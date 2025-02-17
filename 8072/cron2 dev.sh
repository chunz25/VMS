php -f "/home/vmsdev/8072/P050_getPOCancel.php" 1 > /home/vmsdev/8072/log/P050_getPOCancel.log
php -f "/home/vmsdev/8072/P050_getPO.php" 2 > /home/vmsdev/8072/log/P050_getPO.log
php -f "/home/vmsdev/8072/P060_getGRCancel.php" 1 > /home/vmsdev/8072/log/P060_getGRCancel.log
php -f "/home/vmsdev/8072/P060_getGR.php" 1 > /home/vmsdev/8072/log/P060_getGR.log
php -f "/home/vmsdev/8072/P070_getInvoice.php" 1 > /home/vmsdev/8072/log/P070_getInvoice.log
# php -f "/home/vmsdev/8072/P075_getReadyToPay.php"  > /home/vmsdev/8072/log/P075_getReadyToPay.log
php -f "/home/vmsdev/8072/P076_getPaid.php"  > /home/vmsdev/8072/log/P076_getPaid.log
php -f "/home/vmsdev/8072/P080_getPayment.php" 1 > /home/vmsdev/8072/log/P080_getPayment.log
php -f "/home/vmsdev/8072/P085_getDnnum.php" 1 > /home/vmsdev/8072/log/P085_getDnnum.log
php -f "/home/vmsdev/8072/P090_saveReceiptSupplier.php" > /home/vmsdev/8072/log/P090_saveReceiptSupplier.log
php -f "/home/vmsdev/8072/P095_parkRS.php" 1 > /home/vmsdev/8072/log/P095_parkRS.log
# php -f "/home/vmsdev/8072/P110_getDN.php" 1 > /home/vmsdev/8072/log/P110_getDN.log
# php -f "/home/vmsdev/8072/P120_getPOReturn.php" 1 > /home/vmsdev/8072/log/P120_getPOReturn.log
# php -f "/home/vmsdev/8072/P991_getPdf.php" > /home/vmsdev/8072/log/P991_getPdf.log