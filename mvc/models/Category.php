<?php


class Category extends connection
{
    var $connection;

    function __construct(){
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }

    function getCateByID($id){
        $sqlGetCateByID = "CALL findCateOfProduct($id)";
        $result = $this->connection->query($sqlGetCateByID);
        return $data = $result->fetch_assoc();
    }

    function getAllCate(){
        //Lấy tổng số sản phẩm có trong từng danh mục.
        $sqlGetAllCate = "SELECT count(pro.proID) as totalCate,ca.cateID,ca.cateName FROM products pro INNER JOIN categories ca ON ca.cateID = pro.cateID WHERE ca.cateIsDelete = 0 AND ca.cateStatus = 0 AND pro.proIsDelete = 0 AND pro.proStatus = 0 GROUP BY ca.cateID";
        $result = $this->connection->query($sqlGetAllCate);
        $data = array();
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

}