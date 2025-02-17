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
				<td><?php echo $key1 ?></td>
				<?php foreach ($value1 as $key2 => $value2) { ?>
				<td><?php echo $value2 ?>
				<?php }?>
			</tr>
		<?php } ?>
			
		</tbody>
	</table>
</body>
</html>