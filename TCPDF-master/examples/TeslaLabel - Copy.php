<?php
require_once('tcpdf_include.php');
include ('../../conexion2.php'); 

$fromdata = "Golden Sate Assembly L.L.C. Golden State Assembly (Westinghouse Dr.) Fremont California 94529. United States";
$todata = "Tesla South Dock 45500, Fremont Blvd. Fremont CA 94536";
$licenseplate = "0001099981806270655085514";
$quantity = "32";
$identify = "EA";
$grossweight = "1";
$grossweightidy = "LB";
$partname = "RWK ASY, HRN, MDLX, ALL, REAR DOOR. LOWER RH";
$ponumln = "77000001339 / 1330";
$shipdate = "6/27/2018";

$width = 576;
$height = 384;
$pageLayout = array($width, $height); //  or array($height, $width) 




$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Golden State Assembly');
$pdf->SetTitle('Tesla Label');
$pdf->SetMargins(0, 0, 0);



//$employee_number = '553';
//$employee_name = 'Omar Martinez';
$pdf->AddPage('L', $pageLayout);
$pdf->SetFont('helvetica', '0', 38);

$tbl = <<<EOD
<font color="#ffffff">
<table border="4pt" cellpadding="0" cellspacing="0" padding="0px" bgcolor="#ffffff" style="border-collapse: collapse;">
 <tr style="background-color:#000000" >
  <td>1-1</td>
  <td rowspan="6">
  	<table >
  		<tr>
  			<td>
			<img src="../../ShippingQR/QR.PNG" alt="" width="380" height="450" border="0" />
			</td>
  		</tr>
  		<tr>
  			<td border="0" cellpadding="0" cellspacing="0">1135153-00-G</td>
  		</tr>
  	</table>
  	
  </td>
 </tr>
 <tr style="border:#ff00ff;">
  <td>1-1</td>
  
 </tr>
 <tr>
  <td>2-1</td>
  
 </tr>
 <tr>
  <td>
  	<table border="1" cellpadding="0" cellspacing="0">
		 <tr>
		  <td>3-1</td>
		  <td>3-2</td>
		 </tr>
	</table>
  </td>
  
 </tr>
  <tr>
  <td>3-1</td>
  
 </tr>
  <tr>
  <td rowspan="2">  	
	<img src="../../ShippingQR/QR.PNG" alt="" width="380" height="450" border="0" />
  </td>
 </tr>
</table>
</font>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

/*$pdf->writeHTML($html, true, 20, true, 20);*/
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//$pdf->write1DBarcode('4689', 'C39', '30', '265', '250', 30, 1.5, $style, 'N');
						//valor		//tipo    PosX   PosY  Largo ancho  
$pdf->Output('TeslaLabel.pdf', 'I');



//----------------------

