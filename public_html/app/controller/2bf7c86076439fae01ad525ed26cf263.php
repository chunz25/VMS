<?php
// INVOICE  ======================================================================== //
if($pwdnya='730e85e6ce5a47b805e96bf133a8758b'){
	
	$_MAIN__CONFIGS_030[4]  = '"'.getcwd().'/_exec/db2json/configs.properties"'; // configs for exec jar file 
	$_MAIN__CONFIGS_030[5] 	= 'java -jar '.'"'.getcwd().'/_exec/db2json/db2json.jar"'.' -f '.$_MAIN__CONFIGS_030[4];

	$docnonya=$_REQUEST['docno'];
	
	// data INVOICE Header -------------
	$sql001='"select * from invoice where invoice_no='."'".$docnonya."'".'"';
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
	
		
	// data item  -----------------
	$sql004='"select * from invoice_item where invoice_no='."'".$data_header["invoice_no"]."'".'"';
	$exec_sql004=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql004);
	$json_exec_sql004=json_decode($exec_sql004,true);
	$data_item=$json_exec_sql004[rows];
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
		
		<td style="vertical-align: bottom; text-align: center;width:580px;">
			<h1>INVOICE </h1>
		</td>
		<td style="vertical-align: bottom; text-align: right;">
			<h3> NO : <?php echo $data_header[invoice_no];?> </h3>
		</td>
	</tr>
</table>

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
	<strong>Store : <?php echo $data_header[store_code]." ".$data_header_store[name];?></strong><br>
	<?php echo $data_header_store[address];?><br>
	<?php echo $data_header_store[city];?> <?php echo $data_header_store[zip_code];?><br>
	Phone: <?php echo $data_header_store[phone];?><br/>
					
</td>
</tr>
</table>
<br>
<table  style="text-align: left; width: 750px;" border="0" cellpadding="2" cellspacing="0" >
	<tr>
		<td style="border: 1px solid black; vertical-align: top; text-align: center; font-weight: bold; width: 25px;">
		NO
		</td>
		<td style="border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;  vertical-align: top; text-align: center; font-weight: bold; width: 70px;">
		ITEM CODE
		</td>
		<td style="border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: center; font-weight: bold;width: 220px; ">
		DESCRIPTION
		</td>
		<td style="vertical-align: top; font-weight: bold; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; width: 50px; text-align: center">
		QTY
		</td>
		<td style="vertical-align: top; font-weight: bold; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; width: 75px; text-align: center">
		UNIT PRICE
		</td>
		<td style="border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: center; font-weight: bold; width: 110px;">
		AMOUNT
		</td>
		<td style="border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: center; font-weight: bold; width: 110px;">
		TAX AMOUNT
		</td>
	</tr>
<?php $tot_sub_amt =0;
$tot_vat =0;
$tot_grand =0;
$nonya =1;
foreach ($data_item as $key => $value){
$tot_sub_amt = $tot_sub_amt + $value['amount'];
$tot_vat = $tot_vat + $value['vat_amount'];
$tot_grand = $tot_grand + $value['amount'] + $value['vat_amount'];
?>
	<tr>
		<td style="border-left: 1px solid black; border-right: 1px solid black; vertical-align: top; text-align: right;">
		<?php echo $nonya++; ?>.
		</td>
		<td style="border-right: 1px solid black; vertical-align: top; text-align: left;">
		<?php echo $value['product_code']; ?> / <br> <?php echo $value['barcode']; ?>
		</td>
		<td style="border-right: 1px solid black; vertical-align: top; text-align: left;">
		<?php echo $value['description']; ?>
		</td>
		
		<td style="border-right: 1px solid black; vertical-align: top; text-align: center;">
		<?php echo $value['quantity']; ?>
		</td>
		<td style="vertical-align: top; border-right: 1px solid black; text-align: right;">
		<?php echo number_format($value['unit_price'],2); ?>
		</td>
		<td style="vertical-align: top; border-right: 1px solid black; text-align: right ">
		<?php echo number_format($value['amount'],2); ?>
		</td>
		<td style="border-right: 1px solid black; vertical-align: top; text-align: right;">
		<?php echo number_format($value['vat_amount'],2); ?>
		</td>
</tr>
<?php } ?><?php while ($nonya <= 25 ){
$nonya++;
?> 
<tr>
		<td style="border-left: 1px solid black; border-right: 1px solid black; vertical-align: top; text-align: right;">
		&nbsp;
		</td>
		
		<td style="border-right: 1px solid black; vertical-align: top; text-align: left;">
		&nbsp;
		</td>
		<td style="border-right: 1px solid black; vertical-align: top; text-align: left;">
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
		<td colspan="6" style="border: 1px solid black; vertical-align: top; text-align: right;">
		<b>Subtotal Sebelum Pajak : </b>
		</td>
		<td style="border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: right;">
		<b><?php echo number_format($tot_sub_amt,2);?></b>
		</td>
	</tr>
	<tr>
		<td colspan="6" style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: right;">	<b>Pajak : </b>
		</td>
		<td style="border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: right;">
			<b><?php echo number_format($tot_vat,2);?></b>
		</td>
	</tr>
	<tr>
			<td colspan="6" style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: right;">
			<b>Grand Total : </b>
			</td>
			<td style="border-right: 1px solid black; border-bottom: 1px solid black; vertical-align: top; text-align: right;">
				<b><?php echo number_format($tot_grand,2);?></b>
			</td>
	</tr>
	
</table>
<br>
<table align="right" border="0" cellpadding="2" cellspacing="2">
<tr>
<td style="vertical-align: top; text-align: center; width: 30%;">&nbsp;<?php echo $data_header_supplier[city];?>,
<?php echo $data_header[insert_date];?><br>
</td>
</tr>
<tr>
<td style="vertical-align: top; text-align: center;"> 
<br>
<br>
<br>
<br><br>
(<?php 
$financeName = ($data_header_supplier[finance_name]!='') ? $data_header_supplier[finance_name] : "Finance ".$data_header_supplier[name];
echo $financeName;?>) <br>
</td>
</tr>
</table>
</body>
</html>
<?php } ?>