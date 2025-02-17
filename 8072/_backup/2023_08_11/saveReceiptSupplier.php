<?php
// ini_set('display_errors',0);

include "config/config.php";
include "config/koneksiDB.php";

/*
viewrs
http://devecc.electronic-city.co.id:8000/sap/ws/vms/viewrs?sap-client=130
{
    "zuonr" : "RS1000000000903219",
    "date" : ""
}


*/


// URL tujuan

// $urlAPI = 'http://devecc.electronic-city.co.id:8000/sap/ws/vms/savers?sap-client=130';
$urlAPI = 'http://10.140.3.2:8000/sap/ws/vms/savers?sap-client=130';

// Jika butuh parameter dinamis
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
$jumRow=0;

$sql = "SELECT a.*,year(a.document_date) as year_doc FROM vms_db.invoice_receipt a WHERE (isIntegrated=0 or isIntegrated is null) and confirm_date is not null";
$xx=$db1->query($sql);

// $reqtype="PUT";
// var_dump($xx);
// die();

/*
"zuonr"=>$arr['invoice_receipt_no'],  // no receipt supplier
 "bukrs" : "EC01",
        "prctr" : "EC01400001",
        "lifnr" : "300661",
        "zterm" : "",
        "rcdat" : "2023-07-21",
        "matwr" : "10000",
        "waerk" : "IDR",
        "aenam" : "USER01"
		
		 "itmno" : "1",
            "sgtxt" : "TEST ITEM1",
            "trnty" : "2001",
            "netwr" : "10000",
            "mwskz" : "P1",
            "taxwr" : "1",
            "xblnr" : "1000",
            "bktxt" : "1234567890",
            "fktdt" : "2023-07-24",
            "waerk" : "IDR"
			
			
			"itmno" :  "1",
            "detno" :  "1",
            "rnnum" :  "",
            "ebeln" :  "8500111142",
            "dnnum" :  "2400015647",
            "coniv" :  "",
            "congi" :  "",
            "mwskz" :  "",
            "sapdocno" :  "5000000132",
            "sapdocitem" :  "1",
            "sapdocyear" :  "2023"
			
			['purchase_order_no'];?
		
		*/

foreach ($xx as $arr) { 
$dataPOST = array(
		"header"=>array(
					
					"bukrs"=>$arr['company_code'], // company_code
					"prctr"=>"EC01400001", // profit center
					"lifnr"=>$arr['supplier_code'], // kode supplier
					"zterm"=>"V030", // payment term
					"rcdat"=>$arr['document_date'],  // tanggal receipt supplier
					"matwr"=>$arr['biaya_materai'], // biaya materai
					"waerk"=>"IDR", // mata uang
					"aenam"=>"Helmizz"), // user create
				
		"item"=>array(
								array(
								"itmno"=>"1", // item nomor
								"sgtxt"=>$arr['no_invoice_supplier'], // nomor invoice supplier
								"trnty"=>"2001", // transaction type
								"netwr"=>$arr['grand_total'], // total amount
								"mwskz"=>"P8", // tax code, P8
								"taxwr"=>$arr['vat_amount'], // tax amount
								"xblnr"=>$arr['remark'], // remark
								"bktxt"=>$arr['no_faktur_pajak'], // no faktur pajak
								"fktdt"=>$arr['tgl_faktur_pajak'], // tanggal faktur
								"waerk"=>"IDR")
								), // mata uang
							
								"detail"=>array(
											array(
											"itmno"=> "1", // item no
											"detno"=> "1", // detail no
											"rnnum"=> $arr['goods_receive_no'], // no Good receive ( RN )
											"ebeln"=> $arr['purchase_order_no'], // no PO
											"dnnum"=> "", // DN No.
											"coniv"=> "", // invoice consignment
											"congi"=> "", // GI Invoice
											"mwskz"=> "", // tax code
											"sapdocno"=> "", // SAP doc no 
											"sapdocitem"=> "1", // sap item doc no
											"sapdocyear"=> $arr['year_doc'] // sap doc year
											)
										)
									
									
		
						
				);

$folder=__DIR__."/data/in/";
$file_in_name=$folder."INVR_".$tanggal."_".date("Ymd").".json";

include "config/koneksiCURL.php";
 print_r($jsonData);
// var_dump($responseData);
// $dataResult=$responseData["header"];

/* kalau mau tampilin --- */
// $arraySource=$dataResult;
 // print_r($dataResult);
// include "include/arrayToTabelHTML.php";
$jumRow++;
}



}

echo "$jumRow Rows done .... \n";



unset($db1);
?>
