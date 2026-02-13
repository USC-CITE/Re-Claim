<?php 
/**
    * Layer: Controller
    * Purpose: Handle HTTP requests and responses
    * Rules: No direct DB queries or HTML markup
*/

namespace App\Controllers;

use App\Core\Database;
use App\Helpers\Mailer;
use App\Models\UserModel;
use PDOException;
use Exception;

class AuthController{
    public static function showLogin(){
        require __DIR__ . '/../Views/auth/login.php';
    }

    public static function showRegister(){
        require __DIR__ . '/../Views/auth/register.php';
    }

    public static function showVerify(){
        $expiresAt = $_SESSION['otp_expires_at'];
        
        // Check if verify_message field 
        if(!empty($_SESSION['message'])){
            echo "<p>" . htmlspecialchars($_SESSION['message']) . "</p>";
            unset($_SESSION['message']);
        }
        require __DIR__ . '/../Views/mainpages/verify.php';
    }

    public static function login(array $config){

        // Fetch form fields
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Validate email format
        if (!str_ends_with($email, '@wvsu.edu.ph') || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $email;
        }

        // Initialize object for UserModel class
        $model = new UserModel($config);

        // Utilize our finbByEmail method passing the user's email
        $user = $model->findByEmail($email);

        // Handle if user not exist
        if(!$user){
            // Frontend will handle UI/UX error handling
            echo $email;
            return;
        }

        // Handle if user account is created but not verified
        if((int)$user['email_verified'] !== 1){
            // Frontend will handle UI/UX error handling
            echo $email;
            return;
        } 
        
        // Verify credentials
        if(!password_verify($password, $user['password'])){
            // Frontend will handle UI/UX error handling
            echo $email; // Invalid credentials
            return;
        }

        // If no errors
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['wvsu_email'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        header('Location: /');
    }

    

    public static function register(array $config){
        session_start();
        try {
            // Handle data submitted by the user
            $firstName = trim($_POST["firstname"] ?? "");
            $lastName = trim($_POST["lastname"] ?? "");
            $email = trim($_POST["email"] ?? "");
            $password = trim($_POST["password"] ?? "");
            $confirmPass = trim($_POST["confirm-pass"] ?? "");
            $phoneNum = trim($_POST['phone-num'] ?? "");
            $socialLink = trim($_POST['social-link'] ?? "");

            // Generate OTP
            $otp = random_int(100000, 999999); // secure 6-digit OTP
    
            // Hash generated OTP
            $v_code_hashed = password_hash($otp, PASSWORD_DEFAULT);
            
            $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            // Validation Logic
            if(!$firstName || !$lastName || !$email || !$password || !$confirmPass || !$phoneNum || !$socialLink){
                throw new Exception("All fields are mandatory!");
            }

            if (!str_ends_with($email, '@wvsu.edu.ph') || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "[DEBUG]: Invalid email format";
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
                'hashedPass' => $hashPass,
                'phone_number' => $phoneNum,
                'social_link' => $socialLink,
                'v_code_hashed' => $v_code_hashed,
                'v_code_expiry' => $expires

            ]);

            // Store user email to be used in OTP verification
            $_SESSION['pending_email'] = $email;
            $_SESSION['first_name'] = $firstName;

            // For the OTP UI timer
            $_SESSION['otp_expires_at'] = $expires;
            
            // Send OTP via Gmail
            if (Mailer::sendOtp($email, $firstName, $otp)) {
                $_SESSION['message'] = "Registration successful! Check your email for the OTP.";
            } else {
                $SESSION['message'] = "Registration successful, but failed to send OTP email. Please contact support.";
            }

            header('Location: /verify');
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                echo "Registration failed: The email address '$email' is already in use.";
            } else {
                error_log("Database Error: " . $e->getMessage());
                echo "An unexpected error occurred during registration. Please try again later." . $e->getMessage();
            }
        } catch (Exception $e) {
            // General Error Handling (Validation, etc.)
            echo "Error: " . $e->getMessage();
        }
    }

    public static function verify(array $config)
    {
        session_start();
        
        $email = $_SESSION['pending_email'] ?? null;
        $otp = trim($_POST['otp'] ?? '');
        
        if (!$email || !$otp) {
            echo "Session expired. Please register again.";
            return;
        }

        $model = new UserModel($config);

        if ($model->verifyOtp($email, $otp)) {
            
            $user = $model->findByEmail($email);
            if($user){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['wvsu_email'] = $user['wvsu_email'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
            }

            // Clean up 
            unset($_SESSION['pending_email']);
            unset($_SESSION['otp_expires_at']);

            header('Location: /');
            exit();
        } else {    
            echo "Invalid or expired OTP.";
        }
    }

    public static function resendOtp(array $config){
        session_start();

        $firstName = $_SESSION['first_name'] ?? null;
        $email = $_SESSION['pending_email'] ?? null;

        if(!$email){
            echo "Session expired. Please register again";
            return;
        }

        $otp = random_int(100000, 999999);
        $hashed = password_hash($otp, PASSWORD_DEFAULT);
        $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        $model = new UserModel($config);
        $model->updateOtp($email, $hashed, $expires);

        if(Mailer::sendOtp($email, $firstName, $otp)){
            $_SESSION['resend_message'] = "New OTP sent to your email";
        }else{
            $_SESSION['resend_message'] = "OTP generated, but failed to sent to your email.";
        }

        // For the OTP UI timer
        $_SESSION['otp_expires_at'] = $expires;
        header('Location: /verify');

    }
}
?>