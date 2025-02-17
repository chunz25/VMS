<?php

include "config/config.php";
include "config/koneksiDB.php";

// URL tujuan
// $urlAPI = 'http://devecc.electronic-city.co.id:8000/sap/ws/vms/payment?sap-client=130';
// $urlAPI = 'http://10.140.3.2:8000/sap/ws/vms/payment?sap-client=130';

$urlAPI = "http://$serverAPI/sap/ws/vms/payment?sap-client=130";

// Jika butuh parameter dinamis --------------------
$xx=array_key_exists("1",$argv);
$yy=array_key_exists("2",$argv);
if($xx){$jml_hari=$argv[1];}else{$jml_hari=1;}
if($yy){$tgl_mulai=$argv[2];}else{$tgl_mulai=date("Y-m-d");}

$datexx = date_create($tgl_mulai);

for($i=1;$i<=$jml_hari;$i++)
{
$tanggal= date_format($datexx, 'Y-m-d');
$tahun=date_format($datexx, 'Y');

$dataPOST = array(
    "invoice_no"=>"",
    "year"=>$tahun,
    "document_date"=>$tanggal,
    "supplier_code"=>""	
);

// reverse 1 day ----
date_modify($datexx, '-1 day');
	
// save JSON file ------	
$folder=__DIR__."/data/in/";
$file_in_name=$folder."PAYMENT_"."_".$tanggal."_".date("Ymd").".json";

include "config/koneksiCURL.php";
$dataResult=$responseData["header"];

// print_r($dataResult);
/* kalau mau tampilin --- */
// $arraySource=$dataResult;
// include "include/arrayToTabelHTML.php";

$sqlInsert="
insert 	
into 	
vms_gateway.payment
	(
	payment_no,
	company_code,
	supplier_code,
	document_date,
	payment_term,
	payment_type,
	payment_description,
	bank_account,
	bank_name,
	bank_branch_name,
	total_amount
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
	?
	)
";

$sqlInsertDetail="
insert		
	into	
	vms_gateway.payment_item	
(		
	payment_no,	
	line_item,	
	company_code,	
	store_code,	
	payment_flag,	
	purchase_order_no,	
	goods_receive_no,	
	reference_no,	
	debit_no,	
	sir_no,	
	remark,	
	payment_date,	
	payment_amount
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
	?	
)
";

// eksekusi insert ---
$insert1=array();
$insert2=array();
foreach ($dataResult as $key1 => $value1) {	
	   try
	   {			
			$insert1['payment_no'] = $value1['payment_no'] ; 
			$insert1['company_code'] = $value1['company_code'] ; 
			$insert1['supplier_code'] = $value1['supplier_code'] ; 
			$insert1['document_date'] = $value1['document_date'] ;  
			$insert1['payment_term'] = setNol($value1['payment_term']) ;  
			$insert1['payment_type'] = $value1['payment_type'] ;  
			$insert1['payment_description'] = $value1['payment_description'] ; 
			$insert1['bank_account'] = $value1['bank_account'] ; 
			$insert1['bank_name'] = $value1['bank_name'] ;  
			$insert1['bank_branch_name'] = $value1['bank_branch_name'] ; 
			$insert1['total_amount'] = setNol($value1['total_amount']) ;  	
		   
			$insertX = $db1->prepare($sqlInsert);
			$insertX->execute(array_values($insert1)); 
		   
			$insert2['payment_no'] = $value1['payment_no']; 			
			$insert2['line_item'] = $value1['line_item'];			
			$insert2['company_code'] = $value1['company_code']; 			
			$insert2['store_code'] = $value1['payment_no'];		
			$insert2['payment_flag'] = $value1['payment_flag'];			
			$insert2['purchase_order_no'] = $value1['purchase_order_no'];			
			$insert2['goods_receive_no'] = $value1['goods_receive_no']; 			
			$insert2['reference_no'] = $value1['reference_no']; 			
			$insert2['debit_no'] =  $value1['debit_no']; 			
			$insert2['sir_no'] = $value1['sir_no'];			
			$insert2['remark'] = $value1['remark'];			
			$insert2['payment_date'] = setNull($value1['payment_date']);			
			$insert2['payment_amount'] = setNol($value1['total_amount']);			   
					
			$insertX2 = $db1->prepare($sqlInsertDetail);
			$insertX2->execute(array_values($insert2));					     
		   
	   } catch (PDOException $e) {
		   // do something here
		    print "Error!: " . $e->getMessage() . "<br/> \n";
	   }
}
// clear var ---
unset($insert);
unset($insert2);
// unset($db1);
unset($dataResult);
unset($value1);
unset($key1);

echo "$tanggal Rows done .... \n";
}
unset($db1);
// include "config/insertDB.php";
// var_dump($dataResult);

?>
