<?php
// URL tujuan
$url = 'devecc.electronic-city.co.id:8000/sap/ws/zmst/mstvndr?sap-client=130';

// Username dan password
$username = 'defa';
$password = '123123123';

// Inisialisasi curl
$curl = curl_init($url);

// Atur opsi curl
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_USERPWD, $username . ':' . $password);

// Kirim permintaan GET
$response = curl_exec($curl);

// Periksa apakah permintaan berhasil
if($response === false) {
    $error = curl_error($curl);
    echo 'Gagal mengirim permintaan: ' . $error;
} else {
    // Tampilkan hasil
    // echo $response;
	$hasilx=json_decode($response, true);
	$hasil=$hasilx; 
	var_dump($hasil);
}

// Tutup curl
curl_close($curl);
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
		<thead>
			<tr>
				<th>Header 1</th>
				<th>Header 2</th>
				<th>Header 3</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		foreach ($hasil as $key1 => $value1) {
			
?>

			<tr>
				<td><?= $key1 ?></td>
				<?php foreach ($value1 as $key2 => $value2) { ?>
				<td><?= $value2 ?>
				<?php }?>
			</tr>
		<?php } ?>
			
		</tbody>
	</table>
</body>
</html>