<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
//2. koneksi database load --------------
include "conn/config.php";
// $db->debug=true;
require 'librarysmtp/autoload.php';
require 'mail_form.php';

$supp = "
        SELECT DISTINCT a.supplier_code, a.supplier_name, c.email
        FROM goods_receive a
        left join tb_user c on c.supplier_code = a.supplier_code
        WHERE sendmail= 0 
        ORDER BY goods_receive_no
        ";
$supp = $db->query($supp);

var_dump($supp->fetch(PDO::FETCH_OBJ));die;

while ($ven = $supp->fetch(PDO::FETCH_OBJ)) {
    // $no++;
    $po = "
            SELECT * FROM vw_grmail
            WHERE supplier_code = '" . $ven->supplier_code . "' 
            ORDER BY goods_receive_no
            ";
    $po = $db->query($po);

    while ($arr = $po->fetch(PDO::FETCH_OBJ)) {
        // $no++;
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
                <td>' . $arr->qty_received . '</td>
                </tr>            
                    ';
    }

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $host;                     //hostname/domain yang dipergunakan untuk setting smtp
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $username;                     //SMTP username
        $mail->Password   = $password;                               //SMTP password
        $mail->SMTPSecure = 'SSL';            //Enable implicit TLS encryption
        $mail->Port       = 25;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($username, 'VMSMail');
        $userto = "
                SELECT * FROM email WHERE tb_id_user_type IN (5) and username = " . $ven->supplier_code;
        $userto = $db->query($userto);

        while ($a = $userto->fetch(PDO::FETCH_OBJ)) {
            $mail->addAddress($a->email);
        }

        //Content
        $mail->addBCC($username);
        $mail->isHTML(true);
        $mail->Subject = 'VMS: New GR ' . $ven->supplier_name;
        $mail->Body    = '
                        <p>Dear bapak/ibu </p>
                        <p> FYI , Berikut list PO yang sudah di receipt oleh logistik ECI di Vendor Management System ECI :</p>
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

        $body = '';

        $send = "
        UPDATE goods_receive SET sendmail = 1 WHERE sendmail = 0 and supplier_code = '" . $ven->supplier_code . "'
    ";
        $db->query($send);

        echo 'Message has been sent' . "\r\n";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}" . "\r\n";
    }
}
