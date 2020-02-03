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
                
                ORDER BY model";
                
                $result = mysqli_query($link, $sql) or die("Something wrong with DB please verify.");

                if (mysqli_num_rows($result) > 0) {
                    // Se recoge el número de resultados
                    $records = 'Found: ' . mysqli_num_rows($result) . ' Records.';
                   echo $records;
                    echo ' <div class="row" >';
                } else {
            
                    $records = "TOOLS No matches.";
                }

            while ($row = mysqli_fetch_array($result)) {
                $onerrorprint = "onerror=this.onerror=null;this.src='tools_imgs/no_image.png';";
                if ($row['available'] == '1') {
                    $stock_user = $row["stock"];
                    $classavailable = "bg-success";
                    //$setstatus = "<img src='components/available.png' width='50px' title='" . $row["stock"] . "'/>";
                    $setstatus = "border-success";

                    $button_get = "<a href='#' id='" . $row['psc_id'] . "' class='btn btn-success btn-sm' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'><i class='fa fa-arrow-left' style='font-size:15px'></i></a>";
                } elseif ($row['available'] == '-1') {
                    $stock_user = "DAMAGED";
                    $classavailable = "bg-warning";
                    $setstatus = "border-warning";
                    //$setstatus = "<img src='components/damaged.png' width='10px' alt='DAMAGED'/>";
                    $button_get = "<a href='#' id='" . $row['psc_id'] . "' class='btn btn-warning btn-sm text-white' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'><i class='fa fa-arrow-left' style='font-size:15px'></i></a>";
                } else {
                    $classavailable = "bg-danger";
                    $stock_user = "[" . $row["stock"] . "] - " . $row["user_know"];
                    $setstatus = "border-danger";
                    //                        $setstatus = "<img src='components/notavailable.png' width='50px' title='" . $row["user_know"] . "'/>";
                    $button_get = "<a href='#' id='" . $row['psc_id'] . "' class='btn btn-secondary btn-sm ' data-toggle='modal' data-target='#get_tool' onclick='update_modal(this.id)'><i class='fa fa-arrow-left' style='font-size:15px'></i></a>";
                    $button_get .= "&nbsp;<a href='#' id='" . $row['psc_id'] . "' class='btn btn-danger btn-sm float-right' data-toggle='modal' data-target='#return_tool' onclick='return_modal(this.id)'><i class='fa fa-arrow-right' style='font-size:15px'></i></a>";
                }
                $nextcaldate = date("Y-m-d", strtotime($row['reg_date'] . "+ " . $row['common'] . " month"));
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

                echo '     <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2" style="padding:10px;">';
                echo '         <div class="card ' . $setstatus . ' ">';
                echo "             <div class='card-header " . $classavailable . "'>";
                echo "                 <center><small><a href='https://octopart.com/search?q=" . $row["model"] . "' target='_blank' class='text-white'>" . $row["manufacturer"] . " </a> - <a href='index?srch=" . $row["model"] . "' target='_self' class='text-white'>" . $row["model"] . " </a></small></center>";
                echo '             </div>';
                echo '             <div class="col-xs-12 col-sm-12"><br>';
                echo "<a href='tools_imgs/" . $row["img"] . "' data-lightbox='image-1' data-title='" . $row["model"] . "' ><img src='tools_imgs/" . $row["img"] . "' class='card-img' style='max-height: 150px' $onerrorprint /></a>";

                echo '             </div>';
                echo '             <div class="card-body">';
                echo "                 <center><small><b><a href='tool_details.php?id=" . $row['psc_id'] . "' >" . $row["psc_id"] . "</a></b></small><a href='#' class='float-right' id='" . $row['psc_id'] . "' onclick='addcommon(this.id)'><small><i class='fa fa-plus'></i></small></a></center>";
                echo '                 <small>';
                echo "                     NEXT CAL. DATE: $nextcaldate </small><br>";
                echo "                 <small> REMAINING DAYS: $calibrationnow </i>";
                echo '                 </small><br>';
                echo '                 <small>LAST USE: ' . $row["last_use"] . '</small><br>';
                echo '                 <small>STORAGE | USER: <b>' . $stock_user . '</b></small>';
                echo '                 <div class="col-12">';
                echo $button_get;
                echo '                 </div>';

                echo '             </div>';
                echo '         </div>';
                echo '     </div>';


                //         printf("<tr><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td class='text-center'>&nbsp;%s&nbsp;</td><td class='text-center'>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", "<a href='tool_details.php?id=" . $row['psc_id'] . "' >" . $row["psc_id"] . "</a>", "<a href='https://octopart.com/search?q=" . $row["model"] . "' target='_blank'>" . $row["manufacturer"] . "  <i class='fa fa-cog float-right'></i> </a>  ", "<a href='index?srch=" . $row["model"] . "' target='_self'>" . $row["model"] . " </a><a href='#' class='float-right' id='" . $row['psc_id'] . "' onclick='addcommon(this.id)'><small><i class='fa fa-plus'></i></small></a> | &nbsp;<a href='http://192.0.0.125/TOOLS/" . $row['manufacturer'] . "/" . substr($row['manufacturer'], 0, 3) . " " . $row['model'] . ".pdf' target='_blank' class='float-center' id='" . $row['psc_id'] . "' ><small><i class='fa fa-file-text-o'></i></small></a> ", $row["description"], $calibrationnow, $row["last_use"], "<small>" . $stock_user . "</small>", $setstatus, "<a href='tools_imgs/" . $row["img"] . "' data-lightbox='image-1' data-title='" . $row["model"] . "' ><img src='tools_imgs/" . $row["img"] . "' class='img-thumbnail' width='50px' $onerrorprint /></a>", $button_get);
            }

            ?>