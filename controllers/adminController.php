<?php

session_start();

class AdminController extends Controller{
    
    public function index(){
        if(!isset($_SESSION['logged']) || $_SESSION['logged'] == false){
            $_SESSION['logged'] = false;
        }
        
        if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
            $this->showAdminPanel();
        }else{
            $this->showLoginPanel();
        }
    }


    private function showLoginPanel(){
        
        $this->partial('header');
        $this->partial('navbar');
        
        $this->partial('loginForm');
       

        
        $this->partial('footer');
    }

    public function showRegisterPanel(){


        if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
            $this->showAdminPanel();
        }else{
            $this->partial('header');
            $this->partial('navbar');
            
           
            $this->partial('registerForm');
    
            
            $this->partial('footer');;
        }


        
        
    }



    public function register() {
        if (!isset($_POST) || empty($_POST)){
            $this->redirect("/admin/showRegisterPanel");
            die();
        }else {
            $model = $this->model('admin');
            if ($model->register($_POST)){
                $this->redirect("/");
            }else {
                $this->redirect("/admin/showRegisterPanel");
            }
        }
    }







    
    private function showAdminPanel(){
        
        $this->partial('header');
        $this->partial('logNavbar');
        
        if($_SESSION['id_role']==1){
         $this->partial('adminPanel');
       // $this->view('users');
        $model = $this->model('admin');
        $table = $model->generateCRUD();
        echo $table;
        }
        else{
            $this->partial('adminPanel');
            $model = $this->model('admin');
            $table = $model->generateCRUD();
            echo $table;
        }

        $this->partial('footer');
    }

    public function showUsers(){
        $this->partial('header');
        $this->partial('logNavbar');
        $this->view('users');
        $this->partial('footer');

    }



    



    public function add(){
        $this->partial('header');
        $this->partial('navbar');

        $this->view('addNewElement');

        $this->partial('footer');
    }

    
    public function addFunction(){
        $model = $this->model('admin');
		
		$model->add($_POST);
		
		$model->addMainPhoto();
		$model->addPhotos();
        
        
		$model->addMainPhotoDB($_POST);
        $model->addPhotosDB($_POST);
        
		$this->redirect('/admin');
    }

    public function edit(){
        if(!isset($_GET['id']))
            return false;

        $id = $_GET['id'];


        $model = $this->model('shop');
        $data = $model->getElementById($id);

        $this->partial('header');
        $this->partial('navbar');

        $this->view('editElement', $data);

        $this->partial('footer');
    }

    public function editFunc(){
        if(!isset($_GET['id']))
            return false;

        $id = $_GET['id'];

        $model = $this->model('shop');
        
        $model->editElementById($id);
        $this->redirect('/admin');
    }

    public function delete(){
        if(!isset($_GET['id']))
            return false;
        
        $id = $_GET['id'];

        $model = $this->model('admin');
        $model->delete($id);
        $this->redirect('/admin');
    }

    public function logout(){
        session_unset();
        session_destroy();
        $this->redirect('/');
        exit();
    }

    
    
    public function login(){
        
        if(!isset($_POST) || empty($_POST)){
            $_SESSION['logged'] = false;
            $this->redirect("/");
            die();
        }else{
            $model = $this->model('admin');
            if($model->login($_POST)){
                $_SESSION['logged'] = true;
                $this->redirect('/admin');
            }else{
                $_SESSION['logged'] = false;
                $this->redirect('/admin');
            }
        }
    }




    public function users(){
        
        header('Content-type: application/json');
        http_response_code(200);
        $model = $this->model('admin');

        $users = $model->getUsers();
        
        
        echo $users ? json_encode($users) : '';
    }







}