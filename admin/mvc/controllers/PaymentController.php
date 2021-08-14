<?php


class PaymentController extends controllers
{
    protected $payment;

    public function listPayment()
    {
        $this->payment = $this->models('Payment');
        $dataViews = [
            'views' => 'payments/list',
            'payment' => $this->payment->listPayment()
        ];
        $this->views('layouts/master', $dataViews);
    }

    public function addPayment()
    {
        $this->payment = $this->models('Payment');
        $dataViews = [
            'views' => 'payments/add'
        ];
        $this->views('layouts/master', $dataViews);
    }

    public function addPaymentAction(){
        $data = $_POST;
        $this->payment = $this->models('Payment')->addPaymentAction($data);
    }

    public function updatePayment()
    {
        $data = $_POST;
        $this->payment = $this->models('Payment')->updatePayment($data);
    }

    public function deletePayment()
    {
        $id = $_POST['payID'];
        $this->payment = $this->models("Payment")->deletePayment($id);
    }
}