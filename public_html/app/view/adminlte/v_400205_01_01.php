<?php

	// data PO Header -------------
	$sql001='"select * from invoice where purchase_order_no='."'".$_REQUEST["po_no"]."'".'"';
	$exec_sql001=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql001);
	$json_exec_sql001=json_decode($exec_sql001,true);
	$data_header=$json_exec_sql001[rows][0];
	$namafilepdf = ".".$_REQUEST["po_no"].".pdf";
	
?>
<div class="modal fade" id="tampil2" role="dialog" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title" id="exampleModalCenterTitle">REVISI INV RECEIPT # <?php echo $_REQUEST["po_no"]; ?></h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" align="left"> 
				<embed src="_docs/FP/<?php echo $namafilepdf;?>" frameborder="0" width="100%" height="250px">	
				<br>			
                <form role="form" id="my_form" action="index.php" method="post" enctype="multipart/form-data">
                  <div class="box-body">
				  <label>Proses :</label></br>
					 <input name="proses" type="radio" value="1"> Proses Manual
					 <input name="proses" type="radio" value="2"> Supplier Harus Upload Ulang </br>
					<label>HPP / VAT :</label></br>
					 <input name="address" type="text" value="<?php echo number_format($data_header['total_amount']) ?>" size="45" disabled> 
					 <input name="address" type="text" value="<?php echo number_format($data_header['vat_amount']) ?>" size="45" disabled >
					 </br>					 
					<label>Link :</label></br>
					 <input name="address" type="text" value="" size="135"> </br>               
					</div><!-- /.box-body -->
					<div class="box-footer" align="center">  
					<input type="hidden" name="main" value="040">
					<input type="hidden" name="main_act" value="010">
					<input type="hidden" name="main_id" value="400205_01_02">
					<input type="hidden" name="po_no" value="<?php echo $_REQUEST["po_no"]; ?>">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit"  class="btn btn-primary" >Submit</button>
                  </div>	
                </form>
 			</div>
		</div>	
	 </div>	 
</div>
<div class="clearfix"></div> 
<script>
$("#my_form").submit(function(event){
	// alert('data disubmit');
	//$('#loading').modal('show');
    event.preventDefault(); //prevent default action 
    var post_url = $(this).attr("action"); //get form action url
    var request_method = $(this).attr("method"); //get form GET/POST method
	var form_data = new FormData(this); //Creates new FormData object
    $.ajax({
        url : post_url,
        type: request_method,
        data : form_data,
		contentType: false,
		cache: false,
		processData:false
    }).done(function(response){ //
        //$("#server-results").html(response);
		if(response=='success'){
			alert('Revisi Berhasil ...');
			$(".close").click()
			cobaxx('REVISI+DATA','400205');
		}
		else
		{
			alert('Gagal Revisi...');
			alert(response);
			return false;
		}		
    });
});
</script>