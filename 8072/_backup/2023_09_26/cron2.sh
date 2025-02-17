php -f "/home/vms/8072/P050_getPO.php" 3 > /home/vms/8072/log/P050_getPO.log
php -f "/home/vms/8072/P060_getGR.php" 2 > /home/vms/8072/log/P060_getGR.log
php -f "/home/vms/8072/P070_getInvoice.php" 2 > /home/vms/8072/log/P070_getInvoice.log
php -f "/home/vms/8072/P080_getPayment.php" 2 > /home/vms/8072/log/P080_getPayment.log
php -f "/home/vms/8072/P085_getDnnum.php" 2 > /home/vms/8072/log/P085_getDnnum.log
php -f "/home/vms/8072/P090_saveReceiptSupplier.php" >> /home/vms/8072/log/P090_saveReceiptSupplier.log
# php -f "/home/vms/8072/P100_getReceiptSupplier.php" 2 > /home/vms/8072/log/P100_getReceiptSupplier.log
php -f "/home/vms/8072/P095_parkRS.php" 2 > /home/vms/8072/log/P095_parkRS.log
php -f "/home/vms/8072/P110_getDN.php" 2 > /home/vms/8072/log/P110_getDN.log
php -f "/home/vms/8072/P120_getPOReturn.php" 2 > /home/vms/8072/log/P120_getPOReturn.log

