<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'librarysmtp/autoload.php';
require 'mail_form.php';

$proforma_invoice_no = $_REQUEST["main_id_key"];

if (!$proforma_invoice_no) {
    die('Invalid proforma invoice number.');
}

$grQuery = "
        SELECT * FROM vw_disputeprice
        WHERE proforma_invoice_no = '" . $proforma_invoice_no . "'
        ORDER BY CAST(line_item AS UNSIGNED)
    ";

$grStmt = $db->execute($grQuery);

$body = '';
$suppliercode = null;

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
                <td>' . htmlspecialchars($arr['unit_price_finish']) . '</td> 
            </tr>';
    $suppliercode = $arr['supplier_code'];
}

if (empty($body)) {
    throw new Exception('No data found for the given proforma invoice number.');
}

$usertoQuery = "
        SELECT email FROM email 
        WHERE tb_id_user_type = 5 
        AND username = '" . $suppliercode . "'
    ";

$usertoStmt = $db->execute($usertoQuery);

$validRecipients = 0;

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = $host;
$mail->SMTPAuth = true;
$mail->Username = $username;
$mail->Password = $password;
$mail->SMTPSecure = 'SSL';
$mail->Port = 25;
$mail->setFrom($username, 'VMSMail');

while ($email = $usertoStmt->fetchRow()) {
    $emailAddress = trim($email['email']);
    if (filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
        $mail->addAddress($emailAddress);
        $validRecipients++;
    }
}

if ($validRecipients === 0) {
    throw new Exception("No valid recipient emails found.");
}
$mail->addBCC($username);
$mail->isHTML(true);
$mail->Subject = 'VMS: Confirm Dispute Price ' . htmlspecialchars($proforma_invoice_no);
$mail->Body = '
        <p>Dear Bapak/Ibu,</p>
        <p>FYI, berikut list Approved atas Dispute Price pada proses Invoice yang diajukan oleh tim anda di Vendor Management System ECI:</p>
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
                <th>Unit Price Revisi</th>
            </tr>' . $body . '</table>
        <p>Mohon untuk segera diproses.</p>
        <p><a href="' . $base_url . '">Vendor Management System</a></p>';

$mail->send();
echo 'success';
