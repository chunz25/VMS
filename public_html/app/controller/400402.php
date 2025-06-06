<?php
// tab navigation and style ---------
$tab_title = array("SETTLEMENT QTY PROCESS", "DISPUTE QTY PROCESS", "HISTORY DISPUTE QTY"); // ,"GOODS RECEIVE FINISHED"
$tab_ahref = array("tabcontent1", "tabcontent2", "tabcontent3");//,"tabcontent3"
$cek_param_menu4 = array_key_exists("param_menu4", $_REQUEST);
$param_menu4req = isset($_REQUEST["param_menu4"]) && is_numeric($_REQUEST["param_menu4"]) ? intval($_REQUEST["param_menu4"]) : 0;
$tab_status_active = $cek_param_menu4 ? $param_menu4req - 1 : 0;
$style_tab = "background-color:#ccddee";

// tab content -----------------------
$tab_content_file = array("400402_01", "400402_02", "400402_03"); //,"400402_03"
?>
<style>
	#custom-progress-container {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 3px;
		z-index: 9999;
		background-color: #f3f3f3;
		display: none;
	}

	#custom-progress-bar {
		height: 100%;
		width: 0%;
		background-color: #337ab7;
		animation: progress-animation 2s infinite ease-in-out;
	}

	@keyframes progress-animation {
		0% {
			width: 0%;
		}

		50% {
			width: 70%;
		}

		100% {
			width: 100%;
		}
	}
</style>
<div id="custom-progress-container">
	<div id="custom-progress-bar"></div>
</div>
<!-- Content Header (Page header) -->
<section class="content" style="padding:3px;">
	<div class="box box-solid" id="isicontentovl" style="padding:0px;"> <!--style="overflow-y:auto;padding:0px;"-->
		<div class="box-header with-border">
			<font size="3"><b> <?= $_REQUEST["param_menu1"]; ?></b></font>
		</div>

		<div class="box-body" style="padding:2px;">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<?php
					foreach ($tab_title as $tab_title_index => $tab_title_content) {
						$tab_class = ($tab_title_index == $tab_status_active) ? "active" : "";
						?>
						<li class="<?= $tab_class ?>" style="<?= $style_tab; ?>"><a
								href="#<?= $tab_ahref[$tab_title_index]; ?>"
								data-toggle="tab"><?= $tab_title_content; ?></a></li>
						<?php
					}
					?>
				</ul>
			</div>
			<div class="tab-content">
				<?php
				foreach ($tab_ahref as $tab_ahref_index => $tab_ahref_content) {
					$tab_class2 = ($tab_ahref_index == $tab_status_active) ? "tab-pane active" : "tab-pane";
					?>
					<div class="<?= $tab_class2 ?>" id="<?= $tab_ahref_content ?>">
						<?php include $tab_content_file[$tab_ahref_index] . ".php"; ?>
					</div>
					<?php
				}
				?>
			</div>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</section><!-- /.content -->