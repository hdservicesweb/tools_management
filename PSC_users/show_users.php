<?php
include("../header.php");
$link = Conectarse();
$sqlallusers = "SELECT * from employes where available >= '1' order by employ_num";
$allusers = mysqli_query($link, $sqlallusers) or die("Something wrong with DB please verify.");
$x = 0;

?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="rowusers">
                <table class="table table-sm table-condensed table-striped">
                    <?php
                    while ($rowusers = mysqli_fetch_array($allusers)) {
                        $x++;
                        //  add elseif or case if more position is necesary.

                        if ($rowusers["position"] == '1') {
                            $textposition = "PRODUCTION";
                        } else {
                            $textposition = "NO ASIGNED";
                        }


                        if ($x == 1) {
                            echo "<thead class='thead-dark'>";
                            printf("<tr><th>&nbsp;%s</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th></tr>", "#", "EMP. NUM", "NAME", "INIT.", "REG.DATE", "POSITION", "ACTION");
                            echo "</thead>";
                        }
                        $elid = $rowusers['employ_num'] . "-" . str_replace(" ", "_", $rowusers['name']) . "-" . $rowusers['initials'] . "-" . $rowusers['position'] . "-" . $rowusers['password'] . "-" . $rowusers['photo'];

                        printf("<tr><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", $x, $rowusers["employ_num"], $rowusers["name"], $rowusers["initials"], $rowusers["reg_date"], $textposition, '<a href="#" id= ' . $elid . ' class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#users" onclick="update_user(id)"><i class="fa fa-user-circle" ></i></a>');
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for users -->
<div class="modal fade" id="users" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><input type="text" for="id_tool" id="headername" value="" style="border:none;width:200px" readonly><label for="idempleado" id="idempleado"></label></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="changestatus.php" method="post" id="modelforget" target="_self" onsubmit="event.preventDefault(); localvalidations();">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <img src="psc_logo.png" alt="" width="100%">
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card" style="width: 100%;">
                                <div class="card-body">

                                    <div><b><label for="modal" id="cardname"></label></b></div>

                                    <div>Employee #: <label for="modal" id="numemployee"></label></div>
                                    <div>Position: <label for="modal" id="cardposit"></label></div>
                                    <div>Password: <label for="modal" id="cardpass"></label></div>
                                </div>
                            </div>
                        </div>
                        <div id="container">
                            <h1>
                                <div id="initials">

                                </div>
                            </h1>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning text-white">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function update_user(id) {
        var id = id;
        var idselect = id.split("-");
        namegood = idselect[1].replace("_", " ");
        switch (idselect[3]) {
            case "1":
                var position = "PRODUCTION";
                break;

            default:
                var position = "NO ASSIGNED";
                break;
        }

        if (idselect[4] != "") {
            var iconpass = "<i class='fa fa-check' style='color:red'></>";
        } else {
            var iconpass = "<i class='fa fa-times' style='color:red'></>";
        }

        document.getElementById('headername').value = idselect[1].replace("_", " ");
        document.getElementById("idempleado").innerHTML = "( " + idselect[0] + " )";
        document.getElementById("cardname").innerHTML = namegood;
        document.getElementById("numemployee").innerHTML = idselect[0];
        document.getElementById("cardposit").innerHTML = position;
        document.getElementById("cardpass").innerHTML = iconpass;
        document.getElementById("initials").innerHTML = idselect[2];
    }
</script>
<style>
    #container {
        position: relative;
    }

    #initials {
        position: absolute;
        top: 20px;
        left: -100px;
        bottom: 50%;
        right: 10%;


    }
</style>
<?php
include('../footer.php');
?>