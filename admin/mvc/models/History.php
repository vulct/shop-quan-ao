<?php


class History extends connection
{
    var $connection;

    public function __construct(){
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }

    public function historyOrder(){
        $data = array();
        $sqlGetHistoryOrder = "select l.nameBill, l.logBuyContent, l.logBuyCreateAt, u.uFirstName, u.uLastName, u.uEmail from logbuyproduct l inner join user u on l.uID = u.uID order by l.logBuyID DESC";
        $result = $this->connection->query($sqlGetHistoryOrder);
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }

    public function historyCoupon(){
        $data = array();
        $sqlGetHistoryCoupon = "select ld.logdis_ID,ld.logdisTime, d.disCode, u.uFirstName, u.uLastName,u.uEmail  from log_discount ld inner join discounts d on ld.disID = d.disID inner join user u on ld.uID = u.uID order by ld.logdis_ID DESC";
        $result = $this->connection->query($sqlGetHistoryCoupon);
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }

    public function logGeneral(){
        $data = array();
        $sqlGetLogGeneral = "select l.logID, l.logTime, l.logRole, l.logContent,admins.adUsername from logs l inner join admins on l.logUID = admins.adID where l.logRole = 1 order by l.logID DESC";
        $this->connection->next_result();
        $result = $this->connection->query($sqlGetLogGeneral);
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }

    public function logCustomer(){
        $data = array();
        $sqlGetLogGeneral = "select l.logID,l.logTime,l.logContent,u.uFirstName,u.uLastName,u.uEmail, u.uStatus from `logs` l inner join `user` u on l.logUID = u.uID where l.logRole = 0 order by l.logID DESC";
        $result = $this->connection->query($sqlGetLogGeneral);
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }

}