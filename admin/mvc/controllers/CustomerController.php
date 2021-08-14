<?php


class CustomerController extends controllers
{

    protected $profile;
    protected $customer;

    public function view_login()
    {
        require_once("./mvc/views/auth/login.php");
    }

    public function login($data){
        $user = $this->models('Customer')->login($data);
        if ($user){
            $_SESSION['admin'] = $user;
            echo json_encode(array('status'=>1));
        } else {
            echo json_encode(array('status'=>0,'mess'=>'Đăng nhập không thành công, vui lòng kiểm tra lại thông tin.'));
        }
    }

    public function logout()
    {
        unset($_SESSION['admin']);
        header("Location: ?mod=login");
    }

    public function listCustomer(){
        $cssFile = array(
            'public/assets/plugins/bootstrap-select/css/bootstrap-select.css'
        );
        $this->customer = $this->models("Customer");
        $dataViews = [
            'customer'=>$this->customer->getAllCustomer(),
            'views'=>'customers/list'
        ];
        $this->views('layouts/master',$dataViews,$cssFile);
    }

    public function deleteCustomer($id){
        $this->customer = $this->models('Customer');
        $this->customer->deleteCustomer($id);
    }

    public function editCustomer($id){
        $cssFile = array(
            'public/assets/plugins/bootstrap-select/css/bootstrap-select.css'
        );
        $this->customer = $this->models('Customer');
        $dataViews = [
            'views'=>'customers/edit',
            'customer'=>$this->customer->getDetailCustomer($id)
        ];
        $this->views('layouts/master',$dataViews,$cssFile);
    }

    public function editCustomerAction(){
        $data = $_POST;
        $this->customer = $this->models('Customer');
        $this->customer->editCustomerAction($data);
    }

    public function addCustomer()
    {
        $cssFile = array(
            'public/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css'
        );
        $this->customer = $this->models('Customer');
        $dataViews = [
            'views' => 'customers/add'
        ];
        $this->views('layouts/master', $dataViews,$cssFile);
    }

    public function addCustomerAction(){
        $data = $_POST;
        $this->customer = $this->models('Customer')->addCustomerAction($data);
    }
}