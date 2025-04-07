<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'librarysmtp/autoload.php';
require 'mail_form.php';

$sql = "
        SELECT * FROM vw_invoice
        WHERE goods_receive_no ='" . $gr_no . "'
    ";
$sql = $db->Execute($sql);

while ($arr = $sql->FetchRow()) {
    $no++;
    $body .= '
            <tr>
            <td>' . $arr['purchase_order_no'] . '</td> 
            <td>' . $arr['goods_receive_no'] . '</td> 
            <td>' . $arr['store_code'] . '</td> 
            <td>' . $arr['supplier_code'] . '</td> 
            <td>' . $arr['supplier_name'] . '</td> 
            <td>' . $arr['amount'] . '</td> 
            <td>' . $arr['vat'] . '</td> 
            <td>' . $arr['totalamount'] . '</td> 
            </tr>              
    ';
    $inv = $arr['invoice'];
}

//Create an instance; passing `true` enables exceptions
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
        SELECT * FROM email WHERE tb_id_user_type IN (3)
            ";
    $userto = $db->Execute($userto);

    while ($a = $userto->FetchRow()) {
        $mail->addAddress($a['email']);
    }

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'VMS: New Invoice ' . $inv;
    $mail->Body    = '
                    <p>Dear bapak/ibu </p>
                    <p>FYI , Berikut list Receipt Supplier pada Proses Invoice yang di ajukan oleh vendor di Vendor Management System ECI :</p>
                    <table border="1" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <th>Purchase Order</th>
                        <th>GR Number</th>
                        <th>Store</th>
                        <th>Supplier Code</th>
                        <th>Supplier Name</th>
                        <th>Amount</th>
                        <th>VAT</th>
                        <th>Total Amount</th>
                    </tr>' . $body . '</table>
                    <p> Mohon untuk segera di proses.</p>
                    <p> https://vmsdev.electronic-city.biz/</p>';
    $mail->send();
    // echo 'success';
} catch (Exception $e) {
    echo "failed";
}
