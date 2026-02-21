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
    public static function showContactPage($response = null){
        require __DIR__ . "/../Views/mainpages/contact.php";
    }

    public static function sendMessage(){
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
           if (!Mailer::sendMessage(
                $adminEmail,
                'ReClaim Admin',
                "New Message from $name",
                "Name: $name<br>Email: $wvsu_email<br>Message: $message",
                $wvsu_email,
                $name
            )) {
                throw new Exception("Failed to send message to admin.");
            }
            
            // Send notification to the sender
              if (!Mailer::sendMessage(
                $wvsu_email,
                $name,
                "ReClaim Contact Form Confirmation",
                "A message was sent using your email.<br>Message:<br>$message"
            )) {
                throw new Exception("Failed to send confirmation email.");
            }

            $response = ['success' => "Message sent successfully!"];
        }catch(Exception $e){
            $response = ['error' => 'Error: ' . $e->getMessage()];
        }

        // Render contact page again with response
        return self::showContactPage($response);
    }
}
?>