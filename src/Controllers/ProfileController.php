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

    public static function uploadAvatar(){
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        if(!isset($_FILES['avatar'])){
            $_SESSION['flash_error'] = "No file uploaded!";
            header("Location: /profile/edit");
            exit;
        }

        $file = $_FILES['avatar'];

        $allowedTypes = ['image/jpg', 'image/png', 'image/webp'];

        // Handle invalid uploaded file type
        if(!in_array($file['type'], $allowedTypes)){
            $_SESSION['flash_error'] = "Invalid file type. Only JPEG, PNG, and WEBP are allowed!";
            header("Location: /profile/edit");
            exit;
        }

        if($file['size'] > 2 * 1024 * 1024){
            $_SESSION['flash_error'] = "File too large. Max 2MB";
            header("Location: /profile/edit");
            exit;
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        // Generate a unique name for uploaded avatar
        $filename = uniqid('avatar_', true) . '.' . $ext;
        

        $uploadedPath = __DIR__ . '/../../public/avatars/'. $filename;

        if(!move_uploaded_file($file['tmp_name'], $uploadedPath)){
            $_SESSION['flash_error'] = "Upload failed. Please try again.";
            header("Location: /profile/edit");
            exit;
        }

        // Store the avatar path to be inserted to user
        $dbPath = '/avatars/' . $filename;

        // DB connection 
        $config = require __DIR__ . "/../Config/config.php";
        $userModel = new UserModel($config);
        $userId = $_SESSION['user_id'];

        // Delete old avatar if exists
        $oldAvatar = $_SESSION['avatar'] ?? null;
        if ($oldAvatar) {
            $oldPath = __DIR__ . '/../../public/avatars/' . ltrim($oldAvatar, '/');
            if (is_file($oldPath)) {
                @unlink($oldPath);
            }
        }

        // Update DB (create method in UserModel instead ideally)
        $userModel->updateAvatar($userId, $dbPath);

        // Store avatar path to session for UI
        $_SESSION['avatar'] = $dbPath;
        $_SESSION['flash_success'] = "Profile picture updated successfully!";

        header("Location: /profile/edit");
        exit;
    }

    public static function deleteAvatar(){
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user_id'];

        $config = require __DIR__ . '/../Config/config.php';
        $user = new UserModel($config);

        // Fetch current user avatar path
        $currentAvatar = $user->getAvatar($userId);

        // Only delete if there is image uploaded
        if($currentAvatar && $currentAvatar !== '/avatars/default.png'){
            $fullPath = __DIR__ . "/../../public" . $currentAvatar;
            if(is_file($fullPath)){
                @unlink($fullPath);
            }
        }

        $user->deleteAvatar($userId);

        // Update session
        $_SESSION['avatar'] = '/avatars/default.png';
        $_SESSION['flash_success'] = "Avatar deleted successfully.";

        header("Location: /profile/edit");
        exit;
    }


}
