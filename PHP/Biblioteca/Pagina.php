<?php
session_start(); 
if (!isset($_SESSION["emailLogin"])) {
    header("Location: ../../index.php");
    exit;
}
require '../Conexion_DB.php';
require 'leerJuegos_DB.php';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bienvenido | LevelUp Library</title>
        <link rel="stylesheet" href="../../CSS/style_Pagina.css">
        <link rel="stylesheet" href="../../CSS/style_Header.css">

        <script>
            let searchTimeout; 

            function debouncedSearch(busca) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    barraBusqueda(busca);
                }, 300);
            }

            function barraBusqueda(busca) {
                let xmlhttp = new XMLHttpRequest();

                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        let res = JSON.parse(this.responseText);

                        for (let x = 0 ; x < res.todos.length ; x++) {
                            document.getElementById(res.todos[x]).style["display"] = "none";
                        }

                        if (res.buscados.length !== 0) {
                            document.getElementById("noJuego").style["display"] = "none";

                            for (let x = 0 ; x < res.buscados.length ; x++) {
                                document.getElementById(res.buscados[x]).style["display"] = "inline";
                            }
                        } else {
                            document.getElementById("noJuego").style["display"] = "block";
                        }
                        
                    }
                }

                xmlhttp.open("GET", "buscarJuegos_DB.php?b=" + encodeURIComponent(busca) + "%", true);
                xmlhttp.send();
            }
        </script>
    </head>

    <body>
        <header>
            <a href="Pagina.php">
                <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.336 2.253a1 1 0 0 1 1.328 0l9 8a1 1 0 0 1-1.328 1.494L20 11.45V19a2 2 0 0 1-2 2H6a2 2 0 0 
                    1-2-2v-7.55l-.336.297a1 1 0 0 1-1.328-1.494l9-8zM6 9.67V19h3v-5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 
                    1v5h3V9.671l-6-5.333-6 5.333zM13 19v-4h-2v4h2z" fill="#ffffffff"/>
                </svg>
            </a>
            <p class="welcome-user">Hola <?php echo htmlspecialchars($_SESSION["nombreLogin"]); ?>!</p>
            <form>
                <input type="text" onkeyup="debouncedSearch(this.value)" placeholder="Buscar Juegos...">
            </form>
            <a href="Crear/nuevoJuego.php" class="btn-juego">Añadir Juego</a>
            <a href="Perfil.php"><img src="<?php echo $_SESSION["fotoLogin"]; ?>" style="width:64px; border-radius:64px;"></a>
        </header>

        <div id="juegos">
        <?php
            foreach ($result as $juego) {
                echo "<a id=\"" . $juego["id"] . "\" href=\"Juego.php?id=" . $juego["id"] . "\">";
                    echo "<div class=\"juego\" style=\"background-image: url(" . $juego["caratula"] . ");\">";
                        echo "<h1 class=\"titulo\">" . htmlspecialchars($juego["titulo"]) . "</h1>";
                        echo "<h2 class=\"autor\">" . htmlspecialchars($juego["autor"]) . "</h2>";
                    echo "</div>";
                echo "</a>";
            }

            $conn = false;
        ?>
        </div>

        <div id="noJuego" style="display: none;">
            <p>Ningún Juego Encontrado</p>
        </div>
    </body>
</html>