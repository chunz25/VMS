
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?= $_REQUEST["param_menu1"];?>
            
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
		 
          <div class="row">
            <div class="col-md-6">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">TAX REPORT FROM B2B</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
				
                   <form role="form" id="my_form" action="index.php" method="post" target="_reportwindow">              				  
					<label>Date From :</label></br>
					 <div class="input-group date"> 
						<div class="input-group-addon">
						<span class="glyphicon glyphicon-th"></span>
						</div>
						<input placeholder="Date from" type="text" class="form-control datepicker" name="date_from">
					  </div> 
					<label>Date To :</label>
					  <div class="input-group date"> 
						<div class="input-group-addon">
						<span class="glyphicon glyphicon-th"></span>
						</div>
						<input placeholder="Date To" type="text" class="form-control datepicker" name="date_to">
					  </div>            
					
					<div class="box-footer" align="center">  
					<input type="hidden" name="main" value="060">
					<input type="hidden" name="main_act" value="060">
					<input type="hidden" name="main_id" value="400901_001">
					<button type="submit"  class="btn btn-primary" >Create Report</button>
                  </div>	
                </form>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->
			  
			  
			  </div><!-- /.col -->
			  <div class="col-md-6">
			  
			  
			  
			
          </div><!-- /.row -->
         
		 
		
		 
		 
        </section><!-- /.content -->
<script type="text/javascript">
 $(function(){
  $(".datepicker").datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
  });
 });
</script>