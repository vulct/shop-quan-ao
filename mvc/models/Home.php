<?php 
	class Home extends connection
	{
		var $connection;

		function __construct(){
			$conn_obj = new Connection();
			$this->connection = $conn_obj->conn;
		}

		function getAllProduct(){
            $sqlGetAllProducts = "SELECT * from products WHERE proStatus = 0 and proIsDelete = 0 ORDER BY proID ASC limit 9";
		    $data = array();
		    $result = $this->connection->query($sqlGetAllProducts);
		    while($row = $result->fetch_assoc()) { 
		    	$data[] = $row;
		    }
		    return $data;
		}

		function addFeedback($name,$email,$message){
		    $time = date("Y-m-d H:i:s");
            $sqlInsertFB = "CALL insertFeedBack("."'$name'".","."'$email'".","."'$message'".","."'$time'".")";
            return $result = $this->connection->query($sqlInsertFB);

        }

        //get products sale
        function getProductsSale(){
		    $sql = "SELECT * FROM products WHERE proDiscount > 0 and proIsDelete = 0 and proStatus = 0 ORDER BY proCreateAt ASC LIMIT 0,10";
		    $result = $this->connection->query($sql);
		    $data = array();
		    while ($row = $result->fetch_assoc()){
		        $data[] = $row;
            }
            return $data;
        }

        function getAllFB(){
            $sql = "select * from feedback where fbIsDelete = 0 and fbStatus = 0 order by fbID DESC limit 5";
            $result = $this->connection->query($sql);
            $data = array();
            while ($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
	}