<?php
include_once('inc_condition.php');

//$sql_400402_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
$sql_400402_02 = "SELECT * FROM invoice_all_status_v where ( status_inv in ('41') or status_inv is null ) and document_status is null".$sql_400401_01;
$rs = $db->Execute($sql_400402_02); 
?>
<!-- Content Header (Page header) -->
        <!-- Main content -->
 		<?php // echo $sql_400402_02;?>
		<!-- <div class="row">
				<div class="col-xs-6">	
		
		Search By : <input type="text" size="" name=""> &nbsp;<button class="btn btn-info btn-xs btn-flat" onclick="window.open('c9fb1392bf5979cd6785e937fb6ec170.php?id_main=400502');"data-toggle="tooltip" title="Reset Password <?php echo $hp;?> " ><i class="fa fa-search"> Search </i></button>
		
</div>	
<div class="col-xs-6">	
		<div class="pull-right">
		<button class="btn bg-maroon btn-xs btn-flat" onclick="window.open('c9fb1392bf5979cd6785e937fb6ec170.php?id_main=400502');" data-toggle="tooltip" title="Reset Password " ><i class="fa fa-print"> Print</i></button>
  <button class="btn btn-primary btn-xs btn-flat" onclick="window.open('c9fb1392bf5979cd6785e937fb6ec170.php?id_main=400502');" data-toggle="tooltip" title="Reset Password  " ><i class="fa fa-file-text-o"> Save To Excel</i></button>
  <button class="btn btn-info btn-xs btn-flat" onclick="window.open('c9fb1392bf5979cd6785e937fb6ec170.php?id_main=400502');"data-toggle="tooltip" title="Reset Password <?php echo $hp;?> " ><i class="fa fa-file-text-o"> CSV For Tax</i></button>
		</div>
</div>	
</div>	<hr>-->
		
		<div class="box-body table-responsive" style="padding:4px;">
		<TABLE id="tbl01"  class="table table-striped table-bordered" style="padding:0px;">
		<THEAD>
			  <tr valign="top">       
				<td align="center"><b>PO NO</b></td>
				<td align="center"><b>GRN NO</b></td>
				<td align="center"><b>PFI NO</b></td>
				<td align="center"><b>INVOICE NO</b></td>
				<td align="center"><b>STORE</b></td>
				<td align="center"><b>SUPPLIER_CODE</b></td>
				<td align="center"><b>AMOUNT</b></td>
				<td align="center"><b>VAT AMOUNT</b></td>
				<td align="center"><b>GRAND TOTAL</b></td>
				<td align="center"><b>ACTION</b></td>
			  </tr>
		</THEAD>
		<TBODY>
			<?php if ($rs) 
			while ($arr = $rs->FetchRow()) { ?>
			  <tr valign="top">      
				<td ><?php echo $arr['purchase_order_no'];?></td>
				<td ><?php echo $arr['goods_receive_no'];?></td>
				<td ><?php echo $arr['proforma_invoice_no'];?></td>
				<td ><?php echo $arr['invoice_no'];?></td>
				<td ><?php echo $arr['store_code'];?></td>
				<td ><?php echo $arr['supplier_code'];?></td>
				<td align="right"><?php echo number_format($arr['total_amount'],2);?></td>
				<td align="right" ><?php echo number_format($arr['vat_amount'],2);?></td>
				<td align="right" ><?php echo number_format($arr['grand_total'],2);?></td>
				<td  align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="cobayy('INVOICE','400404_01_01','<?php echo $arr['invoice_no'];?>');" >Proses</button></td>				
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