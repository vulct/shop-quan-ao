<?php


class ProductController extends controllers
{
    protected $product;
    protected $cate;
    protected $color;
    protected $comment;
    protected $productInBill;
    protected $commentOfCustomer;
    protected $rating;
    protected $relatedProducts;

    public function productDetail()
    {
        $id = (isset($_GET['id']) ? $_GET['id'] : 1);
        $uID = (isset($_SESSION['user']['uID']) ? $_SESSION['user']['uID'] : "");
        $this->product = $this->models('Product');
        $this->color = $this->models('Product');
        $this->cate = $this->models('Category');
        $this->comment = $this->models('Product');
        $this->productInBill = $this->models('Product');
        $this->commentOfCustomer = $this->models('Product');
        $this->rating = $this->models('Product');
        $this->relatedProducts = $this->models('Product');
        if ($uID == "") {
            $dataViews = [
                'views' => 'products/detail',
                'pro' => $this->product->showProduct($id),
                'rating' => $this->rating->getRatingByID($id),
                'cate' => $this->cate->getCateByID($id),
                'color' => $this->color->getColorOfProduct($id),
                'comment' => $this->comment->getCommentOfProduct($id),
                'relate' => $this->relatedProducts->getRelatedProducts($id)
            ];
        } else if ($uID != "") {
            $dataViews = [
                'views' => 'products/detail',
                'productInBill' => $this->productInBill->getProductInBillDetail($id, $uID),
                'commentOfCustomer' => $this->commentOfCustomer->findCommentOfCustomer($uID, $id),
                'pro' => $this->product->showProduct($id),
                'rating' => $this->rating->getRatingByID($id),
                'cate' => $this->cate->getCateByID($id),
                'color' => $this->color->getColorOfProduct($id),
                'comment' => $this->comment->getCommentOfProduct($id),
                'relate' => $this->relatedProducts->getRelatedProducts($id)
            ];
        }
        $this->views('layouts/master', $dataViews);
    }

    public function view_product()
    {
        $this->product = $this->models('Product');
        $this->cate = $this->models('Category');

        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        if (isset($_GET['cate'])) {
            $id = $_GET['cate'];
            $dataViews = [
                'views' => 'products/shop',
                'product' => $this->product->getProductByCate($current_page, $id),
                'cate' => $this->cate->getAllCate()
            ];
        } else {
            $dataViews = [
                'views' => 'products/shop',
                'product' => $this->product->getAllProduct($current_page),
                'cate' => $this->cate->getAllCate()
            ];
        }
        $this->views('layouts/master', $dataViews);
    }

    public function error_product()
    {
        $dataViews = [
            'views' => 'products/error_product'];
        $this->views('layouts/master', $dataViews);
    }

    public function view_search()
    {
        $dataViews = [
            'views' => 'products/view_search'];
        $this->views('layouts/master', $dataViews);
    }

    public function getValueSearch()
    {
        $this->models('Product')->searchProduct();
    }
    
    public function comment()
    {
        $this->comment = $this->models('Product');
        $this->commentOfCustomer = $this->models('Product');

        $data = array();
        $data['com_Rating'] = isset($_POST['comRating']) ? $_POST['comRating'] : 0;
        $data['com_Content'] = isset($_POST['comContent']) ? $_POST['comContent'] : "";
        $data['u_ID'] = $_SESSION['user']['uID'];
        $data['pro_ID'] = $_POST['proID'];

        $statusCommentOfCustomer = $this->commentOfCustomer->findCommentOfCustomer($data['u_ID'], $data['pro_ID']);

        if ($statusCommentOfCustomer == null) {
            $status = $this->comment->insertComment($data);
            if ($status) {

                $mess_done = "<script>swal.fire(\"Review done!\", \"Thank you for rating our product.\",\"success\")</script>";
                setcookie("notification_comment", $mess_done, time() + 10);
            } else {
                $mess_error = "<script>swal.fire(\"Review error!\", \"Please review the rating information.\",\"error\")</script>";
                setcookie("notification_comment", $mess_error, time() + 10);
            }
        } else {
            $mess_error = "<script>swal.fire(\"Review error!\", \"Please review the rating information.\",\"error\")</script>";
            setcookie("notification_comment", $mess_error, time() + 10);
        }
        $location = "?mod=product&act=detail&id=" . $data['pro_ID'];
        header("Location: $location");

    }

    public function add_cart()
    {
        $this->product = $this->models('Product');
        $data = array();
        $data['proID'] = $_POST['proID'];
        $lengthColor = strpos($_POST['valueColor'], "-");
        $lengthString = strlen($_POST['valueColor']);
        $valueColor = substr($_POST['valueColor'], $lengthColor + 1, $lengthString);
        $maxColor = substr($_POST['valueColor'], 0, $lengthColor);
        $data['valueColor'] = $valueColor;
        $data['numProduct'] = $_POST['numProduct'];
        $data['maxColor'] = $maxColor;
        $this->product->getProductCart($data);
    }

    public function checkUser()
    {
        if (!isset($_SESSION['user'])) {
            setcookie("login_check", "First, sign in to your account. If you do not have an account please register.", time() + 30);
            header("Location: ?mod=login");
            return false;
        } else {
            return true;
        }
    }


}