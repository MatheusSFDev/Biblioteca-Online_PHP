<?php
session_start(); 

if (isset($_SESSION["nombreLogin"])) {
    header("location: PHP/Biblioteca/Pagina.php");
    exit;
} else {
    header("location: PHP/Login/Login.php");
    exit;
}
?>