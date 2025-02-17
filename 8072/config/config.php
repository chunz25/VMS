<?php
// ini_set('display_errors',0);

// Database QAS
$jenis_db[1]='mysql';
$host[1]='10.101.0.8';
$username[1]='root';
$password[1]='Admin2021!';
$database[1]='vms_gateway';

// Database PRD
// $jenis_db[1] = 'mysql';
// $host[1] = '10.140.1.13';
// $username[1] = 'vms';
// $password[1] = 'Vms-ECI2023!';
// $database[1] = 'vms_gateway';

// REST API
// Server API
// Username dan password

//QAS
// $usernameAPI = 'defa';
// $passwordAPI = '123123123';
// $serverAPI = "10.140.3.6:8000";
// $client = "sap-client=400";

//PRD
$usernameAPI = 'vms';
$passwordAPI = 'Vmseci123!';
$serverAPI="10.140.4.25:8001";
$client="sap-client=600";


// url po 
// url master vendor

// get store --
$configUrlAPI["P010"] = "http://$serverAPI/sap/ws/zmst/mststore?$client";
// get product
$configUrlAPI["P020"] = "http://$serverAPI/sap/ws/zmst/mstarticle?$client";
// get category product
$configUrlAPI["P030"] = "http://$serverAPI/sap/ws/zmst/mstcategory?$client";
// get vendor
$configUrlAPI["P040"] = "http://$serverAPI/sap/ws/zmst/mstvndr?$client";
// get PO
$configUrlAPI["P050"] = "http://$serverAPI/sap/ws/vms/po?$client";
// get GR
$configUrlAPI["P060"] = "http://$serverAPI/sap/ws/vms/gr?$client";
// get Invoice
$configUrlAPI["P070"] = "http://$serverAPI/sap/ws/vms/invoice?$client";
// get ready to Pay
$configUrlAPI["P075"] = "http://$serverAPI/sap/ws/vms/readytopay?$client";
// get Paid
$configUrlAPI["P076"] = "http://$serverAPI/sap/ws/vms/paid?$client";
// get Payment
$configUrlAPI["P080"] = "http://$serverAPI/sap/ws/vms/payment?$client";
// Get DnNum / detail RS
$configUrlAPI["P085"] = "http://$serverAPI/sap/ws/vms/detailrs?$client";
// save Receipt Supplier
$configUrlAPI["P090"] = "http://$serverAPI/sap/ws/vms/savers?$client";
// save PARK RS
$configUrlAPI["P095"] = "http://$serverAPI/sap/ws/vms/parkrs?$client";
// get Receipt Supplier 
$configUrlAPI["P100"] = "http://$serverAPI/sap/ws/vms/viewrs?$client";
// get DN
$configUrlAPI["P110"] = "http://$serverAPI/sap/ws/vms/dn?$client";
// get Return
$configUrlAPI["P120"] = "http://$serverAPI/sap/ws/vms/poreturn?$client";
