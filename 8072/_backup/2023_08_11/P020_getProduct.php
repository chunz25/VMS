<?php
include "config/config.php";
include "config/koneksiDB.php";

// URL tujuan --------------------------------------------------------------------------------
// $urlAPI = 'http://devecc.electronic-city.co.id:8000/sap/ws/zmst/mststore?sap-client=130';
// $urlAPI = 'http://10.140.3.2:8000/sap/ws/zmst/mststore?sap-client=130';
// $urlAPI = "http://$serverAPI/sap/ws/zmst/mstarticle?sap-client=400";
$urlAPI = $configUrlAPI["P020"];

// Jika butuh parameter dinamis --------------------------------------------------------------
$xx=array_key_exists("d",$_REQUEST);
if($xx){
$d=$_REQUEST["d"];}
else
{$d=date("Ymd");}

// message in body ----------------------------------------------
$dataPOST = array("product_code"=>"");

// Save JSON File ------------------------------------------------
$folder=__DIR__."/data/in/";
$file_in_name=$folder."PROD"."_".$d."_".date("Ymd").".json";

include "config/koneksiCURL.php";
$dataResult=$responseData["data"];

$sqlInsert="INSERT INTO vms_gateway.product
(product_code, barcode, description, brand, dimension, uom, active, insert_date)
VALUES(?, ?, ?, ?, ?, ?, ?, current_timestamp());
";


// eksekusi insert ---
foreach ($dataResult as $key1 => $value1) {		 
	   try
	   {
		   $value1["active"]=1;
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
