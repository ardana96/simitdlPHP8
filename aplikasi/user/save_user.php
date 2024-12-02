<?php
// Konfigurasi koneksi database
// $servername = "localhost";
// $username = "root";
// $password = "dlris30g";
// $dbname = "sitag";

// // Membuat koneksi
// $conn = mysql_connect($servername, $username, $password);
// if (!$conn) {
//     die("Connection failed: " . mysql_error());
// }

// // Memilih database
// mysql_select_db($dbname, $conn);

include('../../config.php');

$conn = $koneksi;
// Ambil data header dari form
$user = $_POST['user'];
$password = $_POST['password'];
$akses = $_POST['akses'];
// Mulai transaksi
mysql_query("START TRANSACTION", $conn);

// Insert data ke tabel headers
$insertHeaderQuery = sprintf(
    "INSERT INTO tuser (user, password, akses) VALUES ('".$user."', '".$password."', '".$akses."')",
    mysql_real_escape_string($nama_perangkat)
);

$result = mysql_query($insertHeaderQuery, $conn);
if (!$result) {
    mysql_query("ROLLBACK", $conn);
    die("Error inserting header: " . mysql_error());
}



if($result){
    header('location:../../user.php?menu=users&stt= Simpan Berhasil');}
else{
    echo "transaksi gagal";
}
// Commit transaksi jika semua insert berhasil
mysql_query("COMMIT", $conn);
echo "Order saved successfully!";



// Tutup koneksi
mysql_close($conn);
?>
