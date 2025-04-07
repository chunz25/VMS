<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'librarysmtp/autoload.php';
require 'mail_form.php';

$gr = "
    SELECT * FROM vw_disputeqty 
    WHERE goods_receive_no='" . $goods_receive_no . "'
    ORDER BY CAST(line_item AS UNSIGNED)
";
$gr = $db->Execute($gr);

$body = '';

$suppliercode = '';
while ($arr = $gr->FetchRow()) {
    $body .= '
    <tr>
        <td>' . $arr['purchase_order_no'] . '</td> 
        <td>' . $arr['goods_receive_no'] . '</td> 
        <td>' . $arr['store_code_item'] . ' - ' . $arr['store_desc_item'] . '</td>
        <td>' . $arr['supplier_code'] . '</td>
        <td>' . $arr['supplier_name'] . '</td>
        <td>' . $arr['document_date'] . '</td>
        <td>' . $arr['product_code'] . '</td>
        <td>' . $arr['description'] . '</td>
        <td>' . $arr['unit'] . '</td>
        <td>' . $arr['po_quantity'] . '</td>
        <td>' . $arr['qty_ori'] . '</td>
        <td>' . $arr['qty_rev1'] . '</td>
        <td>' . $arr['qty_rev2'] . '</td>
        <td>' . $arr['qty_rev3'] . '</td> 
        <td>' . $arr['qty_rev4'] . '</td>
        <td>' . $arr['qty_rev5'] . '</td>
        <td>' . $arr['qty_rev6'] . '</td>
        <td>' . $arr['notercv'] . '</td>
    </tr>';
    $suppliercode = $arr['supplier_code'];
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
$userto = "
        SELECT * FROM email WHERE tb_id_user_type IN (5) AND username = '" . $suppliercode . "'
    ";
$userto = $db->Execute($userto);

while ($a = $userto->FetchRow()) {
    $mail->addAddress($a['email']);
}

$mail->isHTML(true);
$mail->Subject = 'VMS: Dispute QTY ' . $goods_receive_no;
$mail->Body = '
        <p>Dear bapak/ibu,</p>
        <p>FYI, Berikut list Reject atas Request Dispute Settlement Qty pada Proses Invoice yang diajukan oleh tim anda di Vendor Management System ECI:</p>
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
        <p><a href="' . $base_url . '">Vendor Management System</a></p>';

$mail->send();
echo 'success';
