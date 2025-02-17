<?php

// insert into database
foreach ($dataResult as $key1 => $value1) {
 //  foreach ($value1 as $key2 => $value2) {   
		// die($sqlInsert."\n".print_r($value1));
	   $insert = $db1->prepare($sqlInsert);
	   $insert->execute(array_values($value1));	   
//	}

}


?>