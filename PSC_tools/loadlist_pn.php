<?php
include('../header.php');
$link = Conectarse();

if ((isset($_REQUEST['command'])) && ($_REQUEST['command'] == 'save_list')) {
$tool = $_REQUEST['tool'];
    if (isset($_FILES['pn_list'])) {

        if ($_FILES["pn_list"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
        } else {
            if (($handle = fopen($_FILES["pn_list"]["tmp_name"], "r")) !== FALSE) {

                while (($line = fgetcsv($handle)) !== FALSE) {
                    $trimmed = str_replace("-", "", trim($line[3]));
                    $sql = "INSERT INTO `common_tb` (`id`, `component_pn`, `tool_pn`, `trimmed`, `manufacturer`, `img`, `import_verif`) VALUES (NULL, '$line[3]', '$tool', '$trimmed', '$line[4]', '$line[1]', '1');";
                    $savecomponents = mysqli_query($link, $sql);

                }
                fclose($handle);
                echo "<script>window.close();</script>";
            }
        }
    } else {
        echo "NO FILE UPLOAD";
    }
    // 
}
?>
<!-- 
echo "<a href='index' class='btn btn-success float-right'>RETURN</a>";
            //Print file details
            echo "Upload: " . $_FILES["importfile"]["name"] . "<br />";
            echo "Type: " . $_FILES["importfile"]["type"] . "<br />";
            echo "Size: " . ($_FILES["importfile"]["size"] / 1024) . " Kb<br />";
            echo "Temp file: " . $_FILES["importfile"]["tmp_name"] . "<br />";
            
            
            //if file already exists
            if (file_exists("import_file/" . $_FILES["importfile"]["name"])) {
                $storagename = "pn_list.csv";
                
                move_uploaded_file($_FILES["importfile"]["tmp_name"], "import_file/" . $storagename);
            } else {
                //Store file in directory "import_file" with the name of "uploaded_file.csv"
                $storagename = "pn_list.csv";
                move_uploaded_file($_FILES["importfile"]["tmp_name"], "import_file/" . $storagename);
                // echo "Stored in: " . "import_file/" . $_FILES["importfile"]["name"] . "<br />";
            }
            echo "<hr>";
        } -->