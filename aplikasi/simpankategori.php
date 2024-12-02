<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $idkategori = $_POST['idkategori'];
    $kategori = $_POST['kategori'];
    $nmkecil = strtolower($kategori);

    // Query untuk menyisipkan data
    $query = "INSERT INTO tkategori (idkategori, kategori) VALUES (?, ?)";
    $params = array($idkategori, $nmkecil);

    // Eksekusi query menggunakan prepared statement
    $stmt = sqlsrv_query($conn, $query, $params);

    // Periksa hasil eksekusi
    if ($stmt === false) {
        // Jika gagal, tangkap error
        $errors = sqlsrv_errors();
        $error_message = "Gagal: " . print_r($errors, true);
        header("Location: ../user.php?menu=kategori&stt=$error_message");
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman sukses
        header("Location: ../user.php?menu=kategori&stt=Simpan Berhasil");
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>