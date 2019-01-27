<?php
	//include connection file 
	include_once("ajaxconnection.php");
	
	$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$betCls = new user($connString);

	switch($action) {
	 case 'add':
		$betCls->addbet($params);
	 break;
	 case 'delete':
		$betCls->deletebet($params);
	 break;
	 default:
	 $betCls->getbets($params);
	 return;
	}
	
	class user {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}

	public function getbets($params) {
		
		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
		
	}
	function addbet($params) {
		$data = array();;
		$sql = "INSERT INTO `bets` (category, rateX, rateY,druzynaA,druzynaB) VALUES('" . $params["category"] . "', '" . $params["rateX"] . "','" . $params["rateY"] . "','". $params["druzynaA"] ."','".$params["druzynaB"] ."');  ";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to insert bets data");
		
	}
	
	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
		
		if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };  
        $start_from = ($page-1) * $rp;
		
		$sql = $sqlRec = $sqlTot = $where = '';
		
	
	   // getting total number records without any search
		$sql = "SELECT * FROM `bets` ";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}
		if ($rp!=-1)
		$sqlRec .= " LIMIT ". $start_from .",".$rp;
		
		
		$qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot employees data");
		$queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch employees data");
		
		while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			$data[] = $row;
		}

		$json_data = array(
			"current"            => intval($params['current']), 
			"rowCount"            => 10, 			
			"total"    => intval($qtot->num_rows),
			"rows"            => $data
			);
		
		return $json_data;
	}
	
	function deletebet($params) {
		$data = array();
		//print_R($_POST);die;
		$sql = "delete from `bets` WHERE betsID='".$params["betsID"]."'";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to delete bets data");
	}
}
?>