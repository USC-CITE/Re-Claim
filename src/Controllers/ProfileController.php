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
    public static function showProfileSettings(){
        require __DIR__ . '/../Views/subpages/profile-settings.php';
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
    // Unified function that handles ( Avatar DELETION, Avatar UPLOAD, and UPDATE text user's text fields)
    public static function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user_id'];

        $config = require __DIR__ . '/../Config/config.php';
        $user = new UserModel($config);

        // =========================
        // 1. HANDLE AVATAR DELETE
        // =========================
        $deleteAvatar = isset($_POST['delete_avatar']);

        $currentAvatar = $user->getAvatar($userId);

        if ($deleteAvatar && $currentAvatar && $currentAvatar !== '/avatars/default.png') {
            $fullPath = __DIR__ . "/../../public" . $currentAvatar;

            if (is_file($fullPath)) {
                @unlink($fullPath);
            }

            $currentAvatar = '/avatars/default.png';
        }

        // =========================
        // 2. HANDLE AVATAR UPLOAD
        // =========================
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {

            $file = $_FILES['avatar'];

            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

            if (in_array($file['type'], $allowedTypes) && $file['size'] <= 2 * 1024 * 1024) {

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid('avatar_', true) . '.' . $ext;

                $uploadPath = __DIR__ . '/../../public/avatars/' . $filename;

                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {

                    // delete old avatar
                    if ($currentAvatar && $currentAvatar !== '/avatars/default.png') {
                        $oldPath = __DIR__ . "/../../public" . $currentAvatar;
                        if (is_file($oldPath)) {
                            @unlink($oldPath);
                        }
                    }

                    $currentAvatar = '/avatars/' . $filename;
                }
            }
        }

        // =========================
        // 3. HANDLE TEXT FIELDS
        // =========================
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $phone = $_POST['phone_number'] ?? '';
        $social = $_POST['social_link'] ?? '';

        // Retrieve social links
        $socialLinks = $_POST['social_links'] ?? [];

        // Ensure it an array
        if(!is_array($socialLinks)){
            $socialLinks = [];
        }

        // Clean, validate, and limit to 3 fields
        $socialLinks = array_filter(array_map(function ($link){
            $link = trim($link);
            return filter_var($link, FILTER_VALIDATE_URL) ? $link : null; 
        }, $socialLinks));

        // No duplication
        $socialLinks = array_unique($socialLinks);

        // Enfore 3 max
        $socialLinks = array_slice($socialLinks, 0, 3);

        $user->deleteSocialLinks($userId);

        foreach($socialLinks as $link){
            $user->addSocialLinks($userId, $link);
        }


        // =========================
        // 4. UPDATE DATABASE
        // =========================
        $user->updateFullProfile($userId, [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone_number' => $phone,
            'social_link' => $social,
            'avatar_path' => $currentAvatar
        ]);

        // =========================
        // 5. UPDATE SESSION
        // =========================
        $_SESSION['first_name'] = $firstName;
        $_SESSION['last_name'] = $lastName;
        $_SESSION['phone_number'] = $phone;
        $_SESSION['social_link'] = $social;
        $_SESSION['social_links'] = $socialLinks;
        $_SESSION['avatar'] = $currentAvatar ?? '/avatars/default.png';

        $_SESSION['flash'] = ['success' => 'Profile updated successfully'];

        header("Location: /profile/settings");
        exit;
    }
    
    public static function changePassword(){
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $config = require __DIR__ . '/../Config/config.php';
        $user = new UserModel($config);
        // Get Values
        $currentPassword = $_POST['current_password'] ?? "";
        $newPassword = $_POST['new_password'] ?? "";
        $confirmPassword = $_POST['confirm_password'] ?? "";
        
        // Verify Current Password
        $userData = $user->findById($userId);

        // This would store all error messages
        $errors = [];
        
        // Validate values
        if(!$currentPassword){
            $errors['current_password'] = ['error' => 'This field is required'];
        }

        if(!$newPassword){
            $errors['new_password'] = ['error' => 'This field is required'];
        }

        if(!$confirmPassword){
            $errors['confirm_password'] = ['error' => 'This field is required'];
        }
        
        // If new password exist but less than 6 characters
        if($newPassword && strlen($newPassword) < 6){
            $errors['new_password'] = ['error' => 'Password must be at least 6 characters'];
        }
        if($newPassword !== $confirmPassword){
            $errors['confirm_password'] = ['error' => 'Password do not match!'];
        }

        // If new password value is same as current password
        if(password_verify($newPassword, $userData['password'])){
            $errors['new_password'] = ['errors' => "New password is the same as current password!"];
        }
        // If one error occurs show UI
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: /profile/settings#change-pass");
            exit;
        }

        if(!$userData || !password_verify($currentPassword, $userData['password'])){
            $errors['current_password'] = ['error' => 'Current password is incorrect!'];
            header("Location: /profile/settings#change-pass");
            exit;
        }


        // Update Password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $user->updatePassword($userId, $hashedPassword);
        
        $_SESSION['flash'] = ['success' => "Password changed successfully!"];
        header("Location: /profile/settings#change-pass");
        exit;


    }

    public static function deleteAccount(){
        if (!\App\Core\Router::isCsrfValid()) {
            http_response_code(403);
            die("Invalid CSRF token");
        }

        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $config = require __DIR__ . "/../Config/config.php";
        $user = new UserModel($config);
        
        $user->deleteUser($userId);

        session_destroy();

        header("Location: /register");
        exit;
    }
}
