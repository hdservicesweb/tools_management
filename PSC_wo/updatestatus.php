<?php
include('../conection.php');
date_default_timezone_set('America/Los_Angeles');
$link = Conectarse();
$executetime = date ('Y-m-d H:i:s');
if(isset($_REQUEST['worder'])){
    $worder = $_REQUEST['worder'];
    $sqlprev = "SELECT status from wo where psc_no = '$worder'";
    // echo $sqlprev;
    $wodata = mysqli_query($link, $sqlprev);
    $actualstatus = mysqli_fetch_array($wodata);
    $status = $actualstatus['status'];
    
    if ($status == '1'){
        $SQL = "UPDATE wo set status = '0' where psc_no = '$worder'";
        $update = mysqli_query($link, $SQL);
        echo "0";
        //  -->> VITACORA   
        $sqladdingtracking = "INSERT into wo_process (id,wo,date,user,process) values (NULL,'$worder','$executetime','TO ON HOLD','WO STATUS CHANGED')";
        $executeV = mysqli_query($link, $sqladdingtracking);
        //  -->> VITACORA 
    }else{
        $SQL = "UPDATE wo set status = '1' where psc_no = '$worder'";
        $update = mysqli_query($link, $SQL);
        echo "1";
                //  -->> VITACORA   
                $sqladdingtracking = "INSERT into wo_process (id,wo,date,user,process) values (NULL,'$worder','$executetime','TO IN PROCESS','WO STATUS CHANGED')";
                $executeV = mysqli_query($link, $sqladdingtracking);
                //  -->> VITACORA 
    }
   
}
