<?php
switch ($_SESSION['tb_id_user_type']) {
    case 1:
        $sql_400402_01 = " ";
        break;
    case 2:
        $sql_400402_01 = " AND  b.department in (".$_SESSION['department'].")";
        break;
    case 3:
        $sql_400402_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
        break;
	case 4:
        $sql_400402_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
        break;
	case 5:
        $sql_400402_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
        break;
}

//$sql_400402_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
$sql_400402_02 = "SELECT a.*,b.name,b.department FROM proforma_invoice_all_status_v a left join supplier b on a.supplier_code=b.supplier_code  where ( a.status_pfi in('34') )  and revision_seq>0 and a.document_status is null".$sql_400402_01;
$rs = $db->Execute($sql_400402_02); 

?>
<!-- Content Header (Page header) -->
        <!-- Main content -->
       
			 
		<?php // echo $sql_400402_02;?>
		<TABLE id="tbl02"  class="table table-striped table-bordered" style="padding:0px;">
		<THEAD>
			  <tr valign="top">       
				<td align="center"><b>PO NO</b></td>
				<td align="center"><b>GRN NO</b></td>
				<td align="center"><b>PFI NO</b></td>
				<td align="center"><b>STORE</b></td>
				<td align="center"><b>SUPPLIER_CODE</b></td>
				<td align="center"><b>SUPPLIER_NAME</b></td>
				<td align="center"><b>RECEIVED DATE</b></td>
				<td align="center"><b>DEPARTMENT</b></td>
				<td align="center"><b>STATUS</b></td>
				<td align="center"><b>SEQ</b></td>
				<td align="center"><b>ACTION</b></td>
			  </tr>
		</THEAD>
		<TBODY>
			<?php if ($rs) 
			while ($arr = $rs->FetchRow()) { 
				//$view_action=($arr['status_grn']==23)? "Proses" : "View" ;
				// $view_status=($arr['status_grn']==23)? "Dispute qty By SUPERECO" : "Dispute qty By Supplier" ;
				$view_status="Dispute price finished";
				$view_action="View";
		
			?>
			  <tr valign="top">      
				<td ><?php echo $arr['purchase_order_no'];?></td>
				<td ><?php echo $arr['goods_receive_no'];?></td>
				<td ><?php echo $arr['proforma_invoice_no'];?></td>
				<td ><?php echo $arr['store_code'];?></td>
				<td ><?php echo $arr['supplier_code'];?></td>
				<td ><?php echo $arr['name'];?></td>
				<td ><?php echo $arr['document_date'];?></td>				
				<td ><?php echo $arr['department'];?></td>
				
				<td  align="center"><span class="label label-info"><?php echo $view_status;?></span></td>
				<td  align="center"><span class="label label-info"><?php echo $arr['revision_seq'];?></span></td>
				<td  align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="cobayy('PROFORMA+INVOICE','401001_02_01','<?php echo $arr['proforma_invoice_no'];?>&param_menu4=<?php echo $arr['status_pfi'];?>');" ><?php echo $view_action;?> </button></td>					
			  </tr>
			<?php } ?>
		</TBODY>
		</TABLE>
 
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