<?php
include('../config.php'); // Pastikan koneksi menggunakan sqlsrv

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $nomor = $_POST['nomor'];
    $id_perangkat = $_POST['id_perangkat'];
    $printer = $_POST['printer'];
    $keterangan = $_POST['keterangan'];
    $status = $_POST['status'];
    $nama_user = $_POST['nama_user'];
    $lokasi = $_POST['lokasi'];
    $bulan = $_POST['bulan'];
    $tgl_perawatan = $_POST['tgl_perawatan'];

    // Query dengan parameterized statement
    $query_insert = "INSERT INTO printer (nomor, id_perangkat, printer, keterangan, status, [user], lokasi, bulan, tgl_perawatan) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = array($nomor, $id_perangkat, $printer, $keterangan, $status, $nama_user, $lokasi, $bulan, $tgl_perawatan);

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
        header("Location: ../user.php?menu=printer&stt=$error_message");
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman printer
        header("Location: ../user.php?menu=printer&stt=" . urlencode("Simpan Berhasil"));
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
