<?php
include_once('inc_condition2.php');

//$sql_400402_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
$sql_400402_02 = "SELECT * FROM invoice_receipt_all_status_v where status_invr in ('51','52','53') and payment_amount is null ".$sql_400401_01;
$rs = $db->Execute($sql_400402_02); 

?>
<!-- Content Header (Page header) -->
        <!-- Main content -->
       
			 
		<?php // echo $sql_400402_02;?>
		<div class="box-body table-responsive" style="padding:2px;">
		<TABLE id="tbl01"  class="table table-striped table-bordered" style="padding:0px;">
		<THEAD>
			  <tr valign="top">       
				<td align="center"><b>PO NO</b></td>
				<td align="center"><b>GRN NO</b></td>
				
				<!-- <td align="center"><b>INVOICE NO</b></td> -->
				<td align="center"><b>INVOICE RECEIPT NO</b></td>
				<td align="center"><b>STORE</b></td>
				<td align="center"><b>SUPPLIER CODE</b></td>
				<td align="center"><b>SUPPLIER NAME</b></td>
				<td align="center"><b>ORDER_DATE</b></td>
				<td align="center"><b>INV RECEIPT DATE</b></td>
				<td align="center"><b>AMOUNT</b></td>
				<td align="center"><b>VAT</b></td>				
				<td align="center"><b>TOTAL AMT</b></td>				
					<td align="center"><b>STATUS FAKTUR PAJAK</b></td>
					<td align="center"><b>ACTION</b></td>
			  </tr>
		</THEAD>
		<TBODY>
			<?php if ($rs) 
			while ($arr = $rs->FetchRow()) { ?>
			  <tr valign="top">      
				<td ><?php echo $arr['purchase_order_no'];?></td>
				<td ><?php echo $arr['goods_receive_no'];?></td>
				
				<!-- <td ><?php echo $arr['invoice_no'];?></td> -->
				<td ><?php echo $arr['invoice_receipt_no'];?></td>
				<td ><?php echo $arr['store_code'];?></td>
				<td ><?php echo $arr['supplier_code'];?></td>
				<td ><?php echo $arr['supplier_name'];?></td>
				<td ><?php echo $arr['document_date'];?></td>
				<td ><?php echo $arr['inv_receipt_date'];?></td>
				<td align="right"><?php echo number_format($arr['total_amount'],2);?></td>				
				<td align="right"><?php echo number_format($arr['vat_amount'],2);?></td>				
				<td align="right"><?php echo number_format($arr['grand_total'],2);?></td>				
				<td align="right">
				<?php 
				if($arr['status_invr']=='53') {?>
				<button class="btn btn-danger btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400405_01_02&po_no=<?php echo urlencode($arr['purchase_order_no']); ?>','','#tampil2');" >Faktur Pajak<br> Not Valid !</button>
				
				<?php } ?>
				</td>				
				<td  align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="cobayy('INVOICE+RECEIPT','400405_01_01','<?php echo $arr['invoice_no'];?>&invrno=<?php echo $arr['invoice_receipt_no'];?>');" >Detail</button>
				</td>				
			  </tr>
			<?php } ?>
		</TBODY>
		</TABLE>
		</div>
 
<div id="tempatmodal"></div>
<div id="loading" class="modal fade"  aria-hidden="true" >
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body" align="center">
				<img src="_images/ajax-loader.gif">			  
			</div>
		</div>
	 </div>
</div>