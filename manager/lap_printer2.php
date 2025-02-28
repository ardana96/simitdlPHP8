<?php
require('kop_printer.php');
require('../config.php'); // Menggunakan koneksi dari config.php

function GenerateWord()
{
    $nb = rand(3, 10);
    $w = '';
    for ($i = 1; $i <= $nb; $i++) {
        $w .= chr(rand(ord('a'), ord('z')));
    }
    return $w;
}

function GenerateSentence()
{
    $nb = rand(1, 10);
    $s = '';
    for ($i = 1; $i <= $nb; $i++) {
        $s .= GenerateWord() . ' ';
    }
    return substr($s, 0, -1);
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->SetWidths(array(15, 55, 55, 55, 55));

$status = $_POST['status'] ?? '';

// **Periksa apakah koneksi `$conn` valid**
if (!$conn) {
    die("Koneksi database tidak valid. Periksa konfigurasi di config.php. " . print_r(sqlsrv_errors(), true));
}

// **Mengambil data dari tabel printer**
$sql = "SELECT id_perangkat, printer, keterangan FROM printer WHERE status = ? ORDER BY id_perangkat";
$params = array($status);
$stmt = sqlsrv_prepare($conn, $sql, $params);

if (!$stmt) {
    die("Kesalahan dalam query printer: " . print_r(sqlsrv_errors(), true));
}

if (!sqlsrv_execute($stmt)) {
    die("Kesalahan eksekusi printer: " . print_r(sqlsrv_errors(), true));
}

$no = 1;
while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $pdf->Row(array($no++, $database['id_perangkat'], $database['printer'], $database['keterangan']));
}

// **Mengambil data dari tabel scanner**
$sql2 = "SELECT id_perangkat, printer, keterangan FROM scaner WHERE status = ? ORDER BY id_perangkat";
$params2 = array($status);
$stmt2 = sqlsrv_prepare($conn, $sql2, $params2);

if (!$stmt2) {
    die("Kesalahan dalam query scanner: " . print_r(sqlsrv_errors(), true));
}

if (!sqlsrv_execute($stmt2)) {
    die("Kesalahan eksekusi scanner: " . print_r(sqlsrv_errors(), true));
}

$no2 = 1;
while ($database2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
    $pdf->Row(array($no2++, $database2['id_perangkat'], $database2['printer'], $database2['keterangan']));
}

$pdf->Output();
?>
