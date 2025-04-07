<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader and other required files
require 'librarysmtp/autoload.php';
require 'mail_form.php';

// Initialize variables
$body = '';
$suppliercode = '';

// Query to get dispute price data
$grQuery = "
    SELECT * FROM vw_disputeprice
    WHERE proforma_invoice_no = :proforma_invoice_no
    ORDER BY CAST(line_item AS UNSIGNED)
";

// Prepare and execute the query with a prepared statement to prevent SQL injection
$grStmt = $db->prepare($grQuery);
$grStmt->execute(['proforma_invoice_no' => $proforma_invoice_no]);

// Fetch rows and build email body content
while ($arr = $grStmt->fetch(PDO::FETCH_ASSOC)) {
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
    $suppliercode = htmlspecialchars($arr['supplier_code']); // Sanitize supplier code
}

// Create an instance of PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP(); // Send using SMTP
    $mail->Host = $host; // SMTP host
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = $username; // SMTP username
    $mail->Password = $password; // SMTP password
    $mail->SMTPSecure = 'SSL';  // Use SSL encryption
    $mail->Port = 25;  // Set the correct SMTP port // TCP port for TLS (use 465 for SSL)

    // Set sender's email address and name
    $mail->setFrom($username, 'VMSMail');

    // Query to get the supplier's email address
    $emailQuery = "
        SELECT * FROM email 
        WHERE tb_id_user_type = 5 
        AND username = :suppliercode
    ";

    // Prepare and execute the query to fetch email addresses
    $emailStmt = $db->prepare($emailQuery);
    $emailStmt->execute(['suppliercode' => $suppliercode]);

    // Add recipients
    while ($a = $emailStmt->fetch(PDO::FETCH_ASSOC)) {
        $mail->addAddress($a['email']);
    }

    // Add BCC
    $mail->addBCC($username);

    // Set email content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'VMS: Dispute Price ' . htmlspecialchars($proforma_invoice_no);
    $mail->Body = '
        <p>Dear Bapak/Ibu,</p>
        <p>FYI, Berikut adalah list Reject atas Dispute Settlement Price pada Proses Invoice yang diajukan oleh tim anda di Vendor Management System ECI:</p>
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
                <th>Note Reject</th>
            </tr>' . $body . '</table>
        <p>Mohon untuk segera diproses.</p>
        <p><a href="https://vmsdev.electronic-city.biz/">Vendor Management System</a></p>';

    // Send the email
    $mail->send();
    echo 'success';
} catch (Exception $e) {
    echo "Email failed to send. Mailer Error: {$mail->ErrorInfo}";
}
