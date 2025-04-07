<?php
include_once('inc_condition.php');

$sql_400502_02 = "SELECT * FROM goods_return_1_v where cek_null_z is null and  year(document_date)>2018 and isIntegrated=1 and ( version = '2' )".$sql_400401_01;
$rs = $db->Execute($sql_400502_02); 
?>

<!-- Content Header (Page header) -->
        <!-- <section class="content-header"> -->
        <!-- Main content -->
        <section class="content" style="padding:3px;">
          <!-- Default box -->
          <div class="box box-solid" id="isicontent1" style="padding:0px;" > <!--style="overflow-y:auto;padding:0px;"-->
            <!----> <div class="box-header with-border">
              <font size="3">
           <b> <?= $_REQUEST["param_menu1"];?></b>
          </font>
		<div class="pull-right">
		<!-- <button class="btn bg-maroon btn-xs btn-flat" onclick="window.open('c9fb1392bf5979cd6785e937fb6ec170.php?id_main=400502');" data-toggle="tooltip" title="Reset Password " ><i class="fa fa-print"> Print</i></button>
  <button class="btn btn-primary btn-xs btn-flat" onclick="window.open('c9fb1392bf5979cd6785e937fb6ec170.php?id_main=400502');" data-toggle="tooltip" title="Reset Password  " ><i class="fa fa-file-text-o"> Save To Excel</i></button> -->
  <button class="btn btn-info btn-xs btn-flat" onclick="window.open('c9fb1392bf5979cd6785e937fb6ec170.php?id_main=400502');"data-toggle="tooltip" title="CSV Tax For supplier " ><i class="fa fa-file-text-o"> CSV For Tax</i></button>
<?php if($_SESSION['tb_id_user_type']==3 || $_SESSION['tb_id_user_type']==1){ ?>
  <button class="btn btn-info btn-xs btn-flat" onclick="window.open('c9fb1392bf5979cd6785e937fb6ec171.php?id_main=400502');"data-toggle="tooltip" title="CSV Tax For supplier " ><i class="fa fa-file-text-o"> CSV Tax Fin GORO</i></button>
<?php } ?>

  </div>
  
            </div> 
            <div class="box-body" style="padding:4px;">
			 <?php //echo $sql_400502_02;?>
			 


		
		
	
<TABLE id="tbl01"  class="table table-striped table-bordered" style="padding:0px;">
<THEAD>
      <tr valign="top">
        
        <td align="center"><b>RETURN NO</b></td>
        <td align="center"><b>DOCUMENT NO</b></td>
        <td align="center"><b>STORE</b></td>
        <td align="center"><b>SUPPLIER_CODE</b></td>
        <td align="center"><b>DOCUMENT_DATE</b></td>
        <td align="center"><b>DUE_DATE</b></td>    
        <td align="center"><b>TOTAL_AMOUNT</b></td>
        <td align="center"><b>VAT_AMOUNT</b></td>
        <td align="center"><b>GRAND_TOTAL</b></td>
        <td align="center"><b>PO_NO_ORIGINAL</b></td>
		<td align="center"><b>ACTION</b></td>
		
      </tr>
</THEAD>
<TBODY>
<?php if ($rs) 
while ($arr = $rs->FetchRow()) { ?>
      <tr valign="top">       
        <td ><?= $arr['goods_return_no'];?></td>      
        <td ><?= $arr['document_no'];?></td>      
        <td  align="center"><?= $arr['store_code'];?></td>
        <td  align="center"><?= $arr['supplier_code'];?></td>
        <td  align="center"><?= $arr['document_date'];?></td>
        <td  align="center"><?= $arr['due_date'];?></td>              
        <td align="right"><?= number_format($arr['total_amount']);?></td>
        <td align="right"><?= number_format($arr['vat_amount']);?></td>
        <td align="right"><?= number_format($arr['grand_total']);?></td>        
        <td align="right"><?= $arr['po_no_original'];?></td>  
<td  align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="cobayy('RETURN','400502_00_01','<?= $arr['goods_return_no'];?>&param_menu4=<?= $arr['backorder_flag']?>');" >View</button></td>		
      </tr>
<?php } ?>
</TBODY>
</TABLE>
 </div><!-- /.box-body -->
           <!-- <div class="box-footer"> 
               Footer 
            </div>  --><!-- /.box-footer-->
					<!-- <div class="overlay">
					  <i class="fa fa-refresh fa-spin"></i>
					</div> -->
          </div><!-- /.box -->

	

</section><!-- /.content -->
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