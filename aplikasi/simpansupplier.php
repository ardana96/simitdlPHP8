<?php
include('../config.php'); // Pastikan koneksi menggunakan sqlsrv

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $idsupp = $_POST['idsupp'];
    $namasupp = $_POST['namasupp'];
    $alamatsupp = $_POST['alamatsupp'];
    $telpsupp = $_POST['telpsupp'];

    // Query dengan parameterized statement
    $query = "INSERT INTO tsupplier (idsupp, namasupp, alamatsupp, telpsupp) VALUES (?, ?, ?, ?)";
    $params = array($idsupp, $namasupp, $alamatsupp, $telpsupp);

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query, $params);

    // Periksa hasil query
    if ($stmt === false) {
        // Jika gagal, tangkap error dan arahkan dengan pesan gagal
        $errors = sqlsrv_errors();
        $error_message = "Gagal: " . print_r($errors, true);
        header("Location: ../user.php?menu=supplier&stt=$error_message");
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman sukses
        header("Location: ../user.php?menu=supplier&stt=Simpan Berhasil");
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
