<?php
require_once('tcpdf_include.php');
$pdf = new TCPDF('P', PDF_UNIT, 'LETTER', true, 'UTF-8', false);
if (isset($_REQUEST['customer'])) {
    $customer = strtoupper ($_REQUEST['customer']);
} else {
    $customer = "";
}
if (isset($_REQUEST['c_pn'])) {
    $c_pn = strtoupper ($_REQUEST['c_pn']);
} else {
    $c_pn = "";
}
if (isset($_REQUEST['rev'])) {
    $rev = strtoupper ($_REQUEST['rev']);
} else {
    $rev = "";
}
if ((isset($_REQUEST['PSC_PN'])) && ($_REQUEST['PSC_PN'] != "")) {
    $PSC_PN = strtoupper ($_REQUEST['PSC_PN']);
    $namepdf = strtoupper ($_REQUEST['PSC_PN'] ). ".pdf";
} else {
    $PSC_PN = "";
    $namepdf = "TOOL_REQUEST.pdf";
}

if (isset($_REQUEST['date_psc'])) {
    $date_psc = $_REQUEST['date_psc'];
} else {
    $date_psc = "";
}
if (isset($_REQUEST['prepared'])) {
    $prepared = strtoupper ($_REQUEST['prepared']);
} else {
    $prepared = "";
}

if (isset($_REQUEST['pn_tool'])) {
    $pn_tool = explode(',', $_REQUEST['pn_tool']);
} else {
    $pn_tool = "";
}

if (isset($_REQUEST['tool_tool'])) {
    $tool_tool = explode(',', $_REQUEST['tool_tool']);
} else {
    $tool_tool = "";
}

if (isset($_REQUEST['crip_tool'])) {
    $crip_tool = explode(',', $_REQUEST['crip_tool']);
} else {
    $crip_tool = "";
}

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(false, 0);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetAuthor('Miguel Matus');
$pdf->SetTitle('Certificate');
$pdf->SetMargins(.5, 0, 1, 0);
$pdf->AddPage('P', "");


$pdf->SetLineStyle(array('width' => .8, 'color' => array(255, 255, 255, 0, 'black')));
// $pdf->SetLineStyle( array( 'width' => 2, 'color' => array(1,1,1)));
// marco exterior
$pdf->Line(15, 20, $pdf->getPageWidth() - 15, 20);
$pdf->Line($pdf->getPageWidth() - 15, 20, $pdf->getPageWidth() - 15, 40);
$pdf->Line(15, 40, $pdf->getPageWidth() - 15, 40);
$pdf->Line(15, 20, 15, 40);


// $pdf ->Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
$pdf->Image('../../PSC_tools/tools_imgs/no_image.png', 20, 23, 20, 15, '', '', '', false, 300, '', false, false, 1, false, false, false);
$pdf->SetFont('helvetica', 'B', 16);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'PSC Electronics Tooling Requeriment Form', 0, 'C', 0, 0, '', 27, true);

// $pdf->SetLineStyle( array( 'width' => 2, 'color' => array(1,1,1)));

//table
$pdf->SetLineStyle(array('width' => .4, 'color' => array(255, 255, 255, 0, 'black')));
$pdf->Line(20, 47, $pdf->getPageWidth() - 20, 47);
$pdf->Line(20, 55, $pdf->getPageWidth() - 20, 55);
$pdf->Line(20, 63, $pdf->getPageWidth() - 20, 63);
$pdf->Line($pdf->getPageWidth() - 20, 47, $pdf->getPageWidth() - 20, 71);
$pdf->Line(20, 47, 20, 71);
$pdf->Line(63, 47, 63, 71);
$pdf->Line(115, 47, 115, 71);
$pdf->Line(155, 47, 155, 71);
$pdf->Line(20, 71, $pdf->getPageWidth() - 20, 71);
$pdf->SetFont('helvetica', '', 11);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Customer:', 0, 'L', 0, 0, 20, 49, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Customer Part Number:', 0, 'L', 0, 0, 20, 57, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Prepared by:', 0, 'L', 0, 0, 20, 65, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'PSC Part Number:', 0, 'L', 0, 0, 115, 49, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Revision Level', 0, 'L', 0, 0, 115, 57, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Date:', 0, 'L', 0, 0, 115, 65, 12);
$pdf->SetFont('helvetica', 'B', 11);
$pdf->MultiCell($pdf->getPageWidth(), 12, $customer, 0, 'L', 0, 0, 65, 49, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, $c_pn, 0, 'L', 0, 0, 65, 57, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, $prepared, 0, 'L', 0, 0, 65, 65, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, $PSC_PN, 0, 'L', 0, 0, 158, 49, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, $rev, 0, 'L', 0, 0, 158, 57, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, $date_psc, 0, 'L', 0, 0, 158, 65, 12);

//PARTNUMBER SECTION
$pdf->SetFont('helvetica', 'B', 11);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'PART NUMBERS:', 0, 'L', 0, 0, 18, 78, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'TOOLING NEEDED:', 0, 'L', 0, 0, 90, 78, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'CRIMP HT/PULL:', 0, 'L', 0, 0, 160, 78, 12);

$pdf->SetFont('helvetica', '', 11);


$x = 83;

for ($i = 0; $i < 14; $i++) {
    if (isset($pn_tool[$i])) {
        $pdf->MultiCell($pdf->getPageWidth(), 12, $pn_tool[$i], 0, 'L', 0, 0, 16, $x + 4, 12);
    }
    if (isset($tool_tool[$i])) {
        $pdf->MultiCell($pdf->getPageWidth(), 12, $tool_tool[$i], 0, 'L', 0, 0, 85, $x + 4, 12);
    }
    if (isset($crip_tool[$i])) {
        $pdf->MultiCell($pdf->getPageWidth(), 12, $crip_tool[$i], 0, 'L', 0, 0, 150, $x + 4, 12);
    }

    $pdf->SetLineStyle(array('width' => .4, 'color' => array(255, 255, 255, 0, 'black')));
    $pdf->Line(15, $x, 75, $x);
    $pdf->Line(82, $x, 140, $x);
    $pdf->Line(147, $x, 200, $x);
    $x = $x + 9.5;
}

$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Instructions for use:', 0, 'L', 0, 0, 18, 220, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Fill in all pins, contacts and terminals used an entire job under the 1st column.', 0, 'L', 0, 0, 27, 225, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Fill in hand tool and / or machine and applicator / die needed to perform the operation', 0, 'L', 0, 0, 27, 230, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'under 2nd column.', 0, 'L', 0, 0, 27, 235, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Fill in crimp height or pool test spec for each entry under the 3rd column.  ', 0, 'L', 0, 0, 27, 240, 12);
$pdf->SetLineStyle(array('width' => .4, 'color' => array(255, 255, 255, 0, 'black')));
$pdf->Line(20, 250, $pdf->getPageWidth() - 20, 250);

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Document No: F1003', 0, 'L', 0, 0, 20, 255, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, 'Rev No: A', 0, 'L', 0, 0, 95, 255, 12);
$pdf->MultiCell($pdf->getPageWidth(), 12, '10/5/2011', 0, 'L', 0, 0, 160, 255, 12);

$pdf->Output($namepdf, 'I');
