<?php
include("../header.php");
$link = Conectarse();

if ((isset($_REQUEST['new_key'])) && (isset($_REQUEST['user']))) {
    $new_key = $_REQUEST['new_key'];
    $user = $_REQUEST['user'];
    $key = base64_encode($new_key);
    $SQL_UPDATE = "UPDATE settings set value = '$key', registry = '$user' where functions = 'registry_key'";
    //echo $SQL_UPDATE;
    if ($SAVEKEY = mysqli_query($link, $SQL_UPDATE) or die("Something wrong with DB please verify.")) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="alertdone">
        <strong>Success!</strong> ACTION HAS BEEN EXECUTED.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="container text-center">
<p align=""center><a href="index" target="_self" class="btn btn-sm btn-success text-white">Home <i class="fa fa-home"></i></a></p>
      </div>
      ';
    } else {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="alertdone">
        <strong>Warning!</strong> ACTION HAS ALREADY BEEN EXECUTED. <a href="new_view" class="alert-link"> Dismiss. </a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
} else {
?>
    <div class="modal-header">
        <h3>Registry</h3>
    </div>
    <form action="registry" method="post" id="registry_form">
        <div class="modal-body">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-cubes"></i></span>
                </div>

                <input type="text" class="form-control" placeholder="Company Name" name="user" id="user" required>
            </div>
            <br>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                </div>

                <input type="text" class="form-control" placeholder="Key" name="new_key" id="new_key" required>
            </div>
        </div>
        <div class="modal-footer">
            <input type="submit" class="btn btn-warning btn-sm text-white" value="Save">
    </form>
    <a href="index" data-dismiss="modal" class="btn btn-danger btn-sm">Close</a>
    <div class="container text-center">
<p align=""center><a href="index" target="_self" class="btn btn-sm btn-success text-white">Home <i class="fa fa-home"></i></a></p>
      </div>





<?php }
include('../footer.php');
?>