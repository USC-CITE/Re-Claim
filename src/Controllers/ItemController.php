<?php
/**
 * Layer: Controller
 * Purpose: Unified controller for handling Lost and Found items
 */

namespace App\Controllers;

use App\Core\Router;
use App\Models\LostItemModel;
use App\Models\FoundItemModel;
use App\Models\UserModel;
use PDOException;
use Exception;
use DateTime;
use DateTimeZone;

class ItemController
{

    // LISTING VIEWS
    public static function listLostItems()
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

            $fullName = trim(($item['first_name'] ?? '') . ' ' . ($item['last_name'] ?? ''));

            return [
                'id'            => $item['id'],
                'item_name'     => $item['item_name'],
                'title'         => $item['item_name'], // For compatibility
                'description'   => $item['description'],
                'location'      => $item['location_name'],
                'event_date'    => $item['event_date'],
                'date_found'    => $item['event_date'], // For compatibility
                'image_url'     => $imageUrl,
                'status'        => $item['status'],
                'status_tag'    => ($item['status'] ?? 'Unrecovered') === 'Recovered' ? 'Recovered' : 'Lost',
                'categories'    => $categories,
                'name'          => $fullName ?: 'Unknown User',
                'contact_info'  => (function($raw) {
                    $d = json_decode((string)$raw, true);
                    return is_array($d) ? ($d['phone'] ?? $raw) : $raw;
                })($item['contact_details'] ?? ''),
                'contact_social_links' => (function($raw) {
                    $d = json_decode($raw, true);
                    $links = is_array($d) ? ($d['social_links'] ?? []) : [];
                    return array_map(fn($link) => [
                        'url' => $link,
                        'platform' => self::detectPlatform($link)
                    ], $links);
                })($item['contact_details'] ?? ''),
                'archive_date'  => $archiveDisplay
            ];
        }, $rawItems);

        $flash = $_SESSION['flash'] ?? null;
        if ($flash) unset($_SESSION['flash']);

        require __DIR__ . '/../Views/lost/index.php';
    }

    public static function listFoundItems()
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

            $fullName = trim(($item['first_name'] ?? '') . ' ' . ($item['last_name'] ?? ''));

            return [
                'id' => $item['id'],
                'item_name' => $item['item_name'],
                'title' => $item['item_name'] ?: "Found Item",
                'status' => $item['status'],
                'status_tag' => ($item['status'] ?? 'Unrecovered') === 'Recovered' ? 'Recovered' : 'Found',
                'image_url' => !empty($item['image_path']) ? '/' . $item['image_path'] : null,
                'date_found' => $dateDisplay,
                'event_date' => $item['event_date'], // For compatibility
                'archive_date' => $archiveDateDisplay,
                'location' => $item['location_name'],
                'description' => $item['description'] ?: 'No description provided.',
                'categories' => $categories,
                'name' => $fullName ?: 'Unknown User',
                'contact_info' => (function($raw) {
                    $d = json_decode($raw, true);
                    return is_array($d) ? ($d['phone'] ?? $raw) : $raw;
                })($item['contact_details'] ?? ''),
                'contact_social_links' => (function($raw) {
                    $d = json_decode($raw, true);
                    $links = is_array($d) ? ($d['social_links'] ?? []) : [];
                    return array_map(fn($link) => [
                        'url' => $link,
                        'platform' => self::detectPlatform($link)
                    ], $links);
                })($item['contact_details'] ?? ''),
                'can_recover' => isset($_SESSION['user_id'], $item['user_id'])
                    && (int)$item['user_id'] === (int)$_SESSION['user_id']
                    && ($item['status'] ?? 'Unrecovered') === 'Unrecovered'
                    && ($item['item_type'] ?? 'found') === 'found',
                'can_archive' => isset($_SESSION['user_id'], $item['user_id'])
                    && (int)$item['user_id'] === (int)$_SESSION['user_id']
                    && ($item['item_type'] ?? 'found') === 'found'
                    && !($item['is_archived'] ?? false),
            ];
        }, $rawItems);

        $flash = $_SESSION['flash'] ?? null;
        if ($flash) {
            unset($_SESSION['flash']);
        }

        require __DIR__ . '/../Views/found/index.php';
    }

    public static function listRecoveredItems()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $config = require __DIR__ . '/../Config/config.php';
        $lostModel = new LostItemModel($config);
        $foundModel = new FoundItemModel($config);

        $recoveredLost = $lostModel->getRecovered();
        $recoveredFound = $foundModel->getRecovered();

        $allRecovered = array_merge($recoveredLost, $recoveredFound);

        // Sort by event_date descending
        usort($allRecovered, function($a, $b) {
            return ($b['event_date'] ?? '') <=> ($a['event_date'] ?? '');
        });

        $items = array_map(function($item) {
            $categories = [];
            if (!empty($item['category'])) {
                $decoded = json_decode($item['category'], true);
                $categories = is_array($decoded) ? $decoded : [$item['category']];
            }

            $imageUrl = !empty($item['image_path']) ? '/' . ltrim($item['image_path'], '/') : null;
            $isLost = ($item['item_type'] ?? 'lost') === 'lost';

            return [
                'id'            => $item['id'],
                'item_name'     => $item['item_name'],
                'title'         => $item['item_name'],
                'description'   => $item['description'],
                'location'      => $item['location_name'],
                'event_date'    => $item['event_date'],
                'date_found'    => $item['event_date'], 
                'image_url'     => $imageUrl,
                'status'        => $item['status'],
                'status_tag'    => 'Recovered',
                'item_type'     => $item['item_type'],
                'categories'    => $categories,
                'name'          => trim(($item['first_name'] ?? '') . ' ' . ($item['last_name'] ?? '')),
                'contact_info'  => (function($raw) {
                    $d = json_decode((string)$raw, true);
                    return is_array($d) ? ($d['phone'] ?? $raw) : $raw;
                })($item['contact_details'] ?? ''),
            ];
        }, $allRecovered);

        $flash = $_SESSION['flash'] ?? null;
        if ($flash) unset($_SESSION['flash']);

        require __DIR__ . '/../Views/recovered/index.php';
    }

    private static function detectPlatform($url)
    {
        $url = strtolower($url);
        if (strpos($url, 'facebook.com') !== false || strpos($url, 'fb.com') !== false) return 'Facebook';
        if (strpos($url, 'instagram.com') !== false) return 'Instagram';
        if (strpos($url, 'x.com') !== false || strpos($url, 'twitter.com') !== false) return 'X (Twitter)';
        if (strpos($url, 'linkedin.com') !== false) return 'LinkedIn';
        if (strpos($url, 'm.me') !== false) return 'Messenger';
        if (strpos($url, 'whatsapp.com') !== false || strpos($url, 'wa.me') !== false) return 'WhatsApp';
        if (strpos($url, 't.me') !== false || strpos($url, 'telegram.org') !== false) return 'Telegram';
        return 'Social Media';
    }


    // POSTING FORM
    public static function showPostForm()
    {   
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        
        $socialLinks = [];
        try {
            $config = require __DIR__ . '/../Config/config.php';
            $userModel = new UserModel($config);
            
            // Fetch from main users table (legacy/primary column)
            $userData = $userModel->findById((string)$_SESSION['user_id']);
            if ($userData && !empty($userData['social_link'])) {
                $socialLinks[] = $userData['social_link'];
            }

            // Fetch from links table (multiple links)
            $dbSocialLinks = $userModel->getSocialLinks($_SESSION['user_id']);
            if (is_array($dbSocialLinks)) {
                @$extraLinks = array_column($dbSocialLinks, 'social_link');
                $socialLinks = array_merge($socialLinks, $extraLinks);
            }

            $socialLinks = array_unique(array_filter($socialLinks));
        } catch (\Throwable $e) {
            // Silently fail
        }

        $user = [
            'id' => $_SESSION['user_id'] ?? null,
            'email' => $_SESSION['user_email'] ?? null,
            'first_name' => $_SESSION['first_name'] ?? null,
            'last_name' => $_SESSION['last_name'] ?? null,
            'phone_number' => $_SESSION['phone_number'] ?? null,
            'social_links' => $socialLinks
        ];

        $old = $_SESSION['old'] ?? [];
        if (isset($_SESSION['old'])) {
            unset($_SESSION['old']);
        }

        $flash = $_SESSION['flash'] ?? null;
        if ($flash) {
            unset($_SESSION['flash']);
        }

        if (!empty($_GET)) {
            $old = array_merge($_GET, $old);
        }

        require __DIR__ . '/../Views/post_item/index.php';
    }

    public static function submitPostForm()
    {
        if (empty($_POST) && !empty($_SERVER['CONTENT_LENGTH'])) {
            $maxPost = ini_get('post_max_size');
            $_SESSION['flash'] = [
                'error' => "Uploaded file is too large. Maximum allowed size is {$maxPost}."
            ];
            header('Location: /post-item');
            exit;
        }

        if (!Router::isCsrfValid()) {
            http_response_code(403);
            die("Security Error: Invalid CSRF Token. Please refresh the page and try again.");
        }

        $config = require __DIR__ . '/../Config/config.php';

        $statusTag = trim($_POST['status'] ?? 'Lost');

        $oldInput = [
            'item_name'        => $_POST['item_name'] ?? '',
            'first_name'       => $_POST['first_name'] ?? '',
            'last_name'        => $_POST['last_name'] ?? '',
            'contact_details'  => $_POST['contact_details'] ?? '',
            'social_links'     => $_POST['social_links'] ?? [],
            'location'         => $_POST['location'] ?? '',
            'room_number'      => $_POST['room_number'] ?? '',
            'event_date'       => $_POST['event_date'] ?? '', 
            'event_time'       => $_POST['event_time'] ?? '', 
            'category'         => $_POST['category'] ?? '',
            'description'      => $_POST['description'] ?? '',
            'status'           => $statusTag,
        ];

        $movedUploadedFile = false;
        $movedFileFullPath = null;

        try {
            $itemName = trim($_POST['item_name'] ?? '');
            if (empty($itemName)) {
                throw new Exception('Please provide an item name/title.');
            }

            $firstName = trim($_POST['first_name'] ?? '');
            $lastName  = trim($_POST['last_name'] ?? '');
            $contact   = trim($_POST['contact_details'] ?? '');
            $socialLinksRaw = $_POST['social_links'] ?? [];
            $socialLinks = [];
            if (is_array($socialLinksRaw)) {
                foreach ($socialLinksRaw as $link) {
                    $link = trim($link);
                    if ($link === '') continue;
                    
                    // Automatically add https:// if no protocol is found
                    if (!preg_match('~^(?:f|ht)tps?://~i', $link)) {
                        $link = 'https://' . $link;
                    }
                    
                    if (filter_var($link, FILTER_VALIDATE_URL)) {
                        $socialLinks[] = $link;
                    }
                }
            }

            if (empty($firstName)) {
                throw new Exception('Please provide your first name.');
            }
            if (empty($lastName)) {
                throw new Exception('Please provide your last name.');
            }
            if (empty($contact)) {
                throw new Exception('Please provide contact details.');
            }
            if (empty($socialLinks) && $statusTag === 'Lost') {
                throw new Exception('Please provide at least one valid social media link.');
            }

            $contactData = json_encode([
                'phone' => $contact,
                'social_links' => $socialLinks,
            ]);

            $locationRaw  = $_POST['location'] ?? '';
            $locationName = '';
            $roomNumber   = null;
            $latitude     = null;
            $longitude    = null;

            if (empty($locationRaw)) {
                throw new Exception('Please select a location.');
            }

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
                    $locationName = $locationRaw;
                }
            }

            if (!empty($_POST['room_number'])) {
                $roomNumber = trim($_POST['room_number']);
            }

            $timezone = new \DateTimeZone('Asia/Manila');
            $eventDate = $_POST['event_date'] ?? '';
            $eventTime = $_POST['event_time'] ?? '';
            
            try {
                if (empty($eventDate) || empty($eventTime)) {
                    throw new Exception('Please provide both date and time.');
                }
                
                $dateTimeString = $eventDate . ' ' . $eventTime;
                $dt = \DateTime::createFromFormat('Y-m-d H:i', $dateTimeString, $timezone);
                
                if (!$dt) {
                    throw new Exception('Please provide a valid date and time.');
                }
                
                $now = new \DateTime('now', $timezone);
                if ($dt > $now) {
                    throw new Exception('Date cannot be in the future.');
                }

                 $eventDateFormatted = $dt->format('Y-m-d H:i:s');

            } catch (\Exception $e) {
                if (strpos($e->getMessage(), 'Date') === 0 || strpos($e->getMessage(), 'valid') !== false) {
                    throw $e;
                }
                throw new Exception('Please provide a valid date and time.');
            }

            $category = trim($_POST['category'] ?? '');
            if (empty($category)) {
                throw new Exception('Please select a category.');
            }
            $categoryJson = json_encode($category);

            $description = trim($_POST['description'] ?? '');
            if ($description === '') {
                $description = null;
            }

            if (!isset($_FILES['item_image']) || $_FILES['item_image']['error'] === UPLOAD_ERR_NO_FILE) {
                if ($statusTag === 'Found') {
                    throw new Exception('Please upload an image of the found item.');
                } else {
                    throw new Exception('Please upload an image.');
                }
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

            $extension = $allowedTypes[$mimeType];
            $timestamp = date('Ymd_His');

            if ($statusTag === 'Found') {
                $uniqueId = strtoupper(substr(uniqid(), -6));
                $fileName = "found_{$timestamp}_FND{$uniqueId}.{$extension}";
                $uploadDir = __DIR__ . '/../../public/uploads/found_items/';
                $imagePath = 'uploads/found_items/' . $fileName;
            } else {
                $uniqueId  = strtoupper(substr(uniqid(), -6));
                $fileName  = "lost_{$timestamp}_LST{$uniqueId}.{$extension}";
                $uploadDir = __DIR__ . '/../../public/uploads/lost_items/';
                $imagePath = 'uploads/lost_items/' . $fileName;
            }

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $destination = $uploadDir . $fileName;

            if (!move_uploaded_file($tmpPath, $destination)) {
                throw new Exception('Failed to save uploaded image.');
            }

            $movedUploadedFile = true;
            $movedFileFullPath = $destination;

            $userId = $_SESSION['user']['id'] ?? $_SESSION['user_id'] ?? null;

            $dbData = [
                'item_name'        => $itemName,
                'image_path'       => $imagePath,
                'location_name'    => $locationName,
                'room_number'      => $roomNumber,
                'latitude'         => $latitude,
                'longitude'        => $longitude,
                'category'         => $categoryJson,
                'description'      => $description,
                'first_name'       => $firstName,
                'last_name'        => $lastName,
                'contact_details'  => $contactData,
                'user_id'          => $userId,
            ];

            if ($statusTag === 'Found') {
                $dbData['date_found'] = $eventDateFormatted;
                $dbData['item_type'] = 'found';
                $model = new FoundItemModel($config);
                $ok = $model->create($dbData);
            } else {
                $dbData['event_date'] = $eventDateFormatted;
                $dbData['item_type'] = 'lost';
                $model = new LostItemModel($config);
                $ok = $model->create($dbData);
            }

            if (!$ok) {
                throw new Exception('Failed to post item.');
            }

            if ($statusTag === 'Found') {
                $_SESSION['flash'] = ['success' => 'Found item posted successfully.'];
                header('Location: /found');
            } else {
                $_SESSION['flash'] = ['success' => 'Lost item posted successfully.'];
                header('Location: /lost');
            }
            exit;

        } catch (PDOException $e) {
            if (!empty($movedUploadedFile) && !empty($movedFileFullPath) && file_exists($movedFileFullPath)) {
                @unlink($movedFileFullPath);
            }
            error_log("Database Error: " . $e->getMessage());
            $_SESSION['flash'] = ['error' => 'Database error occurred.'];
            $_SESSION['old'] = $oldInput;
            header('Location: /post-item');
            exit;
        } catch (Exception $e) {
            if (!empty($movedUploadedFile) && !empty($movedFileFullPath) && file_exists($movedFileFullPath)) {
                @unlink($movedFileFullPath);
            }
            $_SESSION['flash'] = ['error' => $e->getMessage()];
            $_SESSION['old'] = $oldInput;
            header('Location: /post-item');
            exit;
        }
    }


    // ARCHIVE & RECOVER
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
        $userId = (int)$_SESSION['user_id'];
        
        $isLostRoute = strpos($_SERVER['REQUEST_URI'], '/lost') !== false;
        
        $model = $isLostRoute ? new LostItemModel($config) : new FoundItemModel($config);
        $success = $model->markAsRecovered($itemId, $userId);

        if ($success) {
            $_SESSION['flash'] = ['success' => 'Item marked as recovered.'];
        } else {
            $_SESSION['flash'] = ['error' => 'Unable to mark this item as recovered. You can only recover items that you posted and are still unrecovered.'];
        }

        header('Location: ' . self::postActionRedirect());
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
            header('Location: ' . self::postActionRedirect());
            exit;
        }

        if (!is_array($itemIds)) {
            $itemIds = [$itemIds];
        }

        try {
            $config = require __DIR__ . '/../Config/config.php';
            $isLostRoute = strpos($_SERVER['REQUEST_URI'], '/lost') !== false;
            $model = $isLostRoute ? new LostItemModel($config) : new FoundItemModel($config);
            
            if ($model->archiveByIds($itemIds, (int)$userId)) {
                $_SESSION['flash'] = ['success' => 'Selected post(s) archived.'];
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
        $days = max(1, $days);

        if (!$userId || $itemId <= 0) {
            $_SESSION['flash'] = ['error' => 'Delay request is invalid.'];
            header('Location: ' . self::postActionRedirect());
            exit;
        }

        $config = require __DIR__ . '/../Config/config.php';
        $isLostRoute = strpos($_SERVER['REQUEST_URI'], '/lost') !== false;
        $model = $isLostRoute ? new LostItemModel($config) : new FoundItemModel($config);

        if ($model->postponeArchive($itemId, (int)$userId, $days)) {
            $_SESSION['flash'] = ['success' => "Archive date moved by {$days} day(s)."];
        } else {
            $_SESSION['flash'] = ['error' => 'Could not update archive schedule.'];
        }

        header('Location: ' . self::postActionRedirect());
        exit;
    }

    // HELPERS
    private static function postActionRedirect(): string
    {
        $redirectTo = trim((string)($_POST['redirect_to'] ?? ''));

        if ($redirectTo !== '' && str_starts_with($redirectTo, '/')) {
            return $redirectTo;
        }
        
        $isLostRoute = strpos($_SERVER['REQUEST_URI'], '/lost') !== false;
        return $isLostRoute ? '/lost' : '/found';
    }
}
