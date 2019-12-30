<?php
include('../conection.php');
$link = Conectarse();

$csv_filename = 'import_file/db_export_' . date('Y-m-d') . '.csv';
$nameoffile = 'db_export_' . date('Y-m-d') . '.csv';
function mysqli_field_name($result, $field_offset)
{
    $properties = mysqli_fetch_field_direct($result, $field_offset);
    return is_object($properties) ? $properties->name : null;
}
// create var to be filled with export data
$csv_export = '';
$delimiter = ",";
// query to get data from database
$query = mysqli_query($link, "SELECT * FROM tools_main_db");
$field = mysqli_num_fields($query);
$f = fopen($csv_filename, 'w');
// create line with field names


$header = array("ID", "MANUFACTURER", "TOOL_MODEL", "CERTIFICATE_NO", "NEXT_CALIB_DATE", "LAST_CALIB_DATE", "DESCRIPTION", "NOTES", "LAST_USE_DATE", "STOCK", "STATUS", "CALIB_PERIOD", "IMAGE", "NAME_TRIMMED", "USED_TIMES", "LAST_USER");
fputcsv($f, $header, $delimiter);
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    // create line with field values
    // $lineData = array($row[mysqli_field_name($query,$i)]);
    $lineData = array($row['psc_id'], $row['manufacturer'], $row['model'], $row['certif_num'], date("Y-m-d", strtotime($row['reg_date'] . "+ " . $row['common'] . " month")), date("m/d/Y", strtotime($row['reg_date'])), $row['description'], $row['notes'], $row['last_use'], $row['stock'], $row['available'], $row['common'], $row['img'], $row['trimmed'], $row['used_qty'], $row['user_know']);
    fputcsv($f, $lineData, $delimiter);
}
// Export the data and prompt a csv file for download
if (fclose($f)) {
    echo "<script>window.close();</script>";
}
?>
