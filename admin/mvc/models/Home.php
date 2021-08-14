<?php


class Home extends connection
{
    var $connection;

    public function __construct(){
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }

    public function getSumBill(){
        $sqlGetSumBill = "SELECT SUM(biTotal) sumBill FROM bill WHERE biStatus = 3";
        $result = $this->connection->query($sqlGetSumBill);
        return $result->fetch_assoc();
    }

    public function getRecentOrders(){
        $data = array();
        $sqlGetRecentOrders = "select * from bill ORDER BY biID DESC limit 5";
        $result = $this->connection->query($sqlGetRecentOrders);
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }

    public function getComment(){
        $sqlGetComment = "select c.comRating, c.comContent,c.comPublishedAt,p.proTitle,u.uFirstName, u.uLastName from comments c inner join user u on c.uID = u.uID inner join products p on c.proID = p.proID limit 5";
        $result = $this->connection->query($sqlGetComment);
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }

    public function getCountBill(){
        $sqlGetCountBill = "SELECT count(biID) totalBill from bill";
        $result = $this->connection->query($sqlGetCountBill);
        return $result->fetch_assoc();
    }

    public function countUser(){
        $sqlCountUser = "SELECT count(uID) totalUser from user where uIsDelete = 0";
        $result = $this->connection->query($sqlCountUser);
        return $result->fetch_assoc();
    }
}