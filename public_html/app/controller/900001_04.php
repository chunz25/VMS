<?php
include_once($_MAIN__CONFIGS_000[4].'inc_condition.php');

// $sql_400401_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
$sql_400401_02 = "select * from stock_opname_result_v where stock_qty>0 and (qty_1>0 or qty_2>0 or qty_3>0) ".$sql_400401_01;
//die($sql_400401_02);
$rs = $db->Execute($sql_400401_02); 
?>

			<?php  //echo $sql_400401_02;?>
			<TABLE id="tbl04"  class="table table-striped table-bordered" style="padding:0px;">
			<THEAD>
				  <tr valign="top">
					<td align="center"><b>DIVISI</b></td> 
					<td align="center"><b>DEPT</b></td>
					<td align="center"><b>BARCODE</b></td>
					<td align="center"><b>NAME PRODUK</td>
					<td align="center"><b>KONVERSI KARTON</td>
					<td align="center"><b>INPUT QTY 1</b></td>
					<td align="center"><b>INPUT QTY 2</b></td>
					<td align="center"><b>INPUT QTY 3</b></td>
					<td align="center"><b>AREA</b></td>
					<td align="center"><b>USER INPUT</b></td>
					
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
        <td align="center"><?php echo $arr['qty_1'];?></td>
        <td align="center"><?php echo $arr['qty_2'];?></td>       
        <td align="center"><?php echo $arr['qty_3'];?></td>       
        <td align="center"><?php echo $arr['area'];?></td>       
        <td align="center"><?php echo $arr['user_input'];?> | <?php echo $arr['user_input2'];?> | <?php echo $arr['user_input3'];?></td>       
        
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
