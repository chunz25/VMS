<?php
include_once('inc_condition.php');

//include "100101_v.php";
$sql = "SELECT * FROM debit_note WHERE 1=1 ".$sql_400401_01;
$rs = $db->Execute($sql); 

?>

        <!-- Main content -->
        <section class="content" style="padding:3px;">
          <!-- Default box -->
          <div class="box box-solid" id="isicontent1" style="padding:0px;" > <!--style="overflow-y:auto;padding:0px;"-->
            <!----> <div class="box-header with-border">
              <font size="3">
           <b> <?php echo $_REQUEST["param_menu1"];?></b>
          </font>
              
            </div> 
            <div class="box-body table-responsive" style="padding:2px;">
			 <?php  // echo $sql;?>

<TABLE id="tbl01"  class="table table-striped table-bordered" style="padding:0px;">
<THEAD>
      <tr valign="top">
        
        <td align="center"><b>DEBIT_NOTE_NO</b></td>
      
        <td align="center"><b>STORE_CODE</b></td>
        <td align="center"><b>SUPPLIER_CODE</b></td>
        <td align="center"><b>SUPPLIER_NAME</b></td>
        <td align="center"><b>DOCUMENT_DATE</b></td>
      
        <td align="center"><b>TOTAL_AMOUNT</b></td>
        <td align="center"><b>TAX_REG_NO</b></td>
        
        
        
        <td align="center"><b>ACTION</b></td>
      </tr>
</THEAD>
<TBODY>
<?php if ($rs) 
while ($arr = $rs->FetchRow()) { ?>
      <tr valign="top">

        <td ><?php echo $arr['tax_file_name'];?></td>

        <td ><?php echo $arr['store_code'];?></td>
        <td ><?php echo $arr['supplier_code'];?></td>
        <td ><?php echo $arr['supplier_name'];?></td>
        <td align="center" ><?php echo $arr['document_date'];?></td>
        <td align="right"><?php echo number_format($arr['total_amount']);?></td>
        <td align="center"><?php echo $arr['tax_reg_no'];?></td>
        <td  align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="cobayy('DEBIT+NOTE','400602_00_01','<?php echo $arr['debit_note_no'];?>');" >VIEW DETAIL</button></td>
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