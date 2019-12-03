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
            <div class="col-sm-6 col-md-3">
                <table class="table table-sm">
                    <tr>
                    <th><?= $manufacturer; ?></th>
                    </tr>
                    <tr>
                        <td>PSC ID</td>
                        <td>MODEL</td>
                        <td>STATUS</td>
                        <td>IMG</td>
                    </tr>
                    <?php
                    $sql = "SELECT * from tools_main_db where manufacturer = '$manufacturer' order by manufacturer,available,psc_id, model";
                        $exec2 = mysqli_query($link, $sql);
                        while ($row2 = mysqli_fetch_array($exec2)) {
                            echo "<tr>";
                            echo "<td>".$row2['psc_id']."</td>";
                            echo "<td>".$row2['model']."</td>";
                            if ($row2['available'] == '1') {
                                $setstatus = "<img src='components/available.png' width='10px' alt='AVAILABLE'/><small> - ".$row2['stock']."</small>";
                            }else{
                                $setstatus = "<img src='components/notavailable.png' width='10px' alt='NOT AVAILABLE'/><small> - ".$row2['user_know']."</small>";
                            }
                            echo "<td>".$setstatus."</td>";
                            
                            echo "<td><a href='tool_details.php?id=".$row2['psc_id']."' > <i class='fa fa-list-ul'></i></a> <a href='tools_imgs/" . $row2["img"] . "' data-lightbox='image-1' data-title='" . $row2["model"] . "'><i class='fa fa-file-image-o'></i></a></td>";
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