<?php
// Konfigurasi koneksi MySQL
// $server = "localhost";
// $username = "root";
// $password = "dlris30g";
// $database = "sitag";


// // Membuka koneksi
// $connection = mysql_connect($server, $username, $password);
// mysql_select_db($database, $connection);

include('../../config.php');

$connection = $koneksi;

$id = $_GET['id'];

// Query untuk mendapatkan data perangkat utama
$query = "SELECT * FROM tuser WHERE id_user = '$id'";
$result = mysql_query($query);
$user = mysql_fetch_assoc($result);



// Gabungkan data perangkat dan item dalam satu array
$response = array (
    'user' => $user
   
);

// Ubah array menjadi format JSON dan kirim sebagai respons
echo json_encode($response);

// Tutup koneksi
mysql_close($connection);
?>
