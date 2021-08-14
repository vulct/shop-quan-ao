<?php
require_once('./mvc/core/Controllers.php');
session_start();

/**
 *
 */
class App extends Controllers
{
    protected $mod;
    protected $act;

    public function __construct()
    {
        //mod=product&act=edit&id=1
        //$model = isset($_GET['mod']) ? $_GET['mod'] : '';
        //$action = isset($_GET['act']) ? $_GET['act'] : '';
        $arrQueryString = explode('&', $_SERVER['QUERY_STRING']);
        foreach ($arrQueryString as $param) {
            $arrParam[] = explode('=', $param);
        }

        if ($arrParam) {
            $model = isset($arrParam[0][1]) ? $arrParam[0][1] : '';
            $action = isset($arrParam[1][1]) ? $arrParam[1][1] : '';
        } else {
            $model = '';
            $action = '';
        }

        $this->mod = $this->clearString($model);
        $this->act = $this->clearString($action);
    }

    public function action()
    {
        switch ($this->mod) {
            case 'index':
            case '':
                $this->checkUser();
                $controller_obj = $this->controller('HomeController');
                switch ($this->act) {
                    case '':
                        $controller_obj->home();
                        break;
                }
                break;
            case 'log':
                $this->checkUser();
                $controller_obj = $this->controller('HistoryController');
                switch ($this->act) {
                    case '':
                    case 'general':
                        $controller_obj->logGeneral();
                        break;
                    case 'order':
                        $controller_obj->logBuyProduct();
                        break;
                    case 'coupon':
                        $controller_obj->logCoupon();
                        break;
                    case 'customer':
                        $controller_obj->logCustomer();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'product':
                $this->checkUser();
                $controller_obj = $this->controller('ProductController');
                switch ($this->act) {
                    case '':
                    case 'list':
                        $controller_obj->listProduct();
                        break;
                    case 'detail':
                        $id = $this->clearString(isset($_GET['id']) ? $_GET['id'] : 0);
                        $controller_obj->detailProduct($id);
                        break;
                    case 'add':
                        $controller_obj->addProduct();
                        break;
                    case 'add_action':
                        $controller_obj->addProductAction();
                        break;
                    case 'delete':
                        $id = $this->clearString(isset($_POST['proID']) ? $_POST['proID'] : 0);
                        $controller_obj->deleteProduct($id);
                        break;
                    case 'edit':
                        $id = $this->clearString(isset($_GET['id']) ? $_GET['id'] : 0);
                        $controller_obj->editProduct($id);
                        break;
                    case 'edit_action':
                        $controller_obj->editProductAction();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'category':
                $this->checkUser();
                $controller_obj = $this->controller('CategoryController');
                switch ($this->act) {
                    case '':
                    case 'list':
                        $controller_obj->listCategory();
                        break;
                    case 'delete':
                        $id = $this->clearString(isset($_POST['cateID']) ? $_POST['cateID'] : 0);
                        $controller_obj->deleteCategory($id);
                        break;
                    case 'add':
                        $controller_obj->addCategory();
                        break;
                    case 'add_action':
                        $controller_obj->addCategoryAction();
                        break;
                    case 'edit':
                        $cateID = $this->clearString(isset($_POST['id_category']) ? $_POST['id_category'] : 0);
                        $nameCategory = $this->clearString($_POST['name_category']);
                        $statusCategory = (isset($_POST['status_category']) && $_POST['status_category'] == "on") ? 0 : 1;;
                        $controller_obj->editCategory($cateID, $nameCategory, $statusCategory);
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'color':
                $this->checkUser();
                $controller_obj = $this->controller('ColorController');
                switch ($this->act) {
                    case '':
                    case 'list':
                        $controller_obj->listColor();
                        break;
                    case 'delete':
                        $id = $this->clearString(isset($_POST['colorID']) ? $_POST['colorID'] : 0);
                        $controller_obj->deleteColor($id);
                        break;
                    case 'add':
                        $controller_obj->addColor();
                        break;
                    case 'add_action':
                        $controller_obj->addColorAction();
                        break;
                    case 'edit':
                        $id = $this->clearString(isset($_GET['id']) ? $_GET['id'] : 0);
                        $controller_obj->editColor($id);
                        break;
                    case 'edit_action':
                        $controller_obj->editColorAction();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'customer':
                $this->checkUser();
                $controller_obj = $this->controller('CustomerController');
                switch ($this->act) {
                    case '':
                    case 'list':
                        $controller_obj->listCustomer();
                        break;
                    case 'delete':
                        $id = $this->clearString(isset($_POST['uID']) ? $_POST['uID'] : 0);
                        $controller_obj->deleteCustomer($id);
                        break;
                    case 'add':
                        $controller_obj->addCustomer();
                        break;
                    case 'add_action':
                        $controller_obj->addCustomerAction();
                        break;
                    case 'edit':
                        $id = $this->clearString(isset($_GET['id']) ? $_GET['id'] : 0);
                        $controller_obj->editCustomer($id);
                        break;
                    case 'edit_action':
                        $controller_obj->editCustomerAction();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'bill':
                $this->checkUser();
                $controller_obj = $this->controller('InvoiceController');
                switch ($this->act) {
                    case '':
                    case 'list':
                        $controller_obj->listInvoice();
                        break;
                    case 'detail':
                        $controller_obj->detailInvoice();
                        break;
                    case 'update':
                        $controller_obj->updateStatus();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'feedback':
                $this->checkUser();
                $controller_obj = $this->controller('FeedbackController');
                switch ($this->act) {
                    case '':
                    case 'list':
                        $controller_obj->listFeedback();
                        break;
                    case 'update':
                        $controller_obj->updateStatusFB();
                        break;
                    case 'delete':
                        $controller_obj->deleteFB();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'payment':
                $this->checkUser();
                $controller_obj = $this->controller('PaymentController');
                switch ($this->act) {
                    case '':
                    case 'list':
                        $controller_obj->listPayment();
                        break;
                    case 'update':
                        $controller_obj->updatePayment();
                        break;
                    case 'add':
                        $controller_obj->addPayment();
                        break;
                    case 'add_action':
                        $controller_obj->addPaymentAction();
                        break;
                    case 'delete':
                        $controller_obj->deletePayment();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'coupon':
                $this->checkUser();
                $controller_obj = $this->controller('CouponController');
                switch ($this->act) {
                    case '':
                    case 'list':
                        $controller_obj->listCoupon();
                        break;
                    case 'add':
                        $controller_obj->addCoupon();
                        break;
                    case 'add_action':
                        $controller_obj->addCouponAction();
                        break;
                    case 'delete':
                        $controller_obj->deleteCoupon();
                        break;
                    case 'edit':
                        $id = $this->clearString(isset($_GET['id']) ? $_GET['id'] : 0);
                        $controller_obj->editCoupon($id);
                        break;
                    case 'edit_action':
                        $controller_obj->editCouponAction();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'login':
                $this->checkLogin();
                $controller_obj = $this->controller('CustomerController');
                switch ($this->act) {
                    case '':
                    case 'login':
                        $controller_obj->view_login();
                        break;
                    case 'act_login':
                        $data['username'] = isset($_POST['username']) ? $_POST['username'] : '';
                        $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';
                        $controller_obj->login($data);
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'logout':
                $controller_obj = $this->controller('CustomerController');
                switch ($this->act) {
                    case '':
                    case 'out':
                        $controller_obj->logout();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            default:
                header("Location: ./404.php");
                break;
        }
    }

    public function checkLogin()
    {
        if (isset($_SESSION['admin'])) {
            header("Location: ?mod=index");
        }
    }

    public function checkUser()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: ?mod=login");
        }
    }

    public function clearString($string)
    {
        return str_replace(array('<', "'", '>', '?', '/', "\\", '--', 'eval(', '<php'), array('', '', '', '', '', '', '', '', ''), htmlspecialchars(addslashes(strip_tags($string))));
    }
}

