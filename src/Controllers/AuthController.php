<?php 
/**
    * Layer: Controller
    * Purpose: Handle HTTP requests and responses
    * Rules: No direct DB queries or HTML markup
*/

namespace App\Controllers;

class AuthController{
    public static function showLogin(){
        require __DIR__ . '/../Views/auth/login.php';
    }
}

?>