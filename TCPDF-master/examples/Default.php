<?php 
require_once('tcpdf_include.php'); 
include('Default_settings.php'); 
 
$name = $_REQUEST['layout']; 
$id_size = $_REQUEST['id_size']; 
$serverName= '10.0.0.24,1433'; 
$connectionInfo = array( 'Database'=>'GSA', 'UID'=>'sa', 'PWD'=>'reloj$123'); 
$conn = sqlsrv_connect($serverName, $connectionInfo); 
if( $conn === false ) { die( print_r( sqlsrv_errors(), true )); } 
$sql = "SELECT * from labelsize_dtl where id_size = $id_size "; 
 
$stmt = sqlsrv_query($conn, $sql);
$pdf->AddPage(); 
  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) { 
 
  switch ($row['type']) { 
 
case 'MultiCell': 
$pdf->$row['type']($row['textareaWidth'], $row['textareaheight'], $row['value'], $row['contorno'], $row['align'], $row['relleno'], $row['ln'], $row['posX'], $row['posY'], $row['reseth'], $row['extraval1'], $row['inhtml'], $row['autopadding'], $row['maxh'], 'T', $row['extraval2']); 
break; 
 
case 'QRCODE': 
$pdf->write2DBarcode($row['value'], 'QRCODE,$row[quality]', $row['posX'], $row['posY'], $row['alto'], $row['ancho'], $style, 'N'); 
break; 
 
case 'DATAMATRIX': 
$pdf->write2DBarcode($row['value'], 'DATAMATRIX,$row[quality]', $row['posX'], $row['posY'], $row['alto'], $row['ancho'], $style, 'N'); 
break; 
 
  } 
  } 
/*end of file*/$pdf->Output($name.'.pdf', 'I');