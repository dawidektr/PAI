<?php

class App{
    
    public static $link = "/";
    
    protected $controller = 'defaultController';
    protected $method = 'index';
    protected $params = 'defaultController';
    
    public function __construct(){
        
        $url = $this->parseUrl();

        if(file_exists('controllers/'.$url[0].'Controller.php')){
            $this->controller = $url[0].'Controller';
            unset($url[0]);
        }
        require_once 'controllers/'.$this->controller.'.php';
        $this->controller = new $this->controller;

        if(isset($url[1])){
            if(method_exists($this->controller, $url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }else{
                $this->controller->redirect('/');
            }
        }

        $this->params = $url? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    
    public function parseUrl(){
        if(isset($_GET['url'])){
            return explode('/', filter_var(rtrim($_GET['url'],'/'), FILTER_SANITIZE_URL));
        }
    }
}