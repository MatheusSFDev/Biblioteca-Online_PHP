<?php
session_start();

if ($_SESSION["emailLogin"] !== $_POST["propietario"]) {
    header("Location: ../Pagina.php");
    exit;
}

$titulo = $_POST["titulo"];
$descripcion = $_POST["descripcion"];
$autor = $_POST["autor"];
$categoria = $_POST["categoria"];
$enlace = $_POST["enlace"];
$ano = $_POST["ano"];
$id = $_POST["id"];

$_SESSION["descripcion"] = $descripcion;

if (datosValidos($titulo, $autor, $categoria, $enlace, $ano)) {
    $caratula = guardarFoto();
} else {
    $caratula = "false";
}

if (datosValidos($titulo, $autor, $categoria, $enlace, $ano) && $caratula != "false") {
    require '../../Conexion_DB.php';

    try {
        $sentencia = $conn->prepare("UPDATE juegos SET 
                                                    titulo = :titulo,
                                                    descripcion = :descripcion,
                                                    autor = :autor,
                                                    caratula = :caratula,
                                                    categoria = :categoria,
                                                    enlace = :enlace,
                                                    ano = :ano
                                    WHERE id = :id ");

        $sentencia->bindParam(":titulo", $titulo);
        $sentencia->bindParam(":descripcion", $descripcion);
        $sentencia->bindParam(":autor", $autor);
        $sentencia->bindParam(":caratula", $caratula);
        $sentencia->bindParam(":categoria", $categoria);
        $sentencia->bindParam(":enlace", $enlace);
        $sentencia->bindParam(":ano", $ano);
        $sentencia->bindParam(":id", $id);

        $sentencia->execute();

        $conn = null;

        $nombreLogin = $_SESSION["nombreLogin"];
        $emailLogin = $_SESSION["emailLogin"];
        session_destroy();
        session_start();
        $_SESSION["nombreLogin"] = $nombreLogin;
        $_SESSION["emailLogin"] = $emailLogin;

        header("Location: ../Juego.php?id=" . $id);
        exit;
    } catch (PDOException $ex) {
        $_SESSION["err_Try"] = "<p>Operación Fallida</p>";
        header("Location: modificarJuego.php?id=" . $id);
        exit;
    }
} else {
    header("Location: modificarJuego.php?id=" . $id);
    exit;
}

function datosValidos($titulo, $autor, $categoria, $enlace, $ano) {
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

    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $enlace) && $enlace != "") {
        $correcto = false;
        $_SESSION["enlace"] = "";
        $_SESSION["err_enlace"] = "<p>! Debes introducir una enlace Valida !</p>";
    } else {
        $_SESSION["enlace"] = $enlace;
        $_SESSION["err_enlace"] = "";
    }

    if ((int) $ano < 1950 && $ano != "") {
        $correcto = false;
        $_SESSION["ano"] = "";
        $_SESSION["err_ano"] = "<p>! El ano debe ser posterior o igual a 1950 !</p>";
    } else {
        $_SESSION["ano"] = $ano;
        $_SESSION["err_ano"] = "";
    }

    return $correcto;
}

function guardarFoto() {
    if ($_FILES["caratula"]["error"] === UPLOAD_ERR_OK) {
        $nombreNuevo = md5(basename($_FILES["caratula"]["name"]) . $_SESSION["emailLogin"] . uniqid('', true));
        $extencion = strtolower(pathinfo(basename($_FILES["caratula"]["name"]))['extension']);
        $rutaGuardado = "../../../Imgs/Caratulas/" . $nombreNuevo . "." . $extencion;
        $rutaBiblioteca = "../../Imgs/Caratulas/" . $nombreNuevo . "." . $extencion;

        if (file_exists($rutaGuardado)) {
            $_SESSION["err_Caratula"] = "<p>! La Foto no se pudo Guardar !</p>";
            return "false";
        }

        if ($_FILES["caratula"]["size"] > 524288) { // 512 KB
            $_SESSION["err_Caratula"] = "<p>! La Imagen supera el limite de 512 KB !</p>";
            return "false";
        }

        if($extencion != "jpg" && $extencion != "png" && $extencion != "jpeg") {
            $_SESSION["err_Caratula"] = "<p>! El Fichero no es una Imagen (JPG / PNG / JPEG) !</p>";
            return "false";
        }
        
        if (move_uploaded_file($_FILES["caratula"]["tmp_name"], $rutaGuardado)) {
            $_SESSION["err_Caratula"] = "";

            if ($_POST["ruta"] != "../../Imgs/Caratulas/Caratula_Base.png") {
                unlink("../" . $_POST["ruta"]);
            }
            
            return $rutaBiblioteca;
        } else {
            $_SESSION["err_Caratula"] = "<p>! La Foto no se pudo Guardar !</p>";
            return "false";
        }
    } else {
        return $_POST["ruta"];
    }
}
?>