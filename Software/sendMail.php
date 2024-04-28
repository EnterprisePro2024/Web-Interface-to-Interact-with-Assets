<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "C:\Users\Shass\OneDrive - University of Bradford\New folder\htdocs\Software\PHPMailer.php";
require "C:\Users\Shass\OneDrive - University of Bradford\New folder\htdocs\Software\Exception.php";
require "C:\Users\Shass\OneDrive - University of Bradford\New folder\htdocs\Software\SMTP.php";

// Create a PHPMailer instance
$mail = new PHPMailer(true);

// Set mailer to use SMTP
$mail->isSMTP();

// Enable SMTP debugging (if needed)
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

// SMTP authentication
$mail->SMTPAuth = true;

// SMTP host
$mail->Host = "smtp.gmail.com";

// SMTP port (usually 587)
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