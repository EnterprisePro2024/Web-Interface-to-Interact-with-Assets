<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Create a PHPMailer instance
$mail = new PHPMailer(true);

// Set mailer to use SMTP
$mail->isSMTP();


// SMTP authentication
$mail->SMTPAuth = true;

// SMTP host
$mail->Host = "smtp.gmail.com";

// SMTP port 
$mail->Port = 587;

// SMTP username
$mail->Username = "subby1229@gmail.com";

// SMTP password
$mail->Password = "aysy gxwl sqvy qtho";

// Enable TLS encryption
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

// Set email format to HTML
$mail->isHTML(true);

// Return the PHPMailer instance
return $mail;