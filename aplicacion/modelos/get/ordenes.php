<?php
include_once '../db.php';

class Select extends DB{
    function get(){
        $query = $this->connect()->query('SELECT * FROM ordenes ORDER BY id_orden ASC');
        return $query;
    }
}

class Api{

    function getAll(){
        $query = new Select();
        $data = array();
        $res = $query->get();

        if($res->rowCount()){
            while ($row = $res->fetch(PDO::FETCH_ASSOC)){
    
                $obj=array(
                    "id_orden" => $row['id_orden'],
                    "total" => $row['total'],
                    "nombre_ordenante" => $row['nombre_ordenante']
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
$api->getAll();

?>