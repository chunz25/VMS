<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Load Composer's autoloader
require 'librarysmtp/autoload.php';
require 'mail_form.php';

// Initialize $body variable to prevent undefined variable warnings
$body = '';

// Get goods_receive_no from the request and sanitize it
$goods_receive_no = filter_input(INPUT_GET, 'goods_receive_no', FILTER_SANITIZE_STRING);

if (!$goods_receive_no) {
    die('Invalid goods receive number.');
}

try {
    // Query to retrieve dispute quantity data
    $grQuery = "
        SELECT * FROM vw_disputeqty
        WHERE goods_receive_no = :goods_receive_no
        ORDER BY CAST(line_item AS UNSIGNED)
    ";

    // Prepare and execute the query using prepared statements
    $grStmt = $db->prepare($grQuery);
    $grStmt->execute(['goods_receive_no' => $goods_receive_no]);

    $storecode = '';
    while ($arr = $grStmt->fetch(PDO::FETCH_ASSOC)) {
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

    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();                                        // Use SMTP
    $mail->Host = $host;                                   // SMTP host
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $username;                          // SMTP username
    $mail->Password = $password;                          // SMTP password
    $mail->SMTPSecure = 'SSL';  // Use SSL encryption
    $mail->Port = 25;  // Set the correct SMTP port                                   // TCP port for TLS (use 465 for SSL)

    // Set sender's email address and name
    $mail->setFrom($username, 'VMSMail');

    // Query to fetch email recipients
    $emailQuery = "
        SELECT email FROM email WHERE tb_id_user_type IN (8)
        UNION ALL
        SELECT a.email FROM email a 
        LEFT JOIN tb_user b ON b.username = a.username 
        WHERE a.tb_id_user_type IN (4) AND b.store_code = :storecode
    ";

    // Prepare and execute the query using prepared statements
    $emailStmt = $db->prepare($emailQuery);
    $emailStmt->execute(['storecode' => $storecode]);

    // Add recipients to the email
    while ($a = $emailStmt->fetch(PDO::FETCH_ASSOC)) {
        $mail->addAddress($a['email']);
    }

    // Add BCC
    $mail->addBCC($username);

    // Email content
    $mail->isHTML(true);                                   // Set email format to HTML
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
        <p><a href="https://vmsdev.electronic-city.biz/">Vendor Management System ECI</a></p>';

    // Send email
    $mail->send();
    echo 'success';
} catch (Exception $e) {
    // Log the error message for debugging
    error_log("Email failed to send. Error: " . $e->getMessage());
    echo "Email failed to send. Please try again later.";
}
