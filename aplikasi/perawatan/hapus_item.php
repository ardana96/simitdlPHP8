<?php
// Koneksi ke database
$server = "localhost";
$username = "root";
$password = "dlris30g";
$database = "sitdl";

// Membuka koneksi
$connection = mysql_connect($server, $username, $password);
mysql_select_db($database, $connection);

// Ambil ID item dari permintaan POST
$id_item = $_POST['id_item'];

// Hapus item berdasarkan ID
$query = "DELETE FROM tipe_perawatan_item WHERE id = '$id_item'";
$result = mysql_query($query);

if ($result) {
    echo 'success';
} else {
    echo 'error';
}

// Tutup koneksi
mysql_close($connection);
?>
