<?php
include('../../config.php'); // Pastikan config.php menggunakan sqlsrv_connect()

// **Ambil data dari form**
$id_user = $_POST['id_user'] ?? null;
$user = $_POST['user'] ?? null;
$password = $_POST['password'] ?? null;
$akses = $_POST['akses'] ?? null;

// **Pastikan semua data tersedia sebelum update**
if (!$id_user || !$user || !$password || !$akses) {
    die("❌ Semua field harus diisi!");
}

// **Gunakan parameterized query untuk keamanan**
$query = "UPDATE tuser SET [user] = ?, [password] = ?, [akses] = ? WHERE id_user = ?";
$params = [$user, $password, $akses, $id_user];

$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die("❌ Error saat mengupdate data: " . print_r(sqlsrv_errors(), true));
} else {
    echo "✅ success";
}

// **Tutup koneksi**
sqlsrv_close($conn);
?>
