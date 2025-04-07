<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader and other required files
require 'librarysmtp/autoload.php';
require 'mail_form.php';

try {
    // Prepare query for dispute price data
    $grQuery = "
        SELECT * FROM vw_disputeprice
        WHERE proforma_invoice_no = :proforma_invoice_no
        ORDER BY CAST(line_item AS UNSIGNED)
    ";

    // Prepare the statement
    $grStmt = $db->prepare($grQuery);
    $grStmt->execute(['proforma_invoice_no' => $proforma_invoice_no]);

    // Initialize email body
    $body = '';
    $mccode = '';
    $no = 0;

    // Fetch data for the email body using foreach
    $results = $grStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $arr) {
        $no++;
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
        $mccode = $arr['dept'];  // Keep track of the last 'dept' value
    }

    // Prepare query to fetch user email addresses
    $usertoQuery = "
        SELECT a.email 
        FROM email a
        LEFT JOIN tb_user b ON b.username = a.username
        WHERE a.tb_id_user_type IN (2) 
          AND CONCAT(COALESCE(b.lock1, ''), COALESCE(b.lock2, ''), COALESCE(b.lock3, '')) 
          LIKE CONCAT('%', LEFT(:mccode, 3), '%')
    ";

    // Prepare and execute statement for user emails
    $usertoStmt = $db->prepare($usertoQuery);
    $usertoStmt->execute(['mccode' => $mccode]);

    // Fetch email addresses for recipients
    $usertoEmails = $usertoStmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host = $host;         // SMTP server hostname
    $mail->SMTPAuth = true;
    $mail->Username = $username;     // SMTP username
    $mail->Password = $password;     // SMTP password
    $mail->SMTPSecure = 'SSL';  // Use SSL encryption
    $mail->Port = 25;  // Set the correct SMTP port          // TCP port for SSL

    // Set sender email address
    $mail->setFrom($username, 'VMSMail');

    // Add recipients from the fetched email addresses
    foreach ($usertoEmails as $email) {
        $mail->addAddress($email['email']);
    }

    // Add BCC
    $mail->addBCC($username);

    // Set email format to HTML
    $mail->isHTML(true);
    $mail->Subject = 'VMS: Dispute Price ' . htmlspecialchars($proforma_invoice_no);
    $mail->Body = '
        <p>Dear Bapak/Ibu,</p>
        <p>FYI, berikut list Request Dispute Price pada proses invoice yang diajukan oleh vendor di Vendor Management System ECI:</p>
        <table border="1" cellpadding="0" cellspacing="0" width="100%">
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
                <th>Note Cancel</th>
            </tr>' . $body . '
        </table>
        <p>Mohon untuk segera diproses.</p>
        <p><a href="https://vmsdev.electronic-city.biz/">Vendor Management System</a></p>';

    // Send email
    $mail->send();
    echo 'Success';
} catch (Exception $e) {
    echo "Email failed to send. Mailer Error: {$mail->ErrorInfo}";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
