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
				<h4 class="modal-title" id="exampleModalCenterTitle">UPLOAD ULANG FAKTUR PAJAK # <?php echo $_REQUEST["po_no"]; ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" align="left"> 
				<label>Faktur Pajak Sebelumnya :</label>
				<?php //if(is_file('_docs/FP/'.$namafilepdf)){ ?>
				<embed src="_docs/FP/<?php echo $namafilepdf;?>" frameborder="0" width="100%" height="180px">	
				<?php //}
					//else
					//{
					//	echo "File Faktur Pajak Tidak ditemukan";
					//}	
					?>
							
                <form role="form" id="my_form" action="index.php" method="post" enctype="multipart/form-data">
                  <div class="box-body">
					<label>HPP / VAT :</label></br>
					 <input name="total_amountx" type="text" value="<?php echo number_format($data_header['total_amount']) ?>" size="45" readonly> 
					 <input name="vat_amountx" type="text" value="<?php echo number_format($data_header['vat_amount']) ?>" size="45" readonly >
					 </br>
					 </br>
				<div class="alert alert-info alert-dismissable">
					<label for="Notes">Catatan</label></br>
					  - File Pajak yang diUpload, harus File Asli dari DJP ( PAJAK )</br>
					  - Selisih Pembulatan Total Amount < 1000 ,
					  Selisih Pembulatan Pajak < 100 </br>
				</div>
					<div class="form-group">
                      <label for="exampleInputFile">File Faktur Pajak</label>
                      <input type="file" id="exampleInputFile" name="fakturpajak">
                    </div>             
					<div class="box-footer" align="center">  
					<input type="hidden" name="main" value="040">
					<input type="hidden" name="main_act" value="010">
					<input type="hidden" name="main_id" value="400405_01_03">
					<input type="hidden" name="total_amount" value="<?php echo $data_header['total_amount']; ?>">
					<input type="hidden" name="vat_amount" value="<?php echo $data_header['vat_amount']; ?>">
					<input type="hidden" name="po_no" value="<?php echo $_REQUEST["po_no"]; ?>">
					<input type="hidden" name="newnamefile" value="<?php echo $_REQUEST["po_no"]; ?>">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit"  class="btn btn-primary" >Submit</button>
                  </div>	
				  </div>
                </form>
 			</div>
		</div>	
	 </div>	 
</div>
<div class="clearfix"></div> 
<script>
$("#my_form").submit(function(event){
	 alert('Apakah File yang dipilih sudah benar.. ?');
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
			alert('Upload Ulang Faktur Pajak Berhasil ...');
			$(".close").click()
			cobaxx('INVOICE+RECEIPT','400405');
		}
		else
		{
			alert('Gagal Upload Ulang Faktur Pajak ...');
			alert(response);
			return false;
		}		
    });
});
</script>