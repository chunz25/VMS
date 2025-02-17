<?php
include_once('inc_condition.php');

//$sql_400402_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
$sql_400402_02 = "select tgl, sum(case when tb_id_user_type = 1 then jml else 0 end) admin, sum(case when tb_id_user_type = 2 then jml else 0 end) buyer, sum(case when tb_id_user_type = 3 then jml else 0 end) finance, sum(case when tb_id_user_type = 4 then jml else 0 end) gr, sum(case when tb_id_user_type = 5 then jml else 0 end) supplier, sum(case when tb_id_user_type = 6 then jml else 0 end) group_supplier, sum(jml) total  from log_tx_daily_v group by tgl ".$sql_400401_01;
$rs = $db->Execute($sql_400402_02); 

?>
<!-- Content Header (Page header) -->
        <!-- Main content -->
       
		 <div class="box-body table-responsive" style="padding:2px;">	 
		<?php // echo $sql_400402_02;?>
		<TABLE id="tbl01"  class="table table-striped table-bordered" style="padding:0px;">
		<THEAD>
			  <tr valign="top">       
				<td align="center"><b>TGL</b></td>
				<td align="center"><b>ADMIN</b></td>
				<td align="center"><b>BUYER</b></td>
				<td align="center"><b>FINANCE</b></td>
				<td align="center"><b>GR</b></td>
				<td align="center"><b>SUPPLIER</b></td>
				<td align="center"><b>GROUP SUPPLIER</b></td>
				<td align="center"><b>SUB TOTAL</b></td>
				<td align="center"><b>ACTION</b></td>
				
			  </tr>
		</THEAD>
		<TBODY>
			<?php if ($rs) 
			while ($arr = $rs->FetchRow()) { ?>
			  <tr valign="top">      
				<td ><?php echo $arr['tgl'];?></td>
				<td ><?php echo $arr['admin'];?></td>		
				<td ><?php echo $arr['buyer'];?></td>
				<td ><?php echo $arr['finance'];?></td>
				<td ><?php echo $arr['gr'];?></td>
				<td ><?php echo $arr['supplier'];?></td>
				<td ><?php echo $arr['group_supplier'];?></td>
				<td ><?php echo $arr['total'];?></td>
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