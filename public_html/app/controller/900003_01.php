<?php
include_once($_MAIN__CONFIGS_000[4].'inc_condition.php');

// $sql_400401_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
$sql_400401_02 = "select * from fix_barcode where MP_BARCODE_NEW is null or  MP_BARCODE_NEW=''".$sql_400401_01;
//die($sql_400401_02);
$rs = $db->Execute($sql_400401_02); 
?>

			<?php  //echo $sql_400401_02;?>
			<TABLE id="tbl01"  class="table table-striped table-bordered" style="padding:0px;">
			<THEAD>
				  <tr valign="top">
					<td align="center"><b>DIVISI</b></td> 
					<td align="center"><b>DEPT</b></td>
					<td align="center"><b>PRODUCT CODE</b></td>
					<td align="center"><b>BARCODE</b></td>
					<td align="center"><b>NAME PRODUK</td>
					<td align="center"><b>KONVERSI KARTON</td>
					<td align="center"><b>INPUT REVISI BARCODE</b></td>
					<td align="center"><b>ACTION</b></td>
				  </tr>
			</THEAD>
			<TBODY>
<?php if ($rs) 
while ($arr = $rs->FetchRow()) { 
$x++;
$kode_product=$arr["kode_product"];
?>

      <tr valign="top">
        <td align="center" ><?php echo $arr['divisi'];?></td>
        <td ><?php echo $arr['departemen'];?></td>
        <td ><?php echo $arr['mp_sku'];?></td>
        <td align="center"><?php echo $arr['mp_barcode'];?></td>
        <td align="center"><?php echo $arr['mp_descp'];?></td>
        <td align="center"><?php echo $arr['mp_conv2'];?></td>
        
        <td align="center"><input type="text" name="area_1_<?php echo $x;?>" id="a<?php echo $x;?>" > </td>       
        <td  align="center">
		<input type="hidden" name="k<?php echo $x;?>" id="k<?php echo $x;?>" value="<?php echo $arr['mp_sku'];?>">
		<button onclick="updatedata_900003_01('a<?php echo $x;?>','k<?php echo $x;?>')" type="button"  name="ccc" class="btn btn-primary" id="s<?php echo $x;?>" >Submit</button></td>
      </tr>

<?php } ?>
</TBODY>
</TABLE>
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
function updatedata_900003_01(param1,param2){
	var urlaction="https://vms.supereco.id/index.php?main=040&main_act=010&main_id=900003_01_01&"
	var v1 = $("#"+param1).val();
	var v2 = $("#"+param2).val();
	var paramlengkap="p1="+v1+"&p2="+v2;
	var url=urlaction+paramlengkap;

  $.ajax({url: url, success: function(result){
    // $("#div1").html(result);
  }}).done(function(response){ //
	// alert('test');
        // $("#server-results").html(response);
		// alert(response);
		if(response=='success'){
			alert('Data Sudah masuk ke database....!');
			$(".close").click()
			 cobaxx('PROSES+REVISI+BARCODE','900003');
		}
		else
		{
			alert('Gagal Masuk ke database...');
			return false;
		}		
    });
	
}
</script>