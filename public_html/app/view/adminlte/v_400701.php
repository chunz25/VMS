<?php
include_once('inc_condition.php');

$sql = "SELECT * FROM payment WHERE ucase(payment_description) not like '%CANCEL%' ".$sql_400401_01." order by document_date desc";
$rs = $db->Execute($sql);
//include "100101_v.php";
?>
<!-- Content Header (Page header) -->
        <!-- <section class="content-header">
          <font size="10">
           <b> <?php echo $_REQUEST["param_menu1"];?></b>
          </font>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
          </ol>
        </section> 
-->
        <!-- Main content -->
        <section class="content" style="padding:3px;">
          <!-- Default box -->
          <div class="box box-solid" id="isicontent1" style="padding:0px;" > <!--style="overflow-y:auto;padding:0px;"-->
            <!----> <div class="box-header with-border">
              <font size="3">
           <b> <?php echo $_REQUEST["param_menu1"];?></b>
          </font>
              
            </div> 
			
           <div class="box-body table-responsive" style="padding:4px;">
		   <?php //  echo $sql;?>
			 
		

<TABLE  id="tbl10"  class="table table-striped table-bordered" style="padding:0px;">
<THEAD>
      <tr valign="top">
         <td align="center"><b>DOCUMENT_DATE</b></td>
        <td align="center"><b>PAYMENT_NO</b></td>
        <td align="center"><b>SUPPLIER_CODE</b></td>
        <td align="center"><b>SUPPLIER NAME</b></td>
       
        <td align="center"><b>PAYMENT_DESCRIPTION</b></td>
        <td align="center"><b>BANK_ACCOUNT</b></td>
        <td align="center"><b>BANK_NAME</b></td>
        
        <td align="center"><b>TOTAL_AMOUNT</b></td>
        <td align="center"><b>ACTION</b></td>
       
      </tr>
</THEAD>
<TBODY>
<?php if ($rs) 
while ($arr = $rs->FetchRow()) { ?>
      <tr valign="top">
         <td ><?php echo $arr['document_date'];?></td>
        <td ><?php echo $arr['payment_no'];?></td>
        <td ><?php echo $arr['supplier_code'];?></td>
        <td ><?php echo $arr['supplier_name'];?></td>
       
        <td ><?php echo $arr['payment_description'];?></td>
        <td ><?php echo $arr['bank_account'];?></td>
        <td ><?php echo $arr['bank_name'];?></td>
        
        <td align="right"><?php echo number_format($arr['total_amount'],2);?></td>
        <td  align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="cobayy('PAYMENT+DETAIL','400701_00_01','<?php echo $arr['payment_no'];?>');" >VIEW DETAIL</button></td>
       
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
<script>
$('#tbl10').DataTable({"aaSorting":[[2,'desc']]});
</script>