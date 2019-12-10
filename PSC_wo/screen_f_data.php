<?php
include('../conection.php');
date_default_timezone_set('America/Los_Angeles');
$link = Conectarse();
$search = "";

$sql = "SELECT wo.*,C.name_customer as NC from wo inner join customers C on wo.customer = C.id 
    where (wo.psc_no like '%" . $search . "%'
         OR wo.picking like '%" . $search . "%'
         OR wo.assy_pn like '%" . $search . "%'  )
         and position <= '10'  
    order by wo.priorizetotal desc, wo.due_date asc";



?>

        <table class="table table-sm table-striped table-bordered table-hover" width="100%" style='font-size:13px;text-align:left'>
            <?php
            $wodata = mysqli_query($link, $sql) or die("Something wrong with DB please verify.");
            if ($row = mysqli_num_rows($wodata) > 0) {
                printf("<tr style='text-align:center'><th>&nbsp;%s</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th></tr>", "<i class='fa fa-hashtag' ></i>", "<i class='fa fa-flag'></i>", "P / N", "Qty", "WO GENERATED | <i class='fa fa-print'></i>", "DUE DATE | <i class='fa fa-calendar-plus'></i>", "<i class='fa fa-line-chart'></i>", "LAST TRANSFER | <i class='fa fa-calendar'></i>", "<i class='fa fa-inbox'></i>", "<i class='fa fa-star'></i>");
            }
            while ($row = mysqli_fetch_array($wodata)) {
                $starqty = substr($row["priorizetotal"], -1);
                $colorstars = "";
                $staricon = "";
                $position = $row['position'];
                $due_date_query = "SELECT DATEDIFF(now(), (select due_date from wo where psc_no = '" . $row['psc_no'] . "' order by due_date desc limit 1)) as days";
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


                //ASIGNA EL ESTATUS ON HOLD O RUNNING
                if ($row['status'] == 1) {
                    $newstatus = "RUNNING";
                    $onholdclass = "";
                    $onholdicon = "<i class='fa fa-check bg-success text-white'></i>";
                    if (($row["last_employee"] != "PRODUCTION") && (substr($row["last_employee"],0,3) != "NEW")&& ($row["last_employee"] != "PROCESSING")&& (substr($row["last_employee"],0,5) != "FROM:")){
                        $tempstatus = "<i class='fa fa-user'></i> : <small><b> ".strtoupper($row["last_employee"])."</b></small>";
                    }else{
                        $tempstatus = $row["last_employee"];
                    }
                    
                } else {
                    $newstatus = "ON HOLD";
                    $onholdclass = "text-muted";
                    $onholdicon = "<i class='fa fa-clock-o bg-warning text-white'></i>";
                    $tempstatus = "ON HOLD";
                }


                // swith para escribir la posicion y estado actual de la WO
                switch ($position) {
                    case '1':
                        $NEWPOSITION = "CREATING WO";
                        break;
                    case '2':
                        $positiontext = "APPROVING";
                        $NEWPOSITION = "A ($position) : " . $positiontext;
                        break;
                    case '3':
                        $positiontext = "KITTING";
                        $NEWPOSITION = "A ($position) : " . $positiontext;
                        break;
                    case '4':
                        $positiontext = "ASSIGNING EMPLOYEE";
                        $NEWPOSITION = "A ($position) : " . $positiontext;
                        break;
                    case '5':
                        $positiontext = "IN PROCCESS";
                        $NEWPOSITION = "A ($position) : " . $positiontext;
                        break;
                    case '6':
                        $positiontext = "DONE";
                        $NEWPOSITION = "A ($position) : " . $positiontext;
                        break;
                    case '7':
                        $positiontext = "QUALITY INSPECT.";
                        $NEWPOSITION = "A ($position) : " . $positiontext;
                        break;
                    case '8':
                        $positiontext = "PACKING";
                        $NEWPOSITION = "A ($position) : " . $positiontext;
                        break;
                    case '9':
                        $positiontext = "SHIPPED";
                        $NEWPOSITION = "A ($position) : " . $positiontext;
                        break;
                    case '10':
                        $positiontext = "CLOSED";
                        $NEWPOSITION = "A ($position) : " . $positiontext;
                        break;
                    default:
                        $NEWPOSITION = "MOVED to: CLOSED + " . $position;
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
                                $staricon .= "<i class='fa fa-star-o text-muted' aria-hidden='true' ></i>";
                            }
                        }
                        break;
                    case '2':
                        $colorstars = "green";
                        for ($i = 1; $i < 6; $i++) {
                            if ($i <=    $starqty) {
                                $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                            } else {
                                $staricon .= "<i class='fa fa-star-o text-muted' aria-hidden='true' ></i>";
                            }
                        }
                        break;
                    case '3':
                        $colorstars = "orange";
                        for ($i = 1; $i < 6; $i++) {
                            if ($i <= $starqty) {
                                $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                            } else {
                                $staricon .= "<i class='fa fa-star-o text-muted' aria-hidden='true' ></i>";
                            }
                        }
                        break;
                    case '4':
                        $colorstars = "orange";
                        for ($i = 1; $i < 6; $i++) {
                            if ($i <= $starqty) {
                                $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                            } else {
                                $staricon .= "<i class='fa fa-star-o text-muted' aria-hidden='true' ></i>";
                            }
                        }
                        break;
                    case '5':
                        $colorstars = "red";
                        for ($i = 1; $i < 6; $i++) {
                            if ($i <= $starqty) {
                                $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                            } else {
                                $staricon .= "<a href='#'><i class='fa fa-star-o' aria-hidden='true' ></i></a>";
                            }
                        }
                        break;
                    default:
                        # code...
                        break;
                }



                printf("<tr class='$onholdclass'><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td class='$urgenclass'>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", "&nbsp;" . $onholdicon . "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;<a href='edit_wo?wo=" . $row["id"]."'><b> " . $row["psc_no"]."</b></a>",  $row["picking"],  $row["assy_pn"], "<b style='color:$colorstars'>" .  $row["qty"] . "<b>",  $row["printed"], $row["due_date"] . "  |  " . $dayslate, $NEWPOSITION, $row["last_movement"], $tempstatus, $staricon);
            }

            ?>
        </table>
