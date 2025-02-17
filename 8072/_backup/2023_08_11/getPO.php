<?php
// ini_set('display_errors',0);

include "config/config.php";
include "config/koneksiDB.php";

// URL tujuan
// $urlAPI = 'http://devecc.electronic-city.co.id:8000/sap/ws/vms/po?sap-client=130';
// $urlAPI = 'http://10.140.3.2:8000/sap/ws/vms/po?sap-client=130';
$urlAPI = "http://$serverAPI/sap/ws/vms/po?sap-client=130";

// Jika butuh parameter dinamis ----------------
$xx=array_key_exists("1",$argv);
$yy=array_key_exists("2",$argv);
if($xx){$jml_hari=$argv[1];}else{$jml_hari=1;}
if($yy){$tgl_mulai=$argv[2];}else{$tgl_mulai=date("Y-m-d");}

$datexx = date_create($tgl_mulai);

for($i=1;$i<=$jml_hari;$i++)
{
$tanggal= date_format($datexx, 'Y-m-d');
	
$dataPOST = array(
    "purchase_order_no"=>"",
    "supplier_code"=>"",
    "document_date"=>$tanggal
);

date_modify($datexx, '-1 day');
	
$folder=__DIR__."/data/in/";
$file_in_name=$folder."PO_"."_".$tanggal."_".date("Ymd").".json";

include "config/koneksiCURL.php";
$dataResult=$responseData["header"];

// print_r($dataResult);
/* kalau mau tampilin --- */
// $arraySource=$dataResult;
// include "include/arrayToTabelHTML.php";

$sqlInsert="
insert
into
	vms_gateway.purchase_order
(
	purchase_order_no,
	company_code,
	store_code,
	supplier_code,
	document_date,
	delivery_date,
	order_type,
	category_code,
	category_sub_code,
	total_quantity,
	total_amount,
	total_vat_amount,
	grand_total,
	pk_header
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

$sqlInsertDetail="
insert
into
	vms_gateway.purchase_order_item
(
	purchase_order_no,
	line_item,
	category_code,
	category_sub_code,
	product_code,
	barcode,
	description,
	uom,
	conversion_value,
	unit,
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
			
			// initial data header -----
			$value1["total_quantity"]=setNol($value1["total_quantity"]);
			$value1["total_amount"]=setNol($value1["total_amount"]);
			$value1["total_vat_amount"]=setNol($value1["total_vat_amount"]);
			$value1["grand_total"]=setNol($value1["grand_total"]);
			$value1["pk_header"]=$value1["purchase_order_no"];
			
			// insert to db -----
			$insert = $db1->prepare($sqlInsert);
			$insert->execute(array_values($value1)); 
			
			// detail item -------
		   foreach ($dataResult2 as $key2 => $value2)
		   {
			   try
				{
					// initial data item -----------------------------------------------
					$value2["uom"]=setNol($value2["uom"]);
					$value2["conversion_value"]=setNol($value2["conversion_value"]);
					$value2["unit_price"]=setNol($value2["unit_price"]);
					$value2["quantity"]=setNol($value2["quantity"]);
					$value2["amount"]=setNol($value2["amount"]);
					$value2["tax_pct"]=setNol($value2["tax_pct"]);
					$value2["vat_amount"]=setNol($value2["vat_amount"]);
					$value2["amount_after_tax"]=setNol($value2["amount_after_tax"]);
					// insert to db ----------------------------------------------------
					$insert2 = $db1->prepare($sqlInsertDetail);
					$insert2->execute(array_values($value2));
				} 
				catch (PDOException $e) 
				{
				   print "Error!: " . $e->getMessage() . "<br/>\n";
				}
		   }  		   
	   } catch (PDOException $e){
		   // do something here
		    print "Error!: " . $e->getMessage() . "<br/> \n";
	   }
}
unset($insert);
unset($insert2);
unset($dataResult);
unset($dataResult2);
unset($value1);
unset($value2);
unset($key1);
unset($key2);
echo "$tanggal Rows done .... \n";
}
unset($db1);
// include "config/insertDB.php";
// var_dump($dataResult);
?>
