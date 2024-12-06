<?php
include('../../config.php');

// Periksa apakah tombol telah diklik
if (isset($_POST['tombol'])) {
    $id = $_POST['id'];

    // Koneksi ke database SQL Server menggunakan sqlsrv_query
    // Pastikan koneksi sudah ada di $conn

    // Query untuk menghapus data dari tabel tipe_perawatan
    $query_delete = "DELETE FROM tipe_perawatan WHERE id = ?";
    $params = array($id); // Menggunakan parameter untuk mencegah SQL Injection
    $stmt = sqlsrv_query($conn, $query_delete, $params);

    // Query untuk menghapus data dari tabel tipe_perawatan_item
    $query_delete_item = "DELETE FROM tipe_perawatan_item WHERE tipe_perawatan_id = ?";
    $params_item = array($id);
    $stmt_item = sqlsrv_query($conn, $query_delete_item, $params_item);

    // Cek apakah query DELETE berhasil dieksekusi
    if ($stmt && $stmt_item) {
        // Redirect jika penghapusan berhasil
        header("Location: ../../user.php?menu=perawatan");
    } else {
        // Jika ada kesalahan, tampilkan error
        echo "Error: " . print_r(sqlsrv_errors(), true);
        header("Location: ../../user.php?menu=perawatan");
    }
}

// Tutup koneksi jika diperlukan
sqlsrv_close($conn);
?>
