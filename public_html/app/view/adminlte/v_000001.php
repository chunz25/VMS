<?php
switch ($_SESSION['tb_id_user_type']) {
    case 1:
        $info1="Sys Admin";
        $info3="1";
        $info4=$_SESSION['email'];
        break;
    case 2:
		$info1="Buyer";
        $info3="2";
        $info4=$_SESSION['email'];
        break;
    case 3:
		$info1="Finance";
        $info3="3";
        $info4=$_SESSION['email'];
        break;
	case 4:
		$info1="Goods Receiving";
        $info3="4";
        $info4=$_SESSION['email'];
        break;
	case 5:
        $info1="Supplier";
        $info3="5";
        $info4=$_SESSION['supplier_name'];
        break;
	case 6:
        $info1="Supplier Group";
        $info3="6";
        $info4=$_SESSION['supplier_name'];
        break;
}
$info2=$_SESSION['username'];
?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $_REQUEST["param_menu1"];?>
            <small></small>
          </h1>
          
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-6">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">User Access Profile</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-hover">
                   
                    <tr>                    
                      <td align="right">Type User </td>
                      <td>
                        <?php echo $info1?>
                      </td> 
                    </tr>
					<tr>  
                      <td align="right">Username </td>
                      <td>
                        <b><?php echo $_SESSION['username']?></b>
                      </td>  
                    </tr>
					<tr>  
                      <td align="right">Email </td>
                      <td>
                        <b><?php echo $_SESSION['email']?></b>
                      </td>  
                    </tr>
					<tr>  
                      <td align="right">Supplier Group</td>
                      <td>
                        <b><?php echo $_SESSION['supplier_group']?></b>
                      </td>  
                    </tr>
					<tr>  
                      <td align="right">Supplier Name</td>
                      <td>
                        <b><?php echo $_SESSION['supplier_name']?></b>
                      </td>  
                    </tr>
					<tr>  
                      <td align="right">Full Name PIC</td>
                      <td>
                        <b><?php echo $_SESSION['fullname']?></b>
                      </td>  
                    </tr>
					<tr>  
                      <td align="right">Handphone</td>
                      <td>
                        <b><?php echo $_SESSION['hp']?></b>
                      </td>  
                    </tr>
					<tr>  
                      <td align="right">Last login</td>
                      <td>
                        <b><?php echo $_SESSION['last_login']?></b>
                      </td>  
                    </tr>
                  </table>
				  <?php //print_r($_SESSION); ?>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                 
                </div>
              </div><!-- /.box -->
			  </div><!-- /.col -->
			  <div class="col-md-6">
			  <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Change Password</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
				<form id="my_form" method="post">
					<table class="table table-bordered table-hover">
                   
                    <tr>                    
                      <td align="right">Type User :</td>
                      <td>
                        <?php echo $info1?>
                      </td> 
                    </tr>
					<tr>  
                      <td align="right">Username :</td>
                      <td>
                        <b><?php echo $_SESSION['username']?></b>
                      </td>  
                    </tr>
					
					<tr>  
                      <td align="right">Old Password :</td>
                      <td>
                       <input type="password" name="pwd_old">
                      </td>  
                    </tr>
					<tr>  
                      <td align="right">New Password :</td>
                      <td>
                        <input type="password" name="pwd_new">
                      </td>  
                    </tr>
					<tr>  
                      <td align="right">Re type New Password :</td>
                      <td>
                        <input type="password" name="pwd_new2">
                      </td>  
                    </tr>
					<tr>  
                      
                      <td colspan="2" align="center">
                        <input type="submit" name="Change Password">
                      </td>  
                    </tr>
                  </table>
				  <input type="hidden" name="main" value="040">
					<input type="hidden" name="main_act" value="010">
					<input type="hidden" name="main_id" value="000001_01">
				  </form>
              </div><!-- /.box -->
			</div><!-- /.col -->
			
          </div><!-- /.row -->
          
        </section><!-- /.content -->

<script>
$("#my_form").submit(function(event){
	 if(confirm('Apakah benar Password mau diubah...?')){
	//$('#loading').modal('show');
    event.preventDefault(); //prevent default action 
    var post_url = $(this).attr("action"); //get form action url
    var request_method = $(this).attr("method"); //get form GET/POST method
	var form_data = new FormData(this); //Creates new FormData object
    $.ajax({
        url : post_url,
        type: request_method,
        data : form_data,
		contentType: false,
		cache: false,
		processData:false
    }).done(function(response){ //
        //$("#server-results").html(response);
		alert(response);
		if(response=='success'){
			alert('Password sudah Berubah ');
			
			//$(".close").click()
			cobayy('PROFILE','000001','');
		}
		else
		{
			alert('Gagal Ubah Password');
			return false;
		}		
    });
	 }
	 else
	 {
		 return false;
	 }
});
</script>
