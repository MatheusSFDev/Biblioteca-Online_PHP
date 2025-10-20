<?php
session_start(); 
if (!isset($_SESSION["emailLogin"])) {
    header("Location: ../../../index.php");
    exit;
}

require 'contarViews_DB.php';
require 'topVisitas_DB.php';
require 'viewsJuegos_DB.php';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil | LevelUp Library</title>
        <link rel="stylesheet" href="../../../CSS/style_Header.css">
        <link rel="stylesheet" href="../../../CSS/style_PanelViews.css">
    </head>

    <body>
        <header>
            <a href="../Pagina.php">
                <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.336 2.253a1 1 0 0 1 1.328 0l9 8a1 1 0 0 1-1.328 1.494L20 11.45V19a2 2 0 0 1-2 2H6a2 2 0 0 
                    1-2-2v-7.55l-.336.297a1 1 0 0 1-1.328-1.494l9-8zM6 9.67V19h3v-5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 
                    1v5h3V9.671l-6-5.333-6 5.333zM13 19v-4h-2v4h2z" fill="#ffffffff"/>
                </svg>
            </a>
            <p class="welcome-user">Hola <?php echo htmlspecialchars($_SESSION["nombreLogin"]); ?>!</p>
            <a href="../Crear/nuevoJuego.php" class="btn-juego">Añadir Juego</a>
            <a href="../Perfil.php"><img src="../<?php echo $_SESSION["fotoLogin"]; ?>" style="width:64px; border-radius:64px;"></a>
        </header>

        <div class="stats-container-grid">
            <div class="stats-col-main">
                <div class="stat-card total-views">
                    <h1>Total Visualizaciones</h1>
                    <p><?php echo $viewsTotales; ?></p>
                </div>
                
                <div class="stat-card top-games">
                    <h1>Top 3 Más Vistos</h1>
                    <div class="stat-list">
                    <?php
                        if (empty($resultTop)) {
                            echo "<p><span>No hay datos suficientes.</span></p>";
                        } else {
                            foreach ($resultTop as $juego) {
                                echo "<p><span>" . htmlspecialchars($juego["titulo"]) . "</span> <span>" . $juego["visualizaciones"] . " Views</span></p>";
                            }
                        }
                    ?>
                    </div>
                </div>

            </div>

            <div class="stats-col-all-games">
                <div class="stat-card all-games-list">
                    <h1>Todos tus Juegos</h1>
                    <div class="stat-list scrollable-list">
                    <?php
                        if (empty($resultTodos)) {
                            echo "<p><span>Aún no has añadido ningún juego.</span></p>";
                        } else {
                            foreach ($resultTodos as $juego) {
                                echo "<p><span>" . htmlspecialchars($juego["titulo"]) . "</span> <span>" . $juego["visualizaciones"] . " Views</span></p>";
                            }
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>