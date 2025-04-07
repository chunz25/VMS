<?php
require_once("db_connPDO.php");

$stmt = $pdo->prepare("
  SELECT 
    supplier_code , 
    name as supplier_name 
  FROM 
    supplier
  WHERE 
    supplier_code IN ('1000','300125', 'B0121', 'B2341', 'D0321', 'E0321', 'P0321', 'S0121', 'S0221', 'S0421', 'S0521', 'S2321', 'T2721', 'T6821', 'V1721')
");
$stmt->execute();
$supplierList = $stmt->fetchAll();
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?= $_REQUEST["param_menu1"]; ?>
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-4">
      <div class="box">
        <div class="box-body">
          <form role="form" id="my_form" action="reportPo.php" method="post" onsubmit="return validateForm();"
            target="_reportwindow">
            <label>Supplier Code :</label>
            <?php if (isset($_SESSION['supplier_code'])) { ?>
              <input type="text" name="supplier_code" value="<?= $_SESSION['supplier_code'] ?>" hidden>
              <input type="text" class="form-control" readonly
                value="<?= $_SESSION['supplier_code'] . " - " . $_SESSION['supplier_name'] ?>">
            <?php } else { ?>
              <select class="form-control" name="supplier_code">
                <option value="" disabled selected hidden>Pilih Supplier</option>
                <?php foreach ($supplierList as $s) { ?>
                  <option value="<?= $s['supplier_code'] ?>"><?= $s['supplier_code'] . ' - ' . $s['supplier_name'] ?>
                  </option>
                <?php } ?>
              </select>
            <?php } ?>
            <br>
            <label>Status PO :</label>
            <select class="form-control" name="statuspo">
              <option value="0" disabled selected hidden>Pilih Status</option>
              <option value="">All Status</option>
              <option value="1">Open PO</option>
              <option value="2">Settlement Qty</option>
              <option value="3">Settlement Price</option>
              <option value="4">Pengajuan Invoice</option>
              <option value="5">Invoicing Process</option>
              <option value="6">Ready To Pay</option>
              <option value="7">Paid</option>
            </select>
            <br>
            <label>Date From :</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
              </div>
              <input placeholder="Date from" type="text" class="form-control datepicker" name="date_from"
                autocomplete="off" onkeypress="return false">
            </div>
            <br>
            <label>Date To :</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
              </div>
              <input placeholder="Date To" type="text" class="form-control datepicker" name="date_to" autocomplete="off"
                onkeypress="return false">
            </div>
            <div class="box-footer" align="center">
              <input type="hidden" name="main" value="060">
              <input type="hidden" name="main_act" value="060">
              <input type="hidden" name="main_id" value="400901_001">
              <button type="submit" class="btn btn-primary mt-2">Export Report</button>
            </div>
          </form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
    <div class="col-md-6">
    </div><!-- /.row -->
</section><!-- /.content -->

<script type="text/javascript">
  $(function () {
    $(".datepicker").datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
    });
  });

  function validateForm() {
    var supplierCode = document.forms["my_form"]["supplier_code"].value;
    var statusPo = document.forms["my_form"]["statuspo"].value;
    var dateFrom = document.forms["my_form"]["date_from"].value;
    var dateTo = document.forms["my_form"]["date_to"].value;

    if (dateFrom == "" || dateTo == "") {
      alert("Pilih Tanggal Terlebih Dahulu");
      return false;
    } else if (statusPo == "0") {
      let m = alert('Pilih Status Terlebih Dahulu');
      return false;
    } else if (supplierCode == "") {
      let m = confirm('Yakin tidak pilih Supplier?');
      return m;
    } else {
      return true;
    }
  }
</script>