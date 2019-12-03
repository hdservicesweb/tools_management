<?php
include("../header.php");
$link = Conectarse();
$optiontext = "";
if ((isset($_REQUEST['selector'])) && ($_REQUEST['selector'] != 0)) {
    if (isset($_REQUEST['textfield'])) {
        $optiontext = $_REQUEST['textfield'];
    } else {
        $optiontext = "";
    }
    $selector = $_REQUEST['selector'];
    $info = "test";
    switch ($selector) {
            // SELECTION is looking for all in used tools
        case 1:
            $value = "RESULTS FOR: In use tools";
            $optiontextattrib = "readonly";
            $optiontext = "";
            $sqlsearch = "SELECT * from tools_main_db where available = '0' order by last_use,manufacturer desc";
            $result1 = mysqli_query($link, $sqlsearch) or die("Something wrong with DB please verify.");
            break;
        case 2:
            $value = "RESULTS FOR: Using tools by";
            $optiontextattrib = "";
            $sqlsearch = "SELECT * from tools_main_db where available = '0' and user_know like '%$optiontext%' order by last_use,manufacturer desc";
            $result1 = mysqli_query($link, $sqlsearch) or die("Something wrong with DB please verify.");
            break;
        case 3:
            $value = "RESULTS FOR: Used tools by User";
            $optiontextattrib = "";
            $sqlsearch = "SELECT TP.psc_id,TM.manufacturer,TM.model,TP.date as last_use,TP.name,TM.available,TM.stock,TM.user_know,TM.img FROM `tools_process` TP INNER JOIN tools_main_db TM on TP.psc_id = TM.psc_id where TP.name like '%$optiontext%' and TP.process = '0' group by TP.psc_id order by TP.date desc limit 20";
            //$sqlsearch = "SELECT * FROM `tools_process` TP INNER JOIN tools_main_db TM on TP.psc_id = TM.psc_id where TP.name like '%$optiontext%' and TP.process = '0' order by TP.date desc limit 20";
            $result1 = mysqli_query($link, $sqlsearch) or die("Something wrong with DB please verify.");
            break;
        case 4:
            $value = "RESULTS FOR: Using more than 15 days";
            $optiontextattrib = "readonly";
            $sqlsearch = "SELECT * from tools_main_db where available = '0' order by last_use,manufacturer desc";
            $result1 = mysqli_query($link, $sqlsearch) or die("Something wrong with DB please verify.");
            break;
            case 5:
            $value = "RESULTS FOR: Most Recent tools";
            $optiontextattrib = "readonly";
            $sqlsearch = "SELECT * from tools_main_db order by reg_date desc limit 25";
            $result1 = mysqli_query($link, $sqlsearch) or die("Something wrong with DB please verify.");
            break;
        default:
            $optiontextattrib = "";
            $sqlsearch = "";
            $result1 = mysqli_query($link, $sqlsearch) or die("Something wrong with DB please verify.");
            break;
    }
    if (mysqli_num_rows($result1) > 0) {
        // Se recoge el número de resultados
        $info = 'Found: ' . mysqli_num_rows($result1) . ' Records.';
    } else {

        $info = "No matches.";
    }
} else {
    $optiontextattrib = "readonly";
    $selector = 0;
    $info = "";
    $value = "";
}
?>
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-3 ">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        SEARCH CRITERIA:
                    </div>
                    <div class="card-body">
                        <form action="show_me.php">
                            <select name="selector" id="selector" class="form-control" onchange="updateform(this.value)">
                                <option value="<?= $selector ?>"><?= $value ?></option>
                                <option disabled>
                                    <hr>---------------------------------------</option>
                                <option value="1">In use tools:</option>
                                <option value="2">In use by User:</option>
                                <option value="3">Last Tool used by User:</option>
                                <option value="4">More than 15 Days requested:</option>
                                <option value="5">Most recent tools:</option>
                            </select>
                            <br>
                            <input type="text" class="form-control" name="textfield" id="textfield" value="<?= $optiontext ?>" <?= $optiontextattrib ?>>
                            <br>
                            <a href="show_me" class="btn btn-sm btn-secondary"><i class='fa fa-times fa-lg'> </i>&nbsp;CANCEL </a>
                            <button type="submit" class="btn btn-info btn-sm">
                                GO <i class="fa fa-chevron-right fa-lg"></i>
                            </button>

                        </form>
                    </div>
                </div>
                <br>
                <p>
                    <?= $info ?>
                </p>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        RESULTS
                    </div>
                    <div class="card-body">
                        <?php
                        if ($selector >= 1) {
                            echo  "<table class='table table-sm table-default'>";
                            $x = 0;
                            while ($row = mysqli_fetch_array($result1)) {
                                $noprint = '0';
                                if ($selector == '4') {
                                    $calcdays = "SELECT DATEDIFF(now(), (select last_use from tools_main_db where psc_id = '" . $row['psc_id'] . "')) as days";
                                    $execdays = mysqli_query($link, $calcdays);
                                    $days = mysqli_fetch_array($execdays);
                                    if (($days['days']) >= '10') {
                                        $noprint = "0";
                                    } else {
                                        $noprint = "1";
                                    }
                                } else {
                                    $noprint = "0";
                                }
                                $x++;
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
                                if ($noprint == '0') {
                                    printf("<tr><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", "<h6>" . $x . "</h6>", "<h6>" . $row["psc_id"] . "</h6>", "<h6>" . $row["manufacturer"] . "</h6>", "<h6>" . $row["model"] . "</h6>", "<h6>" . $row["last_use"] . "</h6>", "<small><h6>" . $stock_user . "</h6></small>", "<h6>" . $setstatus . "</h6>", "<a href='tools_imgs/" . $row["img"] . "' data-lightbox='image-1' data-title='" . $row["model"] . "'><img src='tools_imgs/" . $row["img"] . "' width='70px'/></a>", $button_get);
                                }
                            }
                            echo "</table>";
                        } else {
                            echo "<p align='center'>EMPTY SELECTOR <br> <br>";
                            echo "<img src='psc_logo.png'/> </p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="col-md-12">
        <p><small><i>
                    <li>The show option was created to perform a conditional search on the items stored in the database of hand tools
                </i></small></p>
    </div>

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
                        <input type="text" name="psc_id" id="psc_id_r" class="form-control input-sm" value="" readonly required>
                        <br>
                        Name:
                        <input type="text" name="employee" id="employee_r" class="form-control" value="RETURN" placeholder="User or Name" readonly required autofocus>
                        <input type="text" name="process" id="process_r" value="" hidden readonly required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit" class="btn btn-danger">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function lounch() {
            var select = document.getElementById('selector').value;
            alert(select);

        }

        function return_modal(id) {
            pcs_id = id;
            if (pcs_id == "returning") {
                document.getElementById("psc_id_r").removeAttribute('readonly');
                document.getElementById("label_idtool_r").value = "RETURN";
                document.getElementById("psc_id_r").focus();
            } else {

                document.getElementById("psc_id_r").value = pcs_id;
                document.getElementById("label_idtool_r").value = pcs_id;


            }
            document.getElementById("process_r").value = "1";
        }

        function updateform(value) {
            var selectoption = value;
            if ((selectoption == '1') || (selectoption == '4') || (selectoption == '5')) {
                // alert(selectoption);
                document.getElementById("textfield").setAttribute("readonly", "true");
            }
            if ((selectoption == '2') || (selectoption == '3')) {
                // alert(selectoption);
                document.getElementById("textfield").removeAttribute('readonly');
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
                    $('#psc_id').focus();
                }, 500);


            }
            document.getElementById("process").value = "0";


            document.getElementById("employee").focus();
        }
    </script>
    <?php
    // include("underconstruction.php");
    include('../footer.php');
    ?>