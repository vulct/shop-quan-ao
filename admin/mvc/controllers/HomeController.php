<?php


class HomeController extends controllers
{
    protected $bill;
    protected $comment;
    protected $sumBill;
    protected $countBill;
    protected $countUser;

    public function home()
    {

        $this->bill = $this->models('Home');
        $this->comment = $this->models('Home');
        $this->sumBill = $this->models('Home');
        $this->countBill = $this->models('Home');
        $this->countUser = $this->models('Home');
        $dataViews = [
            'views'=>'home',
            'bill'=>$this->bill->getRecentOrders(),
            'comment'=>$this->comment->getComment(),
            'sumBill'=>$this->sumBill->getSumBill(),
            'countBill'=>$this->countBill->getCountBill(),
            'countUser'=>$this->countUser->countUser(),
        ];
        $this->views('layouts/master',$dataViews);
    }

}