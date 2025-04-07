<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


define('b', dirname(__FILE__));
//Load Composer's autoloader
//2. koneksi database load --------------
include "conn/config.php";
// $db->debug=true;
require 'librarysmtp/autoload.php';
require 'mail_form.php';

$user = "
        select b.fullname as nama, a.username, 'sukses@2023' as password, a.email, a.remark, a.doc from email a
        left join tb_user b on b.username = a.username
        WHERE a.tb_id_user_type in (2,3,4,7,8);
";
$user = $db->query($user);

while ($a = $user->fetch(PDO::FETCH_OBJ)) {
    // $no++;
    $body = '
            <tr>
            <td>' . $a->nama . '</td>
            <td>' . $a->username . '</td>
            <td>' . $a->password . '</td>
            <td>' . $a->remark . '</td>
            </tr>            
                ';

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $host;                     //hostname/domain yang dipergunakan untuk setting smtp
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $username;                     //SMTP username
        $mail->Password   = $password;                               //SMTP password
        $mail->SMTPSecure = 'SSL';            //Enable implicit TLS encryption
        $mail->Port       = 25;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($username, 'VMSMail');
        $mail->addAddress($a->email);

        //Attachments
        $mail->addAttachment(b . $a->doc);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'VMS: Username VMS ' . $a->nama;
        $mail->Body    = '
                        <p>Dear bapak/ibu</p>
                        <p>FYI , Berikut Username & Password untuk melakukan login ke VMS :</p>
                        <table border="1" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <th>Nama</th>
                            <th>Username VMS</th>
                            <th>Password VMS</th>
                            <th>Departement</th>
                            </tr>' . $body . '</table>';
        $mail->send();

        echo 'Message has been sent' . "\r\n";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}" . "\r\n";
    }
}
