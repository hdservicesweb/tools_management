<?php
include('../conection.php');
$link = Conectarse();
if (isset($_REQUEST['worder'])) {
    $woid = $_REQUEST['worder'];
    //CONSULTA PARA CONTAR CUANTOS REGISTROS SE ENCONTRARON CON EL VALOR PROPORCIONADO
    $sqlexist = "SELECT COUNT(id) as located from wo where id = '$woid'";
    
    $readexist = mysqli_query($link, $sqlexist);
    $exeexist = mysqli_fetch_array($readexist);
    
    switch ($exeexist['located']) {
        case '0':
            
            $sqlexist2 = "SELECT COUNT(id) as located from wo where psc_no = '$woid'";
            $readexist2 = mysqli_query($link, $sqlexist2);
            $exeexist2 = mysqli_fetch_array($readexist2);
           // echo $sqlexist2;
            $segundabusqueda = $exeexist2['located'];
            if ($segundabusqueda == '1') {
                $sqlquery = "SELECT position from wo where psc_no = '$woid'";
                $executeV = mysqli_query($link, $sqlquery);
                $row = mysqli_fetch_array($executeV);
                echo $row['position'];
            } elseif ($segundabusqueda <= '0') {
                echo "X";
            } else {
                echo "R";
            }
            break;
        case '1':
            $sqlquery = "SELECT position from wo where id = '$woid'";
            $executeV = mysqli_query($link, $sqlquery);
            $row = mysqli_fetch_array($executeV);
            echo $row['position'];
            break;
        default:
            echo "R";
            break;
    }
} else {echo "R"; }
