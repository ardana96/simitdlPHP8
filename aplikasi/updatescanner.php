<?php
include('../config.php'); // Pastikan koneksi menggunakan sqlsrv

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $nomor = $_POST['nomor'];
    $id_perangkat = $_POST['id_perangkat'];
    $printer = $_POST['printer'];
    $keterangan = $_POST['keterangan'];
    $status = $_POST['status'];
    $user = $_POST['user'];
    $lokasi = $_POST['lokasi'];
    $tgl_perawatan = $_POST['tgl_perawatan'];
    $bulan = $_POST['bulan'];

    // Query untuk memperbarui data
    $query = "UPDATE scaner SET id_perangkat = ?, 
                         printer = ?, 
                         keterangan = ?, 
                         status = ?, 
                         [user] = ?, 
                         lokasi = ?, 
                         tgl_perawatan = ?, 
                         bulan = ?  WHERE nomor = ?";;
 $params = array($id_perangkat, $printer, $keterangan, $status, $user, $lokasi, $tgl_perawatan, $bulan, $nomor);

    // Eksekusi query menggunakan prepared statement
    $stmt = sqlsrv_query($conn, $query, $params);

    // Periksa hasil eksekusi
    if ($stmt === false) {
        // Jika gagal, tangkap error
        $errors = sqlsrv_errors();
        $error_message = "Gagal: " . print_r($errors, true);
        header("Location: ../user.php?menu=scanner&stt=$error_message");
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman sukses
        header("Location: ../user.php?menu=scanner&stt=Update Berhasil");
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>