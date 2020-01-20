<?php
require_once('tcpdf_include.php'); 

$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetAuthor('Author');
$pdf->SetTitle('Certificate');
$pdf->SetMargins(.5,0,-25,0);
$pdf->AddPage('L', "");
$pdf->SetFont('helvetica','B', 30);

$pdf->SetLineStyle( array( 'width' => .5, 'color' => array(100, 100,0, 0,'Blue')));
// $pdf->SetLineStyle( array( 'width' => 2, 'color' => array(1,1,1)));
// marco exterior
$pdf->Line(0,10,$pdf->getPageWidth(),10); 
$pdf->Line($pdf->getPageWidth()-10,0,$pdf->getPageWidth()-10,$pdf->getPageHeight());
$pdf->Line(0,$pdf->getPageHeight()-10,$pdf->getPageWidth(),$pdf->getPageHeight()-10);
$pdf->Line(10,0,10,$pdf->getPageHeight());
$pdf->SetLineStyle( array( 'width' => .5, 'color' => array(100, 0, 0, 0, 'Cyan')));
// marco interior
$pdf->Line(12,12,$pdf->getPageWidth()-12,12); 
$pdf->Line($pdf->getPageWidth()-12,12,$pdf->getPageWidth()-12,$pdf->getPageHeight()-12);
$pdf->Line(12,$pdf->getPageHeight()-12,$pdf->getPageWidth()-12,$pdf->getPageHeight()-12);
$pdf->Line(12,12,12,$pdf->getPageHeight()-12);

// $pdf ->Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
$pdf->Image('../../PSC_tools/tools_imgs/no_image.png', 20, 13, 20, 20, '', '', '', false, 300, '', false, false, 1, false, false, false);

$pdf->MultiCell($pdf->getPageWidth(), 12,'Tool Certification of Calibration', 0, 'C', 0, 0, '', 20, true);


$pdf->Output('certificate.pdf', 'I');
?>