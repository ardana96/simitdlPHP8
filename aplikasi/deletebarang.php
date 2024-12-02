<?php
include('../config.php'); // Pastikan koneksi menggunakan sqlsrv

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $idbarang = $_POST['idbarang'];

    // Query dengan parameterized statement
    $query_delete = "DELETE FROM tbarang WHERE idbarang = ?";
    $params = array($idbarang);

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_delete, $params);

    // Periksa hasil eksekusi query
    if ($stmt === false) {
        // Jika gagal, tangkap error
        $errors = sqlsrv_errors();
        $error_message = "Gagal menghapus data. Detail error: " . print_r($errors, true);

        // Redirect ke halaman dengan pesan error
        header("Location: ../user.php?menu=barang&stt=$error_message");
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman barang
        header("Location: ../user.php?menu=barang&stt=Hapus Berhasil");
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
