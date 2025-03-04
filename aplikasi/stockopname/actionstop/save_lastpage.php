<?php
// Mulai session
session_start();

// Include konfigurasi database (opsional, tergantung kebutuhan)
include('../../../config.php');

// Ambil data dari input POST atau gunakan nilai session yang ada
$currentPage = isset($_POST['page']) && $_POST['page'] > 0 ? (int)$_POST['page'] : (isset($_SESSION['current_page']) ? (int)$_SESSION['current_page'] : 1);
$recordsPerPage = isset($_POST['recordsPerPage']) && $_POST['recordsPerPage'] > 0 ? (int)$_POST['recordsPerPage'] : (isset($_SESSION['records_per_page']) ? (int)$_SESSION['records_per_page'] : 10);

// Simpan ke session sebagai halaman terakhir
$_SESSION['current_page'] = $currentPage;
$_SESSION['records_per_page'] = $recordsPerPage;
$_SESSION['last_page'] = $currentPage; // Simpan halaman terakhir saat Update atau Simpan
$_SESSION['last_limit'] = $recordsPerPage; // Simpan limit terakhir saat Update atau Simpan
error_log("Session disimpan di save_lastpage.php: current_page = $currentPage, records_per_page = $recordsPerPage, last_page = " . (isset($_SESSION['last_page']) ? $_SESSION['last_page'] : 'null') . ", last_limit = " . (isset($_SESSION['last_limit']) ? $_SESSION['last_limit'] : 'null'));

// Kembalikan respons untuk debugging
header('Content-Type: application/json');
echo json_encode([
    "status" => "success",
    "current_page" => $currentPage,
    "records_per_page" => $recordsPerPage,
    "last_page" => isset($_SESSION['last_page']) ? $_SESSION['last_page'] : 1,
    "last_limit" => isset($_SESSION['last_limit']) ? $_SESSION['last_limit'] : 10
]);
exit;
?>