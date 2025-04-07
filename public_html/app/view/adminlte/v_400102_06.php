<?php
$sql = "SELECT * FROM tb_user where tb_id_user_type=6";
$rs = $db->Execute($sql); 
//echo __FILE__;
?>
<div class="box-body table-responsive" style="padding:2px;">
<TABLE id="tbl06"  class="table table-striped table-bordered" style="padding:0px;">
<THEAD>
      <tr valign="top">         
        <td align="center"><b>USERNAME</b></td>       
        <td align="center"><b>SUPPLIER CODE</b></td> 
        <td align="center" width="300px"><b>SUPPLIER_VENDOR_NAME</b></td> 
        <td align="center"><b>DEPARTMENT</b></td> 
        <td align="center"><b>SUPPLIER GROUP</b></td> 
		<td align="center"><b>EMAIL</b></td>		
        <td align="center"><b>LAST LOGIN</b></td>      
        <td align="center"><b>DETAIL</b></td>      
      </tr>
</THEAD>
<TBODY>
<?php if ($rs) 
while ($arr = $rs->FetchRow()) { ?>
      <tr valign="top">  
        
        <td ><?= $arr['username'];?></td>      
        <td ><?= $arr['supplier_code'];?></td>
        <td ><?= $arr['supplier_name'];?></td>
        <td ><?= $arr['department'];?></td>
        <td ><?= $arr['supplier_group'];?></td>
		<td ><?= $arr['email'];?></td>
		<td ><?= $arr['last_login'];?></td>
        <td ><span class='label label-success'><i class="fa fa-whatsapp"></i></span></td>
      </tr>
<?php } ?>
</TBODY>
</TABLE>
</div>