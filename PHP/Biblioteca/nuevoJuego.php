<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Añadir Juego | LevelUp Library</title>
    </head>
    <body>
        <h1>Añadir Nuevo Juego</h1>
        <div id="linea"></div>

        <form action="nuevoJuego_DB.php" method="post">
            <input type="text" name="titulo" placeholder="Titulo" maxlength="200" value="<?php echo (isset($_SESSION["titulo"]) ? $_SESSION["titulo"] : "") ?>">
            <br/>

            <input type="text" name="descripcion" placeholder="Descripción" value="<?php echo (isset($_SESSION["descripcion"]) ? $_SESSION["descripcion"] : "") ?>">
            <br/>
            
            <input type="text" name="autor" placeholder="Autor" maxlength="100" value="<?php echo (isset($_SESSION["autor"]) ? $_SESSION["autor"] : "") ?>">
            <br/>

            <input type="file" name="caratula">
            <br/>

            <input type="text" name="categoria" placeholder="Categoria" maxlength="50" value="<?php echo (isset($_SESSION["categoria"]) ? $_SESSION["categoria"] : "") ?>">
            <br/>

            <input type="text" name="url" placeholder="URL" maxlength="500" value="<?php echo (isset($_SESSION["URL"]) ? $_SESSION["URL"] : "") ?>">
            <br/>

            <input type="number" name="año" placeholder="Año" value="<?php echo (isset($_SESSION["año"]) ? $_SESSION["año"] : "") ?>">
            <br/>

            <input type="submit">
        </form>
    </body>
</html>