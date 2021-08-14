<?php


class CategoryController extends controllers
{
    protected $cate;

    public function listCategory(){
        $this->cate = $this->models('Category');
        $dataViews = [
            'views'=>'categories/list',
            'cate'=>$this->cate->getAllCate()
        ];
        $this->views('layouts/master',$dataViews);
    }

    public function deleteCategory($id){
        $this->cate = $this->models('Category');
        $this->cate->deleteCategory($id);
    }

    public function addCategory(){
        $cssFile = array(
            'public/assets/plugins/bootstrap-select/css/bootstrap-select.css'
        );
        $dataViews = [
            'views'=>'categories/add'
        ];
        $this->views('layouts/master',$dataViews,$cssFile);
    }

    public function addCategoryAction(){
        $data = $_POST;
        $this->cate = $this->models('Category');
        $this->cate->addCategoryAction($data);
    }

    public function editCategory($cateID,$nameCategory,$statusCategory){
        $this->cate = $this->models('Category');
        $this->cate->editCategory($cateID,$nameCategory,$statusCategory);
    }
}