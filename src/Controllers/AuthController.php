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

    public static function showForgotPassword(){
        require __DIR__ . '/../Views/auth/forgot_password.php';
    }

    public static function showVerify(){
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
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
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@wvsu.edu.ph')) {
            $_SESSION['error'] = 'Invalid email format. Please use your WVSU email address (@wvsu.edu.ph).';
            header('Location: /login');
            exit();
        }

        // Initialize object for UserModel class
        $model = new UserModel($config);

        // Utilize our finbByEmail method passing the user's email
        $user = $model->findByEmail($email);

        // Handle if user not exist
        if(!$user){
            $_SESSION['error'] = 'Invalid credentials. Please try again.';
            header('Location: /login');
            exit();
        }

        // Handle if user account is created but not verified
        if((int)$user['email_verified'] !== 1){
            $_SESSION['pending_email'] = $email;
            $_SESSION['error'] = 'Email not verified. Please check your inbox.';
            header('Location: /verify');
            exit();
        } 
        
        // Verify credentials
        if(!password_verify($password, $user['password'])){
            $_SESSION['error'] = 'Invalid credentials. Please try again.';
            header('Location: /login');
            exit();
        }

        // If no errors
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['phone_number'] = $user['phone_number'];
        $_SESSION['social_link'] = $user['social_link'];
        $_SESSION['wvsu_email'] = $user['wvsu_email'];
        $_SESSION['avatar'] = $user['avatar_path'];

        header('Location: /');
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
            $model = new UserModel($config);

            $user = $model->findByEmail($email);

            // Email Verification Scenarios
            if(!$user){
                // [1] User email is available
               // Stores the userId that the create method returns
                $userId = $model->create([ 
                    'first_name' => $firstName,
                    'last_name' => $lastName, 
                    'email' => $email, 
                    'hashedPass' => $hashPass,
                    'phone_number' => $phoneNum,
                    'social_link' => $socialLink,
                    'v_code_hashed' => $v_code_hashed,
                    'v_code_expiry' => $expires

                ]);
            }else{ 
                // [2] Email already exists
                if($user['email_verified'] == 1){
                    throw new Exception("Registration failed: The email address '$email' is already in use.");
                }
                // [3] Email already exists but not verified -> Redirect To OTP
                else{
                    $model->updateOtp($email, $v_code_hashed, $expires);

                    $userId = $user['id'];
                }
            }
           
            // Store user email to be used in OTP verification
            $_SESSION['pending_email'] = $email;
            $_SESSION['first_name'] = $firstName;
            $_SESSION['full_name'] = $firstName . ' ' . $lastName;
            // For the OTP UI timer
            $_SESSION['social_link'] = $socialLink;
            $_SESSION['phone_number'] = $phoneNum;
            $_SESSION['otp_expires_at'] = $expires;
            $_SESSION['avatar'] = $user['avatar_path'];
            $_SESSION['user_id'] = $userId;
            // Send OTP via Gmail
            if (Mailer::sendOtp($email, $firstName, $otp)) {
                echo "Registration successful! Check your email for the OTP.";
                header('Location: /verify');
            } else {
                echo "Registration successful, but failed to send OTP email. Please contact support.";
            }
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

    public static function logout(){
        // Clean sesssion
        $_SESSION = [];

        // Destory session
        session_destroy();
        header('Location: /login');
        exit();

    }

    public static function forgotPassword(array $config){
        $email = trim($_POST['email'] ?? '');

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@wvsu.edu.ph')) {
            $_SESSION['error'] = 'Please use a valid WVSU email address (@wvsu.edu.ph).';
            header('Location: /forgot-password');
            exit();
        }

        $model = new UserModel($config);
        $user = $model->findByEmail($email);

        if (!$user || (int)$user['email_verified'] !== 1) {
            // Show generic success to prevent email enumeration
            $_SESSION['success'] = 'If an account with that email exists, a password reset link has been sent.';
            header('Location: /forgot-password');
            exit();
        }
        
        // Generate a secure token
        $token = bin2hex(random_bytes(32));
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        $expires = date('Y-m-d H:i:s', strtotime('+30 minutes'));

        $model->storeResetToken($email, $hashedToken, $expires);

        // reset link
        $protocol = 'http';
        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
            ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') {
            $protocol = 'https';
        }
        $host = $_SERVER['HTTP_HOST'];
        $resetLink = "{$protocol}://{$host}/reset-password?token={$token}";

        // Send reset email
        Mailer::sendResetLink($email, $user['first_name'], $resetLink);

        $_SESSION['success'] = 'If an account with that email exists, a password reset link has been sent.';
        header('Location: /forgot-password');
        exit();
    }
    public static function showResetPassword(array $config){
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            $_SESSION['error'] = 'Invalid or missing reset token.';
            header('Location: /forgot-password');
            exit();
        }

        $model = new UserModel($config);
        $user = $model->findByResetToken($token);

        if (!$user) {
            $_SESSION['error'] = 'This reset link is invalid or has expired.';
            header('Location: /forgot-password');
            exit();
        }

        require __DIR__ . '/../Views/auth/reset_password.php';
    }
    
    public static function resetPassword(array $config){
        $token = trim($_POST['token'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirmPassword = trim($_POST['confirm-password'] ?? '');

        if (empty($token)) {
            $_SESSION['error'] = 'Invalid reset token.';
            header('Location: /forgot-password');
            exit();
        }

        if (strlen($password) < 8) {
            $_SESSION['error'] = 'Password must be at least 8 characters.';
            header("Location: /reset-password?token={$token}");
            exit();
        }

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match.';
            header("Location: /reset-password?token={$token}");
            exit();
        }

        $model = new UserModel($config);
        $user = $model->findByResetToken($token);

        if (!$user) {
            $_SESSION['error'] = 'This reset link is invalid or has expired.';
            header('Location: /forgot-password');
            exit();
        }

        // Update password and clear token
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $model->updatePassword((int)$user['id'], $hashedPassword);
        $model->clearResetToken((int)$user['id']);

        $_SESSION['success'] = 'Your password has been reset successfully. Please log in.';
        header('Location: /login');
        exit();
    }
}

?>