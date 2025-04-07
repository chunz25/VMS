<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "conn/config.php";
require 'librarysmtp/autoload.php';
require 'mail_form.php';

$suppQuery = "
    SELECT DISTINCT a.supplier_code, a.supplier_name
    FROM vw_grmail a
    ORDER BY a.goods_receive_no
";
$suppStmt = $db->query($suppQuery);
$suppliers = $suppStmt->fetchAll(PDO::FETCH_OBJ);

if ($suppliers) {
    foreach ($suppliers as $ven) {
        $poQuery = "
            SELECT * FROM vw_grmail
            WHERE supplier_code = :supplier_code
            ORDER BY goods_receive_no
        ";
        $poStmt = $db->prepare($poQuery);
        $poStmt->execute(['supplier_code' => $ven->supplier_code]);
        $poDetails = $poStmt->fetchAll(PDO::FETCH_OBJ);

        $body = '';
        foreach ($poDetails as $arr) {
            $body .= '
                <tr>
                    <td>' . $arr->purchase_order_no . '</td>
                    <td>' . $arr->goods_receive_no . '</td>
                    <td>' . $arr->store_code . ' - ' . $arr->store_name . '</td>
                    <td>' . $arr->departement_code . ' - ' . $arr->departement_desc . '</td>
                    <td>' . $arr->supplier_code . '</td>
                    <td>' . $arr->supplier_name . '</td>
                    <td>' . $arr->document_date . '</td>
                    <td>' . $arr->est_delivery_date . '</td>
                    <td>' . $arr->product_code . ' - ' . $arr->product_name . '</td>
                    <td>' . intval($arr->qty_received) . '</td>
                </tr>';
        }

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $host;
            $mail->SMTPAuth = true;
            $mail->Username = $username;
            $mail->Password = $password;
            $mail->SMTPSecure = 'SSL';
            $mail->Port = 25;
            $mail->setFrom($username, 'VMSMail');
            $userToQuery = "
                SELECT * FROM email WHERE tb_id_user_type IN (5) AND username = :supplier_code
            ";
            $userToStmt = $db->prepare($userToQuery);
            $userToStmt->execute(['supplier_code' => $ven->supplier_code]);
            $usertoEmails = $userToStmt->fetchAll(PDO::FETCH_OBJ);

            foreach ($usertoEmails as $email) {
                $mail->addAddress($email->email);
            }
            $mail->addBCC($username);
            $mail->isHTML(true);
            $mail->Subject = 'VMS: New GR ' . $ven->supplier_name;
            $mail->Body = '
                <p>Dear Bapak/Ibu,</p>
                <p>FYI, Berikut list PO yang sudah di receipt oleh logistik ECI di Vendor Management System ECI:</p>
                <table border="1" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <th>Purchase Order</th>
                        <th>Goods Receive</th>
                        <th>Store</th>
                        <th>Departement</th>
                        <th>Supplier Code</th>
                        <th>Supplier Name</th>
                        <th>Doc date</th>
                        <th>Est Del Date</th>
                        <th>Product</th>
                        <th>Qty Received</th>
                    </tr>' . $body . '</table>';

            $mail->send();
            echo 'Message has been sent for supplier: ' . $ven->supplier_name . "\r\n";

            try {
                $updateQuery = "
                    UPDATE goods_receive 
                    SET sendmail = 1 
                    WHERE sendmail = 0 AND supplier_code = :supplier_code
                ";
                $updateStmt = $db->prepare($updateQuery);
                $updateStmt->execute(['supplier_code' => $ven->supplier_code]);

                echo 'Data has been Updated successfully for supplier: ' . $ven->supplier_name . "\r\n";

            } catch (Exception $e) {
                echo "Data not Updated for supplier {$ven->supplier_name}. Error: {$e}" . "\r\n";
            }

        } catch (Exception $e) {
            echo "Message could not be sent for supplier {$ven->supplier_name}. Mailer Error: {$mail->ErrorInfo}" . "\r\n";

            try {
                $updateQuery = "
                    UPDATE goods_receive 
                    SET sendmail = 1 
                    WHERE sendmail = 0 AND supplier_code = :supplier_code
                ";
                $updateStmt = $db->prepare($updateQuery);
                $updateStmt->execute(['supplier_code' => $ven->supplier_code]);

                echo 'Data has been Updated successfully for supplier: ' . $ven->supplier_name . "\r\n";

            } catch (Exception $e) {
                echo "Data not Updated for supplier {$ven->supplier_name}. Error: {$e}" . "\r\n";
            }
        }

        $body = '';
    }
} else {
    echo 'Tidak Ada PO Baru' . "\r\n";
}
