<?php
$name_loaded='';
//Se distingue entre get y post porque usé distintos métodos en distintos formularios pero logro enviar lo mismo.
if(@$_GET['loaded_name']){
    $name_loaded = $_GET['loaded_name'];
}else if(@$_POST['editar_nombre']){
    $name_loaded = $_POST['editar_nombre'];
}
$name_loaded = str_replace('%20', ' ', $name_loaded);
$name_loaded = str_replace('.txt', '', $name_loaded);
echo $name_loaded;
?>