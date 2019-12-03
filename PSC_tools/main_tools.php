<?php
include('../header.php');
$link = Conectarse();
if ($search == "") {
    ?>
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3">
            </div>
            <div class="col-md-3">

                <div class="card" style="">
                    <br>
                    <center>

                        <i class="fa fa-arrow-left" style="color:green;font-size:80px"></i>
                    </center>
                    <a href='#' id='getting' class='btn btn-light btn-sm' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'>
                        <div class="card-body bg-success text-light">
                            <h5 class="card-title">
                                <center>GET</center>
                            </h5>
                            <p class="card-text">Push this button when you need to use a tool.</p>

                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-1">
            </div>
            <div class="col-md-3">


                <div class="card" style="">
                    <br>
                    <center>
                        <i class="fa fa-arrow-right" style="color:red;font-size:80px"></i>
                    </center>

                    <a href='#' id='returning' class='btn btn-light btn-sm' data-toggle='modal' data-target='#return_tool' onclick='return_modal(this.id)'>
                        <div class="card-body bg-danger text-light">
                            <center>
                                <h5 class="card-title"> RETURN</h5>
                                <p class="card-text">Push this button when you finish.</p>

                            </center>
                        </div>
                    </a>
                    <center><a href="#" id="massive" class="btn btn-sm btn-danger form-control" data-toggle='modal' data-target='#returning_m' >Massive Return</a></center>
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
    $sqlextend = "SELECT * from common_tb where component_pn like '%" . $search . "%'
         OR trimmed like '%" . $search . "%'";
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

        $records = "No matches.";
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
            <a href="https://www.digikey.com/products/en?keywords=<?=$search?>" id="new" class="btn btn-sm btn-info " target="_blank"><i class="fa fa-search"></i> Digikey</a> 
            <a href="https://octopart.com/search?q=<?=$search?>" id="new" class="btn btn-sm btn-info " target="_blank"><i class="fa fa-search"></i> Octopart</a> 
            <a href="new_tool.php" id="new" class="btn btn-sm btn-success float-right"><i class="fa fa-plus"></i> ADD TOOL</a>
        </p>

        <div class="container">
            <table class="table table-sm table-default">
                <?php
                    if ($row = mysqli_num_rows($result) > 0) {
                        printf("<tr><th>&nbsp;%s</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th></tr>", "PSC ID", "BRAND", "MODEL", "DESCRIPTION", "LAST USED DATE", "STORAGE", "STATUS", "IMG", "ACTIONS");
                    }
                    while ($row = mysqli_fetch_array($result)) {
                        if ($row['available'] == '1') {
                            $stock_user = $row["stock"];
                            $setstatus = "<img src='components/available.png' width='10px' alt='AVAILABLE'/>";
                            $button_get = "<a href='tool_details.php?id=" . $row['psc_id'] . "' class='btn btn-link'> <i class='fa fa-list-ul' style='font-size:15px'></i> </a> <a href='#' id='" . $row['psc_id'] . "' class='btn btn-success btn-sm' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'><i class='fa fa-arrow-left' style='font-size:15px'></i></a>";
                        } elseif ($row['available'] == '-1') {
                            $stock_user = "DAMAGED";
                            $setstatus = "<img src='components/damaged.png' width='10px' alt='DAMAGED'/>";
                            $button_get = "<a href='tool_details.php?id=" . $row['psc_id'] . "' class='btn btn-link'> <i class='fa fa-list-ul' style='font-size:15px'></i> </a> <a href='#' id='" . $row['psc_id'] . "' class='btn btn-success btn-sm' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'><i class='fa fa-arrow-left' style='font-size:15px'></i></a>";
                        } else {
                            $stock_user = "[" . $row["stock"] . "] - " . $row["user_know"];
                            $setstatus = "<img src='components/notavailable.png' width='10px' alt='NOT AVAILABLE'/>";
                            $button_get = "<a href='tool_details.php?id=" . $row['psc_id'] . "' class='btn btn-link'> <i class='fa fa-list-ul' style='font-size:15px'></i> </a> <a href='#' id='" . $row['psc_id'] . "' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#return_tool' onclick='return_modal(this.id)'><i class='fa fa-arrow-right' style='font-size:15px'></i></a>";
                        }
                        printf("<tr><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", "<h6>" . $row["psc_id"] . "</h6>", "<h6>" . $row["manufacturer"] . "</h6>", "<h6>" . $row["model"] . "</h6>", "<h6>" . $row["description"] . "</h6>", "<h6>" . $row["last_use"] . "</h6>", "<small><h6>" . $stock_user . "</h6></small>", "<h6>" . $setstatus . "</h6>", "<a href='tools_imgs/" . $row["img"] . "' data-lightbox='image-1' data-title='" . $row["model"] . "'><img src='tools_imgs/" . $row["img"] . "' width='70px'/></a>", $button_get);
                    }

                    ?>
            </table>
        </div>

        <div class="">
            <?php
                $result2 = mysqli_query($link, $sqlextend) or die("Something wrong with DB please verify.");
                if (mysqli_num_rows($result2) > 0) {
                    // Se recoge el número de resultados
                    echo  'Found: ' . mysqli_num_rows($result2) . ' more Records on commonly used partnumber.';
                    while ($rowcommon = mysqli_fetch_array($result2)) {
                        echo "<br><a href='main_tools.php?srch=" . $rowcommon['tool_pn'] . "'>" . $rowcommon['component_pn'] . "</a>";
                    }
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
                            <input type="text" name="massive"  value="massive" readonly hidden>
                            <br>
                            <center><input type="submit" value="Return" class=" btn btn-sm btn-danger"></center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
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
                $('#psc_id').focus();
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
        if (temp_psc_ID.length <= 7) {
            alert("ALERT: WRONG ID.");
        } else {
            document.getElementById('modelforget').submit();
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