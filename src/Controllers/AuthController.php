<?php 
/**
    * Layer: Controller
    * Purpose: Handle HTTP requests and responses
    * Rules: No direct DB queries or HTML markup
*/

namespace App\Controllers;

use App\Core\Database;
use App\Models\UserModel;
use PDOException;
use Exception;

class AuthController{
    public static function showLogin(){
        require __DIR__ . '/../Views/auth/login.php';
    }

    public static function login(){

        // Fetch form fields
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Validate email format
        if (!str_ends_with($email, '@wvsu.edu.ph') || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $email;
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
        try {
            // Handle data submitted by the user
            $firstName = trim($_POST["firstname"] ?? "");
            $lastName = trim($_POST["lastname"] ?? "");
            $email = trim($_POST["email"] ?? "");
            $password = trim($_POST["password"] ?? "");
            $confirmPass = trim($_POST["confirm-pass"] ?? "");
            $phoneNum = trim($_POST['phone-num'] ?? ""); 

            // Validation Logic
            if(!$firstName || !$lastName || !$email || !$password || !$confirmPass || !$phoneNum){
                throw new Exception("All fields are mandatory!");
            }

            if (!str_ends_with($email, '@wvsu.edu.ph') || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $email;
            }

            // Check password if matching
            if($password !== $confirmPass){
                throw new Exception("Password does not match!");
            }

            // Hash password
            $hashPass = password_hash($password, PASSWORD_DEFAULT);

            // Utilize UserModel create method to insert into database
            $model = new UserModel($config);
            $model->create([ 
                'first_name' => $firstName,
                'last_name' => $lastName, 
                'email' => $email, 
                'password' => $password,
                'phone_number' => $phoneNum 
            ]);

            echo 'User registered successfully!';

        } catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                echo "Registration failed: The email address '$email' is already in use.";
            } else {
                error_log("Database Error: " . $e->getMessage());
                echo "An unexpected error occurred during registration. Please try again later.";
            }
        } catch (Exception $e) {
            // General Error Handling (Validation, etc.)
            echo "Error: " . $e->getMessage();
        }
    }
}
?>