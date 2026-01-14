<?php 
namespace App\Controllers;

class AuthController{
    public static function showLogin(){
        require __DIR__ . '/../Views/auth/login.php';
    }
}

?>