<?php
include_once('inc_condition.php');

//$sql_400402_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
$sql_400402_02 = "select * from dashboard_inv_process_v ".$sql_400401_01;
$rs = $db->Execute($sql_400402_02); 

?>
<!-- Content Header (Page header) -->
        <!-- Main content -->
       
			 
		<?php // echo $sql_400402_02;?>
		 <div class="box-body table-responsive" style="padding:2px;">
		<TABLE id="tbl02"  class="table table-striped table-bordered" style="padding:0px;">
		<THEAD>
																							

			  <tr valign="top">       
				<td align="center"><b>supplier_code</b></td>
				<td align="center"><b>supplier_name</b></td>
				<td align="center"><b>DEPT</b></td>
				<!-- <td align="center"><b>PO</b></td>
				<td align="center"><b>GRN</b></td>
				<td align="center"><b>DISP QTY</b></td>
				<td align="center"><b>PFI</b></td>
				<td align="center"><b>DISP PRC</b></td>
				<td align="center"><b>INV</b></td>
				<td align="center"><b>INVR</b></td>
				<td align="center"><b>INVR_INV</b></td>
				<td align="center"><b>RTP</b></td>
				<td align="center"><b>PAID</b></td>
				<td align="center"><b>LASTUPD</b></td> -->
				<td align="center"><b>INV PROC</b></td>
				<td align="center"><b>INV CLOSE</b></td>
				<td align="center"><b>TOT INV</b></td>
				<td align="center"><b>EMAIL</b></td>
				<td align="center"><b>NAME</b></td>
				<td align="center"><b>HP</b></td>
				<td align="center"><b>LASTLGN</b></td>
				<td align="center"><b>SUPP GROUP</b></td>
				<td align="center"><b>ACTION</b></td>
				
			  </tr>
		</THEAD>
		<TBODY>
			<?php if ($rs) 
			while ($arr = $rs->FetchRow()) { ?>
			  <tr valign="top">      
				<td ><?php echo $arr['supplier_code'];?></td>
				<td ><?php echo $arr['supplier_name'];?></td>
				<td ><?php echo $arr['department'];?></td>
				
				<td ><?php echo $arr['inv_belum_selesai'];?></td>
				<td ><?php echo $arr['inv_sudah_selesai'];?></td>
				<td ><?php echo $arr['total_inv_process'];?></td>
				<td ><?php echo $arr['email'];?></td>
				<td ><?php echo $arr['fullname'];?></td>
				<td ><?php echo $arr['hp'];?></td>
				<td ><?php echo $arr['last_login'];?></td>
				<td ><?php echo $arr['supplier_group'];?></td>
								
				<td  align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400205_01_01&po_no=<?php echo urlencode($arr['purchase_order_no']); ?>','','#tampil2');" >View Detail</button></td>
							
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