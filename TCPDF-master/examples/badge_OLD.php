<?php
require_once('tcpdf_include.php');
include ('../../conexion2.php'); 

$width = 300;
$height = 800;
$pageLayout = array($width, $height); //  or array($height, $width) 

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'GSA_BADGE', true, 'UTF-8', false);

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->setJPEGQuality(75);
$style = array(
	'border' => true,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false,
	'module_width' => 1, 
	'module_height' => 1 
);
$style2 = array(
	'border' => true,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false,
	'module_width' => 1, 
	'module_height' => 1 
);

$employee_number = $_GET['id'];

$id_empl = $_GET['realid'];
$sqlparaEmployees = "SELECT * from EMPLOYEES where ID_EMP = '$id_empl'";
$getemployees = sqlsrv_query($conn,$sqlparaEmployees); 
while ($employes = sqlsrv_fetch_array($getemployees)){ 
$photo = $employes['picture'];
$nombre =  $employes['NAME'];
$nombre = strtoupper($nombre);
}
//$employee_number = '553';
//$employee_name = 'Omar Martinez';
$pdf->AddPage();
$caracteresenname = strlen($nombre);
if ($caracteresenname >= '20') {
	
}else{
	$pdf->Image('../../'.$photo.'', 5, 5, 30, 0, 'JPG', 'http://www.gsassembly.com', '', true, 150, '', false, false, 1, false, false, false);
	
	$pdf->Image('../../upload_pic/contractor.jpg', 38, 25, 10, 0, 'JPG', 'http://www.gsassembly.com', '', true, 150, '', false, false, 0, false, false, false);
	
	$pdf->Image('../../upload_pic/contractor.jpg', 38, 25, 10, 0, 'JPG', 'http://www.gsassembly.com', '', true, 150, '', false, false, 0, false, false, false);
	
	$html = '
	<table>
	<tr>
		<td width="70%" cellpadding="0"><img src="../../'.$photo.'" alt="" width="350" height="430" border="1" /></td>
		<td width="30%" valign="bottom">&nbsp;<img src="../../upload_pic/contractor.jpg" alt="" width="150" height="230" border="0" /></td>
	</tr>
	<tr>
		<td colspan="2">
			
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<p align="center"><b>'.$nombre.'</b></p>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<p align="center"><img src="images/Untitled.png" alt="Golden State Manufacturing Services." width="400" height="100" border="0" /></p>
		</td>
	</tr>
</table>';
	$pdf->SetFont('helvetica', '0', 10);	
}

$pdf->writeHTML($html, true, 0, true, 00);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->write1DBarcode($employee_number, 'C39', '15', '242', '250', 30, 1.5, $style, 'N');
						//valor		//tipo    PosX   PosY  Largo ancho  
$pdf->Output('badge.pdf', 'I');



//----------------------

