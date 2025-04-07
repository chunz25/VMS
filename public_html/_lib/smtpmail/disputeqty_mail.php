<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'librarysmtp/autoload.php';
require 'mail_form.php';

$body = '';

$grQuery = " SELECT * FROM vw_disputeqty
            WHERE goods_receive_no = '" . $goods_receive_no . "'
            ORDER BY CAST(line_item AS UNSIGNED)";
$grStmt = $db->Execute($grQuery);

$grQuery = "
        SELECT * FROM vw_disputeqty
        WHERE goods_receive_no = :goods_receive_no
        ORDER BY CAST(line_item AS UNSIGNED)
    ";

$storecode = '';
while ($arr = $grStmt->FetchRow()) {
    $body .= '
            <tr>
                <td>' . htmlspecialchars($arr['purchase_order_no']) . '</td> 
                <td>' . htmlspecialchars($arr['goods_receive_no']) . '</td> 
                <td>' . htmlspecialchars($arr['store_code_item'] . ' - ' . $arr['store_desc_item']) . '</td>
                <td>' . htmlspecialchars($arr['supplier_code']) . '</td>
                <td>' . htmlspecialchars($arr['supplier_name']) . '</td>
                <td>' . htmlspecialchars($arr['document_date']) . '</td>
                <td>' . htmlspecialchars($arr['product_code']) . '</td>
                <td>' . htmlspecialchars($arr['description']) . '</td>
                <td>' . htmlspecialchars($arr['unit']) . '</td>
                <td>' . htmlspecialchars($arr['po_quantity']) . '</td>
                <td>' . htmlspecialchars($arr['qty_ori']) . '</td>
                <td>' . htmlspecialchars($arr['qty_rev1']) . '</td>
                <td>' . htmlspecialchars($arr['qty_rev2']) . '</td>
                <td>' . htmlspecialchars($arr['qty_rev3']) . '</td> 
                <td>' . htmlspecialchars($arr['qty_rev4']) . '</td>
                <td>' . htmlspecialchars($arr['qty_rev5']) . '</td>
                <td>' . htmlspecialchars($arr['qty_rev6']) . '</td>
                <td>' . htmlspecialchars($arr['notercv']) . '</td>
            </tr>';
    $storecode = htmlspecialchars($arr['store_code_item']);
}

if (empty($body)) {
    throw new Exception('No data found for the given goods receive number.');
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

$emailQuery = "
        SELECT email FROM email WHERE tb_id_user_type IN (8)
        UNION ALL
        SELECT a.email FROM email a 
        LEFT JOIN tb_user b ON b.username = a.username 
        WHERE a.tb_id_user_type IN (4) AND b.store_code = '" . $storecode . "'
    ";

$emailStmt = $db->execute($emailQuery);

while ($a = $emailStmt->fetchRow()) {
    $mail->addAddress($a['email']);
}

$mail->addBCC($username);
$mail->isHTML(true);
$mail->Subject = 'VMS: Dispute QTY ' . htmlspecialchars($goods_receive_no);
$mail->Body = '
        <p>Dear Bapak/Ibu,</p>
        <p>FYI, berikut adalah daftar permintaan Dispute Qty pada Proses Invoice yang diajukan oleh vendor di Vendor Management System ECI:</p>
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
                <th>Qty Revisi 1 (Supplier)</th>
                <th>Qty Revisi 2 (EC)</th>
                <th>Qty Revisi 3 (Supplier)</th>
                <th>Qty Revisi 4 (EC)</th>
                <th>Qty Revisi 5 (Supplier)</th>
                <th>Qty Revisi 6 (EC)</th>
                <th>Note Cancel</th>
            </tr>' . $body . '</table>
        <p>Mohon untuk segera diproses.</p>
        <p><a href="' . $base_url . '">Vendor Management System ECI</a></p>';

$mail->send();
echo 'success';
