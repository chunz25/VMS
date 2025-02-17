<?php
class cekTimeProcess {
  public $start;
  public $finish;
  public $start_int;
  public $finish_int;
  public $nameDB;
  public $nameTable;
  public $userName;
  public $limitTime;
  public $desc;
  public $desc2;
  private $conn;

  function __construct($namedb="",$limit_time=3,$description="",$username="",$description2="") {
    $this->start = date("Y-m-d H:i:s"); 
    $this->start_int = strtotime(date("Y-m-d H:i:s")); 
	$this->limitTime=$limit_time;
	$this->desc=$description;
	$this->desc2=$description2;
	$this->nameTable="log_".date("Ymd");
	$this->userName=$username;
	if($namedb==""){$this->nameDB = "log";}
	$this->conn = new PDO('sqlite:file:'.__DIR__.'/'.$this->nameDB.'_'.date("Ym").".db");
	$sql0='CREATE TABLE IF NOT EXISTS "'.$this->nameTable.'" (
			"cronjob_code" VARCHAR(20) NULL,
			"cronjob_name" VARCHAR(100) NULL,
			"start_date" DATETIME NULL,
			"finish_date" DATETIME NULL,
			"duration" INTEGER NULL,
			"status" VARCHAR(50) NULL,
			"created_by" VARCHAR(50) NULL,
			"username" VARCHAR(50) NULL,
			"ip" VARCHAR(50) NULL,
			"description1" VARCHAR(255) NULL,
			"description2" VARCHAR(255) NULL,
			"filename" VARCHAR(255) NULL,
			"include_file" TEXT
		)';
	$this->conn->exec($sql0);
  }
  function __destruct() {
	$this->finish = date("Y-m-d H:i:s");	
	
	$this->finish_int = strtotime(date("Y-m-d H:i:s"));
	$duration = $this->finish_int - $this->start_int;
	
	if($duration>$this->limitTime){
	$include_file=str_replace(str_replace("_log","",__DIR__)," ",implode(",",get_included_files()));
	$sql="INSERT INTO ".$this->nameTable."(start_date,finish_date,duration,filename,description1,description2,username,ip,include_file) values('".$this->start."','".$this->finish."',".$duration.",'".__FILE__."','".$this->desc."','".$this->desc2."','".$this->userName."','".$this->get_client_ip()."','".$include_file."')";
	$this->conn->exec($sql);
	}
	$this->conn=null;
	
	/*
	echo "<pre>";
    echo(str_replace(str_replace("_log","",__DIR__)," ",implode(",",get_included_files())))."<br>\n";
    echo "Duration is {$duration} seconds ";
	*/
	
  }
  
  function get_client_ip() 
  {
    $ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
	}

}
?>