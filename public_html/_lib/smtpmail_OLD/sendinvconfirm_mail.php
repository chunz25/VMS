<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'librarysmtp/autoload.php';
require 'mail_form.php';

// Prepare the SQL query with parameterized queries to prevent SQL injection
$gr_no = isset($gr_no) ? $gr_no : '';  // Ensure $gr_no is defined
if (empty($gr_no)) {
    echo json_encode(['status' => false, 'message' => 'Missing GR number.']);
    exit;
}

$grQuery = "
    SELECT * FROM vw_invoice
    WHERE goods_receive_no = ?
";
$grStmt = $db->prepare($grQuery);
$grStmt->execute([$gr_no]);

// Initialize variables
$body = '';
$suppliercode = '';
$inv = '';
$no = 0;  // Counter

while ($arr = $grStmt->FetchRow()) {
    $no++;
    $body .= '
        <tr>
            <td>' . htmlspecialchars($arr['purchase_order_no']) . '</td> 
            <td>' . htmlspecialchars($arr['goods_receive_no']) . '</td> 
            <td>' . htmlspecialchars($arr['store_code']) . '</td> 
            <td>' . htmlspecialchars($arr['supplier_code']) . '</td> 
            <td>' . htmlspecialchars($arr['supplier_name']) . '</td> 
            <td>' . htmlspecialchars($arr['amount']) . '</td> 
            <td>' . htmlspecialchars($arr['vat']) . '</td> 
            <td>' . htmlspecialchars($arr['totalamount']) . '</td> 
        </tr>';
    $suppliercode = htmlspecialchars($arr['supplier_code']);
    $inv = htmlspecialchars($arr['invoice']);
}

// Ensure we have a supplier code
if (empty($suppliercode)) {
    echo json_encode(['status' => false, 'message' => 'No supplier code found.']);
    exit;
}

// Create an instance of PHPMailer, passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host = $host;                                        // SMTP host
    $mail->SMTPAuth = true;                                     // Enable SMTP authentication
    $mail->Username = $username;                                // SMTP username
    $mail->Password = $password;                                // SMTP password
    $mail->SMTPSecure = 'SSL';            // Enable implicit TLS encryption
    $mail->Port = 25;                                          // Use port 465 for TLS

    // Set sender's email address and name
    $mail->setFrom($username, 'VMSMail');

    // Prepare SQL query to fetch email recipients
    $usertoQuery = "
        SELECT email FROM email 
        WHERE tb_id_user_type IN (5) AND username = ?
    ";
    $usertoStmt = $db->prepare($usertoQuery);
    $usertoStmt->execute([$suppliercode]);

    // Add recipient email addresses
    while ($a = $usertoStmt->FetchRow()) {
        $mail->addAddress($a['email']);
    }

    // Add BCC for the sender
    $mail->addBCC($username);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'VMS: Confirm Invoice ' . $inv;
    $mail->Body = '
        <p>Dear Bapak/Ibu,</p>
        <p>FYI, Berikut adalah list approved atas Receipt Supplier pada Proses Invoice yang diajukan oleh vendor di Vendor Management System ECI:</p>
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <tr>
                <th>Purchase Order</th>
                <th>GR Number</th>
                <th>Store</th>
                <th>Supplier Code</th>
                <th>Supplier Name</th>
                <th>Amount</th>
                <th>VAT</th>
                <th>Total Amount</th>
            </tr>' . $body . '</table>';

    // Send the email
    $mail->send();
    // echo json_encode(['status' => true, 'message' => 'Email sent successfully.']);
    echo 'success';
} catch (Exception $e) {
    // Log and return error message
    error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    echo json_encode(['status' => false, 'message' => 'Email could not be sent.']);
}
