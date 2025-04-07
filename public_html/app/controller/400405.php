<?php
// tab navigation and style ---------
$tab_title = array("INVOICING FINISHED", "READY TO PAY", "PAID");
$tab_ahref = array("tabcontent1", "tabcontent2", "tabcontent3");
$tab_status_active = 0;
$cek_param_menu4 = array_key_exists("param_menu4", $_REQUEST);
$tab_status_active = ($cek_param_menu4) ? ($_REQUEST["param_menu4"] - 1) : 0;
$style_tab = "background-color:#ccddee";

// tab content -----------------------
$tab_content_file = array("400405_01", "400405_02", "400405_03");

$bg_arr = array("bg-red", "bg-green", "bg-yellow", "bg-blue", "bg-aqua", "bg-purple");
$yesterday_str = date('l,d F Y', mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$input = file_get_contents('php://input');
	$data = json_decode($input, true);

	if (isset($data['par'])) {
		$isActive = $data['par'];
	}
}
?>
<!-- Content Header (Page header) -->
<section class="content" style="padding:3px;">
	<div class="box box-solid" id="isicontentovl" style="padding:0px;">
		<div class="box-header with-border">
			<font size="3"><b> <?= $_REQUEST["param_menu1"]; ?></b></font>
		</div>

		<div class="box-body" style="padding:2px;">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<?php
					foreach ($tab_title as $tab_title_index => $tab_title_content) {
						$tab_class = ($tab_ahref[$tab_title_index] == $_POST['par']) ? "active" : "";
						?>
						<li class="<?= $tab_class ?>" style="<?= $style_tab; ?>"
							id="<?= 'tab_' . $tab_ahref[$tab_title_index]; ?>">
							<a href="#<?= $tab_ahref[$tab_title_index]; ?>" data-toggle="tab"
								onclick="kontol('<?= $tab_ahref[$tab_title_index]; ?>');">
								<?= $tab_title_content; ?>
							</a>
						</li>
						<?php
					}
					?>
				</ul>
			</div>

			<div class="tab-content">
				<?php
				foreach ($tab_ahref as $tab_ahref_index => $tab_ahref_content) {
					$tab_class2 = ($tab_ahref_content == $_POST['par']) ? "tab-pane active" : "tab-pane";
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

<script>
	function kontol(par) {
		const element = document.getElementById(par);
		element.classList.add('active');
		const hasActiveClass = element.classList.contains('active');

		if (hasActiveClass) {
			$(".content-wrapper").load("index.php?param_menu1=Receipt+Supplier&main_id=400405", {
				main: "040",
				main_act: "010",
				par: par
			}, '');
		}

	}
</script>