<?php

include_once('DefaultFunction.php');

class Feedback extends connection
{
    var $connection;

    public function __construct()
    {
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }

    public function listFeedback()
    {
        $data = array();
        $sql = 'select * from feedback where fbIsDelete = 0';
        $result = $this->connection->query($sql);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getDetailFeedback($id)
    {
        $sql = "select * from feedback where fbID = {$id} and fbIsDelete = 0";
        $this->connection->next_result();
        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    public function updateStatus($data)
    {
        $func = new DefaultFunction();
        // check id feedback
        $id = $func->clearString($data['id_fb_status']);
        $status = $func->clearString($data['status_fb']);
        $detailFB = $this->getDetailFeedback($id);
        if ($detailFB) {
            $sqlUpdate = "update feedback set fbStatus = {$status} where fbID = {$id}";
            $this->connection->next_result();
            $result = $this->connection->query($sqlUpdate);
            if ($result) {
                $contentLog = 'Cập nhật trạng thái phản hồi của khách hàng <b>' . $detailFB['fbName'] . '</b> - <b>' . $func->obfuscate_email($detailFB['fbEmail']) . '</b> thành công.';
                $func->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                echo json_encode(array('status' => 1, 'message' => 'Cập nhật trạng thái phản hồi thành công.'));
                die();
            }
            echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình cập nhật, vui lòng thử lại.'));
            die();
        }
        echo json_encode(array('status' => 0, 'message' => 'Kiểm tra lại thông tin phản hồi.'));
    }

    public function deleteFB($id)
    {
        $func = new DefaultFunction();
        // check id feedback
        $id = $func->clearString($id);
        $detailFB = $this->getDetailFeedback($id);
        if ($detailFB){
            $sqlUpdate = "update feedback set fbIsDelete = 1 where fbID = {$id}";
            $this->connection->next_result();
            $result = $this->connection->query($sqlUpdate);
            if ($result) {
                $contentLog = 'Xóa phản hồi của khách hàng <b>' . $detailFB['fbName'] . '</b> - <b>' . $func->obfuscate_email($detailFB['fbEmail']) . '</b> thành công.';
                $func->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                echo json_encode(array('status' => 1, 'message' => 'Xóa phản hồi thành công.'));
                die();
            }
            echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình xóa, vui lòng thử lại.'));
            die();
        }
        echo json_encode(array('status' => 0, 'message' => 'Kiểm tra lại thông tin phản hồi.'));
    }
}