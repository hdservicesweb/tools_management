<?php
include('../conection.php');
date_default_timezone_set('America/Los_Angeles');
$link = Conectarse();
$search = "";

$sql = "SELECT wo.*,C.name_customer as NC from wo inner join customers C on wo.customer = C.id 
    where wo.psc_no like '%" . $search . "%'
         OR wo.picking like '%" . $search . "%'
         OR wo.assy_pn like '%" . $search . "%'    
    order by wo.priorizetotal desc";



?>
<div class="container-fluid" id="contenido">
    <div name="timediv" id="timediv">
        <table class="table table-sm table-striped table-bordered table-hover" width="100%" style='font-size:13px;text-align:left'>
            <?php
            $wodata = mysqli_query($link, $sql) or die("Something wrong with DB please verify.");
            if ($row = mysqli_num_rows($wodata) > 0) {
                printf("<tr style='text-align:center'><th>&nbsp;%s</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th></tr>", "<i class='fa fa-hashtag' ></i>", "<i class='fa fa-flag'></i>", "P / N", "<i class='fas fa-cubes'></i>", "WO GENERATED | <i class='fa fa-print'></i>", "DUE DATE | <i class='fa fa-calendar-plus'></i>", "<i class='fas fa-chart-line'></i>", "LAST TRANSFER | <i class='fa fa-calendar'></i>", "<i class='fa fa-inbox'></i>", "<i class='fa fa-star'></i>");
            }
            while ($row = mysqli_fetch_array($wodata)) {
                $starqty = substr($row["priorizetotal"], -1);
                $colorstars = "";
                $staricon = "";
                $position = $row['position'];
                $due_date_query = "SELECT DATEDIFF(now(), (select due_date from wo where psc_no = '" . $row['psc_no'] . "')) as days";
                $datedataexe = mysqli_query($link, $due_date_query);
                $datedata = mysqli_fetch_array($datedataexe);

                if ($datedata['days'] >= 0) {
                    $urgenclass = "V-URGENT";
                    $dayslate = "  DL:[ " . $datedata['days'] . " ] ";
                } else {
                    if ($datedata['days'] <= -3) {
                        $urgenclass = "";
                    } else {
                        $urgenclass = "V-IMPORTANT";
                    }
                    $dayslate = "";
                }


                //ASIGNA EL ESTATUS ON HOLD O CORRIENDO
                if ($row['status'] == 1) {
                    $newstatus = "RUNNING";
                    $onholdclass = "";
                    $onholdicon = "<i class='fa fa-check'></i>";
                } else {
                    $newstatus = "ON HOLD";
                    $onholdclass = "text-muted";
                    $onholdicon = "<i class='fa fa-clock'></i>";
                }


                // swith para escribir la posicion y estado actual de la WO
                switch ($position) {
                    case '1':
                        $NEWPOSITION = "CREATING WO";
                        break;
                    case '2':
                        $NEWPOSITION = "MOVED to: " . $position;

                        break;
                    default:
                        $NEWPOSITION = "MOVED to: " . $position;
                        break;
                }


                //switch para poner las estrellas de prioridad
                switch ($starqty) {
                    case '1':
                        $colorstars = "green";
                        for ($i = 1; $i < 6; $i++) {
                            if ($i <= $starqty) {
                                $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                            } else {
                                $staricon .= "<i class='far fa-star text-muted' aria-hidden='true' ></i>";
                            }
                        }
                        break;
                    case '2':
                        $colorstars = "green";
                        for ($i = 1; $i < 6; $i++) {
                            if ($i <=    $starqty) {
                                $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                            } else {
                                $staricon .= "<i class='far fa-star text-muted' aria-hidden='true' ></i>";
                            }
                        }
                        break;
                    case '3':
                        $colorstars = "orange";
                        for ($i = 1; $i < 6; $i++) {
                            if ($i <= $starqty) {
                                $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                            } else {
                                $staricon .= "<i class='far fa-star text-muted' aria-hidden='true' ></i>";
                            }
                        }
                        break;
                    case '4':
                        $colorstars = "orange";
                        for ($i = 1; $i < 6; $i++) {
                            if ($i <= $starqty) {
                                $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                            } else {
                                $staricon .= "<i class='far fa-star text-muted' aria-hidden='true' ></i>";
                            }
                        }
                        break;
                    case '5':
                        $colorstars = "red";
                        for ($i = 1; $i < 6; $i++) {
                            if ($i <= $starqty) {
                                $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                            } else {
                                $staricon .= "<a href='#'><i class='far fa-star' aria-hidden='true' ></i></a>";
                            }
                        }
                        break;
                    default:
                        # code...
                        break;
                }



                printf("<tr class='$onholdclass'><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td class='$urgenclass'>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", "&nbsp;" . $onholdicon . "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp; " . $row["psc_no"],  $row["picking"],  $row["assy_pn"], "<b style='color:$colorstars'>" .  $row["qty"] . "<b>",  $row["printed"], $row["due_date"] . "  |  " . $dayslate, $NEWPOSITION, $row["last_movement"], $row["last_employee"], $staricon);
            }

            ?>
        </table>
    </div>
</div>