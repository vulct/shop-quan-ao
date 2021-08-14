<?php


class ProductController extends controllers
{
    protected $product;
    protected $color;
    protected $comment;
    protected $rate;
    protected $cate;
    protected $list_color;

    public function listProduct(){
        $this->product = $this->models('Product');

        $dataViews = [
            'views'=>'products/list',
            'product'=>$this->product->listProduct()
        ];

        $this->views('layouts/master',$dataViews);
    }

    public function detailProduct($id){
        $this->product = $this->models('Product');
        $this->color = $this->models('Product');
        $this->comment = $this->models('Product');
        $this->rate = $this->models('Product');
        $dataViews = [
            'views'=>'products/detail',
            'product'=>$this->product->detailProduct($id),
            'color'=>$this->color->getColorOfProduct($id),
            'comment'=>$this->comment->getCommentOfProduct($id),
            'rate'=>$this->rate->getRatingByID($id)
        ];

        $this->views('layouts/master',$dataViews);
    }

    public function addProduct(){
        $cssFile = array(
            'public/assets/plugins/bootstrap-select/css/bootstrap-select.css'
        );
        $this->cate = $this->models('Category');
        $this->color = $this->models('Color');
        $dataViews = [
            'views'=>'products/add',
            'cate'=>$this->cate->getAllCate(),
            'color'=>$this->color->getAllColor()
        ];
        $this->views('layouts/master',$dataViews,$cssFile);
    }

    public function addProductAction(){
        $data = $_POST;
        $file = $_FILES;
        $this->product = $this->models('Product');
        $this->product->addProductAction($data,$file);
    }

    public function deleteProduct($id){
        $this->product = $this->models('Product');
        $this->product->deleteProduct($id);
    }

    public function editProduct($id){
        $this->cate = $this->models('Category');
        $this->list_color = $this->models('Color');
        $this->color = $this->models('Product');
        $this->product = $this->models('Product');
        $dataViews = [
            'views'=>'products/edit',
            'product'=>$this->product->detailProduct($id),
            'color'=>$this->color->getColorOfProduct($id),
            'cate'=>$this->cate->getAllCate(),
            'list_color'=>$this->list_color->getAllColor()
        ];
        $this->views('layouts/master',$dataViews);
    }

    public function editProductAction(){
        $data = $_POST;
        $file = $_FILES;
        $this->product = $this->models('Product');
        $this->product->editProductAction($data,$file);
    }
}