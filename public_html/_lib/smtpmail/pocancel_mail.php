<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'librarysmtp/autoload.php';
require 'mail_form.php';

$sql004 = "SELECT * FROM purchase_order_item WHERE purchase_order_no='" . $purchase_order_no . "' order by CAST(line_item AS UNSIGNED)";
$rs = $db->Execute($sql004);

$mccode = '';
$body = '';
while ($arr = $rs->FetchRow()) {
    $no++;
    $body .= '
            <tr>
            <td>' . $purchase_order_no . '</td>
            <td>' . $store_mail . '</td>
            <td>' . $arr['category_code'] . ' - ' . $arr['departement_desc_item'] . '</td>
            <td>' . $suppcode_mail . '</td>
            <td>' . $suppname_mail . '</td>
            <td>' . $docdate_mail . '</td>
            <td>' . $docexp_mail . '</td>
            <td>' . $arr['product_code'] . ' - ' . $arr['description'] . '</td>
            <td>' . $arr['header_text'] . '</td> <!-- Added description from the field header_text -->
            <td>' . $reason . '</td>
            <td>' . $user_req_note . '</td>
            </tr>            
    ';
    $mccode = $arr['category_code'];
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
        SELECT * FROM email WHERE tb_id_user_type IN (7)
        UNION ALL
        SELECT a.* FROM email a
        LEFT JOIN tb_user b on b.username = a.username
        WHERE a.tb_id_user_type IN (2) AND CONCAT(COALESCE(b.lock1,''),COALESCE(b.lock2,''),COALESCE(b.lock3,'')) like concat('%','" . $mccode . "','%')
    ";
$userto = $db->Execute($userto);
while ($a = $userto->FetchRow()) {
    $mail->addAddress($a['email']);
}
$mail->addBCC($username);
$mail->isHTML(true);
$mail->Subject = 'VMS: Request Cancel PO ' . $purchase_order_no;
$mail->Body = '
        <p>Dear bapak/ibu,</p>
        <p>FYI, Berikut list Request Cancel PO pada Proses PO yang diajukan oleh vendor di Vendor Management System ECI:</p>
        <table border="1" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <th>Purchase Order</th>
            <th>Store</th>
            <th>Departement</th>
            <th>Supplier Code</th>
            <th>Supplier Name</th>
            <th>Doc date</th>
            <th>Est Del Date</th>
            <th>Product</th>
            <th>Description</th>
            <th>Reason</th>
            <th>Note Cancel</th>
        </tr>' . $body . '</table>
        <p>Mohon untuk segera diproses jika di rasa perlu membuat PO baru.</p>';

$mail->send();
echo 'success';
