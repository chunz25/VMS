<?php
// ini_set('display_errors',0);

// URL tujuan
$url = 'http://devecc.electronic-city.co.id:8000/sap/ws/vms/po?sap-client=130';

// Username dan password
$username = 'defa';
$password = '123123123';


$xx=array_key_exists("d",$_REQUEST);
if($xx){
$d=$_REQUEST["d"];}
else
{$d="20230710";}

 

$data = array(
    "purchase_order_no"=>"",
    "supplier_code"=>"",
    "document_date"=>$d
);

 var_dump($data);

$jsonData = json_encode($data);

$headers = array(
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode($username . ':' . $password)
);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Error: ' . curl_error($ch);
}

curl_close($ch);

// Process the API response
if ($response) {
    $responseData = json_decode($response, true);
	// var_dump($responseData);
	// $hasilx=json_decode($response, true);
	$hasil=$responseData["header"]; 
    // Process the data returned by the API
} else {
    // Handle the case when there is no response or an error occurred
    echo 'Error: No response from the API.';
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>HTML Table Generator</title> 
	<style>
		table {
			height:100%;
			border:1px solid #9d6d06;
			border-collapse:collapse;
			padding:3px;
		}
		table th {
			border:1px solid #9d6d06;
			padding:3px;
			background: #f5b13d;
			color: #313030;
		}
		table td {
			border:1px solid #9d6d06;
			text-align:center;
			padding:3px;
			background: #fcf8f8;
			color: #313030;
		}
	</style>
</head>
<body>
	<table>
		
		
		<?php 
		foreach ($hasil as $key1 => $value1) {
			$no=$key1+1;
			if($no==1){
?>		
		<thead>
			<tr>
				<td>No</td>
				<?php foreach ($value1 as $key2 => $value2) { ?>
				<td>
				<?php if (is_array($value2)){print_r($key2);}else{echo $key2;} ?>
				</td>
				<?php }?>
			</tr>
		</thead>
			<?php } ?>
			
			<tbody>
			<tr>
				<td><?= $key1 ?></td>
				<?php foreach ($value1 as $key2 => $value2) { ?>
				<td>
				<?php if (is_array($value2)){print_r($value2);}else{echo $value2;} ?>
				</td>
				<?php }?>
			</tr>
		<?php } ?>
			
		</tbody>
	</table>
</body>
</html>