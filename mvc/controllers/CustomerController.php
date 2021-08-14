<?php

class CustomerController extends controllers
{

    protected $profile;
    protected $history;
    protected $product;
    protected $payment;

    public function view_login()
    {
        $dataViews = [
            'views' => 'auth/login'
        ];
        $this->views('layouts/master', $dataViews);
    }

    public function showOTP()
    {
        $dataViews = [
            'views' => 'auth/otp'
        ];
        $this->views('layouts/master', $dataViews);
    }

    public function getOTP()
    {
        $this->models('Customer')->getOTP();
    }

    public function login($data)
    {
       $this->models('Customer')->login($data);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header("Location: ?mod=login");
    }

    public function edit()
    {
        $this->profile = $this->models('Customer');
        $this->history = $this->models('Customer');
        $id = $_SESSION['user']['uID'];
        $dataViews = [
            'views' => 'auth/profile',
            'profile' => $this->profile->getInfo($id),
            'history' => $this->history->getHistory($id)

        ];
        $this->views('layouts/master', $dataViews);
    }

    public function update()
    {
        $this->profile = $this->models('Customer');
        $data = $_POST;
        $this->profile->updateInfoUser($data);
    }

    public function change()
    {
        $this->profile = $this->models('Customer');
        $data = array();
        $data['id'] = $_SESSION['user']['uID'];
        $data['currentPassword'] = md5($_POST['currentPassword']);
        $data['newPassword'] = md5($_POST['newPassword']);
        $data['confirmPassword'] = md5($_POST['confirmPassword']);
        $status = $this->profile->changePassword($data);
        if ($status) {
            $this->models('Customer')->addLog("Khách hàng " . $_SESSION['user']['uFirstName'] . " " . $_SESSION['user']['uLastName'], ' đổi mật khẩu thành công!');
        } else {
            if (isset($mess)) {
                setcookie("error_change_password", $mess, time() + 5);
            }
        }
    }

    public function submitOTP()
    {
        $this->profile = $this->models('Customer')->submitOTP();
    }

    public function register()
    {
        $this->profile = $this->models("Customer");
        $data = array();
        $data['firstName'] = $_POST['firstname'];
        $data['lastName'] = $_POST['lastname'];
        $data['email'] = $_POST['email'];
        $data['phone'] = $_POST['phone'];
        $data['password'] = md5($_POST['password']);
        $this->profile->registerUser($data);
    }

    public function show_cart()
    {
        $this->profile = $this->models('Customer');
        $dataViews = [
            'views' => 'shopping/cart'
        ];
        $this->views('layouts/master', $dataViews);
    }

    public function update_cart()
    {
        $this->product = $this->models("Product");
        $this->product->updateCart();
    }

    public function delete_cart()
    {
        $this->product = $this->models("Product");
        $this->product->deleteCart();
    }

    public function remove_cart()
    {
        $this->product = $this->models("Product");
        $this->product->removeCart();
    }

    public function discount()
    {
        $codeDiscount = strtolower(htmlspecialchars($_POST['code']));
        $this->product = $this->models("Product");
        $this->product->discount($codeDiscount);
    }

    public function checkout()
    {
        $this->profile = $this->models('Customer');
        $this->payment = $this->models('Customer');
        $id = $_SESSION['user']['uID'];
        $dataViews = [
            'views' => 'shopping/checkout',
            'payment' => $this->payment->getPayment(),
            'profile' => $this->profile->getInfo($id)
        ];
        $this->views('layouts/master', $dataViews);
    }

    public function order()
    {
        $this->profile = $this->models("Customer");
        $this->profile->order($_POST);
    }

    public function cancel_bill($id)
    {
        $this->models("Customer")->cancel_bill($id);
    }

    public function bill($id)
    {
        $this->profile = $this->models('Customer');
        $uID = $_SESSION['user']['uID'];
        $dataViews = [
            'views' => 'shopping/detail_bill',
            'bill' => $this->profile->getBillDetail($id, $uID)
        ];
        $this->views('layouts/master', $dataViews);
    }

    function forgetPassword()
    {
        $dataViews = [
            'views' => 'auth/forget'
        ];
        $this->views('layouts/master', $dataViews);
    }

    function getPassword()
    {
        $email = strtolower(htmlspecialchars($_POST['email']));
        $this->profile = $this->models("Customer");
        $this->profile->generatePassword($email);
    }
}