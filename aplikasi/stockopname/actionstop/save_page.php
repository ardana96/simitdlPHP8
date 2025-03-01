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
// Debug untuk memastikan session disimpan
error_log("Session disimpan: " . print_r($_SESSION, true));
// Kembalikan respons untuk debugging di JavaScript
header('Content-Type: application/json');
echo json_encode(["status" => "success"]);
?>