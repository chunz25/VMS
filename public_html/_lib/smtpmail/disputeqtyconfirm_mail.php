<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'librarysmtp/autoload.php';
require 'mail_form.php';

$goods_receive_no = $_REQUEST['main_id_key'];

$body = '';

$grQuery = "
    SELECT * FROM vw_disputeqty 
    WHERE goods_receive_no = '" . $goods_receive_no . "'
    ORDER BY CAST(line_item AS UNSIGNED)
";
$grStmt = $db->execute($grQuery);

$suppliercode = '';
while ($arr = $grStmt->fetchRow()) {
    $body .= '
        <tr>
            <td>' . htmlspecialchars($arr['purchase_order_no']) . '</td> 
            <td>' . htmlspecialchars($arr['goods_receive_no']) . '</td> 
            <td>' . htmlspecialchars($arr['store_code_item']) . ' - ' . htmlspecialchars($arr['store_desc_item']) . '</td>
            <td>' . htmlspecialchars($arr['supplier_code']) . '</td>
            <td>' . htmlspecialchars($arr['supplier_name']) . '</td>
            <td>' . htmlspecialchars($arr['document_date']) . '</td>
            <td>' . htmlspecialchars($arr['product_code']) . '</td>
            <td>' . htmlspecialchars($arr['description']) . '</td>
            <td>' . htmlspecialchars($arr['unit']) . '</td>
            <td>' . htmlspecialchars($arr['po_quantity']) . '</td>
            <td>' . htmlspecialchars($arr['qty_ori']) . '</td>
            <td>' . htmlspecialchars($arr['qty_finish']) . '</td>
        </tr>';
    $suppliercode = htmlspecialchars($arr['supplier_code']);
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
        SELECT * FROM email WHERE tb_id_user_type IN (5) AND username = '" . $suppliercode . "'
    ";
$usertoStmt = $db->execute($usertoQuery);

while ($a = $usertoStmt->fetchRow()) {
    $mail->addAddress($a['email']);
}

$mail->addBCC($username);
$mail->isHTML(true);
$mail->Subject = 'VMS: Confirm Dispute QTY ' . htmlspecialchars($goods_receive_no);
$mail->Body = '
        <p>Dear Bapak/Ibu,</p>
        <p>FYI, berikut list Approved atas Request Dispute Qty pada Proses Invoice yang diajukan oleh tim Anda di Vendor Management System ECI:</p>
        <table border="1" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <th>Purchase Order</th>
                <th>Receipt No</th>
                <th>Store</th>
                <th>Supplier Code</th>
                <th>Supplier Name</th>
                <th>Receipt Date</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Unit</th>
                <th>Qty Order</th>
                <th>Qty Receipt</th>
                <th>Qty Revisi</th>
            </tr>' . $body . '</table>
        <p>Mohon untuk segera diproses.</p>
        <p><a href="' . $base_url . '">Vendor Management System ECI</a></p>';

$mail->send();
echo 'success';