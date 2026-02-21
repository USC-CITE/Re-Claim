<?php 
namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer{
    public static function sendMessage(
        string $toEmail, string $toName, string $subject, string $body,
        ?string $replyToEmail = null, ?string $replyToName = null // (Optional) handler for contact message reply to sender
    ): bool{
        $mail = new PHPMailer(true);

        $envPath = dirname(__DIR__, 2) .'/.env';

        // Handle error if file does not exist
        if (!file_exists($envPath)) {
            var_dump($envPath);
            throw new Exception('.env file not found');
        }

        // Parse the fields inside the .env into an array
        $env = parse_ini_file($envPath);

        try{

            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $env['SMTP_USERNAME']; // your Gmail
            $mail->Password   = $env['SMTP_PASSWORD'];   // Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = $env['SMTP_PORT'] ?? 587;

            //Recipients
            $mail->setFrom($env['SMTP_USERNAME'], 'WVSU ReClaim');
            $mail->addAddress($toEmail, $toName);

            // If replyToEmail variable has value
            if($replyToEmail){
                $mail->addReplyTo($replyToEmail, $replyToName ?? '');
            }

            // Dynamic Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            
            $mail->send();
            return true;
        }catch(Exception $e){
            error_log("Mailer Error: " . $mail->ErrorInfo);
            return false;
        }

    }
     public static function sendOtp(string $toEmail, string $toName, string $otp): bool {
        $subject = 'Your OTP for ReClaim Registration (NEW)';
        $body = "Hello $toName,<br><br>"
              . "Your OTP is: <b>$otp</b><br>"
              . "It expires in 10 minutes.<br><br>"
              . "Do not share this code with anyone.";
        return self::sendMessage($toEmail, $toName, $subject, $body); 

    }
}

?>