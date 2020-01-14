<?php
include('../header.php');
$link = Conectarse();
if (isset($_REQUEST['id'])) {
    $tool = $_REQUEST['id'];

    if ((isset($_REQUEST['newstock'])) && ($_REQUEST['newstock'] != 'null')) {
        $newstock = $_REQUEST['newstock'];
        $sqlnewstock = "UPDATE tools_main_db set stock = '$newstock' where psc_id = '$tool'";
        //echo $sqlnewstock;
        $updatestock = mysqli_query($link, $sqlnewstock);
        if (($newstock == "BROKEN") || ($newstock == "DAMAGED")) {
            $sqlupdatestatus = "UPDATE tools_main_db set available = '-1' where psc_id = '$tool'";
            $updatestatus = mysqli_query($link, $sqlupdatestatus);
        }
    }

    if ((isset($_REQUEST['newperiod'])) && ($_REQUEST['newperiod'] != 'null')) {
        $newperiod = $_REQUEST['newperiod'];
        $sqlnewnewperiod = "UPDATE tools_main_db set common = '$newperiod' where psc_id = '$tool'";
        //echo $sqlnewstock;
        $updatenewperiod = mysqli_query($link, $sqlnewnewperiod);
    }

    if ((isset($_REQUEST['newcertif'])) && ($_REQUEST['newcertif'] != 'null')) {
        $newcertif = $_REQUEST['newcertif'];
        $sqlnewnewcertif = "UPDATE tools_main_db set certif_num = '$newcertif' where psc_id = '$tool'";
        //echo $sqlnewstock;
        $updatenewcertif = mysqli_query($link, $sqlnewnewcertif);
    }


    $sql = "SELECT * from tools_main_db where psc_id = '$tool'";
    $sqltracking = "SELECT * from tools_process where psc_id = '$tool' order by date desc limit 15";
    $exec = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($exec);
    $model = trim($row['model'], " ");
    $status = $row['available'];
    // SQL QUERY FOR UPDATE STOCK LOCATION


    //CODE FOR DELETE DETAILS OF COMMON PARTNUMBERS IF EXIST ACTION
    $error_del = "";
    if (isset($_REQUEST['action'])) {
        $action = $_REQUEST['action'];
        //IF RECEIVED ACTION IS DELETE DETAILS
        if ($action === "DELETE_DTL") {
            if (isset($_REQUEST['id_pn'])) {
                $id_pn = $_REQUEST['id_pn'];
                if (isset($_REQUEST['fromtool'])) {
                    $fromtool = $_REQUEST['fromtool'];
                    $sql_delete_dtl = "DELETE from common_tb where id = '$id_pn' and tool_pn = '$fromtool'";
                    $delete_DTL = mysqli_query($link, $sql_delete_dtl);
                    if ($delete_DTL) {
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
    //echo $error_del;
    //SQL FOR ADD COMMONLY USED PARTNUMBER
    if ((isset($_REQUEST['newcommonpn'])) && ($_REQUEST['newcommonpn'] != 'null')) {
        $newcommonpn = $_REQUEST['newcommonpn'];
        $trimmednewcomp = str_replace("-", "", $newcommonpn);
        $sqlnewcommon = "INSERT into common_tb (id,component_pn, tool_pn, trimmed) values (null,'$newcommonpn','$model','$trimmednewcomp')";
        //echo $trimmednewcomp;
        $insertnewcpn = mysqli_query($link, $sqlnewcommon);
    }
} else {
    $tool = "Error";
}
?>
<div class="container-fluid">
    <?php
    if (($error_del != "ERROR") && ($error_del === "NO")) {
    ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>DELETE</strong> Record correctly removed.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php
    }
    ?>

    <center>
        <h2>DETAILS <?= $tool ?></h2>
    </center>
    <div class="row">
        &nbsp;&nbsp;&nbsp;<br>
        <div class="card" style="width: 25rem;">

            <img src="tools_imgs/<?= $row['img'] ?>" class="card-img-top" alt="..." onerror=this.onerror=null;this.src='tools_imgs/no_image.png' ;>
            <div class="card-header">
                <input type="text" value="<?= $tool ?>" class="form-control" name="real_psc_id" id="real_psc_id" style="border:none;background:none; text-align:center;  font-weight: bold;
;" readonly>
                <center></center>
            </div>
            <div class="card-body">
                <table class="table table-sm table-default table-striped">
                    <tr>
                        <th>Storage / Qty:</th>
                        <td><i class='fa fa-inbox' aria-hidden='true'></i> &nbsp;<?= $row['stock'] ?> | <?= $row['qty'] ?></td>
                        <td><a href="#" id="<?= $row['psc_id'] ?>" onclick="alterstock(this.id)"><i class='fa fa-edit' aria-hidden='true'></i></a> &nbsp;</td>
                    </tr>
                    <tr>
                        <th>Manufacturer:</th>
                        <td><?= $row['manufacturer'] ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Model:</th>

                        <td><a href="http://192.0.0.125/TOOLS/<?= $row['manufacturer'] ?>/<?= substr($row['manufacturer'], 0, 3) ?> <?= $row['model'] ?>.pdf" target="_blank"><?= $row['model'] ?></a></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td><?= $row['description'] ?></td>
                        <td></td>
                    </tr>

                </table>

                <p class="card-text"><?= $row['notes'] ?></p>
            </div>
        </div>
        &nbsp;&nbsp;&nbsp;<br>
        <!-- USO / usage -->
        <div class="card" style="width: 20rem;">
            <div class="card-body">
                <center>
                    <h5 class="card-title">Usage</h5>
                </center>
                <center>
                    <input type="text" value="<?= $model ?>" name="modeltool" id="modeltool" style="border:none;text-align:center;  font-weight: bold;
;" readonly>
                    <br>
                </center>

                <p class="card-text">This tool is currently: </p>
                <?php if ($status == '1') {

                    echo "<center><i class='fa fa-flag' aria-hidden='true' style='color:green;font-size:40px'></i><br><small>Available.</small></center>";
                } elseif (($status == '-1') || ($row['stock'] == "BROKEN") || ($row['stock'] == "DAMAGED")) {
                    echo "<center><i class='fa fa-flag' aria-hidden='true' style='color:orange;font-size:40px'></i><br><small>Using By: DAMAGED TOOL</small></center>";
                } else {
                    echo "<center><i class='fa fa-flag' aria-hidden='true' style='color:red;font-size:40px'></i><br><small>Using By: " . $row['user_know'] . "</small></center>";
                }
                ?>

                <br>
                <table class="table table-striped table-sm table-condensed table-bordered text-center">
                    <tr>
                        <td>Used:</td>
                        <td><?= $row['used_qty'] ?> Times</td>
                    </tr>
                    <tr>
                        <td>Last usage:</td>
                        <td><?= $row['last_use'] ?></td>
                    </tr>

                </table>
                <hr>
                <table class="table table-secondary table-striped table-sm table-condensed text-center">
                    <th colspan="3" class="text-center">CALIBRATION INFO</th>
                    <tr>
                        <td><small><b>CERTIFICATE:</small></td>
                        <td><small><a href='http://192.0.0.125/databases/calib_certs/<?= $row['certif_num'] ?>.pdf' class='nav-link' target='_blank'><?= $row['certif_num'] ?></a> </small></td>
                        <td><small><a href='#' class='nav-link' id="<?= $row['psc_id'] ?>" onclick="altercertificate(this.id)"> <i class="fa fa-pencil"></i></a></small></td>
                    </tr>
                    <tr>
                        <td><small><b>CALIBRATED:</small></td>
                        <td colspan="2"><small><?= date("Y-m-d", strtotime($row['reg_date'])) ?></small></td>
                    </tr>
                    <tr>
                        <td><small><b>CALIB. PERIOD:</small></td>
                        <td><small><?= $row['common'] ?> months </small></td>
                        <td><small><a href='#' class='nav-link' id="<?= $row['psc_id'] ?>" onclick="altercerperiod(this.id)"> <i class="fa fa-pencil"></i></a></small></td>
                    </tr>
                    <tr>
                        <td><small><b>NEXT CALIB. </small></td>
                        <td colspan="2"><small><?php
                                                $nextcaldate = date("Y-m-d", strtotime($row['reg_date'] . "+ " . $row['common'] . " month"));
                                                $datetoday =  date("Y-m-d");
                                                $daysleftsql = "SELECT TIMESTAMPDIFF(DAY, '$datetoday', '$nextcaldate') AS daysleft";
                                                $execdaysleft = mysqli_query($link, $daysleftsql);
                                                $daysleft = mysqli_fetch_array($execdaysleft);
                                                if ($daysleft['daysleft'] <= 30) {
                                                    echo "<div class='bg-danger text-white V-URGENT'>" . $nextcaldate . " | " . $daysleft['daysleft'] . " Days</div>";
                                                } else {
                                                    echo $nextcaldate . " | " . $daysleft['daysleft'] . " Days";
                                                }

                                                ?> </td>
                    </tr>
                </table>

            </div>
        </div> &nbsp;&nbsp;&nbsp;<br>
        <!-- SEGUIMIENto / TRACKING -->
        <div class="card" style="width: 30rem;">
            <div class="card-body">
                <center>
                    <h5 class="card-title">Tracking</h5>
                </center>
                <center>
                    <p class="card-subtitle mb-2 text-muted">If exist, last 15 movements.</p>
                </center>

                <br>
                <table class="table table-sm table-light table-striped">
                    <?php
                    $x = 0;
                    $execsql = mysqli_query($link, $sqltracking);
                    while ($track = mysqli_fetch_array($execsql)) {
                        $x++;
                        if ($track['process'] == '0') {
                            $icon = "<center><i class='fa fa-upload' aria-hidden='true' style='color:green'></i></i></center>";
                            $label = "<td class='bg-success text-white'>DELIVERED</td>";
                        } else if ($track['process'] == '1') {
                            $icon = "<center><i class='fa fa-download' aria-hidden='true' style='color:red'></i></center>";
                            $label = "<td class='bg-danger text-white'>RETURNED</td>";
                        } else {
                            $icon = "<center><i class='fa fa-upload' aria-hidden='true' style='color:green'></i></i></center>";
                            $label = "<td class='bg-success text-white'><small>TRANSFERRED</small></td>";
                        }

                    ?>
                        <tr>
                            <td>
                                <?= $icon ?>
                            </td>
                            <td><?= $track['name'] ?></td>
                            <td><?= $track['date'] ?></td>
                            <?= $label ?>
                        </tr>
                    <?php }
                    if ($x == 0) {
                        echo "No Data";
                    }
                    ?>


                </table>

            </div>
        </div>&nbsp;&nbsp;&nbsp;<br>
        <div class="card" style="width:20rem;">
            <div class="card-body">
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <h6> TRANSF / USE <br><br>
                            <a href='#' id='<?= $tool ?>' class='btn btn-success ' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'><i class='fa fa-arrow-left' style='font-size:15px'></i></a>
                        </h6>
                    </div>
                    <div class="col-sm-6">

                        <?php
                        if ($status == '0') {
                            echo "<h6> RETURN <br><br>";
                            echo "<a href='#' id='$tool' class='btn btn-danger' data-toggle='modal' data-target='#return_tool' onclick='return_modal(this.id)'><i class='fa fa-arrow-right' style='font-size:15px'></i></a>";
                            echo "</h6>";
                        } else {
                        }
                        ?>
                        <!-- <a href='#' id='<?= $tool ?>' class='btn btn-success ' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'><i class='fa fa-arrow-left' style='font-size:15px'></i></a> -->
                    </div>

                </div>

            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <a href="#" class="btn btn-secondary btn-sm pull-left" id="<?= $model ?>" onclick="addlist(this.id)" data-toggle='modal' data-target='#addlist_pn'><i class="fa fa-upload"></i></a>
                <h6>Commonly used PNs: </h6>
                <a href="#" class="btn btn-dark btn-sm pull-right" id="<?= $row['psc_id'] ?>" onclick="addcommon(this.id)"><i class="fa fa-plus"></i></a>


            </div>


            <div class="card-footer">
                <div class="col-12 pn_panel">


                    <table class="table table-responsive table-light table-sm table-striped">

                        <?php
                        $sqlforcommon = "SELECT * from common_tb where tool_pn = '$model'";
                        $execforcommon = mysqli_query($link, $sqlforcommon);
                        while ($commonpn = mysqli_fetch_array($execforcommon)) {
                            if ($commonpn['import_verif'] == '0') {
                                $caracter = "<small><i class='fa fa-dot-circle-o'></i></small>";
                            } else {
                                $caracter = "<small><i class='fa fa-check-square-o'></i></small>";
                            }
                            if ($commonpn['img'] != "") {

                                $imagen = "<a href='" . $commonpn['img'] . "' data-lightbox='image-1' data-title='" . $commonpn['component_pn'] . "' ><i class='fa fa-file-image-o' aria-hidden='true'></i></a>";
                            } else {
                                $imagen = "";
                            }
                            echo "<tr>";
                            echo "<td><small> $caracter </small>| <a href='https://www.digikey.com/products/en?keywords=" . $commonpn['component_pn'] . "' target='_blank'><small>" . $commonpn['component_pn'] . "</small></a></td>";
                            echo "<td><small>" . substr($commonpn['manufacturer'], 0, 7) . "</small></td>";
                            echo "<td>" . $imagen . "</td>";
                            echo "<td><a href='#' id='" . $commonpn['id'] . "' onclick='delete_common(this.id)'><i class='fa fa-times' style='color:red'></i></a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
<br><br>
<!-- Modal for get tool -->
<div class="modal fade" id="get_tool" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Getting (<input type="text" for="id_tool" id="label_idtool" value="" style="border:none" readonly>)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="changestatus.php" method="post" target="_self">
                <div class="modal-body">
                    Tool ID:
                    <input type="text" name="psc_id" id="psc_id" class="form-control input-sm" value="" placeholder="PSC-ID Ex. PSC-XXXX" readonly required>
                    <br>
                    Name:
                    <input type="text" name="employee" id="employee" class="form-control" value="" placeholder="User or Name" required>
                    <input type="text" name="process" id="process" value="" hidden readonly required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal for return tool -->
<div class="modal fade" id="return_tool" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Returning (<input type="text" for="id_tool_return" id="label_idtool_r" value="" style="border:none" readonly>)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="changestatus.php" method="post" target="_self">
                <div class="modal-body">
                    Tool ID:
                    <input type="text" name="psc_id" id="psc_id_r" class="form-control input-sm" readonly required>
                    <br>
                    Name:
                    <input type="text" name="employee" id="employee_r" class="form-control" value="RETURN" placeholder="User or Name" readonly required>
                    <input type="text" name="process" id="process_r" value="" hidden readonly required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" autofocus>Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="addlist_pn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Loading PN LIST</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="loadlist_pn.php" method="post" target="_blank" enctype="multipart/form-data">
                <div class="modal-body">
                    TOOL MODEL: <?= $model; ?>
                    <br>
                    <input type="text" name="tool" value="<?= $model; ?>" readonly hidden>
                    <input type="text" value="save_list" name="command" readonly hidden>
                    <br>
                    File:
                    <input type="file" name="pn_list">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" autofocus>UPLOAD</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function alterstock(id) {
        id = id;
        stock = prompt(" New Storage location for " + id + " .");
        if ((stock != null) && (stock != "")) {
            window.location.href = "tool_details.php?id=" + id + "&newstock=" + stock;
        }
    }

    function altercertificate(id) {
        id = id;
        certif = prompt(" New CALIBRATION CERTIFICATE for " + id + " .");
        if ((certif != null) && (certif != "")) {
            window.location.href = "tool_details.php?id=" + id + "&newcertif=" + certif;
        }
    }

    function altercerperiod(id) {
        id = id;
        certif = prompt(" New CALIBRATION PERIOD for " + id + " (NUMBER 1 - 12).");
        if ((certif != null) && (certif != "")) {
            window.location.href = "tool_details.php?id=" + id + "&newperiod=" + certif;
        }
    }

    function update_modal(id) {
        pcs_id = id;
        if (pcs_id == "getting") {
            document.getElementById("psc_id").removeAttribute('readonly');
            document.getElementById("label_idtool").value = "GETTING TOOL";
            setTimeout(function() {
                $('#psc_id').focus();
            }, 500);

        } else {
            document.getElementById("psc_id").value = pcs_id;
            document.getElementById("label_idtool").value = pcs_id;

        }
        document.getElementById("process").value = "0";


        setTimeout(function() {
            $('#employee').focus();
        }, 500);
    }

    function addcommon(id) {
        id = id;
        var model = document.getElementById("modeltool").value;
        var newpartnumer = prompt("Enter the component partnumer. ");
        if ((newpartnumer != null) && (newpartnumer != "")) {
            window.location.href = "tool_details.php?id=" + id + "&newcommonpn=" + newpartnumer;
        }
    }

    function return_modal(id) {
        pcs_id = id;
        if (pcs_id == "returning") {
            document.getElementById("psc_id_r").removeAttribute('readonly');
            document.getElementById("label_idtool_r").value = "RETURN";
            // document.getElementById("psc_id_r").focus();
            $(document).on('shown.bs.modal', function(e) {
                $('input:visible:enabled:first', e.target).focus();
            });
        } else {
            document.getElementById("psc_id_r").value = pcs_id;
            document.getElementById("label_idtool_r").value = pcs_id;
        }
        document.getElementById("process_r").value = "1";

        setTimeout(function() {
            $('#employee_r').focus();
        }, 500);

    }

    function delete_common(id) {
        id = id;
        opcion = confirm("Are you sure you want to DELETE this record.?");
        if (opcion) {

            var return_to = document.getElementById("real_psc_id").value;

            var modeltool = document.getElementById("modeltool").value;

            window.location.href = "tool_details.php?id_pn=" + id + "&fromtool=" + modeltool + "&action=DELETE_DTL&id=" + return_to;

        } else {
            return;
        }

    }
</script>

<?php
include('../footer.php');
?>