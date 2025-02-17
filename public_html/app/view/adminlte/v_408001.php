
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $_REQUEST["param_menu1"];?>
            <small>preview of simple tables</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Tables</a></li>
            <li class="active">Simple</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-3">			
			<div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Search / Filter</h3>
                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <div class="form-group">
                    <input class="form-control" placeholder="NO HandPhone:" onblur="ubahContentBlok(this.value)"/>
					</div>				
					</ul>
					<ul>
					<center><button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Search / Cari</button></center> 
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
			
             <div class="box box-solid">
<!-- BLOK1 START ----------------------------------------->
			 <div id="blok1">
                <table class="table table-bordered">
                    <tr>
                      <td colspan="2"><h4>Ibu Alisha</h4></td>
                    </tr>
					<tr>
                      <td>Cust No</td>
                      <td><b>12131212</b></td>
                    </tr>
					<tr>
                      <td>No HP</td>
                      <td><b>081827827282897</b></td>
                    </tr>
					<tr>
                      <td>Cust Group</td>
                      <td><b>Retailer</b></td>
                    </tr>
                    <tr>
                      <td>Nama Usaha</td>
                      <td><b>Toko Alisha</b></td>
                    </tr>
					<tr>
                      <td>Alamat</td>
                      <td><b>Gunung Putri Bogor</b></td>
                    </tr>
					<tr>
                      <td>Last Visit</td>
                      <td><b>Minggu, 25 Jan 2019</b></td>
                    </tr>
					<tr>
                      <td>MTD Sales</td>
                      <td><b>23.293.000</b></td>
                    </tr>
					<tr>
                      <td>YTD Sales</td>
                      <td><b>23.293.000</b></td>
                    </tr>
					</table>
				</div>
<!-- BLOK1 END ----------------------------------------->
              </div><!-- /.box -->
			  
			  
			  
			  
			  </div><!-- /.col -->
			  <div class="col-md-9">
			  <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Bordered Table</h3>
                </div><!-- /.box-header -->
                <div class="box-body" >
					<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
					  <li class="active" style="background-color:#aabbcc"><a href="#tab1" data-toggle="tab">Profile Customer</a></li>
					  <li style="background-color:#aabbcc"><a href="#tab2" data-toggle="tab">Top Artikel</a></li>
					  <li style="background-color:#aabbcc"><a href="#tab3" data-toggle="tab">Sales Contribution</a></li>
					  <li style="background-color:#aabbcc"><a href="#tab4" data-toggle="tab">Sales History</a></li>                 
					</ul>
					</div>
				<div class="tab-content">
				<div class="tab-pane" id="tab1" >
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Task</th>
                      <th>Progress</th>
                      <th style="width: 40px">Label</th>
                    </tr>
                    <tr>
                      <td>1.</td>
                      <td>Update software</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-red">55%</span></td>
                    </tr>
                    <tr>
                      <td>2.</td>
                      <td>Clean database</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-yellow">70%</span></td>
                    </tr>
                    <tr>
                      <td>3.</td>
                      <td>Cron job running</td>
                      <td>
                        <div class="progress progress-xs progress-striped active">
                          <div class="progress-bar progress-bar-primary" style="width: 30%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-light-blue">30%</span></td>
                    </tr>
                    <tr>
                      <td>4.</td>
                      <td>Fix and squish bugs</td>
                      <td>
                        <div class="progress progress-xs progress-striped active">
                          <div class="progress-bar progress-bar-success" style="width: 90%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-green">90%</span></td>
                    </tr>
                  </table>
				  </div>
				 
					<div class="tab-pane" id="tab2" >
						<div class="box box-solid">
							<div class="box-header with-border">
							  <i class="fa fa-text-width"></i>
							  <h3 class="box-title">Description Horizontal</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
							  <dl class="dl-horizontal">
								<dt>Nama Usaha</dt>
								<dd>Toko Alisha</dd>
								<dt>PIC</dt>
								<dd>Ibu Alisha</dd>
								<dt>Malesuada porta</dt>
								<dd>Etiam porta sem malesuada magna mollis euismod.</dd>
								<dt>Felis euismod semper eget lacinia</dt>
								<dd>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</dd>
							  </dl>
							</div><!-- /.box-body -->
						  </div><!-- /.box -->
					</div>
					
					<div class="tab-pane" id="tab3" >
						Tab 3
					</div>
					
					<div class="tab-pane" id="tab4" >
						<ul class="timeline">
						<?php
						$ii=0;
						while($ii<100){
							$ii++;
							?>
								<!-- timeline time label -->
								<li class="time-label">
									<span class="bg-red">
										Minggu, <?php echo $ii;?> Feb. 2014
									</span>
								</li>
								<!-- /.timeline-label -->
								<!-- timeline item -->
								<li>
									<!-- timeline icon -->
									<i class="fa fa-envelope bg-blue"><?php echo $ii;?></i>
									<div class="timeline-item">
										<span class="time"><i class="fa fa-clock-o"></i> Minggu, 15 agustus 2019 12:05</span>

										<h3 class="timeline-header"><a href="#">INV NO : <?php echo $ii;?> </a> | Tot Sales : <?php echo $ii;?>.000.000 </h3>							
									</div>
								</li>
								<!-- END timeline item -->
						<?php }?>
								
								

								

							</ul>
					</div>
				  </div>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->
			</div><!-- /.col -->
			
          </div><!-- /.row -->
          
       
        </section><!-- /.content -->
		<script>
		function ubahContentBlok(param)
		{
			alert(param);
		}
		</script>
