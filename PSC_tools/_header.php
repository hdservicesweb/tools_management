<?php
include('conection.php');
date_default_timezone_set('America/Los_Angeles');
if (isset($_REQUEST['srch'])) {
  $search = $_REQUEST['srch'];
} else {
  $search = "";
}
$host= $_SERVER["PHP_SELF"];
echo $host;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script defer src="fontawesome/js/all.js"></script>
  <!--load all styles -->
  <link href="lightbox/dist/css/lightbox.css" rel="stylesheet" />
  <title>PSC - Tools Management</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <a class="navbar-brand" href="#">PSC Electronics</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <!-- <li class="nav-item">
        <a class="nav-link" href="tools.php">Catalog</a>
      </li> -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="main_tools" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Tools
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="main_tools">Start</a>
            <a class="dropdown-item" href="new_tool">New</a>
            <a class="dropdown-item" href="show_me">Show</a>
            <a class="dropdown-item" href="tools">Catalog</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="search_external.php">Search In</a>
          </div>
        </li>
        <!-- <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li> -->
      </ul>
      <form action="main_tools" class="form-inline my-2 my-lg-0" id="searchform">

        <input class="form-control-sm mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="srch" id="srch" value="" autofocus>
        <input type="checkbox" name="common" id="common_main" hidden>
        <button class="btn btn-outline-success my-2 my-sm-0 btn-sm" type="submit">Search</button>
      </form>
    </div>
  </nav>
  <br>