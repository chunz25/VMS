<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader and other required files
require 'librarysmtp/autoload.php';
require 'mail_form.php';

// Get proforma_invoice_no from the request and sanitize it
$proforma_invoice_no = filter_input(INPUT_REQUEST, 'main_id_key', FILTER_SANITIZE_STRING);

if (!$proforma_invoice_no) {
    die('Invalid proforma invoice number.');
}

try {
    // Prepare query for dispute price data
    $grQuery = "
        SELECT * FROM vw_disputeprice
        WHERE proforma_invoice_no = :proforma_invoice_no
        ORDER BY CAST(line_item AS UNSIGNED)
    ";

    // Prepare and execute the query with a prepared statement
    $grStmt = $db->prepare($grQuery);
    $grStmt->execute(['proforma_invoice_no' => $proforma_invoice_no]);

    // Initialize body content and other variables
    $body = '';
    $suppliercode = '';

    // Fetch data for the email body
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
                <td>' . htmlspecialchars($arr['unit_price_finish']) . '</td> 
            </tr>';
        $suppliercode = $arr['supplier_code']; // Store supplier code for recipient query
    }

    if (empty($body)) {
        throw new Exception('No data found for the given proforma invoice number.');
    }

    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host = $host; // Hostname of the SMTP server
    $mail->SMTPAuth = true;  // Enable SMTP authentication
    $mail->Username = $username; // SMTP username
    $mail->Password = $password; // SMTP password
    $mail->SMTPSecure = 'SSL'; // Use TLS encryption
    $mail->Port = 25; // TCP port to connect to (use 465 if using SSL)

    // Set sender's email address and name
    $mail->setFrom($username, 'VMSMail');

    // Query to get email addresses for the supplier
    $usertoQuery = "
        SELECT email FROM email 
        WHERE tb_id_user_type = 5 
        AND username = :suppliercode
    ";
    $usertoStmt = $db->prepare($usertoQuery);
    $usertoStmt->execute(['suppliercode' => $suppliercode]);

    // Add email recipients
    while ($a = $usertoStmt->fetch(PDO::FETCH_ASSOC)) {
        $mail->addAddress($a['email']);
    }

    // Add BCC
    $mail->addBCC($username);

    // Set email content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'VMS: Confirm Dispute Price ' . htmlspecialchars($proforma_invoice_no);
    $mail->Body = '
        <p>Dear Bapak/Ibu,</p>
        <p>FYI, berikut list Approved atas Dispute Price pada proses Invoice yang diajukan oleh tim anda di Vendor Management System ECI:</p>
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
                <th>Unit Price Revisi</th>
            </tr>' . $body . '</table>
        <p>Mohon untuk segera diproses.</p>
        <p><a href="https://vmsdev.electronic-city.biz/">Vendor Management System</a></p>';

    // Send the email
    $mail->send();
    echo 'success';
} catch (Exception $e) {
    // Log the error message for debugging
    error_log("Email failed to send. Error: " . $e->getMessage());
    echo "Email failed to send. Please try again later.";
}
