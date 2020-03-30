<?php
include('conection.php');
$link = Conectarse();
date_default_timezone_set('America/Los_Angeles');
if (isset($_REQUEST['srch'])) {
  $search = $_REQUEST['srch'];
} else {
  $search = "";
}
$host = $_SERVER["HTTP_HOST"];
$host_user = $_SERVER['REMOTE_ADDR'];
$url = $_SERVER["REQUEST_URI"];
$seg_url = explode("/", $url);
$search_action =  $seg_url[1];
$search_text = explode("_", $search_action);
if (isset($search_text[1])) {
  $search_icon = strtoupper($search_text[1]);
} else {
  $search_icon = " ";
}
$form_action = "index";

//condiciones para ocultar el buscador cuando se ejecuta desde una pantalla
if (isset($seg_url[2])) {
  $screen = explode("_", $seg_url[2]);
  if (isset($screen[1])) {
    if (($screen[1] == "full") || ($screen[1] == "full.php") || ($screen[1] == "FULL")) {
      $varforhidde = "hidden";
    } else {
      $varforhidde = "";
    }
  } else {
    $varforhidde = "";
  }
} else {
  $varforhidde = "";
}

//echo $host_user;
$sqlnameuser = "SELECT * from users_ip where IP_address = '$host_user'";
//echo $sqlnameuser;
$execnameuser = mysqli_query($link, $sqlnameuser);
$posiblenameqty = mysqli_num_rows($execnameuser);
//echo "<br>".$posiblenameqty;
if ($posiblenameqty  > 0) {
    $posiblename = mysqli_fetch_array($execnameuser);
    if (isset($posiblename['user'])) {
        $namestation = $posiblename['user'];
    }
    else{
        $namestation = "NEW";
    }
} else { 
    $sqlrecord = "INSERT into users_ip values (null, '$host_user', 'NO-NAME', 'UNIDENTIFY')";
    $savenameip = mysqli_query($link, $sqlrecord);
    $namestation = "NEW";
}



$querysettings = "SELECT * from settings where functions = 'authorization' limit 1";
$result = $mysqli->query($querysettings);
$rowpassword = $result->fetch_array(MYSQLI_BOTH);
$authorization =  $rowpassword[2];
$querysettings_key = "SELECT * from settings where functions = 'registry_key' limit 1";
$result_key = $mysqli->query($querysettings_key);
$licence_key = $result_key->fetch_array(MYSQLI_BOTH);
if(isset ($licence_key[2])){
  $authorization_key = $licence_key[2];
  $registry_user = $licence_key[3];
}else{
  $authorization_key = 0;
  $registry_user = '';
  $sqlinsertkey ="INSERT into settings values (null,'registry_key','$authorization_key','')";
  //echo $sqlinsertkey;
  $mysqli->query($sqlinsertkey);
};

$key_ = "<iframe src='http://hdservicesweb.com/certificate/public/?key=".$authorization_key.'&user='.$registry_user.'" frameborder="0" width="100%" class="fixed-bottom" height="50px" scrolling="no" allowtransparency="true" style="border: 0;padding: 0px; margin: 0px;background:none transparent;  overflow:hidden;"></iframe>';
$result_key->free();
$mysqli->close();
//echo $authorization_key;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <!-- <script defer src="../fontawesome/js/all.js"></script> -->
  <link rel="shortcut icon" href="../psc_logo.png">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <!--load all styles -->
  <link href="../lightbox/dist/css/lightbox.css" rel="stylesheet" />
  <title>PSC Electronics (<?= $search_icon ?>)</title>
  <link rel="stylesheet" href="../customs.css">

  <script src="../lightbox/dist/js/lightbox-plus-jquery.js"></script>

  
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

  <script>
        function openkey() {
            $(document).ready(function() {
                $("#key_form").modal("show");
            });
        }
    </script>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top" <?= $varforhidde ?>>
    <a class="navbar-brand" href="http://<?= $host; ?>"><img src="../psc_logo.png" width="60px" alt="PSC Electronics"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index"><i class="fa fa-home fa-sm"></i> Home <span class="sr-only">(current)</span></a>
        </li>
        <!-- <li class="nav-item">
        <a class="nav-link" href="tools.php">Catalog</a>
      </li> -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="main_tools" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-wrench"></i> Tools
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="../PSC_tools/index">Start</a>
            <a class="dropdown-item" href="../PSC_tools/new_tool">New</a>
            <a class="dropdown-item" href="../PSC_tools/show_me">Show</a>
            <a class="dropdown-item" href="../PSC_tools/tools">Catalog</a>
            <a class="dropdown-item" href="../PSC_tools/tool_req">Tooling Requirement</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../PSC_tools/statistics.php">Statistics</a>
            <a class="dropdown-item" href="../PSC_tools/request_t.php">Request Tool</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="index" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user fa-sm"></i> Users
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="../PSC_users/index">Home</a>
            <a class="dropdown-item" href="../PSC_users/new_user">New</a>
            <a class="dropdown-item" href="../PSC_users/onhold">On Hold</a>
            <a class="dropdown-item" href="../PSC_users/show_users">View all</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../PSC_users/timer" target="_blank">Time Clock</a>
            <a class="dropdown-item" href="../PSC_users/time_card">Time Card</a>
            
            <a class="dropdown-item" href="../PSC_users/view_today">View Today</a>
          </div>
        </li>
        <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle" href="index" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-truck fa-sm"></i> WO Tracking
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="../PSC_wo/index">Home</a>
            <a class="dropdown-item" href="../PSC_wo/new_view">New WO</a>
            <a class="dropdown-item" href="../PSC_wo/edit_wo">Edit WO</a>
            <a class="dropdown-item" href="../PSC_wo/close_wo">Close WOs</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../PSC_wo/view_all">View All</a>
          </div>
        </li>
        <!-- <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li> -->
      </ul>
      <form action="<?= $form_action; ?>" class="form-inline my-2 my-lg-0" id="searchform">

        <input class="form-control form-control-sm mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="srch" id="srch" value="" autofocus autocomplete="off">
        <!-- <input type="checkbox" name="common" id="common_main" hidden> -->
        <button class="btn btn-outline-success my-2 my-sm-0 btn-sm" type="submit"> <i class="fa fa-search"> </i> <?= $search_icon; ?></button>
      </form>
    </div>
  </nav>
  <br>

  
  