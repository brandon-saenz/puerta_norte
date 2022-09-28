<?php
include_once '../db.php';

class SelectProductos extends DB{
    function getProductos(){
        $query = $this->connect()->query('SELECT * FROM productos_menu ORDER BY id_producto ASC');
        return $query;
    }
}

class ApiProductos{

    function getAllProductos(){
        $query = new SelectProductos();
        $data = array();
        $data = array();
        $res = $query->getProductos();

        if($res->rowCount()){
            while ($row = $res->fetch(PDO::FETCH_ASSOC)){
    
                $obj=array(
                    "id_producto" => $row['id_producto'],
                    "titulo" => $row['titulo'],
                    "descripcion" => $row['descripcion'],
                    "precio" => $row['precio'],
                    "id_categoria" => $row['id_categoria'],
                    "id_unidad_medida" => $row['id_unidad_medida'],
                    "destacado" => $row['destacado']
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

$apiProductos = new ApiProductos();
$apiProductos->getAllProductos();

?>