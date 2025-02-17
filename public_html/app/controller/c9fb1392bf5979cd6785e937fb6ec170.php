<?php
session_start();
if(!$_SESSION['username']) 
	{
		$message_denied = "Session Expired , Please .....";
		header("Location: http://".$_SERVER["HTTP_HOST"]."/index.php?message_denied=".urlencode($message_denied));
	}
set_time_limit(0);
include_once('inc_condition.php');
require_once($address_file_configs."_lib/dbconn_new.php");
$db=initdb(1);
	//$db->debug=true;
$sql_060_00 = "select 
				'RK' as RK,
				'855869327022000' as NPWP,
				'PT. KARYA GUDANG RABAT' as NAMA,
				substr(tax_no,1,2) as KD_JENIS_TRANSAKSI,
				substr(tax_no,3,1) as FG_PENGGANTI,
				substr(tax_no,4) as NOMOR_FAKTUR,
				DATE_FORMAT(tax_date,'%d/%m/%Y') as TANGGAL_FAKTUR,
				document_no as NOMOR_DOKUMEN_RETUR,
				DATE_FORMAT(document_date,'%d/%m/%Y') as TANGGAL_RETUR,
				DATE_FORMAT(tax_date,'%m') as MASA_PAJAK_RETUR,
				DATE_FORMAT(tax_date,'%Y') as TAHUN_PAJAK_RETUR,
				total_amount as NILAI_RETUR_DPP,
				vat_amount as NILAI_RETUR_PPN,
				0 as NILAI_RETUR_PPNBM
				FROM goods_return_1_v 
				where cek_null_z is null and  year(document_date)>2018 and isIntegrated=1 and ( version = '2' ) and tax_no is not null and tax_date is not null and trim(tax_no)!='' ".$sql_400401_01." order by document_date";

$recordSet=$db->Execute($sql_060_00);

// redirect output to client browser
if($file_output_6==''){$file_output_6=$gg_main_id."_download_".date("Ymd_Hi").".csv";}
header('Content-Type: vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$file_output_6.'"');

$arr=$recordSet->GetArray();
//die();
$contentocsv="";
foreach ($arr as $key => $value) {	
	 if($key==0){
					// $contentocsv .= '"NOMOR';
						foreach ($value as $nama_field => $isi_field)
							{
							$nama_field=str_replace('"','""',$nama_field);
							// $contentocsv .='","'.  strtoupper($nama_field);						
							   $contentocsv .='"'.  strtoupper($nama_field) . '",';	
							}							
						$contentocsv=substr($contentocsv,0,-1)."\n";					
					//$contentocsv .= '"'."\n";
				}
	$nomernya=$key+1;
	// $contentocsv .='"'.$nomernya;
	foreach ($value as $nama_field => $isi_field) 
	{
		$isi_field=str_replace('"','""',$isi_field);
		// $contentocsv .= '","'.$isi_field;
		 $contentocsv .= '"'.$isi_field.'",';		
	}
	// $contentocsv .= '"'."\n";
	$contentocsv=substr($contentocsv,0,-1)."\n";
}
echo $contentocsv;
?>