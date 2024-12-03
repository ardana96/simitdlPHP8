


<?php
include('../config.php');  // Pastikan koneksi menggunakan sqlsrv

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $lokasi_id=$_POST['lokasi_id'];
    $lokasi_nama=$_POST['lokasi_nama'];
      // (tidak digunakan dalam query update, bisa dihapus jika tidak dibutuhkan)

    // Query update dengan parameterized query untuk menghindari SQL injection
    $query_update = "UPDATE lokasi SET lokasi_nama = ? WHERE lokasi_id = ?";

    // Tentukan parameter yang akan digunakan
    $params = array( $lokasi_nama, $lokasi_id);

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_update, $params);

    // Periksa apakah query berhasil
    if ($stmt === false) {
        // Jika query gagal, tangkap error
        $errors = sqlsrv_errors();
        $error_message = "Gagal mengupdate data. Detail error: " . print_r($errors, true);

        // Redirect ke halaman dengan pesan error
        header("Location: ../user.php?menu=lokasi&stt=" . urlencode($error_message));
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman divisi dengan pesan sukses
        header("Location: ../user.php?menu=lokasi&stt=Update Berhasil");
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
