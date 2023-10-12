<?php
if (array_key_exists('volver', $_POST)) {
    header('Location: index.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Editor de texto</title>
</head>

<body>
    <div class="containter">
        <header id="title_header">
            <h2 id="title">Editor de texto en PHP</h2>
        </header> 
    </div>
    <div class="container" id="editor_container">
        <header>
            <h2>Archivo</h2>
        </header>
        <form name="text_save" method="post" target="_self" id="text">
            <table border="1">
                <tr>
                    <td>
                        <label for="file_name">Nombre del archivo:</label>
                    </td>
                    <td>
                        <input type="text" name="file_name" id="file_name" value="<?php
                        include_once('./assets/php/cargar_nombre.php');
                        ?>" size=40 placeholder="Nombre del archivo nuevo">
                    </td>
                </tr>

                <table border="1">
                    <tr>
                        <th colspan="2">Contenido</th>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <textarea name="file_content" id="file_content" cols="150" rows="25" wrap="off"
                                placeholder="Comienza a escribir aquí..." autocorrect="on"><?php
                                include_once('./assets/php/cargar_contenido.php');
                                ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Todos los archivos se guardan automáticamente con la extensión .txt</h5>
                        <td>
                            <button id="guardar" type="submit">Guardar</button>
                        <td>
                    </tr>
                </table>
                </td>
        </form>
    </div>
    <?php
    // echo $name_loaded, '<br>';
    // // echo $content_path, '<br>';
    // echo $file_path, '<br>';
    // echo $complete_file_path, '<br>';
    ?>
    <div class="container" id="folder_container">
        <header>
            <h2>Directorios</h2>
        </header>
        <div style="overflow-x:auto;">
            <table border="1">
                <form method="post" class=bar>
                    <tr>
                        <td colspan=2>
                            <input type="text" name="folder_name" placeholder="Nombre del directorio nuevo" size=20>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2>
                            <input type="submit" name="button1" class="button" value="Crear nuevo 
directorio" />
                        </td>
                        <td>
                            <input type="submit" name="volver" class="button" value="Volver a
directorio principal" />
                        </td>
                    </tr>
                    <tr>
                        <th colspan=6>Archivos del directorio actual:</th>
                    </tr>
                </form>
                <div>
                    <?php
                    include_once('./assets/php/archivos.php');
                    echo '<tr>', '<td colspan=6>', 'Ruta del directorio actual: ', $went, '</td>', '</tr>';
                    echo '</table>';
                    echo '</div>';
                    include_once('./assets/php/guardar.php');
                    ?>
                </div>
        </div>
</body>

</html>