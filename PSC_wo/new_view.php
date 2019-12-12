<?php
include("../header.php");
$link = Conectarse();

$nowtime = date("m/d/Y");
if ((isset($_REQUEST['movefast'])) && $_REQUEST['movefast'] != ' ') {
    $psc_id_update = $_REQUEST['movefast'];
    $sqlexpedite = "SELECT position,psc_no from wo where id = '$psc_id_update'";
    $currentposition = mysqli_query($link, $sqlexpedite);

    $position = mysqli_fetch_array($currentposition);
    //wonumber captura el numero de la WO diferente del ID
    $wonumber = $position['psc_no'];
    if (($position['position'] == '1') || ($position['position'] == '2') || ($position['position'] == '3')) {
        $sqlfastupdate = "UPDATE wo set position = position + 1 where id = '$psc_id_update'";
        $executeupdate = mysqli_query($link, $sqlfastupdate);
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="alertdone">
        <strong>Success!</strong> ACTION HAS BEEN EXECUTED.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';

        //vitacora
        $executetime = date('Y-m-d H:i:s');
        if (($position['position'] == '1')) {
            $sqladdingtracking = "INSERT into wo_process (id,id_wo,wo,date,user,process) values (NULL,'$psc_id_update','$wonumber','$executetime','TO WAITING APPROVAL','MOVED FORWARD')";
        }
        if (($position['position'] == '2')) {
            $sqladdingtracking = "INSERT into wo_process (id,id_wo,wo,date,user,process) values (NULL,'$psc_id_update','$wonumber','$executetime','TO KITTING','MOVED FORWARD')";
        }
        if (($position['position'] == '3')) {
            $sqladdingtracking = "INSERT into wo_process (id,id_wo,wo,date,user,process) values (NULL,'$psc_id_update','$wonumber','$executetime','ASSIGNING EMPLOYEE','MOVED FORWARD')";
        }
        $executeV = mysqli_query($link, $sqladdingtracking);
    } else {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="alertdone">
        <strong>Warning!</strong> ACTION HAS ALREADY BEEN EXECUTED. <a href="new_view" class="alert-link"> Dismiss. </a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
} else {
    $psc_id_update = "";
}

if ((isset($_REQUEST['saved'])) && $_REQUEST['saved'] == '1') {
    if (isset($_REQUEST['psc_no'])) {
        $psc_no = $_REQUEST['psc_no'];
    } else {
        $psc_no = "ERROR";
    }
    if (isset($_REQUEST['picking'])) {
        $picking = $_REQUEST['picking'];
    } else {
        $picking = " ";
    }
    if (isset($_REQUEST['assy_pn'])) {
        $assy_pn = $_REQUEST['assy_pn'];
    } else {
        $assy_pn = " ";
    }
    if (isset($_REQUEST['customer'])) {
        $customer = $_REQUEST['customer'];
    } else {
        $customer = "0";
    }
    if (isset($_REQUEST['po'])) {
        $po = $_REQUEST['po'];
    } else {
        $po = "0";
    }
    if (isset($_REQUEST['qty'])) {
        $qty = $_REQUEST['qty'];
    } else {
        $qty = "1";
    }
    if (isset($_REQUEST['printed'])) {
        $printed = $_REQUEST['printed'];
    } else {
        $printed = $nowtime;
    }
    if (isset($_REQUEST['due_date'])) {
        $due_date = $_REQUEST['due_date'];
    } else {
        $due_date = $nowtime;
    }
    if (isset($_REQUEST['priorizetotal'])) {
        $priorizetotal = $_REQUEST['priorizetotal'];
    } else {
        $priorizetotal = "P1";
    }
    if (isset($_REQUEST['starting'])) {
        $starting = $_REQUEST['starting'];
    } else {
        $starting = "1";
    }
    $SQLinsert = "INSERT INTO `wo` (`id`, `psc_no`, `picking`, `assy_pn`, `customer`, `po`, `qty`, `printed`, `due_date`, `priorizetotal`, `last_employee`, `status`, `position`, `note`, `fieldextra1`, `fieldextra2`, `last_movement`) VALUES (NULL, '$psc_no', '$picking', '$assy_pn', '1', '0', '$qty', CURRENT_TIMESTAMP, '$due_date', '$priorizetotal', '$namestation', '0', '$starting', NULL, NULL, NULL, CURRENT_TIMESTAMP);";
    //echo $SQLinsert;
    if (mysqli_query($link, $SQLinsert)) {
        $lasredg = mysqli_insert_id($link);
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="alertdone">
       <strong>Success!</strong> WO have added to proccess.<a href="../TCPDF-master/examples/psc_wo_box.php?wo=' . $lasredg . '" target="_blank" class="alert-link"> <i class="fa fa-print"></i> PRINT </a>
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>';

        //  -->> VITACORA   

        $sqladdingtracking = "INSERT into wo_process (id,id_wo,wo,date,user,process) values (NULL,'$lasredg','$psc_no',CURRENT_TIMESTAMP,'$namestation','WO CREATED')";

        $executeV = mysqli_query($link, $sqladdingtracking);
        //  -->> VITACORA 
    } else {

        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertdone">
        <strong>ERROR!</strong> Please verify information. (DUPLICATED VALUE)<a href="new_view" class="alert-link"> Dismiss. </a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
}
?>
<script src="../ajax.js"></script>
<script>
    var url = "new_view_data.php";
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
        <div class="col-4">
            <div class="card">
                <form action="new_view.php" id="form-newWO" onsubmit="event.preventDefault(); prevalidation();" method="post">
                    <div class="card-header bg-secondary text-white">New WO for Tracking</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">


                                <label for="validationServer03">Description No.:</label>
                                <input type="text" class="form-control " name="psc_no" id="psc_no" placeholder="PSC No." onblur="agregarclase()" autocomplete="off" required>
                                <div class="invalid-feedback">
                                    Please provide correct Description No.
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="">Assembly Picking T:</label>
                                <input type="text" name="picking" class="form-control">
                            </div>
                        </div><br>
                        <div class="row">

                            <div class="col-12">
                                <label for="">TOP Assembly Part No.:</label>
                                <input type="text" name="assy_pn" class="form-control">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <label for="">Customer:</label>
                                <!-- <select name="customer" id="customer"></select> -->
                                <select name="customer" id="customer" data-placeholder="Customer" class="select form-control" tabindex="1">
                                    <option value="1">PSC</option>
                                </select>

                            </div>
                            <div class="col-4">
                                <label for="">PO:</label>
                                <input type="text" name="po" class="form-control">
                            </div>
                            <div class="col-4">
                                <label for="">Qty:</label>
                                <input type="text" name="qty" id="qty" onblur="resaltarqty()" autocomplete="off" class="form-control" required>
                                <div class="invalid-feedback">
                                    Qty must be > or = 1.
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Date Printed:</label>
                                <input type="text" name="printed" class="form-control" value="<?= $nowtime ?>" readonly>

                            </div>
                            <div class="col-6">
                                <label for="">Date Due:</label>
                                <input type="date" name="due_date" class="form-control" min='2019-01-01' required>
                            </div>

                        </div><br>
                        <div class="row">
                            <div class="col-3">
                                <label for="">Prioritize:</label><br>
                                <center>
                                    <a href="#" id="P1" onclick="priorize(this.id)"><i class="fa fa-star" aria-hidden="true" style="color:green"></i></a>
                                    <a href="#" id="P2" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                    <a href="#" id="P3" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                    <a href="#" id="P4" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                    <a href="#" id="P5" onclick="priorize(this.id)"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                </center>
                                <input type="text" value="P1" name="priorizetotal" id="priorizetotal" readonly hidden>
                            </div>
                            <div class="col-4">
                                <br>
                                <select name="starting" id="starting" class="form-control">
                                    <option value="1">Work Order Registration</option>
                                    <option value="2">Prior approval</option>
                                    <option value="3">Kitting</option>
                                    <option value="4">Ready for assign</option>
                                    <option value="5">In Process</option>
                                    <option value="6">Done</option>
                                    <option value="7">Quality Control</option>
                                    <option value="8">Packing</option>
                                    <option value="9">Shipped</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <br><input type="text" id="saved" name="saved" value="0" readonly hidden>
                                <center>
                                    <button type="submit" class="btn btn-info form-control"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
                                    &nbsp;
                                    <br>
                                    <button type="button" onclick="location.href='index';" class="btn btn-dark form-control"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                                </center>

                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header bg-info text-white">OPEN WO - Tracking</div>
                <div id="contenido">
                    <div name="timediv" id="timediv">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<script>
    function priorize(id) {
        var stars = id;
        switch (stars) {
            case "P1":
                document.getElementById("P1").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:green'></i>";
                document.getElementById("P2").innerHTML = "<i class='fa fa-star-o' aria-hidden='true' ></i>";
                document.getElementById("P3").innerHTML = "<i class='fa fa-star-o' aria-hidden='true'></i>";
                document.getElementById("P4").innerHTML = "<i class='fa fa-star-o' aria-hidden='true'></i>";
                document.getElementById("P5").innerHTML = "<i class='fa fa-star-o' aria-hidden='true'></i>";

                break;
            case "P2":
                document.getElementById("P1").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:green'></i>";
                document.getElementById("P2").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:green'></i>";
                document.getElementById("P3").innerHTML = "<i class='fa fa-star-o' aria-hidden='true'></i>";
                document.getElementById("P4").innerHTML = "<i class='fa fa-star-o' aria-hidden='true'></i>";
                document.getElementById("P5").innerHTML = "<i class='fa fa-star-o' aria-hidden='true'></i>";

                break;
            case "P3":
                document.getElementById("P1").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:orange'></i>";
                document.getElementById("P2").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:orange'></i>";
                document.getElementById("P3").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:orange'></i>";
                document.getElementById("P4").innerHTML = "<i class='fa fa-star-o' aria-hidden='true'></i>";
                document.getElementById("P5").innerHTML = "<i class='fa fa-star-o' aria-hidden='true'></i>";

                break;
            case "P4":
                document.getElementById("P1").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:orange'></i>";
                document.getElementById("P2").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:orange'></i>";
                document.getElementById("P3").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:orange'></i>";
                document.getElementById("P4").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:orange'></i>";
                document.getElementById("P5").innerHTML = "<i class='fa fa-star-o' aria-hidden='true'></i>";

                break;
            case "P5":
                document.getElementById("P1").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:red'></i>";
                document.getElementById("P2").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:red'></i>";
                document.getElementById("P3").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:red'></i>";
                document.getElementById("P4").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:red'></i>";
                document.getElementById("P5").innerHTML = "<i class='fa fa-star' aria-hidden='true' style='color:red'></i>";

                break;
            default:
                break;
        }
        document.getElementById("priorizetotal").value = stars;
    }

    function agregarclase() {
        var tempno = document.getElementById("psc_no").value;
        if (tempno == "" || tempno == " " || tempno.length <= 5 || isNaN(tempno)) {
            document.getElementById("psc_no").classList.add("is-invalid");
            return;
        } else {
            document.getElementById("psc_no").classList.remove("is-invalid");
            return;
        }
    }

    function resaltarqty() {
        var qty = document.getElementById("qty").value;
        if (qty == "" || qty == " " || isNaN(qty)) {
            document.getElementById("qty").classList.add("is-invalid");
            return;
        } else {
            document.getElementById("qty").classList.remove("is-invalid");
            return;
        }
    }

    function prevalidation() {
        var aprobado = 0;
        var tempno = document.getElementById("psc_no").value;
        if (tempno == "" || tempno == " " || tempno.length <= 5 || isNaN(tempno)) {
            document.getElementById("psc_no").classList.add("is-invalid");
            aprobado = 0;

        } else {
            aprobado = 1;
            document.getElementById("psc_no").classList.remove("is-invalid");

        }

        if (aprobado == 1) {
            document.getElementById("saved").value = "1";
            document.getElementById("form-newWO").submit();
        } else {
            return;
        }
    }

    function movefast(id) {
        psc_no = id;
        window.location.href = "new_view.php?movefast=" + id;
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
                    alert("STATUS CHANGED");
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
<script>
    $(document).ready(function() {
        $('#alertdone').toast('hide')


    });
</script>
<?php
include('../footer.php');
?>