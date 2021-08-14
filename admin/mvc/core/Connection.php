<?php 
/**
 * 
 */
class connection
{
	public $conn;
	function __construct()
	{
		$host_db = "localhost";
		$username_db = "root";
		$password = "";
		$name_db = "db_shopbanquanao";
//        $host_db = "localhost";
//        $username_db = "vulcttkq_admin";
//        $password = "matkhau123";
//        $name_db = "vulcttkq_shopbanquanao";
	    $this->conn = new mysqli($host_db, $username_db, $password, $name_db);

	    $this->conn->set_charset("utf8"); // set utf-8 dể đọc dữ liệu tiếng Việt

	    // Check connection
	    if ($this->conn->connect_error) {
	        die("Connection failed: " . $this->conn->connect_error);
	    }
	}
}

 ?>