<?php
// ini_set('display_errors',0);

include "config/config.php";
include "config/koneksiDB.php";

// di vms_gateway ------------------------------------
$nama_tabel[]='vms_gateway.store';
$nama_tabel[]='vms_gateway.supplier';
$nama_tabel[]='vms_gateway.purchase_order';
$nama_tabel[]='vms_gateway.purchase_order_item';
$nama_tabel[]='vms_gateway.goods_receive';
$nama_tabel[]='vms_gateway.goods_receive_item';
$nama_tabel[]='vms_gateway.payment';
$nama_tabel[]='vms_gateway.payment_item';
$nama_tabel[]='vms_gateway.invoice_information';
$nama_tabel[]='vms_gateway.debit_note';
$nama_tabel[]='vms_gateway.debit_note_item';
$nama_tabel[]='vms_gateway.goods_return';
$nama_tabel[]='vms_gateway.goods_return_item';

// di vms_db ------------------------------------

$nama_tabel[]='vms_db.store';
$nama_tabel[]='vms_db.supplier';
$nama_tabel[]='vms_db.purchase_order';
$nama_tabel[]='vms_db.purchase_order_item';
$nama_tabel[]='vms_db.goods_receive';
$nama_tabel[]='vms_db.goods_receive_item';
$nama_tabel[]='vms_db.purchase_order_req_cancel';
$nama_tabel[]='vms_db.proforma_invoice';
$nama_tabel[]='vms_db.proforma_invoice_item';
$nama_tabel[]='vms_db.invoice';
$nama_tabel[]='vms_db.invoice_item';
$nama_tabel[]='vms_db.invoice_receipt';
$nama_tabel[]='vms_db.payment';
$nama_tabel[]='vms_db.payment_item';
$nama_tabel[]='vms_db.invoice_information';
$nama_tabel[]='vms_db.debit_note';
$nama_tabel[]='vms_db.debit_note_item';
$nama_tabel[]='vms_db.goods_return';
$nama_tabel[]='vms_db.goods_return_item';

foreach ($nama_tabel as $key1 => $value1)
{
	try
	{
	$sql = "TRUNCATE TABLE ".$value1;
	$statement = $db1->prepare($sql);
	$statement->execute();
	}
	catch (PDOException $e) 
	{		   
		    print "Error!: " . $e->getMessage() . "<br/>\n";
	}
	
}
$statement=null;
$db1=null;
echo "$key1 Rows done .... \n";
?>
