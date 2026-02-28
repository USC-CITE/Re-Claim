<?php 

namespace App\Controllers;
use App\Core\Router;
use App\Models\UserModel;
use DateTime;
use DateTimeZone;

class ProfileController{
    public static function showProfile(){
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $id = $_SESSION['user_id'];
        
        $config = require __DIR__ . "/../Config/config.php";

        $user = new UserModel($config);
        
        $lostItems = $user->fetchItems($id, "lost");
        $foundItems = $user->fetchItems($id, "found");
        $archivedItems = array_map(function ($item) {
            try {
                $archivedAt = new DateTime($item['archive_date'], new DateTimeZone('Asia/Manila'));
                $archiveDate = $archivedAt->format('F j, Y g:i A');
            } catch (\Exception $e) {
                $archiveDate = $item['archive_date'] ?? 'N/A';
            }

            return [
                'id' => (int)($item['id'] ?? 0),
                'item_name' => $item['item_name'] ?? 'Unnamed Item',
                'description' => $item['description'] ?? 'No description provided.',
                'item_type' => ucfirst($item['item_type'] ?? 'Item'),
                'status' => $item['status'] ?? 'Archived',
                'archive_date' => $archiveDate,
            ];
        }, $user->fetchArchivedItems($id));

        $flash = $_SESSION['flash'] ?? null;
        if ($flash) {
            unset($_SESSION['flash']);
        }

        require __DIR__ . "/../Views/mainpages/profile.php";

    }
    public static function showEditProfile(){
        require __DIR__ . '/../Views/subpages/edit_profile.php';
    }

    public static function deleteArchivedItems(): void
    {
        if (!Router::isCsrfValid()) {
            http_response_code(403);
            die("Security Error: Invalid CSRF Token.");
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $itemIds = $_POST['item_ids'] ?? [];
        if (!is_array($itemIds)) {
            $itemIds = [$itemIds];
        }

        $itemIds = array_values(array_unique(array_filter(array_map('intval', $itemIds))));

        if (empty($itemIds)) {
            $_SESSION['flash'] = ['error' => 'Select at least one archived item to delete.'];
            header('Location: /profile');
            exit;
        }

        $config = require __DIR__ . "/../Config/config.php";
        $user = new UserModel($config);
        $userId = (int)$_SESSION['user_id'];

        $archivedItems = $user->fetchOwnedArchivedItemsByIds($userId, $itemIds);
        if (empty($archivedItems)) {
            $_SESSION['flash'] = ['error' => 'Only your archived items can be deleted.'];
            header('Location: /profile');
            exit;
        }

        $deletedCount = $user->deleteArchivedItems($userId, array_column($archivedItems, 'id'));

        if ($deletedCount <= 0) {
            $_SESSION['flash'] = ['error' => 'Archived items could not be deleted.'];
            header('Location: /profile');
            exit;
        }

        foreach ($archivedItems as $item) {
            $imagePath = $item['image_path'] ?? '';
            if (!$imagePath) {
                continue;
            }

            $fullPath = __DIR__ . '/../../public/' . ltrim($imagePath, '/');
            if (is_file($fullPath)) {
                @unlink($fullPath);
            }
        }

        $message = $deletedCount === 1
            ? 'Archived item deleted permanently.'
            : "{$deletedCount} archived items deleted permanently.";

        $_SESSION['flash'] = ['success' => $message];
        header('Location: /profile');
        exit;
    }
}
