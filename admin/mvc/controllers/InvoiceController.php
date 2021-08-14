<?php


class InvoiceController extends controllers
{
    protected $invoice;

    public function listInvoice(){
        $this->invoice = $this->models('Invoice');

        $dataViews = [
            'views'=>'invoices/list',
            'invoice'=>$this->invoice->listInvoice()
        ];

        $this->views('layouts/master',$dataViews);
    }

    public function updateStatus(){
        $data = $_POST;
        $this->invoice = $this->models("Invoice")->updateStatus($data);
    }

    public function detailInvoice()
    {
        $id = htmlspecialchars($_GET['id']);
        $this->invoice = $this->models('Invoice');
        $dataViews = [
            'views' => 'invoices/detail',
            'bill' => $this->invoice->getBillDetail($id)
        ];
        $this->views('layouts/master', $dataViews);
    }
}