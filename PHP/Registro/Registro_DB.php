<?php
session_start();
require '../Conexion_DB.php';

$nombre = $_POST["nombre"];
$email = $_POST["email"];
$passwd = $_POST["passwd"];
$passwd_R = $_POST["passwd_R"];
$passwd_H = password_hash($passwd, PASSWORD_DEFAULT);

if (datosCorrectos($nombre, $email, $passwd, $passwd_R)) {
    $foto = guardarFoto();
} else {
    $foto = "false";
}

if ($foto != "false") {
    try {
        $sentencia = $conn->prepare("INSERT INTO usuarios(email, nombre, passwd, foto) VALUE (:email, :nombre, :passwd, :foto)");

        $sentencia->bindParam(":email", $email);
        $sentencia->bindParam(":nombre", $nombre);
        $sentencia->bindParam(":passwd", $passwd_H);
        $sentencia->bindParam(":foto", $foto);

        $sentencia->execute();

        session_destroy();
        session_start();
        $_SESSION["correcto"] = "<p> Cuenta Creada! Logueate</p>";

        $conn = null;
        header("Location: ../Login/Login.php");
        exit;
    } catch (PDOException $ex) {
        $_SESSION["err"] = "<p> Operación Fallida </p>";

        $conn = null;
        header("Location: Registro.php");
        exit;
    }
} else {
    $conn = null;
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

    if (($passwd !== $passwd_R || empty($passwd) || !passwdValida($passwd)) && $passwd != "123") { // Borrar Luego, solo se utiliza para tests durante Desarrollo 
        $correcto = false; 
        $_SESSION["passwd"] = "";

        if (empty($passwd)) {
            $err = "El Campo esta Vacio";
        } elseif ($passwd !== $passwd_R) {
            $err = "Las Contraseñas no coinciden";
        } elseif (!passwdValida($passwd)) {
            $err = "La Contraseña no cumple los Requisitos";
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
        $_SESSION["err"] = "<p> Operación Fallida </p>";
    }

    return $result === false;
}

function passwdValida($passwd) {
    if (strlen($passwd) < 8) return false;
    if (!(preg_match("/[A-Z]/", $passwd) && preg_match("/[a-z]/", $passwd))) return false;
    if (!strpbrk($passwd, "0123456789")) return false; 
    if (!preg_match("/[^a-zA-Z0-9\s]/", $passwd)) return false;

    return true;
}

function guardarFoto() {
    if ($_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
        $nombreNuevo = md5(basename($_FILES["foto"]["name"]) . uniqid('', true));
        $extencion = strtolower(pathinfo(basename($_FILES["foto"]["name"]))['extension']);
        $rutaGuardado = "../../Imgs/Fotos_Perfil/" . $nombreNuevo . "." . $extencion;
        $rutaBiblioteca = "../../Imgs/Fotos_Perfil/" . $nombreNuevo . "." . $extencion;

        if (file_exists($rutaGuardado)) {
            $_SESSION["err_Foto"] = "<p>! La Foto no se pudo Guardar !</p>";
            return "false";
        }

        if ($_FILES["foto"]["size"] > 10000000) { // 10 MB
            $_SESSION["err_Foto"] = "<p>! La Imagen supera el limite de 10 MB !</p>";
            return "false";
        }

        if($extencion != "jpg" && $extencion != "png" && $extencion != "jpeg") {
            $_SESSION["err_Foto"] = "<p>! El Fichero no es una Imagen (JPG / PNG / JPEG) !</p>";
            return "false";
        }
        
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaGuardado)) {
            $_SESSION["err_Foto"] = "";
            return $rutaBiblioteca;
        } else {
            $_SESSION["err_Foto"] = "<p>! La Foto no se pudo Guardar !</p>";
            return "false";
        }
    } else {
        return "../../Imgs/Fotos_Perfil/Foto_Base.png";
    }
}
?>