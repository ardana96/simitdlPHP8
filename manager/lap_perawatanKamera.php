<?php
ob_start(); // Mengaktifkan output buffering
require('kop_perawatanKamera.php');
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

$pdf = new PDF('L');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(7, 25, 25, 25, 37, 50, 16, 23, 28, 15, 15, 15));

$status = $_POST['status'] ?? '';
$bulan = $_POST['bulan'] ?? ($_GET['bulan'] ?? '');
$pdivisi = $_POST['pdivisi'] ?? ($_GET['pdivisi'] ?? '');
$tahun_rawat = $_POST['tahun'] ?? ($_GET['tahun'] ?? '');

function generatebulan($tgl)
{
    $bulan_array = [
        "01" => "JANUARI", "02" => "FEBRUARI", "03" => "MARET", "04" => "APRIL",
        "05" => "MEI", "06" => "JUNI", "07" => "JULI", "08" => "AGUSTUS",
        "09" => "SEPTEMBER", "10" => "OKTOBER", "11" => "NOVEMBER", "12" => "DESEMBER"
    ];
    return $bulan_array[$tgl] ?? "SEMUA";
}

$bulanGen = generatebulan($bulan);
$pdf->Header1($bulanGen);

$query = "SELECT 
    a.id_perangkat, a.[user] AS user_name, a.divisi AS bagian, b.tipe_perawatan_id, 
    CONVERT(VARCHAR, a.tgl_perawatan, 23) AS tgl_perawatan, 
    a.lokasi, a.perangkat, CONVERT(VARCHAR, b.tanggal_perawatan, 23) AS tanggal_perawatan, 
    (SELECT treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = a.id_perangkat AND tahun = ?) AS treated_by, 
    (SELECT approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = a.id_perangkat AND tahun = ?) AS approve_by,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi Kamera' THEN 'true' END) AS item1,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi Kejelasan Kamera' THEN 'true' END) AS item2,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi View Kamera Dilihat dari Monitor/Online' THEN 'true' END) AS item3
FROM peripheral a
LEFT JOIN (SELECT * FROM perawatan WHERE YEAR(tanggal_perawatan) = ?) AS b ON a.id_perangkat = b.idpc
LEFT JOIN tipe_perawatan_item d ON b.tipe_perawatan_item_id = d.id
WHERE LOWER(a.tipe) = 'kamera' 
AND (a.bulan LIKE ? OR ? = '')
AND (a.divisi LIKE ? OR ? = '')
GROUP BY a.id_perangkat, a.[user], a.divisi, a.tgl_perawatan, a.lokasi, a.perangkat, b.tipe_perawatan_id, b.tanggal_perawatan";

$params = [$tahun_rawat, $tahun_rawat, $tahun_rawat, "%$bulan%", $bulan, "%$pdivisi%", $pdivisi];
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$no = 1;
while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $tgl_perawatan = is_a($database['tgl_perawatan'], 'DateTime') ? $database['tgl_perawatan']->format('Y-m-d') : $database['tgl_perawatan'];
    $tanggal_perawatan = is_a($database['tanggal_perawatan'], 'DateTime') ? $database['tanggal_perawatan']->format('Y-m-d') : $database['tanggal_perawatan'];
    
    $data = array(
        array(
            $no++, $database['lokasi'], $tgl_perawatan, $tanggal_perawatan,
            $database['id_perangkat'], $database['perangkat'] . ' / ' . $database['user_name'],
            $database['item1'], $database['item2'], $database['item3'],
            $database['treated_by'], $database['approve_by'], ''
        )
    );
    foreach ($data as $row) {
        $pdf->RowWithCheck($row, 'true');
    }
}

ob_end_clean(); // Hapus output buffer sebelum mengeluarkan PDF
$pdf->Output();
?>