<?php
/**
 * Layer: Controller
 * Purpose: Handle lost item related requests
 * Rules: No DB logic or HTML rendering logic here
 */

namespace App\Controllers;

use App\Models\LostItemModel;
use PDOException;
use Exception;

class LostItemController
{
    public static function showPostForm()
    {
        $user = $_SESSION['user'] ?? null;
        require __DIR__ . '/../Views/lost/post.php';
    }

    public static function submitPostForm()
    {
        $config = require __DIR__ . '/../Config/config.php';

        try {
            // fetch form fields
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $contact = trim($_POST['contact_details'] ?? '');
            
            // Location
            $locationRaw = $_POST['location'] ?? '';
            // parse location: "Name|lat,long"
            $locationName = '';
            $latitude = null;
            $longitude = null;

            if ($locationRaw) {
                [$locationName, $coords] = explode('|', $locationRaw);
                [$latitude, $longitude] = explode(',', $coords);
            }

            // Date lost / last seen (required)
            $dateLost = $_POST['date_lost'] ?? '';
            $dt = \DateTime::createFromFormat('Y-m-d', $dateLost);
            if (!$dt || $dt->format('Y-m-d') !== $dateLost) {
                throw new Exception('Please provide a valid date.');
            }

            // Disallow selection of future dates
            $today = new \DateTime('today');
            if ($dt > $today) {
                throw new Exception('Date lost cannot be in the future.');
            }

            // Category tags
            $categories = $_POST['category'] ?? [];
            if (!is_array($categories)) {
                $categories = [$categories];
            }
            $categories = array_values(array_filter(array_map('trim', $categories)));
            if (count($categories) === 0) {
                throw new Exception('Please select at least one category.');
            }
            $categoryJson = json_encode($categories);

            // Description (optional)
            $description = trim($_POST['description'] ?? '');
            if ($description === '') {
                $description = null;
            }

            // ---- Image upload handling ----
            // SIZE LIMIT handled in php.ini (post_max_size = 8M)
            if (empty($_FILES) && !empty($_SERVER['CONTENT_LENGTH'])) {
                $maxPost = ini_get('post_max_size');
                throw new Exception("Uploaded file is too large. Maximum allowed size is {$maxPost}.");
            }

            if (!isset($_FILES['item_image'])) {
                throw new Exception('Please upload an image.');
            }

            if ($_FILES['item_image']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('Image upload error. Please try again.');
            }

            $allowedTypes = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/webp' => 'webp',
                'image/avif' => 'avif',
            ];

            $tmpPath = $_FILES['item_image']['tmp_name'];
            $mimeType = mime_content_type($tmpPath);

            if (!isset($allowedTypes[$mimeType])) {
                throw new Exception('Invalid image format. Allowed: JPG, PNG, WEBP, AVIF.');
            }

            $extension = $allowedTypes[$mimeType];

            // Generate safe unique filename
            $timestamp = date('Ymd_His');
            $uniqueId = strtoupper(substr(uniqid(), -6));
            $fileName = "lost{$timestamp}_LST{$uniqueId}.{$extension}";

            // Destination path
            $uploadDir = __DIR__ . '/../../public/uploads/lost_items/';
            $destination = $uploadDir . $fileName;

            if (!move_uploaded_file($tmpPath, $destination)) {
                throw new Exception('Failed to save uploaded image.');
            }

            // Path saved to DB (relative to public)
            $imagePath = 'uploads/lost_items/' . $fileName;
            // ---- End image upload handling ----

            // user_id is optional for now (auto-fill later)
            $userId = null;

            $model = new LostItemModel($config);

            $ok = $model->create([
                'image_path' => $imagePath,
                'location_name' => $locationName,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'date_lost' => $dateLost,
                'category' => $categoryJson,
                'description' => $description,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'contact_details' => $contact,
                'user_id' => $userId,
            ]);

            if ($ok) {
                echo "Lost item posted (text fields saved).";
                return;
            }

            echo "Failed to post lost item.";

        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            echo "Database error occurred.";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
