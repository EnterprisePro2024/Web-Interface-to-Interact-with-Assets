<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

    try {
        
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bilalkaan.mail@gmail.com';
        $mail->Password   = 'vtrdbrtvkgykypeu';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;
        $mail ->setFrom('bilalkaan.mail@gmail.com', 'Admin');
        $mail ->addAddress($email, $fname . ' ' . $sname);
        
        //$mail ->isHTML(true);

        $subject = "Registration Confirmation";

    // Email message
        $message = "Dear $fname $sname,\r\n\r\n";
        $message .= "Thank you for registering with us. Your registration is pending admin approval.\r\n\r\n";
        $message .= "We will inform you via email once your registration has been approved.\r\n\r\n";
        $message .= "Best regards,\r\n\r\n";
        $message .= "CBMDC IT Team";

        $mail ->Subject = $subject;
        $mail ->Body = $message;

        $mail ->send();
        echo 'Email has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>
