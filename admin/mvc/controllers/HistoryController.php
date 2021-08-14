<?php


class HistoryController  extends controllers
{
    protected $historyOrder;
    protected $historyCoupon;
    protected $logGeneral;
    protected $logCustomer;

    public function logBuyProduct(){
        $this->historyOrder = $this->models('History');
        $dataViews = [
            'views'=>'logs/logInvoice',
            'logInvoice'=>$this->historyOrder->historyOrder()
        ];
        $this->views('layouts/master',$dataViews);
    }

    public function logCoupon(){
        $this->historyCoupon = $this->models('History');
        $dataViews = [
            'views'=>'logs/logUsed',
            'logUsed'=>$this->historyCoupon->historyCoupon()
        ];
        $this->views('layouts/master',$dataViews);
    }

    public function logGeneral(){
        $this->logGeneral = $this->models('History');
        $dataViews = [
            'views'=>'logs/logAdmin',
            'logGeneral'=>$this->logGeneral->logGeneral()
        ];
        $this->views('layouts/master',$dataViews);
    }

    public function logCustomer(){
        $this->logCustomer = $this->models('History');
        $dataViews = [
            'views'=>'logs/logCustomer',
            'logCustomer'=>$this->logCustomer->logCustomer()
        ];
        $this->views('layouts/master',$dataViews);
    }

}