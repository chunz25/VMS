<?php
$sql = "SELECT * FROM tb_user where tb_id_user_type=1";
$rs = $db->Execute($sql); 
//echo __FILE__;
?>
<TABLE id="tbl01"  class="table table-striped table-bordered" style="padding:0px;">
<THEAD>
      <tr valign="top">              
        <td align="center"><b>Action</b></td>
		 <td align="center"><b>EMAIL</b></td>
        <td align="center"><b>USERNAME</b></td>       
        <td align="center"><b>EMPLOYEE_NO</b></td>
        <td align="center"><b>STORE_CODE</b></td>      
        <td align="center"><b>SOC MED</b></td>      
      </tr>
</THEAD>
<TBODY>
<?php if ($rs) 
while ($arr = $rs->FetchRow()) { 
$hp=$arr['hp'];
$wa_address="https://api.whatsapp.com/send?phone=".$hp."&text=Halo%20Supplier%0ASaya%20Admin%20B2B%20SUPERECO";
?>
      <tr valign="top">  
       
        <td ><button class="btn btn-info btn-xs" ><i class="fa fa-times" alt="delete this row"></i></button></td>
		 <td ><?php echo $arr['email'];?></td>
        <td ><?php echo $arr['username'];?></td>      
        <td ><?php echo $arr['employee_no'];?></td>
        <td ><?php echo $arr['store_code'];?></td>
        <td align="center" >
		<a href="<?php echo $wa_address;?>" target="whatsappWeb"><button class="btn btn-info btn-xs btn-flat"  data-toggle="tooltip" title="Chat via WhatsApp Web <?php echo $hp;?> " ><i class="fa fa-whatsapp"></i></button></a>
		<button class="btn btn-info btn-xs btn-flat" onclick="mailto:('<?php echo $email;?>');" data-toggle="tooltip" title="Send Email <?php echo $hp;?> " ><i class="fa fa-envelope"></i></button>
		<button class="btn btn-warning btn-xs btn-flat" onclick="window.open('<?php echo $wa_address;?>');" data-toggle="tooltip" title="Reset Password <?php echo $hp;?> " ><i class="fa fa-wrench"></i></button>
		<button class="btn btn-info btn-xs btn-flat" onclick="window.open('<?php echo $wa_address;?>');" data-toggle="tooltip" title="See Detail <?php echo $hp;?> " ><i class="fa fa-search"></i></button>
		</td>
      </tr>
<?php } ?>
</TBODY>
</TABLE>