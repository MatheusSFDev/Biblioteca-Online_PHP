<?php
session_start();
require '../Conexion_DB.php';

$nombre = $_POST["nombre"];
$email = $_POST["email"];
$passwd = $_POST["passwd"];
$passwd_R = $_POST["passwd_R"];
$passwd_H = password_hash($passwd, PASSWORD_DEFAULT);

$correct = true;

if (!preg_match("/^[a-zA-Z-' ]*$/", $nombre) || empty($nombre)) {
    $correct = false;
    $_SESSION["nombre"] = "";

    if (empty($nombre)) {
        $_SESSION["err_Nombre"] = "<p>! El Campo esta Vacio !</p>";
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $nombre)) {
        $_SESSION["err_Nombre"] = "<p>! Solo se permiten letras, espacios y el caracter (') !</p>";
    }
} else {
    $_SESSION["nombre"] = $nombre;
    $_SESSION["err_Nombre"] = "";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email) || !emailValido($email)) {
    $correct = false;
    $_SESSION["email"] = "";

    if (empty($email)) {
        $_SESSION["err_Email"] = "<p>! El Campo esta Vacio !</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["err_Email"] = "<p>! No Cumple con un formato correcto de Correo !</p>";
    }  elseif (!emailValido($email)) {
        $_SESSION["err_Email"] = "<p>! El Correo Introducido ya Existe !</p>";
    }
} else {
    $_SESSION["email"] = $email;
    $_SESSION["err_Email"] = "";
}

if ($passwd !== $passwd_R || empty($passwd)) { 
    $correct = false; 
    $_SESSION["passwd"] = "";

    if (empty($passwd)) {
        $_SESSION["err_Passwd"] = "<p>! El Campo esta Vacio !</p>";
    } elseif ($passwd !== $passwd_R) {
        $_SESSION["err_Passwd"] = "<p>! Las Contraseñas no coinciden !</p>";
    } 
} else {
    $_SESSION["passwd"] = $passwd;
    $_SESSION["err_Passwd"] = "";
}

if ($correct) {
    try {
        $sentencia = $conn->prepare("INSERT INTO usuarios(email, nombre, passwd) VALUE (:email, :nombre, :passwd)");

        $sentencia->bindParam(":email", $email);
        $sentencia->bindParam(":nombre", $nombre);
        $sentencia->bindParam(":passwd", $passwd_H);

        $sentencia->execute();

        session_destroy();
        $insertado = true;
    } catch (PDOException $ex) {
        $_SESSION["err_Try"] = "<p> Operación Fallida </p>";
    }

    $conn = null;

    if ($insertado) {
        session_start();
        $_SESSION["correcto"] = "<p> Cuenta Creada! Logueate</p>";

        header("Location: ../Login/Login.php");
        exit;
    }
    
    header("Location: Registro.php");
    exit;
} else {
    header("Location: Registro.php");
    exit;
}

function emailValido($mail) {
    require '../Conexion_DB.php';

    try {
        $sentencia = $conn->prepare("SELECT email FROM usuarios WHERE email like(:email)");
        $sentencia->bindParam(":email", $mail);

        $sentencia->execute();

        $result = $sentencia->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        $_SESSION["err_Try"] = "<p> Operación Fallida </p>";
    }

    $conn = null;

    return $result === false;
}
?>