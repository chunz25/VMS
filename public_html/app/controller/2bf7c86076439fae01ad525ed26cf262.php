<?php
// CREDIT NOTE / NOTA RETURN  ========================================================================
if($pwdnya='730e85e6ce5a47b805e96bf133a8757b'){
	
	$_MAIN__CONFIGS_030[4]  = '"'.getcwd().'/_exec/db2json/configs.properties"'; // configs for exec jar file 
	$_MAIN__CONFIGS_030[5] 	= 'java -jar '.'"'.getcwd().'/_exec/db2json/db2json.jar"'.' -f '.$_MAIN__CONFIGS_030[4];

	$docnonya=$_REQUEST['docno'];
	
// data GRN Header -------------
	$sql001='"select * from goods_return where document_no='."'".$docnonya."'".' and version=2"';
	$exec_sql001=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql001);
	$json_exec_sql001=json_decode($exec_sql001,true);
	$data_header=$json_exec_sql001[rows][0];
	
	
	
	// data supplier -----------------
	$sql003='"select * from supplier where supplier_code='."'".$data_header["supplier_code"]."'".'"';
	$exec_sql003=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql003);
	$json_exec_sql003=json_decode($exec_sql003,true);
	$data_header_supplier=$json_exec_sql003[rows][0];
	
		
	// data item  -----------------
	$sql004='"select * from goods_return_item where backorder_flag='."'".$data_header["backorder_flag"]."'".' and goods_return_no='."'".$data_header["goods_return_no"]."'".'  and version=2 "';
	$exec_sql004=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql004);
	$json_exec_sql004=json_decode($exec_sql004,true);
	$data_item=$json_exec_sql004[rows];
	
	$no_fp = (abs($data_header['vat_amount'])>0) ? $data_header['tax_no'] : '0000000000000000'; 
	//$tax_date = $data_header['tax_date'];
	
	$datexx = date_create($data_header['tax_date']);
	$tax_date=date_format($datexx, 'd M Y');
	
	$dateyy=date_create($data_header['document_date']);
	$ttd_date=date_format($dateyy, 'd M Y');
	
?>
<html>
<head>
<meta content="text/html; charset=ISO-8859-1"
http-equiv="content-type">
<title></title>
</head>
<body>
<table border="1" cellpadding="2" cellspacing="0" >
	<tr>
		<td style="vertical-align: middle; text-align: center; width: 90px;"> 
		<img src="_images/logo_goro_s.png" style="width: 55px; height: 45px;"> 
		</td>
		<td style="vertical-align: bottom; text-align: left; width: 457px;">
		<h1 style="text-align: center;">NOTA RETURN</h1>
		<div style="text-align: center;">&nbsp;( Atas Faktur Pajak
		No. <?php echo $no_fp; ?> &nbsp; &nbsp; &nbsp; Tgl.
		<?php echo $tax_date;?>&nbsp;&nbsp;&nbsp; )
		</div>
		</td>
		<td style="vertical-align: bottom; text-align: right;width: 185px;">
		<h3 style="text-align: center;">Nomor : <?php echo $data_header['document_no'];?> </h3>
		</td>
	</tr>
</table>
<table style="text-align: left; width: 750px;" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td style="vertical-align: top; width: 750px; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;">
		<strong>PEMBELI  :</strong><br>
		<strong style="font-weight: normal;">Nama&nbsp;&nbsp;&nbsp;&nbsp;</strong>:<strong>&nbsp;&nbsp;&nbsp; <?php echo $_MAIN__CONFIGS_040[4] ?>&nbsp;&nbsp; : &nbsp; KH MAS MANSYUR CITYLOFTS SUDIRMAN LT.11 UNIT 21 NO.121 <br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		RT 013/011 KARET
		TENGSIN - TANAH ABANG <br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		JAKARTA PUSAT - DKI JAKARTA <br>
		N.P.W.P / NPPKP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; 85.586.932.7-022.000<br>
		Tanggal Pengukuhan&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; 18 Oktober 2018<br>
		</td>
	</tr>
	<tr>
		<td style="vertical-align: top; width: 750px; border-right: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;">
		<strong>KEPADA PENJUAL :</strong><br>
		Kode&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;<?php echo $data_header_supplier[supplier_code];?><br>
		Nama&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<strong><span style="font-weight: normal;"></span><?php echo $data_header_supplier[name];?></strong><br>
		Alamat&nbsp;&nbsp; : &nbsp;<?php echo $data_header_supplier[address1];?>
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $data_header_supplier[address2];?>,<?php echo $data_header_supplier[city];?>
		<span style="font-weight: bold;"></span><br>
		Npwp &nbsp; :&nbsp;&nbsp;<?php echo $data_header_supplier[npwp];?> <br>
		No Pengukuhan PKP : &nbsp;&nbsp;<?php echo $data_header_supplier[npwp];?> 
		<?php // print_r($data_item); ?>
		</td>
	</tr>
</table>
<table  style="text-align: left; width: 750px;" border="0" cellpadding="0" cellspacing="0" >
	<tr>
		<td style="border: 1px solid black; vertical-align: top; text-align: center; font-weight: bold; width: 30px;">
		No
		</td>
		<td style="border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: center; font-weight: bold;width: 305px; ">
		Macam dan Jenis
		</td>
		<td style="vertical-align: top; font-weight: bold;border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; width: 60px;">
		Kuantum
		</td>
		<td style="vertical-align: top; font-weight: bold; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; width: 150px;">
		Harga Satuan Menurut Faktur Pajak
		</td>
		<td style="border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: center; font-weight: bold; width: 185px;">
		Harga BKP yang dikembalikan
		</td>
	</tr>
<?php $tot_sub_amt =0;
$tot_vat =0;
$tot_grand =0;
$nonya =1;
foreach ($data_item as $key => $value){
$tot_amount = $tot_amount + $value['amount'];
$tot_vat_amount = $tot_vat_amount + $value['vat_amount'];
$tot_grand = $tot_grand + $value['amount'] + $value['vat_amount'];
?>
	<tr>
		<td style="border-left: 1px solid black; border-right: 1px solid black; vertical-align: top; text-align: right;">
		<?php echo $nonya++; ?>.
		</td>
		<td style="border-right: 1px solid black; vertical-align: top; text-align: left;">
		<?php echo $value['description']; ?> [<?php echo $value['product_code']; ?>]
		</td>
		<td style="vertical-align: top; border-right: 1px solid black;  text-align: right;">
		<?php echo number_format($value['quantity'],2); ?>
		</td>
		<td style="vertical-align: top; border-right: 1px solid black;  text-align: right;">
		<?php echo number_format($value['unit_price'],2); ?>
		</td>
		<td style="border-right: 1px solid black; vertical-align: top; text-align: right;">
		<?php echo number_format($value['amount'],2); ?>
		</td>
</tr>
<?php } ?><?php while ($nonya <= 28 ){
$nonya++;
?> 
<tr>
		<td style="border-left: 1px solid black; border-right: 1px solid black; vertical-align: top; text-align: right;">
		&nbsp;
		</td>
		<td style="border-right: 1px solid black; vertical-align: top; text-align: left;">
		&nbsp;
		</td>
		<td style="vertical-align: top;border-right: 1px solid black; ">
		&nbsp;
		</td>
		<td style="vertical-align: top;border-right: 1px solid black; ">
		&nbsp;
		</td>
		<td style="border-right: 1px solid black; vertical-align: top; text-align: right;">
		&nbsp;
		</td>
</tr>
<?php } ?>
	<tr>
		<td colspan="4" style="border: 1px solid black; vertical-align: top; text-align: left;">
		Jumlah Harga BKP yang dikembalikan :
		</td>
		<td style="border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: right;">
		<?php echo number_format($tot_amount,2);?>
		</td>
	</tr>
	<tr>
		<td colspan="4" style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: left;">	Pajak Pertambahan Nilai yang diminta kembali :
		</td>
		<td style="border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: right;">
			<b><?php echo number_format($tot_vat_amount,2);?></b>
		</td>
	</tr>
	<tr>
			<td colspan="4" style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: left;">
			Pajak Penjualan Atas Barang Mewah yang diminta kembali : 
			</td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: right;">
				<b><?php echo '0.00'?></b>
			</td>
	</tr>
	<tr>
		
		<td colspan="5"   style="vertical-align: top; border-left: 1px solid black; border-right: 1px solid black;text-align: right; ">Jakarta, <?php echo $ttd_date;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
			<td colspan="5"  style="vertical-align: top; border-left: 1px solid black; border-right: 1px solid black;text-align: right; ">
					<img src="_images/ttd.png" style="width: 300px; height: 150px;"> 
			</td>
	</tr>
	<tr>
		<td colspan="5"  style="vertical-align: top;border: 1px solid black; ">
		Lembar ke - 1 : Untuk Pengusaha Kena Pajak yang menerbitkan Faktur Pajak.<br>
		Lembar ke - 2 : Untuk Pembeli.<br>
		</td>
	</tr>
	<tr>
		<td colspan="4" style="vertical-align: top;border: 1px solid black; ">
		   Purchase No. <?php echo $data_header['document_no'];?>
		</td>
		<td style="vertical-align: top;border: 1px solid black;  text-align: right;">
		   <b><?php echo number_format($tot_grand,2);?></b>
		</td>
	</tr>
</table>
</body>
</html>
<?php } ?>