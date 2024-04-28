<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


    // Retrieve the parameters
    $email = $_GET['email'];
    $fname = $_GET['fname'];
    $sname = $_GET['sname'];

    // Create a new instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bilalkaan.mail@gmail.com';
        $mail->Password   = 'vtrdbrtvkgykypeu';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;
        $mail->setFrom('bilalkaan.mail@gmail.com', 'Admin');
        $mail->addAddress($email, $fname . ' ' . $sname);

        // Email subject
        $subject = "Registration Confirmation";

        // Email message
        $message = "Dear User,\r\n\r\n";
        $message .= "Thank you for registering with us. We are pleased to inform you that the Administrator has approved your registration.\r\n\r\n";
        $message .= "You may now login and continue.\r\n\r\n";
        $message .= "Best regards,\r\n\r\n";
        $message .= "CBMDC IT Team";

        // Set email subject and body
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send email
        $mail->send();
        echo 'Email has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

?>