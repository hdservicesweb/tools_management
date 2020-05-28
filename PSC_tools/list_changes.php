<?php
include("../header.php");
$link = Conectarse();

$sqlinfo = "SELECT date from tools_process order by id desc limit 1";
$execinfo = mysqli_query($link, $sqlinfo);
$row = mysqli_fetch_array($execinfo);
$lafecha = $row['date'];


$sqlinfo2 = "SELECT * from tools_process where date = '$lafecha' order by psc_id";
$execinfo2 = mysqli_query($link, $sqlinfo2);
// while ($lastchanges = mysqli_fetch_array($execinfo2)){

// }


?>
<div class="container">
<div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                 
                        <div class="float-right">
                         
                            &nbsp;<a href="index.php" class="btn btn-sm btn-primary "><i class="fa fa-home"></i> Home</a>&nbsp;
                        </div>
                    </div>

                </div>
            </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark bg-light">
                <div class="card-header bg-success text-white">
                    <strong>
                        <i class="fa fa-circle-o-notch"></i>
                        <label> | Latest Changes.</label>
                    </strong>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table-condensed table-sm">
                        <thead>
                            <tr class="text-center">
                                <th><small>PSC ID</small></th>
                                <th><small>MANUFACTURER</small></th>
                                <th><small>MODEL</small></th>
                                <th><small>DATE</small></th>
                                <th><small>USER</small></th>
                                <th><small>STATUS</small></th>
                                <th><small>STORAGE</small></th>
                                <th><small>IMAGE</small></th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            while ($lastchanges = mysqli_fetch_array($execinfo2)) {
                                $dinamicid = $lastchanges['psc_id'];
                                $sqldetails = "SELECT * FROM `tools_main_db` where psc_id = '$dinamicid' limit 1";
                                $details = mysqli_query($link, $sqldetails);
                                $row_details = mysqli_fetch_array($details);
                            ?>
                                <tr class="text-center">
                                    <th><small><?= $row_details['psc_id'] ?></small></th>
                                    <th><small><?= $row_details['manufacturer'] ?></small></th>
                                    <th><small><?= $row_details['model'] ?></small></th>
                                    <th><small><?= $row_details['last_use'] ?></small></th>
                                    <th><small><?= $row_details['user_know'] ?></small></th>
                                    <?php
                                    if ($row_details['available'] == '1') {

                                        $classavailable = "bg-success text-success";
                                    } elseif ($row_details['available'] == '-1') {

                                        $classavailable = "bg-warning text-warning";
                                    } else {
                                        $classavailable = "bg-danger text-danger";
                                    }
                                    ?>
                                    <th><small><i class="fa fa-square-o <?=$classavailable?>>"></i></small></th>
                                    <th><small><?= $row_details['stock'] ?></small></th>
                                    <th><small><a href='tools_imgs/<?=$row_details['img']?>' data-lightbox='image-1' data-title='<?=$row_details['img']?>' ><img src='tools_imgs/<?=$row_details['img']?>' width="50px"/></a></small></th>
                                </tr>
                            <?php
                                //                                echo $dinamicid;
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>


<?php
include('../footer.php');
?>