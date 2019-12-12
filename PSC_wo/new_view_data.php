<?php
include('../conection.php');
date_default_timezone_set('America/Los_Angeles');
$link = Conectarse();
$search = "";


?>

<table class="table table-sm table-striped table-bordered table-hover header-fixed" width="100%" style='font-size:12px;text-align:center'>
    <?php
    printf("<tr><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th></tr>", "<i class='fa fa-clock-o' ></i>", "<i class='fa fa-hashtag' ></i>", "<i class='fa fa-flag'></i>", "<i class='fa fa-circle'></i>", "<i class='fa fa-print'></i>", "<i class='fa fa-calendar'></i>", "Qty", "<i class='fa fa-user'></i>", "<i class='fa fa-star'></i>", "<i class='fa fa-inbox'></i>", "<i class='fa fa-dot-circle-o'></i>");

    $sqlquery = "SELECT wo.*, (TIMESTAMPDIFF(MINUTE,(printed),now()) )as minut from wo where position <= '4' order by wo.psc_no desc";
    $wodata = mysqli_query($link, $sqlquery) or die("Something wrong with DB please verify.");



    $sqlquery2 = "SELECT wo.*, (TIMESTAMPDIFF(MINUTE,(printed),now()) )as minut from wo where position <= '4' order by minut asc LIMIT 5";
    $wodata2 = mysqli_query($link, $sqlquery2) or die("Something wrong with DB please verify.");




//MOSTRAR LOS 3 PRIMEROS REGISTROS INGRESADOS RECIENTEMENTE

    while ($row2 = mysqli_fetch_array($wodata2)) {
        $starqty = substr($row2["priorizetotal"], -1);
        $colorstars = "";
        $staricon = "";

        if ($row2['status'] == 1) {

            $onholdclass = "bg-success text-white";

            $onholdicon = "<a href='#'   onclick='changestatus(" . $row2['id'] . ")' id='changestatus1'><i class='fa fa-check bg-success text-white'></i></a>";
            $buttonrelease = "";
        } else {

            $onholdclass = " bg-warning text-white";
            $onholdicon = "<a href='#'   onclick='changestatus(" . $row2['id'] . ")' id='changestatus0'><i class='fa fa-clock-o text-white'></i></a>";
            $buttonrelease = "";
        }

        $recently = "text-primary";


        switch ($row2['position']) {
            case '1':
                $buttonmove = "<a href='#'  id='" . $row2['id'] . "' onclick='movefast(this.id)' ><i class='fa fa-arrow-right'></i></a>";
                $classdinamic = "bg-light text-white";

                break;
            case '2':
                $buttonmove = "<a href='#'  id='" . $row2['id'] . "' onclick='movefast(this.id)'><i class='fa fa-arrow-right'></i></a>";
                $classdinamic = "";

                break;
            case '3':
                $buttonmove = "<a href='../TCPDF-master/examples/psc_wo_box.php?wo=" . $row2['id'] . "' target='_blank' id='" . $row2['psc_no'] . "' ><i class='fa fa-print btn btn-info btn-sm'></i></a>";
                $buttonmove .= "&nbsp; <a href='#'  id='" . $row2['id'] . "' onclick='movefast(this.id)' ><i class='fa fa-arrow-right btn btn-success btn-sm'></i></a>";
                $classdinamic = "";

                break;
            case '4':
                $buttonmove = "READY";
                $classdinamic = "bg-success text-white";

                break;

            default:
                $buttonmove = "";
                $classdinamic = "";

                break;
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

        printf("<tr class='$recently'><td class='$onholdclass'>&nbsp;%s</td><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td class='" . $classdinamic . "'>&nbsp;%s&nbsp;</td></tr>", $onholdicon, "<a href='edit_wo?wo=" . $row2["id"] . "'>" . $row2["psc_no"] . "</a>",  $row2["picking"],  $row2["assy_pn"],  $row2["printed"], $row2["due_date"],  $row2["qty"], $row2["last_employee"], $staricon, $row2['position'], $buttonmove);
    }

    printf("<tr class='bg-disabled text-dark' ><td colspan='11'>&nbsp;%s</td></tr>", "END OF MOST RECENT RECORDS");

    while ($row = mysqli_fetch_array($wodata)) {
        $starqty = substr($row["priorizetotal"], -1);
        $colorstars = "";
        $staricon = "";

        if ($row['status'] == 1) {

            $onholdclass = "bg-success text-white";

            $onholdicon = "<a href='#'  onclick='changestatus(" . $row['id'] . ")' id='changestatus1'><i class='fa fa-check bg-success text-white'></i></a>";
            $buttonrelease = "";
        } else {

            $onholdclass = " bg-warning text-white";
            $onholdicon = "<a href='#'  onclick='changestatus(" . $row['id'] . ")' id='changestatus0'><i class='fa fa-clock-o text-white'></i></a>";
            $buttonrelease = "";
        }


        if ($row['minut'] <= '5') {
            $recently = "text-primary";
        } else {
            $recently = "text-dark ";
        }


        switch ($row['position']) {
            case '1':
                $buttonmove = "<a href='#' id='" . $row['id'] . "' onclick='movefast(this.id)' ><i class='fa fa-arrow-right'></i></a>";
                $classdinamic = "bg-light text-white";

                break;
            case '2':
                $buttonmove = "<a href='#' id='" . $row['id'] . "' onclick='movefast(this.id)'><i class='fa fa-arrow-right'></i></a>";
                $classdinamic = "";

                break;
            case '3':
                $buttonmove = "<a href='../TCPDF-master/examples/psc_wo_box.php?wo=" . $row['id'] . "' target='_blank' id='" . $row['psc_no'] . "' ><i class='fa fa-print'></i></a>";

                $classdinamic = "";

                break;
            case '4':
                $buttonmove = "READY";
                $classdinamic = "bg-success text-white";

                break;

            default:
                $buttonmove = "";
                $classdinamic = "";

                break;
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

        printf("<tr class='$recently'><td class='$onholdclass'>&nbsp;%s</td><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td class='" . $classdinamic . "'>&nbsp;%s&nbsp;</td></tr>", $onholdicon, "<a href='edit_wo?wo=" . $row["id"] . "'>" . $row["psc_no"] . "</a>",  $row["picking"],  $row["assy_pn"],  $row["printed"], $row["due_date"],  $row["qty"], $row["last_employee"], $staricon, $row['position'], $buttonmove);
    };

    ?>
</table>