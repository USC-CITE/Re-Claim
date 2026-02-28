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
use DateTime;
use DateTimeZone;

class LostItemController
{
    public static function index()
    {   
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

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

            try {
                $archiveAt = new DateTime($item['archive_date'], new DateTimeZone('Asia/Manila'));
                $archiveDisplay = $archiveAt->format('F j, Y g:i A');
            } catch (Exception $e) {
                $archiveDisplay = $item['archive_date'] ?? null;
            }

            return [
                'id' => $item['id'],
                'item_name' => $item['item_name'] ?? 'Unnamed Item',
                'image_url' => $imageUrl,
                'event_date' => $item['event_date'] ?? null,
                'location' => $item['location_name'] ?? 'Unknown Location',
                'room_number' => $item['room_number'] ?? null,
                'description' => $item['description'] ?: 'No description provided.',
                'categories' => $categories,
                'status' => $item['status'] ?? 'Unrecovered',
                'archive_date' => $archiveDisplay,
                'contact_info' => $item['contact_details'] ?? '',
                'name' => trim(($item['first_name'] ?? '') . ' ' . ($item['last_name'] ?? '')),
                'can_recover' => isset($_SESSION['user_id'], $item['user_id'])
                    && (int)$item['user_id'] === (int)$_SESSION['user_id']
                    && ($item['status'] ?? 'Unrecovered') === 'Unrecovered'
                    && ($item['item_type'] ?? 'lost') === 'lost',
                'can_archive' => isset($_SESSION['user_id'], $item['user_id'])
                    && (int)$item['user_id'] === (int)$_SESSION['user_id']
                    && ($item['item_type'] ?? 'lost') === 'lost'
                    && ($item['status'] ?? 'Unrecovered') !== 'Archived',
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
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        
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
            'item_name'        => $_POST['item_name'] ?? '',
            'first_name'       => $_POST['first_name'] ?? '',
            'last_name'        => $_POST['last_name'] ?? '',
            'contact_details'  => $_POST['contact_details'] ?? '',
            'location'         => $_POST['location'] ?? '',
            'room_number'      => $_POST['room_number'] ?? '',
            'event_date'       => $_POST['event_date'] ?? '',
            'category'         => $_POST['category'] ?? [],
            'description'      => $_POST['description'] ?? '',
        ];

        $movedUploadedFile = false;
        $movedFileFullPath = null;

        try {
            // 1) Item name/title (required)
            $itemName = trim($_POST['item_name'] ?? '');
            if (empty($itemName)) {
                throw new Exception('Please provide an item name/title.');
            }

            // 2) Fetch text fields
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName  = trim($_POST['last_name'] ?? '');
            $contact   = trim($_POST['contact_details'] ?? '');

            // 3) Parse Location (format: "Name|lat,long")
            $locationRaw  = $_POST['location'] ?? '';
            $locationName = '';
            $roomNumber   = null;
            $latitude     = null;
            $longitude    = null;

            if ($locationRaw) {
                $parts = explode('|', $locationRaw);
                if (count($parts) === 2) {
                    $locationName = $parts[0];
                    $coords = explode(',', $parts[1]);
                    if (count($coords) === 2) {
                        $latitude = (float)$coords[0];
                        $longitude = (float)$coords[1];
                    }
                } else {
                    $locationName = $locationRaw; // fallback
                }
            }

            // Extract Room Number if provided (optional, stored separately)
            if (!empty($_POST['room_number'])) {
                $roomNumber = trim($_POST['room_number']);
            }

            // 4) Event date / date lost (required) with timezone awareness
            $timezone = new \DateTimeZone('Asia/Manila');
            $eventDate = $_POST['event_date'] ?? '';
            
            try {
                // Parse datetime-local input with explicit timezone
                $dt = \DateTime::createFromFormat('Y-m-d\TH:i', $eventDate, $timezone);
                if (!$dt) {
                    throw new Exception('Please provide a valid date and time.');
                }
                
                // Validate format matches input
                if ($dt->format('Y-m-d\TH:i') !== $eventDate) {
                    throw new Exception('Please provide a valid date and time.');
                }
                
                // Disallow future dates/times (timezone-aware comparison)
                $now = new \DateTime('now', $timezone);
                if ($dt > $now) {
                    throw new Exception('Date and time lost cannot be in the future.');
                }

                // Convert HTML datetime-local value to MySQL DATETIME format
                $eventDate = $dt->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                if (strpos($e->getMessage(), 'Date and time') === 0 || strpos($e->getMessage(), 'valid') !== false) {
                    throw $e;
                }
                throw new Exception('Please provide a valid date and time.');
            }

            // 5) Category tags (at least one required)
            $categories = $_POST['category'] ?? [];
            if (!is_array($categories)) {
                $categories = [$categories];
            }
            $categories = array_values(array_filter(array_map('trim', $categories)));
            if (count($categories) === 0) {
                throw new Exception('Please select at least one category.');
            }
            $categoryJson = json_encode($categories);

            // 6) Description (optional)
            $description = trim($_POST['description'] ?? '');
            if ($description === '') {
                $description = null;
            }

            // 7) Image upload
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

            // 8) user_id association (from AuthController session)
            $userId = $_SESSION['user']['id'] ?? $_SESSION['user_id'] ?? null;

            // 9) Save to unified DB table
            $model = new LostItemModel($config);
            $ok = $model->create([
                'item_name'        => $itemName,
                'image_path'       => $imagePath,
                'location_name'    => $locationName,
                'room_number'      => $roomNumber,
                'latitude'         => $latitude,
                'longitude'        => $longitude,
                'event_date'       => $eventDate,
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

            // Success flash + redirect to listing page after posting
            $_SESSION['flash'] = ['success' => 'Lost item posted successfully.'];
            header('Location: /lost');
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

    public static function recover()
    {
        if (!Router::isCsrfValid()) {
            http_response_code(403);
            die("Security Error: Invalid CSRF Token. Please refresh the page and try again.");
        }

        if (empty($_SESSION['user_id'])) {
            $_SESSION['flash'] = ['error' => 'You must be logged in to recover an item you posted.'];
            header('Location: /lost');
            exit;
        }

        $itemId = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;
        if ($itemId <= 0) {
            $_SESSION['flash'] = ['error' => 'Invalid item selected for recovery.'];
            header('Location: /lost');
            exit;
        }

        $config = require __DIR__ . '/../Config/config.php';
        $model = new LostItemModel($config);

        $success = $model->markAsRecovered($itemId, (int)$_SESSION['user_id']);

        if ($success) {
            $_SESSION['flash'] = ['success' => 'Item marked as recovered.'];
        } else {
            $_SESSION['flash'] = ['error' => 'Unable to mark this item as recovered. You can only recover lost items that you posted and are still unrecovered.'];
        }

        header('Location: /lost');
        exit;
    }

    public static function archive()
    {
        if (!Router::isCsrfValid()) {
            http_response_code(403);
            die("Security Error: Invalid CSRF Token.");
        }

        $userId = $_SESSION['user_id'] ?? null;
        $itemIds = $_POST['item_ids'] ?? [];

        if (!$userId || empty($itemIds)) {
            $_SESSION['flash'] = ['error' => 'Archive request is invalid.'];
            header('Location: /lost');
            exit;
        }

        if (!is_array($itemIds)) {
            $itemIds = [$itemIds];
        }

        $config = require __DIR__ . '/../Config/config.php';
        $model = new LostItemModel($config);

        if ($model->archiveByIds($itemIds, (int)$userId)) {
            $_SESSION['flash'] = ['success' => 'Selected lost post(s) archived.'];
        } else {
            $_SESSION['flash'] = ['error' => 'Could not archive selected post(s).'];
        }

        header('Location: /lost');
        exit;
    }

    public static function delayArchive()
    {
        if (!Router::isCsrfValid()) {
            http_response_code(403);
            die("Security Error: Invalid CSRF Token.");
        }

        $userId = $_SESSION['user_id'] ?? null;
        $itemId = (int)($_POST['item_id'] ?? 0);
        $days = max(1, (int)($_POST['delay_days'] ?? 7));

        if (!$userId || $itemId <= 0) {
            $_SESSION['flash'] = ['error' => 'Delay request is invalid.'];
            header('Location: /lost');
            exit;
        }

        $config = require __DIR__ . '/../Config/config.php';
        $model = new LostItemModel($config);

        if ($model->postponeArchive($itemId, (int)$userId, $days)) {
            $_SESSION['flash'] = ['success' => "Archive date moved by {$days} day(s)."];
        } else {
            $_SESSION['flash'] = ['error' => 'Could not update archive schedule.'];
        }

        header('Location: /lost');
        exit;
    }

}