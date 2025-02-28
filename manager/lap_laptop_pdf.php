<?php
session_start();
require('../config.php');
require('laptop_table.php');

function GenerateWord() {
    $nb = rand(3, 10);
    $w = '';
    for ($i = 1; $i <= $nb; $i++) {
        $w .= chr(rand(ord('a'), ord('z')));
    }
    return $w;
}

function GenerateSentence() {
    $nb = rand(1, 10);
    $s = '';
    for ($i = 1; $i <= $nb; $i++) {
        $s .= GenerateWord() . ' ';
    }
    return trim($s);
}

$pdf = new PDF('L');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->SetWidths(array(10, 22, 20, 20, 25, 28, 20, 27, 25, 10, 13, 17, 10, 20, 8, 8));

$divisi = $_POST['divisi'] ?? '';

$query = "SELECT * FROM pcaktif WHERE model = 'laptop' AND divisi LIKE ?";
$params = array("%$divisi%");
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$no = 1;
while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $bagian = htmlspecialchars($database['bagian']);
    $subbagian = htmlspecialchars($database['subbagian']);
    $user = htmlspecialchars($database['user']);
    $idpc = htmlspecialchars($database['idpc']);
    $namapc = htmlspecialchars($database['namapc']);
    $lokasi = htmlspecialchars($database['lokasi']);
    $prosesor = htmlspecialchars($database['prosesor']);
    $mobo = htmlspecialchars($database['mobo']);
    $ram = htmlspecialchars($database['ram']);
    $harddisk = htmlspecialchars($database['harddisk']);
    $monitor = htmlspecialchars($database['monitor']);
    $os = htmlspecialchars($database['os']);
    $ippc = htmlspecialchars($database['ippc']);
    $jumlah = htmlspecialchars($database['jumlah']);

    $pdf->Row(array(
        $no++, $bagian, $subbagian, $user, $idpc, $namapc, $lokasi,
        $prosesor, $mobo, $ram, $harddisk, $monitor, $os, $ippc, $jumlah, ''
    ));
}

$pdf->Output();
?>
