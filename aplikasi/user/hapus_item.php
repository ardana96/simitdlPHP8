<?php
include('../../config.php'); // Pastikan config.php menggunakan sqlsrv_connect()

// **Pastikan koneksi tersedia**
if (!$conn) {
    die("Koneksi ke database gagal: " . print_r(sqlsrv_errors(), true));
}

// **Ambil ID item dari permintaan POST**
$id_item = $_POST['id_item'] ?? null;

if (!$id_item) {
    die("❌ ID item tidak ditemukan!");
}

// **Gunakan parameterized query untuk keamanan**
$query = "DELETE FROM tipe_perawatan_item WHERE id = ?";
$params = [$id_item];

$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die("❌ Error saat menghapus item: " . print_r(sqlsrv_errors(), true));
} else {
    echo "✅ success";
}

// **Tutup koneksi**
sqlsrv_close($conn);
?>

#region old code
<!-- <?php
// Koneksi ke database
// $server = "localhost";
// $username = "root";
// $password = "dlris30g";
// $database = "sitag";

// // Membuka koneksi
// $connection = mysql_connect($server, $username, $password);
// mysql_select_db($database, $connection);

// include('../../config.php');

// $connection = $koneksi;

// Ambil ID item dari permintaan POST
// $id_item = $_POST['id_item'];

// Hapus item berdasarkan ID
// $query = "DELETE FROM tipe_perawatan_item WHERE id = '$id_item'";
// $result = mysql_query($query);

// if ($result) {
//     echo 'success';
// } else {
//     echo 'error';
// }

// Tutup koneksi
// mysql_close($connection);
?> -->
#endregion
