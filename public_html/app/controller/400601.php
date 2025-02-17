<?php
switch ($_SESSION['tb_id_user_type']) {
    case 1:
        $sql_400401_01 = " ";
        break;
    case 2:
        $sql_400401_01 = "  ";
        break;
    case 3:
        $sql_400401_01 = " ";
        break;
	case 4:
        $sql_400401_01 = " AND store_code='".$_SESSION['store_code']."'";
        break;
	case 5:
        $sql_400401_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
		break;
	case 6:
        $sql_400401_01 = " AND supplier_group in (".$_SESSION['supplier_code'].")";
        break;
}

$sql_condition = "";
$sql = "SELECT * FROM debit_note WHERE 1=1 ".$sql_400401_01;
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
            <div class="box-body table-responsive" style="padding:2px;">



<TABLE id="tbl01"  class="table table-striped table-bordered" style="padding:0px;">
<THEAD>
      <tr valign="top">       
        <td align="center"><b>DN NO</b></td>
        <td align="center"><b>SUPPLIER_CODE</b></td>
        <td align="center"><b>SUPPLIER_NAME</b></td>
        <td align="center"><b>DOCUMENT_DATE</b></td>
        <td align="center"><b>DUE_DATE</b></td>
        <td align="center"><b>TOTAL_AMOUNT</b></td>
        <td align="center"><b>TAX_REG_NO</b></td>
        <td align="center"><b>FAKTUR_PAJAK_NO</b></td>
        <td align="center"><b>TAX_ID</b></td>
        <td align="center"><b>ADDRESS</b></td>
      </tr>
</THEAD>
<TBODY>
<?php if ($rs) 
while ($arr = $rs->FetchRow()) { ?>
      <tr valign="top">
        <td ><?php echo $arr['debit_note_no'];?></td>      
        <td ><?php echo $arr['supplier_code'];?></td>
        <td ><?php echo $arr['supplier_name'];?></td>
        <td ><?php echo $arr['document_date'];?></td>
        <td ><?php echo $arr['due_date'];?></td>
        <td ><?php echo number_format($arr['total_amount']);?></td>
        <td ><?php echo $arr['tax_reg_no'];?></td>
        <td ><?php echo $arr['faktur_pajak_no'];?></td>
        <td ><?php echo $arr['tax_id'];?></td>
        <td ><?php echo $arr['address'];?></td>  
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
	function klikallcekbox(){
		alert('test');
		$('.cekboxpilih').each(function(){ //iterate all listed checkbox items
		this.checked = true; //change ".checkbox" checked status
	});
	}			
		
		function bukaModalHelmizz301(param1,param2,param3,param4)
	{
		$('#loading').modal('show');
		$(param1).load(param2,
		param3,
			function(responseTxt, statusTxt, xhr){
				if(statusTxt == "success")
				{
					$('#loading').modal('hide');
					$(param4).modal('show');	
				}
				if(statusTxt == "error")
					alert("Data Not Found : " + xhr.status + ": " + xhr.statusText);
				}
		);
	}
</script>