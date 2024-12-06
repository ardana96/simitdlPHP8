<?php
include('../config.php'); // Pastikan koneksi menggunakan sqlsrv

if (isset($_POST['tombol'])) {

    // Ambil data dari form
    $nomor = $_POST['nomor'];
    $id_perangkat = $_POST['id_perangkat'];
    $perangkat = $_POST['perangkat'];
    $keterangan = $_POST['keterangan'];
    $divisi = $_POST['divisi'];
    $nama_user = $_POST['nama_user'];
    $lokasi = $_POST['lokasi'];
    $bulan = $_POST['bulan'];
    $tgl_perawatan = $_POST['tgl_perawatan'];
    $tipe = $_POST['tipe'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $pembelian_dari = $_POST['pembelian_dari'];
    $sn = $_POST['sn'];

    // Query dengan parameterized statement
    $query_insert = "INSERT INTO peripheral (nomor, id_perangkat, perangkat, keterangan, divisi, [user], lokasi, bulan, tgl_perawatan, tipe, brand, model, pembelian_dari, sn) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Parameter untuk query
    $params = array($nomor, $id_perangkat, $perangkat, $keterangan, $divisi, $nama_user, $lokasi, $bulan, $tgl_perawatan, $tipe, $brand, $model, $pembelian_dari, $sn);

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
        header("Location: ../user.php?menu=peripheral&stt=$error_message");
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman printer
        header("Location: ../user.php?menu=peripheral&stt=" . urlencode("Simpan Berhasil"));
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
