<?php
include_once($_MAIN__CONFIGS_000[4].'inc_condition.php');

// $sql_400401_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
$sql_400401_02 = "select * from fix_barcode where MP_BARCODE_NEW is not null and MP_BARCODE_NEW<>''  ".$sql_400401_01;
//die($sql_400401_02);
$rs = $db->Execute($sql_400401_02); 
?>

			<?php  //echo $sql_400401_02;?>
			<TABLE id="tbl04"  class="table table-striped table-bordered" style="padding:0px;">
			<THEAD>
				  <tr valign="top">
					<td align="center"><b>DIVISI</b></td> 
					<td align="center"><b>DEPT</b></td>
					<td align="center"><b>PRODUCT CODE</b></td>
					<td align="center"><b>BARCODE</b></td>
					<td align="center"><b>NAME PRODUK</td>
					<td align="center"><b>KONVERSI KARTON</td>
					<td align="center"><b>HASIL REVISI BARCODE</b></td>
					<td align="center"><b>USER INPUT</b></td>
					<td align="center"><b>TANGGAL INPUT</b></td>
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
        
        <td align="center"><?php echo $arr['mp_barcode_new'];?></td>       
        <td align="center"><?php echo $arr['user_input'];?></td>       
        <td align="center"><?php echo $arr['tgl_input'];?></td>       
        
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
