<?php
include('../header.php');
$link = Conectarse();


if ($search == "") {
    ?>

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3">
            </div>

            <div class="col-md-1">
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">

                        <div class="row">
                            <div class="col-md-9 ">

                                LAST CLOSED WOs.
                            </div>
                            <div class="col-md-3 ">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm col-6" name="wo" id="search" placeholder="Search Closed WO" autocomplete="off" required>

                                    <div class="input-group-append input-small">
                                        <span class="input-group-text input-small"><i class="fa fa-search"></i></span>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please provide correct Description No.
                                    </div>
                                </div>
                            </div>


                            <!-- 
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" id="search" placeholder="Search video">
                                </div>
                            </div> -->

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 col-md-offset-3" id="result">
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

<?php
} else {

    $sql = "SELECT * from wo_completed 
    where id = '$search' LIMIT 1";

    $result = mysqli_query($link, $sql) or die("Something wrong with DB please verify.");
    $row = mysqli_fetch_array($result)
    ?>


    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-info text-white">General Desc.</div>
            <div class="card-body">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">
                                    WO Info.
                                </div>
                                <div class="card-body">
                                    <div class="col-12">
                                        <label for="validationServer03">Description No.:</label>
                                        <div class="input-group mb-12">
                                            <label style="font-weight:bold"><?= $row['psc_no'] ?> </label>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for=''>Assembly Picking T:</label>
                                        <label style="font-weight:bold"><?= $row['picking'] ?> </label>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">
                                    Details.
                                </div>
                                <div class="card-body">
                                    <div class="col-12">
                                        <label for=''>TOP Assembly Part No.:</label>
                                        <label style="font-weight:bold"><?= $row['assy_pn'] ?> </label>

                                    </div><br>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for=''>Customer:</label>
                                                    <!-- <select name="customer" id="customer"></select> -->
                                                    <label style="font-weight:bold">PSC</label>

                                                </div>
                                                <div class="col-3">
                                                    <label for=''>PO:</label>
                                                    <label style="font-weight:bold"><?= $row['po'] ?> </label>

                                                </div>
                                                <div class="col-3">
                                                    <label for=''>Qty:</label>
                                                    <label style="font-weight:bold"><?= $row['qty'] ?> </label>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card">
                                <div class="card-header">
                                    STATUS
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <br>
                                        <?php
                                            $priorizetotal = $row['priorizetotal'];
                                            $star = "";
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
                                            for ($i = 0; $i < substr($priorizetotal, -1); $i++) {
                                                $star .= '<a id="P1"><i class="fa fa-star" aria-hidden="true" style="color:blue;font-size:35px;"></i></a>';
                                            }

                                            ?>

                                        <div class="col-12">

                                            <i class="fa fa-check" <?= $iconhidden1 ?>></i>
                                            <center><i class="fa fa-clock-o" <?= $iconhidden0 ?> style="font-size:30px"></i></center>
                                            <center>COMPLETED</center>
                                        </div>
                                        <div class="col-12">

                                            <center>
                                                <?= $star ?>
                                            </center>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Dates
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <center>
                                        <label for=''>Printed:</label><br>
                                        <label><?= $row['printed'] ?></label>
                                    </center>


                                </div>
                                <div class="col-4">
                                    <center>
                                        <label for=''>Due:</label>
                                        <br>
                                        <label><?= $row['due_date'] ?></label>
                                    </center>

                                </div>

                                <div class="col-4">
                                    <center>
                                        <label for=''>Closed:</label><br>
                                        <label style="font-weight:bold"><?= $row['last_movement'] ?></label>
                                    </center>


                                </div>
                            </div>
                        </div>


                    </div>
                </div><br>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <center><b>MESSAGES</b></center>
                                </div>
                                <div class="crad-body">

                                </div>
                            </div>

                            <center>



                            </center>


                        </div>
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <center><b>REGISTERED TRACKING INFORMATION</b></center>
                                </div>
                                <div class="crad-body">
                                    <?php
                                        $SQLTRCK = "SELECT * from wo_process where id_wo = '" . $row['id'] . "' and wo = '" . $row['psc_no'] . "' order by date desc ";
                                        echo "<table class='table table-striped table-sm'>";
                                        $resulttrac = mysqli_query($link, $SQLTRCK) or die("Something wrong with DB please verify.");
                                        while ($track = mysqli_fetch_array($resulttrac)) {
                                            echo "<tr>";
                                            echo "<td>" . $track['date'] . "</td>";
                                            echo "<td>" . $track['process'] . "</td>";
                                            echo "<td>" . $track['user'] . "</td>";
                                            echo "</tr>";
                                        }
                                        echo "</table>";
                                        ?>
                                </div>
                            </div>





                        </div>


                    </div>

                </div>
            </div>
        </div>
        <br>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <a href="#" class="btn btn-dark"> &nbsp;<i class="fa fa-print"> </i>&nbsp;</a>
                    <a href="closed" class="btn btn-info">Return</a>
                </div>
            </div>
        </div>
    <?php
        mysqli_free_result($result);
        mysqli_close($link);
    }
    ?>


    <script type="text/javascript" src="js/index.js"></script>
    <?php
    echo "<hr>";

    include('../footer.php');
    ?>