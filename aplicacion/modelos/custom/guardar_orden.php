<?php

include_once 'db.php';

class ModelPost extends DB{
    function post($list){
        $query = $this->connect()->prepare(
            'INSERT INTO 
            ordenes(total, nombre_ordenante) 
            VALUES (:total, :nombre_ordenante)');
        $query->execute([
            'total'=>$list['total'], 
            'nombre_ordenante'=>$list['nombre_ordenante']
        ]);
        return 'success';
    }
}

class ApiPost{
    function postAll(){
        $modelo = new ModelPost();
        if($_GET['total']!=null){
            $data=array(
                "total" => $_GET['total'],
                "nombre_ordenante" => $_GET['nombre_ordenante']
            );
            $res=$modelo->post($data);
            if($res=="success"){
                echo 'success'.$data["total"];
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