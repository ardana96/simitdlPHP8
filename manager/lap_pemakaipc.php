<?php
require('kop_pemakaipc.php');
require('../config.php'); // Menggunakan koneksi dari config.php

$pdf = new PDF('L');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 6);
$pdf->SetWidths(array(10,22,20,20,25,28,20,27,25,10,13,17,10,20,8,8));

// Mengambil data dari form
$status = $_POST['status'] ?? '';
$bln_akhir = $_POST['bln_akhir'] ?? '';
$thn_akhir = $_POST['thn_akhir'] ?? '';
$id_divisi = $_POST['id_divisi'] ?? '';

// Format tanggal untuk SQL Server (YYYYMMDD)
$tanggal_akhir = $thn_akhir . str_pad($bln_akhir, 2, '0', STR_PAD_LEFT);
$tanggal_akhir_format = str_pad($bln_akhir, 2, '0', STR_PAD_LEFT) . "-" . $thn_akhir;

$no = 1;

// Query menggunakan SQLSRV dengan prepared statement
$query = "SELECT * FROM pcaktif WHERE divisi LIKE ? AND model = 'CPU' ORDER BY idpc ASC";
$params = ["%$id_divisi%"];

$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Perulangan untuk menampilkan data ke PDF
while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data = [
        $no++,
        $database['bagian'],
        $database['subbagian'],
        $database['user'],
        $database['idpc'],
        $database['namapc'],
        $database['lokasi'],
        $database['prosesor'],
        $database['mobo'],
        $database['ram'],
        $database['harddisk'],
        $database['monitor'],
        $database['os'],
        $database['ippc'],
        $database['jumlah'],
        "-" // Mengganti variabel `$a` yang tidak didefinisikan
    ];

    $pdf->Row($data);
}

$pdf->Output();
?>
