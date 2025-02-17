<?php
$sql = "SELECT * FROM tb_user where tb_id_user_type=3";
$rs = $db->Execute($sql); 
//echo __FILE__;
?>
<div class="box-body table-responsive" style="padding:2px;">
<TABLE id="tbl03"  class="table table-striped table-bordered" style="padding:0px;">
<THEAD>
      <tr valign="top">        
        <td align="center"><b>EMAIL</b></td>
        <td align="center"><b>USERNAME</b></td>       
        <td align="center"><b>EMPLOYEE_NO</b></td>
        <td align="center"><b>STORE_CODE</b></td>      
      </tr>
</THEAD>
<TBODY>
<?php if ($rs) 
while ($arr = $rs->FetchRow()) { ?>
      <tr valign="top">  
        <td ><?php echo $arr['email'];?></td>
        <td ><?php echo $arr['username'];?></td>      
        <td ><?php echo $arr['employee_no'];?></td>
        <td ><?php echo $arr['store_code'];?></td>
      </tr>
<?php } ?>
</TBODY>
</TABLE>
</div>