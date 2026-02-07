<?php 
namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer{
     public static function sendOtp(string $toEmail, string $toName, string $otp): bool {
        $mail = new PHPMailer(true);

        $envPath = dirname(__DIR__, 2) .'/.env';

        // Handle error if file does not exist
        if (!file_exists($envPath)) {
            var_dump($envPath);
            throw new Exception('.env file not found');
        }

        // Parse the fields inside the .env into an array
        $env = parse_ini_file($envPath);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $env['SMTP_USERNAME']; // your Gmail
            $mail->Password   = $env['SMTP_PASSWORD'];   // Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = $env['SMTP_PORT'];

            //Recipients
            $mail->setFrom($env['SMTP_USERNAME'], 'ReClaim App');
            $mail->addAddress($toEmail, $toName);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for ReClaim Registration';
            $mail->Body    = "Hello $toName,<br><br>Your OTP is: <b>$otp</b><br>It expires in 10 minutes.<br><br>Do not share this code with anyone.";
            
            $mail->send();
            return true;

        } catch (Exception $e) {
            error_log("Mailer Error: " . $mail->ErrorInfo);
            return false;
        }
    }
}

?>