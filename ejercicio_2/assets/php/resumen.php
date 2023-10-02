<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');

include_once('conexion.php');

$results = array();
$json_array = [];

// Nota promedio de cada materia.
$query1 = "SELECT nota_matematicas, nota_fisica, nota_programacion from estudiante";
$rs1    = mysqli_query($conn, $query1) or die(mysqli_error($conn));
$count1 = mysqli_num_rows($rs1);
$notas_mat = array();
$notas_fis = array();
$notas_prog = array();
while ($fila = $rs1->fetch_assoc()) {
    $notas_mat[] = $fila['nota_matematicas'];
    $notas_fis[] = $fila['nota_fisica'];
    $notas_prog[] = $fila['nota_programacion'];
}

// Obtener el número de alumnos aprobados en cada materia.
$query2_1 = "SELECT * from estudiante where nota_matematicas>=10";
$query2_2 = "SELECT * from estudiante where nota_fisica>=10";
$query2_3 = "SELECT * from estudiante where nota_programacion>=10";
$rs2_1    = mysqli_query($conn, $query2_1) or die(mysqli_error($conn));
$count2_1 = mysqli_num_rows($rs2_1);
$rs2_2  = mysqli_query($conn, $query2_2) or die(mysqli_error($conn));
$count2_2 = mysqli_num_rows($rs2_2);
$rs2_3  = mysqli_query($conn, $query2_3) or die(mysqli_error($conn));
$count2_3 = mysqli_num_rows($rs2_3);

//Obtener el número de alumnos reprobados en cada materia.
$query3_1 = "SELECT * from estudiante where nota_matematicas<10";
$query3_2 = "SELECT * from estudiante where nota_fisica<10";
$query3_3 = "SELECT * from estudiante where nota_programacion<10";
$rs3_1    = mysqli_query($conn, $query3_1) or die(mysqli_error($conn));
$count3_1 = mysqli_num_rows($rs3_1);
$rs3_2  = mysqli_query($conn, $query3_2) or die(mysqli_error($conn));
$count3_2 = mysqli_num_rows($rs3_2);
$rs3_3  = mysqli_query($conn, $query3_3) or die(mysqli_error($conn));
$count3_3 = mysqli_num_rows($rs3_3);

// Contar los estudiantes que aprobaron todas las materias.
$query4 = "SELECT * from estudiante where nota_matematicas>=10 and nota_fisica>=10 and nota_programacion>=10";
$rs4    = mysqli_query($conn, $query4) or die(mysqli_error($conn));
$count4 = mysqli_num_rows($rs4);

// Contar los estudiantes que pasaron una sola materia.
$query5 = "SELECT COUNT(*) as cantidad FROM estudiante WHERE (nota_matematicas >= 10 AND nota_fisica < 10 AND nota_programacion < 10) OR (nota_matematicas < 10 AND nota_fisica >= 10 AND nota_programacion < 10) OR (nota_matematicas < 10 AND nota_fisica < 10 AND nota_programacion >= 10)";
$rs5 = mysqli_query($conn, $query5) or die(mysqli_error($conn));
$count5 = mysqli_num_rows($rs5);

// Contar los estudiantes que pasaron dos materias.
$query6 = "SELECT COUNT(*) as cantidad FROM estudiante WHERE (nota_matematicas >= 10 AND nota_fisica >= 10 AND nota_programacion < 10) OR (nota_matematicas >= 10 AND nota_fisica < 10 AND nota_programacion >= 10) OR (nota_matematicas < 10 AND nota_fisica >= 10 AND nota_programacion >= 10)";
$rs6 = mysqli_query($conn, $query6) or die(mysqli_error($conn));
$count6 = mysqli_num_rows($rs6);

// Encontrar nota máxima de cada materia.
$query7 = "SELECT MAX(nota_matematicas) as max_matematicas, MAX(nota_fisica) as max_fisica, MAX(nota_programacion) as max_programacion FROM estudiante";
$rs7 = mysqli_query($conn, $query7);
if ($rs7) {
    $fila = mysqli_fetch_assoc($rs7);
    $max_matematicas = $fila['max_matematicas'];
    $max_fisica = $fila['max_fisica'];
    $max_programacion = $fila['max_programacion'];
}

try{
    $total1 =   array_sum($notas_mat);
    $total2 =   array_sum($notas_fis);
    $total3 =   array_sum($notas_prog);
    $prom1 = $total1/$count1;
    $prom2 = $total2/$count1;
    $prom3 = $total3/$count1;
}
catch(Exception $e){
    $promedio = 0;
}
finally{
    $json_array = array(
        "resp" => "success",
        "message" => "Resumen listo",

        "promedio_mat" => "{$prom1}",
        "aprobados_mat" => "{$count2_1}",
        "reprobados_mat" => "{$count3_1}",
        "max_mat" => "{$max_matematicas}",

        "promedio_fis" => "{$prom2}",
        "aprobados_fis" => "{$count2_2}",
        "reprobados_fis" => "{$count3_2}",
        "max_fis" => "{$max_fisica}",

        "promedio_prog" => "{$prom3}",
        "aprobados_prog" => "{$count2_3}",
        "reprobados_prog" => "{$count3_3}",
        "max_prog" => "{$max_programacion}",

        "pasaron_una" =>"{$count5}",
        "pasaron_dos" =>"{$count6}",
        "pasaron_todo" => "{$count4}",
    );
   array_push($results, $json_array);
    echo json_encode($results);
    mysqli_close($conn);  
}

?>