<?php
require_once('tcpdf_include.php');
include('../../conection.php');
$link = Conectarse();
$pdf = new TCPDF('L', PDF_UNIT, 'LETTER', true, 'UTF-8', false);

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(false, 0);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetAuthor('CERTIFICATE');
$pdf->SetTitle('Certificate');
$pdf->SetMargins(.5, 0, 1, 0);
$pdf->AddPage('L', "");




$pdf->Image('images/background.png', 0, 0, 280, 216, '', '', '', false, 300, '', false, false, 0);

$pdf->Output('output.pdf', 'I');
