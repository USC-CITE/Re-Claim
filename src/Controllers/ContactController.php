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

        $envPath = dirname(__DIR__, 2) .'/.env';

        // Handle error if file does not exist
        if (!file_exists($envPath)) {
            var_dump($envPath);
            throw new Exception('.env file not found');
        }

        // Parse the fields inside the .env into an array
        $env = parse_ini_file($envPath);
        $adminEmail = $env['ADMIN_EMAIL'];
        $adminMsgBody = "
        <h2>New Contact Form Submission</h2>
        
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$wvsu_email}</p>
        <p><strong>Message:</strong></p>
        <p>" . nl2br(htmlspecialchars($message)) . "</p>

        <hr>
        <p>This message was sent from WVSU: ReClaim Contact Page form</p>
        ";

        try{
            // PHPMailer sending 
           if (!Mailer::sendMessage(
                $adminEmail,
                'ReClaim Admin',
                "ReClaim: New Message from $name",
                $adminMsgBody,
                $wvsu_email,
                $name
            )) {
                throw new Exception("Failed to send message to admin.");
            }
            
            $userMsgNotif = "
            <p>Hello {$name},</p>

            <p>
                Thank you for contacting <strong>WVSU: ReClaim</strong>. <br>
                This email confirms that your message has been successfully submitted to our team.
            </p>

            <p><strong>Submitted Message:</strong></p>

            <p>" . nl2br(htmlspecialchars($message)) . "</p>

            <hr>
            <p>
                If you submitted this message, <strong>no further action is required</strong>. Our team will review it and respond if necessary.
            </p>

            <p>
                If you did <strong>NOT</strong> submit this message, please report it immediately by contacting us through one of the following:
            </p>

            <ul>
                <li>Email: <strong>info@reclaim.wvsu-usc.org</strong></li>
                <li>Facebook: <strong>WVSU – CITE</strong></li>
            </ul>

            <p>
            This helps us protect your account and maintain system security.
            </p>

            Best regards,
            ReClaim Team
            West Visayas State University
            <hr>
            ";
            // Send notification to the sender
            if (!Mailer::sendMessage(
                $wvsu_email,
                $name,
                "Message Received - WVSU: ReClaim",
                $userMsgNotif
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