<?php
ini_set('display_errors',1);
$aa=$_REQUEST['a'];
$bb=$_REQUEST['b'];
$cc=$_REQUEST['c'];
$dd=md5(md5("helmianwar999".date("Ymd")));
// $folder=__DIR__."/_docs/".$cc."/";
// $folder=$_MAIN__CONFIGS_040[910]."/".$cc."/";
$folder=$cc;

// file yang bisa dibuka,
$extfileallowed=array('pdf','jpg','jpeg','png','gif');
// print_r($_REQUEST);
if($aa==$dd){
$file_path = $folder.$bb;
// die($file_path);	
if(!file_exists($file_path))
{	
	$ext_yang_ada="";
	foreach ($extfileallowed as $bb_add) {
		if(file_exists($file_path.".".$bb_add))
		{
			$ext_yang_ada=".".$bb_add;
		}
	}
	$file_path=$file_path.$ext_yang_ada;
	// $file_path=$file_path.".pdf";
	// readfile($file_path);
}

 
if (file_exists($file_path)) {
    $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
    $content_type = '';

    if ($file_extension === 'pdf') {
        $content_type = 'application/pdf';
    } elseif (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
        $content_type = 'image/' . $file_extension;
    } else {
        echo "Unsupported file format!";
        exit;
    }

    header("Content-type: $content_type");
    echo file_get_contents($file_path);
} else {
    echo $file_path."File not found!";
}
}
?>
