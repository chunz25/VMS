<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'librarysmtp/autoload.php';
require 'mail_form.php';

$sql = "
        SELECT * FROM vw_invoice
        WHERE goods_receive_no ='" . $gr_no . "'
    ";
$sql = $db->Execute($sql);

$body = '';
$no = 0;

while ($arr = $sql->FetchRow()) {
    $no++;
    $body .= '
            <tr>
            <td>' . $arr['purchase_order_no'] . '</td> 
            <td>' . $arr['goods_receive_no'] . '</td> 
            <td>' . $arr['store_code'] . '</td> 
            <td>' . $arr['supplier_code'] . '</td> 
            <td>' . $arr['supplier_name'] . '</td> 
            <td>' . $arr['amount'] . '</td> 
            <td>' . $arr['vat'] . '</td> 
            <td>' . $arr['totalamount'] . '</td> 
            </tr>              
    ';
    $inv = $arr['invoice'];
}

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = $host;
$mail->SMTPAuth = true;
$mail->Username = $username;
$mail->Password = $password;
$mail->SMTPSecure = 'SSL';
$mail->Port = 25;
$mail->setFrom($username, 'VMSMail');
$mail->addBCC($username);
$userto = "
        SELECT * FROM email WHERE tb_id_user_type IN (3)
            ";
$userto = $db->Execute($userto);

while ($a = $userto->FetchRow()) {
    $mail->addAddress($a['email']);
}

$mail->isHTML(true);
$mail->Subject = 'VMS: New Invoice ' . $inv;
$mail->Body = '
                    <p>Dear bapak/ibu </p>
                    <p>FYI , Berikut list Receipt Supplier pada Proses Invoice yang di ajukan oleh vendor di Vendor Management System ECI :</p>
                    <table border="1" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <th>Purchase Order</th>
                        <th>GR Number</th>
                        <th>Store</th>
                        <th>Supplier Code</th>
                        <th>Supplier Name</th>
                        <th>Amount</th>
                        <th>VAT</th>
                        <th>Total Amount</th>
                    </tr>' . $body . '</table>
                    <p> Mohon untuk segera di proses.</p>
                    <p><a href="' . $base_url . '">Vendor Management System</a></p>';
$mail->send();
