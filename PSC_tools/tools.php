<?php
include('../header.php');
$link = Conectarse();
$manufacturer = "";
$sqlmanufactures = "SELECT manufacturer from tools_main_db GROUP by manufacturer";


$exec = mysqli_query($link, $sqlmanufactures);




?>
<div class="container-fluid">
    <div class="row">
        <?php
        while ($row = mysqli_fetch_array($exec)) {
            $manufacturer = $row['manufacturer'];
        ?>
            <div class="col-sm-6 col-md-4">
                <table class="table table-sm table-striped table-bordered table-hover">
                    <tr>
                        <th><?= $manufacturer; ?></th>
                    </tr>
                    <tr class="text-center">
                        <td>PSC ID</td>
                        <td>MODEL</td>
                        <td>STATUS</td>
                        <td>IMG</td>
                    </tr>
                    <?php
                            $sql = "SELECT * from tools_main_db where manufacturer = '$manufacturer' order by manufacturer,available,psc_id, model";
                            $exec2 = mysqli_query($link, $sql);
                            $onerrorprint = "onerror=this.onerror=null;this.src='tools_imgs/no_image.png';";
                            while ($row2 = mysqli_fetch_array($exec2)) {
                                echo "<tr>";
                                echo "<td><a href='tool_details.php?id=" . $row2['psc_id'] . "' class='nav-link'>" . $row2['psc_id'] . " </a></td>";
                                echo "<td>" . $row2['model'] . "</td>";
                                if ($row2['available'] == '1') {
                                    $setstatus = "<img src='components/available.png' width='50px' alt='AVAILABLE'/><small> - " . $row2['stock'] . "</small>";
                                } else {
                                    $setstatus = "<img src='components/notavailable.png' width='50px' alt='NOT AVAILABLE'/><small> - " . $row2['user_know'] . "</small>";
                                }
                                echo "<td>" . $setstatus . "</td>";

                                echo "<td class='text-center'> <a href='tools_imgs/" . $row2["img"] . "' data-lightbox='image-1' data-title='" . $row2["model"] . "'><img src='tools_imgs/" . $row2["img"] . "' class='img-thumbnail' width='50px' $onerrorprint /></td>";
                                echo "</tr>";
                            }
                    ?>



                </table>
            </div>
        <?php

                        }
        ?>

    </div>
</div>


<?php
                        include('../footer.php');
?>