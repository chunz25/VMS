<?php
include "include/mulai.php";
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

$sql = "SELECT a.*,year(a.document_date) as year_doc,b.prctr as prctr FROM vms_db.invoice_receipt a 
LEFT JOIN vms_db.store b on a.store_code=b.code
 WHERE (isIntegrated=0 or isIntegrated is null) and confirm_date is not null and rs_no_sap is null and dnnum_sap is not null";
$xx=$db1->query($sql);


foreach ($xx as $arr) 
	{ 
	
	$sql2="select line_item from vms_db.invoice_item where invoice_no='".$arr['invoice_no']."'";
	$yy = $db1->query($sql2);
	
	$detno=1;
	foreach($yy as $arr2)
	{	
	$data_item[]=array
						(
						"itmno"=> "1", // item no
						"detno"=> $detno, // detail no
						"rnnum"=> "", // no Good receive ( RN )
						"ebeln"=> $arr['purchase_order_no'], // no PO
						"dnnum"=> $arr['dnnum_sap'], // DN No.
						"coniv"=> "", // invoice consignment
						"congi"=> "", // GI Invoice
						"mwskz"=> "", // tax code
						"sapdocno"=> $arr['goods_receive_no'], // SAP doc no di isi no RN
						"sapdocitem"=> $arr2["line_item"], // sap item doc no
						"sapdocyear"=> $arr['year_doc'] // sap doc year
						);
	$detno++;
	};
		
	$dataPOST = array
		(
			"header"=>array
				(
						
						"bukrs"=>$arr['company_code'], // company_code
						"prctr"=>$arr['prctr'], // profit center
						"lifnr"=>$arr['supplier_code'], // kode supplier
						"zterm"=>$arr['payment_term_cd'], // payment term code
						"rcdat"=>$arr['document_date'],  // tanggal receipt supplier
						"matwr"=>(int)$arr['biaya_materai'], // biaya materai
						"waerk"=>"IDR", // mata uang
						"aenam"=>$arr['user_confirm']), // user create
					
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
			"detail"=>$data_item
										
		);

	// save JSON File --------------------------------------------------------------
	$folder=__DIR__."/data/in/";
	$file_in_name=$folder."INVR_".$tanggal."_".date("Ymd").".json";

	include "config/koneksiCURL.php";
	
	if($responseData['rsno']!='')
	{
		$sql2="UPDATE vms_db.invoice_receipt SET rs_no_sap='".$responseData['rsno']."',integrasi_date='".date("Y-m-d H:i:s")."' WHERE invoice_receipt_no='".$arr['invoice_receipt_no']."' and goods_receive_no='".$arr['goods_receive_no']."'";
		$sqlToVmsDb = "INSERT INTO vms_db.store SELECT * FROM vms_db.v_insert_store";
		$statement 	= $db1->prepare($sql2);
		$statement->execute();
	}

	$jumRow++;
	}

}
// echo "$jumRow Rows done .... \n";
print_r($responseData);
unset($db1);
include "include/selesai.php";
?>
