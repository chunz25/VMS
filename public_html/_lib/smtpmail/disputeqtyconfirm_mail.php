<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'librarysmtp/autoload.php';
require 'mail_form.php';

// Get the goods_receive_no from the request
$goods_receive_no = $_REQUEST['main_id_key'];

// Initialize $body variable
$body = '';

// SQL query to retrieve dispute quantity data, using prepared statements to prevent SQL injection
$grQuery = "
    SELECT * FROM vw_disputeqty 
    WHERE goods_receive_no = :goods_receive_no
    ORDER BY CAST(line_item AS UNSIGNED)
";
$grStmt = $db->prepare($grQuery);
$grStmt->execute(['goods_receive_no' => $goods_receive_no]);

$suppliercode = '';
while ($arr = $grStmt->fetch(PDO::FETCH_ASSOC)) {
    $body .= '
        <tr>
            <td>' . htmlspecialchars($arr['purchase_order_no']) . '</td> 
            <td>' . htmlspecialchars($arr['goods_receive_no']) . '</td> 
            <td>' . htmlspecialchars($arr['store_code_item']) . ' - ' . htmlspecialchars($arr['store_desc_item']) . '</td>
            <td>' . htmlspecialchars($arr['supplier_code']) . '</td>
            <td>' . htmlspecialchars($arr['supplier_name']) . '</td>
            <td>' . htmlspecialchars($arr['document_date']) . '</td>
            <td>' . htmlspecialchars($arr['product_code']) . '</td>
            <td>' . htmlspecialchars($arr['description']) . '</td>
            <td>' . htmlspecialchars($arr['unit']) . '</td>
            <td>' . htmlspecialchars($arr['po_quantity']) . '</td>
            <td>' . htmlspecialchars($arr['qty_ori']) . '</td>
            <td>' . htmlspecialchars($arr['qty_finish']) . '</td>
        </tr>';
    $suppliercode = htmlspecialchars($arr['supplier_code']);
}

// Create an instance of PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                        // Send using SMTP
    $mail->Host = $host;                              // SMTP host
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $username;                          // SMTP username
    $mail->Password = $password;                          // SMTP password
    $mail->SMTPSecure = 'SSL';  // Use SSL encryption
    $mail->Port = 25;  // Set the correct SMTP port                       

    // Recipients
    $mail->setFrom($username, 'VMSMail');

    // Query to fetch recipient email addresses
    $usertoQuery = "
        SELECT * FROM email WHERE tb_id_user_type IN (5) AND username = :suppliercode
    ";
    $usertoStmt = $db->prepare($usertoQuery);
    $usertoStmt->execute(['suppliercode' => $suppliercode]);

    while ($a = $usertoStmt->fetch(PDO::FETCH_ASSOC)) {
        $mail->addAddress($a['email']);
    }

    // Content
    $mail->addBCC($username);
    $mail->isHTML(true);                                   // Set email format to HTML
    $mail->Subject = 'VMS: Confirm Dispute QTY ' . htmlspecialchars($goods_receive_no);
    $mail->Body = '
        <p>Dear Bapak/Ibu,</p>
        <p>FYI, berikut list Approved atas Request Dispute Qty pada Proses Invoice yang diajukan oleh tim Anda di Vendor Management System ECI:</p>
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
                <th>Qty Revisi</th>
            </tr>' . $body . '</table>
        <p>Mohon untuk segera diproses.</p>
        <p><a href="https://vmsdev.electronic-city.biz/">Vendor Management System ECI</a></p>';

    // Send email
    $mail->send();
    echo 'success';
} catch (Exception $e) {
    echo "Email failed to send. Error: {$mail->ErrorInfo}";
}