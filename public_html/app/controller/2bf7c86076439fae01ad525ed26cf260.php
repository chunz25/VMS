<?php
if($pwdnya='730e85e6ce5a47b805e96bf133a8755b'){
	
	$_MAIN__CONFIGS_030[4]  = '"'.getcwd().'/_exec/db2json/configs.properties"'; // configs for exec jar file 
	$_MAIN__CONFIGS_030[5] 	= 'java -jar '.'"'.getcwd().'/_exec/db2json/db2json.jar"'.' -f '.$_MAIN__CONFIGS_030[4];

	$_MAIN__CONFIGS_030[6]  = '"'.getcwd().'/_exec/db2json/configs2.properties"'; // configs for exec jar file 
	$_MAIN__CONFIGS_030[7] 	= 'java -jar '.'"'.getcwd().'/_exec/db2json/db2json.jar"'.' -f '.$_MAIN__CONFIGS_030[6];

	$_MAIN__CONFIGS_030[8]  = '"'.getcwd().'/_exec/db2json/configs3.properties"'; // configs for exec jar file 
	$_MAIN__CONFIGS_030[9] 	= 'java -jar '.'"'.getcwd().'/_exec/db2json/db2json.jar"'.' -f '.$_MAIN__CONFIGS_030[8];
	
// data GRN Header -------------
	$sql001='"select * from invoice_receipt where purchase_order_no='."'".$ponya."'".'"';
	$exec_sql001=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql001);
	$json_exec_sql001=json_decode($exec_sql001,true);
	$data_header=$json_exec_sql001[rows][0];
	
	// data store -----------------
	$sql002='"select * from store where code='."'".$data_header["store_code"]."'".'"';
	$exec_sql002=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql002);
	$json_exec_sql002=json_decode($exec_sql002,true);
	$data_header_store=$json_exec_sql002[rows][0];
	
	// data supplier -----------------
	$sql003='"select * from supplier where supplier_code='."'".$data_header["supplier_code"]."'".'"';
	$exec_sql003=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql003);
	$json_exec_sql003=json_decode($exec_sql003,true);
	$data_header_supplier=$json_exec_sql003[rows][0];
?>
<html>
<head>
<meta content="text/html; charset=ISO-8859-1"
http-equiv="content-type">
<title></title>
</head>
<body>
<table width="100%" border="1" cellpadding="2" cellspacing="0">
	<tr >
		<td style="vertical-align: middle; text-align: center; width:70px;">
			<img src="_images/logo_goro_s.png" style="width:55px;height:45px;">
		</td>
		<td style="vertical-align: bottom; text-align: left;width:490px;">
			<h2>INVOICE RECEIPT </h2>
		</td>
		<td style="vertical-align: bottom; text-align: right;">
			<h3> NO : <?php echo $data_header[invoice_receipt_no];?> </h3>
		</td>
	</tr>
</table>

<hr style="border:1px solid">Telah diterima,<br>
<br>
<table style="text-align: left; width: 100%;" border="0" cellpadding="2"
cellspacing="2">
<tr>
<td style="vertical-align: top; width: 50%;">Dari :<br>
<br>

	<strong><?php echo $data_header_supplier[name];?></strong><br>
	<?php echo $data_header_supplier[address1];?><br>
	<?php echo $data_header_supplier[address2];?>, <?php echo $data_header_supplier[city];?><br>
	Phone : <?php echo $data_header_supplier[phone];?><br/>
	Email : <?php echo $data_header_supplier[email];?><br/>
	Npwp : <?php echo $data_header_supplier[npwp];?>
				
<br>
</td>
<td style="vertical-align: top;">Untuk :<br>
<br>
	<strong><?php echo $_MAIN__CONFIGS_040[4] ?></strong><br>
	<?php echo $data_header_store[address];?><br>
	<?php echo $data_header_store[city];?> <?php echo $data_header_store[zip_code];?><br>
	Phone: <?php echo $data_header_store[phone];?><br/>
					
</td>
</tr>
</table>
<br>
Dengan keterangan sebagai berikut :<br>
<table align="center" style="width: 70%;" border="0" cellpadding="3" cellspacing="5"  >
<tbody>
<tr>
<td style="vertical-align: top; text-align: right;">No Invoice<br>
</td>
<td style="vertical-align: top; text-align: center;">:<br>
</td>
<td style="vertical-align: top;">&nbsp;<?php echo $data_header[invoice_no];?><br>
</td>
</tr>
<tr>
<td style="vertical-align: top; text-align: right;">No PO<br>
</td>
<td style="vertical-align: top; text-align: center;">:<br>
</td>
<td style="vertical-align: top;">&nbsp;<?php echo $data_header[purchase_order_no];?><br>
</td>
</tr>
<tr>
<td style="vertical-align: top; text-align: right;">No GRN<br>
</td>
<td style="vertical-align: top; text-align: center;">:<br>
</td>
<td style="vertical-align: top;">&nbsp;<?php echo $data_header[goods_receive_no];?><br>
</td>
</tr>
<tr>
<td style="vertical-align: top; text-align: right;">Jumlah Sebelum Pajak <br>
</td>
<td style="vertical-align: top; text-align: center;">:<br>
</td>
<td style="vertical-align: top;">&nbsp;Rp. <?php echo number_format($data_header[total_amount],2);?><br>
</td>
</tr>
<tr>
<td style="vertical-align: top; text-align: right;">Pajak<br>
</td>
<td style="vertical-align: top; text-align: center;">:<br>
</td>
<td style="vertical-align: top;">&nbsp;Rp. <?php echo number_format($data_header[vat_amount],2);?><br>
</td>
</tr>
<tr>
<td style="vertical-align: top; text-align: right;">Grand Total<br>
</td>
<td style="vertical-align: top; text-align: center;">:<br>
</td>
<td style="vertical-align: top;">&nbsp;Rp. <?php echo number_format($data_header[grand_total],2);?><br>
</td>
</tr>
</tbody>
</table>
<br>
<hr style="border:1px solid"><br>
<table align="right" border="0" cellpadding="2" cellspacing="2">
<tr>
<td style="vertical-align: top; text-align: center; width: 30%;">&nbsp;Bogor,
<?php echo $data_header[insert_date];?><br>
</td>
</tr>
<tr>
<td style="vertical-align: top; text-align: center;"> <img src="_images/ttd.png" style="width:300px;height:150px;" ><br>
</td>
</tr>
</table>
<br>
</body>
</html>
<?php } ?>