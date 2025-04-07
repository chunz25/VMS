<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title><?= $_MAIN__CONFIGS_010[3]; ?></title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link rel="icon" type="image/png" href="<?= $_MAIN__CONFIGS_010[7]; ?>">
  <link href="themes/admin_LTE/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="themes/admin_LTE/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="themes/admin_LTE/bootstrap/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <link href="themes/admin_LTE/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  <link href="themes/admin_LTE/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
  <link href="themes/admin_LTE/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap.min.css" rel="stylesheet"
    type="text/css" />
  <link href="themes/admin_LTE/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
  <link href="_assets/_css/helmizz.css" rel="stylesheet" type="text/css" />
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->

<body class="<?= $_MAIN__CONFIGS_010[9]; ?>">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- =============================================== -->
    <header class="main-header">
      <a href="#" class="logo"><img src="<?= $_MAIN__CONFIGS_030[10]; ?>"></img></a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"> Test xx</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <!-- Navbar Right -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li>
              <a href="reportPo.php" class="btn btn-primary">
                Download User Manual
              </a>
            </li>
          </ul>
        </div>

      </nav>
    </header>
    <!-- =============================================== -->
    <?php
    switch ($_SESSION['tb_id_user_type']) {
      case 1:
        $info1 = "Sys Admin";
        $info3 = "1";
        $info4 = $_SESSION['fullname'];
        break;
      case 2:
        $info1 = "Buyer";
        $info3 = "2";
        $info4 = $_SESSION['fullname'];
        break;
      case 3:
        $info1 = "Finance";
        $info3 = "3";
        $info4 = $_SESSION['fullname'];
        break;
      case 4:
        $info1 = "Goods Receiving";
        $info3 = "4";
        $info4 = $_SESSION['fullname'];
        break;
      case 5:
        $info1 = "Supplier";
        $info3 = "5";
        $info4 = $_SESSION['supplier_name'];
        break;
      case 6:
        $info1 = "Supplier Group";
        $info3 = "6";
        $info4 = $_SESSION['supplier_name'];
        break;
      case 7:
        $info1 = "Supply & Demand Planning";
        $info3 = "7";
        $info4 = $_SESSION['fullname'];
        break;
      case 8:
        $info1 = "Goods Receiving";
        $info3 = "8";
        $info4 = $_SESSION['fullname'];
        break;
    }
    $info2 = $_SESSION['username'];
    ?>
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">
            <h5><b><?= $info4; ?></b></h5>
            <hr>
          </li>
          <li>
            <a href="#" onclick="cobaxx('PROFILE','000001');">
              <i class="fa fa-calendar"></i> <span>PROFILE</span>
            </a>
          </li>
          <?php

          $tabmenu = 0;
          foreach ($_CONFIGS_MODUL as $row1 => $col1) {

            foreach ($_CONFIGS_MENU[$row1] as $rowmenu1 => $colmenu1) {

              ?>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-dashboard"></i> <span><?= $colmenu1; ?></span> <i
                    class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <?php
                  foreach ($_CONFIGS_SUBMENU[$row1][$rowmenu1] as $rowsubmenu1 => $colsubmenu1) { ?>
                    <li><a href="#"
                        onclick="cobaxx('<?= urlencode($colsubmenu1); ?>','<?= urlencode($rowsubmenu1); ?>');">
                        <i class="fa fa-circle-o"></i> <?= $colsubmenu1; ?>
                        <!-- [<?= $rowsubmenu1; ?>] -->
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
              <?php

            }
            ?>

            <?php

          }
          ?>
          <!-- <li>
          <a href="#"  onclick="cobaxx('PROFIL','profil');">
            <i class="fa fa-calendar"></i> <span>PROFILE</span>
          </a>
        </li>-->
          <li>
            <a href="<?= $_MAIN__CONFIGS_000[2] . "logout.php" ?>">
              <i class="fa fa-calendar"></i> <span>LOGOUT</span>
            </a>
          </li>


      </section>
      <!-- /.sidebar -->
    </aside>
    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" class="center-block"></div><!-- /.content-wrapper -->
    <!-- Control Sidebar -->
    <!-- Add the sidebar's background. This div must be placed  immediately after the control sidebar -->
    <div class='control-sidebar-bg'></div>
  </div><!-- ./wrapper -->
  <!-- Modal -->
  <script src="themes/admin_LTE/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- Bootstrap 3.3.2 JS -->
  <script src="themes/admin_LTE/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <!-- DATA TABES SCRIPT -->
  <script src="themes/admin_LTE/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
  <script src="themes/admin_LTE/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
  <!-- SlimScroll -->
  <script src="themes/admin_LTE/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
  <!-- FastClick -->
  <script src='themes/admin_LTE/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="themes/admin_LTE/dist/js/app.min.js" type="text/javascript"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="themes/admin_LTE/dist/js/demo.js" type="text/javascript"></script>
  <script src="_assets/_js/helmizz.js" type="text/javascript"></script>
  <script src='themes/admin_LTE/plugins/datepicker/bootstrap-datepicker.js'></script>
  <script src='themes/admin_LTE/plugins/input-mask/jquery.inputmask.js'></script>
  <script src='themes/admin_LTE/plugins/input-mask/jquery.inputmask.extensions.js'></script>
  <script src='themes/admin_LTE/plugins/input-mask/jquery.inputmask.numeric.extensions.js'></script>
  <script>
    <?php
    if (isset($_REQUEST['showFirst1']) && isset($_REQUEST['showFirst2'])) {
      echo "cobayy('" . $_REQUEST['showFirst1'] . "','" . $_REQUEST['showFirst2'] . "','" . $_REQUEST['showFirst3'] . "');";
    } else {
      echo "cobaxx('MAIN+PAGE','000000');";
    }
    ?>
  </script>
</body>

</html>