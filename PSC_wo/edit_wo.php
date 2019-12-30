<?php
include("../header.php");
$link = Conectarse();
$nowtime = date("m/d/Y");
if (isset($_REQUEST['Execute-Time'])) {
    $executetime = $_REQUEST['Execute-Time'];
} else {
    $executetime = date("Y-m-d H:i:s");
}
if ((isset($_REQUEST['saved']))) {
    $saved = $_REQUEST['saved'] + 1;

    $psc_no = $_REQUEST['wo'];
    $woid = $_REQUEST['wo_number'];
    $picking = $_REQUEST['picking'];
    $assy_pn = $_REQUEST['assy_pn'];
    $customer = $_REQUEST['customer'];
    $printed = $_REQUEST['printed'];
    $po = $_REQUEST['po'];
    $qty = $_REQUEST['qty'];
    $due_date = $_REQUEST['due_date'];
    $priorizetotal = $_REQUEST['priorizetotal'];
    $last_employee = $_REQUEST['last_employee'];

    // $note = $_REQUEST['note'];
    // $last_movement = $_REQUEST['last_movement'];
    $position = $_REQUEST['position'];

    $sqlupdate = "UPDATE wo set picking = '$picking', assy_pn = '$assy_pn', customer = '$customer', printed= '$printed', po='$po', qty='$qty', due_date='$due_date', priorizetotal = '$priorizetotal', last_employee = '$last_employee' , position = '$position' where id = '$psc_no'";

    if (($executeV = mysqli_query($link, $sqlupdate)) && ($psc_no != "")) {
        $varalert = 1;
        //  -->> VITACORA   
        $sqladdingtracking = "INSERT into wo_process (id,id_wo,wo,date,user,process) values (NULL,'$psc_no','$woid','$executetime','$last_employee','Update data.')";
        $executeV = mysqli_query($link, $sqladdingtracking);
        //  -->> VITACORA 
    } else {
        $varalert = 0;
    }
} else {
    $saved = 0;
}

if (isset($_REQUEST['wo'])) {
    $wo = $_REQUEST['wo'];

    //BUTTON TEMPORAL PARA PROBAR CONDICION QUE IMPIDE O ADVIERTE CUANDO SE IMPREME MAS DE UNA VEZ
    $sqlcountprinted = "SELECT COUNT(id) as qtyImp from printed where id_wo = '$wo'";
    $countqty = mysqli_query($link, $sqlcountprinted) or die("Something wrong with DB please verify.");
    $qtyimpresed =  mysqli_fetch_array($countqty);
    $manytimes = $qtyimpresed['qtyImp'];


    //FIN DE BOTON
    $sqlloadingdata = "SELECT * from wo where id = '$wo'";

    $wodata = mysqli_query($link, $sqlloadingdata) or die("Something wrong with DB please verify.");
    $row = mysqli_fetch_array($wodata);

    $idheader = "EDIT WO " . $row['psc_no'];
    $psc_no = $row['psc_no'];
    $picking = $row['picking'];
    $assy_pn = $row['assy_pn'];
    $customer = $row['customer'];
    $printed = $row['printed'];
    $po = $row['po'];
    $qty = $row['qty'];
    $due_date = $row['due_date'];
    $newdue_date = strftime('%Y-%m-%dT%H:%M:%S', strtotime($due_date));
    $priorizetotal = $row['priorizetotal'];
    //echo $priorizetotal;
    $last_employee = $row['last_employee'];
    $status = $row['status'];
    $note = $row['note'];
    // $last_movement = $row['last_movement'];
    $position = $row['position'];


    if ((isset($_REQUEST['newcomment'])) && ($_REQUEST['newcomment'] != 'null')) {

        $info = substr($_REQUEST['newcomment'], 0, 10);
        $newcomment = $_REQUEST['newcomment'];
        $wo_num = $_REQUEST['wo_num'];

        $trimmednewcomment = str_replace("-", "", $newcomment);
        $sqlnewcommon = "INSERT into messages (id,date,message,relation,employes,read_,info) values (null,CURRENT_TIMESTAMP,'$newcomment','$wo_num','$last_employee',0,'$info')";
        //  -->> VITACORA   
        //echo $sqlnewcommon;
        $sqladdingtracking = "INSERT into wo_process (id,id_wo,wo,date,user,process) values (NULL,'$wo','$wo_num',CURRENT_TIMESTAMP,'$last_employee','MSG: " . $newcomment . " ')";
        $executeV = mysqli_query($link, $sqladdingtracking);
        //  -->> VITACORA   

        //echo $sqladdingtracking;
        $insertnewcpn = mysqli_query($link, $sqlnewcommon);
    }
    if (isset($_REQUEST['action'])) {
        $action = $_REQUEST['action'];
        //IF RECEIVED ACTION IS DELETE DETAILS
        if ($action === "DELETE_MSG") {
            if (isset($_REQUEST['id_comment'])) {
                $id_comment = $_REQUEST['id_comment'];
                if (isset($_REQUEST['wo'])) {
                    $fromwo = $_REQUEST['wo'];
                    $sql_delete_dtl = "UPDATE messages set read_ = '11', info = CURRENT_TIMESTAMP where id = '$id_comment' ";
                    $delete_MSG = mysqli_query($link, $sql_delete_dtl);
                    if ($delete_MSG) {
                        $error_del = "NO";
                    } else {
                        $error_del = "ERROR";
                    }
                } else {
                    $error_del = "ERROR";
                }
            } else {
                //NO EXIST ID OF DETAIL ERROR
                $error_del = "ERROR";
                //echo $error_del;
            }
        }
    } else {
        //NO ACTION RECEIVED
        $error_del = "NO RECEIVED ACTION - ERROR.";
    }
} else {
    $manytimes = 0;
    $idheader = "NO WO. SELECTED";
    $wo = '';
    $psc_no = '';
    $picking = '';
    $assy_pn = '';
    $customer = '';
    $po = '';
    $qty = '';
    $due_date = '';
    $newdue_date = strftime('%Y-%m-%dT%H:%M:%S', strtotime($nowtime));

    $printed = '';
    $priorizetotal = '';
    $last_employee = '';
    $status = '';
    $note = '';
    $last_movement = '';
    $position = '';
}
switch ($priorizetotal) {
    case 'P1':
        $star1 = '<a id="P1" onclick="priorize(this.id)"><i class="fa fa-star" aria-hidden="true" style="color:green"></i></a>';
        $star2 = '<a id="P2" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:green"></i></a>';
        $star3 = '<a id="P3" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:orange"></i></a>';
        $star4 = '<a id="P4" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:orange"></i></a>';
        $star5 = '<a id="P5" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:red"></i></a>';
        break;
    case 'P2':
        $star1 = '<a id="P1" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:green"></i></a>';
        $star2 = '<a id="P2" onclick="priorize(this.id)"><i class="fa fa-star" aria-hidden="true" style="color:green"></i></a>';
        $star3 = '<a id="P3" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:orange"></i></a>';
        $star4 = '<a id="P4" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:orange"></i></a>';
        $star5 = '<a id="P5" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:red"></i></a>';
        break;
    case 'P3':
        $star1 = '<a id="P1" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:green"></i></a>';
        $star2 = '<a id="P2" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:green"></i></a>';
        $star3 = '<a id="P3" onclick="priorize(this.id)"><i class="fa fa-star" aria-hidden="true" style="color:orange"></i></a>';
        $star4 = '<a id="P4" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:orange"></i></a>';
        $star5 = '<a id="P5" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:red"></i></a>';
        break;
    case 'P4':
        $star1 = '<a id="P1" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:green"></i></a>';
        $star2 = '<a id="P2" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:green"></i></a>';
        $star3 = '<a id="P3" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:orange"></i></a>';
        $star4 = '<a id="P4" onclick="priorize(this.id)"><i class="fa fa-star" aria-hidden="true" style="color:orange"></i></a>';
        $star5 = '<a id="P5" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:red"></i></a>';
        break;
    case 'P5':
        $star1 = '<a id="P1" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:green"></i></a>';
        $star2 = '<a id="P2" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:green"></i></a>';
        $star3 = '<a id="P3" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:orange"></i></a>';
        $star4 = '<a id="P4" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true" style="color:orange"></i></a>';
        $star5 = '<a id="P5" onclick="priorize(this.id)"><i class="fa fa-star" aria-hidden="true" style="color:red"></i></a>';
        break;
    default:
        $star1 = '<a id="P1" onclick="priorize(this.id)"><i class="fa fa-star" aria-hidden="true" style="color:green"></i></a>';
        $star2 = '<a id="P2" onclick="priorize(this.id)"><i class="fa fa-star" aria-hidden="true" style="color:green"></i></a>';
        $star3 = '<a id="P3" onclick="priorize(this.id)"><i class="fa fa-star" aria-hidden="true" style="color:orange"></i></a>';
        $star4 = '<a id="P4" onclick="priorize(this.id)"><i class="fa fa-star" aria-hidden="true" style="color:orange"></i></a>';
        $star5 = '<a id="P5" onclick="priorize(this.id)"><i class="fa fa-star" aria-hidden="true" style="color:red"></i></a>';
        break;
}
?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-3">
                <div>
                    <select class="itemName form-control" name="itemName" id="selecWO" onchange="cambiarfoco()"></select>
                </div>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-info btn-sm" id="botoncambiowo" onclick="changeselect()"><i class="fa fa-arrow-right"></i></button>
            </div>
            <div class="col-7">
                <h1><?= $idheader ?></h1>
            </div>
        </div>
        <br>
        <!--        INICIA MENSAJE DE ALERTA -->
        <?php
        if ((isset($varalert)) && ($varalert == 1)) {
            ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> The WO has been updated correctly.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
        } elseif ((isset($varalert)) && ($varalert == 0)) {
            ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Something went wrong, please verify information.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
        }
        ?>


        <!--FIN DE MENSAJE DE ALERTA -->
        <div class="row">
            <div class="col-1"></div>
            <div class="col-5">
                <form action="edit_wo" method="post" class="needs-validation" id="form_edit" onsubmit="event.preventDefault(); returnea();" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header bg-info text-white">General Desc.</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">


                                    <label for="validationServer03">Description No.:</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control form-control-sm col-3" name="wo" id="woid" placeholder="PSC WO." autocomplete="off" value="<?= $wo ?>" required readonly style="font-weight:bold">
                                        <input type="text" class="form-control form-control-sm" name="wo_number" id="psc_no" placeholder="PSC WO." autocomplete="off" value="<?= $psc_no ?>" required readonly style="font-weight:bold">
                                        <div class="input-group-append input-small">
                                            <span class="input-group-text input-small"><i class="fa fa-pencil" onclick="activepscid()"></i></span>
                                        </div>
                                        <div class="invalid-feedback">
                                            Please provide correct Description No.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for=''>Assembly Picking T:</label>
                                    <input type="text" name="picking" class="form-control form-control-sm" value="<?= $picking ?>">
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-12">
                                    <label for=''>TOP Assembly Part No.:</label>
                                    <input type="text" name="assy_pn" class="form-control form-control-sm" value="<?= $assy_pn ?>">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-4">
                                    <label for=''>Customer:</label>
                                    <!-- <select name="customer" id="customer"></select> -->
                                    <select name="customer" id="customer" data-placeholder="Customer" class="select form-control form-control-sm" tabindex="1">
                                        <option value="1">PSC</option>
                                    </select>

                                </div>
                                <div class="col-4">
                                    <label for=''>PO:</label>
                                    <input type="text" name="po" class="form-control form-control-sm" value="<?= $po ?>">
                                </div>
                                <div class="col-4">
                                    <label for=''>Qty:</label>
                                    <input type="text" name="qty" id="qty" onblur="resaltarqty()" autocomplete="off" class="form-control form-control-sm" value="<?= $qty ?>" required>
                                    <div class="invalid-feedback">
                                        Qty must be > or = 1.
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

            </div>



            <div class="col-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <div class="row">
                            <div class="col-6">WO Details</div>
                            <?php
                            if (isset($row['status'])) {
                                $actualstatus = $row['status'];
                                if ($actualstatus == '1') {
                                    $iconhidden1 = "";
                                    $iconhidden0 = "hidden";
                                } else {
                                    $iconhidden1 = "hidden";
                                    $iconhidden0 = "";
                                }
                            } else {
                                $iconhidden1 = "hidden";
                                $iconhidden0 = "hidden";
                            }

                            ?>

                            <div class="col-6">
                                STATUS
                                <a class="btn btn-success btn-sm float-right" onclick="changestatus()" id="changestatus1" <?= $iconhidden1 ?>><i class="fa fa-check" title="In Process"></i></a>
                                <a class="btn btn-warning btn-sm float-right" onclick="changestatus()" id="changestatus0" <?= $iconhidden0 ?>><i class="fa fa-clock-o" title="On Hold"></i></a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label for=''>Date Printed:</label>
                                <input type="text" name="printed" class="form-control form-control-sm" value="<?= $printed ?>" readonly>

                            </div>
                            <div class="col-6">
                                <label for=''>Date Due:</label>

                                <input type="datetime-local" name="due_date" class="form-control form-control-sm" value="<?= $newdue_date ?>" required>
                            </div>

                        </div><br>
                        <div class="row">
                            <div class="col-3">
                                <label for=''>Prioritize:</label><br>
                                <center>
                                    <?= $star1 ?>
                                    <?= $star2 ?>
                                    <?= $star3 ?>
                                    <?= $star4 ?>
                                    <?= $star5 ?>

                                </center>

                                <input type="text" name="priorizetotal" id="priorizetotal" value="<?= $priorizetotal ?>" readonly hidden>
                            </div>
                            <div class="col-4">
                                <label for=''>Current Position:</label><br>
                                <select name="position" id="starting" class="form-control form-control-sm">
                                    <option value="<?= $position ?>" selected><?= $position ?></option>
                                    <option value="1">1 - Work Order Registration</option>
                                    <option value="2">2 - Prior approval</option>
                                    <option value="3">3 - Kitting</option>
                                    <option value="4">4 - Ready for assign</option>
                                    <option value="5">5 - In Process</option>
                                    <option value="6">6 - Done</option>
                                    <option value="7">7 - Quality Control</option>
                                    <option value="8">8 - Packing</option>
                                    <option value="9">9 - Shipped</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for=''>Last Process / User:</label><br>
                                <input type="text" name="last_employee" class="form-control form-control-sm" value="<?= $last_employee ?>">
                            </div>

                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <?php
                                if ((isset($row['psc_no'])) && ($position <= '3')) {
                                    if ($position >= 2) {
                                        ?>
                                        <a href='#' id='forward_wo,<?= $row['psc_no'] ?>,<?= $position ?>,<?= $row['id'] ?>' data-toggle='modal' data-target='#return_wo' onclick='return_wo(this.id)' class='btn btn-info btn-sm text-white form-control'><i class='fa fa-arrow-left'></i></a>
                                    <?php
                                        }
                                        ?>

                            </div>
                            <div class="col-6">
                                <a href='#' id='forward_wo,<?= $row['psc_no'] ?>,<?= $position ?>,<?= $row['id'] ?>' data-toggle='modal' data-target='#move_wo' onclick='update_wo(this.id)' class='btn btn-success btn-sm text-white form-control'><i class='fa fa-arrow-right'></i></a>
                            <?php
                            } ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row">

            <div class="col-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        Messages
                        <a href="#" class="btn btn-dark btn-sm pull-right" id="<?= $wo ?>" onclick="addcommon(this.id)"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-body">

                        <table class="table table-light table-sm table-striped">

                            <?php
                            $sqlmessages = "SELECT * from messages where relation = '$psc_no' and read_ <= 10 order by date desc";
                            $execformessa = mysqli_query($link, $sqlmessages);
                            while ($message = mysqli_fetch_array($execformessa)) {
                                echo "<tr>";
                                echo "<td><lu>" . $message['message'] . "</li></td>";
                                echo "<td><a href='#' id='" . $message['id'] . "' onclick='delete_message(this.id)'><i class='fa fa-times' style='color:red'></i></a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        Tracking
                        <label class="pull-right"><a href="view_tracking?wo=<?= $wo ?>" class="text-white"> View All </a></label>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered table-striped table-condensed smalltable">

                            <?php
                            $sqltrack = "SELECT * from wo_process where wo = '$psc_no' and id_wo = '$wo' order by date desc limit 10";
                            $exectrack = mysqli_query($link, $sqltrack);
                            while ($trackinfo = mysqli_fetch_array($exectrack)) {
                                if ($trackinfo['user'] === 1) {
                                    $positioninitial = "NEW REGISTRY";
                                } else {
                                    $positioninitial = $trackinfo['user'];
                                }
                                echo "<tr>";
                                echo "<td><lu>" . $trackinfo['date'] . "</lu></td>";
                                echo "<td>" . $trackinfo['process'] . "</td>";
                                echo "<td>" . $positioninitial . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div><input type="text" name="Execute-Time" value="<?= $executetime ?>" readonly hidden>
        <div class="col-12">
            <br><input type="text" id="saved" name="saved" value="<?= $saved ?>" hidden readonly>
            <center>
                <div class="row ">
                    <div class="col-3 float-right">Password:</div>
                    <div class="col-3">
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
                        &nbsp;
                        <button type="button" onclick="location.href='index';" class="btn btn-dark btn-sm"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                    </div>
                    <div class="col-3">
                        <?php
                        if ((isset($row['position'])) && ($row['position'] <= '4')) {
                            echo "<a href='#' target='_blank' id='btn-print' onclick='event.preventDefault();chekprintqty()' class='btn btn-primary btn-sm'><i class='fa fa-print'></i> Print</a>";
                            // echo "<a href='../TCPDF-master/examples/psc_wo_box.php?wo=$psc_no' target='_blank' ><i class='fa fa-print'></i> Print</a>";
                        }
                        ?>

                    </div>
                </div>


            </center>

        </div>
        </form>
    </div>
    <hr>

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
                <form action="movewo.php" method="get" target="_self" id="move_wo_form">
                    <div class="modal-body">

                        <h2>WO No.:</h2> <input type="text" name="wo" id="wo_f" class="form-control input-sm" value="" autocomplete="off" required readonly>
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
                        <input type="text" id="realid" name="backtome" value="edit_wo" hidden readonly>
                        <input type="text" id="saved" name="saved" value="1" hidden readonly>

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
                <form action="movewo.php" method="get" target="_self" id="return_wo_form">
                    <div class="modal-body">

                        <h2>WO No.:</h2> <input type="text" name="wo" id="wo_r" class="form-control input-sm" value="" autocomplete="off" required readonly>
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
                        <input type="text" id="realid" name="backtome" value="edit_wo" hidden readonly>
                        <input type="text" id="saved_r" name="saved" value="0" hidden readonly>
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

        function delete_message(id) {
            id = id;
            opcion = confirm("Are you sure you want to DELETE this record.?");
            if (opcion) {

                var return_to = "<?= $wo ?>";

                window.location.href = "edit_wo.php?id_comment=" + id + "&action=DELETE_MSG&wo=" + return_to;

            } else {
                return;
            }

        }

        function changeselect() {
            var newid = document.getElementById("selecWO").value;
            var desition = window.confirm("Are you sure you want to change the selected WO?");
            if (desition == true) {
                location.href = "edit_wo.php?wo=" + newid;

            } else {
                return
            }

        }

        function activepscid() {
            var sure = window.confirm("Be careful, you are trying to edit a unique field, all related information could be lost.");
            if ((sure == true) && (document.getElementById("psc_no").value != "")) {
                document.getElementById("psc_no").removeAttribute("readonly");
            }
        }

        function priorize(val) {
            var wid = val;
            document.getElementById("priorizetotal").value = wid;

            document.getElementById(wid).style.fontSize = "25px";
        }

        function changestatus() {
            var newstatus = window.confirm("Do you want to change the current status of this WO?");
            if (newstatus == true) {
                var worder = document.getElementById("woid").value;
                $.ajax({
                        method: "POST",
                        url: 'updatestatus.php?worder=' + worder,
                    })
                    .done(function(msg) {
                        alert("STATUS CHANGED: " + worder);
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

        function cambiarfoco() {
            setTimeout(function() {
                $('#botoncambiowo').focus();
            }, 100);
        }

        function addcommon(id) {
            var id = id;
            var wo_num = document.getElementById("psc_no").value;

            if (id != '') {
                var newcomment = prompt("Enter the note or message. ");
                if ((newcomment != null) && (newcomment != "")) {
                    window.location.href = "edit_wo.php?wo=" + id + "&newcomment=" + newcomment + "&wo_num=" + wo_num;
                }
            } else {
                alert("NO WO SELECTED.");
            }
        }

        function returnea() {

            var pass = document.getElementById("password").value;

            if ((pass == "<?= $authorization ?>") || pass == "ADMINPCS159") {
                // alert("PASS CORRECT");
                document.getElementById('form_edit').submit();

            } else {
                alert("WRONG PASSWORD");

            }
        }

        function chekprintqty() {
            var manytimes = "<?= $manytimes ?>";
            if (manytimes >= '1') {
                var reprint = confirm("This WO has been printed " + manytimes + " times, Would you like to re-print?");
                var pagine = "../TCPDF-master/examples/psc_wo_box.php?wo=<?= $wo ?>";
                if (reprint) {
                    window.open(pagine);
                    location = location.href;
                } else {
                    location = location.href;

                }
            } else {
                var pagine = "../TCPDF-master/examples/psc_wo_box.php?wo=<?= $wo ?>";
                window.open(pagine);
            }




        }
    </script>
    <script type="text/javascript">
        $('.itemName').select2({
            placeholder: 'Select an item',
            ajax: {
                url: 'ajaxpro.php',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    </script>
    <?php
    include('../footer.php');
    ?>