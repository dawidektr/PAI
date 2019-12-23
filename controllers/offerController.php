<?php

class OfferController extends Controller{
    

    public function index(){
        $this->partial('header');
        $this->partial('navbar');
       // $this->partial('offer');
        

        $model = $this->model('offer');       
      $car = $model->carInfo();
      $html2=$model->gencarINFO($car);
      echo $html2;



       $tab=$model->getPhotos();

    
        $html = $model->genHTML($tab);

       echo $html;
        
        
        
        
        
        $this->partial('footer');
    }






}