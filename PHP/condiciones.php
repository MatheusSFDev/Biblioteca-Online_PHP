<?php
$passwd = $_GET["p"];
$verificacion = array(
    "minCaract" => 1,
    "mayusMins" => 1,
    "numsOblig" => 1,
    "espcCarac" => 1
);

if (strlen($passwd) < 8) $verificacion["minCaract"] = 0;
if (!(preg_match("/[A-Z]/", $passwd) && preg_match("/[a-z]/", $passwd))) $verificacion["mayusMins"] = 0;
if (!strpbrk($passwd, "0123456789")) $verificacion["numsOblig"] = 0; 
if (!preg_match("/[^a-zA-Z0-9\s]/", $passwd)) $verificacion["espcCarac"] = 0;

echo json_encode($verificacion);
?>