<?php
include('../config.php'); // Pastikan koneksi menggunakan sqlsrv

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $idkategori = $_POST['idkategori'];
    $kategori = $_POST['kategori'];
    $nmkecil = strtolower($kategori);

    // Query dengan parameterized statement
    $query_insert = "INSERT INTO tkategori (idkategori, kategori) VALUES (?, ?)";
    $params = array($idkategori, $nmkecil);

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_insert, $params);

    // Periksa hasil eksekusi query
    if ($stmt === false) {
        // Jika gagal, tangkap error
        $errors = sqlsrv_errors();
        $error_message = "Gagal menyimpan data. Detail error: " . print_r($errors, true);

        // Redirect ke halaman dengan pesan error
        header("Location: ../user.php?menu=barang&stt=$error_message");
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman barang
        header("Location: ../user.php?menu=barang&stt=Simpan Berhasil");
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
