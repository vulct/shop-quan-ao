<?php
include_once('DefaultFunction.php');

class Payment extends connection
{
    var $connection;

    public function __construct()
    {
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }

    public function listPayment()
    {
        $data = array();
        $sql = 'select * from payment_method where payIsDelete = 0';
        $result = $this->connection->query($sql);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getDetailPayment($id)
    {
        $sql = "select * from payment_method where payID = {$id} and payIsDelete = 0";
        $this->connection->next_result();
        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    public function updatePayment($data)
    {
        $func = new DefaultFunction();
        $id = $func->clearString($data['id_payment']);
        $name = $func->clearString($data['name_payment']);
        $status = $func->clearString($data['status_payment']);
        // check id payment
        $detailPayment = $this->getDetailPayment($id);
        if ($detailPayment) {
            $sqlUpdate = "update payment_method set payName = '{$name}', payStatus = {$status} where payID = {$id}";
            $this->connection->next_result();
            $result = $this->connection->query($sqlUpdate);
            if ($result) {
                $contentLog = 'Chỉnh sửa thông tin phương thức thanh toán <b>' . $detailPayment['payName'] . '</b> thành công.';
                $func->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                echo json_encode(array('status' => 1, 'message' => 'Chỉnh sửa thông tin thành công.'));
                die();
            }
            echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình chỉnh sửa, vui lòng thử lại.'));
            die();
        }
        echo json_encode(array('status' => 0, 'message' => 'Kiểm tra lại thông tin phương thức thanh toán.'));
    }

    public function deletePayment($id)
    {
        $func = new DefaultFunction();
        $id = $func->clearString($id);
        // check id payment
        $detailPayment = $this->getDetailPayment($id);
        if ($detailPayment) {
            $sqlUpdate = "update payment_method set payIsDelete = 1 where payID = {$id}";
            $this->connection->next_result();
            $result = $this->connection->query($sqlUpdate);
            if ($result) {
                $contentLog = 'Xóa phương thức thanh toán <b>' . $detailPayment['payName'] . '</b> thành công.';
                $func->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                echo json_encode(array('status' => 1, 'message' => 'Xóa phương thức thanh toán thành công.'));
                die();
            }
            echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình xóa, vui lòng thử lại.'));
            die();
        }
        echo json_encode(array('status' => 0, 'message' => 'Kiểm tra lại thông tin phương thức thanh toán.'));
    }

    public function getNamePayment($name)
    {
        $sql = "select * from payment_method where payName = '{$name}' and payIsDelete = 0";
        $this->connection->next_result();
        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    public function addPaymentAction($data)
    {
        $payStatus = (isset($data['show_payment']) && $data['show_payment'] == "on") ? 0 : 1;
        $clear = new DefaultFunction();
        $payName = $clear->clearString($data['name_payment']);
        // check name payment
        $checkName  = $this->getNamePayment($payName);
        if ($checkName){
            echo json_encode(array('status' => 0, 'message' => 'Phương thức thanh toán đã tồn tại, vui lòng thêm phương thức mới.'));
        }else {
            //select * from payment_method where payName = 'momo' and payIsDelete = 0
            $sqlInsertPayment = "INSERT INTO payment_method(payName,payStatus) VALUES ('{$payName}',{$payStatus})";
            $result = $this->connection->query($sqlInsertPayment);
            if ($result) {
                $funcLog = new DefaultFunction();
                $contentLog = 'Thêm thành công phương thức thanh toán <b>' . $payName . '</b>';
                $funcLog->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                echo json_encode(array('status' => 1, 'message' => 'Phương thức đã được thêm thành công.'));
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình thêm mới, vui lòng kiểm tra và thử lại.'));
            }
        }
    }
}