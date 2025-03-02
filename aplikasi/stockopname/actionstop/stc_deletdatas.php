<?php
// Sertakan konfigurasi koneksi database
include('../../../config.php'); // Pastikan path ini benar (actionstop -> stockopname -> simitdlPHP8)

// Validasi koneksi database
if ($conn === false) {
    header('Content-Type: application/json');
    die(json_encode([
        "error" => "Koneksi database gagal",
        "details" => sqlsrv_errors()
    ]));
}

// Ambil data POST dari formulir (id dan nomor PC yang akan dihapus)
if (isset($_POST['id']) && isset($_POST['nomor'])) {
    $id = $_POST['id'];
    $nomor = $_POST['nomor'];

    // Query untuk menghapus data berdasarkan id DAN nomor dari tabel pcaktif
    $sql = "DELETE FROM pcaktif WHERE id = ? AND nomor = ?";
    $params = array($id, $nomor);
    $query = sqlsrv_query($conn, $sql, $params);

    // Periksa apakah query berhasil
    if ($query === false) {
        header('Content-Type: application/json');
        die(json_encode([
            "error" => "Gagal menghapus data",
            "details" => sqlsrv_errors()
        ]));
    }

    // Mulai session untuk mengakses dan menyimpan data halaman
    session_start();
    // Debug isi session
    error_log("Session sebelum penghapusan: " . print_r($_SESSION, true));
    // Ambil currentPage dari session, gunakan 1 jika tidak ada atau invalid
    $currentPage = isset($_SESSION['current_page']) && $_SESSION['current_page'] > 0 ? (int)$_SESSION['current_page'] : 1;
    // Ambil recordsPerPage dari session, gunakan 10 jika tidak ada atau invalid
    $recordsPerPage = isset($_SESSION['records_per_page']) && $_SESSION['records_per_page'] > 0 ? (int)$_SESSION['records_per_page'] : 10;

    // Hitung ulang total data untuk menentukan totalPages
    $countQuery = sqlsrv_query($conn, "SELECT COUNT(*) as total FROM pcaktif");
    if ($countQuery === false) {
        header('Content-Type: application/json');
        die(json_encode([
            "error" => "Gagal menghitung total data",
            "details" => sqlsrv_errors()
        ]));
    }
    $totalData = sqlsrv_fetch_array($countQuery, SQLSRV_FETCH_ASSOC);
    $totalPages = ceil($totalData['total'] / $recordsPerPage);

    // Tentukan halaman yang akan digunakan setelah penghapusan
    if ($totalData['total'] == 0) {
        // Jika tidak ada data lagi, set ke halaman 1
        $currentPage = 1;
    } elseif ($currentPage > $totalPages) {
        // Jika currentPage lebih besar dari totalPages, gunakan totalPages (halaman terakhir yang valid)
        $currentPage = $totalPages > 0 ? $totalPages : 1;
    } else {
        // Tetap gunakan currentPage jika masih valid
        $currentPage = $currentPage;
    }

    // Debug setelah penghapusan
    error_log("Session setelah penghapusan - currentPage: $currentPage, totalPages: $totalPages");

    // Bebaskan resource
    sqlsrv_free_stmt($countQuery);

    // Kirim respons JSON dengan informasi halaman terakhir
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "success",
        "message" => "Data berhasil dihapus",
        "currentPage" => $currentPage,
        "totalPages" => $totalPages
    ]);
} else {
    header('Content-Type: application/json');
    die(json_encode([
        "error" => "ID dan/atau Nomor tidak ditemukan dalam request"
    ]));
}

// Tutup koneksi
sqlsrv_close($conn);
?>