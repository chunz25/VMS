<?php


	
?>
<style>
		.tabelpopup {
			width:100%;
			border:1px solid #b3adad;
			border-collapse:collapse;
			padding:5px;
		}
		
		.tdpopup {
			border:1px solid #b3adad;
			padding:5px;
			background: #ffffff;
			color: #313030;
		}
	</style>
<div class="modal fade" id="tampil07" role="dialog" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalCenterTitle">CREATE GROUP USER </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" align="left">               
                <form role="form" id="form_cancel_po" action="index.php" method="post" enctype="multipart/form-data">
                  <div class="box-body">				  
					<table class="tabelpopup">
		
				<tbody>
					<tr >
						<td class="tdpopup" align="right" width="40%">Type User</td>
						<td class="tdpopup"><b>Product</b></td>		
					</tr>
					<tr >
						<td class="tdpopup" align="right" width="40%">Group Akses</td>
						<td class="tdpopup"><b>Product Group User</b></td>	
					</tr>
					<tr >
						<td class="tdpopup" align="right" width="40%">Nama lengkap</td>
						<td class="tdpopup"><input type="text" class="form-control" name="nama_lengkap" value="" style="background-color:lightblue;"></td>	
					</tr>
					
					<tr >
						<td class="tdpopup" align="right" width="40%">Username</td>
						<td class="tdpopup"><input type="text" class="form-control" name="username" value="" style="background-color:lightblue;"></td>	
					</tr>
					<tr >
						<td class="tdpopup" align="right" width="40%">Password</td>
						<td class="tdpopup"><input type="password" class="form-control" name="password" value="" style="background-color:lightblue;"></td>	
					</tr>
					<tr >
						<td class="tdpopup" align="right" width="40%">Email</td>
						<td class="tdpopup"><input type="text" class="form-control" name="email" value="" style="background-color:lightblue;"></td>	
					</tr>
					<tr >
						<td class="tdpopup" align="right" width="40%">No HP</td>
						<td class="tdpopup"><input type="text" class="form-control" name="no_hp" value="" style="background-color:lightblue;"></td>	
					</tr>
					<tr >
						<td class="tdpopup" align="right" width="40%">Department</td>
						<td class="tdpopup"><input type="text" class="form-control" name="department" value="" style="background-color:lightblue;"></td>	
					</tr>
					
					
				</tbody>
	</table>          
					</div><!-- /.box-body -->
					<div class="box-footer" align="center">  
					<input type="hidden" name="main" value="040">
					<input type="hidden" name="main_act" value="010">
					<input type="hidden" name="main_id" value="400401_01_03">
					<input type="hidden" name="purchase_order_no" value="<?php echo $_REQUEST["po_no"]; ?>">
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
$("#form_cancel_po").submit(function(event){
	// alert('data disubmit yaaaaaaaaaaa.........');
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
		// alert('test');
        // $("#server-results").html(response);
		// alert(response);
		if(response=='success'){
			alert('Request cancel PO Sudah diproses, Menunggu confirm dari ELECTRONIC CITY ...');		
			var targetUrlCP = "index.php";
			var postDataCP = {
				main: "030",
				showFirst1: "Purchase+Order",
				showFirst2: "400401",
				showFirst3: "2"
			};
			// Panggil fungsi untuk melakukan redirect dengan metode POST
			redirectWithPost(targetUrlCP, postDataCP);
		}
		else
		{
			alert('Gagal request to cancel...');
			return false;
		}		
    });
});
</script>