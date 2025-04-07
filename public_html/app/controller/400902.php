<style>
  input[type=number]::-webkit-outer-spin-button,
  input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  input[type=number] {
    -moz-appearance: textfield;
  }
</style>
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
          <form role="form" id="my_form" action="download_pomass.php" method="post" onsubmit="return validateForm();"
            target="_reportwindow">
            <?php if ($_SESSION['tb_id_user_type'] == "5") { ?>
              <input type="text" name="supplier_code" value="<?= $_SESSION['supplier_code']; ?>" hidden>
            <?php } ?>
            <label>PO Number From :</label>
            <div class="input-group date">
              <input placeholder="PO Number From" type="number" class="form-control" name="po_from" autocomplete="off">
            </div>
            <br>
            <label>PO Number To :</label>
            <div class="input-group date">
              <input placeholder="PO Number To" type="number" class="form-control" name="po_to" autocomplete="off">
            </div>
            <div class="box-footer" align="center">
              <input type="hidden" name="main" value="060">
              <input type="hidden" name="main_act" value="060">
              <input type="hidden" name="main_id" value="400901_001">
              <button type="submit" class="btn btn-primary mt-2">Download PO</button>
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
    let poFrom = document.forms["my_form"]["po_from"].value;
    let poTo = document.forms["my_form"]["po_to"].value;

    if (poFrom == "") {
      alert("Silahkan isi Nomor PO Awal Terlebih Dahulu");
      return false;
    }
    if (poTo == "") {
      alert("Silahkan isi Nomor PO Akhir Terlebih Dahulu");
      return false;
    }
    if (poFrom > poTo) {
      alert("Nomor PO Awal tidak Boleh lebih besar dari PO Akhir");
      return false;
    }
    if (poFrom.length < 10 || poTo.length < 10) {
      alert("Silahkan isi Nomor PO dengan format yang benar");
      return false;
    }

    return true;
  }
</script>