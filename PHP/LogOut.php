<?php 
session_start();
session_destroy();

require 'Conexion_DB.php';
if (isset($_COOKIE["cookieSesion"])) {
    try {
        $sentencia = $conn->prepare("DELETE FROM cookies WHERE cookie LIKE(:cookie)");
        $sentencia->bindParam(":cookie", $_COOKIE["cookieSesion"]);
        $sentencia->execute();

    } catch (PDOException $ex) {
        // ERROR
    }

    setcookie("cookieSesion", "", time() - (60 * 60), "/");
}

header("Location: Login/Login.php");
exit;
?>