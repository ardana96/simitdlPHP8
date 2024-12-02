<?php
include('../config.php'); // Pastikan koneksi menggunakan sqlsrv

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $idbarang = $_POST['idbarang'];
    $idkategori = $_POST['idkategori'];
    $namabarang = $_POST['namabarang'];
    $barcode = $_POST['barcode'];
    $stock = $_POST['stock'];
    $inventory = $_POST['inventory'];
    $refil = $_POST['refil'];
    $stockawal = $_POST['stockawal'];
    $keterangan = $_POST['keterangan'];

    // Query dengan parameterized statement
    $query_update = "UPDATE tbarang 
                     SET stockawal = ?, 
                         keterangan = ?, 
                         inventory = ?, 
                         refil = ?, 
                         idkategori = ?, 
                         stock = ?, 
                         barcode = ?, 
                         namabarang = ? 
                     WHERE idbarang = ?";
    $params = array($stockawal, $keterangan, $inventory, $refil, $idkategori, $stock, $barcode, $namabarang, $idbarang);

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_update, $params);

    // Periksa hasil query
    if ($stmt === false) {
        // Jika gagal, tangkap error
        $errors = sqlsrv_errors();
        $error_message = "Gagal: " . print_r($errors, true);
        header("Location: ../user.php?menu=barang&stt=$error_message");
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman sukses
        header("Location: ../user.php?menu=barang&stt=Update Berhasil");
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
