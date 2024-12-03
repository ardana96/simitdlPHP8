

<?php
include('../config.php'); // Pastikan koneksi menggunakan sqlsrv

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $id_bagian=$_POST['id_bagian'];
    $bagian=$_POST['bagian'];
    $bagianbesar=strtoUpper($bagian);

    // Query dengan parameterized statement
    $query_insert = "INSERT INTO bagian (id_bagian,bagian) 
                     VALUES (?, ?)";
    $params = array($id_bagian, $bagianbesar);

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
        header("Location: ../user.php?menu=bagian&stt=$error_message");
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman printer
        header("Location: ../user.php?menu=bagian&stt=" . urlencode("Simpan Berhasil"));
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
