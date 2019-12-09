<?php
include('../conection.php');
$link = Conectarse();
if(isset($_REQUEST['worder'])){
    $woid = $_REQUEST['worder'];

    $sqlquery = "SELECT * from wo where id = '$woid'";
    $executeV = mysqli_query($link, $sqlquery);
    $row = mysqli_fetch_array($executeV);
    echo $row['position'];
}else{
    
}
?>