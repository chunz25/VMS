<?php
include "config/config.php";
include "config/koneksiDB.php";

// URL tujuan ------------------------------------------------------------------------------
// $urlAPI = 'http://devecc.electronic-city.co.id:8000/sap/ws/vms/savers?sap-client=130';
// $urlAPI = 'http://10.140.3.2:8000/sap/ws/vms/savers?sap-client=130';
// $urlAPI = "http://$serverAPI/sap/ws/vms/savers?sap-client=130";
$urlAPI = $configUrlAPI["P090"];

// Jika butuh parameter dinamis ------------------------------------------------------------
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


foreach ($xx as $arr) 
	{ 
	$dataPOST = array
		(
			"header"=>array
				(
						
						"bukrs"=>$arr['company_code'], // company_code
						"prctr"=>"EC01400001", // profit center
						"lifnr"=>$arr['supplier_code'], // kode supplier
						"zterm"=>"V030", // payment term
						"rcdat"=>$arr['document_date'],  // tanggal receipt supplier
						"matwr"=>$arr['biaya_materai'], // biaya materai
						"waerk"=>"IDR", // mata uang
						"aenam"=>"vms_site"), // user create
					
			"item"=>array
					(
						array
						(
						"itmno"=>"1", // item nomor
						"sgtxt"=>$arr['no_invoice_supplier'], // nomor invoice supplier
						"trnty"=>"2001", // transaction type
						"netwr"=>$arr['grand_total'], // total amount
						"mwskz"=>"P8", // tax code, P8
						"taxwr"=>$arr['vat_amount'], // tax amount
						"xblnr"=>$arr['remark'], // remark
						"bktxt"=>$arr['no_faktur_pajak'], // no faktur pajak
						"fktdt"=>$arr['tgl_faktur_pajak'], // tanggal faktur
						"waerk"=>"IDR"
						)
					), // mata uang			
			"detail"=>array
					(
						array
						(
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

	// save JSON File --------------------------------------------------------------
	$folder=__DIR__."/data/in/";
	$file_in_name=$folder."INVR_".$tanggal."_".date("Ymd").".json";

	include "config/koneksiCURL.php";

	$jumRow++;
	}

}
echo "$jumRow Rows done .... \n";

unset($db1);
?>
