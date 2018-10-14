<?php
class Functions {
	
	private $conn;
	
	// constructor
	function __construct() {
		require'conn.php';
		// connecting to database
		$db = new Connect();
		$this->conn = $db->connect();
	}
	
	// destructor
	function __destruct() {
		
	}
	
}
?>