<?php
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";

// URL tujuan --------------------------------------------------------------------------------
// $urlAPI = 'http://devecc.electronic-city.co.id:8000/sap/ws/zmst/mststore?sap-client=130';
// $urlAPI = 'http://10.140.3.2:8000/sap/ws/zmst/mststore?sap-client=130';
$urlAPI = $configUrlAPI["P085"];

// Jika butuh parameter dinamis --------------------------------------------------------------
$xx=array_key_exists("d",$_REQUEST);
if($xx){
$d=$_REQUEST["d"];}
else
{$d=date("Ymd");}


$sql = "SELECT a.rs_no_sap FROM vms_db.invoice_receipt a 
 WHERE  confirm_date is not null and rs_no_sap is not null and dnnum_sap is not null and park_date is null";
$xx=$db1->query($sql);


foreach ($xx as $arr) 
	{ 

// message in body ----------------------------------------------

/*
"{
    ""data"" : [
        {
        ""ZUONR"" : ""RS0001202307000039""
        }
    ]
}"
*/

$dataPOST = array(
				"data"=>array(
							array(
							"ZUONR"=>$arr["rs_no_sap"]
							)
						)
				);

// Save JSON File ------------------------------------------------
$folder=__DIR__."/data/in/";
$file_in_name=$folder."PARK"."_".$d."_".date("Ymd").".json";

include "config/koneksiCURL.php";
$dataResult=$responseData["data"];

$sqlUpdate="UPDATE vms_db.invoice_receipt SET park_date='".date("Y-m-d H:i:s")."' where rs_no_sap='".$arr["rs_no_sap"]."'" ;
// eksekusi insert ---
	 
	   try
	   {
		   // $valueUpdate=$value1["dnnum"];
		   $update = $db1->prepare($sqlUpdate);
		   // $updateValue=array_values($valueUpdate);
		   $update->execute(); 
	   } 
	   catch (PDOException $e) 
	   {
		   print "Err \t PARK \t no : \t ".$updateValue[0]." \t ". $e->getMessage() . "\n";
	   }


	}
$update=null;
$db1=null;
// echo "$key1 Rows done .... ";
/**/
// include "config/insertDB.php";
// var_dump($dataResult);
include "include/selesai.php";
?>