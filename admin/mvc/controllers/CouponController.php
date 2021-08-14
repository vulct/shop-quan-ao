<?php


class CouponController extends controllers
{
    protected $coupon;

    public function listCoupon()
    {
        $this->coupon = $this->models('Coupon');
        $dataViews = [
            'views' => 'coupons/list',
            'coupon' => $this->coupon->listCoupon()
        ];
        $this->views('layouts/master', $dataViews);
    }

    public function editCoupon($id){
        $cssFile = array(
            'public/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css'
        );
        $this->coupon = $this->models('Coupon');
        $dataViews = [
            'views'=>'coupons/edit',
            'coupon'=>$this->coupon->getDetailCoupon($id)
        ];
        $this->views('layouts/master',$dataViews,$cssFile);
    }

    public function editCouponAction(){
        $data = $_POST;
        $this->coupon = $this->models('Coupon');
        $this->coupon->editCouponAction($data);
    }

    public function deleteCoupon()
    {
        $id = $_POST['couponID'];
        $this->coupon = $this->models("Coupon")->deleteCoupon($id);
    }

    public function addCoupon()
    {
        $cssFile = array(
            'public/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css'
        );
        $this->coupon = $this->models('Coupon');
        $dataViews = [
            'views' => 'coupons/add'
        ];
        $this->views('layouts/master', $dataViews,$cssFile);
    }

    public function addCouponAction(){
        $data = $_POST;
        $this->coupon = $this->models('Coupon')->addCouponAction($data);
    }
}