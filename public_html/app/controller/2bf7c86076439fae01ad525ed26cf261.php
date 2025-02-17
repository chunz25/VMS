<?php
// DEBIT NOTE ========================================================================
if($pwdnya='730e85e6ce5a47b805e96bf133a8756b'){
	
	$_MAIN__CONFIGS_030[4]  = '"'.getcwd().'/_exec/db2json/configs.properties"'; // configs for exec jar file 
	$_MAIN__CONFIGS_030[5] 	= 'java -jar '.'"'.getcwd().'/_exec/db2json/db2json.jar"'.' -f '.$_MAIN__CONFIGS_030[4];

	$docnonya=$_REQUEST['docno'];
	
// data GRN Header -------------
	$sql001='"select * from debit_note where tax_file_name='."'".$docnonya."'".'"';
	$exec_sql001=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql001);
	$json_exec_sql001=json_decode($exec_sql001,true);
	$data_header=$json_exec_sql001[rows][0];
	
	
	
	// data supplier -----------------
	$sql003='"select * from supplier where supplier_code='."'".$data_header["supplier_code"]."'".'"';
	$exec_sql003=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql003);
	$json_exec_sql003=json_decode($exec_sql003,true);
	$data_header_supplier=$json_exec_sql003[rows][0];
	
		
	// data item  -----------------
	$sql004='"select * from debit_note_item where dn_id='."'".$data_header["debit_note_no"]."'".'"';
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
<table border="1" cellpadding="2" cellspacing="0" width="100%">
<tbody>
<tr>
<td
style="vertical-align: middle; text-align: center; width: 70px;"> <img
src="_images/logo_goro_s.png" style="width: 55px; height: 45px;"> </td>
<td
style="vertical-align: bottom; text-align: left; width: 490px;"> <strong
style="text-decoration: underline;"><?php echo $_MAIN__CONFIGS_040[4] ?></strong><br>
<?php echo $_MAIN__CONFIGS_040[5] ?></td>
<td style="vertical-align: top; text-align: right;">
<div style="text-align: center;"> </div>
<h1 style="text-align: center;">NOTA DEBIT</h1>
</td>
</tr>
</tbody>
</table>
<hr style="border: 1px solid ;"><br>
<table style="text-align: left; width: 100%;" border="0" cellpadding="2"
cellspacing="2">
<tbody>
<tr>
<td style="vertical-align: top; width: 50%;"><strong>PEMBELI /
PENERIMA JASA :<br><br>
<?php echo $data_header_supplier[name];?> </strong><br>
<?php echo $data_header_supplier[address1];?><br>
<?php echo $data_header_supplier[address2];?>,<?php echo $data_header_supplier[city];?>
<br>
<span style="font-weight: bold;">Phone</span> &nbsp; <?php echo $data_header_supplier[phone];?>
<br>
<span style="font-weight: bold;">Npwp</span> &nbsp; <?php echo $data_header_supplier[npwp];?>
<br>
</td>
<td style="vertical-align: top; text-align: right;">
<table
style="width: 70%; outline-color: navy ! important; outline-style: dashed ! important; outline-width: 2px ! important;"
align="center" border="0" cellpadding="3" cellspacing="5">
<tbody>
<tr>
<td style="vertical-align: top; text-align: right;">No
Debit Note
</td>
<td style="vertical-align: top; text-align: center;">:
</td>
<td style="vertical-align: top;"><strong><?php echo $data_header['tax_file_name'];?></strong>
</td>
</tr>
<tr>
<td style="vertical-align: top; text-align: right;">Tanggal
Debit Note
</td>
<td style="vertical-align: top; text-align: center;">:
</td>
<td style="vertical-align: top;">&nbsp;<?php echo $data_header['document_date'];?>
</td>
</tr>
<tr>
<td style="vertical-align: top; text-align: right;">No
Sales Order<br>
</td>
<td style="vertical-align: top; text-align: center;">:
</td>
<td style="vertical-align: top;">&nbsp;<?php echo $data_header['debit_note_no'];?>
</td>
</tr>
<tr>
<td style="vertical-align: top; text-align: right;">Supplier
Code<br>
</td>
<td style="vertical-align: top; text-align: center;">:<br>
</td>
<td style="vertical-align: top;"><?php echo $data_header['supplier_code'];?>
<br>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<hr style="border: 1px solid ;"><br>
<table style="text-align: left; margin-left: auto; margin-right: auto;" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td style="vertical-align: top; text-align: center; font-weight: bold;width: 30px; border: 1px solid black;">No</td>
		<td style="vertical-align: top; text-align: center; font-weight: bold;width: 530px;border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Keterangan</td>
		<td style="vertical-align: top; text-align: center; font-weight: bold;width: 165px; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Jumlah ( Rp.)</td>
	</tr>
<?php
	$tot_sub_amt =0;
	$tot_vat =0;
	$tot_grand =0;
	$nonya =1;
	foreach ($data_item as $key => $value){
		$sub_amt_ori=$value['sub_amt']-$value['vat'];
		$tot_sub_amt = $tot_sub_amt + $sub_amt_ori;
		$tot_vat = $tot_vat + $value['vat'];
		$tot_grand = $tot_grand + $sub_amt_ori + $value['vat'];
		
?>
	<tr>
		<td style="vertical-align: top; text-align: right;  border-left: 1px solid black;  border-right: 1px solid black;"><?php echo $nonya++; ?>.</td>
		<td style="vertical-align: top; text-align: left;  border-right: 1px solid black;"><?php echo $value['remark1']; ?></td>
		<td style="vertical-align: top; text-align: right; border-right: 1px solid black;"><?php echo number_format($sub_amt_ori,2); ?></td>
	</tr>
	<?php } ?>
	<?php
	while ($nonya <= 29 ){
		$nonya++;
?>
	<tr>
		<td style="vertical-align: top; text-align: right;  border-left: 1px solid black;  border-right: 1px solid black;">&nbsp;</td>
		<td style="vertical-align: top; text-align: left; border-right: 1px solid black;">&nbsp;</td>
		<td style="vertical-align: top; text-align: right;   border-right: 1px solid black;">&nbsp;</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2" rowspan="1" style="vertical-align: top; text-align: right;  border: 1px solid black;"><span style="font-weight: bold;">SUB TOTAL</span><br></td>
		<td style="vertical-align: top; text-align: right; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><b><?php echo number_format($tot_sub_amt,2);?></b></td>
	</tr>
	<tr>
		<td colspan="2" rowspan="1" style="vertical-align: top; text-align: right; border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><span style="font-weight: bold;">P A J A K </span></td>
		<td style="vertical-align: top; text-align: right;   border-right: 1px solid black; border-bottom: 1px solid black;"><b><?php echo number_format($tot_vat,2);?></b></td>
	</tr>
	<tr>
		<td colspan="2" rowspan="1" style="vertical-align: top; text-align: right;  border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><span style="font-weight: bold;">T O T A L&nbsp;</span></td>
		<td style="vertical-align: top; text-align: right;  border-right: 1px solid black; border-bottom: 1px solid black;"><b><?php echo number_format($tot_grand,2);?></b></td>
	</tr>
</table>
<br>
<hr style="border: 1px solid ;"><br>
<table align="right" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td style="vertical-align: top; text-align: center; width: 30%;">&nbsp;Jakarta, <?php echo $data_header[document_date];?></td>
	</tr>
	<tr>
		<td style="vertical-align: top; text-align: center;"> <img src="_images/ttd.png" style="width: 300px; height: 150px;"></td>
	</tr>
</table>
<br>
<br>
</body>
</html>
<?php } ?>