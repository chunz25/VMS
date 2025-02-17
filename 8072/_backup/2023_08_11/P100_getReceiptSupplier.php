<?php
// ini_set('display_errors',0);

include "config/config.php";
include "config/koneksiDB.php";

// URL tujuan
// $urlAPI = 'http://devecc.electronic-city.co.id:8000/sap/ws/vms/viewrs?sap-client=130';
// $urlAPI = 'http://10.140.3.2:8000/sap/ws/vms/viewrs?sap-client=130';
$urlAPI = $configUrlAPI["P100"];


// Jika butuh parameter dinamis
$xx=array_key_exists("1",$argv);
$yy=array_key_exists("2",$argv);
if($xx){$jml_hari=$argv[1];}else{$jml_hari=1;}
if($yy){$tgl_mulai=$argv[2];}else{$tgl_mulai=date("Y-m-d");}

$datexx = date_create($tgl_mulai);

for($i=1;$i<=$jml_hari;$i++)
{

date_modify($datexx, '-1 day');
$tanggal= date_format($datexx, 'Y-m-d');
$tahun=date_format($datexx, 'Y');



$dataPOST = array(
    "goods_receive_no"=>"",
    "year"=>$tahun,
    "supplier_code"=>"",
    "posting_date"=>$tanggal,
    "purchase_order_no"=>""
);

$folder=__DIR__."/data/in/";
$file_in_name=$folder."RS_".$tanggal."_".date("Ymd").".json";

include "config/koneksiCURL.php";
$dataResult=$responseData["header"];

/* kalau mau tampilin --- */
 $arraySource=$dataResult;
 // print_r($dataResult);
// include "include/arrayToTabelHTML.php";



$sqlInsert="
insert
into
	vms_gateway.goods_receive
(
	purchase_order_no,
	goods_receive_no,
	company_code,
	store_code,
	supplier_code,
	document_date,
	trade_type,
	total_quantity,
	total_amount,
	vat_amount,
	grand_total
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
	?
)
";

$sqlInsertDetail="
insert
into
	vms_gateway.goods_receive_item
(
	goods_receive_no,
	line_item,
	product_code,
	barcode,
	description,
	uom,
	unit,
	conversion_value,
	po_quantity,
	quantity,
	unit_price,
	amount,
	tax_pct,
	vat_amount,
	amount_after_tax
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
	?,
	?
)
";

// eksekusi insert ---
foreach ($dataResult as $key1 => $value1) {
	
	   try
	   {
		   $dataResult2=$value1["item"];
		   unset($value1["item"]);
		   
			$value1["total_quantity"]=setNol($value1["total_quantity"]);
			$value1["total_amount"]=setNol($value1["total_amount"]);
			$value1["vat_amount"]=setNol($value1["vat_amount"]);
			$value1["grand_total"]=setNol($value1["grand_total"]);
		   
		   $insert = $db1->prepare($sqlInsert);
		   $insert->execute(array_values($value1)); 
		   
		   foreach ($dataResult2 as $key2 => $value2)
		   {
			   try
				{					
					$value2["uom"]=setNol($value2["uom"]);
					$value2["conversion_value"]=setNol($value2["conversion_value"]);
					$value2["unit_price"]=setNol($value2["unit_price"]);
					$value2["quantity"]=setNol($value2["quantity"]);
					$value2["po_quantity"]=setNol($value2["po_quantity"]);
					$value2["amount"]=setNol($value2["amount"]);
					$value2["tax_pct"]=setNol($value2["tax_pct"]);
					$value2["vat_amount"]=setNol($value2["vat_amount"]);
					$value2["amount_after_tax"]=setNol($value2["amount_after_tax"]);					
					$insert2 = $db1->prepare($sqlInsertDetail);
					$insert2->execute(array_values($value2));
				} 
				catch (PDOException $e) 
				{
				  print "Error Insert Item !: " . $e->getMessage() . "<br/>\n";
				}
		   }  
		   
	   } catch (PDOException $e) {
		   // do something here
		    print "Error! Insert Header : " . $e->getMessage() . "<br/>\n";
	   }

}

echo "$tanggal $key1 Rows done .... \n";

unset($insert);
unset($insert2);
// unset($db1);
unset($dataResult);
unset($dataResult2);
unset($value1);
unset($value2);
unset($key1);
unset($key2);



}
unset($db1);
?>
