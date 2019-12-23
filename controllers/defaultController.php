<?php

class DefaultController extends Controller{
    
    public function index(){
        $this->partial('header');
        $this->partial('navbar');
        //$this->partial('slider');
        
       // $this->partial('aboutme');
        
        
        $model = $this->model('shop');
        
        $resultArray = $model->getAllShopElement();
        
        $html = $model->genHTML($resultArray);
        echo $html;
        
        
        $this->partial('footer');
    } 

    
    


}



