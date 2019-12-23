<?php

class AboutmeController extends Controller{
    

    public function index(){
        $this->partial('header');
        $this->partial('navbar');
        
        $this->partial('aboutme');
        

        
        
        
        
        
        $this->partial('footer');
    }






}