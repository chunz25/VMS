<?php
class cekTimeProcess {
  public $start;
  public $finish;
  public $start_int;
  public $finish_int;

  function __construct() {
    $this->start = date("Y-m-d H:i:s"); 
    $this->start_int = strtotime(date("Y-m-d H:i:s")); 
  }
  function __destruct() {
	$this->finish = date("Y-m-d H:i:s");
	$conn = new PDO('sqlite:file:'.__DIR__.'/foo.db');
	$this->finish_int = strtotime(date("Y-m-d H:i:s"));
	$duration = $this->finish_int - $this->start_int;
    echo "Duration is {$duration} seconds ".__DIR__; 
  }
}
?>