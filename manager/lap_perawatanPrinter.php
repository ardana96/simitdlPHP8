<?php
ob_start(); // Menangani output buffer untuk menghindari error FPDF
//require_once('fpdf186/fpdf.php');
require('kop_perawatanPrinter.php');
include('../config.php');

// Membuka koneksi ke SQL Server menggunakan konfigurasi di config.php
// $conn = sqlsrv_connect($serverName, $connectionOptions);

// if (!$conn) {
//     die(print_r(sqlsrv_errors(), true));
// }

// Menerima parameter dari GET atau POST dengan default nilai kosong
$bulan = isset($_POST['bulan']) ? $_POST['bulan'] : (isset($_GET['bulan']) ? $_GET['bulan'] : '');
$pdivisi = isset($_POST['pdivisi']) ? $_POST['pdivisi'] : (isset($_GET['pdivisi']) ? $_GET['pdivisi'] : '');
$tahun_rawat = isset($_POST['tahun']) ? $_POST['tahun'] : (isset($_GET['tahun']) ? $_GET['tahun'] : '');

// Fungsi untuk konversi angka bulan ke nama bulan
function generatebulan($tgl)
{
    $bulan_list = [
        "01" => "JANUARI", "02" => "FEBRUARI", "03" => "MARET",
        "04" => "APRIL", "05" => "MEI", "06" => "JUNI",
        "07" => "JULI", "08" => "AGUSTUS", "09" => "SEPTEMBER",
        "10" => "OKTOBER", "11" => "NOVEMBER", "12" => "DESEMBER"
    ];
    return $bulan_list[$tgl] ?? "SEMUA";
}

$bulanGen = generatebulan($bulan);

// Membuat objek PDF dengan FPDF
$pdf = new PDF('L');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(7, 25, 25, 25, 32, 45, 15, 20, 20, 20, 15, 15, 15));
$pdf->Header1($bulanGen);

// Query untuk mengambil data perawatan printer dari database
$sql = "
SELECT 
    a.id_perangkat,
    a.[user] AS [user],
    a.status AS bagian,
    b.tipe_perawatan_id,
    a.tgl_perawatan AS tgl_perawatan,
    a.lokasi,
    a.printer,
    b.tanggal_perawatan,
    (SELECT TOP 1 treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = a.id_perangkat AND tahun = ? ORDER BY id DESC) AS treated_by,
    (SELECT TOP 1 approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = a.id_perangkat AND tahun = ?) AS approve_by,
    MAX(CASE WHEN d.nama_perawatan = 'Kesesuaian Aset' THEN 'true' ELSE '' END) AS item1,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi Fisik Printer' THEN 'true' ELSE '' END) AS item2,
    MAX(CASE WHEN d.nama_perawatan = 'Test Print' THEN 'true' ELSE '' END) AS item3,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi Tinta' THEN 'true' ELSE '' END) AS item4
FROM 
    printer a
LEFT JOIN 
    (SELECT * FROM perawatan WHERE tahun = ?) AS b ON a.id_perangkat = b.idpc
LEFT JOIN  
    tipe_perawatan_item d ON b.tipe_perawatan_item_id = d.id
WHERE 
    (a.bulan LIKE ? OR ? = '') AND 
    (a.status LIKE ? OR ? = '') 
GROUP BY 
    a.id_perangkat, a.[user], a.status, b.tipe_perawatan_id, a.tgl_perawatan, a.lokasi, a.printer, b.tanggal_perawatan
";

$params = array($tahun_rawat, $tahun_rawat, $tahun_rawat, "%$bulan%", $bulan, "%$pdivisi%", $pdivisi);

// Eksekusi Query
$stmt = sqlsrv_query($conn, $sql, $params);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Looping hasil query untuk dimasukkan ke dalam PDF
$no = 1;
while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $tgl_perawatan = $database['tgl_perawatan'] ? $database['tgl_perawatan']->format('Y-m-d') : '';
    $tanggal_realisasi = $database['tanggal_perawatan'] ? $database['tanggal_perawatan']->format('Y-m-d') : '';
    $id_perangkat = $database['id_perangkat'];
    $printer = $database['printer'];
    $user = $database['user'];
    $bagian = strtoupper($database['bagian']);
    $lokasi = $database['lokasi'];
    $treated_by = $database['treated_by'];
    $approve_by = $database['approve_by'];

    // Cek jadwal perawatan selanjutnya (tambah 1 tahun dari terakhir perawatan)
    $tgl_jadwal = ($tgl_perawatan) ? date('Y-m-d', strtotime('+1 year', strtotime($tgl_perawatan))) : '-';

    $data = array(
        array($no++, $lokasi, $tgl_jadwal, $tanggal_realisasi, $id_perangkat, $printer . '/' . $user, 
              $database['item1'], $database['item2'], $database['item3'], $database['item4'], 
              $treated_by, $approve_by, '')
    );

    // Cetak ke PDF
    foreach ($data as $row) {
        $pdf->RowWithCheck($row, 'true'); 
    }
}

// Tutup koneksi database dan output PDF
sqlsrv_close($conn);
ob_end_clean();
$pdf->Output();
?>
