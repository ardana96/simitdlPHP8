<?php
session_start();
include('../../../config.php');

// Ambil data dari input POST
$currentPage = isset($_POST['page']) && $_POST['page'] > 0 ? (int)$_POST['page'] : (isset($_SESSION['current_page']) ? (int)$_SESSION['current_page'] : 1);
$recordsPerPage = isset($_POST['recordsPerPage']) && $_POST['recordsPerPage'] > 0 ? (int)$_POST['recordsPerPage'] : (isset($_SESSION['records_per_page']) ? (int)$_SESSION['records_per_page'] : 10);

// Perbarui session dengan nilai terakhir
$_SESSION['current_page'] = $currentPage;
$_SESSION['records_per_page'] = $recordsPerPage;
$_SESSION['last_page'] = $currentPage; // Pastikan last_page diperbarui
$_SESSION['last_limit'] = $recordsPerPage; // Pastikan last_limit diperbarui
error_log("Session disimpan di save_lastpage.php: current_page = $currentPage, records_per_page = $recordsPerPage, last_page = " . (isset($_SESSION['last_page']) ? $_SESSION['last_page'] : 'null') . ", last_limit = " . (isset($_SESSION['last_limit']) ? $_SESSION['last_limit'] : 'null'));

header('Content-Type: application/json');
echo json_encode([
    "status" => "success",
    "current_page" => $_SESSION['current_page'],
    "records_per_page" => $_SESSION['records_per_page'],
    "last_page" => $_SESSION['last_page'],
    "last_limit" => $_SESSION['last_limit']
]);
exit;
?>