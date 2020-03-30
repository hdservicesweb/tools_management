<?php
include('../conection.php');
date_default_timezone_set('America/Los_Angeles');
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
            echo "<script>location.replace('timer.php?e=1062');</script>";
        } elseif ($errorsql == '1452') {
            echo "<script>location.replace('timer.php?e=1452');</script>";
        } elseif ($errorsql == '1366') {
            echo "<script>location.replace('timer.php?e=1366');</script>";
        } else {
            echo "<script>alert('SOMETHING WENT WRONG! Try again.$errorsql');location.replace('timer.php?e=1');</script>";
        }
    } else {
        //SI NO HAY ERROR AL GUARDAR
        $toprint = 0;
    }
    // echo $SQL;
} else {
    $toprint = null;
    if ((isset($_REQUEST['e']))) {
        $toprint = $_REQUEST['e'];
    }
    //SI NO HAY VARIABLES QUE PROCESAR
    //echo date('l', strtotime($todayis));
    // echo date ('l',strtotime('09-03-20'));
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- <script defer src="../fontawesome/js/all.js"></script> -->
    <link rel="shortcut icon" href="../psc_logo.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <!--load all styles -->
    <link href="../lightbox/dist/css/lightbox.css" rel="stylesheet" />
    <title>TIME CLOCK</title>
    <link rel="stylesheet" href="../customs.css">

    <script src="../lightbox/dist/js/lightbox-plus-jquery.js"></script>


    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>



    <script>
        function openkey() {
            $(document).ready(function() {
                $("#key_form").modal("show");
            });
        }
    </script>


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
            var t = setTimeout(startTime, 1000);

            if (document.getElementById('functiontodo').value == "") {
                $('#employee_auto').focus();
            }


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


<body>
    <script src="ajax_timer.js"></script>
    <script>
        var url = "last_records_time.php";
    </script>
    <?php
    // echo $toprint;
    if ($toprint >= 1) {
        switch ($toprint) {
            case '1062':
                echo '<div id="moo" class="alert alert-danger alert-dismissible text-center" role="alert" auto-close="3000">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                ERROR Please Verify.
                <br>
                NO DUPLICATE TIME ALLOWED.
            </div>';
                break;

            case '1452':
                echo '<div id="moo" class="alert alert-danger alert-dismissible text-center" role="alert" auto-close="3000">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                ERROR Please Notify.
                <br>
                EMPLOYEE NUMBER UNREGISTERED.
            </div>';
                break;
            case '1366':
                echo '<div id="moo" class="alert alert-danger alert-dismissible text-center" role="alert" auto-close="3000">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                ERROR Please Notify.
                <br>
                INCORRECT DATA ENTRY.
            </div>';
                break;
            default:
                echo '<div id="moo" class="alert alert-danger alert-dismissible text-center" role="alert" auto-close="3000">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            ERROR.
            <br>
            
        </div>';
                break;
        }
    } elseif ((isset($toprint)) && ($toprint == 0)) {
    ?>
        <div class="alert alert-success alert-dismissible" role="alert" auto-close="3000">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            SUCCESS. Thank you!
        </div>
    <?php
    } else {
    ?>
        <div class="alert alert-warning alert-dismissible" role="alert" auto-close="3000">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            START TIMER
        </div>
    <?php
    }
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 style="font-size: 200px">
                    <div id="txt" class="text-center" style="font-family: digital_clock"></div>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-6"> </div>
            <div class="col-sm-12 col-md-6 float-center">
                <input type="text" name="employee_auto" id="employee_auto" value="" class="form-control" onkeypress="return runScript(event,this.value)" style="height: 200px;font-size: 100px;" required>
            </div>
            <div class="col-sm-12 col-md-12" style="position:fixed ;z-index:-1">
                <div id="contenido">
                    <div class="container-fluid" name="timediv" id="timediv">

                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">


            <div class="col-md-6"></div>
            <div class="col-md-3">
                <a href='#' id='clockin' class='text-white' data-toggle='modal' data-target='#clockset' onclick='update_modal(this.id)' style="text-decoration:none;">
                    <div class="card bg-success text-white" style="height: 220px">
                        <div class="card-body text-center">
                            <h1><b>CLOCK IN</b> </h1>
                            <br>
                            <i class="fa fa-clock-o" style="font-size: 80px"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href='#' id='clockout' class='text-white' data-toggle='modal' data-target='#clockset' onclick='update_modal(this.id)' style="text-decoration:none;">
                    <div class="card bg-danger text-white" style="height: 220px">
                        <div class="card-body text-center">
                            <h2><b>CLOCK OUT</b> </h2>
                            <br>
                            <i class="fa fa-clock-o" style="font-size: 80px"></i>
                        </div>
                    </div>
                </a>
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
                <form action="timer.php" method="post" id="model_clock" target="_self" onsubmit="event.preventDefault(); localvalidations();">
                    <div class="modal-body">
                        Scan Badge:
                        <input type="text" name="employee" id="employee" class="form-control" value="" placeholder="Employee Badge or Employee #" autocomplete="off" required>
                        <br>
                        <input type="text" name="process" id="functiontodo" value="" readonly required hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="javascript:window.location.href = 'timer.php'" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">Close</button>

                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
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
            if (person.length <= 3) {
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
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>