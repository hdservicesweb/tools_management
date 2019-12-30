<?php
include('../header.php');
$link = Conectarse();
if ((isset($_REQUEST['newcertif'])) && ($_REQUEST['newcertif'] != 'null')) {
    $tool = $_REQUEST['id'];
        $newcertif = $_REQUEST['newcertif'];
        $sqlnewnewcertif = "UPDATE tools_main_db set certif_num = '$newcertif' where psc_id = '$tool'";
        //echo $sqlnewstock;
        $updatenewcertif = mysqli_query($link, $sqlnewnewcertif);
        if ($updatenewcertif) {
            echo "<script>window.close();</script>";
        }
    }
