<?php 
include ("../header.php");
$link = Conectarse();
if (isset($_REQUEST['quickver'])) {
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
?>




<?php 
include('../footer.php');
?>