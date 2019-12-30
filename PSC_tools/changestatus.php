<?php
include('../header.php');
$link = Conectarse();
if (isset($_REQUEST['massive'])) {
    $text = trim($_REQUEST['toosl_m']);
  

    $text2 = explode("\n", $text);
    foreach ($text2 as $line) {
        $eachline = trim($line);

        $sqlinfo = "SELECT psc_id,user_know,available from tools_main_db where psc_id = '$eachline'";
        
        $execinfo = mysqli_query($link, $sqlinfo);
        $row = mysqli_fetch_array($execinfo);
        if((isset($row['psc_id']))&&($row['available'] == '0')){
            $employee =  $row['user_know'];

        
            $sqlquery = "INSERT into tools_process (id,psc_id,date,name,process) values (NULL,'$eachline',CURRENT_TIMESTAMP,'$employee','1')";
            
            $sql = "UPDATE tools_main_db set available = '1', used_qty = used_qty + 1 where psc_id = '$eachline'";
            $exect = mysqli_query($link, $sqlquery);
            $exec = mysqli_query($link, $sql);
        }
        
    }
}

$datenow = date('Y-m-d H:i:s');
if (isset($_REQUEST['psc_id'])) {
    $psc_id = strtoupper($_REQUEST['psc_id']);
    $tool = strtoupper($psc_id);

    $sqlinfo = "SELECT * from tools_main_db where psc_id = '$tool'";
    $sqltracking = "SELECT * from tools_process where psc_id = '$tool' order by date desc limit 10";
    $execinfo = mysqli_query($link, $sqlinfo);
    $row = mysqli_fetch_array($execinfo);
    $stock = $row['stock'];
    $currentstatus = $row['available'];
} else {
    $psc_id = "Unidentify";
    if (isset ($eachline)){
        $tool = $eachline;
        $sqlinfo = "SELECT * from tools_main_db where psc_id = '$tool'";
        
        $execinfo = mysqli_query($link, $sqlinfo);
        $row = mysqli_fetch_array($execinfo);
        $stock = $row['stock'];
        $currentstatus = $row['available'];
    }else{
      $tool = "";  
    }
    
}

if (isset($_REQUEST['employee'])) {
    $receibedemployee = trim($_REQUEST['employee']);
    if (is_numeric($receibedemployee)) {

        $sqltoknowname = "SELECT name from employes where employ_num = '$receibedemployee'";
        $execname = mysqli_query($link, $sqltoknowname);
        while ($names = mysqli_fetch_array($execname)) {

            if (isset($names['name'])) {
                $employee = $names['name'];
            } else {
                $employee = "UNKNOWN";
            }
        }
    } else {

        $employee = $_REQUEST['employee'];
        if ($employee == "RETURN"){
            $employee =  $row['user_know'];
        }
    }
} else {
    $employee = "Employee";
}

if (isset($_REQUEST['process'])) {
    $process = $_REQUEST['process'];
} else {
    $process = "20";
}

if ($process == '0') {
    if($currentstatus=='0'){
        $process = 2;
    }
    $sqlquery = "INSERT into tools_process (id,psc_id,date,name,process) values (NULL,'$psc_id',CURRENT_TIMESTAMP,'$employee','$process')    ";
    $sql = "UPDATE tools_main_db set available = '0', used_qty = used_qty + 1,user_know = '$employee',last_use = '$datenow' where psc_id = '$psc_id'";
    if (mysqli_query($link, $sql)) {
        $exec = mysqli_query($link, $sqlquery);
    }
}

if ($process == '1') {
    $sqlquery = "INSERT into tools_process (id,psc_id,date,name,process) values (NULL,'$psc_id',CURRENT_TIMESTAMP,'$employee','$process')    ";
    if (($stock == "BROKEN") || ($stock == "DAMAGED")) {
        $sql = "UPDATE tools_main_db set available = '-1', user_know = 'BROKEN' where psc_id = '$psc_id' and available = '0'";
    } else {
        $sql = "UPDATE tools_main_db set available = '1' where psc_id = '$psc_id' and available = '0'";
    }


    if (mysqli_query($link, $sql)) {
        $exec = mysqli_query($link, $sqlquery);
    }
}
?>
<div class="container">
    <h6>
        Saving Changes
    </h6>
    Re-directing ...
</div>
<div class="container-fluid">
    <center>
        <h2>DETAILS <?= $tool ?></h2>
    </center>
    <div class="row">
        &nbsp;&nbsp;&nbsp;<br>
        <div class="card" style="width: 25rem;">
            <img src="tools_imgs/<?= $row['img'] ?>" class="card-img-top" alt="...">
            <div class="card-header">
                <center><?= $tool ?></center>
            </div>
            <div class="card-body">

            </div>
        </div>
        &nbsp;&nbsp;&nbsp;<br>
        <!-- USO / usage -->
        <div class="card card" style="width: 20rem;">
            <div class="card-body ">
                <center>
                    <h5 class="card-title">Usage</h5>
                </center>
                <center>
                    <h6 class="card-subtitle mb-2 text-muted"><?= $row['model'] ?></h6>
                </center>
                <br>
                <?php
                if ($currentstatus == '-1') {
                    echo "<table class='table table-warning table-striped'>";
                    echo "<tr>";
                    echo "<th>Storage:</th>";
                    echo "<td>";
                    echo "<h1>" . $stock . "</h1>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                } elseif ($currentstatus == '1') {
                    echo "<table class='table table-danger table-striped'>";
                    echo "<tr>";
                    echo "<th>Storage:</th>";
                    echo "<td>";
                    echo "<h1>" . $stock . "</h1>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                } else {
                    echo "<table class='table table-success table-striped'>";
                    echo "<tr>";
                    echo "<th>Storage:</th>";
                    echo "<td>";
                    echo "<h1>" . $stock . "</h1>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                }
                ?>


            </div>
        </div> &nbsp;&nbsp;&nbsp;<br>
        <!-- SEGUIMIENto / TRACKING -->
        <div class="card" style="width: 30rem;">
            <div class="card-body">
                <center>
                    <h5 class="card-title">Tracking</h5>
                </center>
                <center>

                    <h2><?= $employee ?></h2>

                    <br>
                    <table class="table table-sm table-light table-striped">
                        <tr>
                            <td>
                                <a href="tool_details.php?id=<?= $psc_id ?>" class="btn btn-success">GO <i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr>
                    </table>
                </center>
            </div>
        </div>
    </div>


</div>
<script LANGUAGE="JavaScript">
    var pagina = "index"

    function redireccionar() {
        location.href = pagina
    }
    setTimeout("redireccionar()", 1500);
</script>
<?php
include('../footer.php');
?>