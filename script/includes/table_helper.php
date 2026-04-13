<?php
function writeVerticalTable(TCPDF $pdf, string $htmlTable, float $headerHeight = 25)
{

preg_match_all('/<th([^>]*)>(.*?)<\/th>/is', $htmlTable, $matches, PREG_SET_ORDER);
$headers = [];
$colWidths = [];

foreach ($matches as $th) {
$attr = $th[1];
$content = trim(strip_tags($th[2]));
$headers[] = $content;

if (preg_match('/width=["\']?([\d\.]+)(mm|cm|px|%)?["\']?/i', $attr, $wMatch)) {
$value = floatval($wMatch[1]);
$unit = strtolower($wMatch[2] ?? '');
switch ($unit) {
case 'cm': $colWidths[] = $value * 10; break;
case 'px': $colWidths[] = $value * 0.264583; break;
case '%':  $colWidths[] = $value . '%'; break;
default:   $colWidths[] = $value; // mm
}
} else {
$colWidths[] = null;
}
}

preg_match('/<\/tr>(.*)<\/table>/is', $htmlTable, $bodyMatch);
$bodyHTML = isset($bodyMatch[1]) ? '<table border="1" cellpadding="3">' . $bodyMatch[1] . '</table>' : '';

$colCount = count($headers);
$pageWidth = $pdf->getPageWidth() - $pdf->getMargins()['left'] - $pdf->getMargins()['right'];

$fixedWidthSum = 0;
$percentTotal = 0;
foreach ($colWidths as $w) {
if (is_string($w) && str_ends_with($w, '%')) {
$percentTotal += floatval(str_replace('%', '', $w));
} elseif (is_numeric($w)) {
$fixedWidthSum += $w;
}
}

$remainingWidth = max(0, $pageWidth - $fixedWidthSum);
$perPercent = $percentTotal > 0 ? $remainingWidth / $percentTotal : 0;

foreach ($colWidths as $i => $w) {
if (is_string($w) && str_ends_with($w, '%')) {
$colWidths[$i] = floatval(str_replace('%', '', $w)) * $perPercent;
} elseif (!is_numeric($w)) {
$colWidths[$i] = $pageWidth / $colCount;
}
}

$startX = $pdf->GetX();
$startY = $pdf->GetY();
$x = $startX;
$y = $startY;

$pdf->SetFont('helvetica', 'B', 8);

foreach ($headers as $i => $h) {
$w = (float)$colWidths[$i];

$pdf->SetFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetLineStyle(['width' => 0.4, 'color' => [255, 255, 255]]);

$pdf->Rect($x, $y, $w, $headerHeight, 'DF');

$cx = $x + ($w / 2);
$cy = $y + ($headerHeight / 2);

$pdf->StartTransform();
$pdf->Rotate(90, $cx, $cy);
$pdf->MultiCell(
$headerHeight, $w, $h, 0, 'C', 0, 1,
$cx - ($headerHeight / 2),
$cy - ($w / 2),
true, 0, false, true, $headerHeight, 'M'
);
$pdf->StopTransform();

$x += $w;
}

$pdf->SetTextColor(0, 0, 0);

$pdf->SetXY($startX, $startY + $headerHeight);
$pdf->writeHTML($bodyHTML, true, false, false, false, '');
}
