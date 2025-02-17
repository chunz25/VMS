<?php

$ROOTNYA=$_SERVER["DOCUMENT_ROOT"];
//die($ROOTNYA);
require_once($ROOTNYA.'/_third_party/PHPExcel/PHPExcel/IOFactory.php');
require_once($ROOTNYA.'/_third_party/html2pdf/html2pdf.class.php');
//die($ROOTNYA);
$objPHPExcel = new PHPExcel();

/*
task to do :
1. create transferformatall using function -----
2. create transferformatall using class --------

format_source					"array"
format_destination				"csv"
source_input					$array_source
destination_output				"/home/usr/data_output/hasil_output.csv"
mode_output						"0"; ----  0 atau blank = output file;	1= on the fly
option_1						""		"" tambah sequence; "0" tanpa sequence
option_2						""		delimiter	
option_3						""		



array 	--> csv
		--> xls
		--> xlsx
		--> xml
		--> json
		--> txt
		--> pdf
		--> insert_db
		--> update_db
		--> delete_db
		--> html

csv		--> array
		--> xls
		--> xlsx
		--> xml
		--> json
		--> txt
		--> pdf
		--> insert_db
		--> update_db
		--> delete_db
		--> html

sql		--> array
		--> csv
		--> xls
		--> xlsx
		--> xml
		--> json
		--> txt
		--> pdf
		--> html_table

function 
transfer_format_general("","",resource,output_file)

*/


/* -------------------------------------------
List Function  Array to xxx :

>> Array source
12. -- array_to_csv_helmi ($array_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0') === done
13. -- array_to_xls_helmi ($array_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0') === done
14. -- array_to_xml_helmi ($array_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0') 
15. -- array_to_json_helmi ($array_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')=== done
16. -- array_to_html_helmi ($array_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0') === done
17. -- array_to_txt_helmi ($array_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0') 
18. -- array_to_pdf_helmi ($array_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
19. -- array_to_sql_helmi ($array_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0') === 

----------------------------------------------------
*/




/* --------------------------------------------------
List Function  Array to xxx :
-- csv_to_array_helmi ($csv_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- csv_to_xls_helmi ($csv_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- csv_to_xml_helmi ($csv_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- csv_to_json_helmi ($csv_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- csv_to_html_helmi ($csv_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- csv_to_txt_helmi ($csv_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- csv_to_pdf_helmi ($csv_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- csv_to_sql_helmi ($csv_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
*/


/* --------------------------------------------------------------------------------------------
>> XLS source
-- xls_to_array_helmi ($xls_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- xls_to_csv_helmi ($xls_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- xls_to_xml_helmi ($xls_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- xls_to_json_helmi ($xls_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- xls_to_html_helmi ($xls_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- xls_to_txt_helmi ($xls_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- xls_to_pdf_helmi ($xls_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- xls_to_sql_helmi ($xls_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')


>> XML source
-- xml_to_array_helmi ($xml_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- xml_to_csv_helmi ($xml_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- xml_to_xls_helmi ($xml_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- xml_to_json_helmi ($xml_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- xml_to_html_helmi ($xml_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- xml_to_txt_helmi ($xml_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- xml_to_pdf_helmi ($xml_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- xml_to_sql_helmi ($xml_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')


>> JSON source
-- json_to_array_helmi ($json_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- json_to_csv_helmi ($json_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- json_to_xls_helmi ($json_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- json_to_xml_helmi ($json_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- json_to_html_helmi ($json_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- json_to_txt_helmi ($json_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- json_to_pdf_helmi ($json_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- json_to_sql_helmi ($json_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')


>> TXT source
-- txt_to_array_helmi ($txt_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- txt_to_csv_helmi ($txt_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- txt_to_xls_helmi ($txt_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- txt_to_xml_helmi ($txt_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- txt_to_html_helmi ($txt_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- txt_to_json_helmi ($txt_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- txt_to_pdf_helmi ($txt_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- txt_to_sql_helmi ($txt_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')


>> SQL source
-- sql_to_array_helmi ($sql_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0') === done
-- sql_to_csv_helmi ($sql_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0') === done
-- sql_to_xls_helmi ($sql_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0') === done
-- sql_to_xml_helmi ($sql_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- sql_to_html_helmi ($sql_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- sql_to_json_helmi ($sql_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- sql_to_pdf_helmi ($sql_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- sql_to_txt_helmi ($sql_nya,$output_nya="d:/sem/hehehehe",$sheet_file_nya='0',$mode_nya='0')
-- sql_to_sql_helmi ($sql_nya,$tabel_nya,$sheet_file_nya='0',$mode_nya='0')

-----------------------------------------------*/

if(!function_exists("array_to_csv_helmi"))
{
// >> Array source ==========================================================================================================================
function array_to_csv_helmi($array_nya,$output_nya,$mode_nya='0')
{	
	foreach ($array_nya as $key => $value) 
		{
			if($key==0)
				{					
					$cekbarispertama=0;
					foreach ($value as $nama_field => $isi_field)
						{
						$nama_field=str_replace('"','""',$nama_field);
						if($cekbarispertama==0)
							{
								$contentocsv .= '"'.strtoupper($nama_field).'"';
							}
						else
							{
								$contentocsv .= ',"'.strtoupper($nama_field).'"';
							}
						$cekbarispertama++;
						}											
					$contentocsv .= "\n";
				}
			$cekbarispertama=0;
			foreach ($value as $nama_field => $isi_field) 
				{
					$isi_field=str_replace('"','""',$isi_field);
					if($cekbarispertama==0)
							{
								$contentocsv .= '"'.$isi_field.'"';
							}
						else
							{								
								$contentocsv .= ',"'.$isi_field.'"';
							}
					$cekbarispertama++;														
				}
			$contentocsv .= "\n";
		}	
	file_put_contents($output_nya.".csv",$contentocsv);

}

function array_to_xls_helmi($array_nya,$output_nya,$sheet_file_nya='0',$mode_nya='0')
{		
	global $objPHPExcel;
	
	

	if(is_array($array_nya))
		{
			
		$baris_nya=0;
		/*
		foreach ($array_nya as $key1 => $value1)
			{					
				if(is_array($value1))
					{	
				
					$kolomnya=1;
					foreach ($value1 as $key2 => $value2)
							{
								
								if($mode_nya=='0')
								{
									if($key1==0)
										{								
											$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($kolomnya,$key1+1,$key2);
										}
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($kolomnya,$key1+2,$value2);
								}
								else
								{
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($kolomnya,$key1+1,$value2);
								}
								
								echo $kolomnya.",".$key1.",".$value2."<br>";
								$kolomnya++;
								
							}
						
					}
			}
		
		*/
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,1,'SATU SATU');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,1,'DUA SATU');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,1,'TIGA SATU');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,2,'XXXXX');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,2,'YYYY');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,3,'ZZZZ');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		
		$file = $output_nya.'.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= "John Smith\n";
// Write the contents back to the file
file_put_contents($file, $current);
		
		echo ($output_nya);
		
		$objWriter->save($output_nya);
		}
}

function array_to_xml_helmi($array_nya,$output_nya,$mode_nya='0')
{

}


function array_to_json_helmi($array_nya,$output_nya,$mode_nya='0')
{
		return json_encode($arr);
}


function array_to_html_helmi($array_nya,$property_umum_nya='',$property_special_nya='',$mode_nya='0')
{
	
	if($property_umum_nya=='')
	{
		//$property_umum_nya['TABLE']="class='dhtmlxGrid' id='grid'  border='1'  align='center' width='85%' cellpadding='0' cellspacing='0'  style='white-space:nowrap;'";
		$property_umum_nya['TABLE']="";
		$property_umum_nya['THEAD']="";
		$property_umum_nya['TBODY']="";
		$property_umum_nya['THEAD_TR']="";
		$property_umum_nya['TBODY_TR']="";
	}

	if($property_special_nya=='')
	{
		$property_special_nya['TDHEAD_TD']=array(' width="35" align="center" ');
		$property_special_nya['TDBODY_TD']=array();
	
	}

	//print_r($array_nya);
	//die();
	echo "<TABLE ".$property_umum_nya['TABLE']." >
				<thead ".$property_umum_nya['THEAD'].">";
				foreach ($array_nya as $key => $value) {
					
					 if($key==0){
									?>
									<tr <?php echo $property_umum_nya['THEAD_TR'];?> >
										<td width="25"> <B>No.</B> </td>
										<?php 
										$banyaknya_kolom=0;
										//print_r($value);
										//die();
										foreach ($value as $nama_field => $isi_field){
										?>
										<td <?php //echo $property_special_nya['TDHEAD_TD'][$banyaknya_kolom];?> > &nbsp;<B><?php echo str_replace("_"," ",$nama_field);?></B>&nbsp; </td>
										<?php
												$banyaknya_kolom++;
											}
										?>
									</TR>
									
									<?php
								}
					
					if(($key % 2) == 0){
					$bgcolor="#E5E5E5";
					}
					else
					{
						$bgcolor="#FDFDFD";
					}
					$nomernya=$key+1;
					 echo "</thead>
									<tbody ".$property_umum_nya['TBODY']."><tr ".$property_umum_nya['TBODY_TR'].">";
					 echo "<td  > <B> $nomernya. </B> </td>";
					 $banyaknya_kolom=0;
					foreach ($value as $nama_field => $isi_field) 
					{
					?>	
					
					<td <?php //echo $property_special_nya['TDBODY_TD'][$banyaknya_kolom];?> ><?php echo $isi_field?>&nbsp;</td>
					<?php
						$banyaknya_kolom++;
					}
					echo "</tr>";
				}
				echo "</tbody></table>";

}

function array_to_txt_helmi($array_nya,$output_nya,$mode_nya='0')
{

}


function array_to_pdf_helmi($array_nya,$output_nya='',$mode_nya='0')
{
	$html2pdf = new HTML2PDF('P', 'A4', 'fr');
	$html2pdf->setDefaultFont('Arial');
	ob_start();
	include 'd:/Aplikasiweb/8096/test_pdf1.php';
    //array_to_html_helmi($array_nya);
    $content = ob_get_clean();

	//echo $content;
	
	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	//$html2pdf->Output('exemple00.pdf');
	

}



// >> CSV source ==========================================================================================================================

function csv_to_array_helmi($file_csvnya="xyzabcdef.csv",$mode_nya='0')
{
		$row = 0;
		$handle = fopen($file_csvnya, "r");		
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				if($mode_nya=='1'){
						if($row>0){
							$hasil[$row-1]=$data;	
						}
				}
				else
				{									   
						$hasil[$row]=$data;	
				}
			   $row++;
			}
		return $hasil;

}

function csv_to_xls_helmi($file_csvnya="xyzabcdef",$file_xlsnya='xyzabcdef',$mode_nya='0')
{
		$array_new=csv_to_array_helmi($file_csvnya,$mode_nya);
		array_to_xls_helmi($array_new,$file_xlsnya,'0',$mode_nya);
}

function csv_to_sql_helmi($db,$file_csvnya="xyzabcdef.csv",$tabel_nya='employee',$field_nya='',$mode_nya='0')
{
		$hasilnya1=csv_to_array_helmi($file_csvnya,$mode_nya);
		//$db->debug=true;
		foreach ($hasilnya1 as $key => $value) 
			{			
				if($key==0)
				{
							$indeksbaru=$value;
				}
				else
				{
					foreach ($value as $key2 => $value2) 
						{
							
								$indeksbarunya=$indeksbaru[$key2];
								$hasilakhir[$key][$indeksbarunya]=$hasilnya1[$key][$key2];
								
						}
					$hasil_eksekusi=$db->AutoExecute($tabel_nya,$hasilakhir[$key],'INSERT');
				}
			}
		return $hasil_eksekusi;
}





// >> SQL source ==========================================================================================================================

function sql_to_array_helmi($db,$sql,$mode_nya='0')
{
		if(! $arrsql = $db->Execute($sql)){ echo $db->ErrorMsg();die();}
		$ressql = $arrsql->GetArray();
		return $ressql;

}


function sql_to_csv_helmi($db,$sql,$output_filenya="xyzabc.csv",$mode_nya='0')
{
		$arraynya=sql_to_array_helmi($db,$sql,$mode_nya);
		array_to_csv_helmi($arraynya,$output_filenya,$mode_nya);
}


function sql_to_xls_helmi($db,$sql,$output_filenya="xyzabc.xlsx",$mode_nya='0')
	{
		$arraynya=sql_to_array_helmi($db,$sql,$mode_nya);
		array_to_xls_helmi($arraynya,$output_filenya,'0',$mode_nya);
	}

function sql_to_html_helmi($db,$sql,$output_filenya="xyzabc.xlsx",$mode_nya='0')
	{
		$arraynya=sql_to_array_helmi($db,$sql,$mode_nya);
		array_to_html_helmi($arraynya);
	}

function sql_to_pdf_helmi($db,$sql,$output_filenya="xyzabc.xlsx",$mode_nya='0')
	{
		$arraynya=sql_to_array_helmi($db,$sql,$mode_nya);
		array_to_pdf_helmi($arraynya);
	}

}
?>