<?php
namespace App\Controllers;

use App\Models\FoundItemModel;
use App\Core\Router;
use PDOException;
use Exception;
use DateTime;
use DateTimeZone;

class FoundItemController
{
    public static function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $config = require __DIR__ . '/../Config/config.php';
        $model = new FoundItemModel($config);
        $rawItems = $model->getAll();
        
        $foundItems = array_map(function($item) {
            $categories = [];
            if (!empty($item['category'])) {
                $decoded = json_decode($item['category'], true);
                $categories = is_array($decoded) ? $decoded : [$item['category']];
            }

            // 1. Format Date
            try {
                $dt = new DateTime($item['event_date'], new DateTimeZone('Asia/Manila'));
                $dateDisplay = $dt->format('F j, Y g:i A');
            } catch (Exception $e) {
                $dateDisplay = $item['event_date'] ?? null;
            }

            try {
                $archiveDt = new DateTime($item['archive_date'], new DateTimeZone('Asia/Manila'));
                $archiveDateDisplay = $archiveDt->format('F j, Y g:i A');
            } catch (Exception $e) {
                $archiveDateDisplay = $item['archive_date'] ?? null;
            }

           // 2. Return Clean Data Structure 
            return [
                'id' => $item['id'] ?? uniqid(), // ID for the modal
                'title' => $item['item_name'] ?: "Found Item",
                'status' => $item['status'],
                'status_tag' => ($item['status'] ?? 'Unrecovered') === 'Recovered' ? 'Recovered' : 'Found',
                'image_url' => !empty($item['image_path']) ? '/' . $item['image_path'] : null,
                'date_found' => $dateDisplay,
                'archive_date' => $archiveDateDisplay,
                'location' => $item['location_name'],
                'description' => $item['description'] ?: 'No description provided.',
                'categories' => $categories,
                'contact_info' => (function($raw) {
                    $d = json_decode($raw, true);
                    return is_array($d) ? ($d['phone'] ?? $raw) : $raw;
                })($item['contact_details'] ?? ''),
                'contact_social_links' => (function($raw) {
                    $d = json_decode($raw, true);
                    $links = is_array($d) ? ($d['social_links'] ?? []) : [];
                    return array_map(fn($link) => [
                        'url' => $link,
                        'platform' => self::detectPlatform($link),
                    ], $links);
                })($item['contact_details'] ?? ''),
                'item_type' => $item['item_type'] ?? 'found',
                'name' => trim(($item['first_name'] ?? '') . ' ' . ($item['last_name'] ?? '')),
                'can_recover' => isset($_SESSION['user_id'], $item['user_id'])
                    && (int)$item['user_id'] === (int)$_SESSION['user_id']
                    && ($item['status'] ?? 'Unrecovered') === 'Unrecovered'
                    && ($item['item_type'] ?? 'found') === 'found',
                'can_archive' => isset($_SESSION['user_id'], $item['user_id'])
                    && (int)$item['user_id'] === (int)$_SESSION['user_id']
                    && ($item['item_type'] ?? 'found') === 'found'
                    && ($item['status'] ?? '') !== 'Archived',
            ];
        }, $rawItems);

        // Read and clear flash for display
        $flash = $_SESSION['flash'] ?? null;
        if ($flash) {
            unset($_SESSION['flash']);
        }

        require __DIR__ . '/../Views/found/index.php';
    }

    public static function showPostForm()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        
        // Auto-fill fields if user is logged in.
    $user = [
            'id' => $_SESSION['user_id'] ?? null,
            'first_name' => $_SESSION['first_name'] ?? null,
            'last_name' => $_SESSION['last_name'] ?? null,
            'phone_number' => $_SESSION['phone_number'] ?? null, //or should this be email?
        ];

        // Retrieve old input and flash 
        $old = $_SESSION['old'] ?? [];
        if (isset($_SESSION['old'])) {
            unset($_SESSION['old']);
        }

        $flash = $_SESSION['flash'] ?? null;
        if ($flash) {
            unset($_SESSION['flash']);
        }

         // Merge GET params for cross-form carry-over (session $old takes priority)
        if (!empty($_GET)) {
            $old = array_merge($_GET, $old);
        }

        // Pass $old and $flash to the view (views can access these variables)
        require __DIR__ . '/../Views/found/post.php';
    }

    public static function submitPostForm()
    {
        // Check for oversized uploads before CSRF validation
        if (empty($_POST) && !empty($_SERVER['CONTENT_LENGTH'])) {
            $maxPost = ini_get('post_max_size');
            $_SESSION['flash'] = [
                'error' => "Uploaded file is too large. Maximum allowed size is {$maxPost}."
            ];
            header('Location: /found/post');
            exit;
        }

        if (!Router::isCsrfValid()) {
            http_response_code(403);
            die("Security Error: Invalid CSRF Token. Please refresh the page and try again.");
        }

        $config = require __DIR__ . '/../Config/config.php';

        // Prepare an array of old input for PRG when redirecting back on error.
        $oldInput = [
            'item_name' => $_POST['item_name'] ?? '',
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'contact_details' => $_POST['contact_details'] ?? '',
            'social_links' => $_POST['social_links'] ?? [],
            'location' => $_POST['location'] ?? '',
            'room_number' => $_POST['room_number'] ?? '',
            'date_found' => ($_POST['date_found_date'] ?? '') . ' ' . ($_POST['date_found_time'] ?? ''),
            'category' => $_POST['category'] ?? '',
            'description' => $_POST['description'] ?? '',
        ];

        try {
            // 1. Fetch text fields
            $itemName = trim($_POST['item_name'] ?? '');
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $contact = trim($_POST['contact_details'] ?? '');
            $socialLinks = array_values(array_filter(
                array_map('trim', $_POST['social_links'] ?? []),
                fn($l) => $l !== '' && filter_var($l, FILTER_VALIDATE_URL)
            ));

            $contactData = json_encode([
                'phone' => $contact,
                'social_links' => $socialLinks,
            ]);

            if ($itemName === '') {
                throw new Exception('Please provide an item name/title.');
            }

            //Require contact details
            if ($firstName === '') {
                throw new Exception('Please provide your first name.');
            }

            if ($lastName === '') {
                throw new Exception('Please provide your last name.');
            }

            if ($contact === '') {
                throw new Exception('Please provide contact details.');
            }

            // 2. Parse Location
            $locationRaw = $_POST['location'] ?? '';

            if (empty($locationRaw)) {
                throw new Exception('Please select a location.');
            }
            
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
            $dateFoundDate = $_POST['date_found_date'] ?? '';
            $dateFoundTime = $_POST['date_found_time'] ?? '';

            try {
                // Combine date and time
                if (empty($dateFoundDate) || empty($dateFoundTime)) {
                    throw new Exception('Please provide both date and time.');
                }
                
                $dateTimeString = $dateFoundDate . ' ' . $dateFoundTime;
                $dt = DateTime::createFromFormat('Y-m-d H:i', $dateTimeString, $timezone);
                
                if (!$dt) {
                    throw new Exception('Please provide a valid date and time.');
                }

                // Validation: Prevent future dates
                if ($dt > new DateTime('now', $timezone)) {
                    throw new Exception('Date found cannot be in the future.');
                }

                // Format for MySQL
                $dateFound = $dt->format('Y-m-d H:i:s');

            } catch (Exception $e) {
                throw new Exception('Please provide a valid date and time.');
            }

            // 4. Categories (ONLY ONE category required)
            $category = trim($_POST['category'] ?? '');
            if (empty($category)) {
                throw new Exception('Please select a category.');
            }
            $categoryJson = json_encode($category);

            // 5. Description
            $description = trim($_POST['description'] ?? '');

            // 6. Image Upload
            $imagePath = null;
            $movedUploadedFile = false;
            $movedFileFullPath = null;
            
            // Check if file is uploaded
            if (!isset($_FILES['item_image']) || $_FILES['item_image']['error'] === UPLOAD_ERR_NO_FILE) {
                throw new Exception('Please upload an image of the found item.');
            }

            if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] === UPLOAD_ERR_OK && is_uploaded_file($_FILES['item_image']['tmp_name'])) {
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

                //unique renaming of file
                $extension = $allowedTypes[$mimeType];
                $timestamp = date('Ymd_His');
                $uniqueId = strtoupper(substr(uniqid(), -6));
                $fileName = "found_{$timestamp}_{$uniqueId}.{$extension}";
                
                // Ensure directory exists
                $uploadDir = __DIR__ . '/../../public/uploads/found_items/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $destination = $uploadDir . $fileName;

                if (!move_uploaded_file($tmpPath, $destination)) {
                    throw new Exception('Failed to save uploaded image.');
                }

                $imagePath = 'uploads/found_items/' . $fileName;
                $movedUploadedFile = true;
                $movedFileFullPath = $destination;
            }

            // 7. Save to DB
            $model = new FoundItemModel($config);
            $model->create([
                'image_path' => $imagePath,
                'item_name' => $itemName,
                'location_name' => $locationName,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'date_found' => $dateFound,
                'category' => $categoryJson,
                'description' => $description,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'contact_details' => $contactData,
                'room_number' => $_POST['room_number'] ?? null,
                'item_type' => 'found',
                'user_id' => $_SESSION['user']['id'] ?? $_SESSION['user_id'] ?? null,
            ]);

            // set success flash and redirect to list page
            $_SESSION['flash'] = ['success' => 'Found item posted successfully.'];
            header('Location: /found');
            exit;

        } catch (Exception $e) {
            // On error, clean up any uploaded file we may have moved already
            if (!empty($movedUploadedFile) && !empty($movedFileFullPath) && file_exists($movedFileFullPath)) {
                @unlink($movedFileFullPath);
            }
            $_SESSION['flash'] = ['error' => $e->getMessage()];
            // Note: file inputs cannot be persisted across redirects; user must re-attach the image
            $_SESSION['old'] = $oldInput;
            
            header('Location: /found/post');
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
            header('Location: ' . self::postActionRedirect());
            exit;
        }

        $itemId = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;
        if ($itemId <= 0) {
            $_SESSION['flash'] = ['error' => 'Invalid item selected for recovery.'];
            header('Location: ' . self::postActionRedirect());
            exit;
        }

        $config = require __DIR__ . '/../Config/config.php';
        $model = new FoundItemModel($config);

        $success = $model->markAsRecovered($itemId, (int)$_SESSION['user_id']);

        if ($success) {
            $_SESSION['flash'] = ['success' => 'Item marked as recovered.'];
        } else {
            $_SESSION['flash'] = ['error' => 'Unable to mark this item as recovered. You can only recover found items that you posted and are still unrecovered.'];
        }

        header('Location: ' . self::postActionRedirect());
        exit;
    }

    private static function postActionRedirect(): string
    {
        $redirectTo = trim((string)($_POST['redirect_to'] ?? ''));

        if ($redirectTo !== '' && str_starts_with($redirectTo, '/')) {
            return $redirectTo;
        }

        return '/found';
    }

    public static function archive()
    {
        if (!Router::isCsrfValid()) {
            http_response_code(403);
            die("Security Error: Invalid CSRF Token.");
        }

        $userId = $_SESSION['user_id'] ?? null;
        $itemIds = $_POST['item_ids'] ?? []; // Supports array of IDs for multiple selections

        if (!$userId || empty($itemIds)) {
            $_SESSION['flash'] = ['error' => 'Invalid action or not logged in.'];
            header('Location: ' . self::postActionRedirect());
            exit;
        }

        // Convert single string to array if only one was submitted
        if (!is_array($itemIds)) {
            $itemIds = [$itemIds];
        }

        try {
            $config = require __DIR__ . '/../Config/config.php';
            $model = new FoundItemModel($config);
            
            if ($model->archiveByIds($itemIds, (int)$userId)) {
                $_SESSION['flash'] = ['success' => 'Selected found post(s) archived.'];
            } else {
                $_SESSION['flash'] = ['error' => 'Could not archive selected post(s).'];
            }
        } catch (Exception $e) {

        error_log("Archive Error: " . $e->getMessage());
            $_SESSION['flash'] = ['error' => 'An error occurred while archiving: ' . $e->getMessage()];
        }

        header('Location: ' . self::postActionRedirect());
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
        $days = (int)($_POST['delay_days'] ?? 7);

        if (!$userId || $itemId <= 0) {
            $_SESSION['flash'] = ['error' => 'Invalid action.'];
            header('Location: ' . self::postActionRedirect());
            exit;
        }

        $config = require __DIR__ . '/../Config/config.php';
        $model = new FoundItemModel($config);

        if ($model->postponeArchive($itemId, (int)$userId, $days)) {
            $_SESSION['flash'] = ['success' => "Archive date moved by {$days} day(s)."];
        } else {
            $_SESSION['flash'] = ['error' => 'Could not update archive schedule.'];
        }

        header('Location: ' . self::postActionRedirect());
        exit;
    }

    private static function detectPlatform(string $url): string
    {
        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');
        $host = preg_replace('/^www\./', '', $host);
        $hostParts = explode('.', $host);
        return !empty($hostParts[0]) ? ucfirst($hostParts[0]) : 'Link';
    } 
}    
