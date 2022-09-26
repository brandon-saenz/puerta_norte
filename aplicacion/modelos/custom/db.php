<?php

class DB{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host     = 'p3plzcpnl487033';
        $this->db       = 'rancho_tecate';
        $this->user     = 'p1d67xcfzkkf';
        $this->password = "Bo0B13S777.";
        $this->charset  = 'utf8mb4';
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