<?php

// tab navigation and style ---------
$tab_title = array("USER BUYER","USER STORE","USER SUPPLIER","USER MANAGEMENT","USER TYPE","USER GROUP","HIST USER MGT","HIST USER ACCESS");
$tab_ahref = array("tabcontent1","tabcontent2","tabcontent3","tabcontent4","tabcontent5","tabcontent6","tabcontent7","tabcontent8");
$tab_status_active =2;
$style_tab = "background-color:#ccddee";
//

// tab content -----------------------
$tab_content_file = array("400201_01","400201_02","400201_03","400201_04","400201_05","400201_06","400201_07","400201_08");


?>
<!-- Content Header (Page header) -->
<section class="content" style="padding:3px;">
    <div class="box box-solid" id="isicontentovl" style="padding:0px;" > <!--style="overflow-y:auto;padding:0px;"-->
			<div class="box-header with-border">
              <font size="3"><b> <?= $_REQUEST["param_menu1"];?></b></font>
			  <div class="box-tools pull-right">
                <button class="btn btn-primary btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="klikallcekbox();">SELECT ALL</button> 
					<button class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#add01" >XEDIT</button> 
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
            
			<div class="box-body" style="padding:2px;">			
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
					<?php 
						foreach ($tab_title as $tab_title_index => $tab_title_content){
						$tab_class=($tab_title_index==$tab_status_active) ? "active" : "";
					?><li class="<?= $tab_class ?>" style="<?= $style_tab; ?>"><a href="#<?= $tab_ahref[$tab_title_index]; ?>" data-toggle="tab" ><?= $tab_title_content; ?></a></li>
					<?php 
						}
					?>                 
					</ul>
				</div>
			
				<div class="tab-content">
					<?php 
						foreach ($tab_ahref as $tab_ahref_index => $tab_ahref_content){
						$tab_class2=($tab_ahref_index==$tab_status_active) ? "tab-pane active" : "tab-pane";
					?>
					<div class="<?= $tab_class2 ?>" id="<?= $tab_ahref_content ?>" >
						<?php include $tab_content_file[$tab_ahref_index].".php"; ?>
					</div>
					<?php 
						}
					?> 
				</div>
		
		</div><!-- /.box-body -->
    </div><!-- /.box -->

</section><!-- /.content -->