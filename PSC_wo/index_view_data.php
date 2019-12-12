<?php
include('../conection.php');
date_default_timezone_set('America/Los_Angeles');
$link = Conectarse();
$search = "";

?>

<table class="table table-striped table-bordered table-hover table-condensed" width="100%" style='font-size:12px;text-align:center'>
    <?php
    $sqlquery = "SELECT * from wo where wo.position = '4' order by wo.priorizetotal desc, wo.due_date asc ";
    $wodata = mysqli_query($link, $sqlquery) or die("Something wrong with DB please verify.");
    if ($row = mysqli_num_rows($wodata) > 0) {
        printf("<tr><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th></tr>", "PSC No", "<i class='fa fa-flag'></i>", "<i class='fa fa-print'></i>", "<i class='fa fa-calendar'></i>", "Qty", "<i class='fa fa-inbox'></i>", "<i class='fa fa-star'></i>", "<i class='fa fa-upload'></i>");
    };

    while ($row = mysqli_fetch_array($wodata)) {
        //ASIGNA EL ESTATUS ON HOLD O CORRIENDO
        if ($row['status'] == 1) {
            $newstatus = "RUNNING";
            $onholdclass = "";
            $onholdicon = "<i class='fa fa-check bg-success text-white'></i>";
            $buttonrelease = "";
        } else {
            $newstatus = "ON HOLD";
            $onholdclass = " bg-warning text-white";
            $onholdicon = "<i class='fa fa-clock-o bg-warning text-white'></i>";
            $buttonrelease = "<a href='#'  onclick='changestatus(".$row['id'].")' id='changestatus0'><i class='fa fa-clock-o'></i></a>";
        }

        $starqty = substr($row["priorizetotal"], -1);
        $colorstars = "";
        $staricon = "";


        if ($row['position'] == '1') {
            $buttonmove = "<a href='#' id='" . $row['id'] . "' onclick='movefast(this.id)'><i class='fa fa-arrow-right'></i></a>";
        } else {
            $buttonmove = "";
        }


        switch ($starqty) {
            case '1':
                $colorstars = "green";
                for ($i = 0; $i < $starqty; $i++) {
                    $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                }
                break;
            case '2':
                $colorstars = "green";
                for ($i = 0; $i < $starqty; $i++) {
                    $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                }
                break;
            case '3':
                $colorstars = "orange";
                for ($i = 0; $i < $starqty; $i++) {
                    $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                }
                break;
            case '4':
                $colorstars = "orange";
                for ($i = 0; $i < $starqty; $i++) {
                    $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                }
                break;
            case '5':
                $colorstars = "red";
                for ($i = 0; $i < $starqty; $i++) {
                    $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
                }
                break;
            default:
                # code...
                break;
        }


        // echo $staricon;
        printf("<tr class='$onholdclass'><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>","<a href='edit_wo?wo=".$row["id"]."'>".  $row["psc_no"]."</a>",  $row["picking"], $row["printed"], $row["due_date"],  $row["qty"], $row["last_employee"], $staricon, $buttonmove. $buttonrelease);
    };

    ?>
</table>