<?php
require_once('tcpdf_include.php');

$fromdata = "Golden Sate Assembly L.L.C. Golden State Assembly (Westinghouse Dr.) Fremont California 94529. United States ";
$email = "gsa_it@gsassembly.com";
$todata = "Tesla South Dock 45500, Fremont Blvd. Fremont CA 94536";
$licenseplate = "0001099981806270655085514";
$quantity = "32";
$identify = "EA";
$grossweight = "1";
$grossweightidy = "LB";
$partname = "RWK ASY, HRN, MDLX, ALL, REAR DOOR. LOWER RH";
$ponumln = "77000001339 / 1330";
$partnumber = "1010518-00-A";
$shipdate = "6/27/2018";
$smallqr= "[)>+06:6J0001099981807030000000003:P2135153-82-A:Q1:K7700001188:5K1:4K250:3QEA:1T:15D:12D:99Z84312:S:X0+#";
$largeqr="6J0001099981807030000000003:ZA";
$shipdate = "6/27/2018";
$expdate = "6/27/2018";
$serialnum = "00013246";
$lotcode = "100";


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'TESLALABEL', true, 'UTF-8', false);


$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetAuthor('Golden State Assembly');
$pdf->SetTitle('Tesla Label');
$pdf->SetMargins(.5,0,-25,0);
$pdf->AddPage('L', "TESLALABEL");
$pdf->SetFont('helvetica','B', 38);
$pdf->SetTextColor(0,0,0);
$style = array(
    'border' => false,
    'vpadding' => '1',
    'hpadding' => '1',
    'fgcolor' => array(0,0,0),
    'bgcolor' => array(255,255,255),
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);

$tbl = <<<EOD
<table border="1px" bgcolor="#fff" cellspacing="0" >
<tbody>
<tr >
<td width="180" height="54">
<p style="font-size: 8pt;font-weight: bold; font-family: Arial Bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MFG PART NUMBER:
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br><center><font size="20">        $partnumber</font></center></p>
</td>
<td rowspan="6" bgcolor="#fff">&nbsp;</td>
</tr >
<tr>
<td height="36" cellpadding="0">
<table border="1">
<tbody>
<tr>
<td height="36">
<p style="font-size: 6; font-weight: bold; font-family: "Arial Bold";">QUANTITY:<br><font size="20">$quantity &nbsp; $identify</font></p>
</td>
<td height="36">
<p style="font-size: 6; font-weight: bold; font-family: "Arial Bold";">GROSS WEIGHT:<br><font size="20">$grossweight &nbsp; $grossweightidy</font></p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td width="180" height="68.4">
<p style="font-size: 6; font-weight: bold; font-family: Arial Bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PARTNAME: <font size="12"> $partname </font><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="6">CONTENT LABEL ID:<br></font><font size="8"> $ponumln </font></p>
</td>
</tr>
<tr>
<td width="180" height="57.6">
<p style="font-size: 6; font-weight: bold; font-family: "Arial Bold";">SUPPLIER: <font size="12"> 109998 </font><br><br>
<font size="12"> GOLDEN STATE ASSEMBLY, L.L.C.</font></p>
</td>
</tr>
<tr>
<td rowspan="2" height="36">
<table height="36">
<tr>
<td width="90" height="71">
<p style="font-size:6; font-weight: bold; font-family: Arial Bold;">EXP DATE: <font size="8"> $expdate</font></p>
<p style="font-size:6; font-weight: bold; font-family: Arial Bold;">SERIAL NUM: <font size="8"> $serialnum</font></p>
<p style="font-size:6; font-weight: bold; font-family: Arial Bold;">LOT CODE: <font size="8"> $lotcode</font></p>
</td>
<td height="19">
</td>
</tr>
</table>
</td>
</tr>
</tbody>
</table>

EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// /$pdf->write2DBarcode($smallqr, 'QRCODE,L', 3, 78, 20, 20, $style, 'N');
$pdf->write2DBarcode($largeqr, 'QRCODE,L', 64, -1.5, 88, 88, $style, 'N');
$pdf->Text(63, 84, $partnumber);
//$pdf->write1DBarcode('4689', 'C39', '30', '265', '250', 30, 1.5, $style, 'N');
						//valor		//tipo    PosX   PosY  Largo ancho  
$pdf->Output('TeslaLabel.pdf', 'I');



//----------------------

