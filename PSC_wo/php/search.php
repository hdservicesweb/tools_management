<?php
if (!isset($_POST['search'])) exit('No se recibió el valor a buscar');

require_once 'conexion.php';

function search()
{
  $mysqli = getConnexion();
  $search = $mysqli->real_escape_string($_POST['search']);

  $query = "SELECT * from wo_completed WHERE psc_no LIKE '%$search%' or picking LIKE '%$search%' order by last_movement desc limit 15  ";
  $res = $mysqli->query($query);

  if ($row = mysqli_num_rows($res) > 0) {
    echo "<table class='table table-striped table-bordered table-hover' width='100%' style='font-size:12px;text-align:center'>";
    printf("<tr><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th><th>&nbsp;%s&nbsp;</th></tr>", "PSC No", "<i class='fa fa-flag'></i>", "<i class='fa fa-print'></i> Printed", "<i class='fa fa-calendar'></i> Due Date", "Qty", "<i class='fa fa-inbox'></i> Closed Date", "<i class='fa fa-star'></i>", "<i class='fa fa-upload'></i>");
  };
  while ($row = $res->fetch_array(MYSQLI_ASSOC)) {


    $starqty = substr($row["priorizetotal"], -1);
    $colorstars = "";
    $staricon = "";
    switch ($starqty) {
      case '1':
        $colorstars = "green";
        for ($i = 0; $i < $starqty; $i++) {
          $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
        }
        break;
      case '2':
        $colorstars = "green";
        for ($i = 0; $i < $starqty; $i++) {
          $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
        }
        break;
      case '3':
        $colorstars = "orange";
        for ($i = 0; $i < $starqty; $i++) {
          $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
        }
        break;
      case '4':
        $colorstars = "orange";
        for ($i = 0; $i < $starqty; $i++) {
          $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
        }
        break;
      case '5':
        $colorstars = "red";
        for ($i = 0; $i < $starqty; $i++) {
          $staricon .= "<i class='fa fa-star' aria-hidden='true' style='color:" . $colorstars . "'></i>";
        }
        break;
      default:
        # code...
        break;
    }


    // echo $staricon;
    printf("<tr><td>&nbsp;%s</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td><td>&nbsp;%s&nbsp;</td></tr>", "<a href='closed?srch=" . $row["id"] . "'>" .  $row["psc_no"] . "</a>",  $row["picking"], $row["printed"], $row["due_date"],  $row["qty"], $row["last_movement"], $staricon, "");
  }
  echo "</table>";
}

search();
