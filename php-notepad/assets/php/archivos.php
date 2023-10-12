<?php

//  Aquí manejo todo el enrutamiento de los archivos del gestor y genero la tabla que
//muestra todos los archivos en el directorio.

//Ejecuta la función si se presionó el botón eliminar
if(@$_POST['eliminar']){
    @eliminar($file_path . $_POST['eliminar']);
}

try {
    $go_to = @$_GET['go_to'];
    $went = validar_avance($go_to);
} catch (\Throwable $th) {
    $went = '/textfiles';
} finally {
    $path = $working_dir . $went;
    $path = corregir_espacios($path);
}

// echo 'WORKING DIR: ', $working_dir, '<br>';
// echo 'PATH: ', $path, '<br>';
if (array_key_exists('button1', $_POST)) {
    $newf = corregir_espacios($_POST['folder_name']);
    // echo 'funciona plis:',$went, '<br>';
    // echo 'xd', $path,'<br>';
    crear_carpeta($path, $newf);
}
if (array_key_exists('button2', $_POST)) {
    header('Location: index.php');
    die();
}

$dir_result = scandir($path);
$dir_result = array_diff($dir_result, ['.', '..']);
echo '<tr>
        <th>TIPO</th>
        <th>NOMBRE</th>
        <th>TAMAÑO</th>
        <th>ÚLTIMA MODIFICACIÓN</th>
        <th colspan=2>ACCIONES</th>
    </tr>';

date_default_timezone_set('America/Caracas');

//Se llenan los datos de la tabla.
foreach ($dir_result as $dir) {
    $dir_url = corregir_espacios($dir);
    $this_file_exists = is_file($path . "/" . $dir_url);
    $this_dir_exists = is_dir($path . "/" . $dir_url);

    echo '<tr>';
    //Indica si es archivo o directorio y prepara el enrutamiento.
    $echoed_went = str_replace('/textfiles', '', $went);
    $echoed_went = str_replace(' ', '%20', $echoed_went);
    if ($this_file_exists){
        echo '<td id=txtdata>';
        echo "<img src=assets/imgs/text-1520.png id=file_icon>";
        echo '</td>';
        echo '<td id=td_nombre>';
        echo '<a href=?go_to=', $echoed_went,'&loaded_name=',$dir_url,'&file=True','>';
    } else if ($this_dir_exists){
        echo '<td>';
        echo "<img src=assets/imgs/folder-1484.png id=file_icon>";
        echo '</td>';
        echo '<td id=td_nombre>';
        echo '<a href=?go_to=', $echoed_went, '/', $dir_url,'&file=False', '>';
    }

    //Nombre del archivo o directorio.
    $echoed_name = mostrar_espacios($dir);
    echo $echoed_name, '</a>';
    echo '</td>';

    //DETALLES
        //Tamaño
    $file_details = stat($path . '/' . $dir_url);
    echo '<td>';
    if($this_file_exists){
        echo formatBytes($file_details[7]);
    }
    echo '</td>';

        //Última modificación
    echo '<td>';
    echo date('d-m-Y h:i:sA',$file_details[8]);
    echo '</td>';
    
    //ACCIONES
        //Editar
    echo '<td>';
    if($this_file_exists){
        echo '<form method=post>';
        echo '<input type=hidden name=editar_nombre value=', $dir_url, '>';
        echo '<input type=hidden name=go_to value=', $go_to, '>';
        echo '<button>';
        echo 'Editar';
        echo '</button></form>';
    }
    echo '</td>';

        //Eliminar
    echo '<td>';
    echo '<form method=post>';
    echo '<input type=hidden name=eliminar value=', $dir_url, '>';
    echo '<button>';
    echo 'Eliminar';
    echo '</button></form></td>';

    echo '</tr>';
}
function crear_carpeta(string $path, string $new_folder_name){
    // echo "SE CREARÁ LA CARPETA DENTRO DE: ", $path, '<br>';
    $new_folder = $path . '/' . $new_folder_name;
    if (!file_exists($new_folder)) {
        // echo "CARPETA CREADA EN: ", $new_folder, '<br>';
        mkdir($new_folder);
    }
}
function validar_avance(string $selected_folder = '/textfiles'){
    if (
        strpos($selected_folder, '\.') === false &&
        strpos($selected_folder, '\..') === false &&
        strpos($selected_folder, '/.') === false &&
        strpos($selected_folder, '/..') === false
    ) {
        return '/textfiles' . $selected_folder;
    } else {
        header( 'Location: index.php' );
        die();
    }
}
function corregir_espacios(string $path){
    $path = str_replace(' ', '%20', $path);
    $path = filter_var($path, FILTER_SANITIZE_URL);
    return $path;
}
function mostrar_espacios(string $path){
    $path = str_replace('%20', ' ', $path);
    return $path;
}
function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    $bytes /= (1 << (10 * $pow)); 

    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 
function eliminar(string $file_path){
    if(is_dir($file_path)){
        if (rmdir($file_path)){
            echo "<p class=successful>El directorio se eliminó correctamente.</p>";
        } else {
            echo "<p class=error>El directorio debe estar vacío antes de poder borrarlo.</p>";
        }
    } else if(is_file($file_path)){
        unlink($file_path);
    }
}


?>