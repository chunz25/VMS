<?php
function sql_to_array_helmi($db,$sql,$mode_nya='0')
{
		if(! $arrsql = $db->Execute($sql)){ echo $db->ErrorMsg();die();}
		$ressql = $arrsql->GetArray();
		return $ressql;

}

function array_to_table_helmi($array_nya,$array_tampil_nya,$property_table='',$property_thead='',$property_body='',$property_tfoot='')
{
	
	foreach ($array_tampil_nya as $key => $value) {
			$judul_kolom_arr = explode(";",$value);
			$judul_kolom[] = $judul_kolom_arr[0];
			$field_kolom[] = $judul_kolom_arr[1];

	}

	//print_r($array_nya);
	//die();
	echo "<TABLE ".$property_table." >
				<thead ".$property_thead.">
				<TR>
				<td width='25'> <B>No.</B> </td>
				";
				
				foreach ($judul_kolom as $key2 => $value2)
					
					{
									?>
									
										
										
										<td > &nbsp;<B><?php echo $value2 ;?></B>&nbsp; </td>
										
									
									
									<?php
					}
					?>
					</TR>
					</THEAD>
					<TBODY <?php echo $property_body;?> >
					<?php
					$nomornya=0;
						foreach ($array_nya as $key3 => $value3) {
							$nomornya++;
					?>
									
					<tr>		
							<td><?php echo $nomornya?>.</td>
							<?php
							foreach ($field_kolom as $key4 => $value4)					
							{
							?>
							<td><?php echo $value3[$value4];?>&nbsp;</td>
							<?php
							}
							?>
					</tr>
					<?php
						
					
					
				}
				?>
				</tr>
				</tbody></table>
				<?php

}

?>