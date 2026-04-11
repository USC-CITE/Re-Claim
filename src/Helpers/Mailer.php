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
            $mail->Host       = $env['SMTP_HOSTNAME'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $env['ADMIN_EMAIL']; 
            $mail->Password   = $env['SMTP_PASSWORD'];   // Gmail App Password
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = $env['SMTP_PORT'] ?? 465;

            //Recipients
            $mail->setFrom($env['ADMIN_EMAIL'], 'WVSU ReClaim');
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
        $subject = 'WVSU: ReClaim Verification Code';
        $body = "DO NOT SHARE!<br><br>"
            . "Your One-Time Pin is: <b>$otp</b>. This is only valid for 5 minutes. <br>
                If this was not you, please report immediately at <b>info@reclaim.wvsu-usc.org</b> or through the official <b>WVSU - CITE</b> Facebook page<br><br>
                
                - WVSU ReClaim Support Team";

        return self::sendMessage($toEmail, $toName, $subject, $body); 

    }

    public static function sendPasswordOtp(string $toEmail, string $toName, string $code): bool{
        $subject = 'WVSU ReClaim - Change Password Verification';

        $body = "
            <div style='font-family: Arial, sans-serif;'>
                <h2>Password Change Request</h2>
                <p>Hello {$toName},</p>

                <p>You requested to change your password. Use the verification code below:</p>

                <h1 style='letter-spacing: 3px;'>{$code}</h1>

                <p>This code is valid for <b>5 minutes</b>.</p>

                <p>If this wasn't you, please secure your account immediately.</p>

                <br>
                <p>- WVSU ReClaim Support Team</p>
            </div>
        ";

        return self::sendMessage($toEmail, $toName, $subject, $body);
    }
}

?>