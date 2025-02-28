<?php
require('kop_stock_out_pdf.php');
include('../config.php'); // Koneksi ke SQL Server

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

function generatebulan($tgl)
{
    $bln_angka = substr($tgl, 5, 2);
    $tahun = substr($tgl, 0, 4);

    $bulan_arr = [
        "01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April",
        "05" => "Mei", "06" => "Juni", "07" => "Juli", "08" => "Agustus",
        "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember"
    ];

    return $bulan_arr[$bln_angka] . " " . $tahun;
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->SetWidths(array(10, 30, 25, 35, 45, 20, 25));

// Mendapatkan input dari POST
$bln_akhir = $_POST['bln_akhir'] ?? '';
$thn_akhir = $_POST['thn_akhir'] ?? '';
$tanggal_akhir_format = $thn_akhir . "-" . $bln_akhir;
$kd_barang = $_POST['kd_barang'] ?? '';

// Query ke SQL Server
$query = "SELECT * FROM tpengambilan a
          JOIN trincipengambilan b ON a.nofaktur = b.nofaktur
          WHERE idbarang = ? AND a.tglambil LIKE ?";

$params = [$kd_barang, $tanggal_akhir_format . '%'];
$get_data = sqlsrv_query($conn, $query, $params);

if ($get_data === false) {
    die(print_r(sqlsrv_errors(), true));
}

$no = 1;
while ($database = sqlsrv_fetch_array($get_data, SQLSRV_FETCH_ASSOC)) {
    $user = $database['nama'];
    $divisi = $database['divisi'];
    $bagian = $database['bagian'];
    $namabarang = $database['namabarang'];
    $jumlah = $database['jumlah'];
    $bulan = generatebulan($database['tglambil']->format('Y-m-d'));

    $pdf->Row(array($no++, $user, $bagian, strtoupper($divisi), $namabarang, $jumlah, $bulan));
}

$pdf->Output();
?>
