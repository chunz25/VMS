<?php
include_once($_MAIN__CONFIGS_000[4].'inc_condition.php');

// $sql_400401_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
$sql_400401_02 = "SELECT supplier,divisi,MP_SKU,MP_BARCODE,MP_DESCP,MP_CONV1,MP_CONV2,MP_STOCK,MPR_PRICE0  `SALE_PRICE_KARTON`,MPR_PRICE1 `SALE_PRICE_PACK`,MPR_PRICE2 SALE_PRICE_PCS , MINIMAL_JUAL,(MP_CONV2/MP_CONV1) as ISI_PACK_DALAM_PCS FROM supereco_vms_db.v_bocis_produk_saleprice WHERE  mp_stock>0 order by supplier ";
//die($sql_400401_02);
$rs = $db->Execute($sql_400401_02); 

/*













*/
?>
<style>
	.table.dataTable  {
		font-family: Verdana, Geneva, Tahoma, sans-serif;
		font-size: 10;
		
	}
	table.dataTable td {
	  font-size: 10px;
	 padding : 5px;
	}
	</style>
			<?php  //echo $sql_400401_02;?>
			<TABLE id="tbl01"  class="table table-striped table-bordered" style="padding:0px;">
			<THEAD>
				  <tr valign="top">
					
        <td align="center"><b>SUPPLIER</b></td>   
            
        <td align="center"><b>SKU</b></td>
        <td align="center"><b>BARCODE</b></td>
        <td align="center"><b>NAMA PRODUCT</b></td>       
        <td align="center"><b>ISI BANDED (PCS)</b></td>
        <td align="center"><b>ISI KARTON (PCS)</b></td>      
             
        <td align="center"><b>STOK</b></td>       
        <td align="center"><b>HRG JUAL KARTON</b></td>
        <td align="center"><b>HRG JUAL PACK</b></td>
        <td align="center"><b>HRG JUAL PCS</b></td>
        <td align="center"><b>MINIMAL JUAL</b></td>
        
		
	</tr>
	</THEAD>
<TBODY>
<?php if ($rs) 
while ($arr = $rs->FetchRow()) { 

?>
      <tr valign="top">
        <td align="center" ><?php echo $arr['supplier'];?></td>       
        <td align="center"><?php echo $arr['mp_sku'];?></td>
        <td align="center"><?php echo $arr['mp_barcode'];?></td>
        <td align="center"><?php echo $arr['mp_descp'];?></td>
        <td  align="right"><?php echo number_format($arr['isi_pack_dalam_pcs'],0,',','.');?></td>
        <td  align="right"><?php echo number_format($arr['mp_conv2'],0,',','.');?></td>      
        <td  align="right"><?php echo number_format($arr['mp_stock'],0,',','.');?></td>
        <td  align="right"><?php echo number_format($arr['sale_price_karton'],0,',','.');?></td>
        <td  align="right"><?php echo number_format($arr['sale_price_pack'],0,',','.');?></td>
        <td  align="right"><?php echo number_format($arr['sale_price_pcs'],0,',','.');?></td>
        <td  align="right"><?php echo number_format($arr['minimal_jual'],0,',','.');?></td>             
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
		$('#tbl01').DataTable({
    "Paginate": false,
	"pageLength": 50
  });		
</script>	