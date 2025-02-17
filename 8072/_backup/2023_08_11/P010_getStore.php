<?php
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
		address
	)
VALUES
	( 
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
		   $insert->execute(array_values($value1)); 
	   } 
	   catch (PDOException $e) 
	   {
		   print "Error!: " . $e->getMessage() . "<br/>\n";
	   }
}
$insert=null;
$db1=null;
echo "$key1 Rows done .... ";
/**/
// include "config/insertDB.php";
// var_dump($dataResult);
?>
