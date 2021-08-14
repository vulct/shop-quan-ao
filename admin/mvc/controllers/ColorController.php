<?php


class ColorController extends controllers
{
    protected $color;

    public function listColor(){
        $this->color = $this->models('Color');
        $dataViews = [
            'views'=>'colors/list',
            'color'=>$this->color->getAllColor()
        ];
        $this->views('layouts/master',$dataViews);
    }

    public function deleteColor($id){

        $this->color = $this->models('Color');
        $this->color->deleteColor($id);
    }

    public function editColor($id){
        $cssFile = array(
            'public/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css'
        );
        $dataViews = [
            'views'=>'colors/edit',
            'color'=>$this->models('Color')->getDetailColor($id)
        ];
        $this->views('layouts/master',$dataViews,$cssFile);
    }

    public function editColorAction(){
        $data = $_POST;
        $this->color = $this->models('Color');
        $this->color->editColorAction($data);
    }

    public function addColor(){
        $cssFile = array(
            'public/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css'
        );
        $dataViews = [
            'views'=>'colors/add'
        ];
        $this->views('layouts/master',$dataViews,$cssFile);
    }

    public function addColorAction(){
        $data = $_POST;
        $this->color = $this->models('Color')->addColorAction($data);
    }
}