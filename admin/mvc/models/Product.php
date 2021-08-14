<?php
include_once('DefaultFunction.php');
include_once('Category.php');
include_once('Color.php');

class Product extends connection
{
    var $connection;

    public function __construct(){
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }

    public function listProduct(){
        $data = array();
        $sqlGetAllProduct = "select p.proID, p.proTitle, p.proPrice, p.proDiscount, p.proImage, p.proDescription, ca.cateName from products p inner join categories ca on p.cateID = ca.cateID where p.proIsDelete = 0 order by p.proID";
        $result = $this->connection->query($sqlGetAllProduct);
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }

    public function detailProduct($id){
        $sqlGetProduct = "call findProduct($id)";
        $result = $this->connection->query($sqlGetProduct);
        return $result->fetch_assoc();
    }

    function getRatingByID($id){
        $sqlGetRating = "call avgRating($id)";
        $result = $this->connection->query($sqlGetRating);
        return $result->fetch_assoc();
    }

    function getColorOfProduct($id){
        $sqlGetColor = "call findColorOfProduct($id)";
        $result = $this->connection->query($sqlGetColor);
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    function getCommentOfProduct($id){
        $sqlGetComment = "call findCommentOfProduct($id)";
        $data = array();
        $result = $this->connection->query($sqlGetComment);
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    function deleteProduct($id){
        //check id isset in database
        $product = $this->detailProduct($id);
        if ($product == null){
            echo json_encode(array('status'=>0,'message'=>'Vui lòng kiểm tra lại thông tin sản phẩm.'));
        }else{
            $sqlUpdateIsDelete = "update products set proIsDelete = 1 where proID = {$id}";
            $this->connection->next_result();
            if ($this->connection->query($sqlUpdateIsDelete)){
                $funcLog = new DefaultFunction();
                $contentLog = 'Xóa thành công sản phẩm <b>'.$product['proTitle'].'</b>';
                $funcLog->addLog($_SESSION['admin']['id'],addslashes($contentLog));
                echo json_encode(array('status'=>1,'message'=>'Sản phẩm đã được xóa thành công.'));
            }else{
                echo json_encode(array('status'=>0, 'message'=>'Có lỗi trong quá trình xóa, vui lòng kiểm tra và thử lại.'));
            }
        }
    }

    function isFileImage($name){
        if(in_array($name , array(IMAGETYPE_JPEG ,IMAGETYPE_PNG)) || $name != null)
        {
            return true;
        }
        return json_encode(array('status'=>0,'message'=>'Vui lòng tải ảnh lên thuộc một trong các định dạng sau: jpeg,png,jpg.'));
    }

    function isFileMaxUpload($size){
        if ($size > 5120000){
            return json_encode(array('status'=>0,'message'=>'Kích thước ảnh tối đa cho phép là 5MB.'));
        }
        return true;
    }

    function insertImageProduct($imageName,$tmp,$cateID){
        // Đường dẫn thư mục
        $dir = "../public/assets/images/products/".$cateID;
        // Kiểm tra thư mục đã tồn tại hay chưa
        if(!file_exists($dir)){
            // Tạo một thư mục mới
            mkdir($dir);
        }
        $path = "../public/assets/images/products/".$cateID."/";
        move_uploaded_file($tmp, $path . $imageName);
        return $cateID ."/". $imageName;
    }

    function checkColor($idColor){
        $findColor = new Color();
        $detailColor = $findColor->getDetailColor($idColor);
        if ($detailColor){
            return true;
        }
        echo json_encode(array('status'=>0,'message'=>'Không tồn tại màu đã chọn, vui lòng kiểm tra lại.'));
        return false;
    }

    function checkCateProduct($cateID){
        $findCate =  new Category();
        $detail = $findCate->getDetailCate($cateID);
        if ($detail){
            return true;
        }else{
            json_encode(array('status'=>0,'message'=>'Không tồn tại danh mục sản phẩm.'));
            return false;
        }
    }

    function insertProduct($data,$cateID,$arrImage){
        $adID = $_SESSION['admin']['id'];
        $clear = new DefaultFunction();
        $proTitle = $clear->clearString($data['name_product']);
        $proPrice = $clear->clearString($data['price_product']);
        $proDiscount = $clear->clearString($data['discount_product']);
        $proCreateAt = date("Y-m-d H:i:s");
        $proImage = isset($arrImage[0]) ? $arrImage[0] : "";
        $proImage1 = isset($arrImage[1]) ? $arrImage[1] : "";
        $proImage2 = isset($arrImage[2]) ? $arrImage[2] : "";
        $proImage3 = isset($arrImage[3]) ? $arrImage[3] : "";
        $proDescription = $clear->clearString($data['description_product']);
        $proStatus = (isset($data['show_product']) && $data['show_product'] == "on" ) ? 0 : 1;
        if ((int)$proDiscount > (int)$proPrice){
            return json_encode(array('status'=>0,'message'=>'Giá sau khi giảm phải nhỏ hơn giá bán ban đầu.'));
        }else{
            $sqlInsertProduct = "INSERT INTO products(adID,proTitle,proPrice,proDiscount,proCreateAt,proImage,proImage1,proImage2,proImage3,proDescription,proStatus,cateID)";
            $sqlInsertProduct .= " VALUES ({$adID},'$proTitle','$proPrice',NULLIF('$proDiscount',''),'$proCreateAt','$proImage','$proImage1','$proImage2','$proImage3','$proDescription',{$proStatus},{$cateID})";
            $result = $this->connection->query($sqlInsertProduct);
            if ($result){
                return $this->connection->insert_id;
            }else{
                return json_encode(array('status'=>0,'message'=>'Thêm sản phẩm không thành công, vui lòng kiểm tra lại.'));
            }
        }
    }

    function updateProduct($data,$cateID,$arrImage)
    {
        $id_product = $data['id_product'];
        $adID = $_SESSION['admin']['id'];
        $clear = new DefaultFunction();
        $proTitle = $clear->clearString($data['name_product']);
        $proPrice = $clear->clearString($data['price_product']);
        $proDiscount = $clear->clearString($data['discount_product']);
        $proImage = $arrImage[0];
        $proImage1 = $arrImage[1];
        $proImage2 = $arrImage[2];
        $proImage3 = $arrImage[3];
        $proDescription = $clear->clearString($data['description_product']);
        $proStatus = (isset($data['show_product']) && $data['show_product'] == "on" ) ? 0 : 1;
        if ((int)$proDiscount > (int)$proPrice){
            return json_encode(array('status'=>0,'message'=>'Giá sau khi giảm phải nhỏ hơn giá bán ban đầu.'));
        }else{
            $sqlUpdateProduct = "UPDATE products SET adID = {$adID}, proTitle = '$proTitle',proPrice = '$proPrice',proDiscount = NULLIF('$proDiscount',''),proImage = '$proImage',proImage1 = '$proImage1',proImage2 = '$proImage2',proImage3 = '$proImage3',proDescription = '$proDescription',proStatus = {$proStatus},cateID = {$cateID} WHERE proID = {$id_product}";
            $this->connection->next_result();
            $result = $this->connection->query($sqlUpdateProduct);
            if ($result){
                return true;
            }else{
                return json_encode(array('status'=>0,'message'=>'Sửa sản phẩm không thành công, vui lòng kiểm tra lại.'));
            }
        }
    }

    function addProductAction($data,$file){
        // Check color product
        for ($i = 0; $i < count($data['group-a']); $i ++){
            $arrCheckColor[] = $this->checkColor($data['group-a'][$i]['color_product']);
        }
        for ($i = 0; $i < count($arrCheckColor); $i++){
            if (gettype($arrCheckColor[$i]) != "boolean"){
                echo $arrCheckColor[$i];
                die();
            }
        }
        // #END check color product

        // check cate product
        $cateID = $data['cate_product'];
        $checkCate = $this->checkCateProduct($cateID);
        if (gettype($checkCate) != "boolean"){
            echo $checkCate;
            die();
        }
        // #END check cate product

        // check and add file image to path

        for ($i = 0;$i < 4; $i++){
            if ($file['image']['name'][$i] != ""){
                if ($this->isFileImage($file['image']['name'][$i]) && $this->isFileMaxUpload($file['image']['size'][$i])){
                    $arrImage[] = $this->insertImageProduct(basename($file['image']['name'][$i]),$file['image']['tmp_name'][$i],$cateID);
                }else{
                    die();
                }
            }
        }
        // #END insert image

        // insert product
        $IDInsertProduct = $this->insertProduct($data,$cateID,$arrImage);
        //#END insert product

        // insert product color
        $arrCheckIDColor = array();
        for ($i = 0; $i < count($data['group-a']); $i++){
            if ($data['group-a'][$i]['quantity_product'] > 0){
                $quantityProduct = (int)$data['group-a'][$i]['quantity_product'];
                $coID = (int)$data['group-a'][$i]['color_product'];
                for ($j = $i +1 ; $j < count($data['group-a']); $j++){
                    if ((int)$data['group-a'][$j]['color_product'] == (int)$data['group-a'][$i]['color_product']){
                        $quantityProduct = (int)$data['group-a'][$j]['quantity_product'] + $quantityProduct;
                        $arrCheckIDColor[] = $j;
                    }
                }
                if (!in_array($i,$arrCheckIDColor)){
                    $sqlInsertProductColor = "INSERT INTO product_colors(proID,procQuantity,coID) VALUES ({$IDInsertProduct},{$quantityProduct},{$coID})";
                    $result = $this->connection->query($sqlInsertProductColor);
                }
            }else{
                echo json_encode(array('status'=>0,'message'=>'Vui lòng nhập số lượng sản phẩm'));
                die();
            }
        }
        if ($result){
            $funcLog = new DefaultFunction();
            $contentLog = 'Thêm thành công sản phẩm <b>'.$IDInsertProduct.'</b>';
            $funcLog->addLog($_SESSION['admin']['id'],addslashes($contentLog));
            echo json_encode(array('status'=>1,'message'=>'Thêm sản phẩm thành công.','idProduct'=>$IDInsertProduct));
            die();
        }
        echo json_encode(array('status'=>0,'message'=>'Thêm sản phẩm không thành công, kiểm tra thông tin và thực hiện lại.'));
        // #END insert product color
    }

    function editProductAction($data,$file){

        // Check product by id_product
        $id_product = $data['id_product'];
        //$currColor = $this->getColorOfProduct($id_product);
//        var_dump(in_array(2,$currColor[1]));
//        die();
        $detailCurrProduct = $this->detailProduct($id_product);
        // #END check product
        if ($detailCurrProduct){
            // Check color product
            for ($i = 0; $i < count($data['group-a']); $i ++){
                $arrCheckColor[] = $this->checkColor($data['group-a'][$i]['color_product']);
            }
            for ($i = 0; $i < count($arrCheckColor); $i++){
                if (gettype($arrCheckColor[$i]) != "boolean"){
                    echo $arrCheckColor[$i];
                    die();
                }
            }
            // #END check color product

            // Check cate product
            $cateID = $data['cate_product'];
            $checkCate = $this->checkCateProduct($cateID);
            if (gettype($checkCate) != "boolean"){
                echo $checkCate;
                die();
            }
            // #END check cate product

            // Check and add file image to path
            $imageCurr[0] = $detailCurrProduct['proImage'];
            $imageCurr[1] = $detailCurrProduct['proImage1'];
            $imageCurr[2] = $detailCurrProduct['proImage2'];
            $imageCurr[3] = $detailCurrProduct['proImage3'];
            for ($i = 0;$i < 4; $i++){
                if ($file['image']['name'][$i] != ""){
                    if ($this->isFileImage($file['image']['name'][$i]) && $this->isFileMaxUpload($file['image']['size'][$i])){
                        $arrImage[] = $this->insertImageProduct(basename($file['image']['name'][$i]),$file['image']['tmp_name'][$i],$cateID);
                    }else{
                        echo json_encode(array('status'=>0,'message'=>'Upload ảnh không thành công.'));
                        die();
                    }
                }else{
                    $arrImage[$i] =  $imageCurr[$i];
                }
            }
            // #END insert image

            // update product
            $statusUpdateProduct = $this->updateProduct($data,$cateID,$arrImage);
            //#END insert product

            if ($statusUpdateProduct){
                // insert product color
                $arrCheckIDColor = array();
                $checkColorEdit = array();
                // get color current
                $this->connection->next_result();
                $currColor = $this->getColorOfProduct($id_product);
                for ($i = 0; $i < count($data['group-a']); $i++){
                    if ($data['group-a'][$i]['quantity_product'] > 0){
                        $quantityBefore = (int)$data['group-a'][$i]['quantity_product'];
                        $coID = (int)$data['group-a'][$i]['color_product'];
                        for ($j = $i +1 ; $j < count($data['group-a']); $j++){
                            if ((int)$data['group-a'][$j]['color_product'] == (int)$data['group-a'][$i]['color_product']){
                                $quantityBefore = (int)$data['group-a'][$j]['quantity_product'] + $quantityBefore;
                                $arrCheckIDColor[] = $j;
                            }
                        }
                        if (!in_array($i,$arrCheckIDColor) && !in_array($coID,$checkColorEdit)){
                            for ($k = 0; $k < count($currColor); $k++){
                                    if (in_array($coID,$currColor[$k]) && !in_array($coID,$checkColorEdit)){
                                        // id color product da ton tai trong db
                                        $sqlUpdateColorProduct = "UPDATE product_colors SET procQuantity = {$quantityBefore} WHERE proID = {$id_product} AND coID = {$coID}";
                                        $this->connection->next_result();
                                        $result = $this->connection->query($sqlUpdateColorProduct);
                                        $checkColorEdit[] = $coID;
                                    }
                            }

                            if (!in_array($coID,$checkColorEdit)){
                                for ($k = 0; $k < count($currColor); $k++){
                                    if (!in_array($coID,$currColor[$k]) && !in_array($coID,$checkColorEdit)){
                                        $sqlInsertProductColor = "INSERT INTO product_colors(proID,procQuantity,coID) VALUES ({$id_product},{$quantityBefore},{$coID})";
                                        $this->connection->next_result();
                                        $result = $this->connection->query($sqlInsertProductColor);
                                        $checkColorEdit[] = $coID;
                                    }
                                }
                            }
                        }
                        } else{
                        echo json_encode(array('status'=>0,'message'=>'Vui lòng nhập số lượng sản phẩm'));
                        die();
                    }
                }
                for ($k = 0; $k < count($currColor); $k++){
                    if (!in_array($currColor[$k]['coID'], $checkColorEdit)) {
                        // da ton tai trong db nhung khong co trong update
                        $sqlUpdateColorProduct = "UPDATE product_colors SET procIsDelete = 1 WHERE proID = {$id_product} AND coID = {$currColor[$k]['coID']}";
                        $this->connection->next_result();
                        $result = $this->connection->query($sqlUpdateColorProduct);
                    }
                }
                if ($result){
                    $funcLog = new DefaultFunction();
                    $contentLog = 'Chỉnh sửa thành công sản phẩm <b>'.$id_product.'</b>';
                    $funcLog->addLog($_SESSION['admin']['id'],addslashes($contentLog));
                    echo json_encode(array('status'=>1,'message'=>'Chỉnh sửa sản phẩm thành công.','idProduct'=>$id_product));
                    die();
                }
                // #END insert product color
            }else{
                echo json_encode(array('status'=>0,'message'=>'Chỉnh sửa sản phẩm không thành công, kiểm tra thông tin và thực hiện lại.'));
            }
        }
    }

}