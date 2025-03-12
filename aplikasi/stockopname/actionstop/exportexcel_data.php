<?php
// Mulai session jika diperlukan
session_start();

// Include konfigurasi koneksi
include('../../../config.php');

if ($conn === false) {
    die(json_encode(array('status' => 'error', 'message' => 'Koneksi database gagal: ' . print_r(sqlsrv_errors(), true))));
}

// Include library PhpSpreadsheet
$autoloadPath = __DIR__ . '/../../../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    die(json_encode(array('status' => 'error', 'message' => 'File vendor/autoload.php tidak ditemukan. Pastikan Composer dan PhpSpreadsheet terinstall.')));
}
require_once $autoloadPath;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Ambil data filter dari AJAX
$divisi = isset($_POST['divisi']) ? $_POST['divisi'] : '';
$bagian = isset($_POST['bagian']) ? $_POST['bagian'] : '';
$subBagian = isset($_POST['subBagian']) ? $_POST['subBagian'] : '';
$lokasi = isset($_POST['lokasi']) ? $_POST['lokasi'] : '';
$bulan = isset($_POST['bulan']) ? $_POST['bulan'] : '';
$pcLaptop = isset($_POST['pcLaptop']) ? $_POST['pcLaptop'] : '';

// Buat query SQL berdasarkan filter (ganti 'motherboard' dengan 'mobo')
$query = "SELECT ippc, idpc, user, namapc, divisi, subbagian, lokasi, prosesor, mobo, ram, harddisk, monitor, bulan, tgl_perawatan FROM [dbo].[pcaktif] WHERE 1=1";
$params = array();

if (!empty($divisi)) {
    $query .= " AND divisi = ?";
    $params[] = $divisi;
}
if (!empty($bagian)) {
    $query .= " AND bagian = ?";
    $params[] = $bagian;
}
if (!empty($subBagian)) {
    $query .= " AND subbagian = ?";
    $params[] = $subBagian;
}
if (!empty($lokasi)) {
    $query .= " AND lokasi = ?";
    $params[] = $lokasi;
}
if (!empty($bulan)) {
    $query .= " AND bulan = ?";
    $params[] = $bulan;
}
if (!empty($pcLaptop)) {
    $query .= " AND model = ?";
    $params[] = $pcLaptop;
}

// Eksekusi query
$stmt = sqlsrv_query($conn, $query, $params);
if ($stmt === false) {
    die(json_encode(array('status' => 'error', 'message' => 'Query gagal: ' . print_r(sqlsrv_errors(), true))));
}

// Ambil semua data
$data = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

// Tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

// Jika tidak ada data, kembalikan error
if (empty($data)) {
    echo json_encode(array('status' => 'error', 'message' => 'Tidak ada data untuk diekspor.'));
    exit;
}

// Simpan data ke variabel untuk dikirim ke template
$templateData = $data;

// Panggil template untuk membangun file Excel
ob_start();
include 'template_excel.php';
$html = ob_get_clean();

// Buat spreadsheet dari HTML
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->fromHtml($html, null, \PhpOffice\PhpSpreadsheet\Reader\Html::LOAD_WITH_CHART);

// Atur auto-size kolom (kembali ke 14 kolom karena 'mobo' ditambahkan kembali)
foreach (range('A', 'N') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

// Buat nama file unik untuk Excel
$timestamp = date('Ymd_His');
$excelFileName = "daftar_pemakai_komputer_{$timestamp}.xlsx";
$excelFilePath = __DIR__ . "/excel_output/{$excelFileName}";

// Pastikan folder excel_output ada dan memiliki izin tulis
if (!is_dir(__DIR__ . '/excel_output')) {
    mkdir(__DIR__ . '/excel_output', 0777, true);
}

// Simpan file Excel
$writer = new Xlsx($spreadsheet);
$writer->save($excelFilePath);

// Buat URL untuk file Excel
$excelUrl = "http://10.110.30.219/simitdlPHP8/aplikasi/stockopname/actionstop/excel_output/{$excelFileName}";

// Kembalikan respons JSON dengan URL file Excel
echo json_encode(array(
    'status' => 'success',
    'excelUrl' => $excelUrl,
    'message' => 'Excel berhasil diekspor.'
));
exit;
?>