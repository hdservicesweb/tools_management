<?php


$pdf->SetFont('helvetica', 'BU', 14);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Employee Time Card', 0, 'C', 0, 0, '', 10, true);

// $pdf->SetLineStyle( array( 'width' => 2, 'color' => array(1,1,1)));

//table

$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell($pdf->getPageWidth(), 12, '(Date)', 0, 'L', 0, 0, 125, 30-5, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, '(Date)', 0, 'L', 0, 0, 170, 30-5, 12);
//first week
$pdf->MultiCell($pdf->getPageWidth(), 12, 'REGULAR', 0, 'L', 0, 0, 162, 53, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'OVERTIME', 0, 'L', 0, 0, 179, 53, 12);

//second week
$pdf->MultiCell($pdf->getPageWidth(), 12, 'REGULAR', 0, 'L', 0, 0, 162, 59+59, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'OVERTIME', 0, 'L', 0, 0, 179, 59+59, 12);
//third week
$pdf->MultiCell($pdf->getPageWidth(), 12, 'REGULAR', 0, 'L', 0, 0, 162, 183, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'OVERTIME', 0, 'L', 0, 0, 179, 183, 12);

$pdf->SetFont('helvetica', '', 11);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'From:', 0, 'L', 0, 0, 110, 25-5, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'To:', 0, 'L', 0, 0, 160, 25-5, 12);
$pdf->SetLineStyle(array('width' => .4, 'color' => array(255, 255, 255, 0, 'black')));
$pdf->Line(120, 30-5, 160, 30-5);
$pdf->Line(165, 30-5, 205, 30-5);

$pdf->Line(52, 40-5, 130, 40-5);
$pdf->Line(67, 46-5, 130, 46-5);
$pdf->SetFont('helvetica', 'B', 11);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Employee Name:', 0, 'L', 0, 0, 20, 35-5, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Social Security Number:', 0, 'L', 0, 0, 20, 42-5, 12);

// fisrt week
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Total Hours:', 0, 'L', 0, 0, 133,100, 12); 
$pdf->MultiCell($pdf->getPageWidth(), 12, 'OVERTIME', 0, 'L', 0, 0, 133,51-5, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Total Hours', 0, 'L', 0, 0, 165,51-5, 12);

//second week
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Total Hours:', 0, 'L', 0, 0, 133,165, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'OVERTIME', 0, 'L', 0, 0, 133,51+60, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Total Hours', 0, 'L', 0, 0, 165,51+60, 12);

//tercera semana
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Total Hours:', 0, 'L', 0, 0, 133,230, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'OVERTIME', 0, 'L', 0, 0, 133,176, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Total Hours', 0, 'L', 0, 0, 165,176, 12);
$j=52;
for ($i=0; $i < 3; $i++) { 
    
    $pdf->MultiCell($pdf->getPageWidth(), 12, 'Work Day:', 0, 'L', 0, 0, 15, $j, 12);
    $pdf->MultiCell($pdf->getPageWidth(), 12, 'Date:', 0, 'L', 0, 0, 40, $j, 12);
    $pdf->MultiCell($pdf->getPageWidth(), 12, 'IN', 0, 'L', 0, 0, 65, $j, 12);
    $pdf->MultiCell($pdf->getPageWidth(), 12, 'OUT', 0, 'L', 0, 0, 80, $j, 12);
    $pdf->MultiCell($pdf->getPageWidth(), 12, 'IN', 0, 'L', 0, 0, 98, $j, 12);
    $pdf->MultiCell($pdf->getPageWidth(), 12, 'OUT', 0, 'L', 0, 0, 115, $j, 12);
    $pdf->MultiCell($pdf->getPageWidth(), 12, 'IN', 0, 'L', 0, 0, 132, $j, 12);
    $pdf->MultiCell($pdf->getPageWidth(), 12, 'OUT', 0, 'L', 0, 0, 147, $j, 12);

    $j=$j+65;
}




$pdf->SetLineStyle(array('width' => .4, 'color' => array(255, 255, 255, 0, 'black')));
//PRIMERAS LINEAS VERTICALES
$y=45;
for ($x=0;$x<11;$x++){
    $pdf->Line(15, $y, $pdf->getPageWidth() - 21, $y);
    $y= $y + 6;
}

$pdf->Line(15, 45, 15, 105);
$pdf->Line(39, 62-11, 39, 139-40);
$pdf->Line(59, 62-11, 59, 139-40);
$pdf->Line(76, 62-11, 76, 139-40);
$pdf->Line(93, 62-11, 93, 139-40);
$pdf->Line(110, 62-11, 110, 139-40);
$pdf->Line(127, 55-10, 127, 139-40);
$pdf->Line(144, 62-11, 144, 139-40);
$pdf->Line(161, 55-10, 161, 146-41);
$pdf->Line(178, 62-11, 178, 146-41);
$pdf->Line(195, 55-10, 195, 146-41);

//SEGUNDA LINEAS 
$y=110;
for ($x=0;$x<11;$x++){
    $pdf->Line(15, $y, $pdf->getPageWidth() - 21, $y);
    $y= $y + 6;
}
$pdf->Line(15, 55+55, 15, 146+24);
$pdf->Line(39, 62+54, 39, 139+25);
$pdf->Line(59, 62+54, 59, 139+25);
$pdf->Line(76, 62+54, 76, 139+25);
$pdf->Line(93, 62+54, 93, 139+25);
$pdf->Line(110, 62+54, 110, 139+25);
$pdf->Line(127, 55+55, 127, 139+25);
$pdf->Line(144, 62+54, 144, 139+25);
$pdf->Line(161, 55+55, 161, 146+24);
$pdf->Line(178, 62+54, 178, 146+24);
$pdf->Line(195, 55+55, 195, 146+24);


$y=175;
for ($x=0;$x<11;$x++){
    $pdf->Line(15, $y, $pdf->getPageWidth() - 21, $y);
    $y= $y + 6;
}
$pdf->Line(15, 175, 15, 146+89);
$pdf->Line(39, 62+119, 39, 139+90);
$pdf->Line(59, 62+119, 59, 139+90);
$pdf->Line(76, 62+119, 76, 139+90);
$pdf->Line(93, 62+119, 93, 139+90);
$pdf->Line(110, 62+119, 110, 139+90);
$pdf->Line(127, 175, 127, 139+90);
$pdf->Line(144, 62+119, 144, 139+90);
$pdf->Line(161, 175, 161, 146+89);
$pdf->Line(178, 62+119, 178, 146+89);
$pdf->Line(195, 175, 195, 146+89);


$pdf->MultiCell($pdf->getPageWidth(), 12, 'GRAND TOTAL:', 0, 'L', 0, 0, 120,250, 12);
$pdf->SetLineStyle(array('width' => .4, 'color' => array(255, 255, 255, 0, 'black')));
$pdf->Line(110, 245, $pdf->getPageWidth() - 21, 245);
$pdf->Line(110, 245, 110, 258);
$pdf->Line(161, 245, 161, 258);
$pdf->Line(178, 245, 178, 258);
$pdf->Line(195, 245, 195, 258);
$pdf->Line(110, 258, $pdf->getPageWidth() - 21, 258);
?>