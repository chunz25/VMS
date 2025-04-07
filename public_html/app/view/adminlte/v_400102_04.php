<?php
$sql = "SELECT * FROM tb_user  where tb_id_user_type=4";
$rs = $db->Execute($sql); 
//echo __FILE__;
?>
<div class="box-body table-responsive" style="padding:2px;">
<TABLE id="tbl04"  class="table table-striped table-bordered" style="padding:0px;">
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
</div>