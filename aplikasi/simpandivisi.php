<?php
include('../config.php');


if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $kodedivisi = $_POST['kd'];
    $namadivisi= $_POST['namadivisi'];
   

    // Query dengan parameterized statement
    $query_insert = "INSERT INTO divisi (kd,namadivisi) 
                     VALUES (?, ?)";
    $params = array($kodedivisi, $namadivisi);

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_insert, $params);

    // Periksa hasil eksekusi query
    if ($stmt === false) {
        // Jika gagal, tangkap error
        $errors = sqlsrv_errors();
        $error_message = "Gagal menyimpan data. Detail error: " . print_r($errors, true);

        // Pastikan error_message aman untuk URL
        $error_message = urlencode($error_message);

        // Redirect ke halaman dengan pesan error
        header("Location: ../user.php?menu=divisi&stt=$error_message");
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman printer
        header("Location: ../user.php?menu=divisi&stt=" . urlencode("Simpan Berhasil"));
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>