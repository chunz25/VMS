<?php
$sql = "SELECT * FROM tb_user where tb_id_user_type=5";
$rs = $db->Execute($sql); 
//echo __FILE__;
?>
<div class="box-body table-responsive" style="padding:2px;">
<TABLE id="tbl05"  class="table table-striped table-bordered" style="padding:0px;">
<THEAD>
      <tr valign="top">         
        <td align="center"><b>USERNAME</b></td>       
        <td align="center"><b>SUPPLIER CODE</b></td> 
        <td align="center"><b>SUPPLIER NAME</b></td> 
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
        
        <td ><?php echo $arr['username'];?></td>      
        <td ><?php echo $arr['supplier_code'];?></td>
        <td ><?php echo $arr['supplier_name'];?></td>
        <td ><?php echo $arr['department'];?></td>
        <td ><?php echo $arr['supplier_group'];?></td>
		<td ><?php echo $arr['email'];?></td>
		<td ><?php echo $arr['last_login'];?></td>
        <td ><span class='label label-success'><i class="fa fa-whatsapp"></i></span></td>
      </tr>
<?php } ?>
</TBODY>
</TABLE>
</div>