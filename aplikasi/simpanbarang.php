<?php
include('../config.php');
if (isset($_POST['tombol'])) {
    $idbarang = $_POST['idbarang'];	
    $idkategori = $_POST['idkategori'];
    $namabarang = $_POST['namabarang'];
    $barcode = $_POST['barcode'];
    $inventory = $_POST['inventory'];
    $refil = $_POST['refil'];
    $keterangan = $_POST['keterangan'];
    $nmbesar = strtoupper($namabarang);

    // Query untuk menyisipkan data ke tabel tbarang
    $query_insert = "INSERT INTO tbarang (idbarang, idkategori, namabarang, barcode, inventory, refil, keterangan) 
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
    $params = array($idbarang, $idkategori, $nmbesar, $barcode, $inventory, $refil, $keterangan);

    // Eksekusi query menggunakan prepared statement
    $stmt = sqlsrv_query($conn, $query_insert, $params);

    // Periksa hasil eksekusi
    if ($stmt === false) {
        // Jika gagal, tangkap error
        $errors = sqlsrv_errors();
        $error_message = "Gagal: " . print_r($errors, true);
        header("Location: ../user.php?menu=barang&stt=$error_message");
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman sukses
        header("Location: ../user.php?menu=barang&stt=Simpan Berhasil");
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>