<?php
define('b', dirname(__FILE__));

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "conn/config.php";
require 'librarysmtp/autoload.php';
require 'mail_form.php';

$suppQuery = "
    SELECT DISTINCT a.supplier_code, a.supplier_name, a.department
    FROM vw_porelease a
    ORDER BY purchase_order_no
";
$suppStmt = $db->query($suppQuery);
$suppliers = $suppStmt->fetchAll(PDO::FETCH_OBJ);

if ($suppliers !== null) {
    foreach ($suppliers as $ven) {
        $poQuery = "
            SELECT * FROM vw_porelease
            WHERE supplier_code = :supplier_code
            AND department = :department
            ORDER BY purchase_order_no
        ";
        $poStmt = $db->prepare($poQuery);
        $poStmt->execute(['supplier_code' => $ven->supplier_code, 'department' => $ven->department]);
        $poDetails = $poStmt->fetchAll(PDO::FETCH_OBJ);

        $body = '';
        foreach ($poDetails as $po) {
            $body .= "
                <tr>
                    <td>{$po->purchase_order_no}</td>
                    <td>{$po->store_code} - {$po->store_name}</td>
                    <td>{$po->departement_code} - {$po->departement_desc}</td>
                    <td>{$po->supplier_code}</td>
                    <td>{$po->supplier_name}</td>
                    <td>{$po->document_date}</td>
                    <td>{$po->delivery_date}</td>
                    <td>{$po->header_text}</td>
                </tr>
            ";
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
            $usertoQuery = "
                SELECT * FROM email WHERE tb_id_user_type IN (5) AND username = :supplier_code
            ";
            $usertoStmt = $db->prepare($usertoQuery);
            $usertoStmt->execute(['supplier_code' => $ven->supplier_code]);
            $usertoEmails = $usertoStmt->fetchAll(PDO::FETCH_OBJ);

            foreach ($usertoEmails as $email) {
                $mail->addAddress($email->email);
            }
            $userccQuery = "
                SELECT * FROM email WHERE tb_id_user_type IN (7)
                UNION ALL
                SELECT a.* FROM email a
                LEFT JOIN tb_user b ON b.username = a.username
                WHERE a.tb_id_user_type IN (2) 
                AND CONCAT(COALESCE(b.lock1,''), COALESCE(b.lock2,''), COALESCE(b.lock3,'')) 
                LIKE concat('%', :department, '%')
            ";
            $userccStmt = $db->prepare($userccQuery);
            $userccStmt->execute(['department' => $ven->department]);
            $userccEmails = $userccStmt->fetchAll(PDO::FETCH_OBJ);

            foreach ($userccEmails as $email) {
                $mail->addCC($email->email);
            }
            $mail->addBCC($username);
            $mail->isHTML(true);
            $mail->Subject = 'VMS: New PO ' . $ven->supplier_name;
            $mail->Body = '
                <p>Dear Bapak/Ibu,</p>
                <p>FYI, Berikut list PO Baru pada Proses PO di Vendor Management System ECI:</p>
                <table border="1" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <th>Purchase Order</th>
                        <th>Store</th>
                        <th>Departement</th>
                        <th>Supplier Code</th>
                        <th>Supplier Name</th>
                        <th>Doc date</th>
                        <th>Est Del Date</th>
                        <th>Description</th>
                    </tr>' . $body . '</table>';

            $mail->send();
            echo 'Message has been sent successfully for supplier: ' . $ven->supplier_name . ' Department ' . $ven->department . "\r\n";

            $body = '';

            try {
                $updateQuery = "
                    UPDATE purchase_order 
                    SET sendmail = 1 
                    WHERE sendmail = 0 AND supplier_code = :supplier_code AND department = :department
                ";
                $updateStmt = $db->prepare($updateQuery);
                $updateStmt->execute(['supplier_code' => $ven->supplier_code, 'department' => $ven->department]);

                echo 'Data has been Updated successfully for supplier: ' . $ven->supplier_name . ' Department ' . $ven->department . "\r\n";

            } catch (Exception $e) {
                echo "Data not Updated for supplier {$ven->supplier_name}. Error: {$e}" . "\r\n";
            }

        } catch (Exception $e) {
            echo "Message could not be sent for supplier {$ven->supplier_name} Department {$ven->department}. Mailer Error: {$mail->ErrorInfo}" . "\r\n";

            try {
                $updateQuery = "
                    UPDATE purchase_order 
                    SET sendmail = 1 
                    WHERE sendmail = 0 AND supplier_code = :supplier_code AND department = :department
                ";
                $updateStmt = $db->prepare($updateQuery);
                $updateStmt->execute(['supplier_code' => $ven->supplier_code, 'department' => $ven->department]);

                echo 'Data has been Updated successfully for supplier: ' . $ven->supplier_name . ' Department ' . $ven->department . "\r\n";

            } catch (Exception $e) {
                echo "Data not Updated for supplier {$ven->supplier_name}. Error: {$e}" . "\r\n";
            }
        }
    }
} else {
    echo 'Tidak Ada PO Baru' . "\r\n";
}
