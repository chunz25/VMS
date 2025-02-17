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
        </section> -->
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


<?php
$sql = "SELECT * FROM supplier";
$rs = $db->Execute($sql); ?>

<TABLE id="tbl01"  class="table table-striped table-bordered" style="padding:0px;">
<THEAD>
      <tr valign="top">
       
        <td align="center"><b>SUPPLIER_CODE</b></td>
        <td align="center"><b>NAME</b></td>
        <td align="center"><b>ADDRESS1</b></td>
        <td align="center"><b>ADDRESS2</b></td>
        <td align="center"><b>CITY</b></td>
        <td align="center"><b>NPWP</b></td>
        <td align="center"><b>CATEGORY_SUPPLIER</b></td>
        <td align="center"><b>DEPARTMENT</b></td>
      </tr>
</THEAD>
<TBODY>
<?php if ($rs) 
while ($arr = $rs->FetchRow()) { ?>
      <tr valign="top">
       
        <td ><?php echo $arr['supplier_code'];?></td>
        <td ><?php echo $arr['name'];?></td>
        <td ><?php echo $arr['address1'];?></td>
        <td ><?php echo $arr['address2'];?></td>
        <td ><?php echo $arr['city'];?></td>
        <td ><?php echo $arr['npwp'];?></td>
       
        <td ><?php echo $arr['category_supplier'];?></td>
        <td ><?php echo $arr['department'];?></td>
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