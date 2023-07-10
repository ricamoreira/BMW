<?php
header('Content-Type: text/html; charset=UTF-8');

if(empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(500);
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

define ('GUSER','info@projectbriareus.pt');
define ('GPWD','edCP%BR]!LqX');


// make a separate file and include this file in that. call this function in that file.

function smtpmailer($to, $from, $from_name, $subject, $body) { 
    $mail = new PHPMailer();  // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'webdomain04.dnscpanel.com';
    $mail->Port = 465;

    $mail->Username = GUSER;  
    $mail->Password = GPWD;           
    $mail->SetFrom($from, $from_name);
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = $subject;
    $mail->Body    = nl2br($body);
    $mail->AltBody = nl2br(strip_tags($body));
    $mail->AddAddress($to);
    if(!$mail->send()) {
        http_response_code(500);
    } /*else {
            //header('Location: index.php?enviado');
            echo "Email enviado!";
    }*/
}

smtpmailer("info@projectbriareus.pt", $_POST['email'], $_POST['name'], $_POST['subject'], $_POST['message']);
?>