<?php
include('../../config.php');

// Pastikan koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

if (isset($_POST['tombol'])) {
    $id = $_POST['id'] ?? ''; // Gunakan null coalescing untuk mencegah undefined index

    // Persiapkan dan eksekusi query delete untuk tabel tipe_perawatan
    $query_delete = "DELETE FROM tipe_perawatan WHERE id = ?";
    $params_delete = [$id];
    $stmt_delete = sqlsrv_prepare($conn, $query_delete, $params_delete);

    if ($stmt_delete === false) {
        die("Persiapan query delete tipe_perawatan gagal: " . print_r(sqlsrv_errors(), true));
    }

    $update = sqlsrv_execute($stmt_delete);
    sqlsrv_free_stmt($stmt_delete);

    // Persiapkan dan eksekusi query delete untuk tabel tipe_perawatan_item
    $query_delete_item = "DELETE FROM tipe_perawatan_item WHERE tipe_perawatan_id = ?";
    $params_delete_item = [$id];
    $stmt_delete_item = sqlsrv_prepare($conn, $query_delete_item, $params_delete_item);

    if ($stmt_delete_item === false) {
        die("Persiapan query delete tipe_perawatan_item gagal: " . print_r(sqlsrv_errors(), true));
    }

    $update_item = sqlsrv_execute($stmt_delete_item);
    sqlsrv_free_stmt($stmt_delete_item);

    // Redirect berdasarkan hasil
    if ($update !== false && $update_item !== false) {
        header("location:../../user.php?menu=perawatan");
    } else {
        header("location:../../user.php?menu=perawatan");
    }
}
?>