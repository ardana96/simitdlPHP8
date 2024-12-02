<?php
// $server = "localhost";
// $username = "root";
// $password = "dlris30g";
// $database = "sitag";

// // Membuka koneksi
// $connection = mysql_connect($server, $username, $password);
// mysql_select_db($database, $connection);


include('../../config.php');
$connection = $koneksi;

$id_user = $_POST['id_user'];
$user = $_POST['user'];
$password = $_POST['password'];
$akses = $_POST['akses'];


if ($id_user) {
    // Update perangkat jika ID ada
    $query = "UPDATE tuser SET user = '$user', password = '$password', akses = '$akses'  WHERE id_user = '$id_user'";
    mysql_query($query);
} 
// else {
//     // Insert perangkat baru jika ID tidak ada
//     $query = "INSERT INTO perangkat (nama_perangkat) VALUES ('$nama_perangkat')";
//     mysql_query($query);
//     $id_perangkat = mysql_insert_id(); // Dapatkan ID perangkat yang baru ditambahkan
// }



echo 'success';
mysql_close($connection);
?>
