<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');

include_once('conexion.php');
$results = array();
$json_array = [];

if(isset($_POST['Nombre']) && isset($_POST['Cedula']) && isset($_POST['Mate']) && isset($_POST['Fis']) && isset($_POST['Prog'])){

    if(!empty($_POST['Nombre']) && !empty($_POST['Cedula']) && !empty($_POST['Mate'])&& !empty($_POST['Fis']) && !empty($_POST['Prog'])){

        $nombre = $_POST['Nombre'];
        $cedula = $_POST['Cedula'];
        $mate = $_POST['Mate'];
        $fisica = $_POST['Fis'];
        $prog = $_POST['Prog'];

        $query = "INSERT INTO estudiante(nombre, cedula, nota_matematicas, nota_fisica, nota_programacion) VALUES ('$nombre', '$cedula', '$mate', '$fisica', '$prog')";
        $rs    = mysqli_query($conn, $query) or die(mysqli_error($conn));
        
        if($rs == true){
            $json_array = array(
                "resp" => "success",
                "message" => "Estudiante registrado"
            );
            array_push($results, $json_array);
        }else{
            $json_array = array(
                "resp" => "error",
                "message" => "Estudiante NO registrado"
            );
            array_push($results, $json_array);
        }

    }else{
        $json_array = array(
            "resp" => "error",
            "message" => "Datos de estudiante vacíos"
        );
        array_push($results, $json_array);
    }

}else{
    $json_array = array(
        "resp" => "error",
        "message" => "No existe un envío de los datos del estudiante"
    );
    array_push($results, $json_array);
}

$json_response=json_encode($results);
echo $json_response;
mysqli_close($conn);
?>