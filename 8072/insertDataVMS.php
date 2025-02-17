<?php
// ini_set('display_errors',0);

include "config/config.php";
include "config/koneksiDB.php";


$sql[]='call vms_db.insert_supplier_sp()';
$sql[]='call vms_db.insert_purchase_order_sp()';
$sql[]='call vms_db.insert_goods_receive_sp()';


foreach ($sql as $key1 => $value1)
{
	try
	{
	$statement = $db1->prepare($value1);
	$statement->execute();
	}
	catch (PDOException $e) 
	{		   
		    print "Error!: " . $e->getMessage() . "<br/>\n";
	}
	
}
$statement=null;
$db1=null;
echo "$key1 Rows done .... ";
?>
