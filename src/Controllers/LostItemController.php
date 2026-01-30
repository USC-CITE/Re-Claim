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
        require __DIR__ . '/../Views/lost/post.php';
    }

    public static function submitPostForm()
    {
        $config = require __DIR__ . '/../Config/config.php';

        try {
            // required fields
            $locationRaw = $_POST['location'] ?? '';
            $category = trim($_POST['category'] ?? '');
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $contact = trim($_POST['contact_details'] ?? '');

            // optional
            $description = trim($_POST['description'] ?? '');
            if ($description === '') {
                $description = null;
            }

            // parse location: "Name|lat,long"
            $locationName = '';
            $latitude = null;
            $longitude = null;

            if ($locationRaw) {
                [$locationName, $coords] = explode('|', $locationRaw);
                [$latitude, $longitude] = explode(',', $coords);
            }

            // TEMP placeholder for image_path (upload handling later)
            $imagePath = 'TEMP_UPLOAD_PENDING';

            // user_id is optional for now (auto-fill later)
            $userId = null;

            $model = new LostItemModel($config);

            $ok = $model->create([
                'image_path' => $imagePath,
                'location_name' => $locationName,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'category' => $category,
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
