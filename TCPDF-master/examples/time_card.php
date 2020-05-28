<?php
require_once('tcpdf_include.php');
include('../../conection.php');
$link = Conectarse();
$pdf = new TCPDF('P', PDF_UNIT, 'LETTER', true, 'UTF-8', false);

function RestarHoras($hora_entrada,$hora_salida)
{



    $f1 = new DateTime($hora_entrada);
    $f2 = new DateTime($hora_salida);
    $d = $f2->diff($f1);
    // $time_total = $d->format('%h.%i');
    $time_total = $d->format('%h');
    return $time_total;
}



if (isset($_REQUEST['employee_id'])) {
    $employee_id = $_REQUEST['employee_id'];
    $select_data = "SELECT * from employes where employ_num = '$employee_id'";
    $exe_req_data = mysqli_query($link, $select_data);
    $data_employee = mysqli_fetch_array($exe_req_data);
    $employee_name = strtoupper($data_employee['name']);
    $ssn = $data_employee['SSN'];
    $namepdf = strtoupper($employee_name) . ".pdf";
} else {
    $employee_id = "";
    $employee_name = "NO EXIST";
    $ssn = "";
    $namepdf = "TIME_CARD.pdf";
}


$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(false, 0);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetAuthor('Miguel Matus');
$pdf->SetTitle('Certificate');
$pdf->SetMargins(.5, 0, 1, 0);
$pdf->AddPage('P', "");

include("layout_timecard.php");
//FECHAS INICIAN
if (isset($_REQUEST['periods'])) {
    $periods = $_REQUEST['periods'];
    $sqlselectdate = "SELECT start_date, IFNULL ((SELECT end_date from time_card_periods where id = '$periods' limit 1) ,CURRENT_DATE()) as new_end_date from time_card_periods where id = '$periods'";
    // echo $sqlselectdate;
    $exeget_dates = mysqli_query($link, $sqlselectdate);
    $date_global = mysqli_fetch_array($exeget_dates);
    $date1 = $date_global[0];
    $date2 = $date_global[1];
} else {
    $periods = "";
    $date1 = "";
    $date2 = "";
}
if (($date1 != "")&&($date2 != "")){
    $pdf->MultiCell($pdf->getPageWidth(), 12, date("m/d/Y", strtotime($date1)), 0, 'L', 0, 0, 125, 20, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, date("m/d/Y", strtotime($date2)), 0, 'L', 0, 0, 170, 20, 12);
}


//DIAS DE LA SEMANA EN LAS TRES TABLAS
$day[0] = "Sunday";
$day[1] = "Monday";
$day[2] = "Tuesday";
$day[3] = "Wednesday";
$day[4] = "Thursday";
$day[5] = "Friday";
$day[6] = "Saturday";

$info_pos = 58;
$tab_day = 58;

//PRINT EMPLOYEE DATA:
$pdf->SetFont('helvetica', '', 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, $employee_name, 0, 'L', 0, 0, 55, 30, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, $ssn, 0, 'L', 0, 0, 70, 36, 12);

$pdf->SetFont('helvetica', 'B', 10);
//PRINT EMPLOYEE DATA:

for ($i = 0; $i < 3; $i++) {
    for ($m = 0; $m < 7; $m++) {
        $pdf->MultiCell($pdf->getPageWidth(), 12, $day[$m], 0, 'L', 0, 0, 15, $tab_day, 12);

        $tab_day = $tab_day + 6;
    }
    $tab_day = $tab_day + 23;
    $info_pos = $info_pos + 65;
}
$info_pos = 58;

$pdf->SetFont('helvetica', '', 10);
//PROCEDIMIENTO PARA SABER LA FECHA Y EL DIA INICIAL QUE PERMITA HACER ENCAJAR EN LA TABLA DE LOS DIAS
$sqlget_values = "SELECT date from `time_card_records` where date between '$date1' and '$date2' and employee_id = '$employee_id' group by date";
// echo $sqlget_values;
$exesqlget_values = mysqli_query($link, $sqlget_values);
//SELECCIONAMOS LA PRIMERA FECHA DE REGISTRO EN LA BASE DE DATOS QUE SE ENCUENTRA ENTRE LAS FECHA INDICADAS POR EL PERIODO.
$date_inicial = mysqli_fetch_array($exesqlget_values);
//SE GUARDA ESTE VALOR EN DOS VARIABLES PARA SU FUTURO PROCESAMIENTO
$real_start_date = $date_inicial['date'];
$new_start_date = $date1;
//CONTADOR DE DIAS RESTADOS HASTA LLLEGAR AL DOMINGO PROXIMO HACIA ATRAS

//SI LA FECHA NO ES IGUAL A DOMINGO, RESTAMOS UN DIA A LA FECHA PARA REALIZAR LA MISMA COMPARACION HASTA ENCONTRAR EL DOMINGO MAS PROXIMO
while (date('l', strtotime($new_start_date)) != "Sunday") {
    
    // echo $new_start_date;
    $new_start_date = date("Y-m-d", strtotime($new_start_date . "- 1 days"));
    // echo $new_start_date;
  
}
//\\\\\ echo "<br>".$new_start_date;
$tab_day = 58;



//YA SABIENDO CUAL ES LA FECHA DEL DOMINGO ANTERIOR SE ESCRIBEN EN EL FORMATO HACIENDO COINCIDIR LA FECHA CON EL DIA CORRESPONDIENTE
$partial_date = "";

$days = 0;
$total_semana = 0;
$total_global = 0;

for ($i = 0; $i < 3; $i++) {
    for ($m = 0; $m < 7; $m++) {
        $partial_date = date("Y-m-d", strtotime($new_start_date . "+ $days days"));
        $sqlforgetvalores = "SELECT * from `time_card_records` where date = '$partial_date' and employee_id = '$employee_id'";
        $exe_get_values = mysqli_query($link, $sqlforgetvalores);
        $registro_diarios = 0;
        while ($get_values = mysqli_fetch_array($exe_get_values)) {
            if ((date("Y-m-d", strtotime($new_start_date . "+ $days days")) >= $date1) && (date("Y-m-d", strtotime($new_start_date . "+ $days days")) <= $date2)){
                if ($get_values['process'] == 1) {
                    $hora_entrada= $get_values['time'];
                    $pdf->MultiCell($pdf->getPageWidth(), 12,$get_values['time'] , 0, 'L', 0, 0, 60, $tab_day, 12);
                   $registro_diarios ++;
                } elseif ($get_values['process'] == 2) {
                    $hora_salida = $get_values['time'];
                    $pdf->MultiCell($pdf->getPageWidth(), 12,$get_values['time'] , 0, 'L', 0, 0, 77, $tab_day, 12);
                    $registro_diarios ++;
                    
                    $tiempo_total = RestarHoras($hora_entrada,$hora_salida);
                    
                        $pdf->MultiCell($pdf->getPageWidth(), 12, $tiempo_total, 0, 'L', 0, 0, 167, $tab_day, 12);
                 
                } else {
                    $pdf->MultiCell($pdf->getPageWidth(), 12, "NO TIME", 0, 'L', 0, 0, 93, $tab_day, 12);
                }
                if($registro_diarios == 2){
                     $total_semana = $total_semana + 8;
                    //$total_semana = $total_semana + $tiempo_total;
                    $registro_diarios=0;
                }
                
            }
            

        }

        if ((date("Y-m-d", strtotime($new_start_date . "+ $days days")) >= $date1) && (date("Y-m-d", strtotime($new_start_date . "+ $days days")) <= $date2) && ($m != 0) && ($m != 6)) {


            $pdf->MultiCell($pdf->getPageWidth(), 12, date('m/d/Y', strtotime($partial_date)), 0, 'L', 0, 0, 39, $tab_day, 12);
        } else {
            $pdf->MultiCell($pdf->getPageWidth(), 12, " ", 0, 'L', 0, 0, 39, $tab_day, 12);
        }
        $days++;
        $tab_day = $tab_day + 6;
        
    }
    if ($total_semana != 0){
        $pdf->MultiCell($pdf->getPageWidth(), 12, $total_semana, 0, 'L', 0, 0, 167, $tab_day, 12);
        $total_global = $total_global + $total_semana;
        $total_semana = 0;
    }else{
        $pdf->MultiCell($pdf->getPageWidth(), 12, '', 0, 'L', 0, 0, 167, $tab_day, 12);

    }
    $tab_day = $tab_day + 23;

}
if ($total_global != 0){
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->MultiCell($pdf->getPageWidth(), 12, $total_global, 0, 'L', 0, 1, 167, $tab_day-4, 12);
    $total_global = 0;
}else{
    $pdf->MultiCell($pdf->getPageWidth(), 12, '', 0, 'L', 0, 1, 167, $tab_day-4, 12);

}


$pdf->Output($namepdf, 'I');
