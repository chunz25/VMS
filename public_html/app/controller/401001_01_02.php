<?php
// $db->debug=true;
$sql4004020102 = "CALL buyer_settlement_price_sp('" . $_REQUEST["main_id_key"] . "')";
$rs = $db->Execute($sql4004020102);

// var_dump($rs);die;
if ($rs) {
    include $address_file_configs . "_lib/smtpmail/disputepriceconfirm_mail.php";
} else {
    echo "failed";
};
//if($rs){print_r($data_header);} else {echo "failed";};
