<?php
namespace App\Controllers;

use App\Models\FoundItemModel;
use PDOException;
use Exception;
use DateTime;
use DateTimeZone;

class FoundItemController
{


    public static function showPostForm()
    {
        // Auto-fill fields if user is logged in
        $user = $_SESSION['user'] ?? null;
        require __DIR__ . '/../Views/found/post.php';
    }

    public static function submitPostForm()
    {
        $config = require __DIR__ . '/../Config/config.php';

        try {
            // 1. Fetch text fields
            $itemName = trim($_POST['item_name'] ?? '');
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $contact = trim($_POST['contact_details'] ?? '');

            if ($itemName === '') {
                throw new Exception('Please provide an item name/title.');
            }

            // 2. Parse Location
            $locationRaw = $_POST['location'] ?? '';
            $locationName = '';
            $latitude = null;
            $longitude = null;

            if ($locationRaw) {
                // Format: "Name|lat,long"
                $parts = explode('|', $locationRaw);
                if (count($parts) === 2) {
                    $locationName = $parts[0];
                    $coords = explode(',', $parts[1]);
                    if (count($coords) === 2) {
                        $latitude = $coords[0];
                        $longitude = $coords[1];
                    }
                } else {
                    $locationName = $locationRaw; // Fallback if no coords
                }
            }
            
            // Append Room Number if provided
            if (!empty($_POST['room_number'])) {
                $locationName .= ' (Room ' . trim($_POST['room_number']) . ')';
            }

            // 3. Date Found (Timezone Fix Applied)
            $timezone = new DateTimeZone('Asia/Manila');
            $dateInput = $_POST['date_found'] ?? null;

            try {
                // If input is empty, use 'now'.
                $dt = new DateTime($dateInput ?: 'now', $timezone);

                // Validation: Prevent future dates
                if ($dt > new DateTime('now', $timezone)) {
                    throw new Exception('Date found cannot be in the future.');
                }

                // Format for MySQL
                $dateFound = $dt->format('Y-m-d H:i:s');

            } catch (Exception $e) {
                throw new Exception('Please provide a valid date and time.');
            }

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}