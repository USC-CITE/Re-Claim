<?php 
/**
    * Layer: Controller
    * Purpose: Handle HTTP requests and responses
    * Rules: No direct DB queries or HTML markup
*/

namespace App\Controllers;

use App\Core\Database;
use App\Models\UserModel;


class AuthController{
    public static function showLogin(){
        require __DIR__ . '/../Views/auth/login.php';
    }

    public static function login(){

        // Fetch form fields
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Validate email format
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "$email is not a valid email address";
            return;
        }

        // TODO: this is for testing purposes only
        if($email === 'test@wvsu.edu.ph' && $password === '123'){
            echo 'Test successful!';
            return;
        }   
        echo 'Invalid credentials!';
    }

    public static function showRegister(){
        require __DIR__ . '/../Views/auth/register.php';
    }

    public static function register(array $config){
        // Establish database connection
        $db = Database::connect($config['db']);

        // Handle data submitted by the user
        $firstName = trim($_POST["firstname"] ?? "");
        $lastName = trim($_POST["lastname"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $password = trim($_POST["password"] ?? "");
        $confirmPass = trim($_POST["confirm-pass"] ?? "");
        $phoneNum = trim($_POST['phone-num'] ?? ""); 

        // Validate data
        if(!$firstName || !$lastName || !$email || !$password || !$confirmPass || !$phoneNum){
            echo "All fields are mandatory!";
            return;
        }

        // Check password if matching
        if($password !== $confirmPass){
            echo "Password does not match!";
            return;
        }

       // Utilize UserModel create method to insert into database
        $model = new UserModel($config);
        $success = $model->create([ 
            'first_name' => $firstName,
            'last_name' => $lastName, 
            'email' => $email, 
            'password' => $password,
            'phone' => $phoneNum ]);

        echo $success ? 'User registered successfully!' : 'Registration failed.';
    }
}

?>