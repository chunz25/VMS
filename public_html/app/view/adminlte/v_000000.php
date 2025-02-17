<?php
$boleh_buka=false;
switch ($_SESSION['tb_id_user_type']) {
    case 1:
        $sql_add_d1 = " ";
		$boleh_buka=true;
        break;
    case 2:
        $sql_add_d1 = " AND  b.department in (".$_SESSION['department'].")";
        break;
    case 3:
        $sql_add_d1 = " ";
        break;
	case 4:
        $sql_add_d1 = " AND store_code='".$_SESSION['store_code']."'";
        break;
	case 5:
        $sql_add_d1 = " AND supplier_code='".$_SESSION['supplier_code']."'";
		$boleh_buka=true;
		break;
	case 6:
        $sql_add_d1 = " AND supplier_code in (".$_SESSION['supplier_group'].")";
		$boleh_buka=true;
        break;
}

if($boleh_buka==true)
{
	$link_more1 = '<a href="#" onclick="cobayy(\'Purchase+Order\',\'400401\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
	$link_more2= '<a href="#" onclick="cobayy(\'Goods+Receive\',\'400402\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
	$link_more3= '<a href="#" onclick="cobayy(\'Goods+Receive\',\'400402&param_menu4=2\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
	$link_more4= '<a href="#" onclick="cobayy(\'Proforma+Invoice\',\'400403&param_menu4=1\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
	$link_more5= '<a href="#" onclick="cobayy(\'Proforma+Invoice\',\'400403&param_menu4=2\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
	$link_more6= '<a href="#" onclick="cobayy(\'Invoice\',\'400404&param_menu4=1\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
	$link_more7= '<a href="#" onclick="cobayy(\'Invoice+Receipt\',\'400405&param_menu4=1\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
	$link_more8= '<a href="#" onclick="cobayy(\'Payment\',\'400406&param_menu4=1\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
	$link_more9= '<a href="#" onclick="cobayy(\'Payment\',\'400406&param_menu4=2\');" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
}
/*
// PO ---
$sqld1 = "SELECT count(purchase_order_no) qty FROM purchase_order_all_status_v where ( status_po in ('10','11','12') or status_po is null ) and document_status is null ".$sql_add_d1;
$rs1=$db->Execute($sqld1);
$qty1=$rs1->fields['qty'];

// GR ---
$sqld2 = "SELECT count(purchase_order_no) qty FROM goods_receive_all_status_v where ( status_grn in ('21') or status_grn is null ) and document_status is null  and year(document_date)>2018 and isIntegrated=1 and total_quantity>0 and store_code not like 'C%' ".$sql_add_d1;
$rs2=$db->Execute($sqld2);
$qty2=$rs2->fields['qty'];

/ Dispute QTY ---
$sqld3 = "SELECT count(purchase_order_no) qty FROM goods_receive_all_status_v where  status_grn in ('22','23')  and document_status is null".$sql_add_d1;
$rs3=$db->Execute($sqld3);
$qty3=$rs3->fields['qty'];

// PFI ---
$sqld4 = "SELECT count(purchase_order_no) qty FROM proforma_invoice_all_status_v where ( status_pfi in ('31') ) and document_status is null".$sql_add_d1;
$rs4=$db->Execute($sqld4);
$qty4=$rs4->fields['qty'];

// Dispute prc ---
$sqld5 = "SELECT count(purchase_order_no) qty FROM proforma_invoice_all_status_v where ( status_pfi in('32','33') ) and document_status is null".$sql_add_d1;
$rs5=$db->Execute($sqld5);
$qty5=$rs5->fields['qty'];


// paid ----------------------
$sqld8 = "SELECT count(purchase_order_no) qty FROM payment_po_all_v where  payment_amount is null  ".$sql_add_d1;
$rs8=$db->Execute($sqld8);
$qty8=$rs8->fields['qty'];



// Invoice
$sqld6 = "SELECT count(purchase_order_no) qty  FROM invoice_all_status_v where ( status_inv in ('41') or status_inv is null ) and document_status is null".$sql_add_d1;
$rs6=$db->Execute($sqld6);
$qty6=$rs6->fields['qty'];

// Invoice Receipt -----------
$sqld7 = "SELECT count(purchase_order_no) qty FROM invoice_receipt_all_status_v where ( status_invr ='51' or status_invr is null ) and payment_amount is null ".$sql_add_d1;
$rs7=$db->Execute($sqld7);
$qty7=$rs7->fields['qty'];

*/

// PO,RTP,PAID -------
$sqld1 = "SELECT sum(jumlah_po) qty1,sum(jumlah_grn) qty2,sum(jumlah_dispute_qty) qty3,sum(jumlah_pfi) qty4,sum(jumlah_dispute_prc) qty5,sum(jumlah_inv) qty6,sum(jumlah_inv_receipt) qty7,sum(jumlah_ready_to_pay) qty8,sum(jumlah_paid) qty9,sum(jumlah_inv_invalid) qty10 FROM dashboard_inv_process where jumlah_po>=0 ".$sql_add_d1;
$rs1=$db->Execute($sqld1);
$qty1=$rs1->fields['qty1'];
$qty2=$rs1->fields['qty2'];
$qty3=$rs1->fields['qty3'];
$qty4=$rs1->fields['qty4'];
$qty5=$rs1->fields['qty5'];
$qty6=$rs1->fields['qty6'];
$qty7=$rs1->fields['qty7'];
$qty8=$rs1->fields['qty8'];
$qty9=$rs1->fields['qty9'];
$qty10=$rs1->fields['qty10'];










/*

*/

//$qty="1280";
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
		if(($boleh_buka==true) && ($qty10>0))
		{		
		?>
		<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h3><i class="icon fa fa-ban"></i> Alert !</h3>
                    Terdapat  &nbsp;&nbsp; <B><font size="6"><?php echo $qty10; ?> </font></B> &nbsp;&nbsp; Invoice yang Faktur pajaknya tidak Valid.</br>
					Harap Segera diproses....! Supaya bisa diproses Pembayarannya !</br>
					<a href="#" class="small-box-footer" onclick="cobayy('Invoice+Receipt','400405');"> Klik disini ........ <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
          <!--  Small boxes (Stat box) -->
		<?php } ?>
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $qty1 ?></h3>
                  <p>Purchase Order</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
				<?php echo $link_more1;?>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $qty2 ?></h3>
                  <p>Goods Receive</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
				<?php echo $link_more2;?>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $qty3 ?></h3>
                  <p>Dispute Quantity</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
				<?php echo $link_more3;?>
                
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $qty4 ?></h3>
                  <p>Proforma Invoice</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <?php echo $link_more4;?>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
          <!-- Main row -->
		 
		  <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                 <h3><?php echo $qty5 ?></h3>
                  <p>Dispute Price</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <?php echo $link_more5;?>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                  <h3><?php echo $qty6 ?></h3>
                  <p>Invoice</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <?php echo $link_more6;?>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $qty7 ?></h3>
                  <p>Invoice Receipt</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <?php echo $link_more7;?>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-purple">
                <div class="inner">
                  <h3><?php echo $qty8 ?></h3>
                  <p>READY TO PAY</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <?php echo $link_more8;?>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
		  
		   <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                 <h3><?php echo $qty9 ?></h3>
                  <p>PAID</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <?php echo $link_more9;?>
              </div>
            </div><!-- ./col -->
			</div><!-- /.row -->
          <!-- Main row -->
		   </hr>
		   
		 

        </section><!-- /.content -->
     