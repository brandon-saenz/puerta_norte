<?php
include_once '../db.php';

class Select extends DB{
    function get(){
        $query = $this->connect()->query('SELECT * FROM categorias_menu ORDER BY id_categoria ASC');
        return $query;
    }
}

class Api{

    function getAll(){
        $query = new Select();
        $data = array();
        $data = array();
        $res = $query->get();

        if($res->rowCount()){
            while ($row = $res->fetch(PDO::FETCH_ASSOC)){
    
                $obj=array(
                    "id_categoria" => $row['id_categoria'],
                    "name_categoria" => $row['name_categoria'],
                    "icono" => $row['icono']
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