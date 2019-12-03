<?php

        $sql2 = "SELECT * FROM tools_main_db TM INNER JOIN common_tb CTB on TM.model = CTB.tool_pn
        WHERE psc_id LIKE '%" . $search . "%' 
        OR TM.manufacturer LIKE '%" . $search . "%' 
        OR TM.model LIKE '%" . $search . "%' 
        OR TM.trimmed LIKE '%" . $search . "%' 
        OR TM.common LIKE '%" . $search . "%' 
        OR CTB.component_pn like '%" . $search . "%'
        OR CTB.trimmed like '%" . $search . "%'
        ORDER BY TM.id_tool";
        //echo $sql;
        $result2 = mysqli_query($link, $sql2) or die("Somthing wrong with DB please verify.");
        // echo mysqli_num_rows($result);
        if (mysqli_num_rows($result2) > 0) {
            // Se recoge el número de resultados
            $records = 'Found: ' . mysqli_num_rows($result2) . ' Records.';
        } else {
            $records = "No matches.";
        }
?>

<br><br>
<div class="page-footer font-small">

    <!-- Copyright -->
    <div class="text-center py-3">
        PCS Electronics
        <!-- <a href="#"> PCS Electronics</a> -->
    </div>
    <!-- Copyright -->

</div>
<br><br>