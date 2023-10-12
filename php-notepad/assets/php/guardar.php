<?php

if(@$_GET['success']){
    echo '<h4 class=message id=saved>¡Archivo guardado exitosamente!</h4>';
}

$url_went = str_replace('/textfiles', '', $went);
if(array_key_exists('file_name', $_POST)) {
    // header( 'Location: index.php/?go_to=' . $url_went . '&success=True');
    $file = $path . '/'. $_POST['file_name'] . '.txt';
    $texto = $_POST['file_content'];
    
    $file = str_replace(' ', '%20', $file);
    $file = filter_var($file, FILTER_SANITIZE_URL);
    
    echo 'GUARDADO EN:', $file,'<br>';
    echo 'url went:', $url_went,'<br>';
    echo 'file_name: ', $_POST['file_name'],'<br>';
    
    $fp = fopen($file, "w");
    fwrite($fp, $texto);
    fclose($fp);
    echo "<meta http-equiv='refresh' content='0'>";
}

?>