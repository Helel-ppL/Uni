<?php
$working_dir = getcwd();
//Se distingue entre get y post porque usé distintos métodos en distintos formularios pero logro enviar lo mismo.
if(@$_GET['go_to']){
    $content_path = $_GET['go_to'];
}else if(@$_POST['go_to']){
    $content_path = $_POST['go_to'];
}
@$content_path = str_replace(' ', '%20', $content_path);
$file_path = $working_dir . '/textfiles'. @$content_path . '/';
$complete_file_path = $working_dir . '/textfiles'. @$content_path . '/' . str_replace(' ', '%20', $name_loaded) . '.txt'/*lol hardcoded esta extensión*/ ;

try{
    $myfile = @fopen($complete_file_path, "r");
    if ($myfile) {
        while(!feof($myfile)) {
            echo @fgets($myfile);
        }
        fclose($myfile);
    }
}catch(\Throwable $th){}
?>