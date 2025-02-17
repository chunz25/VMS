<?php
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";

// URL tujuan --------------------------------------------------------------------------------
// $urlAPI = 'http://devecc.electronic-city.co.id:8000/sap/ws/zmst/mststore?sap-client=130';
// $urlAPI = 'http://10.140.3.2:8000/sap/ws/zmst/mststore?sap-client=130';
$urlAPI = $configUrlAPI["P010"];

// Jika butuh parameter dinamis --------------------------------------------------------------
$xx=array_key_exists("d",$_REQUEST);
if($xx){
$d=$_REQUEST["d"];}
else
{$d=date("Ymd");}

// message in body ----------------------------------------------
$dataPOST = array("site"=>"");

// Save JSON File ------------------------------------------------
$folder=__DIR__."/data/in/";
$file_in_name=$folder."STR"."_".$d."_".date("Ymd").".json";

include "config/koneksiCURL.php";
$dataResult=$responseData["data"];

$sqlInsert="insert
	into
	vms_gateway.store
	(
		code,
		name,
		name2,
		address,
		prctr
	)
VALUES
	( 
		?,
		?,
		?,
		?,
		?
	)
";
// eksekusi insert ---
foreach ($dataResult as $key1 => $value1) {		 
	   try
	   {
		   $insert = $db1->prepare($sqlInsert);
		   $insertValue=array_values($value1);
		   $insert->execute(array_values($value1)); 
	   } 
	   catch (PDOException $e) 
	   {
		   print "Err \t store \t no : \t ".$insertValue[0]." \t ". $e->getMessage() . "\n";
	   }
}

// masukkan ke vms_db ---------------------------------------------------	
	
	try
	{
	$sqlToVmsDb = "INSERT INTO vms_db.store SELECT * FROM vms_db.v_insert_store";
	$statement 	= $db1->prepare($sqlToVmsDb);
	$statement->execute();
	}
	catch (PDOException $e) 
	{		   
		    print "Err : $sqlToVmsDb --- " . $e->getMessage() . "<br/>\n";
	}

$insert=null;
$db1=null;
// echo "$key1 Rows done .... ";
/**/
// include "config/insertDB.php";
// var_dump($dataResult);
include "include/selesai.php";
?>
