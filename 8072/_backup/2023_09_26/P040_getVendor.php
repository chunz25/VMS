<?php
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";

// URL tujuan ------------------------------------------------------------------------------
// $urlAPI = 'http://devecc.electronic-city.co.id:8000/sap/ws/zmst/mstvndr?sap-client=130';
// $urlAPI = 'http://10.140.3.2:8000/sap/ws/zmst/mstvndr?sap-client=130';
// $urlAPI = "http://$serverAPI/sap/ws/zmst/mstvndr?sap-client=130";
$urlAPI = $configUrlAPI["P040"];
// Jika butuh parameter dinamis --------------------------------------------

$xx=array_key_exists("d",$_REQUEST);
if($xx){
$d=$_REQUEST["d"];}
else
{$d="20230710";}

$dataPOST = array(
    "supplier_code"=>"",
    "company_code"=>"EC01"
);

// Save JSON File -------------------------------------------------
$folder=__DIR__."/data/in/";
$file_in_name=$folder."VND"."_".$d."_".date("Ymd").".json";

include "config/koneksiCURL.php";
$dataResult=$responseData["data"];

/* kalau mau tampilin ---
 $arraySource=$dataResult;
 include "include/arrayToTabelHTML.php";
*/

$sqlInsert="insert
into
vms_gateway.supplier
(
	supplier_code,
	company_code,
	name,
	address1,
	address2,
	city,
	postal_code,
	contact_person,
	phone,
	hp1,
	hp2,
	fax,
	npwp,
	email,
	payment_term,
	bank_code,
	bank_name,
	bank_branch_code,
	bank_branch_name,
	bank_account_no,
	active,
	payment_term_cd
	)
VALUES
	( 
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?
)
";
// eksekusi insert ----------------------------------------------------------------------
foreach ($dataResult as $key1 => $value1) {
	if($value1["status"]=="" || $value1["status"]==NULL ){ $value1["status"]=0;}  		 
	   try
	   {
		   $insert = $db1->prepare($sqlInsert);
		   $insert->execute(array_values($value1)); 
	   } 
	   catch (PDOException $e) 
	   {
		   print "Error!: supplier " . $e->getMessage() . "<br/>\n";
	   }
}

// masukkan ke vms_db ---------------------------------------------------	
	
	try
	{
	$sqlToVmsDb = "call vms_db.insert_supplier_sp()";
	$statement 	= $db1->prepare($sqlToVmsDb);
	$statement->execute();
	}
	catch (PDOException $e) 
	{		   
		    print "Error!: $sqlToVmsDb --- " . $e->getMessage() . "<br/>\n";
	}
	
$insert=null;
$db1=null;
echo "$key1 Rows done .... ";
/**/
// include "config/insertDB.php";
// var_dump($dataResult);
include "include/selesai.php";
?>
