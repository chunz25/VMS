<?php
include_once($_MAIN__CONFIGS_000[4].'inc_condition.php');

// $sql_400401_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
$sql_400401_02 = "select * from stock_opname where MP_STOCK>0 and qty_1<=0  ".$sql_400401_01;
//die($sql_400401_02);
$rs = $db->Execute($sql_400401_02); 
?>

			<?php  //echo $sql_400401_02;?>
			<TABLE id="tbl01"  class="table table-striped table-bordered" style="padding:0px;">
			<THEAD>
				  <tr valign="top">
					<td align="center"><b>DIVISI</b></td> 
					<td align="center"><b>DEPT</b></td>
					<td align="center"><b>BARCODE</b></td>
					<td align="center"><b>NAME PRODUK</td>
					<td align="center"><b>KONVERSI KARTON</td>
					<td align="center"><b>INPUT QTY 1</b></td>
					<td align="center"><b>AREA</b></td>
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
        <td align="center"><?php echo $arr['barcode'];?></td>
        <td align="center"><?php echo $arr['nama_product'];?></td>
        <td align="center"><?php echo $arr['konversi_karton'];?></td>
        <td align="center"><input type="text" name="qty_1_<?php echo $x;?>" id="q<?php echo $x;?>" size="10"> </td>
        <td align="center"><input type="text" name="area_1_<?php echo $x;?>" id="a<?php echo $x;?>" > </td>       
        <td  align="center">
		<input type="hidden" name="k<?php echo $x;?>" id="k<?php echo $x;?>" value="<?php echo $kode_product?>">
		<button onclick="updatedata('q<?php echo $x;?>','a<?php echo $x;?>','k<?php echo $x;?>')" type="button"  name="ccc" class="btn btn-primary" id="s<?php echo $x;?>" >Submit</button></td>
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
function updatedata(param1,param2,param3){
	var urlaction="https://vms.supereco.id/index.php?main=040&main_act=010&main_id=900001_01_01&"
	var v1 = $("#"+param1).val();
	var v2 = $("#"+param2).val();
	var v3 = $("#"+param3).val();
	var paramlengkap="p1="+v1+"&p2="+v2+"&p3="+v3;
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
			// cobaxx('INPUT+STOCK+OPNAME','900001');
		}
		else
		{
			alert('Gagal Masuk ke database...');
			return false;
		}		
    });
	
}
</script>