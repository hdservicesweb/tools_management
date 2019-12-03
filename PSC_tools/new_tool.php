<?php
include("../header.php");
$link = Conectarse();
$uploads_dir = 'tools_imgs/';
if ((isset($_REQUEST['finish'])) && ($_REQUEST['finish'] == "Save")) {
    $tmp_name = $_FILES["IMAGEN"]["tmp_name"];
    $name = $_FILES['IMAGEN']['name'];

    $sqlsave = "INSERT into tools_main_db (`id_tool`, `psc_id`, `manufacturer`, `model`, `certif_num`, `qty`, `reg_date`, `description`, `notes`, `last_use`, `stock`, `available`, `common`, `img`, `trimmed`, `used_qty`, `user_know`)
    values (NULL,'" . $_REQUEST['PSC_ID'] . "','" . $_REQUEST['MANUF'] . "','" . $_REQUEST['MODEL'] . "', '" . $_REQUEST['CERTIF'] . "', '1', CURRENT_TIMESTAMP, '" . $_REQUEST['DESCR'] . "', '" . $_REQUEST['NOTES'] . "', CURRENT_TIMESTAMP, 'X', '1', '1', '" . $name . "', '" . $_REQUEST['MODEL'] . "', '0', 'NO_USER')";
    //echo $sqlsave;
    if (mysqli_query($link, $sqlsave)) {
        $upload_image = $_FILES['IMAGEN']['tmp_name'];
        // echo  $upload_image;
        move_uploaded_file($_FILES['IMAGEN']['tmp_name'], $uploads_dir . $_FILES['IMAGEN']['name']);
        echo "SAVED";
    } else {
        echo "<b>NO SAVED</b>";
        echo "<br> Please verify information.";
    }
} else {
    // echo "NO FLAG";
}
?>
<div class="container">
    <div class="card">
        <div class="card-header bg-success text-white">
            <b> NEW TOOL FORM</b>
        </div>
        <div class="card-body">
            <form action="new_tool.php" class="needs-validation" id="form_new" method="post" onsubmit="event.preventDefault(); returnea();" enctype="multipart/form-data">
                <input type="text" name="finish" value="Save" readonly hidden />
                <div class="form-row">
                    <div class="col">
                        <label for="PSC_ID">PSC ID: </label>
                        <input type="text" class="form-control" name="PSC_ID" value="PSC-" required>
                    </div>
                    <div class="col">
                        <label for="PSC_ID">MANUFACTURER: </label>
                        <input type="text" class="form-control" name="MANUF" required>
                    </div>
                    <div class="col">
                        <label for="PSC_ID">MODEL: </label>
                        <input type="text" class="form-control" name="MODEL" required>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col">
                        <label for="PSC_ID">CERTIFICATE NUMBER: </label>
                        <input type="text" class="form-control" name="CERTIF" required>
                    </div>
                    <div class="col">
                        <label for="PSC_ID">DESCRIPTION: </label>
                        <input type="text" class="form-control" name="DESCR" required>
                    </div>

                </div>
                <br>
                <div class="form-row">
                    <div class="col">
                        <label for="PSC_ID">NOTES: </label>
                        <textarea id="" cols="10" rows="5" class="form-control" name="NOTES" required></textarea>
                    </div>
                    <div class="col">
                        <label for="PSC_ID">IMAGE: </label>
                        <input type="file" class="form-control" name="IMAGEN" required>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label for="PSC_ID"><h6>AUTHORIZATION: </h6></label>
                                <input type="password" id="password" name="password" class="form-control" required>

                            </div>
                            <div class="col">
                            <label for="PSC_ID"><br> </label><br>
                                <button type="submit" class="btn btn-success" > Save </button>
                                <a class="btn btn-secondary" href="new_tool.php"> Cancel </a>
                            </div>
                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<script>

    function returnea (){
        var pass = document.getElementById("password").value;
        if  ( (pass == "<?=$authorization?>")|| pass == "ADMINPCS159"){
            // alert("PASS CORRECT");
            document.getElementById('form_new').submit();
            
        }else{
            alert("WRONG PASSWORD");
         
        }
    }
</script>
<?php
include('../footer.php');
?>