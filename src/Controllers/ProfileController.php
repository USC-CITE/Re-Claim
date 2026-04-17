<?php 

namespace App\Controllers;
use App\Core\Router;
use App\Models\UserModel;
use App\Helpers\Mailer;
use DateTime;
use DateTimeZone;
use Exception;

class ProfileController{
    public static function showProfile(){
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $id = $_SESSION['user_id'];
        
        $config = require __DIR__ . "/../Config/config.php";

        $user = new UserModel($config);
        
        $lostItems = array_map(function ($item) use ($id) {
            try {
                $archiveAt = new DateTime($item['archive_date'], new DateTimeZone('Asia/Manila'));
                $archiveDate = $archiveAt->format('F j, Y g:i A');
            } catch (Exception $e) {
                $archiveDate = $item['archive_date'] ?? null;
            }

            return array_merge($item, [
                'archive_date' => $archiveDate,
                'can_recover' => (int)($item['user_id'] ?? 0) === (int)$id
                    && ($item['status'] ?? 'Unrecovered') === 'Unrecovered'
                    && ($item['item_type'] ?? 'lost') === 'lost',
            ]);
        }, $user->fetchItems($id, "lost"));
        $foundItems = array_map(function ($item) use ($id) {
            try {
                $archiveAt = new DateTime($item['archive_date'], new DateTimeZone('Asia/Manila'));
                $archiveDate = $archiveAt->format('F j, Y g:i A');
            } catch (Exception $e) {
                $archiveDate = $item['archive_date'] ?? null;
            }

            return array_merge($item, [
                'archive_date' => $archiveDate,
                'can_recover' => (int)($item['user_id'] ?? 0) === (int)$id
                    && ($item['status'] ?? 'Unrecovered') === 'Unrecovered'
                    && ($item['item_type'] ?? 'found') === 'found',
            ]);
        }, $user->fetchItems($id, "found"));

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
        // 2. HANDLE TEXT FIELDS
        // =========================
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $phone = $_POST['phone_number'] ?? '';
        $social = $_POST['social_link'] ?? '';

        // Retrieve social links
        $socialLinks = $_POST['social_links'] ?? [];

        $errors = [];

        if (!$firstName) {
            $errors['first_name'] = 'First name is required';
        }

        if (!$lastName) {
            $errors['last_name'] = 'Last name is required';
        }

        if(!$phone){
            $errors['phone_number'] = 'Mobile number is required';
        }

        if(!$social){
            $errors['social_link'] = "Social link is required";
        }
        if ($phone && !preg_match('/^[0-9+\-() ]+$/', $phone)) {
            $errors['phone_number'] = 'Invalid phone number format';
        }

        if ($social && !filter_var($social, FILTER_VALIDATE_URL)) {
            $errors['social_link'] = 'Invalid social link URL';
        }

        // Ensure it an array
        if(!is_array($socialLinks)){
            $socialLinks = [];
        }

        // Clean, validate, and limit to 3 fields
        $socialLinks = array_filter(array_map(function ($link){
            $link = trim($link);
            return filter_var($link, FILTER_VALIDATE_URL) ? $link : null; 
        }, $socialLinks));

        // =========================
        // 3. HANDLE AVATAR UPLOAD
        // =========================
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
            
            $file = $_FILES['avatar'];

            if ($file['error'] !== 0){
                $errors['avatar'] = 'Upload failed. Try again.';
            }else{
                $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!in_array($file['type'], $allowedTypes)){
                    $errors['avatar'] = 'Only JPG, PNG, WEBP allowed';
                }

                if ($file['size'] > 2 * 1024 * 1024){
                    $errors['avatar'] = 'Max file size is 2MB';
                }

                // Only upload if no avatar errors
                if (!isset($errors['avatar'])) {
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

                    } else {
                        $errors['avatar'] = 'Failed to save uploaded file';
                    }
                }

            }
        }

        // No duplication
        $socialLinks = array_unique($socialLinks);

        // Enfore 3 max
        $socialLinks = array_slice($socialLinks, 0, 3);

        $user->deleteSocialLinks($userId);

        foreach($socialLinks as $link){
            $user->addSocialLinks($userId, $link);
        }

        // If error array has values return to frontend
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['flash'] = ['error' => 'Please fix the errors'];

            header("Location: /profile/settings");
            exit;
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
            $errors['new_password'] = ['error' => 'New password must be at least 6 characters'];
        }
        if($newPassword !== $confirmPassword){
            $errors['confirm_password'] = ['error' => 'New and confirm passwords do not match!'];
        }

        // If new password value is same as current password
        if(password_verify($newPassword, $userData['password'])){
            $errors['new_password'] = ['error' => "New password is the same as current password!"];
        }

        if(!$userData || !password_verify($currentPassword, $userData['password'])){
            $errors['current_password'] = ['error' => 'Current password does not match!'];
        }

        // If one error occurs show UI
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: /profile/settings#change-pass");
            exit;
        }
        
        // generate otp code
        $otp = rand(100000, 999999);

        // store temp data 
        $_SESSION['otp_code'] = $otp;
        $_SESSION['otp_expiry'] = time() + 300; // 5 mins
        // Store new password
        $_SESSION['pending_password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        $_SESSION['wvsu_email'] = $userData['wvsu_email'];

        $name = !empty($_SESSION['first_name']) ? $_SESSION['first_name'] : 'User';

        Mailer::sendPasswordOtp($_SESSION['wvsu_email'], $name, $otp);
        
        // If no errors open verification code modal
        $_SESSION['show_otp_modal'] = true;
        
        header("Location: /profile/settings#change-pass");
        exit;
    }

    public static function verifyPassword(){
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
            exit;
        }

        $enteredOtp = $_POST['otp'] ?? "";

         // Check OTP existence
        if (!isset($_SESSION['otp_code'])) {
            $_SESSION['errors']['otp'] = 'Session expired. Try again!';
            $_SESSION['show_otp_modal'] = true;
            header("Location: /profile/settings#change-pass");
            exit;
        }

        // Expiry check
        if (time() > $_SESSION['otp_expiry']) {
            unset($_SESSION['otp_code']);
            $_SESSION['errors']['otp'] = 'OTP expired.';
            $_SESSION['show_otp_modal'] = true;
            header("Location: /profile/settings#change-pass");
            exit;
        }

         // Validate OTP
        if ($enteredOtp != $_SESSION['otp_code']) {
            $_SESSION['errors']['otp'] = 'Invalid OTP';
            $_SESSION['show_otp_modal'] = true;
            header("Location: /profile/settings#change-pass");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $config = require __DIR__ . '/../Config/config.php';
        $user = new UserModel($config);

        $user->updatePassword($userId, $_SESSION['pending_password']);

        unset($_SESSION['otp_code']);
        unset($_SESSION['otp_expiry']);
        unset($_SESSION['pending_password']);

        $_SESSION['flash'] =['success' => 'Password changed successfully!'];
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
