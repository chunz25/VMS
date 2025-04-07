<?php

$boleh_buka = false;
switch ($_SESSION['tb_id_user_type']) {
  case 1:
    $sql_add_d1 = " ";
    $boleh_buka = true;
    break;
  case 2:
    $sql_add_d1 = " AND  b.department in (" . $_SESSION['department'] . ")";
    break;
  case 3:
    $sql_add_d1 = " ";
    break;
  case 4:
    $sql_add_d1 = " AND store_code='" . $_SESSION['store_code'] . "'";
    break;
  case 5:
    $sql_add_d1 = " AND supplier_code='" . $_SESSION['supplier_code'] . "'";
    $boleh_buka = true;
    break;
  case 6:
    $sql_add_d1 = " AND supplier_code in (" . $_SESSION['supplier_group'] . ")";
    $boleh_buka = true;
    break;
}

if ($boleh_buka == true) {
  $link_more1 = '<a href="#" onclick="cobayy(\'Purchase+Order\',\'400401\',\'1\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
  $link_more2 = '<a href="#" onclick="cobayy(\'Goods+Receive\',\'400402\',\'1\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
  $link_more3 = '<a href="#" onclick="cobayy(\'Goods+Receive\',\'400402&param_menu4=2\',\'2\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
  $link_more4 = '<a href="#" onclick="cobayy(\'Proforma+Invoice\',\'400403&param_menu4=1\',\'1\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
  $link_more5 = '<a href="#" onclick="cobayy(\'Proforma+Invoice\',\'400403&param_menu4=2\',\'1\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
  $link_more6 = '<a href="#" onclick="cobayy(\'Invoice\',\'400404&param_menu4=1\',\'1\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
  $link_more7 = '<a href="#" onclick="cobayy(\'Invoice+Receipt\',\'400405&param_menu4=1\',\'1\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
  $link_more8 = '<a href="#" onclick="cobayy(\'Payment\',\'400406&param_menu4=1\',\'1\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';

  // PO,RTP,PAID -------
  $sqld1 = "SELECT sum(jumlah_po) qty1,sum(jumlah_grn) qty2,sum(jumlah_dispute_qty) qty3,sum(jumlah_pfi) qty4,sum(jumlah_dispute_prc) qty5,sum(jumlah_inv) qty6,sum(jumlah_inv_receipt) qty7,sum(jumlah_ready_to_pay) qty8,sum(jumlah_paid) qty9,sum(jumlah_inv_invalid) qty10 FROM dashboard_inv_process where jumlah_po>=0 " . $sql_add_d1;
  $rs1 = $db->Execute($sqld1);
  $qty1 = $rs1->fields['qty1'];
  $qty2 = $rs1->fields['qty2'];
  $qty3 = $rs1->fields['qty3'];
  $qty4 = $rs1->fields['qty4'];
  $qty5 = $rs1->fields['qty5'];
  $qty6 = $rs1->fields['qty6'];
  $qty7 = $rs1->fields['qty7'];
  $qty8 = $rs1->fields['qty8'];
  $qty9 = $rs1->fields['qty9'];
  $qty10 = $rs1->fields['qty10'];

?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Invoicing Process
    <!-- <small>Control panel</small> -->
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <?php
    if (($boleh_buka == true) && ($qty10 > 0)) {
    ?>
  <div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h3><i class="icon fa fa-ban"></i> Alert !</h3>
    Terdapat &nbsp;&nbsp; <B>
      <font size="6"><?= $qty10; ?> </font>
    </B> &nbsp;&nbsp; Invoice yang Faktur pajaknya tidak Valid.</br>
    Harap Segera diproses....! Supaya bisa diproses Pembayarannya !</br>
    <a href="#" class="small-box-footer" onclick="cobayy('Invoice+Receipt','400405');"> Klik disini ........ <i
        class="fa fa-arrow-circle-right"></i></a>
  </div>
  <!--  Small boxes (Stat box) -->
  <?php } ?>
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?= $qty1 ?></h3>
          <p>Purchase Order</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <?= $link_more1; ?>
        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
      </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?= $qty2 ?></h3>
          <p>Goods Receive</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <?= $link_more2; ?>
      </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?= $qty3 ?></h3>
          <p>Dispute Quantity</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <?= $link_more3; ?>

      </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?= $qty4 ?></h3>
          <p>Settlement Price</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <?= $link_more4; ?>
      </div>
    </div><!-- ./col -->
  </div><!-- /.row -->
  <!-- Main row -->

  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?= $qty5 ?></h3>
          <p>Dispute Price</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <?= $link_more5; ?>
      </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?= $qty6 ?></h3>
          <p>Receipt Supplier</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <?= $link_more6; ?>
      </div>
    </div><!-- ./col -->

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-purple">
        <div class="inner">
          <h3><?= $qty7 ?></h3>
          <p>READY TO PAY</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <?= $link_more7; ?>
      </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?= $qty8 ?></h3>
          <p>PAID</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <?= $link_more8; ?>
      </div>
    </div><!-- ./col -->
  </div><!-- /.row -->

  <div class="row">

  </div><!-- /.row -->
  <!-- Main row -->
  </hr>



</section><!-- /.content -->

<?php } ?>