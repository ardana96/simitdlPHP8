
<?php
include('../config.php');  // Pastikan koneksi menggunakan sqlsrv

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $id_bag_pemakai=$_POST['id_bag_pemakai'];
    $bag_pemakai=$_POST['bag_pemakai'];
      // (tidak digunakan dalam query update, bisa dihapus jika tidak dibutuhkan)

    // Query update dengan parameterized query untuk menghindari SQL injection
    $query_update = "UPDATE bagian_pemakai SET bag_pemakai = ? WHERE id_bag_pemakai = ?";

    // Tentukan parameter yang akan digunakan
    $params = array( $bag_pemakai, $id_bag_pemakai);

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_update, $params);

    // Periksa apakah query berhasil
    if ($stmt === false) {
        // Jika query gagal, tangkap error
        $errors = sqlsrv_errors();
        $error_message = "Gagal mengupdate data. Detail error: " . print_r($errors, true);

        // Redirect ke halaman dengan pesan error
        header("Location: ../user.php?menu=bagian_pemakai&stt=" . urlencode($error_message));
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman divisi dengan pesan sukses
        header("Location: ../user.php?menu=bagian_pemakai&stt=Update Berhasil");
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
