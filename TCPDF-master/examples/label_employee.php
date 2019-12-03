<?php

require_once('tcpdf_include.php');
$width = 900;
$height = 300;
$pageLayout = array($width, $height); //  or array($height, $width) 
$pdf = new TCPDF('l', 'pt', $pageLayout, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$style = array(
	'border' => false,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false,
	'module_width' => 1, 
	'module_height' => 1 
);

$employee_number = $_GET['id'];
$employee_name = $_GET['name'];
$tipo = $_GET['T'];

//$employee_number = '553';
//$employee_name = 'Omar Martinez';
if ($tipo == '2') {
	$pdf->AddPage();
$pdf->SetFont('helvetica', '', 40);
$pdf->write2DBarcode($employee_number, 'DATAMATRIX', 10, 25, 350,290, $style, 'N');
$txt = 'GOLDEN STATE ASSEMBLY';
$pdf->MultiCell(550, 100, $txt, 0, 'L', false, 1, 230, 30, true, 0, false, true, 0, 'T', false);
$txt = "USERNAME : " . $employee_name;
$txt = "USERNAME : " . $employee_name;
$pdf->MultiCell(550, 50, $txt, 0, 'L', false, 1, 230, 130, true, 0, false, true, 0, 'T', false);

$pdf->Output('label.pdf', 'I');
}else{
	$pdf->AddPage();
$pdf->SetFont('helvetica', '', 40);
$pdf->write2DBarcode($employee_number, 'DATAMATRIX', 10, 25, 350,290, $style, 'N');
$txt = 'GOLDEN STATE ASSEMBLY';
$pdf->MultiCell(550, 100, $txt, 0, 'L', false, 1, 230, 30, true, 0, false, true, 0, 'T', false);
$txt = "NAME : " . $employee_name;
$pdf->MultiCell(550, 50, $txt, 0, 'L', false, 1, 230, 130, true, 0, false, true, 0, 'T', false);

$pdf->Output('label.pdf', 'I');
}
