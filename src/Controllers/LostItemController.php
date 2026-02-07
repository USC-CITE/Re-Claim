<?php
/**
 * Layer: Controller
 * Purpose: Handle lost item related requests
 * Rules: No DB logic or HTML rendering logic here
 */

namespace App\Controllers;

use App\Core\Router;
use App\Models\LostItemModel;
use PDOException;
use Exception;

class LostItemController
{
    public static function index()
    {
        $config = require __DIR__ . '/../Config/config.php';
        $model = new LostItemModel($config);

        $rawItems = $model->getAll();

        $lostItems = array_map(function ($item) {
            $categories = [];
            if (!empty($item['category'])) {
                $decoded = json_decode($item['category'], true);
                $categories = is_array($decoded) ? $decoded : [$item['category']];
            }

            $imageUrl = !empty($item['image_path']) ? '/' . ltrim($item['image_path'], '/') : null;

            return [
                'id' => $item['id'],
                'image_url' => $imageUrl,
                'date_lost' => $item['date_lost'] ?? null,
                'location' => $item['location_name'] ?? '',
                'description' => $item['description'] ?: 'No description provided.',
                'categories' => $categories,
                'contact_info' => $item['contact_details'] ?? '',
                'name' => trim(($item['first_name'] ?? '') . ' ' . ($item['last_name'] ?? '')),
            ];
        }, $rawItems);

        $flash = $_SESSION['flash'] ?? null;
        if ($flash) unset($_SESSION['flash']);

        require __DIR__ . '/../Views/lost/index.php';
    }

    public static function showPostForm()
    {
        /**
         * NOTE:
         * Session is started globally in router.php (dispatch)
         * AuthController stores user session fields like: user_id, user_email, first_name, last_name, etc.
         */
        $user = [
            'id' => $_SESSION['user_id'] ?? null,
            'email' => $_SESSION['user_email'] ?? null,
            'first_name' => $_SESSION['first_name'] ?? null,
            'last_name' => $_SESSION['last_name'] ?? null,
            'phone_number' => $_SESSION['phone_number'] ?? null,
        ];

        // Retrieve old input + flash (PRG)
        $old = $_SESSION['old'] ?? [];
        if (isset($_SESSION['old'])) {
            unset($_SESSION['old']);
        }

        $flash = $_SESSION['flash'] ?? null;
        if ($flash) {
            unset($_SESSION['flash']);
        }

        require __DIR__ . '/../Views/lost/post.php';
    }

    public static function submitPostForm()
    {
        // CSRF validation
        if (!Router::isCsrfValid()) {
            http_response_code(403);
            die("Security Error: Invalid CSRF Token. Please refresh the page and try again.");
        }

        $config = require __DIR__ . '/../Config/config.php';

        // Prepare old input for PRG
        $oldInput = [
            'first_name'       => $_POST['first_name'] ?? '',
            'last_name'        => $_POST['last_name'] ?? '',
            'contact_details'  => $_POST['contact_details'] ?? '',
            'location'         => $_POST['location'] ?? '',
            'room_number'      => $_POST['room_number'] ?? '',
            'date_lost'        => $_POST['date_lost'] ?? '',
            'category'         => $_POST['category'] ?? [],
            'description'      => $_POST['description'] ?? '',
        ];

        $movedUploadedFile = false;
        $movedFileFullPath = null;

        try {
            // 1) Fetch text fields
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName  = trim($_POST['last_name'] ?? '');
            $contact   = trim($_POST['contact_details'] ?? '');

            // 2) Parse Location (format: "Name|lat,long")
            $locationRaw  = $_POST['location'] ?? '';
            $locationName = '';
            $latitude     = null;
            $longitude    = null;

            if ($locationRaw) {
                $parts = explode('|', $locationRaw);
                if (count($parts) === 2) {
                    $locationName = $parts[0];
                    $coords = explode(',', $parts[1]);
                    if (count($coords) === 2) {
                        $latitude = $coords[0];
                        $longitude = $coords[1];
                    }
                } else {
                    $locationName = $locationRaw; // fallback
                }
            }

            // Append Room Number if provided (optional)
            if (!empty($_POST['room_number'])) {
                $locationName .= ' (Room ' . trim($_POST['room_number']) . ')';
            }

            // 3) Date lost / last seen (required)
            $dateLost = $_POST['date_lost'] ?? '';
            $dt = \DateTime::createFromFormat('Y-m-d', $dateLost);
            if (!$dt || $dt->format('Y-m-d') !== $dateLost) {
                throw new Exception('Please provide a valid date.');
            }

            // Normalize to midnight and disallow future dates
            $dt->setTime(0, 0, 0);
            $today = new \DateTime('today');
            if ($dt > $today) {
                throw new Exception('Date lost cannot be in the future.');
            }

            // 4) Category tags (at least one required)
            $categories = $_POST['category'] ?? [];
            if (!is_array($categories)) {
                $categories = [$categories];
            }
            $categories = array_values(array_filter(array_map('trim', $categories)));
            if (count($categories) === 0) {
                throw new Exception('Please select at least one category.');
            }
            $categoryJson = json_encode($categories);

            // 5) Description (optional)
            $description = trim($_POST['description'] ?? '');
            if ($description === '') {
                $description = null;
            }

            // 6) Image upload
            // SIZE LIMIT handled in php.ini (post_max_size / upload_max_filesize)
            if (empty($_FILES) && !empty($_SERVER['CONTENT_LENGTH'])) {
                $maxPost = ini_get('post_max_size');
                throw new Exception("Uploaded file is too large. Maximum allowed size is {$maxPost}.");
            }

            if (!isset($_FILES['item_image'])) {
                throw new Exception('Please upload an image.');
            }

            if ($_FILES['item_image']['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($_FILES['item_image']['tmp_name'])) {
                throw new Exception('Image upload error. Please try again.');
            }

            $allowedTypes = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/webp' => 'webp',
                'image/avif' => 'avif',
            ];

            $tmpPath  = $_FILES['item_image']['tmp_name'];
            $mimeType = mime_content_type($tmpPath);

            if (!isset($allowedTypes[$mimeType])) {
                throw new Exception('Invalid image format. Allowed: JPG, PNG, WEBP, AVIF.');
            }

            // Unique rename
            $extension = $allowedTypes[$mimeType];
            $timestamp = date('Ymd_His');
            $uniqueId  = strtoupper(substr(uniqid(), -6));
            $fileName  = "lost_{$timestamp}_LST{$uniqueId}.{$extension}";

            // Ensure directory exists
            $uploadDir = __DIR__ . '/../../public/uploads/lost_items/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $destination = $uploadDir . $fileName;

            if (!move_uploaded_file($tmpPath, $destination)) {
                throw new Exception('Failed to save uploaded image.');
            }

            $movedUploadedFile = true;
            $movedFileFullPath = $destination;

            $imagePath = 'uploads/lost_items/' . $fileName;

            // 7) user_id association (from AuthController session)
            $userId = $_SESSION['user_id'] ?? null;

            // 8) Save to DB
            $model = new LostItemModel($config);
            $ok = $model->create([
                'image_path'       => $imagePath,
                'location_name'    => $locationName,
                'latitude'         => $latitude,
                'longitude'        => $longitude,
                'date_lost'        => $dateLost,
                'category'         => $categoryJson,
                'description'      => $description,
                'first_name'       => $firstName,
                'last_name'        => $lastName,
                'contact_details'  => $contact,
                'user_id'          => $userId,
            ]);

            if (!$ok) {
                throw new Exception('Failed to post lost item.');
            }

            // Success flash + redirect (PRG)
            $_SESSION['flash'] = ['success' => 'Lost item posted successfully.'];
            header('Location: /lost/post');
            exit;

        } catch (PDOException $e) {
            // Cleanup uploaded file if moved
            if (!empty($movedUploadedFile) && !empty($movedFileFullPath) && file_exists($movedFileFullPath)) {
                @unlink($movedFileFullPath);
            }

            error_log("Database Error: " . $e->getMessage());
            $_SESSION['flash'] = ['error' => 'Database error occurred.'];
            $_SESSION['old'] = $oldInput;

            header('Location: /lost/post');
            exit;

        } catch (Exception $e) {
            // Cleanup uploaded file if moved
            if (!empty($movedUploadedFile) && !empty($movedFileFullPath) && file_exists($movedFileFullPath)) {
                @unlink($movedFileFullPath);
            }

            $_SESSION['flash'] = ['error' => $e->getMessage()];
            $_SESSION['old'] = $oldInput;

            header('Location: /lost/post');
            exit;
        }
    }
}