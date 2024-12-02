<?php
// Konfigurasi koneksi MySQL
$server = "localhost";
$username = "root";
$password = "dlris30g";
$database = "sitdl";

// Membuka koneksi
$connection = mysql_connect($server, $username, $password);
mysql_select_db($database, $connection);

$id = $_GET['id'];

// Query untuk mendapatkan data perangkat utama
$query = "SELECT * FROM tipe_perawatan WHERE id = '$id'";
$result = mysql_query($query);
$perangkat = mysql_fetch_assoc($result);

// Query untuk mendapatkan data item terkait perangkat
$queryItems = "SELECT * FROM tipe_perawatan_item WHERE tipe_perawatan_id = '$id'";
$resultItems = mysql_query($queryItems);

$items = array(); // Menggunakan array() sebagai pengganti []
while ($item = mysql_fetch_assoc($resultItems)) {
    $items[] = $item;
}

// Gabungkan data perangkat dan item dalam satu array
$response = array (
    'perangkat' => $perangkat,
    'items' => $items
);

// Ubah array menjadi format JSON dan kirim sebagai respons
echo json_encode($response);

// Tutup koneksi
mysql_close($connection);
?>
