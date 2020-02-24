            <?php
            include('../conection.php');
            date_default_timezone_set('America/Los_Angeles');
            $link = Conectarse();
            if (isset($_GET['srch'])) {
                $presearch = explode("?", $_GET['srch']);
                $search = $presearch[0];
              } else {
                $search = "";
              }
          
            $sql = "SELECT * 
            FROM tools_main_db 
            WHERE psc_id LIKE '%" . $search . "%' 
                OR manufacturer LIKE '%" . $search . "%' 
                OR model LIKE '%" . $search . "%'
                OR trimmed LIKE '%" . $search . "%'
                OR common LIKE '%" . $search . "%'
                OR user_know LIKE '%" . $search . "%'
                OR description LIKE '%" . $search . "%'
                OR stock LIKE '%" . $search . "%'
                ORDER BY model,available desc";
                
                $result = mysqli_query($link, $sql) or die("Something wrong with DB please verify.");

                if (mysqli_num_rows($result) > 0) {
                    // Se recoge el número de resultados
                    $records = 'Found: ' . mysqli_num_rows($result) . ' Records.';
                   echo $records;
                  
                } else {
            
                    $records = "TOOLS No matches.";
                }
  echo ' <div class="row" >';
            while ($row = mysqli_fetch_array($result)) {
                $onerrorprint = "onerror=this.onerror=null;this.src='tools_imgs/no_image.png';";
                if ($row['available'] == '1') {
                    $stock_user = $row["stock"];
                    $classavailable = "bg-success";
                    //$setstatus = "<img src='components/available.png' width='50px' title='" . $row["stock"] . "'/>";
                    $setstatus = "border-success";

                    $button_get = "<button href='#' id='" . $row['psc_id'] . "' class='btn btn-success ' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'><small><i class='fa fa-arrow-left'></i>&nbspUSE THIS </small></button>";
                } elseif ($row['available'] == '-1') {
                    $stock_user = "DAMAGED";
                    $classavailable = "bg-warning bg-muted";
                    $setstatus = "border-warning";
                    //$setstatus = "<img src='components/damaged.png' width='3px' alt='DAMAGED'/>";

                    $button_get = "<button href='#' id='" . $row['psc_id'] . "' class='btn btn-warning btn-sm text-white' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)' disabled><i class='fa fa-warning' style='font-size:15px'></i> &nbsp; DAMAGED</button>";
                } else {
                    $classavailable = "bg-danger";
                    $stock_user = "[" . $row["stock"] . "] - " . $row["user_know"];
                    $setstatus = "border-danger";
                    //                        $setstatus = "<img src='components/notavailable.png' width='50px' title='" . $row["user_know"] . "'/>";
                    $button_get = "<button href='#' id='" . $row['psc_id'] . "' class='btn btn-secondary  ' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'><small><i class='fa fa-arrow-left' style='font-size:10px'></i>&nbsp;TRANSF</small></button>";
                    $button_get .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button href='#' id='" . $row['psc_id'] . "' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#return_tool' onclick='return_modal(this.id)'><small>RETURN&nbsp;<i class='fa fa-arrow-right' style='font-size:10px'></i></small></button>";
                }
                $nextcaldate = date("Y-m-d", strtotime($row['reg_date'] . "+ " . $row['common'] . " month"));
                $nextcaldate2 = date("m-d-Y", strtotime($row['reg_date'] . "+ " . $row['common'] . " month"));
                $datetoday =  date("Y-m-d");
                $daysleftsql = "SELECT TIMESTAMPDIFF(DAY, '$datetoday', '$nextcaldate') AS daysleft";
                $execdaysleft = mysqli_query($link, $daysleftsql);
                $daysleft = mysqli_fetch_array($execdaysleft);
                if ($daysleft['daysleft'] <= 15) {
                    if ($daysleft['daysleft'] <= 0) {
                        $calibrationnow = " | <label class='bg-light text-dark V-URGENT'>" . $daysleft['daysleft'] . " Days <i class='fa fa-close text-danger'></i></label>";
                        //$calibrationnow = $nextcaldate . " | <label class='bg-light text-dark V-URGENT'>" . $daysleft['daysleft'] . " Days <i class='fa fa-close text-danger'></i></label>";
                    } else {
                        $calibrationnow = " | <label class='bg-light text-dark V-URGENT'>" . $daysleft['daysleft'] . " Days <i class='fa fa-warning text-warning'></i></label>";
                        //                            $calibrationnow = $nextcaldate . " | <label class='bg-light text-dark V-URGENT'>" . $daysleft['daysleft'] . " Days <i class='fa fa-warning text-warning'></i></label>";
                    }
                } else {
                    $calibrationnow =  " | " . $daysleft['daysleft'] . " Days <i class='fa fa-check text-success'></i>";
                    //$calibrationnow = $nextcaldate . " | " . $daysleft['daysleft'] . " Days <i class='fa fa-check text-success'></i>";
                }

                echo '     <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2" style="padding:3px;">';
                echo '         <div class="card ' . $setstatus . ' ">';
                echo "             <div class='card-header " . $classavailable . "'>";
                echo "                 <center><small><a href='https://octopart.com/search?q=" . $row["model"] . "' target='_blank' class='text-white'>" . $row["manufacturer"] . " </a> - <a href='index?srch=" . $row["model"] . "' target='_self' class='text-white'>" . $row["model"] . " </a></small></center>";
                echo '             </div>';
                echo '             <div class="col-xs-12 col-sm-12"><br>';
                echo "<a href='tools_imgs/" . $row["img"] . "' data-lightbox='image-1' data-title='" . $row["model"] . "' ><img src='tools_imgs/" . $row["img"] . "' class='card-img' style='max-height: 150px' $onerrorprint /></a>";
                if ($row['qty'] >= '2'){
                    echo "                    <small><small><center><b>".  $row['description'] ." x ".$row['qty']."</b></center></small></small>";
                }else{
                    echo "                    <small><small><center><b>".  $row['description'] ."</b></center></small></small>";
                }
                echo '             </div>';
                echo '             <div class="card-body">';
                echo '<div class="col-lg-12" >';
                echo '<div class="row justify-content-md-center" >';
                echo $button_get;
                echo '</div>';
                echo '</div>';

                echo "<small> NEXT CAL. DATE: $nextcaldate2 </small><br>";

                echo "                 <small> REMAINING DAYS: $calibrationnow </i>";
                echo '                 </small><br>';
                echo '                 <small>LAST USE: ' . $row["last_use"] . '</small><br>';
                echo '                 <small>STORAGE | USER: <b>' . $stock_user . '</b></small>';
                echo "                 <center><small><b><a href='tool_details.php?id=" . $row['psc_id'] . "' class='btn $classavailable btn-sm text-white'><b>" . $row["psc_id"] . "</b></a></b></small>";
                echo "<a href='#' class='float-right' id='" . $row['psc_id'] . "' onclick='addcommon(this.id)'><small><i class='fa fa-plus'></i></small></a></center>";

                echo '             </div>';
                echo '         </div>';
                echo '     </div>';
            }
            ?>
