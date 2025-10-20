<?php
session_start(); 
require 'PHP/Conexion_DB.php';

if (isset($_COOKIE["cookieSesion"])) {
    try {
        $sentencia = $conn->prepare("SELECT usuario FROM cookies WHERE cookie LIKE(:cookie) AND fecha_exp > NOW()");
        $sentencia->bindParam(":cookie", $_COOKIE["cookieSesion"]);
        $sentencia->execute();
        
        $result = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($result !== false) {
            $email = $result["usuario"];
            $sentencia = $conn->prepare("SELECT nombre, email, foto FROM usuarios WHERE email LIKE(:email)");
            $sentencia->bindParam(":email", $email);
            $sentencia->execute();

            $result = $sentencia->fetch(PDO::FETCH_ASSOC);
            $_SESSION["nombreLogin"] = $result["nombre"];
            $_SESSION["emailLogin"] = $result["email"];
            $_SESSION["fotoLogin"] = $result["foto"];

            header("location: PHP/Biblioteca/Pagina.php");
            exit;
        } else {
            $sentencia = $conn->prepare("DELETE FROM cookies WHERE cookie LIKE(:cookie)");
            $sentencia->bindParam(":cookie", $_COOKIE["cookieSesion"]);
            $sentencia->execute();

            header("location: PHP/Login/Login.php");
            exit;
        }
    } catch (PDOException $ex) {
        echo "Operación Fallida";
    }
} else {
    header("location: PHP/Login/Login.php");
    exit;
}
?>