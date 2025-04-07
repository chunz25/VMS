<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'librarysmtp/autoload.php';
require 'mail_form.php';

$grQuery = "
    SELECT * FROM vw_invoice
    WHERE goods_receive_no = '" . $gr_no . "'
";
$grStmt = $db->execute($grQuery);

$body = '';
$suppliercode = '';
$inv = '';
$no = 0;

while ($arr = $grStmt->FetchRow()) {
    $no++;
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
        </tr>';
    $suppliercode = htmlspecialchars($arr['supplier_code']);
    $inv = htmlspecialchars($arr['invoice']);
}

if (empty($suppliercode)) {
    echo json_encode(['status' => false, 'message' => 'No supplier code found.']);
    exit;
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

$usertoQuery = "
        SELECT email FROM email 
        WHERE tb_id_user_type IN (5) AND username = '" . $suppliercode . "'
    ";
$usertoStmt = $db->execute($usertoQuery);

while ($a = $usertoStmt->FetchRow()) {
    $mail->addAddress($a['email']);
}

$mail->addBCC($username);

$mail->isHTML(true);
$mail->Subject = 'VMS: Confirm Invoice ' . $inv;
$mail->Body = '
        <p>Dear Bapak/Ibu,</p>
        <p>FYI, Berikut adalah list approved atas Receipt Supplier pada Proses Invoice yang diajukan oleh vendor di Vendor Management System ECI:</p>
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <tr>
                <th>Purchase Order</th>
                <th>GR Number</th>
                <th>Store</th>
                <th>Supplier Code</th>
                <th>Supplier Name</th>
                <th>Amount</th>
                <th>VAT</th>
                <th>Total Amount</th>
            </tr>' . $body . '</table>';

$mail->send();
echo 'success';
