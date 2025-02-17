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
		foreach ($arraySource as $key1 => $value1) {
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
				<td><?php echo $key1 ?></td>
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