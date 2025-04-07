<?php

// tab navigation and style ---------
//$tab_title = array("INVOICE PROCESS","INVOICE RECEIPT","INVOICE PAID");
$tab_title = array("INVOICE PROCESS");
//$tab_ahref = array("tabcontent1","tabcontent2","tabcontent3");
$tab_ahref = array("tabcontent1");
$tab_status_active =($_REQUEST["param_menu4"]!='') ? ($_REQUEST["param_menu4"]-1) : 0;
$style_tab = "background-color:#ccddee";

// tab content -----------------------
//$tab_content_file = array("400404_01","400404_02","400404_03");
$tab_content_file = array("400404_01");

?>
<!-- Content Header (Page header) -->
<section class="content" style="padding:3px;">
    <div class="box box-solid" id="isicontentovl" style="padding:0px;" > <!--style="overflow-y:auto;padding:0px;"-->
			<div class="box-header with-border">
              <font size="3"><b> <?= $_REQUEST["param_menu1"];?></b></font>
            </div> 
            
			<div class="box-body" style="padding:2px;">			
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
					<?php 
						foreach ($tab_title as $tab_title_index => $tab_title_content){
						$tab_class=($tab_title_index==$tab_status_active) ? "active" : "";
					?>
					  <li class="<?= $tab_class ?>" style="<?= $style_tab; ?>"><a href="#<?= $tab_ahref[$tab_title_index]; ?>" data-toggle="tab" ><?= $tab_title_content; ?></a></li>
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