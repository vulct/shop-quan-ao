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
        $model = isset($_GET['mod']) ? $_GET['mod'] : '';
        $action = isset($_GET['act']) ? $_GET['act'] : '';
        $this->mod = strtolower(htmlspecialchars($model));
        $this->act = strtolower(htmlspecialchars($action));
    }

    public function action()
    {
        switch ($this->mod) {
            case 'index':
            case '':
                $controller_obj = $this->controller('HomeController');
                switch ($this->act) {
                    case '':
                        $controller_obj->home();
                        break;
                }
                break;
            case 'product':
                $controller_obj = $this->controller('ProductController');
                switch ($this->act) {
                    case '':
                    case 'detail':
                        $controller_obj->productDetail();
                        break;
                    case 'comment':
                        $controller_obj->comment();
                        break;
                    case 'add_cart':
                        $controller_obj->add_cart();
                        break;
                    case 'error_product':
                        $controller_obj->error_product();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'cart':
                $this->checkCustomer();
                $controller_obj = $this->controller('CustomerController');
                switch ($this->act) {
                    case 'show_cart':
                    case '':
                        $controller_obj->show_cart();
                        break;
                    case 'update':
                        $controller_obj->update_cart();
                        break;
                    case 'delete':
                        $controller_obj->delete_cart();
                        break;
                    case 'remove':
                        $controller_obj->remove_cart();
                        break;
                    case 'discount':
                        $controller_obj->discount();
                        break;
                    case 'checkout':
                        $controller_obj->checkout();
                        break;
                    case 'order':
                        $controller_obj->order();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'about':
                $controller_obj = $this->controller('HomeController');
                switch ($this->act) {
                    case '':
                    case 'view':
                        $controller_obj->view_about();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'contact':
                $controller_obj = $this->controller('HomeController');
                switch ($this->act) {
                    case '':
                    case 'view':
                        $controller_obj->view_contact();
                        break;
                    case 'submit':
                        $controller_obj->submit();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'profile':
                $this->checkCustomer();
                $controller_obj = $this->controller('CustomerController');
                switch ($this->act) {
                    case '':
                    case 'edit':
                        $controller_obj->edit();
                        break;
                    case 'update':
                        $controller_obj->update();
                        break;
                    case 'change':
                        $controller_obj->change();
                        break;
                    case 'bill':
                        $id = htmlspecialchars($_GET['id']);
                        $controller_obj->bill($id);
                        break;
                    case 'cancel':
                        $id = htmlspecialchars($_GET['id']);
                        $controller_obj->cancel_bill($id);
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'shop':
                $controller_obj = $this->controller('ProductController');
                switch ($this->act) {
                    case '':
                    case 'view':
                        $controller_obj->view_product();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'search':
                $controller_obj = $this->controller('ProductController');
                switch ($this->act) {
                    case '':
                    case 'view':
                        $controller_obj->view_search();
                        break;
                    case 'get':
                        $controller_obj->getValueSearch();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'login':
                $this->CheckLogin();
                $controller_obj = $this->controller('CustomerController');
                switch ($this->act) {
                    case '':
                    case 'login':
                        $controller_obj->view_login();
                        break;
                    case 'act_login':
                        $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';
                        $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';
                        $controller_obj->login($data);
                        break;
                    case 'register':
                        $controller_obj->register();
                        break;
                    case 'otp':
                        $controller_obj->getOTP();
                        break;
                    case 'show_submit_otp':
                        $controller_obj->showOTP();
                        break;
                    case 'submit_otp':
                        $controller_obj->submitOTP();
                        break;
                    default:
                        header("Location: ./404.php");
                        break;
                }
                break;
            case 'forget':
                $controller_obj = $this->controller('CustomerController');
                switch ($this->act) {
                    case '':
                    case 'forget':
                        $controller_obj->forgetPassword();
                        break;
                    case 'get':
                        $controller_obj->getPassword();
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
                }
                break;
            default:
                header("Location: ./404.php");
                break;
        }
    }


    public function CheckLogin()
    {
        if (isset($_SESSION['user'])) {
            header("Location: ?mod=index");
        }
    }
    public function checkCustomer(){
        if (!isset($_SESSION['user'])){
            setcookie("login_check","First, sign in to your account. If you do not have an account please register.", time() + 30);
            header("Location: ?mod=login");
        }
    }

}

?>