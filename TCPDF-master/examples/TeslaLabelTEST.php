<?php
require_once('tcpdf_include.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'TESLALABEL', true, 'UTF-8', false);

$staging = '';
$dock = "NORTH WEST DOCK";
$rocount = "4";
$printon = date('m-d-Y h:i:s');

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(FALSE, 0);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAuthor('Golden State Assembly');
$pdf->SetTitle('Tesla Label');
$pdf->SetMargins(.5,0,-25,0);
$pdf->SetTextColor(0,0,0);
//$pdf->AddPage('L', "TESLALABEL");
$pdf->AddPage('P', "TESLALABEL");


$tbl = <<<EOD
<br>
<br>
<br>
<br>
<br>
<br>
<table >
<tbody>
<tr>
<td width="100" height="20"><p align="left">STAGING LOC:</p></td>
<td><p align="left">$staging</p></td>
</tr>
<tr>
<td width="100" height="20"><p align="left">DOCK:</p></td>
<td><p align="left">$dock</p></td>
</tr>
<tr>
<td width="100" height="20"><p align="left">RO COUNT:</p></td>
<td><p align="left">$rocount</p></td>
</tr>
<tr>
<td width="100" height="20"><p align="left">PRINT ON:</p></td>
<td><p align="left">$printon</p></td>
</tr>
</tbody>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, 'J');
$pdf->SetFont('helvetica','B', 8);
$pdf->Text(10, 0, "(ZONE)");
$pdf->Text(70, 0, "(CYCLE)");
$pdf->SetFont('helvetica','B', 50);
$pdf->Text(0, 0, "GSA-GA");
$pdf->Text(70, 0, "0");
/*$pdf->SetFont('helvetica','B', 20);
$pdf->Text(0, 30, "STAGING LOC:");
$pdf->Text(0, 50, "DOCK:");
$pdf->Text(40, 50, "NORTH WEST DOCK:");
$pdf->Text(0, 70, "RO COUNT:");
$pdf->Text(40, 70, "4");
$pdf->Text(0, 90, "PRINT ON:");
$pdf->Text(40, 90, "7/11/2018 10:50:28 AM");*/
$pdf->SetFont('helvetica','B', 50);
$pdf->Text(0, 120, "G-SP");
$pdf->SetFont('helvetica','B', 8);
$pdf->Text(10, 140, "(ROUTE)");
$pdf->Text(70, 140, "(DOLLY)");
//$pdf->write2DBarcode($smallqr, 'QRCODE,L', 3, 78, 20, 20, $style, 'N');
//$pdf->write2DBarcode($largeqr, 'QRCODE,Q', 64, -1.5, 88, 88, $style2, 'N');



//$pdf->write1DBarcode('4689', 'C39', '30', '265', '250', 30, 1.5, $style, 'N');
						//valor		//tipo    PosX   PosY  Largo ancho  
$pdf->Output('TeslaLabel.pdf', 'I');



//----------------------

?>