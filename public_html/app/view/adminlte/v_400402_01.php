<?php
include_once('inc_condition.php');

//$sql_400402_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
$sql_400402_02 = "SELECT a.* FROM goods_receive_all_status_v a  where goods_receive_no!='0' and ( status_grn in ('21') or status_grn is null ) and document_status is null and year(document_date)>2018 and isIntegrated=1 and total_quantity>0  and store_code not like 'C%' ".$sql_400401_01;
$rs = $db->Execute($sql_400402_02); 

?>
<!-- Content Header (Page header) -->
        <!-- Main content -->
       
			 
		<?php // echo $sql_400402_02;?>
		<TABLE id="tbl01"  class="table table-striped table-bordered" style="padding:0px;">
		<THEAD>
			  <tr valign="top">       
				<td align="center"><b>PO NO</b></td>
				<td align="center"><b>GRN NO</b></td>
				<td align="center"><b>STORE</b></td>
				<td align="center"><b>SUPPLIER_CODE</b></td>
				<!-- <td align="center"><b>SUPPLIER NAME</b></td> -->				
				<td align="center"><b>RECEIVED DATE</b></td>
				<td align="center"><b>TOTAL AMOUNT</b></td>
					<td align="center"><b>ACTION</b></td>
			  </tr>
		</THEAD>
		<TBODY>
			<?php if ($rs) 
			while ($arr = $rs->FetchRow()) { ?>
			  <tr valign="top">      
				<td align="center" ><?= $arr['purchase_order_no'];?></td>
				<td align="center" ><?= $arr['goods_receive_no'];?></td>
				<td align="center" ><?= $arr['store_code'];?></td>
				<td align="center" ><?= $arr['supplier_code'];?></td>
				<!-- <td ><?= $arr['name'];?></td> -->
				<td align="center" ><?= $arr['document_date'];?></td>
				<td align="right"><?= number_format($arr['total_amount']);?></td>
				<td  align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="cobayy('GOODS+RECEIVE','400402_01_01','<?= $arr['goods_receive_no'];?>');" >Proses</button></td>				
			  </tr>
			<?php } ?>
		</TBODY>
		</TABLE>
 
<div id="tempatmodal"></div>