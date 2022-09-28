<?php

include_once '../db.php';

class ModelPost extends DB{
    function post($list){
        $query = $this->connect()->prepare(
            'INSERT INTO 
            items_orden(id_orden, id_producto, cantidad, nota, subtotal) 
            VALUES (:id_orden, :id_producto, :cantidad, :nota, :subtotal)');
        $query->execute([
            'id_orden'=>$list['id_orden'], 
            'id_producto'=>$list['id_producto'],
            'cantidad'=>$list['cantidad'],
            'nota'=>$list['nota'],
            'subtotal'=>$list['subtotal']
        ]);
        return 'success';
    }
}

class ApiPost{
    function postAll(){
        $modelo = new ModelPost();
        if($_GET['id_orden']!=null){
            $data=array(
                "id_orden" => $_GET['id_orden'],
                "id_producto" => $_GET['id_producto'],
                "cantidad" => $_GET['cantidad'],
                "nota" => $_GET['nota'],
                "subtotal" => $_GET['subtotal'],
            );
            $res=$modelo->post($data);
            if($res=="success"){
                echo 'success';
            }else{
                echo 'ERROR - ApiPost';
            }
        }else{
            echo 'ERROR - Sin parametros';
        }
    }
}

$api = new ApiPost(); 
$api->postAll();
?>