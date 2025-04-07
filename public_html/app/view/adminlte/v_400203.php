<!-- Content Header (Page header) -->
        <!-- <section class="content-header">
          <font size="10">
           <b> <?= $_REQUEST["param_menu1"];?></b>
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
           <b> <?= $_REQUEST["param_menu1"];?></b>
          </font>
              
            </div> 
            <div class="box-body table-responsive" style="padding:2px;">


<?php
$sql = "SELECT * FROM product";
$rs = $db->Execute($sql); ?>

<TABLE id="tbl01"  class="table table-striped table-bordered" style="padding:0px;">
<THEAD>
      <tr valign="top">
        
        <td align="center"><b>PRODUCT_CODE</b></td>
        <td align="center"><b>BARCODE</b></td>
        <td align="center"><b>DESCRIPTION</b></td>
        <td align="center"><b>BRAND</b></td>
        <td align="center"><b>DIMENSION</b></td>
        <td align="center"><b>WEIGHT</b></td>
        <td align="center"><b>UOM</b></td>
        <td align="center"><b>TAX_PCT</b></td>
        <td align="center"><b>ACTIVE</b></td>
       
      </tr>
</THEAD>
<TBODY>
<?php if ($rs) 
while ($arr = $rs->FetchRow()) { ?>
      <tr valign="top">
       
        <td ><?= $arr['product_code'];?></td>
        <td ><?= $arr['barcode'];?></td>
        <td ><?= $arr['description'];?></td>
        <td ><?= $arr['brand'];?></td>
        <td ><?= $arr['dimension'];?></td>
        <td ><?= $arr['weight'];?></td>
        <td ><?= $arr['uom'];?></td>
        <td ><?= $arr['tax_pct'];?></td>
        <td ><?= $arr['active'];?></td>
        
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