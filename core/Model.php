<?php

class Model
{
    private $host = 'localhost';
    private $db_name = 'pai';
    private $username = 'root';
    private $password = '';
    protected $db;
    
    public function __construct()
    {
        try{
            $opt = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
            $conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password, $opt);
            
            $conn -> exec('SET NAMES utf8');
            $this->db = $conn;
            
        }catch (PDOException $e){
            print "Connection error!: ".$e->getMessage()."<br/>";
            die();
        }
    }
}