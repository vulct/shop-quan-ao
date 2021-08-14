<?php
include_once('DefaultFunction.php');
class Coupon extends connection
{
    var $connection;

    public function __construct()
    {
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }

    public function listCoupon()
    {
        $data = array();
        $sql = 'select d.disID,d.disCode,d.disValue,d.disStart,d.disEnd,d.disAmount,d.disUsed,d.disStatus,a.adUsername from discounts d inner join admins a on d.adID = a.adID where d.disIsDelete = 0';
        $result = $this->connection->query($sql);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getDetailCoupon($id){
        $sql = "select * from discounts where disIsDelete = 0 and disID = {$id}";
        $this->connection->next_result();
        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    public function editCouponAction($data)
    {
        $func = new DefaultFunction();
        $id = $func->clearString($data['coupon_id']);
        // check id coupon
        $detailCoupon = $this->getDetailCoupon($id);
        if ($detailCoupon){
            $name = $func->clearString($data['name_coupon']);
            $value_coupon = $func->clearString($data['value_coupon']);
            $date_start = $func->clearString($data['date_start']);
            $date_end = $func->clearString($data['date_end']);
            $amount_coupon = $func->clearString($data['amount_coupon']);
            $show_coupon = (isset($data['show_coupon']) && $data['show_coupon'] == "on") ? 0 : 1;
            $adID = $_SESSION['admin']['id'];
            $sqlUpdate = "update discounts set disCode = '{$name}', disValue = {$value_coupon}, disStart = '{$date_start}', disEnd = '{$date_end}', disAmount = {$amount_coupon}, disStatus = {$show_coupon}, adID = {$adID}";
            $sqlUpdate .= " where disID = {$id}";
            $this->connection->next_result();
            $result = $this->connection->query($sqlUpdate);
            if ($result) {
                $contentLog = 'Chỉnh sửa thông tin mã giảm giá <b style="text-transform: uppercase">' . $name . '</b> thành công.';
                $func->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                echo json_encode(array('status' => 1, 'message' => 'Chỉnh sửa thông tin mã giảm giá thành công.'));
                die();
            }
            echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình chỉnh sửa, vui lòng thử lại.'));
            die();
        }
        echo json_encode(array('status' => 0, 'message' => 'Kiểm tra lại thông tin mã giảm giá.'));
    }

    public function deleteCoupon($id)
    {
        $func = new DefaultFunction();
        $id = $func->clearString($id);
        // check id payment
        $detailCoupon = $this->getDetailCoupon($id);
        if ($detailCoupon) {
            $sqlUpdate = "update discounts set disIsDelete = 1 where disID = {$id}";
            $this->connection->next_result();
            $result = $this->connection->query($sqlUpdate);
            if ($result) {
                $contentLog = 'Xóa mã giảm giá <b style="text-transform: uppercase">' . $detailCoupon['disCode'] . '</b> thành công.';
                $func->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                echo json_encode(array('status' => 1, 'message' => 'Xóa mã giảm giá thành công.'));
                die();
            }
            echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình xóa, vui lòng thử lại.'));
            die();
        }
        echo json_encode(array('status' => 0, 'message' => 'Kiểm tra lại thông tin mã giảm giá.'));
    }

    public function getNameCoupon($name)
    {
        $sql = "select * from discounts where disCode = '{$name}' and disIsDelete = 0";
        $this->connection->next_result();
        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    public function addCouponAction($data)
    {
        $func = new DefaultFunction();
        $name = $func->clearString($data['name_coupon']);
        $value_coupon = $func->clearString($data['value_coupon']);
        $date_start = $func->clearString($data['date_start']);
        $date_end = $func->clearString($data['date_end']);
        $amount_coupon = $func->clearString($data['amount_coupon']);
        $show_coupon = (isset($data['show_coupon']) && $data['show_coupon'] == "on") ? 0 : 1;
        $adID = $_SESSION['admin']['id'];
        // check the coupon name and end date
        $getName = $this->getNameCoupon($name);
        $timeCurr = date("Y-m-d H:i:s");
        if ($getName && strtotime($getName['disEnd']) > strtotime($timeCurr)){
            echo json_encode(array('status' => 0, 'message' => 'Mã giảm giá đã tồn tại và đang còn thời hạn sử dụng, vui lòng thêm mã giảm giá mới hoặc chỉnh sửa mã giảm giá đã có.'));
            die();
        }
        $sqlInsertCoupon = "INSERT INTO discounts(disCode,disValue,disStart,disEnd,disAmount,disStatus,adID)";
        $sqlInsertCoupon .= "VALUES ('{$name}', {$value_coupon}, '{$date_start}', '{$date_end}', {$amount_coupon}, {$show_coupon}, {$adID})";
        $result = $this->connection->query($sqlInsertCoupon);
        if ($result) {
            $funcLog = new DefaultFunction();
            $contentLog = 'Thêm thành công mã giảm giá <b style="text-transform: uppercase">' . $name . '</b>';
            $funcLog->addLog($_SESSION['admin']['id'], addslashes($contentLog));
            echo json_encode(array('status' => 1, 'message' => 'Mã giảm giá đã được thêm thành công.'));
        } else {
            echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình thêm mới, vui lòng kiểm tra và thử lại.'));
        }
    }
}