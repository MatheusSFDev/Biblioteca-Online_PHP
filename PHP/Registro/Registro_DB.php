<?php
session_start();
require '../Conexion_DB.php';

$nombre = $_POST["nombre"];
$email = $_POST["email"];
$passwd = $_POST["passwd"];
$passwd_R = $_POST["passwd_R"];
$passwd_H = password_hash($passwd, PASSWORD_DEFAULT);

if (datosCorrectos($nombre, $email, $passwd, $passwd_R)) {
    try {
        $sentencia = $conn->prepare("INSERT INTO usuarios(email, nombre, passwd) VALUE (:email, :nombre, :passwd)");

        $sentencia->bindParam(":email", $email);
        $sentencia->bindParam(":nombre", $nombre);
        $sentencia->bindParam(":passwd", $passwd_H);

        $sentencia->execute();

        session_destroy();
        session_start();
        $_SESSION["correcto"] = "<p> Cuenta Creada! Logueate</p>";

        $conn = null;
        header("Location: ../Login/Login.php");
        exit;
    } catch (PDOException $ex) {
        $_SESSION["err_Try"] = "<p> Operación Fallida </p>";
        header("Location: Registro.php");
        exit;
    }
} else {
    header("Location: Registro.php");
    exit;
}

function datosCorrectos($nombre, $email, $passwd, $passwd_R) {
    $correcto = true;
    $err = "";

    if (!preg_match("/^[a-zA-Z-' ]*$/", $nombre) || empty($nombre)) {
        $correcto = false;
        $_SESSION["nombre"] = "";

        if (empty($nombre)) {
            $err = "El Campo esta Vacio";
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $nombre)) {
            $err = "Solo se permiten letras, espacios y el caracter (')";
        }

        $_SESSION["err_Nombre"] = "<p>! " . $err . " !</p>";
    } else {
        $_SESSION["nombre"] = $nombre;
        $_SESSION["err_Nombre"] = "";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email) || !emailValido($email)) {
        $correcto = false;
        $_SESSION["email"] = "";

        if (empty($email)) {
            $err = "El Campo esta Vacio";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $err = "No Cumple con un formato correcto de Correo";
        }  elseif (!emailValido($email)) {
            $err = "El Correo Introducido ya Existe";
        }

        $_SESSION["err_Email"] = "<p>! " . $err . " !</p>";
    } else {
        $_SESSION["email"] = $email;
        $_SESSION["err_Email"] = "";
    }

    if ($passwd !== $passwd_R || empty($passwd)) { 
        $correcto = false; 
        $_SESSION["passwd"] = "";

        if (empty($passwd)) {
            $err = "El Campo esta Vacio";
        } elseif ($passwd !== $passwd_R) {
            $err = "Las Contraseñas no coinciden";
        } 

        $_SESSION["err_Passwd"] = "<p>! " . $err . " !</p>";
    } else {
        $_SESSION["passwd"] = $passwd;
        $_SESSION["err_Passwd"] = "";
    }

    return $correcto;
}

function emailValido($mail) {
    require '../Conexion_DB.php';

    try {
        $sentencia = $conn->prepare("SELECT email FROM usuarios WHERE email like(:email)");
        $sentencia->bindParam(":email", $mail);
        $sentencia->execute();

        $result = $sentencia->fetch(PDO::FETCH_ASSOC);
        $conn = null;
    } catch (PDOException $ex) {
        $_SESSION["err_Try"] = "<p> Operación Fallida </p>";
    }

    return $result === false;
}
?>