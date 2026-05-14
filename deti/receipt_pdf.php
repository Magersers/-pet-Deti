<?php
session_start();

if (!isset($_SESSION['child_user'])) {
    header('Location: index.php');
    exit;
}

$receiptData = $_SESSION['receipt_data'] ?? null;
if (!$receiptData) {
    header('Location: cabinet.php');
    exit;
}

function pdfEscape(string $text): string
{
    return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
}

$docDate = date('d.m.Y H:i');
$receiptNumber = (string)($receiptData['receiptNumber'] ?? 'ESV-' . date('Ymd') . '-0000');
$payer = (string)($receiptData['payer'] ?? 'child');
$period = (string)($receiptData['period'] ?? date('m.Y'));
$amount = (string)($receiptData['amount'] ?? '0,00');
$serviceFee = (string)($receiptData['serviceFee'] ?? '0,00');
$tariff = (string)($receiptData['tariff'] ?? '0,00');
$reading = (string)($receiptData['currentReading'] ?? '0');

$lines = [
    'CHEK OB OPLATE ELEKTROENERGII (RF FORMAT)',
    'Poluchatel: AO EnergoSbyt Detyam',
    'INN 7701234567   KPP 770101001   BIK 044525225',
    'r/s 40702810900000012345 v PAO SBERBANK',
    '-----------------------------------------------',
    'Nomer cheka: ' . $receiptNumber,
    'Data operacii: ' . $docDate,
    'Platelshchik: ' . $payer,
    'Period: ' . $period,
    'Pokazanie schetchika: ' . $reading . ' kWh',
    'Tarif: ' . $tariff . ' RUB/kWh',
    'Servisnyy sbor: ' . $serviceFee . ' RUB',
    'ITOGO OPLACHENO: ' . $amount . ' RUB',
    'Status: OPLATA USPESHNO PROVEDENA',
    'UIN: 18810177260001234567',
    'KBK: 18210606010011000110',
    'OKTMO: 45382000',
    '-----------------------------------------------',
    'Kasir: online gateway ESV',
    'Spasibo za oplatu!'
];

$content = "BT\n/F1 12 Tf\n50 790 Td\n";
foreach ($lines as $index => $line) {
    if ($index > 0) {
        $content .= "0 -22 Td\n";
    }
    $content .= '(' . pdfEscape($line) . ") Tj\n";
}
$content .= "ET";

$len = strlen($content);

$objects = [];
$objects[] = "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
$objects[] = "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
$objects[] = "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>\nendobj\n";
$objects[] = "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
$objects[] = "5 0 obj\n<< /Length {$len} >>\nstream\n{$content}\nendstream\nendobj\n";

$pdf = "%PDF-1.4\n";
$offsets = [0];
foreach ($objects as $object) {
    $offsets[] = strlen($pdf);
    $pdf .= $object;
}

$xrefPos = strlen($pdf);
$pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
$pdf .= "0000000000 65535 f \n";
for ($i = 1; $i <= count($objects); $i++) {
    $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
}

$pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n{$xrefPos}\n%%EOF";

$fileName = 'chek-oplaty-' . date('Ymd-His') . '.pdf';
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Content-Length: ' . strlen($pdf));
echo $pdf;
