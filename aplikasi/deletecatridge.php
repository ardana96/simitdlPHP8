

<?php
include('../config.php');  // Pastikan koneksi menggunakan sqlsrv

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $Id=$_POST['Id'];

    // Query delete dengan parameterized query untuk menghindari SQL injection
    $query_delete = "DELETE FROM tvalidasi WHERE Id = ?";

    // Tentukan parameter yang akan digunakan
    $params = array($Id);

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_delete, $params);

    // Periksa apakah query berhasil
    if ($stmt === false) {
        // Jika query gagal, tangkap error
        $errors = sqlsrv_errors();
        $error_message = "Gagal menghapus data. Detail error: " . print_r($errors, true);

        // Redirect ke halaman dengan pesan error
        header("Location: ../user.php?menu=catridge&stt=" . urlencode($error_message));
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman divisi
        header("Location: ../user.php?menu=catridge");
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
