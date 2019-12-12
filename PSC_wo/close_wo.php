<?php
include("../header.php");
$link = Conectarse();

if (isset($_REQUEST['order'])) {
    $sqlselection = "SELECT id,psc_no from wo where (position between '9' and '10')";
    $getvalues = mysqli_query($link, $sqlselection) or die("Something wrong with DB please verify.");
    while ($eachval = mysqli_fetch_array($getvalues)) {



        $sqlsave = "UPDATE wo set position = '11', status = '0', last_employee = 'CLOSED WO', last_movement = CURRENT_TIMESTAMP where id = '" . $eachval['id'] . "'";

        if ($sqlexec = mysqli_query($link, $sqlsave)) {
            //  -->> VITACORA  
            $sqlmovetobackup = "INSERT INTO wo_completed SELECT * FROM wo WHERE id = '" . $eachval['id'] . "'";

            if ($sqltobackup = mysqli_query($link, $sqlmovetobackup)) {
                $sqldeletefirstred = "DELETE from wo where id = '" . $eachval['id'] . "'";
                $execdelete = mysqli_query($link, $sqldeletefirstred);
            }

            $sqladdingtracking = "INSERT into wo_process (id,id_wo,wo,date,user,process) values (NULL,'" . $eachval['id'] . "','" . $eachval['psc_no'] . "',CURRENT_TIMESTAMP,'COMPLETED ORDER','CLOSED')";
            $executeV = mysqli_query($link, $sqladdingtracking);
            //  -->> VITACORA 
        }
    }
}
if (isset($_REQUEST['closeid'])) {
    $idtoclose = $_REQUEST['closeid'];
    $sqlselection = "SELECT psc_no from wo where id='$idtoclose'";
    $getvalues = mysqli_query($link, $sqlselection) or die("Something wrong with DB please verify.");
    $eachval = mysqli_fetch_array($getvalues);
    $sqlsave = "UPDATE wo set position = '11', status = '0', last_employee = 'CLOSED WO', last_movement = CURRENT_TIMESTAMP where id = '" . $idtoclose . "'";

    if ($sqlexec = mysqli_query($link, $sqlsave)) {
        //  -->> VITACORA   
        $sqlmovetobackup = "INSERT INTO wo_completed SELECT * FROM wo WHERE id = '" . $idtoclose . "'";
        if ($sqltobackup = mysqli_query($link, $sqlmovetobackup)) {
            $sqldeletefirstred = "DELETE from wo where id = '" . $idtoclose . "'";
            $execdelete = mysqli_query($link, $sqldeletefirstred);
        }

        $sqladdingtracking = "INSERT into wo_process (id,id_wo,wo,date,user,process) values (NULL,'" . $idtoclose . "','" . $eachval['psc_no'] . "',CURRENT_TIMESTAMP,'COMPLETED ORDER','CLOSED')";
        $executeV = mysqli_query($link, $sqladdingtracking);
        //  -->> VITACORA 
    }
}

$sql = "SELECT * from wo where (position between '9' and '10') order by last_movement desc";
$result = mysqli_query($link, $sql) or die("Something wrong with DB please verify.");
// echo mysqli_num_rows($result);
if (mysqli_num_rows($result) > 0) {
    // Se recoge el número de resultados
    $records = 'Found: ' . mysqli_num_rows($result) . ' Records pending for close.';
    $btnclose = '<input type="submit" class="form-control btn btn-danger " value="CLOSE ALL">';
} else {
    $btnclose = "";
    $records = "NO PENDINGS.";
}

?>
<div class="container-row">
    <div class="row">
        <div class="col-12">
            <?= $records ?>
        </div>
    </div><br>
    <div class="row">
        <div class="col-10">
            <h2 class="text-center">Shipped WOs</h2>
            <div class="container">
                <table class="table table-sm table-default table-striped">
                    <?php
                    if ($row = mysqli_num_rows($result) > 0) {
                        printf("<tr class='text-center'><th>&nbsp;%s</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><td>&nbsp;%s</td></tr>", "ID WO", "PICKING", "ASSY PN", "QTY", "CREATED", "DUE DATE", "PRIORITY", "LAST_STEEP", "LAST_DATE", "");
                    }
                    while ($row = mysqli_fetch_array($result)) {
                        $starqty = substr($row["priorizetotal"], -1);
                        $staricon = "";
                        switch ($starqty) {
                            case '1':
                                $colorstars = "green";
                                for ($i = 1; $i < 6; $i++) {
                                    if ($i <= $starqty) {
                                        $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                                    } else {
                                        $staricon .= "<i class='fa fa-star-o text-muted' aria-hidden='true' ></i>";
                                    }
                                }
                                break;
                            case '2':
                                $colorstars = "green";
                                for ($i = 1; $i < 6; $i++) {
                                    if ($i <=    $starqty) {
                                        $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                                    } else {
                                        $staricon .= "<i class='fa fa-star-o text-muted' aria-hidden='true' ></i>";
                                    }
                                }
                                break;
                            case '3':
                                $colorstars = "orange";
                                for ($i = 1; $i < 6; $i++) {
                                    if ($i <= $starqty) {
                                        $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                                    } else {
                                        $staricon .= "<i class='fa fa-star-o text-muted' aria-hidden='true' ></i>";
                                    }
                                }
                                break;
                            case '4':
                                $colorstars = "orange";
                                for ($i = 1; $i < 6; $i++) {
                                    if ($i <= $starqty) {
                                        $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                                    } else {
                                        $staricon .= "<i class='fa fa-star-o text-muted' aria-hidden='true' ></i>";
                                    }
                                }
                                break;
                            case '5':
                                $colorstars = "red";
                                for ($i = 1; $i < 6; $i++) {
                                    if ($i <= $starqty) {
                                        $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                                    } else {
                                        $staricon .= "<a href='#'><i class='fa fa-star-o' aria-hidden='true' ></i></a>";
                                    }
                                }
                                break;
                            default:
                                # code...
                                break;
                        }
                        printf("<tr><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s</td></tr>", "<a href='edit_wo?wo=" . $row["id"] . "'><small>" . $row["psc_no"] . "</small></a>", "<small>" . $row["picking"] . "</small>", "<small>" . $row["assy_pn"] . "</small>", "<small>" . $row["qty"] . "</small>", "<small>" . $row["printed"] . "</small>", "<small>" . $row["due_date"] . "</small>", $staricon, "<small>" . $row["last_employee"] . "</small>", "<small>" . $row["last_movement"] . "</small>", "<a href='close_wo?closeid=" . $row["id"] . "'><i class='fa fa-close'></i></a>");
                    }

                    ?>
                </table>
            </div>
        </div>
        <div class="col-1">
            <div class="row">
                <form action="close_wo.php" method="post"><br><br>
                    <input type="text" value="save" name="order" hidden readonly>
                    <?= $btnclose ?>
                </form>
            </div>
            <br>
            <div class="row">
                <a href="closed" class=" form-control btn btn-primary"> View Closed. </a>
            </div>
        </div>
    </div>
</div>



<?php
include('../footer.php');
?>