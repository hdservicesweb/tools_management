<?php
include('../conection.php');
date_default_timezone_set('America/Los_Angeles');
$link = Conectarse();
$search = "";


?>

<table class="table table-sm table-striped table-bordered table-hover header-fixed" width="100%" style='font-size:12px;text-align:center'>
    <?php
    $sqlquery = "SELECT wo.* from wo where position <= '4' order by wo.psc_no desc";
    $wodata = mysqli_query($link, $sqlquery) or die("Something wrong with DB please verify.");
    if ($row = mysqli_num_rows($wodata) > 0) {
        printf("<tr><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th></tr>", "<i class='fa fa-clock-o' ></i>","<i class='fa fa-hashtag' ></i>", "<i class='fa fa-flag'></i>", "<i class='fa fa-circle'></i>", "<i class='fa fa-print'></i>", "<i class='fa fa-calendar'></i>", "Qty", "<i class='fa fa-user'></i>", "<i class='fa fa-star'></i>", "");
    };
    while ($row = mysqli_fetch_array($wodata)) {
        $starqty = substr($row["priorizetotal"], -1);
        $colorstars = "";
        $staricon = "";

        if ($row['status'] == 1) {
         
            $onholdclass = "";
            $onholdicon = "<i class='fa fa-check bg-success text-white'></i>";
            $buttonrelease = "";
        } else {
         
            $onholdclass = " bg-warning text-white";
            $onholdicon = "<a href='#'  onclick='changestatus(".$row['psc_no'].")' id='changestatus0'><i class='fa fa-clock-o text-white'></i></a>";
            $buttonrelease = "";
        }

        $sqlfortimeminutes = "SELECT TIMESTAMPDIFF(MINUTE,(select printed from wo where psc_no='".$row['psc_no']."' order by printed desc limit 1),now()) as minut";
        $timeminutes = mysqli_query($link, $sqlfortimeminutes) or die("Something wrong with DB please verify.");
        $minutesdata = mysqli_fetch_array($timeminutes);
        if ($minutesdata['minut'] <= '1'){
            $recently = "bg-info  text-warning";
        }else{
            $recently = ""; 
        }
       

            switch ($row['position']) {
                case '1':
                    $buttonmove = "<a href='#' id='" . $row['psc_no'] . "' onclick='movefast(this.id)'><i class='fa fa-arrow-right'></i></a>";
                    $classdinamic = "";
               
                    break;
                case '2':
                    $buttonmove = "<a href='#' id='" . $row['psc_no'] . "' onclick='movefast(this.id)'><i class='fa fa-arrow-right'></i></a>";
                    $classdinamic = "";
                 
                    break;
                case '3':
                    $buttonmove = "<a href='../TCPDF-master/examples/psc_wo_box.php?wo=" . $row['psc_no'] . "' target='_blank' id='" . $row['psc_no'] . "' ><i class='fa fa-print'></i></a>";
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
        printf("<tr class='$recently'><td class='$onholdclass'>&nbsp;%s</td><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td class='".$classdinamic."'>&nbsp;%s&nbsp;</td></tr>", $onholdicon, "<a href='edit_wo?wo=" . $row["psc_no"] . "'>" . $row["psc_no"] . "</a>",  $row["picking"],  $row["assy_pn"],  $row["printed"], $row["due_date"],  $row["qty"], $row["last_employee"], $staricon, $buttonmove);
    };

    ?>
</table>