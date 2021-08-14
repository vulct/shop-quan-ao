<?php

include_once('DefaultFunction.php');

class Product extends connection
{
    var $connection;

    function __construct()
    {
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }

    function getAllProduct($current_page)
    {
        $sqlGetToTal = "select count(proID) as total from products WHERE proStatus = 0 AND proIsDelete = 0";
        $resultTotal = $this->connection->query($sqlGetToTal);
        $total = $resultTotal->fetch_assoc();
        $total_records = $total['total'];
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 12;
        $total_page = ceil($total_records / $limit);

        if ($current_page > $total_page) {
            $current_page = $total_page;
        } else if ($current_page < 1) {
            $current_page = 1;
        }

        $start = ($current_page - 1) * $limit;
        $sqlGetAllProducts = "SELECT proID,proTitle,proPrice,proDiscount,proImage from products WHERE proStatus = 0 AND proIsDelete = 0 ORDER BY proID ASC LIMIT {$start},{$limit}";
        $data = array();
        $result = $this->connection->query($sqlGetAllProducts);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return array(
            'data' => $data,
            'total' => $total,
            'total_page' => $total_page,
            'current_page' => $current_page
        );
    }

    public function getProductByCate($current_page, $id)
    {
        $sqlGetToTal = "select count(proID) as total from products pr INNER JOIN categories ca ON pr.cateID = ca.cateID WHERE proStatus = 0 AND proIsDelete = 0 AND ca.cateID = {$id} AND ca.cateIsDelete = 0";
        $resultTotal = $this->connection->query($sqlGetToTal);
        $total = $resultTotal->fetch_assoc();
        $total_records = $total['total'];
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 12;
        $total_page = ceil($total_records / $limit);

        if ($current_page > $total_page) {
            $current_page = $total_page;
        } else if ($current_page < 1) {
            $current_page = 1;
        }

        $start = ($current_page - 1) * $limit;
        $sqlGetAllProducts = "SELECT proID,proTitle,proPrice,proDiscount,proImage from products pr INNER JOIN categories ca ON pr.cateID = ca.cateID WHERE proStatus = 0 AND proIsDelete = 0 AND ca.cateID = {$id} AND ca.cateIsDelete = 0 ORDER BY proID ASC LIMIT {$start},{$limit} ";
        $data = array();
        $result = $this->connection->query($sqlGetAllProducts);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return array(
            'data' => $data,
            'total' => $total,
            'total_page' => $total_page,
            'current_page' => $current_page
        );
    }

    function showProduct($id)
    {
        $sqlGetProduct = "call findProduct($id)";
        $result = $this->connection->query($sqlGetProduct);
        $product = $result->fetch_assoc();
        if ($product['proID'] == null) {
            header("Location: ?mod=product&act=error_product");
            return false;
        } else {
            return $product;
        }
    }

    public function checkUser()
    {
        if (!isset($_SESSION['user'])) {
            setcookie("login_check", "First, sign in to your account. If you do not have an account please register.", time() + 30);
            //header("Location: ?mod=login");
            return false;
        } else {
            return true;
        }
    }

    function getProductCart($data)
    {
        if ($this->checkUser()) {
            $id = $data['proID'];
            $color = $data['valueColor'];
            $numProduct = $data['numProduct'];
            $maxColor = $data['maxColor'];
            // tim procID by color and proID
            //SELECT pc.procID, co.coColor FROM product_colors pc INNER JOIN colors co ON pc.coID = co.coID WHERE pc.proID = '1' AND pc.coID = '1'
            $sqlFindProcID = "SELECT pc.procID, co.coColor FROM product_colors pc INNER JOIN colors co ON pc.coID = co.coID WHERE pc.proID = '$id' AND pc.coID = '$color' AND co.colorIsDelete = 0";
            $result = $this->connection->query($sqlFindProcID);
            $checkColor = $result->fetch_assoc();
            if ($numProduct == 1) {
                $mess = "new product added to your cart";
            } else {
                $mess = "new products added to your cart";
            }
            if ($checkColor != null) {
                $product = $this->showProduct($id);
                if ($product['proDiscount']) {
                    $price = $product['proDiscount'];
                } else {
                    $price = $product['proPrice'];
                }
                if (!isset($_SESSION['cart'])) {
                    $cart = array();
                    $cart[$id][$color] = array(
                        'name' => $product['proTitle'],
                        'numProduct' => $numProduct,
                        'price' => $price,
                        'image' => $product['proImage'],
                        'color' => $checkColor['coColor'],
                        'procID' => $checkColor['procID']
                    );
                } else {
                    $cart = $_SESSION['cart'];
                    if (key_exists($id, $cart)) {
                        if (key_exists($color, $cart[$id])) {
                            $numOld = $cart[$id][$color]['numProduct'] + $numProduct;
                            if ($numOld > $maxColor) {
                                echo json_encode(array(
                                    'status' => '0',
                                    'message' => 'The maximum quantity allowed to add to cart is: ' . $maxColor . '.'
                                ));
                                exit();
                            } else {
                                $cart[$id][$color] = array(
                                    'name' => $product['proTitle'],
                                    'numProduct' => (int)$cart[$id][$color]['numProduct'] + $numProduct,
                                    'price' => $price,
                                    'image' => $product['proImage'],
                                    'color' => $checkColor['coColor'],
                                    'procID' => $checkColor['procID']
                                );
                            }
                        } else {
                            // gán cho các giá trị hiện tại
                            $cart[$id][$color] = array(
                                'name' => $product['proTitle'],
                                'numProduct' => $numProduct,
                                'price' => $price,
                                'image' => $product['proImage'],
                                'color' => $checkColor['coColor'],
                                'procID' => $checkColor['procID']
                            );
                        }
                    } else {
                        $cart[$id][$color] = array(
                            'name' => $product['proTitle'],
                            'numProduct' => $numProduct,
                            'price' => $price,
                            'image' => $product['proImage'],
                            'color' => $checkColor['coColor'],
                            'procID' => $checkColor['procID']
                        );
                    }
                }
                $_SESSION['cart'] = $cart;
                echo json_encode(array(
                    'status' => '1',
                    'data' => $cart[$id][$color],
                    'number' => $numProduct,
                    'message' => $numProduct . ' ' . $mess
                ));
            } else {
                echo json_encode(array(
                    'status' => '0',
                    'message' => 'Error adding product to cart.'));
            }
        } else {
            echo json_encode(array('status' => '2', 'message' => 'Sign in to order and get more discount codes.'));
            die();
        }
    }

    function updateCart()
    {
        $proID = $_POST['proID'];
        $colorID = $_POST['colorID'];
        // tim max color
//        SELECT pc.procID, co.coColor,pc.procQuantity FROM product_colors pc INNER JOIN colors co ON pc.coID = co.coID WHERE pc.proID = '2' AND pc.coID = '1'
        $sqlFindProcID = "SELECT pc.procID, co.coColor,pc.procQuantity FROM product_colors pc INNER JOIN colors co ON pc.coID = co.coID WHERE pc.proID = '$proID' AND pc.coID = '$colorID' AND pc.procStatus = 0 AND pc.procIsDelete = 0 AND co.colorIsDelete = 0 AND co.coStatus = 0";
        $result = $this->connection->query($sqlFindProcID);
        $checkColor = $result->fetch_assoc();
        if ($checkColor != false) {
            $cart = $_SESSION['cart'];
            $maxColor = $checkColor['procQuantity'];
            if (key_exists($proID, $cart) && key_exists($colorID, $cart[$proID])) {
                $num = $_POST['numPro'];
                if ($num > $maxColor) {
                    echo json_encode(array(
                        'status' => '0',
                        'num' => $cart[$proID][$colorID]['numProduct'],
                        'message' => 'The maximum quantity allowed to add to cart is: ' . $maxColor . '.'
                    ));
                    exit();
                } else {
                    $cart[$proID][$colorID] = array(
                        'name' => $cart[$proID][$colorID]['name'],
                        'numProduct' => $num,
                        'price' => $cart[$proID][$colorID]['price'],
                        'image' => $cart[$proID][$colorID]['image'],
                        'color' => $cart[$proID][$colorID]['color'],
                        'procID' => $checkColor['procID']
                    );
                    $_SESSION['cart'][$proID][$colorID] = $cart[$proID][$colorID];
                    echo json_encode(array(
                        'status' => '1',
                        'num' => $cart[$proID][$colorID]['numProduct']
                    ));
                }
            } else {
                echo json_encode(array(
                    'status' => '0',
                    'message' => 'Please check product information.'
                ));
            }
        } else {
            echo json_encode(array(
                'status' => '0',
                'message' => 'Please check product information.'
            ));
        }
    }

    function deleteCart()
    {
        $proID = $_POST['proID'];
        $colorID = $_POST['colorID'];
        $sqlFindProcID = "SELECT pc.procID, co.coColor,pc.procQuantity FROM product_colors pc INNER JOIN colors co ON pc.coID = co.coID WHERE pc.proID = '$proID' AND pc.coID = '$colorID' AND pc.procStatus = 0 AND pc.procIsDelete = 0 AND co.colorIsDelete = 0 AND co.coStatus = 0";
        $result = $this->connection->query($sqlFindProcID);
        $checkColor = $result->fetch_assoc();
        if ($checkColor != false) {
            $cart = $_SESSION['cart'];
            if (key_exists($proID, $cart) && key_exists($colorID, $cart[$proID])) {
                unset($cart[$proID][$colorID]);
                if (empty($cart[$proID])) {
                    unset($cart[$proID]);
                }
                $_SESSION['cart'] = $cart;
                echo json_encode(array(
                    'status' => '1'
                ));
            } else {
                echo json_encode(array(
                    'status' => '0',
                    'message' => 'Please check product information.'
                ));
            }
        } else {
            echo json_encode(array(
                'status' => '0',
                'message' => 'Please check product information.'
            ));
        }
    }

    function removeCart()
    {
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
            echo json_encode(array(
                'status' => '1'
            ));
        } else {
            echo json_encode(array(
                'status' => '0',
                'message' => 'Please check product information.'
            ));
        }

    }

    function getRelatedProducts($id)
    {
        //get10ProductSameCategory
        $sqlGetProduct = "call get10ProductSameCategory($id)";
        $data = array();
        $result = $this->connection->query($sqlGetProduct);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    function getRatingByID($id)
    {
        $sqlGetRating = "call avgRating($id)";
        $result = $this->connection->query($sqlGetRating);
        return $result->fetch_assoc();
    }

    function getColorOfProduct($id)
    {
        $sqlGetColor = "call findColorOfProduct($id)";
        $data = array();
        $result = $this->connection->query($sqlGetColor);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    function getCommentOfProduct($id)
    {
        $sqlGetComment = "call findCommentOfProduct($id)";
        $data = array();
        $result = $this->connection->query($sqlGetComment);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    function getProductInBillDetail($proID, $uID)
    {
        $sqlGetProduct = "call findProductInBillDetail($proID,$uID)";
        $result = $this->connection->query($sqlGetProduct);
        return $productInBill = $result->fetch_assoc();
    }

    function insertComment($data)
    {
        //IN com_Rating smallint, IN com_Content varchar(255), IN pro_ID int, IN u_ID int
        $com_Rating = $data['com_Rating'];
        $com_Content = $data['com_Content'];
        $u_ID = $data['u_ID'];
        $pro_ID = $data['pro_ID'];
        $sqlInsertComment = "INSERT INTO comments(comRating, comContent, proID, uID) ";
        $sqlInsertComment .= "VALUES ('{$com_Rating}', '{$com_Content}', $pro_ID, $u_ID)";
        return $this->connection->query($sqlInsertComment);
    }

    function findCommentOfCustomer($uID, $proID)
    {
        $sqlGetCommentOfCustomer = "call findCommentOfCustomer($uID,$proID)";
        $result = $this->connection->query($sqlGetCommentOfCustomer);
        return $commentOfCustomer = $result->fetch_assoc();
    }

    function searchProduct()
    {
        $func = new DefaultFunction();
        $value = $func->clearString($_POST['search']);
        $sql = "select * from products where proTitle like '%" . $value . "%' and proStatus = 0 and proIsDelete = 0";
        $output = "";
        $result = $this->connection->query($sql);
        while ($row = $result->fetch_assoc()) {
            $output .= '<div class="item">
                                        <div class="img-ser">';
            if ($row['proDiscount'] > 0) {
                $output .= '<div class="on-sale"> Sale </div>';
            }
            if ($row['proDiscount']) {
                $discount = '<span class="price"><small>$</small><span class="line-through">' . $row['proPrice'] . '</span> <small>$</small>' . $row['proDiscount'];
            } else {
                $discount = '<small>$</small>' . $row['proPrice'] . '</span>';
            }
            $output .= '<div class="thumb"> <img class="img-1" src="' . MAIN_URL . 'assets/images/products/' . $row['proImage'] . '" alt=""><img class="img-2" src="' . MAIN_URL . 'assets/images/products/' . $row['proImage'] . '" alt="">
                                                <!-- Overlay  -->
                                                <div class="overlay">
                                                    <div class="add-crt"><a href="?mod=product&act=detail&id=' . $row['proID'] . '"><i class="icon-basket margin-right-10"></i> Add To Cart</a></div>
                                                </div>
                                            </div>

                                            <!-- Item Name -->
                                            <div class="item-name fr-grd"> <a href="?mod=product&act=detail&id=' . $row['proID'] . '" class="i-tittle">' . $row['proTitle'] . '</a>
                                                ' . $discount . '
                                                <a class="deta animated fadeInRight" href="?mod=product&act=detail&id=' . $row['proID'] . '">View Detail</a>
                                            </div>
                                        </div>
                                    </div>';
        }
        if ($output == "") {
            echo "No matches for " . $value;
            die();
        }
        echo $output;
    }

    function discount($code)
    {
        //check code
        $sqlCheckCode = "select * from discounts where disCode = '$code' and disStatus = 0 and disIsDelete = 0";
        $valCode = $this->connection->query($sqlCheckCode);
        $codeDetail = $valCode->fetch_assoc();
        if ($codeDetail && $codeDetail['disCode'] == $code) {
            $current_date = date("Y-m-d H:i:s");
            //var_dump($codeDetail);
            $disID = $codeDetail['disID'];
            $uID = $_SESSION['user']['uID'];
            $sqlCheckLogDiscount = "select count(logdis_ID) as countID from log_discount where disID = '$disID' and uID = '$uID'";
            $logDis = $this->connection->query($sqlCheckLogDiscount);
            $logDisDetail = $logDis->fetch_assoc();
            if ($logDisDetail && $logDisDetail['countID'] == 0) {
                $countCode = ($codeDetail['disAmount'] - $codeDetail['disUsed']);
                if (strtotime($codeDetail['disStart']) <= strtotime($current_date) && strtotime($current_date) <= strtotime($codeDetail['disEnd']) && $countCode > 0) {
                    $total = 0;
                    foreach ($_SESSION['cart'] as $proID => $product) {
                        foreach ($product as $key => $pro) {
                            $total = $total + $pro['price'] * $pro['numProduct'];
                        }
                    }
                    if ($total > 1000) {
                        $shipping = 0;
                    } else {
                        $shipping = 30;
                    }
                    $vat = (int)$total * 0.1;
                    $discountValue = (int)$total * ($codeDetail['disValue'] / 100);
                    $currentPrice = $total + $shipping + $vat;
                    $priceAfterDiscount = (int)$currentPrice - $discountValue;
                    //$_SESSION['discount']
                    echo json_encode(array(
                            'status' => '0',
                            'discountValue' => $discountValue,
                            'priceAfterDiscount' => $priceAfterDiscount,
                            'message' => "Successfully applied discount code.")
                    );
                } elseif (strtotime($current_date) >= strtotime($codeDetail['disEnd'])) {
                    echo json_encode(array('status' => '1', 'message' => "The discount code has expired."));
                } elseif ($countCode <= 0) {
                    echo json_encode(array('status' => '1', 'message' => "The number of discount codes has expired."));
                } else {
                    echo json_encode(array('status' => '1', 'message' => "Discount code applied failed. Please check again."));
                }
            } else {
                echo json_encode(array('status' => '1', 'message' => "You have used this discount code."));
            }
        } else {
            echo json_encode(array('status' => '1', 'message' => "This discount code does not exist."));
        }
    }
}