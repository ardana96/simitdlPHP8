

<?php
include('../config.php');  // Pastikan koneksi menggunakan sqlsrv

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $subbag_id=$_POST['subbag_id'];
    $subbag_nama=$_POST['subbag_nama'];
      // (tidak digunakan dalam query update, bisa dihapus jika tidak dibutuhkan)

    // Query update dengan parameterized query untuk menghindari SQL injection
    $query_update = "UPDATE sub_bagian SET subbag_nama = ? WHERE subbag_id = ?";

    // Tentukan parameter yang akan digunakan
    $params = array( $subbag_nama, $subbag_id);

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_update, $params);

    // Periksa apakah query berhasil
    if ($stmt === false) {
        // Jika query gagal, tangkap error
        $errors = sqlsrv_errors();
        $error_message = "Gagal mengupdate data. Detail error: " . print_r($errors, true);

        // Redirect ke halaman dengan pesan error
        header("Location: ../user.php?menu=subbagian&stt=" . urlencode($error_message));
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman divisi dengan pesan sukses
        header("Location: ../user.php?menu=subbagian&stt=Update Berhasil");
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
