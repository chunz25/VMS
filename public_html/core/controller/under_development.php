<!-- Content Header (Page header) -->
<!-- <section class="content-header">
          <font size="10">
           <b> <?php echo $_REQUEST["param_menu1"]; ?></b>
          </font>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
          </ol>
        </section> -->
<!-- Main content -->
<section class="content" style="padding:3px;">
  <!-- Default box -->
  <div class="box box-solid" id="isicontent1" style="padding:0px;"> <!--style="overflow-y:auto;padding:0px;"-->
    <!---->
    <div class="box-header with-border">
      <font size="3">
        <b> <?php echo $_REQUEST["param_menu1"]; ?></b>
      </font>
      <div class="box-tools pull-right">
        <button class="btn btn-primary btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="klikallcekbox();">SELECT ALL</button>
        <button class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#add01">XEDIT</button>
        <button class="btn btn-info btn-xs btn-flat" data-toggle="modal" data-target="#add01">DELETE</button>
        <button class="btn btn-primary btn-xs btn-flat" data-toggle="modal" data-target="#add01">PROCESS</button>
        <button class="btn btn-info btn-xs btn-flat" data-toggle="modal" data-target="#add01">PRINT</button>
        <button class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#add01">XLS</button>
        <button class="btn btn-info btn-xs btn-flat" data-toggle="modal" data-target="#add01">PDF</button>
        <a class="btn btn-default btn-flat btn-xs btn-success">
          <i class="fa fa-edit"></i> Edit
        </a>
        <div class="btn-group"></div>
      </div>
    </div>
    <div class="box-body" style="padding:4px;">



    </div><!-- /.box-body -->
    <!-- <div class="box-footer"> 
               Footer 
            </div>  --><!-- /.box-footer-->
    <!-- <div class="overlay">
					  <i class="fa fa-refresh fa-spin"></i>
					</div> -->
  </div><!-- /.box -->

</section><!-- /.content -->
<script>
  function klikallcekbox() {
    alert('test');
    $('.cekboxpilih').each(function() { //iterate all listed checkbox items
      this.checked = true; //change ".checkbox" checked status
    });
  }
</script>