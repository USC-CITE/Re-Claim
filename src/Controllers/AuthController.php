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

    public static function login(){
        $email = $_POST['email'];
        $password = $_POST['password'];

        // TODO: this is for testing purposes only
        if($email === 'test@wvsu.edu.ph' && $password === '123'){
            echo 'Test successful!';
            return;
        }
        echo 'Invalid credentials!';
    }
}

?>