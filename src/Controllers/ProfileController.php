<?php 

namespace App\Controllers;
use App\Models\UserModel;

class ProfileController{
    public static function showProfile(){
        require __DIR__ . "/../Views/mainpages/profile.php";
    }
}