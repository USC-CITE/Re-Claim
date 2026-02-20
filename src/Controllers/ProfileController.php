<?php 

namespace App\Controllers;
use App\Models\UserModel;

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

        require __DIR__ . "/../Views/mainpages/profile.php";

    }
    public static function showEditProfile(){
        require __DIR__ . '/../Views/subpages/edit_profile.php';
    }
}