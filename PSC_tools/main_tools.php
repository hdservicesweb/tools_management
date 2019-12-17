<?php
include('../header.php');
$link = Conectarse();
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

            <div class="col-md-3">

            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header-s card-header-warning card-header-icon">
                        <a href='#' id='getting' class='text-white' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'>
                            <div class="card-icon bg-success text-center text-white">
                                <i class="fa fa-arrow-left" style="font-size:40px"></i>
                            </div>
                        </a>
                        <div class="card-category pull-right text-muted">Last used.</p>
                        </div>
                        <div class="card-details text-right ">
                            <h1 class="text-muted"><a href="tool_details.php?id=<?= $infoexecute['psc_id']?>" class="text-success text-muted nav-link"><?= $infoexecute['psc_id']?></a></h1>
                          </div>
                            <small class="text-center">
                                    <div class="row">
                                        <div class="col-6">Model: <?= $infoexecute['model']?></div>
                                        <div class="col-6">User: <?= $infoexecute['user_know']?></div>
                                    </div>
                                </small>
                            
                        
                        <div class="card-footer">
                            <div class="stats"><small> <a href="show_me.php?selector=3&textfield=<?= $infoexecute['user_know']?>" class=" text-warning nav-link">
                                    <i class="fa fa-warning text-warning"></i>
                                   View More about this user...</a> </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-1">
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header-s card-header-warning card-header-icon">
                    <a href='#' id='returning' class='text-white' data-toggle='modal' data-target='#return_tool' onclick='return_modal(this.id)'>
                        
                            <div class="card-icon bg-danger text-center text-white">
                            <i class="fa fa-arrow-right" style="font-size:40px"></i>
                                
                            </div>
                        </a>
                        <div class="card-category pull-right text-muted">Using tools</p>
                        </div>
                        <div class="card-details text-right"><a href="http://127.0.0.1/PSC_tools/show_me.php?selector=1&textfield=" class="nav-link">
                            <h1 class="text-muted"><?= $quickcount['usingtools']?> 
                                <small>tools</small>
                            </h1></a>
                            <small>
                                    <div class="row">
                                        <div class="col-6"></div>
                                        <div class="col-6">&nbsp;</div>
                                    </div>
                                </small>
                        </div>
                        <div class="card-footer">
                            <div class="stats"><small> <a href="#" class="text-danger  nav-link" data-toggle='modal' data-target='#returning_m'>
                                    <i class="fa fa-chevron-right text-danger"></i>
                                    Massive Return</a> </small>
                            </div>
                        </div>
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
            <a href="https://www.digikey.com/products/en?keywords=<?= $search ?>" id="new" class="btn btn-sm btn-primary " target="_blank"><i class="fa fa-search"></i> Digikey</a>
            <a href="https://octopart.com/search?q=<?= $search ?>" id="new" class="btn btn-sm btn-primary " target="_blank"><i class="fa fa-search"></i> Octopart</a>
            <a href="new_tool.php" id="new" class="btn btn-sm btn-success float-right"><i class="fa fa-plus"></i> ADD TOOL</a>
        </p>

        <div class="container">
            <table class="table table-sm table-default table-bordered">
                <?php
                                                                    if ($row = mysqli_num_rows($result) > 0) {
                                                                        printf("<tr  class='text-center' style='font-size:12px'><th>&nbsp;%s</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th></tr>", "PSC ID", "BRAND", "MODEL", "DESCRIPTION", "LAST USED DATE", "STORAGE / USER", "STATUS", "IMG", "USE / RETURN");
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
                                                                        //printf("<tr><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", "<h6>" . $row["psc_id"] . "</h6>", "<p>" . $row["manufacturer"] . "</p>", "<p><a href='https://octopart.com/search?q=" . $row["model"] . "' target='_blank'>" . $row["model"] . "</a></p>", "<h6>" . $row["description"] . "</h6>", "<h6>" . $row["last_use"] . "</h6>", "<small><h6>" . $stock_user . "</h6></small>", "<h6>" . $setstatus . "</h6>", "<a href='tools_imgs/" . $row["img"] . "' data-lightbox='image-1' data-title='" . $row["model"] . "' ><img src='tools_imgs/" . $row["img"] . "' width='50px' $onerrorprint /></a>", $button_get);
                                                                        printf("<tr><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td class='text-center'>&nbsp;%s&nbsp;</td><td class='text-center'>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", "<a href='tool_details.php?id=" . $row['psc_id'] . "' class='btn btn-link'>" . $row["psc_id"] . "</a>", $row["manufacturer"], "<a href='https://octopart.com/search?q=" . $row["model"] . "' target='_blank'>" . $row["model"] . "</a> <a href='' class='float-right' id='" . $row['psc_id'] . "' onclick='addcommon(this.id)'>+</a>", $row["description"], $row["last_use"], "<small>" . $stock_user . "</small>", $setstatus, "<a href='tools_imgs/" . $row["img"] . "' data-lightbox='image-1' data-title='" . $row["model"] . "' ><img src='tools_imgs/" . $row["img"] . "' class='img-thumbnail' width='50px' $onerrorprint /></a>", $button_get);
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
                                                                        while ($rowcommon = mysqli_fetch_array($result2)) {
                                                                            echo "<a href='main_tools.php?srch=" . $rowcommon['tool_pn'] . "'>" . $rowcommon['component_pn'] . "</a>  |  ";
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