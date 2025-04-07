<?php
// data PO Header -------------
$sqld1 = "SELECT password pwd FROM tb_user where username= '" . $_SESSION['username'] . "'";
$rs1 = $db->Execute($sqld1);
$pwd_old_db = $rs1->fields['pwd'];

if ($_REQUEST['pwd_old'] == '' || $_REQUEST['pwd_new'] == '' || $_REQUEST['pwd_new2'] == '') {
	$status = "Harap Isi semua field";
} else if ($pwd_old_db != md5($_REQUEST['pwd_old'])) {
	$status = "Password Lama Salah... !"; //.$pwd_old_db." === ".md5($_REQUEST['pwd_old']);
} else if ($_REQUEST['pwd_new'] != $_REQUEST['pwd_new2']) {
	$status = "Password Baru dan Retype password tidak sama... !";
} else {
	$sqld2 = "UPDATE tb_user SET password='" . md5($_REQUEST['pwd_new']) . "' where username= '" . $_SESSION['username'] . "'";
	if ($rs2 = $db->Execute($sqld2)) {
		$status = "success";
	} else {
		$status = "Gagal Ubah Password...!";
	}
}


echo $status;
