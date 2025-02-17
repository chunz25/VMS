<?php
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>PHPExcel Reader Example #01</title>
</head>
<body>

<h1>PHPExcel Reader Example #01</h1>
<h2>Simple File Reader using PHPExcel_IOFactory::load()</h2>
<?php

/** PHPExcel_IOFactory */
include '../_third_party/PHPExcel180/PHPExcel/IOFactory.php';


$inputFileName = 'mdul.xlsx';
//echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);


echo '<hr />';

$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//var_dump($sheetData);
$sql="";
$sql_ke=0;
$tabel_ke=0;
$baris_baru='1';
$max_baris=count($sheetData);
echo $max_baris;
echo "<BR>";
foreach($sheetData as $row => $col)
{
	
	if($row>1)
	{
		echo $row.";";
		
		
		foreach ($col as $index_col => $value_col)
		{
			
			//echo $value_col . ";";
			switch ($index_col) {
				case 'A':
				   echo "A $value_col".";";
				   //$sql .= "$value_col";
				   break;
				case 'B':
				   echo "B $value_col".";";
				   if($value_col!='')
				   {
					   $sql .= "CREATE TABLE $value_col (";
					   
					   }
					   
				   break;
				case 'C':
				   echo "C $value_col".";";
				   if($value_col!='')
				   {
					   $sql .= " $value_col ";
					   
					}
				   break;
				case 'D':
				   echo "D $value_col".";";
				   if($value_col!='')
				   {
					   $sql .= " $value_col ,";
					   
					}
				   break;
				case 'E':
				   echo "E $value_col".";";
				   break;
				case 'F':
				   echo "F $value_col".";";
				   break;
				case 'G':
				   echo "G $value_col".";";
				   break;
				case 'H':
				   echo "H $value_col".";";
				   break;
				case 'I':
				   echo "I $value_col".";";
				   break;
				case 'J':
				   echo "J $value_col".";";
				   break;
				case 'K':
				   echo "K $value_col".";";
				   break;
				case 'L':
				   echo "L $value_col".";";
				   break;
}

			
		}
		
		
	}
	if($row < ($max_baris))
	{
		if($sheetData[$row+1]['C']=='' && $row!=1 && $sheetData[$row+1]['B']!='')
			{
				echo "<br>-----------------<br>";
				$sql = substr($sql, 0, -1);
				$sql .= ");";
				echo $sql;
				//$_global_db1->Execute($sql);
				echo "<br>-----------------<br>";
				$sql='';
			}
	}
		/**/
		echo "<br>\n";
}


?>
<body>
</html>