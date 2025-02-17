<?php

// tab navigation and style ---------
$tab_title = array("LOGIN DAILY","ALL INV PROCESS","SUPP INV PROCESS","SUPP GROUP INV PROCESS");
$tab_ahref = array("tabcontent1","tabcontent2","tabcontent3","tabcontent4");
$tab_status_active =0;
$style_tab = "background-color:#ccddee";

// tab content -----------------------
$tab_content_file = array("400206_01","400206_02","400206_03","400206_04");


//

$bg_arr =array("bg-red", "bg-green", "bg-yellow", "bg-blue" ,"bg-aqua", "bg-purple");
$yesterday_str = date('l,d F Y',mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));


?>
<!-- Content Header (Page header) -->
<section class="content" style="padding:3px;">
    <div class="box box-solid" id="isicontentovl" style="padding:0px;" > <!--style="overflow-y:auto;padding:0px;"-->
			<div class="box-header with-border">
              <font size="3"><b> <?php echo $_REQUEST["param_menu1"];?></b></font>
            </div> 
            
			<div class="box-body" style="padding:2px;">			
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
					<?php 
						foreach ($tab_title as $tab_title_index => $tab_title_content){
						$tab_class=($tab_title_index==$tab_status_active) ? "active" : "";
					?>
					  <li class="<?php echo $tab_class ?>" style="<?php echo $style_tab; ?>"><a href="#<?php echo $tab_ahref[$tab_title_index]; ?>" data-toggle="tab" ><?php echo $tab_title_content; ?></a></li>
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
					<div class="<?php echo $tab_class2 ?>" id="<?php echo $tab_ahref_content ?>" >
						<?php include $tab_content_file[$tab_ahref_index].".php"; ?>
					</div>
					<?php 
						}
					?> 
				</div>
		
		</div><!-- /.box-body -->
    </div><!-- /.box -->
</section><!-- /.content -->