<?php
include("../header.php");
$link = Conectarse();
$uploads_dir = 'tools_imgs/';
if ((isset($_REQUEST['finish'])) && ($_REQUEST['finish'] == "Save")) {
    $tmp_name = $_FILES["IMAGEN"]["tmp_name"];
    $name = $_FILES['IMAGEN']['name'];

    $sqlsave = "INSERT into tools_main_db (`id_tool`, `psc_id`, `manufacturer`, `model`, `certif_num`, `qty`, `reg_date`, `description`, `notes`, `last_use`, `stock`, `available`, `common`, `img`, `trimmed`, `used_qty`, `user_know`)
    values (NULL,'" . $_REQUEST['PSC_ID'] . "','" . $_REQUEST['MANUF'] . "','" . $_REQUEST['MODEL'] . "', '" . $_REQUEST['CERTIF'] . "', '1', CURRENT_TIMESTAMP, '" . $_REQUEST['DESCR'] . "', '" . $_REQUEST['NOTES'] . "', CURRENT_TIMESTAMP, 'X', '1', '" . $_REQUEST['common'] . "', '" . $name . "', '" . $_REQUEST['MODEL'] . "', '0', 'NO_USER')";
    //echo $sqlsave;
    if (mysqli_query($link, $sqlsave)) {
        $upload_image = $_FILES['IMAGEN']['tmp_name'];
        // echo  $upload_image;
        move_uploaded_file($_FILES['IMAGEN']['tmp_name'], $uploads_dir . $_FILES['IMAGEN']['name']);
        echo "SAVED";
    } else {
        echo $sqlsave;
        echo "<b>NO SAVED</b>";
        echo "<br> Please verify information.";
    }
} else {
    // echo "NO FLAG";
}
?>
<div class="container-fluid">
    <div class="col-sm-12 col-md-6">


        <div class="card">
            <div class="card-header bg-success text-white">
                <b> NEW TOOL FORM</b>
            </div>
            <div class="card-body">
                <form action="new_tool.php" class="needs-validation" id="form_new" method="post" onsubmit="event.preventDefault(); returnea();" enctype="multipart/form-data">
                    <input type="text" name="finish" value="Save" readonly hidden />
                    <div class="form-row">
                        <div class="col-4">
                            <label class="small" for="validationServer03">PSC ID:</label>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">PSC ID.</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="PSC_ID" value="PSC-" required>
                            </div>
                        </div>

                        <div class="col-4">
                            <label class="small" for="validationServer03">MANUFACTURER:</label>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">BRAND:</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="MANUF" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="small" for="validationServer03">MODEL:</label>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">MODEL:</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="MODEL" required>
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-3">
                                    <label class="small" for="validationServer03">CERTIFICATE NUMBER:</label>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">CERTF #:</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="CERTIF" required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <label class="small" for="validationServer03">CAL. PERIOD:</label>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">CP:</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="common" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="small" for="validationServer03">DESCRIPTION:</label>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">DESC:</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="DESCR" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label class="small" for="validationServer03">NOTES:</label>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">NOTE:</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="NOTES" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="form-row">

                            <div class="col">
                                <div class="col-12">
                                    <label class="small" for="validationServer03">IMAGE:</label>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">IMG:</span>
                                        </div>
                                        <input type="file" class=" files" name="IMAGEN" required>

                                        <!-- <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="NOTES" required> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="small text-center">AUTHORIZATION</span>

                                    </div>
                                    <input type="password" id="password" name="password" aria-label="Small" aria-describedby="inputGroup-sizing-sm" class="form-control input-small" required>

                                </div>
                            </div>
                            <br>
                            <div class="col-12">
                                <label for="PSC_ID"><br> </label><br>
                                <button type="submit" class="btn btn-success"> Save </button>
                                <a class="btn btn-secondary" href="new_tool.php"> Cancel </a>
                            </div>



                        </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function returnea() {
        var pass = document.getElementById("password").value;
        if ((pass == "<?= $authorization ?>") || pass == "ADMINPCS159") {
            // alert("PASS CORRECT");
            document.getElementById('form_new').submit();

        } else {
            alert("WRONG PASSWORD");

        }
    }
</script>
<?php
include('../footer.php');
?>