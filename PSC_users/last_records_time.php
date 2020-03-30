<?php
include('../conection.php');
date_default_timezone_set('America/Los_Angeles');
$link = Conectarse();


$SQL_lastrecords = "SELECT TM.*,E.name FROM `time_card_records` TM LEFT JOIN employes E on TM.`employee_id` = E.employ_num ORDER BY TM.date_time DESC limit 10";
$exesqlget_records = mysqli_query($link, $SQL_lastrecords);

echo ' <table class="table table-responsive ">';

while ($last_records = mysqli_fetch_array($exesqlget_records)) {
    echo "<tr>";
    echo "<td>";
   
    echo "<small>". date('m/d/Y h:i:s', strtotime($last_records['date_time']))."</small>";
    echo "</td>";
    echo "<td>";
    echo "<small>".$last_records['employee_id']." - <b>".$last_records['name']."</b></small>";
    echo "</td>";
    echo "<td>";
    if ($last_records['process'] == 1){
     echo "<i class='fa fa-clock-o text-success'></i>";
    }else{
        echo "<i class='fa fa-clock-o text-danger'></i>";
    }
    echo "</td>";
    echo "</tr>";
}
echo '</table>';

