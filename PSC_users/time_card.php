<?php
include("../header.php");
$link = Conectarse();
$todayis = date('m/d/Y');
$dateforsave = date('Y-m-d');
$horadeponche = date('h:i:s');
//echo $todayis;
if (isset($_REQUEST['periods'])) {
    $periods = $_REQUEST['periods'];
    //echo $employee_id;
} else {
    $periods = "";
}

if (isset($_REQUEST['employee_id'])) {
    $employee_id = $_REQUEST['employee_id'];
    //echo $employee_id;
    if (isset($_REQUEST['option_insert'])) {
        $option_insert = $_REQUEST['option_insert'];
        $dateandtime = $_REQUEST['manual-time'];
        $inserteddate = date("Y-m-d", strtotime($dateandtime));
        $insertedtime = date("H:i:s", strtotime($dateandtime));
        
        $SQL = "INSERT INTO `time_card_records` (`id`, `employee_id`, `process`, `time`, `date`, `date_time`, `period`, `e_field_1`, `e_field_2`) VALUES (NULL, '$employee_id', '$option_insert', '$insertedtime', '$inserteddate', CURRENT_TIMESTAMP, '0', '2', NULL);";
        // echo $SQL;
        if ($execprocess = mysqli_query($link, $SQL) ){
            echo "Saved Correctly";
        }else{
            echo "error";
        }

    }
} else {
    $employee_id = "";
}


if ((isset($_POST['process'])) && (isset($_POST['employee']))) {
    $varemployee = $_POST['employee'];
    $varprocess = $_POST['process'];

    //AQUI CONDICIONES ANTES DE GUARDAR CALCULAR HORA DE INGRESO



    //FIN DE CODICIONES
    $SQL = "INSERT INTO `time_card_records` (`id`, `employee_id`, `process`, `time`, `date`, `date_time`, `period`, `e_field_1`, `e_field_2`) VALUES (NULL, '$varemployee', '$varprocess', '$horadeponche', '$dateforsave', CURRENT_TIMESTAMP, '0', '1', NULL);";
    // if ($execprocess = mysqli_query($link, $SQL) or die("Something wrong with DB please verify.")){
    //     echo "SE HA GUARDADO";
    // }else{
    //     echo "error";
    // }

    mysqli_query($link, $SQL);
    if ($errorsql = mysqli_errno($link)) {
        if ($errorsql == '1062') {
            echo "<script>alert('ERROR. Entry already registered.');location.replace('time_card.php?e=1');</script>";
        } elseif ($errorsql == '1452') {
            echo "<script>alert('ERROR. No registered employee number.');location.replace('time_card.php?e=1');</script>";
        } elseif ($errorsql == '1366') {
            echo "<script>alert('ERROR. INCORRECT DATA ENTRY.');location.replace('time_card.php?e=1');</script>";
        } else {
            echo "<script>alert('SOMETHING WENT WRONG! Try again.$errorsql');location.replace('time_card.php?e=1');</script>";
        }
    } else {
        //SI NO HAY ERROR AL GUARDAR
        $toprint = 2;
    }
    // echo $SQL;
} else {
    $toprint = 0;
    if ((isset($_REQUEST['e']))) {
        $toprint = $_REQUEST['e'];
    }
    //SI NO HAY VARIABLES QUE PROCESAR
    //echo date('l', strtotime($todayis));
    // echo date ('l',strtotime('09-03-20'));

}
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<style>
    @font-face {
        font-family: digital_clock;
        src: url(digital-7.ttf);
    }
</style>


<script>
    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('txt').innerHTML =
            h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);

        $('#employee_auto').focus();

    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }; // add zero in front of numbers < 10
        return i;
    }

    $(function() {
        var alert = $('div.alert[auto-close]');
        alert.each(function() {
            var that = $(this);
            var time_period = that.attr('auto-close');
            setTimeout(function() {
                that.alert('close');
            }, time_period);
        });
    });

    function runScript(e, value) {
        var scann = value;
        //See notes about 'which' and 'key'
        if (e.keyCode == 13) {
            var date_javaS = new Date();
            var timestamp_hours = date_javaS.getHours();
            if (timestamp_hours >= 12) {
                document.getElementById("functiontodo").value = "2";
            } else {
                document.getElementById("functiontodo").value = "1";
            }
            document.getElementById("employee").value = scann;
            document.getElementById('model_clock').submit();
        }
    }
</script>
</head>

<!-- <body onload="startTime()"> -->

<body>


    <?php
    // echo $toprint;
    if ($toprint == 1) {
    ?>
        <div id="moo" class="alert alert-danger alert-dismissible" role="alert" auto-close="3000">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            ERROR Please Verify.
        </div>
    <?php
    } elseif ($toprint == 2) {
    ?>
        <div class="alert alert-success alert-dismissible" role="alert" auto-close="3000">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            SUCCESS. Thank you!
        </div>
    <?php
    } else {
    }
    ?>

    <div class="container-fluid">

        <br>
        <div class="row">

            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        Settings <a href="#" class="btn btn-sm float-right"><i class="fa fa-sliders" aria-hidden="true"></i></a>
                    </div>
                    <form action="time_card_update.php" method="POST" target="_blank">
                        <div class="card-body">
                            <hr>
                            <p align="center">MAIN SETTINGS</p>

                            <div class="row">
                                <?php

                                $sqlforsettings = "SELECT * from settings where registry = 'time_cards_settings'";
                                $excesqlforsettings = mysqli_query($link, $sqlforsettings);

                                while ($valuefiels = mysqli_fetch_array($excesqlforsettings)) {
                                    switch ($valuefiels['functions']) {
                                        case 'checkin':
                                            $checkin_value = $valuefiels['value'];
                                            break;
                                        case 'checkout':
                                            $checkin_out = $valuefiels['value'];
                                            break;
                                        case 'avoid_function':
                                            $avoid_function = $valuefiels['value'];
                                            break;
                                        case 'minutes_restriction':
                                            $minutes_restriction = $valuefiels['value'];
                                            break;

                                        case 'lunchtime':
                                            $lunchtime = $valuefiels['value'];
                                            break;
                                        default:
                                            # code...
                                            break;
                                    }
                                }

                                ?>
                                <div class="col-sm-3">Check IN :
                                    <div class="input-group mb-3">

                                        <input type="text" class="form-control" name="CheckInTime" readonly value="<?= $checkin_value ?>">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-pencil icon"></i></span>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-3">Check OUT :
                                    <div class="input-group mb-3">

                                        <input type="text" class="form-control" name="CheckOutTime" readonly value="<?= $checkin_out ?>">

                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-pencil icon"></i></span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-3 text-center">Avoid CheckIN
                                    <div class="row text-center">
                                        <div class="col-12 text-center">
                                            <div class="input-group mb-3 text-center">
                                                <p align="center" class="text-center">
                                                    <?php
                                                    if ($avoid_function == '1') {
                                                    ?> <a href="#" class="btn btn-success"><i class="fa fa-square-o" aria-hidden="true"></i>

                                                        <?php
                                                    } else {
                                                        ?> <a href="#" class="btn btn-danger"><i class="fa fa-square-o" aria-hidden="true"></i>

                                                            <?php
                                                        }
                                                            ?>
                                                            </a>
                                                </p>


                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-sm-3">Avoid Limit :
                                    <div class="input-group mb-3">

                                        <input type="text" class="form-control" name="CheckOutTime" readonly value="<?= $minutes_restriction ?>">

                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-pencil icon"></i></span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <hr>
                            <p align="center">TOLERANCE TIME</p>
                            <div class="row">
                                <div class="col-sm-4">Check IN Time:
                                    <div class="input-group mb-3">

                                        <input type="text" class="form-control" name="CheckInTime" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-pencil icon"></i></span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-4">Check OUT Time:
                                    <div class="input-group mb-3">

                                        <input type="text" class="form-control" name="CheckOutTime" readonly>

                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-pencil icon"></i></span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-4">Lunch time (minutes)
                                    <div class="input-group mb-3">

                                        <input type="text" class="form-control" name="CheckOutTime" readonly value="<?= $lunchtime ?>">

                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-pencil icon"></i></span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                Periods:
                                <div class="float-right">
                                    <a href="#" class="btn btn-sm btn-default"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <select name="select_period" id="select_period" class="form-control form-control-xs" onchange="updatedates(this.value)">
                                    <?php
                                    $sql_per = "SELECT id, date_format(start_date,'%m/%d/%Y') as date1,date_format(end_date,'%m/%d/%Y') as date2 from time_card_periods order by id desc limit 5";
                                    $sql_per_exec = mysqli_query($link, $sql_per);
                                    $empty_id = $periods;
                                    while ($quickselect = mysqli_fetch_array($sql_per_exec)) {
                                        if ($empty_id == "") {
                                            $empty_id = $quickselect['id'];
                                        }
                                        if ($quickselect['date2'] == null) {
                                            $date2 = "??" . " Today(" . date('m/d/Y') . ")";
                                            $start_date2 = date('m/d/Y');
                                        } else {
                                            $date2 = $quickselect['date2'];
                                        }
                                        if ($periods == $quickselect['id']) {
                                            $select_start = "selected";
                                        } else {
                                            $select_start = "";
                                        }
                                        echo "<option value='" . $quickselect['id'] . "' $select_start>" . $quickselect['date1'] . " - " . $date2 . "</option>";
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header">
                                Insert missing value:
                                <div class="float-right">
                                    <!-- <a href="#" class="btn btn-sm btn-default"><i class="fa fa-plus"></i></a> -->
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="time_card.php">
                                    <div class="row">
                                        <div class="col-6">
                                            Employee ID:
                                            <input type="text" name="employee_id" class="form-control form-control-sm" value="<?=$employee_id?>" required>
                                        </div>
                                        <div class="col-6">
                                            <p align="center"><small> IN / OUT </small> <br>
                                                Input&nbsp;<input type="radio" name="option_insert" id="" value="1">
                                                &nbsp;|&nbsp; Output&nbsp;<input type="radio" name="option_insert" id="" value="2" default checked>
                                            </p>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-12">
                                            Date / Time:
                                            <input type="datetime-local" id="manual-time" name="manual-time" value="<?php echo date("Y-m-d", strtotime($dateforsave . "- 1 days"))  ?>T14:30" min="2019-01-01T00:00" max="<?= $dateforsave ?>T14:30" class="form-control">
                                            <br>
                                            <p align="center">
                                                <input type="submit" name="save" value="Save" class="btn btn-sm btn-success">
                                                &nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="btn btn-sm btn-danger" onclick="javascript:window.location='time_card.php';">
                                            </p>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>

                </div><br>
                <div class="row">
                    <div class="col-md-6">
                        <a href='#' id='clockin' class='text-white' data-toggle='modal' data-target='#clockset' onclick='update_modal(this.id)' style="text-decoration:none;">
                            <div class="card bg-success text-white" style="height: 160px">
                                <div class="card-body text-center">
                                    <h5><b>CLOCK IN</b> </h5>
                                    <br>
                                    <i class="fa fa-clock-o" style="font-size: 40px"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href='#' id='clockout' class='text-white' data-toggle='modal' data-target='#clockset' onclick='update_modal(this.id)' style="text-decoration:none;">
                            <div class="card bg-danger text-white" style="height: 160px">
                                <div class="card-body text-center">
                                    <h5><b>CLOCK OUT</b> </h5>
                                    <br>
                                    <i class="fa fa-clock-o" style="font-size: 40px"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>


            <div class="col-md-5">
                <div class="card card-info">
                    <div class="card-header">
                        <form action="time_card.php" method="get">


                            Generate Time Card for: &nbsp;
                            <input type="text" class="input-sm" name="employee_id" placeholder="Scan or Type Employee #" value="<?=$employee_id?>">
                            <input type="text" class="input-sm" name="periods" id="periods" placeholder="" value="<?= $empty_id ?>" readonly hidden>

                            <input type="submit" class="btn btn-default btn-sm float-right" value=">>" />
                        </form>
                    </div>
                    <div class="card-body">
                        <iframe src="../TCPDF-master/examples/time_card.php?employee_id=<?= $employee_id ?>&periods=<?= $periods ?>" frameborder="0" width="100%" height="600px"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for get tool -->
    <div class="modal fade" id="clockset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div id="timeexact">Clocking Date: </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="time_card.php" method="post" id="model_clock" target="_self" onsubmit="event.preventDefault(); localvalidations();">
                    <div class="modal-body">
                        Scan Badge:
                        <input type="text" name="employee" id="employee" class="form-control" value="" placeholder="Employee Badge or Employee #" autocomplete="off" required>
                        <br>
                        <input type="text" name="process" id="functiontodo" value="" readonly required hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function update_modal(id) {
            document.getElementById("timeexact").innerHTML = "DATE: <?= $todayis ?>";
            process = id;
            if (process == "clockin") {
                setTimeout(function() {
                    $('#employee').focus();
                }, 500);
                document.getElementById("functiontodo").value = "1";
            } else {

                setTimeout(function() {
                    $('#employee').focus();
                }, 500);
                document.getElementById("functiontodo").value = "2";

            }

        }

        function localvalidations() {

            var person = document.getElementById("employee").value;
            if (person.length <= 5) {
                alert("ALERT: WRONG ID.");
            } else {
                if ((person != "") && (person != " ") && (person != null) && (person.length >= 3)) {
                    document.getElementById('model_clock').submit();
                } else {
                    alert("Verify name or user.");
                }

            }
        }

        function createCustomAlert(txt) {
            d = document;

            if (d.getElementById("modalContainer")) return;

            mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
            mObj.id = "modalContainer";
            mObj.style.height = d.documentElement.scrollHeight + "px";

            alertObj = mObj.appendChild(d.createElement("div"));
            alertObj.id = "alertBox";
            if (d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
            alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth) / 2 + "px";
            alertObj.style.visiblity = "visible";

            h1 = alertObj.appendChild(d.createElement("h1"));
            h1.appendChild(d.createTextNode(ALERT_TITLE));

            msg = alertObj.appendChild(d.createElement("p"));
            //msg.appendChild(d.createTextNode(txt));
            msg.innerHTML = txt;

            btn = alertObj.appendChild(d.createElement("a"));
            btn.id = "closeBtn";
            btn.appendChild(d.createTextNode(ALERT_BUTTON_TEXT));
            btn.href = "#";
            btn.focus();
            btn.onclick = function() {
                removeCustomAlert();
                return false;
            }

            alertObj.style.display = "block";

        }

        function removeCustomAlert() {
            document.getElementsByTagName("body")[0].removeChild(document.getElementById("modalContainer"));
        }

        function updatedates(value) {
            var period_id = value;
            document.getElementById("periods").value = period_id;
        }
    </script>
    <?php
    include('../footer.php');
    ?>