<?php
class DatabaseConnection{

    private $host;
    private $pdoObj;

    function __construct($host){
        $this->host = $host;
    }
    
    function connect(){
        global $host, $dbname, $pdoObj;
        try{
            $connString = "mysql:host={$host};dbname=blogdb";
            $pdoObj = new PDO($connString, "root", "");
            $pdoObj -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        }catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
          }      
          return $pdoObj;
    }

    function destroy(){
        $pdoObj = null;
    }
}

?>