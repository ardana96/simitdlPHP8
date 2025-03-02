<?php
// Mulai session
session_start();

// Include konfigurasi database (opsional, tergantung kebutuhan)
include('../../../config.php');

// Fungsi untuk mendapatkan parameter terakhir dari fect_stockopname.php (dari session)
function getLastFectParams() {
    // Ambil dari session yang diperbarui oleh scriptop.php
    $lastPage = isset($_SESSION['last_fect_page']) ? (int)$_SESSION['last_fect_page'] : 1;
    $lastLimit = isset($_SESSION['last_fect_limit']) ? (int)$_SESSION['last_fect_limit'] : 10;
    return [$lastPage, $lastLimit];
}

// Ambil data dari save_page.php (session)
$currentPage = isset($_SESSION['current_page']) && $_SESSION['current_page'] > 0 ? (int)$_SESSION['current_page'] : null;
$recordsPerPage = isset($_SESSION['records_per_page']) && $_SESSION['records_per_page'] > 0 ? (int)$_SESSION['records_per_page'] : null;

// Jika tidak ada data dari save_page.php, gunakan fallback dari fect_stockopname.php
if ($currentPage === null || $recordsPerPage === null) {
    list($currentPage, $recordsPerPage) = getLastFectParams();
    error_log("Menggunakan fallback dari fect_stockopname.php: page = $currentPage, limit = $recordsPerPage");
} else {
    error_log("Menggunakan data dari save_page.php: page = $currentPage, limit = $recordsPerPage");
}

// Simpan ke session sebagai halaman terakhir
$_SESSION['current_page'] = $currentPage;
$_SESSION['records_per_page'] = $recordsPerPage;
error_log("Session disimpan di save_lastpage.php: " . print_r($_SESSION, true));

// Kembalikan respons (untuk debugging)
header('Content-Type: application/json');
echo json_encode([
    "status" => "success",
    "current_page" => $currentPage,
    "records_per_page" => $recordsPerPage
]);
exit;
?>