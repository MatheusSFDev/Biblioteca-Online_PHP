<?php
session_start();

$titulo = $_POST["titulo"];
$descripcion = $_POST["descripcion"];
$autor = $_POST["autor"];
$categoria = $_POST["categoria"];
$url = $_POST["url"];
$año = $_POST["año"];
$propietario = $_SESSION["emailLogin"];
$ruta_caratula = guardarFoto();

if (datosValidos($titulo, $autor, $categoria, $url, $año) && $ruta_caratula != "false") {
    try {
        $sentencia = $conn->prepare("INSERT INTO juegos(titulo, descripcion, autor, caratula, url, año, propietario) 
                                        VALUE (:titulo, :descripcion, :autor, :caratula, :url, :año, :propietario)");

        $sentencia->bindParam(":titulo", $titulo);
        $sentencia->bindParam(":descripcion", $descripcion);
        $sentencia->bindParam(":autor", $autor);
        $sentencia->bindParam(":caratula", $ruta_caratula);
        $sentencia->bindParam(":url", $url);
        $sentencia->bindParam(":año", $año);
        $sentencia->bindParam(":propietario", $propietario);

        $sentencia->execute();

        $conn = null;
        header("Location: ../Login/Pagina.php");
        exit;
    } catch (PDOException $ex) {
        $_SESSION["err_Try"] = "<p> Operación Fallida </p>";
        header("Location: Registro.php");
        exit;
    }
} else {
    header("Location: nuevoJuego.php");
    exit;
}

function datosValidos($titulo, $autor, $categoria, $url, $año) {
    $correcto = true;

    if (empty($titulo)) {
        $correcto = false;
        $_SESSION["titulo"] = "";
        $_SESSION["err_Titulo"] = "<p>! Debes introducir un Titulo !</p>";
    } else {
        $_SESSION["titulo"] = $titulo;
        $_SESSION["err_Titulo"] = "";
    }

    if (empty($autor)) {
        $correcto = false;
        $_SESSION["autor"] = "";
        $_SESSION["err_Autor"] = "<p>! Debes introducir un Autor !</p>";
    } else {
        $_SESSION["autor"] = $autor;
        $_SESSION["err_Autor"] = "";
    }

    if (empty($categoria)) {
        $correcto = false;
        $_SESSION["categoria"] = "";
        $_SESSION["err_Categoria"] = "<p>! Debes introducir una Categoria !</p>";
    } else {
        $_SESSION["categoria"] = $categoria;
        $_SESSION["err_Categoria"] = "";
    }

    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)) {
        $correcto = false;
        $_SESSION["url"] = "";
        $_SESSION["err_Url"] = "<p>! Debes introducir una URL Valida !</p>";
    } else {
        $_SESSION["url"] = $url;
        $_SESSION["err_Url"] = "";
    }

    if ((int) $año < 1950 && $año != "") {
        $correcto = false;
        $_SESSION["año"] = "";
        $_SESSION["err_Año"] = "<p>! El Año debe ser posterior o igual a 1950 !</p>";
    } else {
        $_SESSION["año"] = $autor;
        $_SESSION["err_Año"] = "";
    }

    return $correcto;
}

function guardarFoto() {
    if ($_FILES["caratula"]["error"] === UPLOAD_ERR_OK) {
        $nombreNuevo = md5(basename($_FILES["caratula"]["name"]) . $_SESSION["emailLogin"] . uniqid('', true));
        $rutaGuardado = "../../Imgs/Caratulas/" . $nombreNuevo . "." . pathinfo(basename($_FILES["caratula"]["name"]), PATHINFO_EXTENSION);
        $rutaBiblioteca = "../../Imgs/Caratulas/" . $nombreNuevo . "." . pathinfo(basename($_FILES["caratula"]["name"]), PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES["caratula"]["tmp_name"], $rutaGuardado)) {
            return $rutaBiblioteca;
        } else {
            $_SESSION["err_Caratula"] = "<p>! La Foto no se pudo Guardar !</p>";
            return "false";
        }
    } else {
        return "../../Imgs/Caratula_Base.png";
    }
}
?>