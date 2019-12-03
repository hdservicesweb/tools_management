<?php
require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, '', true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);


$style = array(
	'border' => false,
	'vpadding' => '0',
	'hpadding' => '0',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false,
	'module_width' => .60, 
	'module_height' => .60 
);

$employee_number = $_GET['id'];
$employee_name = $_GET['name'];
$tipo = $_GET['T'];

//$employee_number = '553';
//$employee_name = 'Omar Martinez';
if ($tipo == '2') {
$pdf->AddPage('L', "GSABrady");
$pdf->SetFont('helvetica', '', 4);
$pdf->write2DBarcode($employee_number, 'DATAMATRIX', .5, .5, 0,0, $style, 'N');
$txt = 'GOLDEN STATE ASSEMBLY';
$pdf->MultiCell(0, 0, $txt, 0, 'L', false, 0, 0, 0, true, 0, false, true, 0, 'T', false);
/*$txt = "USERNAME : " . $employee_name;

$pdf->MultiCell(550, 50, $txt, 0, 'L', false, 1, 230, 130, true, 0, false, true, 0, 'T', false);
*/
$pdf->Output('label.pdf', 'I');
}else{
$pdf->AddPage('L', "GSABrady");
$pdf->SetFont('helvetica', '', 6);
$pdf->write2DBarcode($employee_number, 'DATAMATRIX', 10, 25, 10,10, $style, 'N');
$txt = 'GOLDEN STATE ASSEMBLY';
$pdf->MultiCell(550, 100, $txt, 0, 'L', false, 1, 230, 30, true, 0, false, true, 0, 'T', false);
$txt = "NAME : " . $employee_name;
$pdf->MultiCell(550, 50, $txt, 0, 'L', false, 1, 230, 130, true, 0, false, true, 0, 'T', false);

$pdf->Output('label.pdf', 'I');
}
