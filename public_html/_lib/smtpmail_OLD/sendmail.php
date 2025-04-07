<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'librarysmtp/autoload.php';

$sql004 = "SELECT * FROM purchase_order_item WHERE purchase_order_no='" . $po_no . "' order by CAST(line_item AS UNSIGNED)";
$rs = $db->Execute($sql004);

while ($arr = $rs->FetchRow()) {
    $no++;
    $body .= '
            <tr>
            <td>' . $po_no . '</td>
            <td>' . $store_mail . '</td>
            <td>' . $arr['category_code'] . ' - ' . $arr['departement_desc_item'] . '</td>
            <td>' . $suppcode_mail . '</td>
            <td>' . $suppname_mail . '</td>
            <td>' . $docdate_mail . '</td>
            <td>' . $docexp_mail . '</td>
            <td>' . $arr['product_code'] . ' - ' . $arr['description'] . '</td>
            </tr>            
    ';
}

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.electronic-city.co.id';                     //hostname/domain yang dipergunakan untuk setting smtp
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'mochamad.seliratno@electronic-city.co.id';                     //SMTP username
    $mail->Password   = 'Ellecc1ty';                               //SMTP password
    $mail->SMTPSecure = 'SSL';            //Enable implicit TLS encryption
    $mail->Port       = 25;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('mochamad.seliratno@electronic-city.co.id', 'VMSMail');
    $mail->addAddress('akungamers0131@gmail.com', '');
    //$mail->addAddress('fatchul.hudda@gmail.com', '');     //email tujuan
    // $mail->addReplyTo('emailtujuan@domainaddreply.com', 'Information'); //email tujuan add reply (bila tidak dibutuhkan bisa diberi pagar)
    // $mail->addCC('emailtujuan@domaincc.com'); // email cc (bila tidak dibutuhkan bisa diberi pagar)
    // $mail->addBCC('emailtujuan@domainbcc.com'); // email bcc (bila tidak dibutuhkan bisa diberi pagar)

    //Attachments
    #$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    #$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'VMS: Confirm PO ' . $po_no;
    $mail->Body    = '
                    <p>Dear bapak/ibu </p>
                    <p> FYI , Berikut list konfirmasi PO pada Proses PO di Vendor Management System ECI :</p>
                    <table border="1" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <th>Purchase Order</th>
                        <th>Store</th>
                        <th>Departement</th>
                        <th>Supplier Code</th>
                        <th>Supplier Name</th>
                        <th>Doc date</th>
                        <th>Est Del Date</th>
                        <th>Description</th>
                    </tr>' . $body . '</table>';
    $mail->send();
    echo 'success';
} catch (Exception $e) {
    echo "failed";
}
