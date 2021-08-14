<?php

include_once('DefaultFunction.php');

class Category extends connection
{
    var $connection;

    public function __construct()
    {
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }

    public function getAllCate()
    {
        $data = array();
        $sqlGetAllCate = "select * from categories where cateIsDelete = 0";
        $result = $this->connection->query($sqlGetAllCate);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getDetailCate($cateID)
    {
        $sqlGetDetailCate = "select cateID,cateName from categories where cateIsDelete = 0 and cateID = {$cateID}";
        $result = $this->connection->query($sqlGetDetailCate);
        return $result->fetch_assoc();
    }

    function deleteCategory($id)
    {
        //check id isset in database
        $cate = $this->getDetailCate($id);
        if ($cate == null) {
            echo json_encode(array('status' => 0, 'message' => 'Vui lòng kiểm tra lại thông tin thư mục.'));
        } else {
            $sqlUpdateIsDelete = "update categories set cateIsDelete = 1 where cateID = {$id}";
            $this->connection->next_result();
            if ($this->connection->query($sqlUpdateIsDelete)) {
                $funcLog = new DefaultFunction();
                $contentLog = 'Xóa thành công danh mục <b>' . $cate['cateName'] . '</b>';
                $funcLog->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                echo json_encode(array('status' => 1, 'message' => 'Danh mục đã được xóa thành công.'));
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình xóa, vui lòng kiểm tra và thử lại.'));
            }
        }
    }

    public function getNameCategory($name)
    {
        $sql = "select * from categories where cateName = '{$name}' and cateIsDelete = 0";
        $this->connection->next_result();
        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    function addCategoryAction($data)
    {
        $cateStatus = (isset($data['show_category']) && $data['show_category'] == "on") ? 0 : 1;
        $clear = new DefaultFunction();
        $cateName = $clear->clearString($data['name_category']);
        $getNameCategory = $this->getNameCategory($cateName);
        if ($getNameCategory) {
            echo json_encode(array('status' => 0, 'message' => 'Thư mục đã tồn tại, vui lòng thêm thư mục mới.'));
        } else {
            $sqlInsertCategory = "INSERT INTO categories(cateName,cateStatus) VALUES ('$cateName','$cateStatus')";
            $result = $this->connection->query($sqlInsertCategory);
            $cateID = $this->connection->insert_id;
            // Đường dẫn thư mục
            $path = "../public/assets/images/products/".$cateID;
            // Kiểm tra thư mục đã tồn tại hay chưa
            if(!file_exists($path)){
                // Tạo một thư mục mới
                if(mkdir($path)){
                    if ($result) {
                        $funcLog = new DefaultFunction();
                        $contentLog = 'Thêm thành công danh mục <b>' . $cateName . '</b>';
                        $funcLog->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                        echo json_encode(array('status' => 1, 'message' => 'Danh mục đã được thêm thành công.'));
                    } else {
                        echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình thêm mới, vui lòng kiểm tra và thử lại.'));
                    }
                } else{
                    echo json_encode(array('status' => 0, 'message' => 'ERROR: Không thể tạo thư mục.'));
                }
            }
        }
    }

    function editCategory($cateID, $nameCategory, $statusCategory)
    {
        // check isset category by id
        $cateDetail = $this->getDetailCate($cateID);
        if ($cateDetail) {
            $sqlUpdateCategory = "update categories set cateName = '$nameCategory', cateStatus = {$statusCategory} where cateID = {$cateID}";
            $this->connection->next_result();
            $result = $this->connection->query($sqlUpdateCategory);
            if ($result) {
                $funcLog = new DefaultFunction();
                $contentLog = 'Chỉnh sửa thành công danh mục <b>' . $cateDetail['cateName'] . '</b>';
                $funcLog->addLog($_SESSION['admin']['id'], addslashes($contentLog));
                echo json_encode(array('status' => 1, 'message' => 'Danh mục đã được chỉnh sửa thành công.'));
                die();
            }
            echo json_encode(array('status' => 0, 'message' => 'Có lỗi trong quá trình chỉnh sửa, vui lòng kiểm tra và thử lại.'));
            die();
        }
        echo json_encode(array('status' => 0, 'message' => 'Không tồn tại danh mục yêu cầu, vui lòng kiểm tra và thử lại.'));
    }

}