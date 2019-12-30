<?php
include("../header.php");
$link = Conectarse();

if (isset($_FILES['importfile'])) {
    if ($_FILES["importfile"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    } else {
        echo "<a href='index' class='btn btn-success float-right'>RETURN</a>";
        //Print file details
        echo "Upload: " . $_FILES["importfile"]["name"] . "<br />";
        echo "Type: " . $_FILES["importfile"]["type"] . "<br />";
        echo "Size: " . ($_FILES["importfile"]["size"] / 1024) . " Kb<br />";
        echo "Temp file: " . $_FILES["importfile"]["tmp_name"] . "<br />";
        
        
        //if file already exists
        if (file_exists("import_file/" . $_FILES["importfile"]["name"])) {
            $storagename = "uploaded_file.csv";
            
            move_uploaded_file($_FILES["importfile"]["tmp_name"], "import_file/" . $storagename);
        } else {
            //Store file in directory "import_file" with the name of "uploaded_file.csv"
            $storagename = "uploaded_file.csv";
            move_uploaded_file($_FILES["importfile"]["tmp_name"], "import_file/" . $storagename);
            // echo "Stored in: " . "import_file/" . $_FILES["importfile"]["name"] . "<br />";
        }
        echo "<hr>";
    }
    // $file = fopen("import_file/uploaded_file.csv","r");
echo "<div class='container-fluid'>";
    if (($handle = fopen("import_file/uploaded_file.csv", "r")) !== FALSE) {
        echo "<table class='table table-responsive-sm table-striped table-bordered table-sm table-hover'>";
        echo "<tr class ='table-info'>";
        echo "<th>PSC ID</th>";
        echo "<th>MANUFACTURER</th>";
        
        echo "<th>MODEL</th>";
        echo "<th>CERTIFICATED NUM.</th>";
        echo "<th>STORED DATABASE DATE</th>";
        echo "<th>IMPORTED CALIBRATION</th>";
        echo "<th> ACTION</th>";
        echo "<th> </th>";
        echo "</tr>";
        $row = 1;
        $countar = 1;
        $flag = true;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            // echo "<p> $num fields in line $row: <br /></p>\n";
            $row++;
            $sql = "SELECT * from tools_main_db where psc_id = '$data[0]' and manufacturer = '$data[1]' and model = '$data[2]' ";
            $execdaysleft = mysqli_query($link, $sql);

            if (mysqli_num_rows($execdaysleft) > 0) {

                // Se recoge el número de resultados
                //echo 'Found: ' . mysqli_num_rows($execdaysleft) . ' Records.';
                $mysqldata = mysqli_fetch_array($execdaysleft);
                $segmentodate = explode("/", $data[5]);
                $newfechastring = $segmentodate[2]."-".$segmentodate[0]."-".$segmentodate[1];
                

                $newfecha = date('Y-m-d',strtotime($newfechastring));

                $nextcaldate = date("Y-m-d",strtotime($mysqldata['reg_date']));

                if ($nextcaldate != $newfecha) {
                    
                    $SQLUPDATE = "UPDATE tools_main_db set reg_date = '$newfecha' where psc_id = '$data[0]'";
                    
                    $actualizarfechas = mysqli_query($link, $SQLUPDATE);
                    if ($actualizarfechas){
                        //LAS FECHAS SON DIFERENTES SE REALIZA ACTUALIZACION DE REGISTRO
                        echo "<tr class='bg-warning text-white'>";
                    echo "<td><small><a href='tool_details.php?id=".$data[0] ."' target='_blank'>".$data[0] ."</a></small></td>";
                    echo "<td><small>".$data[1] ."</small></td>";
                    echo "<td><small>".$data[2] ."</small></td>";
                    if ($data[3] != $mysqldata['certif_num']) {
                        echo "<td class='text-danger'><small>". $mysqldata['certif_num']." | >> <label class='V-URGENT'>".$data[3] ."</label> <a href='change_certif?newcertif=".$data[3]."&id=".$data[0] ."' target='_blank'><i class='fa fa-check' ></i></a></small></td>";
                    }else{
                        echo "<td><small>".$data[3] ."</small></td>";
                    }
                    
                    echo "<td><small>".$nextcaldate ."</small></td>";
                    echo "<td><small>".$newfecha ."</small></td>";
                    echo "<td ><small>DATE UPDATED  <small>(NEW DATE)</small></small></td>";
                    echo "<td><small> <i class='fa fa-check text-success'></i>  </small> </td>";
                    }else {
                        echo "ERROR";
                    }
                    //echo $data[0] . "<small>CALIBRATION DUE DATE UPDATED </small><br>";
                } else {
                    //NO SE REALIZA ACTION PORQUE LAS FECHAS COINCIDEN NO SE NECESITA ACTUALIZAR
                    echo "<tr>";
                    echo "<td><small><a href='tool_details.php?id=".$data[0] ."' target='_blank'>".$data[0] ."</a></small></td>";
                    echo "<td><small>".$data[1] ."</small></td>";
                    echo "<td><small>".$data[2] ."</small></td>";
                    if ($data[3] != $mysqldata['certif_num']) {
                        echo "<td class='text-danger'><small>". $mysqldata['certif_num']." | >> <label class='V-URGENT'>".$data[3] ."</label> <a href='change_certif?newcertif=".$data[3]."&id=".$data[0] ."' target='_blank'><i class='fa fa-check' ></i></a></small></td>";
                    }else{
                        echo "<td><small>".$data[3] ."</small></td>";
                    }
                    echo "<td><small>".$nextcaldate ."</small></td>";
                    echo "<td><small>".$newfecha ."</small></td>";
                    echo "<td ><small>DATES MATCH   <small>(NO ACTION)</small></small></td>";
                    echo "<td><small>   </small> </td>";
                    $countar++;
                }
            } else {
                if($flag) { $flag = false; continue; }else{
//echo $sql;
                    echo "<tr class='bg-danger text-white'>";
                    echo "<td><small><a href='tool_details.php?id=".$data[0] ."' target='_blank'>".$data[0] ."</a></small></td>";
                    echo "<td><small>".$data[1] ."</small></td>";
                    echo "<td><small>".$data[2] ."</small></td>";
                    echo "<td><small>".$data[3] ."</small></td>";
                    echo "<td><small>".$nextcaldate ."</small></td>";
                    echo "<td><small>".$newfecha ."</small></td>";
                    echo "<td ><small>NO ID FOUND   <small>(NEED ATENTION !)</small></small></td>";
                    echo "<td><small> <i class='fa fa-close text-white'></i>  </small> </td>";           
                }
            }

           
            // echo $sql;
            // for ($c=0; $c < $num; $c++) {
            //     echo $data[$c] . "<br />\n";
            // }
        }
        //echo $countar . " REGISTROS NO SINCRONIZADOS";
        fclose($handle);
    }
    echo "</table>";
    echo "</div>";
?>




<?php
} else {
    echo "No file selected <br />";
}
include('../footer.php');
?>