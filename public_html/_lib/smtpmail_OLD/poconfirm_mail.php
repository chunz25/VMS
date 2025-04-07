<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'librarysmtp/autoload.php';
require 'mail_form.php';

$sql004 = "SELECT * FROM purchase_order_item WHERE purchase_order_no='" . $po_no . "' order by CAST(line_item AS UNSIGNED)";
$rs = $db->Execute($sql004);

$mccode = '';
$body = ''; // Initialize the body string to avoid undefined variable issues
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
            <td>' . $arr['header_text'] . '</td>
            </tr>';
    $mccode = $arr['category_code'];
}

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host = $host;                                  // SMTP host
    $mail->SMTPAuth = true;                                   // Enable SMTP authentication
    $mail->Username = $username;                              // SMTP username
    $mail->Password = $password;                              // SMTP password
    $mail->SMTPSecure = 'SSL';          // Enable STARTTLS encryption
    $mail->Port = 25;                                     // TCP port 25 for STARTTLS

    //Recipients
    $mail->setFrom($username, 'VMSMail');
    $userto = "
                SELECT * FROM email WHERE tb_id_user_type IN (7,8)
                UNION ALL
                SELECT a.* FROM email a
                LEFT JOIN tb_user b on b.username = a.username
                WHERE a.tb_id_user_type IN (2) AND CONCAT(COALESCE(b.lock1,''),COALESCE(b.lock2,''),COALESCE(b.lock3,'')) like concat('%','" . $mccode . "','%')
                UNION ALL
                SELECT * FROM email WHERE tb_id_user_type IN (4) AND LEFT(username,4) = LEFT('" . $store_mail . "',4)
            ";
    $userto = $db->Execute($userto);

    while ($a = $userto->FetchRow()) {
        $mail->addAddress($a['email']);
    }

    //Content
    $mail->addBCC($username);
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'VMS: Confirm PO ' . $po_no;
    $mail->Body = '
                    <p>Dear bapak/ibu,</p>
                    <p>FYI, Berikut list konfirmasi PO pada Proses PO di Vendor Management System ECI:</p>
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
                    </tr>' . $body . '</table>';
    $mail->send();
    echo 'success';
} catch (Exception $e) {
    echo "failed: " . $mail->ErrorInfo;
}
