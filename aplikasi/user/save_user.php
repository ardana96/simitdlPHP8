<?php
include('../../config.php'); // Memastikan file konfigurasi koneksi sudah benar

// **Pastikan koneksi SQL Server tersedia**
if (!$conn) {
    die("Koneksi ke database gagal: " . print_r(sqlsrv_errors(), true));
}

// **Ambil data dari form**
$user = $_POST['user'];
$password = $_POST['password'];
$akses = $_POST['akses'];
$file = $_POST['file'] ?? null; // Jika ada input file

// **Mulai transaksi**
sqlsrv_begin_transaction($conn);

try {
    // **Gunakan parameterized query untuk keamanan**
    $insertHeaderQuery = "INSERT INTO tuser ([user], [password], [akses], [file]) VALUES (?, ?, ?, ?)";
    $params = [$user, $password, $akses, $file];

    $stmt = sqlsrv_query($conn, $insertHeaderQuery, $params);

    if ($stmt === false) {
        // Jika query gagal, rollback transaksi
        sqlsrv_rollback($conn);
        die("❌ Transaksi gagal: " . print_r(sqlsrv_errors(), true));
    } else {
        // Jika sukses, commit transaksi
        sqlsrv_commit($conn);
        header('location:../../user.php?menu=users&stt=Simpan Berhasil');
        exit();
    }
} catch (Exception $e) {
    // Jika terjadi error, rollback transaksi
    sqlsrv_rollback($conn);
    die("❌ Error: " . $e->getMessage());
}

// **Tutup koneksi**
sqlsrv_close($conn);
?>
