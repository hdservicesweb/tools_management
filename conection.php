<?php
function Conectarse()
{
    if (!($link = mysqli_connect("localhost", "root", ""))) {
        echo "Error conectando a la base de datos.";
        exit();
    }
    if (!mysqli_select_db($link, "management")) {
        echo "Error seleccionando la base de datos.";
        exit();
    }
    return $link;
}

$mysqli = new mysqli("localhost", "root", "", "management");
