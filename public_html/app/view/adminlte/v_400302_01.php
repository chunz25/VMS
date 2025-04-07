<?php
$sql = "SELECT * FROM tb_user";
$rs = $db->Execute($sql); 
//echo __FILE__;
?>
<TABLE id="tbl01"  class="table table-striped table-bordered" style="padding:0px;">
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
        <td ><?= $arr['email'];?></td>
        <td ><?= $arr['username'];?></td>      
        <td ><?= $arr['employee_no'];?></td>
        <td ><?= $arr['store_code'];?></td>
      </tr>
<?php } ?>
</TBODY>
</TABLE>