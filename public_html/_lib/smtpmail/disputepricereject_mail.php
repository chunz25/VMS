<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'librarysmtp/autoload.php';
require 'mail_form.php';

if (!isset($db)) {
    die('Database connection error.');
}

if (!$proforma_invoice_no) {
    die('Invalid proforma invoice number.');
}

$body = '';
$suppliercode = '';

$grQuery = "
        SELECT * FROM vw_disputeprice
        WHERE proforma_invoice_no = '" . $proforma_invoice_no . "'
        ORDER BY CAST(line_item AS UNSIGNED)
    ";

$grStmt = $db->execute($grQuery);

while ($arr = $grStmt->fetchRow()) {
    $body .= '
            <tr>
                <td>' . htmlspecialchars($arr['purchase_order_no']) . '</td> 
                <td>' . htmlspecialchars($arr['goods_receive_no']) . '</td> 
                <td>' . htmlspecialchars($arr['dept']) . '</td> 
                <td>' . htmlspecialchars($arr['store_name']) . '</td> 
                <td>' . htmlspecialchars($arr['supplier_code']) . '</td> 
                <td>' . htmlspecialchars($arr['supplier_name']) . '</td> 
                <td>' . htmlspecialchars($arr['document_date']) . '</td> 
                <td>' . htmlspecialchars($arr['product_code']) . '</td> 
                <td>' . htmlspecialchars($arr['description']) . '</td> 
                <td>' . htmlspecialchars($arr['tax']) . '</td> 
                <td>' . htmlspecialchars($arr['qty']) . '</td> 
                <td>' . htmlspecialchars($arr['unit_price']) . '</td> 
                <td>' . htmlspecialchars($arr['unit_price_rev1']) . '</td> 
                <td>' . htmlspecialchars($arr['unit_price_rev2']) . '</td> 
                <td>' . htmlspecialchars($arr['unit_price_rev3']) . '</td> 
                <td>' . htmlspecialchars($arr['unit_price_rev4']) . '</td> 
                <td>' . htmlspecialchars($arr['unit_price_rev5']) . '</td> 
                <td>' . htmlspecialchars($arr['unit_price_rev6']) . '</td> 
                <td>' . htmlspecialchars($arr['notercv']) . '</td>
            </tr>';
    $suppliercode = htmlspecialchars($arr['supplier_code']);
}

if (empty($body)) {
    throw new Exception('No data found for the given proforma invoice number.');
}

$emailQuery = "
        SELECT email FROM email 
        WHERE tb_id_user_type = 5 
        AND username = '" . $suppliercode . "'
    ";

$emailStmt = $db->execute($emailQuery);

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = $host;
$mail->SMTPAuth = true;
$mail->Username = $username;
$mail->Password = $password;
$mail->SMTPSecure = 'ssl';
$mail->Port = 25;
$mail->setFrom($username, 'VMSMail');

$recipientCount = 0;
while ($a = $emailStmt->fetchRow()) {
    $mail->addAddress($a['email']);
    $recipientCount++;
}

if ($recipientCount === 0) {
    throw new Exception('No valid recipient found.');
}

$mail->addBCC($username);
$mail->isHTML(true);
$mail->Subject = 'VMS: Dispute Price ' . htmlspecialchars($proforma_invoice_no);
$mail->Body = '
        <p>Dear Bapak/Ibu,</p>
        <p>FYI, Berikut adalah list Reject atas Dispute Settlement Price pada Proses Invoice yang diajukan oleh tim anda di Vendor Management System ECI:</p>
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <tr>
                <th>Purchase Order</th>
                <th>Receipt No</th>
                <th>Departement</th>
                <th>Store</th>
                <th>Supplier Code</th>
                <th>Supplier Name</th>
                <th>Receipt Date</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Tax Rate</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Unit Price Revisi 1 (Supplier)</th>
                <th>Unit Price Revisi 2 (EC)</th>
                <th>Unit Price Revisi 3 (Supplier)</th>
                <th>Unit Price Revisi 4 (EC)</th>
                <th>Unit Price Revisi 5 (Supplier)</th>
                <th>Unit Price Revisi 6 (EC)</th>
                <th>Note Reject</th>
            </tr>' . $body . '</table>
        <p>Mohon untuk segera diproses.</p>
        <p><a href="' . $base_url . '">Vendor Management System</a></p>';

$mail->send();
echo 'success';
