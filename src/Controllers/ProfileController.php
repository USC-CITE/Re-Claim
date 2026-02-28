<?php 

namespace App\Controllers;
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
                'item_name' => $item['item_name'] ?? 'Unnamed Item',
                'description' => $item['description'] ?? 'No description provided.',
                'item_type' => ucfirst($item['item_type'] ?? 'Item'),
                'status' => $item['status'] ?? 'Archived',
                'archive_date' => $archiveDate,
            ];
        }, $user->fetchArchivedItems($id));

        require __DIR__ . "/../Views/mainpages/profile.php";

    }
    public static function showEditProfile(){
        require __DIR__ . '/../Views/subpages/edit_profile.php';
    }
}
