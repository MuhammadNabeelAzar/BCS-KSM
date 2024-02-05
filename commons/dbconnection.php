<?php
class dbConnection{
    
    public $conn;
    private $hostname = "localhost";
    private $dbusername = "root";
    private $dbpassword = "";
    private $dbname = "ksm";
    
    function __construct(){
        
        $this ->conn = new mysqli(
                $this->hostname, 
                $this->dbusername, 
                $this->dbpassword, 
                $this->dbname
        );
        
        if(!$this->conn->connect_error){
            $GLOBALS["con"] = $this->conn;
        }else{
            echo "Connection Not Successful";
        }
        
        }
}       
    