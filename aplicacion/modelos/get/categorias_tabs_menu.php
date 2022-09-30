<?php
include_once '../db.php';

class Select extends DB{
    function get(){
        $query = $this->connect()->query('SELECT * FROM categorias_tabs_menu ORDER BY id_tab ASC');
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
                    "id_tab" => $row['id_tab'],
                    "title_tab" => $row['title_tab']
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