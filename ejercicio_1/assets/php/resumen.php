<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');

include_once('conexion.php');

$results = array();
$json_array = [];

$query1 = "SELECT * from empleado where sexo='F'";
$query2 = "SELECT * from empleado where sexo='M' and edo_civil='casado' and sueldo>='2500'";
$query3 = "SELECT * from empleado where sexo='F' and edo_civil='viudo' and sueldo>='1000'";
$query4 = "SELECT * from empleado where sexo='M'";

$rs1    = mysqli_query($conn, $query1) or die(mysqli_error($conn));
$rs2    = mysqli_query($conn, $query2) or die(mysqli_error($conn));
$rs3    = mysqli_query($conn, $query3) or die(mysqli_error($conn));
$rs4    = mysqli_query($conn, $query4) or die(mysqli_error($conn));

$count1 = mysqli_num_rows($rs1);
$count2 = mysqli_num_rows($rs2);
$count3 = mysqli_num_rows($rs3);

$edades = array();
while ($fila = $rs4->fetch_assoc()) {
    $edades[] = $fila['edad'];
}

$totalEdades = count($edades);
$sumaEdades = array_sum($edades);

try{
    $promedio = $sumaEdades/$totalEdades;
}
catch(Exception $e){
    $promedio = 0;
}
finally{
    $json_array = array(
        "resp" => "success",
        "message" => "Resumen listo",
        "res1" => "{$count1}",
        'res2' => "{$count2}",
        'res3' => "{$count3}",
        'res4' => "{$promedio}"
    );
   array_push($results, $json_array);
    echo json_encode($results);
    mysqli_close($conn); 
}



?>