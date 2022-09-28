<?php
include_once '../db.php';

class Select extends DB{
    function get(){
        $query = $this->connect()->query('SELECT MAX(id_orden) AS id FROM ordenes');
        return $query;
    }
}

class Api{

    function getData(){
        $query = new Select();
        $data = array();
        $res = $query->get();

        if($res->rowCount()){
            while ($row = $res->fetch(PDO::FETCH_ASSOC)){
    
                $obj=array(
                    "id" => $row['id']
                );
                array_push($data, $obj);
            }
        
            echo json_encode($data);
        }else{
            $obj=array(
                "id" => '0',
                "name" => 'null'
            );
            array_push($data, $obj);
            echo json_encode($data);
        }
    }
}

$api = new Api();
$api->getData();

?>