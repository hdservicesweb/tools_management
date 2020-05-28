<?php
include('../conection.php');
date_default_timezone_set('America/Los_Angeles');
$link = Conectarse();


$SQL_lastrecords = "SELECT TM.*,E.name FROM `time_card_records` TM LEFT JOIN employes E on TM.`employee_id` = E.employ_num where date = CURRENT_DATE() ORDER BY TM.date_time DESC";
$exesqlget_records = mysqli_query($link, $SQL_lastrecords);
$sql_periods = "SELECT id from time_card_periods order by id desc limit 1";
$exesqlget_period = mysqli_query($link, $sql_periods);
$last_peiod = mysqli_fetch_array($exesqlget_period);
echo '<table class="table table-responsive" width="100%">';

while ($last_records = mysqli_fetch_array($exesqlget_records)) {
    echo "<tr>";
    echo "<td>";
   
    echo "<p><b>". $last_records['employee_id']."</b></p>";
    echo "</td>";
    echo "<td>";
    if ($last_records['process'] == 1){
     echo "<i class='fa fa-clock-o text-success'> </i> <b class='text-success'>CLOCK IN</b>";
    }else{
        echo "<i class='fa fa-clock-o text-danger'> </i> <b class='text-success'>CLOCK IN</b>";
    }
    echo "</td>";
    echo "<td>";
   
    echo "<p>". date('m/d/Y', strtotime($last_records['date']))."</p>";
    echo "</td>";
    echo "<td>";
   
    echo "<p>". $last_records['time']."</p>";
    echo "</td>";
    echo "<td>";
    echo "<p> <b>".$last_records['name']."</b></p>";
    echo "</td>";
    echo "<td>";
    echo "<p> <a href='../TCPDF-master/examples/time_card.php?employee_id=".$last_records['employee_id']."&periods=".$last_peiod['id']."' target='_blank'>View TimeCard</a></p>";
    echo "</td>";
    echo "</tr>";
}
echo '</table>';

