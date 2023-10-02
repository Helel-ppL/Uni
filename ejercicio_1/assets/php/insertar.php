<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');

include_once('conexion.php');
$results = array();
$json_array = [];

if(isset($_POST['Nombre']) && isset($_POST['Apellido']) && isset($_POST['Edad']) && isset($_POST['Sexo']) && isset($_POST['Estado']) && isset($_POST['Sueldo'])){

    if(!empty($_POST['Nombre']) && !empty($_POST['Apellido']) && !empty($_POST['Edad'])&& !empty($_POST['Sexo']) && !empty($_POST['Estado']) && !empty($_POST['Sueldo'])){

        $nombre = $_POST['Nombre'];
        $apellido = $_POST['Apellido'];
        $edad = $_POST['Edad'];
        $sexo = $_POST['Sexo'];
        $estado = $_POST['Estado'];
        $sueldo = $_POST['Sueldo'];

        $query = "INSERT INTO empleado(nombre, apellido, edad, edo_civil, sexo, sueldo) VALUES ('$nombre', '$apellido', '$edad', '$estado', '$sexo', '$sueldo')";
        $rs    = mysqli_query($conn, $query) or die(mysqli_error($conn));
        
        if($rs == true){
            $json_array = array(
                "resp" => "success",
                "message" => "Empleado registrado"
            );
            array_push($results, $json_array);
        }else{
            $json_array = array(
                "resp" => "error",
                "message" => "Empleado NO registrado"
            );
            array_push($results, $json_array);
        }

    }else{
        $json_array = array(
            "resp" => "error",
            "message" => "Datos de empleado Vacios"
        );
        array_push($results, $json_array);
    }

}else{
    $json_array = array(
        "resp" => "error",
        "message" => "No existe el envío de los datos de empleado"
    );
    array_push($results, $json_array);
}

$json_response=json_encode($results);
echo $json_response;
mysqli_close($conn);
?>