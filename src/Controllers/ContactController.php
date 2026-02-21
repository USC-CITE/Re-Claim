<?php 
/**
    * Layer: Controller
    * Purpose: Handle HTTP requests and responses
    * Rules: No direct DB queries or HTML markup
*/

namespace App\Controllers;

use App\Helpers\Mailer;
use PDOException;
use Exception;

class ContactController{
    public static function showContactPage(){
        require __DIR__ . "/../Views/mainpages/contact.php";
    }

    public static function sendMessage(): array{
        // Get values
        $name = $_POST['name'] ?? '';
        $wvsu_email = trim($_POST['wvsu-email'] ?? '');
        $message = $_POST['message'] ?? '';

        // Check fields
        if(!$name || !$wvsu_email || !$message){
            return ['error' => 'All fields are required'];
        }
        // Validate email format
        if (!str_ends_with($wvsu_email, '@wvsu.edu.ph') || !filter_var($wvsu_email, FILTER_VALIDATE_EMAIL)) {
                return ['error' => 'Please enter a valid WVSU email'];
        }

        $adminEmail = 'kellyydrhan.alojepan@wvsu.edu.ph';
        try{
            // PHPMailer sending 
            Mailer::sendMessage(
                $adminEmail,
                'ReClaim Admin',
                "New Message from $name",
                "Name: $name<br>Email: $wvsu_email<br>Message:$message",
                $wvsu_email,
                $name
            );
            
            // Send notification to the sender
            Mailer::sendMessage(
                $wvsu_email,               // Student email
                $name,
                "ReClaim Contact Form Confirmation",
                "A message was sent using your email.<br>Message:<br>$message"
            );

            return ['success' => 'Message sent successfully!'];
        }catch(Exception $e){
            return ['error' => 'Failed to send message: ' . $e->getMessage()];
        }
    }
}
?>