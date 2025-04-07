<?php

	// data PO Header -------------
	$sql001='"select * from purchase_order where purchase_order_no='."'".$_REQUEST["param_menu3"]."'".'"';
	$exec_sql001=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql001);
	$json_exec_sql001=json_decode($exec_sql001,true);
	$data_header=$json_exec_sql001[rows][0];
	
?>
<div class="modal fade" id="tampil2" role="dialog" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title" id="exampleModalCenterTitle">REQUEST CANCEL PO # <?= $_REQUEST["po_no"]; ?></h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" align="left">               
                <form role="form" id="my_form" action="index.php" method="post" enctype="multipart/form-data">
                  <div class="box-body">				  
					<label>Reason :</label></br>
					 <input name="reason1" type="checkbox" value="Tax Rate Salah"> Tax Rate Salah </br>
					 <input name="reason2" type="checkbox"  value="Unit Price Salah"> Unit Price Salah </br>
					 <input name="reason3" type="checkbox"  value="Others"> Others </br>   
					<label>Note :</label>
					  <textarea name="user_req_note" class="form-control" rows="5" placeholder="please fill notes"></textarea>             
					</div><!-- /.box-body -->
					<div class="box-footer" align="center">  
					<input type="hidden" name="main" value="040">
					<input type="hidden" name="main_act" value="010">
					<input type="hidden" name="main_id" value="400401_01_03">
					<input type="hidden" name="purchase_order_no" value="<?= $_REQUEST["po_no"]; ?>">
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
			alert('Request cancel PO Sudah diproses, Menunggu confirm dari SUPERECO ...');
			$(".close").click()
			cobaxx('PURCHASE+ORDER','400401');
		}
		else
		{
			alert('Gagal request to cancel...');
			return false;
		}		
    });
});
</script>