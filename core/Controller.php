<?php

class Controller{
    
    public function model($model){
        require_once 'models/'.$model.'.php';
        return new $model();
    }
    
    public function view($view, $data = []){
        require_once 'view/'.$view.'.php';
    }
    
    public function partial($part, $message=""){
        require_once 'view/partial/'.$part.'.php';
    }
    
    public function redirect($url){
        header('location: '.$url);
    }
}