<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'librarysmtp/autoload.php';
require 'mail_form.php';

$body = '';
$suppliercode = '';
$inv = '';

$gr_query = "
    SELECT * FROM vw_invoice
    WHERE goods_receive_no = '" . $gr_no . "'
";
$gr = $db->Execute($gr_query);

if ($gr) {
    while ($arr = $gr->FetchRow()) {
        $body .= '
            <tr>
                <td>' . htmlspecialchars($arr['purchase_order_no']) . '</td> 
                <td>' . htmlspecialchars($arr['goods_receive_no']) . '</td> 
                <td>' . htmlspecialchars($arr['store_code']) . '</td> 
                <td>' . htmlspecialchars($arr['supplier_code']) . '</td> 
                <td>' . htmlspecialchars($arr['supplier_name']) . '</td> 
                <td>' . htmlspecialchars($arr['amount']) . '</td> 
                <td>' . htmlspecialchars($arr['vat']) . '</td> 
                <td>' . htmlspecialchars($arr['totalamount']) . '</td> 
                <td>' . htmlspecialchars($arr['rejectnote']) . '</td> 
            </tr>';

        $suppliercode = $arr['supplier_code'];
        $inv = $arr['invoice'];
    }
} else {
    die("Database query failed.");
}

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = $host;
$mail->SMTPAuth = true;
$mail->Username = $username;
$mail->Password = $password;
$mail->SMTPSecure = "SSL";
$mail->Port = 25;
$mail->setFrom($username, 'VMSMail');
$suppliercode = $db->quote($suppliercode);
$userto_query = "
        SELECT email FROM email WHERE tb_id_user_type = 5 AND username = $suppliercode
    ";
$userto = $db->Execute($userto_query);

if ($userto) {
    while ($a = $userto->FetchRow()) {
        $mail->addAddress($a['email']);
    }
}
$mail->addBCC($username);
$mail->isHTML(true);
$mail->Subject = 'VMS: Reject Invoice ' . htmlspecialchars($inv);
$mail->Body = '
        <p>Dear Bapak/Ibu,</p>
        <p>FYI, berikut adalah daftar reject atas Receipt Supplier pada proses Invoice yang diajukan oleh vendor di Vendor Management System ECI:</p>
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <tr>
                <th>Purchase Order</th>
                <th>Invoice No</th>
                <th>Store</th>
                <th>Supplier Code</th>
                <th>Supplier Name</th>
                <th>Amount</th>
                <th>VAT</th>
                <th>Total Amount</th>
                <th>Note Reject</th>
            </tr>' . $body . '
        </table>
        <p>Mohon untuk segera diproses.</p>
        <p><a href="' . $base_url . '">Klik di sini untuk login</a></p>';

$mail->send();
echo 'success';
