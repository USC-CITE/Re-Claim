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
        // Security Fix: Only allow access if user is in registration flow (has pending_email set)
        // This prevents unauthorized access before OTP verification
        if (!isset($_SESSION['pending_email'])) {
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

            // Array for errors
            $errors = [];
            
            $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            // Validation Each Input fields

            // [1] First Name
            if(!$firstName){
                $errors['first_name'] = "✕ First name is required.";
            }

            // [2] Last Name
            if(!$lastName){
                $errors['last_name'] = "✕ Last name is required.";
            }

            // [3] WVSU Email
            if(!$email){
                $errors['wvsu_email'] = "✕ WVSU email address is required.";
            }

            // [4] Password
            if(!$password){
                $errors['password'] = "✕ Password is required.";
            }

            // [5] Confirm Password
            if(!$confirmPass){
                $errors['confirm_pass'] = "✕ Password confirmation is required.";
            }

            // [6] Phone Number
            if(!$phoneNum){
                $errors['phone_number'] = "✕ Phone number is required.";
            }
            
            // [7] Social Link
            if(!$socialLink){
                $errors['social_link'] = "✕ Social link is required.";
            }
            // Check password length
            if($password && strlen($password) < 6){
                $errors['password'] = "✕ Password must be atleast 6 characters.";
            }
            // Invalid email format
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $errors['wvsu_email'] = "✕ Please enter a valid email format";
            }else if(!preg_match('/@wvsu\.edu\.ph$/', $email)){ // Invalid WVSU email
                    $errors['wvsu_email'] = "✕ Please use your official WVSU email address.";
            }

        
            // Check password if matching
            if($password !== $confirmPass){
                $errors['confirm_pass'] = "✕ Password does not match";
            }

            // Validate Phone number format
            if ($phoneNum && !preg_match('/^[0-9+\-() ]+$/', $phoneNum)) {
                $errors['phone_number'] = '✕ Invalid phone number.';
            }

            // Validate Social link format
            if ($socialLink && !filter_var($socialLink, FILTER_VALIDATE_URL)) {
                $errors['social_link'] = '✕ Please enter valid social link URL.';
            }
            // Hash password
            $hashPass = password_hash($password, PASSWORD_DEFAULT);
            $model = new UserModel($config);

            $user = $model->findByEmail($email);

            // Email Verification Scenarios
            if($user){
                // [1] Email already exists and is verified
                if((int)$user['email_verified'] === 1){
                    $errors['wvsu_email'] =  "✕ The email address '$email' is already in use.";
                } else {
                    // [2] Email already exists but not verified -> Direct to login
                    $errors['wvsu_email'] = "✕ This email is already registered but unverified. Please log in to continue.";
                }
            }
            // NOTE: Do NOT create user yet! Defer creation until OTP verification to prevent database spam.
            // This prevents attackers from filling the database with unverified accounts.
           
            if(!empty($errors)){
                $_SESSION['errors'] = $errors;
                header('Location: /register');
                exit();
            }
            // Store user email to be used in OTP verification
            $_SESSION['pending_email'] = $email;
            $_SESSION['pending_registration'] = [
                'first_name' => $firstName,
                'last_name' => $lastName, 
                'email' => $email, 
                'hashedPass' => $hashPass,
                'phone_number' => $phoneNum,
                'social_link' => $socialLink,
                'v_code_hashed' => $v_code_hashed,
                'v_code_expiry' => $expires
            ];
            $_SESSION['first_name'] = $firstName;
            $_SESSION['full_name'] = $firstName . ' ' . $lastName;
            // For the OTP UI timer
            $_SESSION['social_link'] = $socialLink;
            $_SESSION['phone_number'] = $phoneNum;
            $_SESSION['otp_expires_at'] = $expires;
            // NOTE: Do NOT set $_SESSION['user_id'] until OTP is verified!
            // This prevents unauthorized access to protected routes before email verification
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

        // Check if this is a new registration or existing unverified account
        if (!isset($_SESSION['pending_registration'])) {
            // Existing account - user should already be in database
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
                return;
            }
        }
        
        // New registration flow - verify OTP then create user
        $registrationData = $_SESSION['pending_registration'];
        $model = new UserModel($config);
        
        // Verify the OTP from session
        $hashedOtp = $registrationData['v_code_hashed'];
        if (!password_verify($otp, $hashedOtp)) {
            echo "Invalid or expired OTP.";
            return;
        }
        
        try {
            $userId = $model->create($registrationData);
            
            // Mark email as verified immediately after creation
            if (!$model->verifyOtp($email, $otp)) {
                echo "Registration completed but verification status failed to update. Try and login to verify your account.";
                return;
            }
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                echo "Registration failed: The email address '$email' is already in use.";
                return;
            }
            throw $e;
        }
        
        // Set session for authenticated user
        $_SESSION['user_id'] = $userId;
        $_SESSION['wvsu_email'] = $email;
        $_SESSION['first_name'] = $registrationData['first_name'];
        $_SESSION['last_name'] = $registrationData['last_name'];
        
        // Clean up 
        unset($_SESSION['pending_email']);
        unset($_SESSION['pending_registration']);
        unset($_SESSION['otp_expires_at']);

        header('Location: /');
        exit();
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

        // Check if this is a new registration (has pending_registration) or existing account
        if (isset($_SESSION['pending_registration'])) {
            // New registration - update OTP in session
            $_SESSION['pending_registration']['v_code_hashed'] = $hashed;
            $_SESSION['pending_registration']['v_code_expiry'] = $expires;
        } else {
            // Existing account - update OTP in database
            $model = new UserModel($config);
            $model->updateOtp($email, $hashed, $expires);
        }

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