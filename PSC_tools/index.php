<?php
include('../header.php');
$link = Conectarse();
$csv_filename = 'import_file/db_export_' . date('Y-m-d') . '.csv';
$nameoffile = 'db_export_' . date('Y-m-d') . '.csv';
if ($search == "") {

    $sqlcount = "SELECT COUNT(id_tool) as usingtools from tools_main_db tm where available = '0'";
    $conteorapido = mysqli_query($link, $sqlcount) or die("Something wrong with DB please verify.");
    $quickcount = mysqli_fetch_array($conteorapido);

    $selectlast = "SELECT * from tools_main_db order by last_use desc limit 1";
    $ejecutelastinfo = mysqli_query($link, $selectlast) or die("Something wrong with DB please verify.");
    $infoexecute = mysqli_fetch_array($ejecutelastinfo);
?>
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-4">
                <div class="card card-dark bg-light">
                    <div class="card-header bg-success text-white">
                        <strong>
                            <i class="fa fa-upload"></i>
                            <label> | Latest assigned tools.</label>
                        </strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-condensed table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th><small>PSC ID</small></th>
                                    <th><small>MODEL</small></th>
                                    <th><small>DATE</small></th>
                                    <th><small>USER</small></th>
                                </tr>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sqllasttools = "SELECT psc_id,model,user_know, last_use from tools_main_db order by last_use desc limit 5";
                                $wodata = mysqli_query($link, $sqllasttools) or die("Something wrong with DB please verify.");

                                while ($row = mysqli_fetch_array($wodata)) {
                                    printf("<tr><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", "<a href='tool_details.php?id=" . $row['psc_id'] . "'><small>" . $row['psc_id'] . "</small></a>", "<a href='index.php?srch=" . $row['model'] . "' class='text-muted'><small>" . $row['model'] . "</small></a>", "<small>" . $row['last_use'] . "</small>", "<a href='show_me.php?selector=3&textfield=" . $row['user_know'] . "'><small>" . $row['user_know'] . "</small></a>");
                                }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6">
                <br><br>
                <div class="card card-stats">
                    <div class="card-header-s card-header-warning card-header-icon">
                        <a href='#' id='getting' class='text-white' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'>
                            <div class="card-icon bg-success text-center text-white">
                                <i class="fa fa-arrow-left" style="font-size:40px"></i>
                            </div>
                        </a>
                        <div class="card-category pull-right text-muted"><small>Last used.</small>
                        </div>
                        <div class="card-details text-right  ">
                            <h5 class="text-muted">
                                <a href="tool_details.php?id=<?= $infoexecute['psc_id'] ?>" class="text-success text-muted nav-link">
                                    <?= $infoexecute['psc_id'] ?></a></h5>
                        </div>
                        <small class="text-center">
                            <div class="row">
                                <div class="col-6"><small>Model: <?= $infoexecute['model'] ?></small></div>
                                <div class="col-6"><small>User: <?= $infoexecute['user_know'] ?></small></div>
                            </div>
                        </small>


                        <div class="card-footer">
                            <div class="stats"><small>
                                    <a href="show_me.php?selector=3&textfield=<?= $infoexecute['user_know'] ?>" class=" text-warning ">
                                        <small><i class="fa fa-warning text-warning"></i></small>
                                        &nbsp;View this user...</a> </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6">
                <br><br>
                <div class="card card-stats">
                    <div class="card-header-s card-header-warning card-header-icon">
                        <a href='#' id='returning' class='text-white' data-toggle='modal' data-target='#return_tool' onclick='return_modal(this.id)'>

                            <div class="card-icon bg-danger text-center text-white">
                                <i class="fa fa-arrow-right" style="font-size:40px"></i>

                            </div>
                        </a>
                        <div class="card-category pull-right text-muted"><small>Using tools</small></p>
                        </div>
                        <div class="card-details text-center"><a href="http://127.0.0.1/PSC_tools/show_me.php?selector=1&textfield=" class="text-right nav-link">
                                <?php
                                //start
                                if ($quickcount['usingtools'] >= '50') {
                                    echo "<h5 class='text-danger'>" . $quickcount['usingtools'] . " <small>tools</small></h5>";
                                } else if (($quickcount['usingtools'] >= '30') && ($quickcount['usingtools'] <= '49')) {
                                    echo "<h5 class='text-warning   '>" . $quickcount['usingtools'] . " <small>tools</small></h5>";
                                } else {
                                    echo "<h5 class='text-dark   '>" . $quickcount['usingtools'] . " <small>tools</small></h5>";
                                }

                                ?>


                            </a>
                            <small>
                                <div class="row">
                                    <div class="col-6"></div>
                                    <div class="col-6">&nbsp;</div>
                                </div>
                            </small>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <small>
                                        <a href="#" class="text-danger " data-toggle='modal' data-target='#returning_m'>
                                            <i class="fa fa-chevron-right text-danger"></i>
                                            <small> Massive &nbsp;<i class="fa fa-chevron-right text-danger"></i></small>
                                        </a>

                                    </small>
                                </div>
                                <div class="col-6">
                                    <small>
                                        <a href="#" class="text-danger " data-toggle='modal' data-target='#verification'>
                                            <i class="fa fa-search-plus text-danger"></i>
                                            <small>In-Use</small>
                                        </a>

                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-dark bg-light">
                    <div class="card-header bg-danger text-white">
                        <strong>
                            <i class="fa fa-download"></i>
                            <label> | Latest returned tools.</label>
                        </strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-condensed table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th><small>PSC ID</small></th>

                                    <th><small>DATE</small></th>
                                    <th><small>USER</small></th>
                                </tr>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sqllasttools = "SELECT psc_id,name, date from tools_process where process = '1' order by date desc limit 5";
                                $wodata = mysqli_query($link, $sqllasttools) or die("Something wrong with DB please verify.");

                                while ($row = mysqli_fetch_array($wodata)) {
                                    printf("<tr><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", "<a href='tool_details.php?id=" . $row['psc_id'] . "'><small>" . $row['psc_id'] . "</small></a>", "<small>" . $row['date'] . "</small>", "<a href='show_me.php?selector=3&textfield=" . $row['name'] . "'><small>" . $row['name'] . "</small></a>");
                                }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-4">
                <div class="card card-dark bg-light">
                    <div class="card-header bg-primary text-white">
                        <strong>
                            <i class="fa fa-area-chart"></i>
                            <label> | Monthly records.</label>
                        </strong>
                    </div>
                    <div class="card-body">
                        <?php

                        $yearchart = date("Y");
                        $month = date("m");
                        $day_today = date("d");


                        $arreglodata = "var data = google.visualization.arrayToDataTable([";
                        $arreglodata .= "['Date', 'Deliveries', 'Returns'],";
                        for ($i = 1; $i <= $day_today; $i++) {
                            $returns = 0;
                            $deliveries = 0;
                            $daychart = str_pad($i, 2, "0", STR_PAD_LEFT);;
                            $sqlchartvalues = "SELECT COUNT(id) as transactions, process from tools_process where `date` like '%$yearchart-$month-$daychart%' GROUP by process";
                            $executecharvalues = mysqli_query($link, $sqlchartvalues) or die("Something wrong with DB please verify.");
                            while ($chardata = mysqli_fetch_array($executecharvalues)) {

                                if ($chardata['process'] == 1) {
                                    $returns = $chardata['transactions'];
                                } else if ($chardata['process'] == 0) {
                                    $deliveries = $chardata['transactions'];
                                } else {
                                    $returns = $returns + $chardata['transactions'];
                                    $deliveries = $deliveries + $chardata['transactions'];
                                }
                            }



                            $arreglodata .= "['" . $yearchart . "-" . $month . "-" . $i . "', $deliveries, $returns],";
                        }
                        $arreglodata .= "]);";
                        //echo $sqlchartvalues;
                        ?>
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                            google.charts.load('current', {
                                'packages': ['corechart']
                            });
                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {
                                var data = new google.visualization.DataTable();

                                <?= $arreglodata ?>

                                var options = {
                                    title: 'Tools usage',
                                    curveType: 'function',
                                    legend: {
                                        position: 'bottom'
                                    }
                                };

                                var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                                chart.draw(data, options);
                            }
                        </script>
                        <div id="curve_chart" style="width: 100%; "></div>
                    </div>
                </div>

            </div>
            <div class="col-4">
                <div class="card card-dark bg-light">
                    <div class="card-header bg-primary text-white">
                        <strong>
                            <i class="fa fa-hdd-o"></i>
                            <label> | Actions.</label>
                        </strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-striped table-responsive">
                            <tr>
                                <form action="importdates.php" id="importdates" method="post" enctype="multipart/form-data">
                                    <td><small>Import Dates</small></td>
                                    <td><small><input type="file" class="file" name="importfile" required></small></td>
                                    <td><button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-upload"></i>
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            <tr>
                                <td colspan="2"><small>Download format for Import</small>
                                    <small class="float-right"><small>format.csv</small></small></td>
                                <td>
                                    <a href="import_file/format.csv" class="btn btn-dark btn-sm"><i class="fa fa-download"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><small>Download tools DB</small>
                                    <small class="float-right"><small><?php echo 'db_export_' . date('Y-m-d') . '.csv' ?></small></small></td>
                                <td>
                                    <a href="generatecsv.php" class="btn btn-warning btn-sm text-white" onclick="generatecsv()" target="_blank"><i class="fa fa-refresh"></i></a>
                                    <a href="import_file/<?php echo 'db_export_' . date('Y-m-d') . '.csv' ?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i></a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <?php
                $sqllasttools = "SELECT *, ADDDATE(reg_date,INTERVAL 365 DAY) as nextdate, 
                TIMESTAMPDIFF(DAY, curdate(), ADDDATE(reg_date,INTERVAL 365 DAY)) AS daysleft 
            FROM `tools_main_db` 
            -- where ADDDATE(reg_date,INTERVAL 365 DAY) <= curdate()  
            ORDER BY `tools_main_db`.`reg_date` ASC";
                $wodata = mysqli_query($link, $sqllasttools) or die("Something wrong with DB please verify.");

                $sqllasttoolsforcount = "SELECT *, ADDDATE(reg_date,INTERVAL 365 DAY) as nextdate, 
TIMESTAMPDIFF(DAY, curdate(), ADDDATE(reg_date,INTERVAL 365 DAY)) AS daysleft 
FROM `tools_main_db` 
where ADDDATE(reg_date,INTERVAL 365 DAY) <= curdate()  
ORDER BY `tools_main_db`.`reg_date` ASC";
                $wodata2 = mysqli_query($link, $sqllasttoolsforcount) or die("Something wrong with DB please verify.");
                $duesdates_qty = mysqli_num_rows($wodata2);
                ?>
                <div class="card card-dark bg-light">
                    <div class="card-header bg-primary text-white">
                        <strong>
                            <i class="fa fa-clock-o"></i>
                            <label> | Calibrations Due Dates.</label>
                            <label class='pull-right'><?= $duesdates_qty ?> | Dues</label>
                        </strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-condensed table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th><small>PSC ID</small></th>
                                    <th><small>BRAND</small></th>
                                    <th><small>MODEL</small></th>
                                    <th><small>CALIB. DATE</small></th>
                                    <th><small>NEXT CALIB.</small></th>
                                </tr>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $x = 0;
                                while (($row = mysqli_fetch_array($wodata)) && ($x <= '4')) {
                                    $nextcaldate = date("Y-m-d", strtotime($row['reg_date'] . "+ " . $row['common'] . " month"));
                                    $datetoday =  date("Y-m-d");
                                    $daysleftsql = "SELECT TIMESTAMPDIFF(DAY, '$datetoday', '$nextcaldate') AS daysleft";
                                    $execdaysleft = mysqli_query($link, $daysleftsql);
                                    $daysleft = mysqli_fetch_array($execdaysleft);
                                    if ($daysleft['daysleft'] <= 30) {
                                        $nextcalibration = "<small><small>" . $nextcaldate . " | <label class='V-URGENT'>" . $daysleft['daysleft'] . " Days</label></small></small>";
                                    } else {
                                        $nextcalibration =  "<small><small>" . $nextcaldate . " | " . $daysleft['daysleft'] . " Days </small></small>";
                                    }
                                    printf("<tr><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", "<a href='tool_details.php?id=" . $row['psc_id'] . "'><small><small>" . $row['psc_id'] . "</small></small></a>", "<small><small>" . $row['manufacturer'] . "</small></small>", "<small><small>" . $row['model'] . "</small></small>", "<small><small>" . date("Y-m-d", strtotime($row['reg_date'])) . "</small></small>", "$nextcalibration");

                                    $x++;
                                }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
    // SI SE A ACTIVADO LA CASILLA PARA AMPLIAR LA BUSQUEDA
    // if (isset($_REQUEST['common'])) {
    // $sqlextend = "SELECT * FROM tools_main_db TM INNER JOIN common_tb CTB on TM.model = CTB.tool_pn
    // WHERE psc_id LIKE '%" . $search . "%' 
    // OR TM.manufacturer LIKE '%" . $search . "%' 
    // OR TM.model LIKE '%" . $search . "%' 
    // OR TM.trimmed LIKE '%" . $search . "%' 
    // OR TM.common LIKE '%" . $search . "%' 
    // OR CTB.component_pn like '%" . $search . "%'
    // OR CTB.trimmed like '%" . $search . "%'
    // ORDER BY TM.id_tool";
    $sqlextend = "SELECT * from common_tb where component_pn like '%" . $search . "%' OR trimmed like '%" . $search . "%'";
    //echo $sql;
    // }
    // // UNA BUSQUEDA NORMAL
    // else {
    $sql = "SELECT * 
    FROM tools_main_db 
    WHERE psc_id LIKE '%" . $search . "%' 
        OR manufacturer LIKE '%" . $search . "%' 
        OR model LIKE '%" . $search . "%'
        OR trimmed LIKE '%" . $search . "%'
        OR common LIKE '%" . $search . "%'
        
        ORDER BY id_tool";
    //  }

    $records = 'Found: 0 Records.';
    $texto = "";





    //echo   $sql;


    $result = mysqli_query($link, $sql) or die("Something wrong with DB please verify.");

    // echo mysqli_num_rows($result);
    if (mysqli_num_rows($result) > 0) {
        // Se recoge el número de resultados
        $records = 'Found: ' . mysqli_num_rows($result) . ' Records.';
    } else {

        $records = "TOOLS No matches.";
    }
?>
    <div class='container-fluid'>
        <h5>
            Looking for: <input type="text" value="<?= $search ?>" id="lastsrch" style="border: none; background: transparent;" readonly>
        </h5>

        <p>
            <?= $records ?>
            <br>
            <!-- Search in common partnumbers.
            <input type="checkbox" name="common" id="common" onclick="research()">
            <a href="#" id="research_b" onclick="submitsrch()" hidden><i class="fa fa-arrow-right"></i></a> -->
            <a href="https://www.digikey.com/products/en?keywords=<?= $search ?>" id="new" class="btn btn-sm btn-primary " target="_blank"><i class="fa fa-search"></i> Digikey</a>
            <a href="https://octopart.com/search?q=<?= $search ?>" id="new" class="btn btn-sm btn-primary " target="_blank"><i class="fa fa-search"></i> Octopart</a>
            <a href="new_tool.php" id="new" class="btn btn-sm btn-success float-right"><i class="fa fa-plus"></i> ADD TOOL</a>
        </p>

        <div class="container-fluid">
            <table class="table table-sm table-default table-bordered">
                <?php
                if ($row = mysqli_num_rows($result) > 0) {
                    printf("<tr  class='text-center' style='font-size:12px'><th>&nbsp;%s</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th></tr>", "PSC ID", "BRAND", "MODEL", "DESCRIPTION", "NEXT CALIBRATION", "LAST USED DATE", "STORAGE / USER", "STATUS", "IMG", "USE / RETURN");
                }
                while ($row = mysqli_fetch_array($result)) {
                    $onerrorprint = "onerror=this.onerror=null;this.src='tools_imgs/no_image.png';";
                    if ($row['available'] == '1') {
                        $stock_user = $row["stock"];
                        $classavailable = "bg-success";
                        $setstatus = "<img src='components/available.png' width='50px' title='" . $row["stock"] . "'/>";
                        $button_get = "<a href='#' id='" . $row['psc_id'] . "' class='btn btn-success btn-sm' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'><i class='fa fa-arrow-left' style='font-size:15px'></i></a>";
                    } elseif ($row['available'] == '-1') {
                        $stock_user = "DAMAGED";
                        $classavailable = "bg-warning";
                        $setstatus = "<img src='components/damaged.png' width='10px' alt='DAMAGED'/>";
                        $button_get = "<a href='#' id='" . $row['psc_id'] . "' class='btn btn-success btn-sm' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'><i class='fa fa-arrow-left' style='font-size:15px'></i></a>";
                    } else {
                        $classavailable = "bg-danger";
                        $stock_user = "[" . $row["stock"] . "] - " . $row["user_know"];
                        $setstatus = "<img src='components/notavailable.png' width='50px' title='" . $row["user_know"] . "'/>";
                        $button_get = "<a href='#' id='" . $row['psc_id'] . "' class='btn btn-success btn-sm' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'><i class='fa fa-arrow-left' style='font-size:15px'></i></a>";
                        $button_get .= "&nbsp;<a href='#' id='" . $row['psc_id'] . "' class='btn btn-danger btn-sm float-right' data-toggle='modal' data-target='#return_tool' onclick='return_modal(this.id)'><i class='fa fa-arrow-right' style='font-size:15px'></i></a>";
                    }
                    $nextcaldate = date("Y-m-d", strtotime($row['reg_date'] . "+ " . $row['common'] . " month"));
                    $datetoday =  date("Y-m-d");
                    $daysleftsql = "SELECT TIMESTAMPDIFF(DAY, '$datetoday', '$nextcaldate') AS daysleft";
                    $execdaysleft = mysqli_query($link, $daysleftsql);
                    $daysleft = mysqli_fetch_array($execdaysleft);
                    if ($daysleft['daysleft'] <= 30) {
                        if ($daysleft['daysleft'] <= 0) {
                            $calibrationnow = $nextcaldate . " | <label class='bg-light text-dark V-URGENT'>" . $daysleft['daysleft'] . " Days <i class='fa fa-close text-danger'></i></label>";
                        } else {
                            $calibrationnow = $nextcaldate . " | <label class='bg-light text-dark V-URGENT'>" . $daysleft['daysleft'] . " Days <i class='fa fa-warning text-warning'></i></label>";
                        }
                    } else {
                        $calibrationnow = $nextcaldate . " | " . $daysleft['daysleft'] . " Days <i class='fa fa-check text-success'></i>";
                    }
                    // $calibrationnow = "<small>".$nextcaldate."</small>";

                    //printf("<tr><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", "<h6>" . $row["psc_id"] . "</h6>", "<p>" . $row["manufacturer"] . "</p>", "<p><a href='https://octopart.com/search?q=" . $row["model"] . "' target='_blank'>" . $row["model"] . "</a></p>", "<h6>" . $row["description"] . "</h6>", "<h6>" . $row["last_use"] . "</h6>", "<small><h6>" . $stock_user . "</h6></small>", "<h6>" . $setstatus . "</h6>", "<a href='tools_imgs/" . $row["img"] . "' data-lightbox='image-1' data-title='" . $row["model"] . "' ><img src='tools_imgs/" . $row["img"] . "' width='50px' $onerrorprint /></a>", $button_get);
                    printf("<tr><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td class='text-center'>&nbsp;%s&nbsp;</td><td class='text-center'>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", "<a href='tool_details.php?id=" . $row['psc_id'] . "' >" . $row["psc_id"] . "</a>", "<a href='https://octopart.com/search?q=" . $row["model"] . "' target='_blank'>" . $row["manufacturer"] . "  <i class='fa fa-cog float-right'></i> </a>  ", "<a href='index?srch=" . $row["model"] . "' target='_self'>" . $row["model"] . " </a><a href='#' class='float-right' id='" . $row['psc_id'] . "' onclick='addcommon(this.id)'><small><i class='fa fa-plus'></i></small></a> | &nbsp;<a href='http://192.0.0.125/TOOLS/" . $row['manufacturer'] . "/" . substr($row['manufacturer'], 0, 3) . " " . $row['model'] . ".pdf' target='_blank' class='float-center' id='" . $row['psc_id'] . "' ><small><i class='fa fa-file-text-o'></i></small></a> ", $row["description"], $calibrationnow, $row["last_use"], "<small>" . $stock_user . "</small>", $setstatus, "<a href='tools_imgs/" . $row["img"] . "' data-lightbox='image-1' data-title='" . $row["model"] . "' ><img src='tools_imgs/" . $row["img"] . "' class='img-thumbnail' width='50px' $onerrorprint /></a>", $button_get);
                }

                ?>
            </table>
        </div>

        <div class="">
            <?php
            $result2 = mysqli_query($link, $sqlextend) or die("Something wrong with DB please verify.");
            if (mysqli_num_rows($result2) > 0) {
                // Se recoge el número de resultados
                echo  'Found: ' . mysqli_num_rows($result2) . ' more Records on commonly used partnumber. <br>';
                echo "<div class='row'> ";
                while ($rowcommon = mysqli_fetch_array($result2)) {
                echo "<div style='padding:10px; '> ";
                    echo "<div class='card ' style='width: 15rem; height:5rem;'> ";
                        echo '<div class="row no-gutters">';
                    if (($rowcommon['img'] != NULL) || ($rowcommon['img'] != "")) {
                        echo " <div class='col-sm-4'>
                                <a href='" . $rowcommon['img'] . "' data-lightbox='image-1' data-title='" . $row["model"] . "'> <img src='" . $rowcommon['img'] . "' class='card-img' onerror=this.onerror=null;this.src='tools_imgs/no_image.png'> </a>
                            </div>";
                    } else {
                        echo " <div class='col-sm-4'>
                                <img src='tools_imgs/no_image.png' class='card-img' onerror=this.onerror=null;this.src='tools_imgs/no_image.png' >
                            </div>";
                    }
                            echo ' <div class="col-sm-8">';
                                echo "<div class='card-body'> ";
                                    echo "<small>PN: <b><a href='https://www.digikey.com/products/en?keywords=" . $rowcommon['component_pn'] . "' target='_blank'>" . $rowcommon['component_pn'] . "</a></b></small>";
                                    echo "<br>";
                                    echo "<small>Tool: <b><a href='index.php?srch=" . $rowcommon['tool_pn'] . "'>" . $rowcommon['tool_pn'] . "</a></b></small>";
                                echo "</div> ";
                            echo "</div> ";
                        echo "</div> ";
                    echo "</div> ";
                echo "</div> ";
                }
                echo "</div> ";
            }
            ?>
        </div>
    </div>
<?php
    mysqli_free_result($result);
    mysqli_close($link);
}
?>

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
            <form action="changestatus.php" method="post" id="modelforget" target="_self" onsubmit="event.preventDefault(); localvalidations();">
                <div class="modal-body">
                    Tool ID:
                    <input type="text" name="psc_id" id="psc_id" class="form-control input-sm" value="" placeholder="PSC-ID Ex. PSC-XXXX" autocomplete="off" readonly required>
                    <br>
                    Name:
                    <input type="text" name="employee" id="employee" class="form-control" value="" placeholder="User or Name" autocomplete="off" required>
                    <input type="text" name="process" id="process" value="" autocomplete="off" hidden readonly required>
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
            <form action="changestatus.php" method="post" target="_self" id="modelforreturn" onsubmit="event.preventDefault(); localvalidations_r();">
                <div class="modal-body">
                    Tool ID:
                    <input type="text" name="psc_id" id="psc_id_r" class="form-control input-sm" value="" autocomplete="off" readonly required>
                    <br>
                    Name:
                    <input type="text" name="employee" id="employee_r" class="form-control" value="RETURN" placeholder="User or Name" autocomplete="off" readonly required autofocus>
                    <input type="text" name="process" id="process_r" value="" autocomplete="off" hidden readonly required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="submitthis" class="btn btn-danger">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal for returning masive -->
<div class="modal fade" id="returning_m" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6>Returning Massive</h6>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="changestatus.php" method="post" target="_self" id="modelmasive">
                            <textarea rows="10" cols="1" width="100%" name="toosl_m" class="form-control" required></textarea>
                            <input type="text" name="massive" value="massive" readonly hidden>
                            <br>
                            <center><input type="submit" value="Return" class=" btn btn-sm btn-danger"></center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for verification in-use tool -->
<div class="modal fade" id="verification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6>verification</h6>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="verificationQ.php" method="get" target="_self">
                            <textarea rows="5" cols="1" width="100%" name="toosl_m" class="form-control" required></textarea>
                            <input type="text" name="quickver" value="vefificationfast" readonly hidden>
                            <br>
                            <center><input type="submit" value="Return" class=" btn btn-sm btn-danger"></center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL FOR DOWNLOAD GENERATED FILE  -->
<div class="modal fade" id="verification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6>verification</h6>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="card">
                                <div class="card-header">
                                    <?= $nameoffile ?>
                                </div>
                                <div class="card-body">
                                    <a href="<?= $csv_filename ?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> | Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="key_form" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Registry</h3>
            </div>
            <form action="registry" method="post" id="registry_form">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-cubes"></i></span>
                        </div>

                        <input type="text" class="form-control" placeholder="Company Name" name="user" id="user" required>
                    </div>
                    <br>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                        </div>

                        <input type="text" class="form-control" placeholder="Key" name="new_key" id="new_key" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success btn-sm" value="Save">
            </form>
            <a href="#" data-dismiss="modal" class="btn btn-danger btn-sm">Close</a>
        </div>
    </div>
</div>
</div>

<script>
    function addcommon(id) {
        id = id;
        var model = id;
        var newpartnumer = prompt("Enter the component partnumer. ");
        if ((newpartnumer != null) && (newpartnumer != "")) {
            window.location.href = "tool_details.php?id=" + id + "&newcommonpn=" + newpartnumer;
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
            setTimeout(function() {
                $('#employee').focus();
            }, 500);


        }
        document.getElementById("process").value = "0";


        document.getElementById("employee").focus();
    }

    function return_modal(id) {
        pcs_id = id;
        if (pcs_id == "returning") {

            document.getElementById("label_idtool_r").value = "RETURN";

            document.getElementById("psc_id_r").removeAttribute('readonly');


            setTimeout(function() {
                $('#psc_id_r').focus();
            }, 500);

        } else {

            document.getElementById("psc_id_r").value = pcs_id;
            document.getElementById("label_idtool_r").value = pcs_id;


            setTimeout(function() {
                $('#psc_id_r').focus();
            }, 500);
        }
        document.getElementById("process_r").value = "1";



    }

    function localvalidations() {
        var temp_psc_ID = document.getElementById("psc_id").value;
        var person = document.getElementById("employee").value;
        if (temp_psc_ID.length <= 7) {
            alert("ALERT: WRONG ID.");
        } else {
            if ((person != "") && (person != " ") && (person != null) && (person.length >= 3)) {
                document.getElementById('modelforget').submit();
            } else {
                alert("Verify name or user.");
            }

        }
    }

    function localvalidations_r() {
        var temp_psc_ID_r = document.getElementById("psc_id_r").value;
        if (temp_psc_ID_r.length <= 7) {
            alert("ALERT: WRONG ID.");
        } else {
            document.getElementById('modelforreturn').submit();
        }
    }
</script>
<?php
echo "<hr>";
include('../footer.php');
?>