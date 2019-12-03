<?php
include('../conection.php');
$link = Conectarse();
if(isset($_REQUEST['worder'])){
    $wo = $_REQUEST['worder'];

    $sqlquery = "SELECT * from wo where psc_no = '$wo'";
    $executeV = mysqli_query($link, $sqlquery);
    $row = mysqli_fetch_array($executeV);
    echo $row['position'];
}else{
    
}
?>