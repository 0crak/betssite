<?php
	//include connection file
	include_once("ajaxconnection.php");

	$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;

	$action = isset($params['action']) != '' ? $params['action'] : '';
	$usrCls = new user($connString);

	switch($action) {
	 case 'add':
		$usrCls->adduser($params);
	 break;
	 case 'edit':
		$usrCls->updateuser($params);
	 break;
	 case 'delete':
		$usrCls->deleteuser($params);
	 break;
	 default:
	 $usrCls->getUsers($params);
	 return;
	}

	class user {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}

	public function getUsers($params) {

		$this->data = $this->getRecords($params);

		echo json_encode($this->data);

	}
	function adduser($params) {
		$data = array();
		$kasa=10000;
		$sql = "INSERT INTO `users` (login, password, role,balance) VALUES('" . $params["login"] . "', '" . $params["password"] . "','" . $params["role"] . "','". $kasa ."');  ";

		echo $result = mysqli_query($this->conn, $sql) or die("error to insert users data");
	}

	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;

		if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };
        $start_from = ($page-1) * $rp;

		$sql = $sqlRec = $sqlTot = $where = '';


	   // getting total number records without any search
		$sql = "SELECT * FROM `users` ";
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
			"rows"            => $data   // total data array
			);

		return $json_data;
	}
	function updateuser($params) {
		$data = array();
		//print_R($_POST);die;
		$sql = "Update `users` set login = '" . $params["edit_login"] . "', password='" . $params["edit_password"]."', role='" . $params["edit_role"] . "' WHERE id='".$_POST["edit_id"]."'";

		echo $result = mysqli_query($this->conn, $sql) or die("error to update users data");
	}

	function deleteuser($params) {
		$data = array();
		//print_R($_POST);die;
		$sql = "delete from `users` WHERE id='".$params["id"]."'";

		echo $result = mysqli_query($this->conn, $sql) or die("error to delete users data");
	}
}
?>
