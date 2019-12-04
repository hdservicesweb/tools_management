<?php
include("../header.php");
$link = Conectarse();
$executetime = date("Y-m-d H:i:s");
$timetosee = 1500;
$pagina_reg = "index";
// Si la entrada es para guardar un cambio
if ((isset($_REQUEST['saved']))) {
    //SI EL PROCESO ES 1, ES DECIR AVANZAR LA WO

    if ($_REQUEST['saved'] == 1) {
        echo "PROCESS: Moving Forward...<br>";
        if (isset($_REQUEST['wo'])) {
            $wo = $_REQUEST['wo'];
            //execute query to know if the string is an existent WO.
            $sqlexist = "SELECT COUNT(id) as located , `status`,`position` from wo where psc_no = '$wo'";
            $readexist = mysqli_query($link, $sqlexist);
            $exeexist = mysqli_fetch_array($readexist);

            if (isset($_REQUEST['employee'])) {

                $tempemployeenum = trim($_REQUEST['employee']);
                if (is_numeric($tempemployeenum)) {
                    $queryname = "SELECT name from employes where employ_num = '$tempemployeenum'";
                    $getname = mysqli_query($link, $queryname);
                    $namereal = mysqli_fetch_array($getname);

                    if (isset($namereal['name'])) {
                        $employee = $namereal['name'];
                    } else {
                        $employee = "UNKNOWN";
                    }
                } else {
                    $employee = $_REQUEST['employee'];
                    //SI EL NOMBRE DEL EMPLEADO ES PRODUCTION NO SIRVE DE NADA COMO DATO EN LA WO, SE AGREGA INFORMACION RELACIONADA CON LA PROCEDENCIA DE LA WO
                    if ($employee == "PRODUCTION") {
                        $actualposition =   $exeexist['position'];
                        switch ($actualposition) {
                            case '1':
                                $employee = "FROM STEP 1";
                                break;
                            case '2':
                                $employee = "FROM: A(2) APPROVING";
                                break;
                            case '3':
                                $employee = "FROM: A(3) KITTING";
                                break;
                            case '4':
                                $employee = "FROM: A(4) ASSIGNING";
                                break;
                            case '5':
                                $employee = "FROM: A(5) IN-PROCESS";
                                break;
                            case '6':
                                $employee = "FROM: A(6) DONE";
                                break;
                            case '7':
                                $employee = "FROM: A(7) QC";
                                break;
                            case '8':
                                $employee = "FROM: A(8) PACKING";
                                break;
                            case '9':
                                $employee = "FROM: A(9) SHIPPING";
                                break;
                            case '10':
                                $employee = "FROM: A(10) CUSTOMER";
                                break;
                            default:
                                $employee = "PROCESSING";
                                break;
                        }
                    } else {
                        $actualposition =   $exeexist['position'];
                    }
                }
            } else {
                $employee = "EDITED";
            }
            // http://127.0.0.1/PSC_wo/movewo.php?wo=123456&emp_a=+30077+&saved=1&autoprocess=55555
            if (isset($_REQUEST['autoprocess'])) {
                if ($_REQUEST['autoprocess'] != '11111') {
                    $autoposition = substr($_REQUEST['autoprocess'], -1);
                } else {
                    $autoposition = 10;
                    $employee = "CLOSED WO";
                }

                $quitahold = "UPDATE wo set status = 1 where psc_no = '$wo'";
                mysqli_query($link, $quitahold);
                $pagina_reg .= "?srch=" . $_REQUEST['autoprocess'];
            }




            //IF WO EXIST
            if ($exeexist['located'] == 1) {
                //IF WO NO SE ENCUENTRA EN ESTADO ON HOLD
                if ($exeexist['status'] != '0') {
                    if (isset($autoposition)) {
                        $flag = " (A: " . $autoposition . ")";
                        if ($autoposition == '11') {
                            $sqlqueryforwared = "UPDATE wo set status = 0, position = $autoposition , last_movement = CURRENT_TIMESTAMP, last_employee = '$employee' where psc_no = '$wo'";
                        } else {
                            $sqlqueryforwared = "UPDATE wo set status = 1, position = $autoposition , last_movement = CURRENT_TIMESTAMP, last_employee = '$employee' where psc_no = '$wo'";
                        }
                    } else {
                        $actualposition =   $exeexist['position'];
                        //PROCESO PARA MARCAR LA WO CON POSICION ACTUAL Y ANTERIOR
                        switch ($actualposition) {
                            case '1':
                                $flag = " (APPROVING)";
                                break;
                            case '2':
                                $flag = " (KITTING)";
                                break;
                            case '3':
                                $flag = " (ASSIGNING)";
                                break;
                            case '4':
                                $flag = " (IN PROCESS)";
                                break;
                            case '5':
                                $flag = " (DONE!)";
                                break;
                            case '6':
                                $flag = " (QC)";
                                break;
                            case '7':
                                $flag = " (PACKING)";
                                break;
                            case '8':
                                $flag = " (SHIPPING)";
                                break;
                            case '9':
                                $flag = " (SHIPPED)";
                                break;
                            case '10':
                                $flag = " (CLOSED)";
                                break;
                            default:
                                $flag = "";
                                break;
                        }


                        $sqlqueryforwared = "UPDATE wo set status = 1, position = position + 1 , last_movement = CURRENT_TIMESTAMP, last_employee = '$employee' where psc_no = '$wo'";
                    }

                    //echo "<br>". $sqlqueryforwared;
                    //IF QUERY HAS BEEN EXECUTED CORRECTLY WE SEND NOTIFICATION THAN IS SAVED
                    if (mysqli_query($link, $sqlqueryforwared)) {
                        echo "DONE!";
                        $timetosee = 3000;
                        $varunique = "<CENTER><img src='images/next.jpg'  height='100%'><h1>WO: " . $wo . " MOVED FORWARD CORRECTLY.</h1><br>
                        You'll be redirected in:<div id='tiemporestante'></div><br>
                        <h2>Go to this WO: <a href='index?srch=" . $wo . "'>" . $wo . "</a></h2>
                        </CENTER>";
                        //CUANDO GUARDA SE DECIDE A DONDE REGRESAR, SI VIENE DE UN PROCESO AUTOMATICO O HACIA LA BUSQUEDA DE LA WO
                        if (isset($autoposition)) {

                            switch ($autoposition) {
                                case '11':
                                    $labelforvitacora = "CLOSE PROCESS";
                                    break;
                                case '5':
                                    $labelforvitacora = "WORK IN PROCESS";
                                    break;
                                case '7':
                                    $labelforvitacora = "QUALITY INSPECTION";
                                    break;
                                default:
                                    $labelforvitacora = "WO MOVED FORWARD" . $flag;
                                    break;
                            }
                            $pagina_reg = "index?srch=" . $_REQUEST['autoprocess'];
                        } else {
                            $labelforvitacora = "FORWARDED" . $flag;
                            $pagina_reg .= "?srch=" . $wo;
                        }

                        //  -->> VITACORA   
                        $sqladdingtracking = "INSERT into wo_process (id,wo,date,user,process) values (NULL,'$wo','$executetime','$employee','$labelforvitacora')";
                        $executeV = mysqli_query($link, $sqladdingtracking);
                        //  -->> VITACORA 
                    }
                } else {
                    echo "PROBLEM DETECTED!";
                    $timetosee = 5000;


                    // SI LA ORDEN ESTA CERRADA ON HOLD, Y POSITION 11
                    if ($exeexist['position'] == '11') {
                        $varunique = "<CENTER><img src='images/stop.jpeg'  width='150px'><h1>WO: " . $wo . " IS 'CLOSED' <br> PLEASE VERIFY.</h1>
                    <br>
                    You'll be redirected in:<div id='tiemporestante'></div>
                    <br>";
                    } else {
                        $varunique = "<CENTER><img src='images/warning.png'  width='150px'><h1>WO: " . $wo . " IS 'ON HOLD' <br> PLEASE VERIFY AND TRY AGAIN.</h1>
                    <br>
                    You'll be redirected in:<div id='tiemporestante'></div>
                    <br> <h1>VIEW WO DATA: <a href='edit_wo?wo=" . $wo . "'><i class='fa fa-arrow-right'></i></a></h1></CENTER>";
                    }
                }
            }
            //IF WO DOESN'T EXIST
            else {
                $timetosee = 5000;
                $varunique = "<CENTER><img src='images/error.jpg'  height='100%'><h1>WARNING - WO : " . $wo . " NO LOCATED.<br>
                You'll be redirected in:<div id='tiemporestante'></div><BR>PLEASE VERIFY ENTERED WO NUMBER.</h1></CENTER>";
            }
        } else {
            $timetosee = 5000;
            $varunique = "<CENTER><img src='images/error.jpg'  height='100%'><h1>ERROR - VARIABLE WO No. <BR>WAS NOT DETECTED.</h1><br>
            You'll be redirected in:<div id='tiemporestante'></div></CENTER>";
        }
    } //SI EL PROCESO ES DIFERENTE de 1 ES DECIR RETROCEDER WO
    elseif ($_REQUEST['saved'] == 0) {
        echo "RETURNING WO... <br>";
        if (isset($_REQUEST['wo'])) {
            $wo = $_REQUEST['wo'];

            if (isset($_REQUEST['employee'])) {
                $employee = $_REQUEST['employee'];
            } else {
                $employee = "PROCESSING";
            }

            //execute query to know if the string is an existent WO.
            $sqlexist = "SELECT COUNT(id) as located, `status`,`position` from wo where psc_no = '$wo'";
            $readexist = mysqli_query($link, $sqlexist);
            $exeexist = mysqli_fetch_array($readexist);
            //IF WO EXIST
            if ($exeexist['located'] == 1) {
                if ($exeexist['status'] != '0') {

                    $sqlqueryforwared = "UPDATE wo set status = 0, position = position - 1 , last_movement = CURRENT_TIMESTAMP, last_employee = '$employee' where psc_no = '$wo'";
                    //echo "<br>". $sqlqueryforwared;
                    //IF QUERY HAS BEEN EXECUTED CORRECTLY WE SEND NOTIFICATION THAN IS SAVED
                    if (mysqli_query($link, $sqlqueryforwared)) {
                        echo "DONE!";
                        $varunique = "<CENTER><img src='images/back.jpg'  height='100%'><h1>WO: " . $wo . " MOVED BACK CORRECTLY.</h1>
                        You'll be redirected in:<div id='tiemporestante'></div><br>
                        <h2>Go to this WO: <a href='index?srch=" . $wo . "'>" . $wo . "</a></h2></CENTER>";
                        $timetosee = 3000;
                        //  -->> VITACORA 
                        $actualposition =   $exeexist['position'];
                        switch ($actualposition) {
                            case '1':
                                $employee = "FROM STEP 1";
                                break;
                            case '2':
                                $employee = "FROM: A(2) APPROVING";
                                break;
                            case '3':
                                $employee = "FROM: A(3) KITTING";
                                break;
                            case '4':
                                $employee = "FROM: A(4) ASSIGNING";
                                break;
                            case '5':
                                $employee = "FROM: A(5) IN-PROCESS";
                                break;
                            case '6':
                                $employee = "FROM: A(6) DONE";
                                break;
                            case '7':
                                $employee = "FROM: A(7) QC";
                                break;
                            case '8':
                                $employee = "FROM: A(8) PACKING";
                                break;
                            case '9':
                                $employee = "FROM: A(9) SHIPPING";
                                break;
                            case '10':
                                $employee = "FROM: A(10) CUSTOMER";
                                break;
                            default:
                                $employee = "PROCESSING";
                                break;
                        }
                        $sqladdingtracking = "INSERT into wo_process (id,wo,date,user,process) values (NULL,'$wo','$executetime','$employee','WO MOVED BACK')";
                        $executeV = mysqli_query($link, $sqladdingtracking);
                        $sqladdingtracking2 = "INSERT into wo_process (id,wo,date,user,process) values (NULL,'$wo','$executetime','WO CHANGED STATUS ON HOLD','DUE LAST MOVEMENT')";
                        $executeV2 = mysqli_query($link, $sqladdingtracking2);
                        //  -->> VITACORA 
                        $pagina_reg .= "?srch=" . $wo;
                    }
                } else {
                    echo "PROBLEM DETECTED!";
                    $varunique = "<CENTER><img src='images/warning.png'  width='150px'><h1>WO: " . $wo . " IS 'ON HOLD' <br> PLEASE VERIFY AND TRY AGAIN.</h1><br>
                    You'll be redirected in:<div id='tiemporestante'></div></CENTER>";
                    $timetosee = 5000;
                }
            }
            //IF WO DOESN'T EXIST
            else {
                $timetosee = 5000;
                $varunique = "<CENTER><img src='images/error.jpg'  height='100%'><h1>WARNING - WO : " . $wo . " NO LOCATED.<BR>PLEASE VERIFY ENTERED WO NUMBER.</h1><br>
                You'll be redirected in:<div id='tiemporestante'></div></CENTER>";
            }
        } else {
            $timetosee = 5000;
            $varunique = "<CENTER><img src='images/error.jpg'  height='100%'><h1>ERROR - VARIABLE WO No. <BR>WAS NOT DETECTED.</h1><br>
            You'll be redirected in:<div id='tiemporestante'></div></CENTER>";
        }
    } else {
        echo "NO ACTION DEFINED";
        $timetosee = 5000;
        $varunique = "<CENTER><img src='images/error.jpg'  height='100%'><h1>ERROR - ACTION. <BR>WAS NOT RECEIVED.</h1><br>
        You'll be redirected in:<div id='tiemporestante'></div></CENTER>";
    }
}
// Si la entrada no es para guardar un cambio
else {
    $timetosee = 500;
    $varunique = "<CENTER><img src='nopass.png' alt='You shall no pass.' width='50%'></CENTER>";
}
?>
                <div class="container">
                    <?php
                    if (isset($varunique)) {
                        echo $varunique;
                    } else { }
                    ?>
                </div>
                <script LANGUAGE="JavaScript">
                    var pagina = "<?php echo $pagina_reg; ?>";
                    var segundos = (<?php echo $timetosee / 1000 ?>);

                    function redireccionar() {
                        location.href = pagina
                    }
                    // alert(segundos);
                    var timeleft = segundos;
                    var downloadTimer = setInterval(function() {
                        document.getElementById("tiemporestante").innerHTML = timeleft + " Seconds";
                        timeleft -= 1;
                        if (timeleft == 0) {
                            clearInterval(downloadTimer);
                            document.getElementById("tiemporestante").innerHTML = "Finished"
                        }
                    }, 900);

                    // document.getElementById("tiemporestante").innerHTML="<?= $timetosee ?>";
                    setTimeout("redireccionar()", <?= $timetosee ?>);
                </script>


                <?php
                include('../footer.php');
                ?>