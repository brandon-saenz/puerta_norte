<?php

class DB{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->charset  = 'utf8mb4';
        $this->db       = 'rancho_tecate';
        if(getenv('HTTP_HOST')=='localhost'){
            $this->host     = 'localhost';
            $this->user     = 'root';
            $this->password = '';
        }else{
            $this->host     = 'p3plzcpnl487033';
            $this->user     = 'p1d67xcfzkkf';
            $this->password = 'br4n.GazTor';
        }
    }

    function connect(){
        try{
            $connection = "mysql:host=".$this->host.";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($connection,$this->user,$this->password);
            return $pdo;

        }catch(PDOException $e){
            echo 'error';
        }   
    }
}

?>