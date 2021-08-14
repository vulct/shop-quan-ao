<?php
include_once('DefaultFunction.php');
class Customer extends connection
{
    var $connection;

    public function __construct(){
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }

    public function login($data)
    {
        $sql = "select * from admins where adUsername = ? and adPassword = ?";
        if($query = $this->connection->prepare($sql)) {
            $user = array();
            $query->bind_param('ss', $username,$password);
            $username = $data['username'];
            $password = md5($data['password']);
            $query->execute();
            $query->bind_result($id,$username,$password,$status);
            while ($query->fetch()) {
                $user = ['id' => $id, 'username' => $username];
            }
            return $user;
        } else {
            return $this->connection->errno . ' ' . $this->connection->error;
        }
    }

    public function getAllCustomer(){
        $data = array();
        $sqlGetAllCustomer = "select * from user where uIsDelete = 0";
        $result = $this->connection->query($sqlGetAllCustomer);
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }

    public function getDetailCustomer($id){
        $sql = "select * from user where uID = {$id} and uIsDelete = 0";
        $this->connection->next_result();
        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    function deleteCustomer($id){
        //check id isset in database
        $customer = $this->getDetailCustomer($id);
        if ($customer == null){
            echo json_encode(array('status'=>0,'message'=>'Vui lòng kiểm tra lại thông tin khách hàng.'));
        }else{
            $sqlUpdateIsDelete = "update user set uIsDelete = 1 where uID = {$id}";
            $this->connection->next_result();
            if ($this->connection->query($sqlUpdateIsDelete)){
                $funcLog = new DefaultFunction();
                $contentLog = 'Xóa thành công khách hàng <b>'.$customer['uFirstName'].' '.$customer['uLastName'].'</b> - <b>'.$funcLog->obfuscate_email($customer['uEmail']).'</b>';
                $funcLog->addLog($_SESSION['admin']['id'],addslashes($contentLog));
                echo json_encode(array('status'=>1,'message'=>'Khách hàng đã được xóa thành công.'));
            }else{
                echo json_encode(array('status'=>0, 'message'=>'Có lỗi trong quá trình xóa, vui lòng kiểm tra và thử lại.'));
            }
        }
    }

    function editCustomerAction($data){
        //check id isset in database
        $customer = $this->getDetailCustomer($data['uID']);
        if ($customer){
            $clear = new DefaultFunction();
            $uID = $clear->clearString($data['uID']);
            $uFirstName = $clear->clearString($data['first_name']);
            $uLastName = $clear->clearString($data['last_name']);
            $uMobile = $clear->clearString($data['mobile']);
            $province = $clear->clearString($data['province']);
            $district = $clear->clearString($data['district']);
            $wards = $clear->clearString($data['wards']);
            $address = $clear->clearString($data['address']);
            $uUpdateAt = date("Y-m-d H:i:s");
            $uStatus = (isset($data['status_customer']) && $data['status_customer'] == "on" ) ? 0 : 1;
            if ($uFirstName == null || $uLastName == null || $uMobile == null || $wards == null || $district == null || $province == null|| $address == null){
                echo json_encode(array('status'=>0, 'message'=>'Vui lòng điền đầy đủ thông tin khách hàng.'));
                die();
            }else{
                $sql = "update user set uFirstName = '{$uFirstName}',uLastName = '{$uLastName}',uMobile = '{$uMobile}',uAddress = '{$address}',uWards = '{$wards}',uDistrict = '{$district}',uProvince = '{$province}'";
                $sql .= ",uUpdateAt = '$uUpdateAt',uStatus = {$uStatus} where uID = {$uID}";
                $this->connection->next_result();
                $result = $this->connection->query($sql);
                if ($result){
                    $funcLog = new DefaultFunction();
                    $contentLog = 'Chỉnh sửa thành công thông tin khách hàng <b>'.$uFirstName.' '.$uLastName.'</b> - <b>'.$funcLog->obfuscate_email($customer['uEmail']).'</b>';
                    $funcLog->addLog($_SESSION['admin']['id'],addslashes($contentLog));
                    echo json_encode(array('status'=>1,'message'=>'Chỉnh sửa thông tin khách hàng thành công.'));
                    die();
                }
                echo json_encode(array('status'=>0, 'message'=>'Có lỗi trong quá trình chỉnh sửa, vui lòng kiểm tra và thử lại.'));
            }
        }
    }

    public function addCustomerAction($data)
    {
//        convert from code to address string
//        $address = file_get_contents('public/assets/plugins/address/nested-divisions.json');
//        $arrAddress = json_decode($address, true);
//        $dataAddress = array();
//        foreach ($arrAddress as $adr){
//            if ($adr['code'] == $data['province']){
//                $dataAddress['name'] = $adr['name'];
//                foreach ($adr['districts'] as $dis){
//                    if ($dis['code'] == $data['district']){
//                        $dataAddress['district'] = $dis['name'];
//                        foreach ($dis['wards'] as $w){
//                            if ($w['code'] == $data['wards']){
//                                $dataAddress['wards'] = $w['name'];
//                            }
//                        }
//                    }
//                }
//            }
//        }
        // check email
        $clear = new DefaultFunction();
        $email = $clear->clearString($data['email']);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $detailEmail = $this->checkEmailCustomer($email);
            if (!$detailEmail) {
                $uRegisteredAt = date("Y-m-d H:i:s");
                $uUpdateAt = date("Y-m-d H:i:s");
                $first_name = $clear->clearString($data['first_name']);
                $last_name = $clear->clearString($data['last_name']);
                $mobile = $clear->clearString($data['mobile']);
                $province = $clear->clearString($data['province']);
                $district = $clear->clearString($data['district']);
                $wards = $clear->clearString($data['wards']);
                $address = $clear->clearString($data['address']);
                $status_customer = (isset($data['status_customer']) && $data['status_customer'] == "on") ? 0 : 1;;
                $sqlInsertCustomer = "insert into user(uFirstName,uLastName,uMobile,uEmail,uAddress,uWards,uDistrict,uProvince,uRegisteredAt,uUpdateAt,uStatus) ";
                $sqlInsertCustomer .= "values ('{$first_name}','{$last_name}','{$mobile}','{$email}','{$address}','{$wards}','{$district}','{$province}','{$uRegisteredAt}','{$uUpdateAt}',{$status_customer})";
                $result = $this->connection->query($sqlInsertCustomer);
                if ($result) {
                    $funcLog = new DefaultFunction();
                    $contentLog = 'Thêm thành công khách hàng <b>' . $first_name . ' ' . $last_name . '</b> - <b>' . $funcLog->obfuscate_email($email) . '</b>';
                    $funcLog->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                    echo json_encode(array('status' => 1, 'message' => 'Khách hàng đã được thêm thành công.'));
                    die();
                }
                echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình thêm mới, vui lòng kiểm tra và thử lại.'));
                die();
            }
            echo json_encode(array('status' => 0, 'message' => 'Email đã tồn tại trong hệ thống, vui lòng kiểm tra và thử lại.'));
            die();
        }
        echo json_encode(array('status' => 0, 'message' => 'Vui lòng nhập địa chỉ email đúng định dạng.'));
    }

    function checkEmailCustomer($email){
        $sql = "select * from user where uEmail = '{$email}' and uIsDelete = 0";
        $this->connection->next_result();
        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

}