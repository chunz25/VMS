<?php
// ini_set('display_errors',0);
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";


// URL tujuan

// $urlAPI = 'http://devecc.electronic-city.co.id:8000/sap/ws/vms/invoice?sap-client=130'; 
// $urlAPI = 'http://10.140.3.2:8000/sap/ws/vms/invoice?sap-client=130';
// $urlAPI = "http://$serverAPI/sap/ws/vms/invoice?sap-client=130";
$urlAPI = $configUrlAPI["P070"];


// Jika butuh parameter dinamis


$xx=array_key_exists("1",$argv);
$yy=array_key_exists("2",$argv);
if($xx){$jml_hari=$argv[1];}else{$jml_hari=1;}
if($yy){$tgl_mulai=$argv[2];}else{$tgl_mulai=date("Y-m-d");}

$datexx = date_create($tgl_mulai);

for($i=1;$i<=$jml_hari;$i++)
{

// 
$tanggal= date_format($datexx, 'Y-m-d');
$tahun=date_format($datexx, 'Y');

// POST Body content ---
$dataPOST = array(
	"invoice_no" => "",
    "year" => "",
    "document_date" => $tanggal,
    "supplier_code" => ""
);

// reserve 1 day ----
date_modify($datexx, '-1 day');


// folder to save json file
$folder=__DIR__."/data/in/";
$file_in_name=$folder."INVSAP_".$tanggal."_".date("Ymd").".json";

// CURL connection ---
include "config/koneksiCURL.php";
$dataResult=$responseData["data"];

/* kalau mau tampilin --- */
$arraySource=$dataResult;
//  print_r($responseData);
// include "include/arrayToTabelHTML.php";



$sqlInsert="
			insert
			into
				vms_gateway.invoice_information
			(
				`type`,
				goods_receive_no,
				invoice_no,
				purchase_order_no,
				reference_no,
				company_code,
				store_code,
				supplier_code,
				document_date,
				posting_date,
				due_date,
				payment_date,
				status,
				amount
			)
			values
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
				?
				
			)
			";


// eksekusi insert ---
foreach ($dataResult as $key1 => $value1) {
	
	   try
	   {		
		   $value1['doc_type']="PO";
		   $insert = $db1->prepare($sqlInsert);
		   $insert->execute(array_values($value1)); 
		   
	   } catch (PDOException $e) {
		   // do something here
		    print "Error! invoice_information : " . $e->getMessage() . "<br/>\n";
	   }

}

// masukkan ke vms_db ---------------------------------------------------	
	
	try
	{
	$sqlToVmsDb = "call vms_db.insert_invoice_information_sp()";
	$statement 	= $db1->prepare($sqlToVmsDb);
	$statement->execute();
	}
	catch (PDOException $e) 
	{		   
		    print "Error!: $sqlToVmsDb --- " . $e->getMessage() . "<br/>\n";
	}
	


echo "$tanggal $key1 Rows done .... \n";

unset($insert);

// unset($db1);
unset($dataResult);

unset($value1);

unset($key1);




}
unset($db1);

include "include/selesai.php";
?>
