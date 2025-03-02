<?php
// Mulai session untuk menyimpan data
session_start();

// Simpan currentPage jika ada di POST
if (isset($_POST['page'])) {
    $_SESSION['current_page'] = (int)$_POST['page'];
}
// Simpan recordsPerPage jika ada di POST
if (isset($_POST['recordsPerPage'])) {
    $_SESSION['records_per_page'] = (int)$_POST['recordsPerPage'];
}
// Simpan last_fect_page dan last_fect_limit jika ada
if (isset($_POST['last_fect_page'])) {
    $_SESSION['last_fect_page'] = (int)$_POST['last_fect_page'];
}
if (isset($_POST['last_fect_limit'])) {
    $_SESSION['last_fect_limit'] = (int)$_POST['last_fect_limit'];
}

// Debug untuk memastikan session disimpan
error_log("Session disimpan: " . print_r($_SESSION, true));

// Kembalikan respons untuk debugging di JavaScript
header('Content-Type: application/json');
echo json_encode([
    "status" => "success",
    "current_page" => isset($_SESSION['current_page']) ? $_SESSION['current_page'] : 1,
    "records_per_page" => isset($_SESSION['records_per_page']) ? $_SESSION['records_per_page'] : 10,
    "last_fect_page" => isset($_SESSION['last_fect_page']) ? $_SESSION['last_fect_page'] : 1,
    "last_fect_limit" => isset($_SESSION['last_fect_limit']) ? $_SESSION['last_fect_limit'] : 10
]);
?>