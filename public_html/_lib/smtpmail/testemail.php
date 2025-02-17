<?php
define('b', dirname(__FILE__));
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
// koneksi database load --------------
include "conn/config.php";
// $db->debug=true;
require 'librarysmtp/autoload.php';
require 'mail_form.php';

$mail = new PHPMailer(true);
// $username = 'mochamad.seliratno@electronic-city.co.id'; // VMSMail
// $password = 'Ellecc1ty2024!@';

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = $host;                     //hostname/domain yang dipergunakan untuk setting smtp
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = $username;                     //SMTP username
    $mail->Password = $password;                               //SMTP password
    $mail->SMTPSecure = 'SSL';            //Enable implicit TLS encryption
    $mail->Port = 25;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($username, 'VMSMail');

    $mail->addAddress('patrick.parikesit@electronic-city.co.id');

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'VMS: Test Email ';
    $mail->Body = '
                    <p> TEST EMAIL VMS</p>';
    $mail->send();

    $body = '';

    echo 'Message has been sent' . "\r\n";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}" . "\r\n";
}
