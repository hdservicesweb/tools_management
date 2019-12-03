<?php
require_once('tcpdf_include.php');
include ('../../conexion2.php'); 

if (isset($_REQUEST['seq'])) {
    $seqID = $_REQUEST['seq'];
    $query = "SELECT * from Sequence_PartNumbers where id = '$seqID'";
}else{
    $first = $_REQUEST['first'];
    $last = $_REQUEST['last'];
    $family = $_REQUEST['select'];
    $query = "SELECT * from Sequence_PartNumbers where family = '$family' and LineSequence >= '$first' and LineSequence <= '$last' and [State] = '0' order by LineSequence";
    
}

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'SEQUENCE_GSA', true, 'UTF-8', false);
$findseq = sqlsrv_query($conn,$query);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(FALSE, 0);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetAuthor('Golden State Assembly');
$pdf->SetTitle('SEQUENCE_GSA');
$pdf->SetMargins(.5,0,0,0);

$pdf->SetFont('helvetica','B', 38);
$pdf->SetTextColor(0,0,0);
$style = array(
    'border' => false,
    'vpadding' => '0',
    'hpadding' => '0',
    'fgcolor' => array(0,0,0),
    'bgcolor' => array(255,255,255),
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);

while ( $registro = sqlsrv_fetch_array($findseq)) {
    $partnumber = $registro['PartNumber'];
    $lineseq = $registro['LineSequence'];
    $smallqr = $registro['VIN'].":".$registro['PartNumber'].":".$registro['LineSequence'];
    $pdf->AddPage('L', "GSASEQ");
    $tbl = <<<EOD
<table cellspacing="0" cellpadding="0">
<tbody>
<tr cellpadding="0">
<td height="75px" cellpadding="0" ><p align="center" style="font-size: 50pt;">$partnumber</p></td>
</tr>
<tr cellpadding="0">
    <td bgcolor="#000" color="#fff" width="220px" cellpadding="0"><p align="center" style="font-size: 65pt;">$lineseq</p></td>
    <td bgcolor="#fff"></td>
</tr>
</tbody>
</table>

EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->write2DBarcode($smallqr, 'QRCODE,L', 100, 20, 29, 30, $style, 'N');
}







//$pdf->Text(30, 2, $partnumber);
//$pdf->Text(10, 30, $lineseq);
//$pdf->write1DBarcode('4689', 'C39', '30', '265', '250', 30, 1.5, $style, 'N');
						//valor		//tipo    PosX   PosY  Largo ancho  
$pdf->Output('SEQ_'.$lineseq.'.pdf', 'I');



//----------------------

