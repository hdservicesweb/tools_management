<?php
include('../header.php');
$link = Conectarse();

if ((isset($_REQUEST['upstar'])) && isset($_REQUEST['uni_id'])) {
    $upstar = $_REQUEST['upstar'];
    $uni_id = $_REQUEST['uni_id'];

    $sqlchangestars = "UPDATE wo set priorizetotal = 'P$upstar' where id = '$uni_id'";
    $updatestars = mysqli_query($link, $sqlchangestars) or die("Something wrong with DB please verify.");
}
if ($search == "") {
    ?>
    <script src="../ajax.js"></script>
    <script>
        var url = "index_view_data.php";
    </script>
    <script>
        $(document).ready(function() {
            $("#success-alert").hide();
            $("#myWish").click(function showAlert() {
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                });
            });
        });
    </script>
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3">
            </div>
            <div class="col-md-3">
                <a href='#' id='returning_wo' class='btn btn-light btn-sm' data-toggle='modal' data-target='#return_wo' onclick='return_wo(this.id)'>

                    <div class="card" style="width: 18rem;">
                        <br>
                        <center>

                            <i class="fa fa-arrow-left" style="color:cadetblue;font-size:80px"></i>
                        </center>
                        <br>
                        <div class="card-body bg-info text-light">
                            <h5 class="card-title">
                                <center>MOVE BACK</center>
                            </h5>
                        </div>

                    </div>
                </a>
            </div>
            <div class="col-md-1">
            </div>
            <div class="col-md-3">
                <a href='#' id='forward_wo' class='btn btn-light btn-sm' data-toggle='modal' data-target='#move_wo' onclick='update_wo(this.id)'>

                    <div class="card" style="width: 18rem;">
                        <br>
                        <center>
                            <i class="fa fa-arrow-right" style="color:green;font-size:80px"></i>
                        </center>

                        <br>
                        <div class="card-body bg-success text-light">
                            <center>
                                <h5 class="card-title"> MOVE FORWARD</h5>
                            </center>
                        </div>

                    </div>
                </a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-7">
                <div class="card">
                    <div class="card-header">READY FOR ASSIGN.</div>
                    <div class="card-body">
                        <div id="contenido">
                            <div name="timediv" id="timediv">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="card">
                    <div class="card-header">General Instructions.</div>
                    <div class="card-body">
                        <p class="text-justify">
                            <i>Use this module to track, transfer and assign a job within the different production areas in the organization.</i>
                            <br>Use any right-arrow in order to move the WO to the next step. Or left arrow to move the WO back against any setback. You should know that wheter the WO is returned to an earlier step it will go to ONHOLD status by default, so you must change the status manually when you want to interact with it again.
                            Different areas or steps:
                            <ol>
                                <li><b>Process for registering a new work instruction.</b>
                                    <a class="btn btn-primary-outline btn-sm text-primary" data-toggle="collapse" href="#step1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-chevron-down"></i></a>
                                    <br>
                                    <div class="collapse multi-collapse" id="step1">Whether you see the WO is in step 1, that means the WO is recently created.</div>
                                </li>
                                <li><b>Post-created approval.</b>
                                    <a class="btn btn-primary-outline btn-sm text-primary" data-toggle="collapse" href="#step2" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-chevron-down"></i></a>
                                    <br>
                                    <div class="collapse multi-collapse" id="step2">The post-creation step is of a complementary type, it refers to a review and scrutiny of the information contained in the BOM to guarantee its optimal displacement during the different production areas.</div>
                                </li>
                                <li><b>Kitting</b>
                                    <a class="btn btn-primary-outline btn-sm text-primary" data-toggle="collapse" href="#step3" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-chevron-down"></i></a>
                                    <br>
                                    <div class="collapse multi-collapse" id="step3">Kitting (STEP 3) Involves a process where separate but related items are grouped, packaged, and supplied together as one unit.</div>
                                </li>
                                <li><b>Ready for assign</b>
                                    <a class="btn btn-primary-outline btn-sm text-primary" data-toggle="collapse" href="#step4" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-chevron-down"></i></a>
                                    <br>
                                    <div class="collapse multi-collapse" id="step4">
                                        After the box has been completed, it is left in the area indicated for its assignment. it is necessary that the status be reviewed before assigning the WO since it should not be on hold.
                                    </div>
                                </li>
                                <li><b>In Process</b>
                                    <a class="btn btn-primary-outline btn-sm text-primary" data-toggle="collapse" href="#step5" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-chevron-down"></i></a>
                                    <br>
                                    <div class="collapse multi-collapse" id="step5">
                                        The work-order has been assigned to a person in charge of carrying out the work, the order is in the production floor.
                                    </div>
                                </li>
                                <li><b>Done</b>
                                    <a class="btn btn-primary-outline btn-sm text-primary" data-toggle="collapse" href="#step6" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-chevron-down"></i></a>
                                    <br>
                                    <div class="collapse multi-collapse" id="step6">
                                        The order has been completed and removed from the production floor pending a visual inspection of the final product, prior to being sent to the quality control area for a more detailed inspection.
                                    </div>
                                </li>
                                <li><b>Quality Control</b>
                                    <a class="btn btn-primary-outline btn-sm text-primary" data-toggle="collapse" href="#step7" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-chevron-down"></i></a>
                                    <br>
                                    <div class="collapse multi-collapse" id="step7">
                                        The order is in quality control area, detailed inspections of assembled components are performed.
                                    </div>
                                </li>
                                <li><b>Packing</b>
                                    <a class="btn btn-primary-outline btn-sm text-primary" data-toggle="collapse" href="#step8" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-chevron-down"></i></a>
                                    <br>
                                    <div class="collapse multi-collapse" id="step8">
                                        The order left the inspection area, it must be processed and packaged to be sent to the customer.
                                    </div>
                                </li>
                                <li><b>Shipped</b>
                                    <a class="btn btn-primary-outline btn-sm text-primary" data-toggle="collapse" href="#step9" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-chevron-down"></i></a>
                                    <br>
                                    <div class="collapse multi-collapse" id="step9">
                                        The order was sent to the customer's facilities. </div>
                                </li>
                            </ol>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    } else {

        $sql = "SELECT wo.*,C.name_customer as NC from wo inner join customers C on wo.customer = C.id 
    where (wo.psc_no like '%" . $search . "%'
         OR wo.picking like '%" . $search . "%'
         OR wo.assy_pn like '%" . $search . "%')
         and position <= '9' 
    order by wo.priorizetotal desc, wo.psc_no asc";


        $records = 'Found: 0 Records.';
        $texto = "";


        $result = mysqli_query($link, $sql) or die("Something wrong with DB please verify.");

        // echo mysqli_num_rows($result);
        if (mysqli_num_rows($result) > 0) {
            // Se recoge el número de resultados
            $records = 'Found: ' . mysqli_num_rows($result) . ' Records';
        } else {
            switch ($search) {
                case '11111':
                    $records = "";
                    echo "<form action='movewo.php' method'get' target='_self'>";

                    echo "<div class='container'>";
                    echo "<center><h1>AUTO ASSIGN PRODUCTION CLOSING WO</h1></center>";
                    echo "<center><h3 class='V-URGENT' style='color:red'>THIS WO WILL BE CONSIDERED CLOSED</h3></center>";
                    echo "<div class= 'row'>";
                    echo "<div class= 'col-6'>";
                    echo "<label>ESCAN WO:</label>";
                    echo "<input type='text' name='wo' id='wo_a' class='form-control' style='background-color: #def;height:80px;font-size:30px;' autocomplete='off' required />";
                    echo "</div>";

                    echo "</div>";
                    echo "</div>";
                    echo "<input type='text' name='saved' id='saved' value='1' readonly hidden />";
                    echo "<input type='text' name='autoprocess' id='autoprocess' value='" . $search . "' readonly hidden />";
                    echo "<br><center><button type='submit' class='btn btn-success'> SUBMIT</button></center>";
                    echo "</form>";
                    echo "<script>       
             setTimeout(function() {
                $('#wo_a').focus();
            }, 500); </script>";
                    break;

                case '55555':
                    $records = "";
                    echo "<form action='movewo.php' method'get' target='_self'>";

                    echo "<div class='container'>";
                    echo "<center><h1>AUTO ASSIGN PRODUCTION STEP</h1></center>";
                    echo "<center><h3>ASIGN EMPLOYEE TO WO</h3></center>";
                    echo "<div class= 'row'>";
                    echo "<div class= 'col-6'>";
                    echo "<label>ESCAN WO:</label>";
                    echo "<input type='text' name='wo' id='wo_a' class='form-control' style='background-color: #def;height:80px;font-size:30px;' autocomplete='off' required />";
                    echo "</div>";
                    echo "<div class= 'col-6'>";
                    echo "<label>ESCAN EMPLOYEE:</label>";
                    echo "<input type='text' name='employee' id='emp_a' class='form-control'  style='background-color: #def;height:80px;font-size:30px;' autocomplete='off' required />";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "<input type='text' name='saved' id='saved' value='1' readonly hidden />";
                    echo "<input type='text' name='autoprocess' id='autoprocess' value='" . $search . "' readonly hidden />";
                    echo "<br><center><button type='submit' class='btn btn-success'> SUBMIT</button></center>";
                    echo "</form>";
                    echo "<script>       
             setTimeout(function() {
                $('#wo_a').focus();
            }, 500); </script>";
                    break;
                case '77777':
                    $records = "";
                    echo "<form action='movewo.php' method'get' target='_self'>";

                    echo "<div class='container'>";
                    echo "<center><h1>AUTO ASSIGN QC STEP 7</h1></center>";
                    echo "<center><h3>ASIGN WO TO QUALITY CONTROL</h3></center>";
                    echo "<div class= 'row'>";
                    echo "<div class= 'col-6'>";
                    echo "<label>ESCAN WO:</label>";
                    echo "<input type='text' name='wo' id='wo_a' class='form-control' style='background-color: #def;height:80px;font-size:30px;' autocomplete='off' required />";
                    echo "</div>";
                    echo "<div class= 'col-6' hidden>";
                    echo "<label>ESCAN EMPLOYEE:</label>";
                    echo "<input type='text' name='employee' id='emp_a' class='form-control'  style='background-color: #def;height:80px;font-size:30px;' value='PRODUCTION' autocomplete='off' required />";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "<input type='text' name='saved' id='saved' value='1' readonly hidden />";
                    echo "<input type='text' name='autoprocess' id='autoprocess' value='" . $search . "' readonly hidden />";
                    echo "<br><center><button type='submit' class='btn btn-success'> SUBMIT</button></center>";
                    echo "</form>";
                    echo "<script>       
                 setTimeout(function() {
                    $('#wo_a').focus();
                }, 500); </script>";
                    break;
                case '99999':
                    $records = "";
                    echo "<form action='movewo.php' method'get' target='_self'>";

                    echo "<div class='container'>";
                    echo "<center><h1>AUTO ASSIGN WO TO STEP 9</h1></center>";
                    echo "<center><h3>ASIGN WO TO SHIPPED STATUS</h3></center>";
                    echo "<div class= 'row'>";
                    echo "<div class= 'col-6'>";
                    echo "<label>ESCAN WO:</label>";
                    echo "<input type='text' name='wo' id='wo_a' class='form-control' style='background-color: #def;height:80px;font-size:30px;' autocomplete='off' required />";
                    echo "</div>";
                    echo "<div class= 'col-6' hidden>";
                    echo "<label>ESCAN EMPLOYEE:</label>";
                    echo "<input type='text' name='employee' id='emp_a' class='form-control'  style='background-color: #def;height:80px;font-size:30px;' value='PRODUCTION' autocomplete='off' required />";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "<input type='text' name='saved' id='saved' value='1' readonly hidden />";
                    echo "<input type='text' name='autoprocess' id='autoprocess' value='" . $search . "' readonly hidden />";
                    echo "<br><center><button type='submit' class='btn btn-success'> SUBMIT</button></center>";
                    echo "</form>";
                    echo "<script>       
                 setTimeout(function() {
                    $('#wo_a').focus();
                }, 500); </script>";
                    break;
                default:
                    $records = "No matches.";
                    break;
            }
        }
        ?>
        <div class='container-fluid'>
            <h5>
                Looking for: <input type="text" value="<?= $search ?>" id="lastsrch" style="border: none; background: transparent;" readonly>
            </h5>
            <p>
                <?= $records ?>
            </p>
        </div>

        <div class="container-fluid">
            <table class="table table-sm table-striped table-bordered table-hover" width="100%" style='font-size:13px;text-align:left'>

                <?php
                    $wodata = mysqli_query($link, $sql) or die("Something wrong with DB please verify.");
                    if ($row = mysqli_num_rows($wodata) > 0) {
                        printf("<tr style='text-align:center'><th>&nbsp;%s</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th></tr>", "<i class='fa fa-hashtag' ></i>", "<i class='fa fa-flag-checkered'></i>", "P / N", "<i class='fa fa-cube'></i>", "WO GENERATED | <i class='fa fa-print'></i>", "DUE DATE | <i class='fa fa-calendar-plus-o'></i>", "<i class='fa fa-line-chart'></i>", "LAST TRANSFER | <i class='fa fa-calendar'></i>", "<i class='fa fa-inbox'></i>", "<i class='fa fa-star'></i>", "<i class='fa fa-eye'></i>");
                    }
                    while ($row = mysqli_fetch_array($wodata)) {
                        $starqty = substr($row["priorizetotal"], -1);
                        $colorstars = "";
                        $staricon = "";
                        $position = $row['position'];

                        $due_date_query = "SELECT DATEDIFF(now(), (select due_date from wo where id = '" . $row['id'] . "' limit 1)) as days";
                        $datedataexe = mysqli_query($link, $due_date_query);
                        $datedata = mysqli_fetch_array($datedataexe);

                        if ($datedata['days'] >= 0) {
                            $urgenclass = "V-URGENT";
                            $dayslate = "  DL: [ " . $datedata['days'] . " ] ";
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
                            $onholdicon = "<a class='btn btn-success btn-sm' href='index?srch=" . $row['psc_no'] . "' onclick='changestatus(" . $row['id'] . ")' id='changestatus1'><i class='fa fa-circle-o bg-success text-white'></i></a>";
                        } else {
                            $newstatus = "ON HOLD";
                            $onholdclass = "text-muted";
                            $onholdicon = "<a class='btn btn-sm btn-warning' href='index?srch=" . $row['psc_no'] . "' onclick='changestatus(" . $row['id'] . ")' id='changestatus0'><i class='fa fa-clock-o bg-warning text-white'></i></a>";
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
                                        $staricon .= "<a href='index?srch=$search&upstar=$i&uni_id=" . $row['id'] . "'><i class='fa fa-star-o' aria-hidden='true' ></i></a>";
                                    }
                                }
                                break;
                            case '2':
                                $colorstars = "green";
                                for ($i = 1; $i < 6; $i++) {
                                    if ($i <=    $starqty) {
                                        $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                                    } else {
                                        $staricon .= "<a href='index?srch=$search&upstar=$i&uni_id=" . $row['id'] . "'><i class='fa fa-star-o' aria-hidden='true' ></i></a>";
                                    }
                                }
                                break;
                            case '3':
                                $colorstars = "orange";
                                for ($i = 1; $i < 6; $i++) {
                                    if ($i <= $starqty) {
                                        $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                                    } else {
                                        $staricon .= "<a href='index?srch=$search&upstar=$i&uni_id=" . $row['id'] . "'><i class='fa fa-star-o' aria-hidden='true' ></i></a>";
                                    }
                                }
                                break;
                            case '4':
                                $colorstars = "orange";
                                for ($i = 1; $i < 6; $i++) {
                                    if ($i <= $starqty) {
                                        $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                                    } else {
                                        $staricon .= "<a href='index?srch=$search&upstar=$i&uni_id=" . $row['id'] . "'><i class='fa fa-star-o' aria-hidden='true' ></i></a>";
                                    }
                                }
                                break;
                            case '5':
                                $colorstars = "red";
                                for ($i = 1; $i < 6; $i++) {
                                    if ($i <= $starqty) {
                                        $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                                    } else {
                                        $staricon .= "<a href='index?srch=$search'><i class='fa fa-star-o' aria-hidden='true' ></i></a>";
                                    }
                                }
                                break;
                            default:
                                # code...
                                break;
                        }

                        $bottonforw = "<a href='#' id='forward_wo," . $row['psc_no'] . "," . $position . "," . $row['id'] . "' data-toggle='modal' data-target='#move_wo' onclick='update_wo(this.id)' class='btn btn-success btn-sm text-white' ><i class='fa fa-arrow-right'></i></a>";
                        $bottonback = "<a href='#' id='forward_wo," . $row['psc_no'] . "," . $position . "," . $row['id'] . "' data-toggle='modal' data-target='#return_wo' onclick='return_wo(this.id)' class='btn btn-info btn-sm text-white'><i class='fa fa-arrow-left'></i></a>";
                        printf("<tr class='$onholdclass'><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td class='$urgenclass'>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", "&nbsp;" . $onholdicon . "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp; <a href='edit_wo?wo=" . $row["id"] . "'><b>" . $row["psc_no"] . "</b></a>",  $row["picking"],  $row["assy_pn"], "<b style='color:$colorstars'>" .  $row["qty"] . "<b>",  $row["printed"], $row["due_date"] . "  |  " . $dayslate, $NEWPOSITION, $row["last_movement"], $row["last_employee"], $staricon, $bottonback . "&nbsp" . $bottonforw);
                    }

                    ?>
            </table>
        </div>

    <?php
        mysqli_free_result($result);
        mysqli_close($link);
    }
    ?>
    <!-- Modal for forward tool -->
    <div class="modal fade" id="move_wo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Moving forward WO.</h6>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="movewo.php" method="get" target="_self" id="move_wo_form" onsubmit="event.preventDefault(); localvalidations();">
                    <div class="modal-body">

                        <h2>WO No.:</h2> <input type="text" name="wo" id="wo_f" class="form-control input-sm" value="" autocomplete="off" required>
                        <br>
                        <h5>
                            <p id="leyenda"></p>
                        </h5>
                        <div class="invalid-feedback">
                            Please provide correct Description No (WO).
                        </div>
                        <div id="employee" hidden>
                            <!-- <div id="employee" hidden> -->
                            <h2>Employee:</h2>
                            <input type="text" id="employee_text" name="employee" class="form-control" value="PRODUCTION" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <!-- //agregar campo realid para dar seguimiento con el ID del registro en la base de datos. -->
                        <input type="text" id="realid" name="realid" hidden readonly>
                        <input type="text" id="saved" name="saved" hidden readonly>

                        <a type="button" class="btn btn-secondary" href="index">Close</a>
                        <button type="submit" id="submitthis" class="btn btn-success"> Forward <i class="fa fa-arrow-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal for back WO -->
    <div class="modal fade" id="return_wo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Moving Back WO.</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="movewo.php" method="get" target="_self" id="return_wo_form" onsubmit="event.preventDefault(); localvalidations_r();">
                    <div class="modal-body">

                        <h2>WO No.:</h2> <input type="text" name="wo" id="wo_r" class="form-control input-sm" value="" autocomplete="off" required>
                        <br>
                        <h5>
                            <p id="leyenda_r"></p>
                        </h5>

                        <div class="invalid-feedback">
                            Please provide correct Description No (WO).
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- //agregar campo realid para dar seguimiento con el ID del registro en la base de datos. -->
                        <input type="text" id="realid_r" name="realid" hidden readonly>
                        <input type="text" id="saved_r" name="saved" hidden readonly>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="submitthis" class="btn btn-info"><i class="fa fa-arrow-left"></i> Return</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        function update_wo(id) {
            process = id;
            var res = process.split(",");
            if (typeof res[1] != 'undefined') {
                document.getElementById("wo_f").value = res[1];
                document.getElementById("realid").value = res[3];
                var nextstep = Number(res[2]) + 1;
                document.getElementById("leyenda").innerHTML = "WO will move to : " + nextstep;
            } else {
                document.getElementById("wo_f").value = "";
            }
            console.log(res[1]);
            setTimeout(function() {
                $('#wo_f').focus();
            }, 500);
        }

        function return_wo(id) {
            process = id;
            var res = process.split(",");
            if (typeof res[1] !== 'undefined') {
                document.getElementById("wo_r").value = res[1];
                document.getElementById("realid_r").value = res[3];
                var nextstep = Number(res[2]) - 1;
                document.getElementById("leyenda_r").innerHTML = "WO will move to : " + nextstep;
            } else {
                document.getElementById("wo_r").value = "";
            }

            setTimeout(function() {
                $('#wo_r').focus();
            }, 500);
        }

        function localvalidations() {
            var aprobado = 0;
            var wo = document.getElementById("wo_f").value;
            var woid = document.getElementById("realid").value;
            if (wo == "" || wo == " " || wo.length <= 5 || isNaN(wo)) {
                document.getElementById("wo_f").classList.add("is-invalid");
                aprobado = 0;

            } else {

                document.getElementById("wo_f").classList.remove("is-invalid");
                if (woid == "") {
                    var worder = wo;
                } else {
                    var worder = woid;
                }

                $.ajax({
                        method: "POST",
                        url: 'viewinfo.php?worder=' + worder,
                    })
                    .done(function(msg) {
                        // alert(msg);
                        if (msg == '4') {
                            var user = prompt("Insert user or employee.");
                            document.getElementById("wo_f").setAttribute("readonly", "yes");

                            if ((user != " ") && (user != "") && (user != null) && (user != undefined)) {
                                document.getElementById("employee_text").value = user;
                                document.getElementById("saved").value = "1";
                                document.getElementById("move_wo_form").submit();
                                aprobado = 1;

                            } else {
                                return;
                            }


                        } else if (msg == 'X') {
                            alert("WO DOESNT EXIST");
                            return;
                        } else {
                            document.getElementById("saved").value = "1";
                            document.getElementById("move_wo_form").submit();
                        }
                        // document.getElementById(divid).innerHTML=xmlHttp.responseText;
                    });

            }

        }

        function localvalidations_r() {
            var aprobado = 0;
            var wo = document.getElementById("wo_r").value;
            if (wo == "" || wo == " " || wo.length <= 5 || isNaN(wo)) {
                document.getElementById("wo_r").classList.add("is-invalid");
                aprobado = 0;

            } else {
                aprobado = 1;
                document.getElementById("wo_r").classList.remove("is-invalid");

            }

            if (aprobado == 1) {
                document.getElementById("saved_r").value = "0";
                document.getElementById("return_wo_form").submit();
            } else {
                return;
            }
        }

        function changestatus(value) {
            var worder = value;
            var newstatus = window.confirm("Do you want to change the current status of this WO?");
            if (newstatus == true) {
                // var worder = document.getElementById("psc_no").value;
                $.ajax({
                        method: "POST",
                        url: 'updatestatus.php?worder=' + worder,
                    })
                    .done(function(msg) {

                        if (msg == 1) {
                            document.getElementById("changestatus1").removeAttribute("hidden");
                            document.getElementById("changestatus0").setAttribute("hidden", "yes");
                        } else {
                            document.getElementById("changestatus0").removeAttribute("hidden");
                            document.getElementById("changestatus1").setAttribute("hidden", "yes");
                        }
                        // document.getElementById(divid).innerHTML=xmlHttp.responseText;
                    });
            }

        }
    </script>
    <?php
    echo "<hr>";

    include('../footer.php');
    ?>