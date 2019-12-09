<?php
require_once('tcpdf_include.php');
include('../../conection.php');
date_default_timezone_set('America/Los_Angeles');

$link = Conectarse();
if (isset($_REQUEST['wo'])) {
	$wo = $_REQUEST['wo'];

	//aregar contador de imrpesiones
	$sqlcountprinted = "SELECT COUNT(id) as qtyImp from printed where id = '$wo'";
	$countqty = mysqli_query($link, $sqlcountprinted) or die("Something wrong with DB please verify.");
	$qtyimpresed =  mysqli_fetch_array($countqty);
	$manytimes = $qtyimpresed['qtyImp'];
	if ($manytimes == 0) {
		$sqlinsert = "INSERT into printed values (null,'$wo','',CURRENT_TIMESTAMP,'1')";
		$execsqlinsert =  mysqli_query($link, $sqlinsert);
	} else {
		$sqlinsert = "INSERT into printed values (null,'$wo','',CURRENT_TIMESTAMP,'$manytimes')";
		$execsqlinsert =  mysqli_query($link, $sqlinsert);
	}

	switch ($wo) {
		case '11111':
			$area = "CLOSE ";
			$messagelabel = "Direct assignment CLOSSING WO. ";
			break;
		case '55555':
			$area = "ASSIGN ";
			$messagelabel = "Direct assignment of a WO to an employee. ";
			break;
		case '77777':
			$area = "QC ";
			$messagelabel = "Direct assignment of a WO to QC. ";
			break;
		case '99999':
			$area = "SHIPPED";
			$messagelabel = "Direct assignment of a WO to SHIPPED STATUS. ";
			break;
		default:
			$area = $wo;
			$messagelabel = "Notes: ";
			break;
			$picking = "";
	}
} else {
	$wo = "ERROR";
}
$SQLDATA = "SELECT * from wo where id = '$wo' order by printed	 desc limit 1";
$wodata = mysqli_query($link, $SQLDATA) or die("Something wrong with DB please verify.");
$row = mysqli_fetch_array($wodata);
$area = $row['psc_no'];
$picking = $row['picking'];
if (isset($row['qty'])) {
	$qty = $row['qty'];
} else {
	$qty = "-";
}
if (isset($row['due_date'])) {
	// $date_p = substr($row['due_date'],0,10);
	$date_p2 = strtotime(substr($row['due_date'], 0, 10));
	$date_p = date('m/d/Y', $date_p2);
} else {
	$date_p = "-";
}
$starts = substr($row['priorizetotal'], -1);


$pdf = new TCPDF('L', PDF_UNIT, 'PSC_WO', true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(true);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(0, 0, 0, 0);
$style = array(
	'border' => true,
	'vpadding' => '2',
	'hpadding' => '2',
	'fgcolor' => array(0, 0, 0),
	'bgcolor' => false,
	'module_width' => 40,
	'module_height' => 1
);
$style2 = array(
	'border' => false,
	'vpadding' => '2',
	'hpadding' => '2',
	'fgcolor' => array(0, 0, 0),
	'bgcolor' => false,
	'module_width' => 40,
	'module_height' => 1
);


$employee_number = ' ';
$employee_name = ' ';
$nombre = ' ';
$pdf->AddPage();
$caracteresenname = strlen($employee_name);
// $pdf->SetFont('HelveticaB', '0', 25);

$pdf->StartTransform();
$pdf->Rotate(90);
$pdf->write1DBarcode($row['psc_no'], 'C39', '-61', '5', 59, 15, 1, $style, 'N');
$pdf->StopTransform();

$pdf->SetFont('HelveticaB', '0', 40);
$pdf->Text(35, 0, $area, false, false, true, 0, 1, 'L');
$pdf->SetFont('Helvetica', '0', 8);
$pdf->Text(50, 15, $picking, false, false, true, 0, 1, 'L');
$pdf->SetFont('HelveticaB', '0', 14);

$pdf->Text(28, 20, "QTY ");
$pdf->Text(28, 26, $qty);
$pdf->Text(83, 20, "DATE ");
$primerastrella = 45;
$sumando = 7;
for ($i = 0; $i < $starts; $i++) {
	$pdf->Image('images/star.jpg', ($primerastrella + ($sumando * $i)), 20, 6, 6, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);
}


$pdf->Text(70, 26, $date_p);
$pdf->Line(25, 1, 25, 60, $style);


//$pdf->Text(20, 145, 'QRCODE Q');
//$pdf->Text( 8, 10,$wo );


// $pdf->Text(3, 50, $nombre);



$pdf->write1DBarcode($row['psc_no'], 'C39', '29', '30', 70, 13, 1, $style2, 'N');
$pdf->SetFont('Helvetica', null, 10);
$pdf->Text(28, 47, $messagelabel);
$pdf->SetFont('Helvetica', null, 9);

$noteas = '<table border="0" cellspacing="0" cellpadding="0">';

$SQLMSG = "SELECT * from messages where relation = '$wo' and read_ <= 10 order by date desc limit 4";
$womess = mysqli_query($link, $SQLMSG) or die("Something wrong with DB please verify.");


while ($msg = mysqli_fetch_array($womess)) {
	$noteas .= "<tr>
<td>" . $msg['message'] . "</td>
</tr>";
}

$noteas .= '</table>';
$pdf->writeHTMLCell(68, 17, 40, 42, $noteas, 0, 0, 0, true, 'L', true);


//valor	//tipo    PosX   PosY  Largo ancho  
$pdf->Output('box_' . $wo . '.pdf', 'I');



//----------------------
