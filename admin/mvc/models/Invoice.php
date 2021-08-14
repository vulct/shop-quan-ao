<?php

include_once('DefaultFunction.php');

class Invoice extends connection
{
    var $connection;

    public function __construct()
    {
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }

    public function listInvoice()
    {
        $data = array();
        $sql = "select * from bill ORDER BY biID DESC";
        $result = $this->connection->query($sql);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getDetailBill($id)
    {
        $data = array();
        $sql = "call findBillDetailsBybiID({$id})";
        $this->connection->next_result();
        $result = $this->connection->query($sql);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getBillDetail($id)
    {
        $data = array();
        $sql = "SELECT * FROM (((bill b INNER JOIN bill_details bd ON bd.biID = b.biID) INNER JOIN product_colors pc ON pc.procID = bd.procID) INNER JOIN colors c ON c.coID = pc.coID) INNER JOIN products p ON p.proID = pc.proID WHERE b.biID = '$id'";
        $result = $this->connection->query($sql);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getDetailBillByID($id)
    {
        $sql = "select * from bill where biID = {$id}";
        $this->connection->next_result();
        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    public function updateStatus($data)
    {
        $func = new DefaultFunction();
        $id_bill_status = $func->clearString($data['id_bill_status']);
        $status_bill = $func->clearString($data['status_bill']);
        $biUpdateAt = date("Y-m-d H:i:s");
        // check invoice id exists or not.
        $detailBill = $this->getDetailBill($id_bill_status);
        if ($detailBill) {
            $billName = $this->getDetailBillByID($id_bill_status);
            if ($status_bill == 4) {
                // get product color current
                // procID,bidQuantity
                foreach ($detailBill as $deBill) {
                    $sqlGetProductColor = "select procID,procQuantity from product_colors where procID = {$deBill['procID']} and procIsDelete = 0";
                    $this->connection->next_result();
                    $procProduct = $this->connection->query($sqlGetProductColor)->fetch_assoc();
                    if ($procProduct) {
                        $quantity = $procProduct['procQuantity'] + $deBill['bidQuantity'];
                        $sqlUpdateProductColor = "update product_colors set procQuantity = {$quantity} where procID = {$deBill['procID']} and procIsDelete = 0";
                        $this->connection->next_result();
                        $status_update = $this->connection->query($sqlUpdateProductColor);
                    }
                }
                if ($status_update) {
                    $sqlUpdate = "update bill set biStatus = {$status_bill},biUpdateAt = '{$biUpdateAt}' where biID = {$id_bill_status}";
                    $this->connection->next_result();
                    $result = $this->connection->query($sqlUpdate);
                    if ($result) {
                        $contentLog = 'Cập nhật trạng thái đơn hàng <b>#' . $billName['biName'] . '</b> thành công.';
                        $func->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                        echo json_encode(array('status' => 1, 'message' => 'Cập nhật trạng thái đơn hàng thành công.'));
                        die();
                    }
                    echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình cập nhật, vui lòng thử lại.'));
                    die();
                }
                echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình cập nhật số lượng sản phẩm, vui lòng thử lại.'));
                die();
            } else {
                $sqlUpdate = "update bill set biStatus = {$status_bill},biUpdateAt = '{$biUpdateAt}' where biID = {$id_bill_status}";
                $this->connection->next_result();
                $result = $this->connection->query($sqlUpdate);
                if ($result) {
                    $contentLog = 'Cập nhật trạng thái đơn hàng <b>#' . $billName['biName'] . '</b> thành công.';
                    $func->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                    echo json_encode(array('status' => 1, 'message' => 'Cập nhật trạng thái đơn hàng thành công.'));
                    die();
                }
                echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình cập nhật, vui lòng thử lại.'));
            }
            die();
        }
        echo json_encode(array('status' => 0, 'message' => 'Kiểm tra lại thông tin đơn hàng.'));
    }


}