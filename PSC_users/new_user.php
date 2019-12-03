<?php
include("../header.php");
$link = Conectarse();
$sqlusersinfo = "SELECT employ_num from employes order by employ_num desc limit 1";
$nextemployee = mysqli_fetch_array(mysqli_query($link, $sqlusersinfo));
$employeenum = $nextemployee[0];

$userspost = "SELECT * from positions where xtra = 'users'";




$uploads_dir = 'photos_users/';
if ((isset($_REQUEST['finish'])) && ($_REQUEST['finish'] == "Save")) {
    if (isset($_FILES["IMAGEN"]["tmp_name"])) {
        $tmp_name = $_FILES["IMAGEN"]["tmp_name"];
        $name = $_FILES['IMAGEN']['name'];
    } else {
        $name = "";
    }

    $sqlsave = "INSERT into employes (`id_employ`, `employ_num`, `name`, `initials`, `reg_date`, `position`, `available`, `photo`, `password`)
    values (NULL,'" . $_REQUEST['employeenum'] . "','" . $_REQUEST['nombre'] . "','" . $_REQUEST['initials'] . "', CURRENT_TIMESTAMP,  '" . $_REQUEST['POSITION'] . "','1', '" . $name . "','X')";
    // echo $sqlsave;

    //echo $sqlsave;
    if (mysqli_query($link, $sqlsave)) {
        if (isset($_FILES['IMAGEN']['tmp_name'])) {
            $upload_image = $_FILES['IMAGEN']['tmp_name'];
            move_uploaded_file($_FILES['IMAGEN']['tmp_name'], $uploads_dir . $_FILES['IMAGEN']['name']);
        } else {
            $name = "";
        }


        // echo  $upload_image;

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
        <div class="card-header bg-warning text-white">
            <b> NEW USER FORM</b>
        </div>
        <div class="card-body">
            <form action="new_user.php" class="needs-validation" id="form_new" method="post" onsubmit="event.preventDefault(); returnea();" enctype="multipart/form-data">
                <input type="text" name="finish" value="Save" readonly hidden />
                <div class="form-row">
                    <div class="col-2">
                        <label for="EMPLOYEE">EMPLOYEE #: </label>
                        <input type="text" class="form-control" name="employeenum" value="<?= $employeenum + 1; ?>" required readonly>
                    </div>
                    <div class="col">
                        <label for="NAME">NAME: </label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="col-2">
                        <label for="INI">INITIALS: </label>
                        <input type="text" class="form-control" id="initials" name="initials" maxlength="5" onblur="myBlurFunction()()" required>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col">
                        <label for="POSITION">POSITION: </label>
                        <select name="POSITION" id="POSITION" class="form-control">
                            <?php
                            $execuserssettings = mysqli_query($link, $userspost);
                            while ($exeuserpost = mysqli_fetch_array($execuserssettings)) {
                                echo "<option value='" . $exeuserpost['num'] . "'>" . $exeuserpost['num'] . " - " . $exeuserpost['descrip'] . "</option>";
                            }
                            ?>

                        </select>
                    </div>
                    <div class="col">
                        <label for="PSC_ID">PHOTO: </label>
                        <input type="file" class="form-control" name="IMAGEN">
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label for="PSC_ID">
                                    <h6>AUTHORIZATION: </h6>
                                </label>
                                <input type="password" id="password" name="password" class="form-control" required>

                            </div>
                            <div class="col">
                                <label for="PSC_ID"><br> </label><br>
                                <button type="submit" class="btn btn-warning text-white"> Save </button>
                                <a class="btn btn-secondary" href="new_tool.php"> Cancel </a>
                            </div>
                        </div>


                    </div>

                </div>
                <br>

            </form>



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
    function myBlurFunction() {
            var valor = document.getElementById("initials").value.toUpperCase();
            document.getElementById("initials").value = valor;
        }
</script>
<?php
include('../footer.php');
?>