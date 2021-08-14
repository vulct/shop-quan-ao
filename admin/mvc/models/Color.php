<?php

include_once('DefaultFunction.php');
class Color extends connection
{
    var $connection;

    public function __construct(){
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }

    public function getAllColor(){
        $data = array();
        $sqlGetAllColor = "select * from colors where colorIsDelete = 0";
        $result = $this->connection->query($sqlGetAllColor);
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }

    public function getDetailColor($idColor){
        $sqlGetDetailCate = "select * from colors where colorIsDelete = 0 and coID = {$idColor}";
        $result = $this->connection->query($sqlGetDetailCate);
        return $result->fetch_assoc();
    }

    function deleteColor($id)
    {
        //check id isset in database
        $color = $this->getDetailColor($id);
        if ($color == null) {
            echo json_encode(array('status' => 0, 'message' => 'Vui lòng kiểm tra lại thông tin màu sắc.'));
        } else {
            $sqlUpdateIsDelete = "update colors set colorIsDelete = 1 where coID = {$id}";
            $this->connection->next_result();
            if ($this->connection->query($sqlUpdateIsDelete)) {
                $funcLog = new DefaultFunction();
                $contentLog = 'Xóa thành công màu sắc <b>' . $color['coColor'] . '</b>';
                $funcLog->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                echo json_encode(array('status' => 1, 'message' => 'Màu sắc đã được xóa thành công.'));
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình xóa, vui lòng kiểm tra và thử lại.'));
            }
        }
    }

    public function editColorAction($data)
    {
        $func = new DefaultFunction();
        $id = $func->clearString($data['color_id']);
        // check id coupon
        $detailCoupon = $this->getDetailColor($id);
        if ($detailCoupon){
            $name = $func->clearString($data['name_color']);
            $value_color = $func->clearString($data['code_color']);
            $show_color = (isset($data['show_color']) && $data['show_color'] == "on") ? 0 : 1;
            $sqlUpdate = "update colors set coColor = '{$name}', coCode = '{$value_color}', coStatus = {$show_color} where coID = {$id}";
            $this->connection->next_result();
            $result = $this->connection->query($sqlUpdate);
            if ($result) {
                $contentLog = 'Chỉnh sửa màu <b>' . $name . '</b> thành công.';
                $func->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                echo json_encode(array('status' => 1, 'message' => 'Chỉnh sửa màu sắc thành công.'));
                die();
            }
            echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình chỉnh sửa, vui lòng thử lại.'));
            die();
        }
        echo json_encode(array('status' => 0, 'message' => 'Kiểm tra lại thông tin màu sắc.'));
    }

    public function getNameColor($name)
    {
        $sql = "select * from colors where coColor = '{$name}' and colorIsDelete = 0";
        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    function addColorAction($data)
    {
        $func = new DefaultFunction();
        $name = $func->clearString($data['name_color']);
        $value_color = $func->clearString($data['code_color']);
        $show_color = (isset($data['show_color']) && $data['show_color'] == "on") ? 0 : 1;
        $getNameColor = $this->getNameColor($name);
        if ($getNameColor) {
            echo json_encode(array('status' => 0, 'message' => 'Màu sắc đã tồn tại, vui lòng thêm màu mới.'));
        } else {
            $sqlInsertColor = "INSERT INTO colors(coColor,coCode,coStatus) VALUES ('{$name}','{$value_color}',{$show_color})";
            $result = $this->connection->query($sqlInsertColor);
            if ($result) {
                $funcLog = new DefaultFunction();
                $contentLog = 'Thêm thành công màu <b>' . $name . '</b>';
                $funcLog->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                echo json_encode(array('status' => 1, 'message' => 'Màu đã được thêm thành công.'));
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình thêm mới, vui lòng kiểm tra và thử lại.'));
            }
        }
    }
}