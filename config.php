<?php
// $user_database="root";
// $password_database="";
// $server_database="localhost";
// $nama_database="sitdl";
// $koneksi=mysqli_connect($server_database,$user_database,$password_database);
// if(!$koneksi){
// die("Tidak bisa terhubung ke server".mysqli_error());}
// $pilih_database=mysqli_select_db($nama_database,$koneksi);
// if(!$pilih_database){
// die("Database tidak bisa digunakan".mysqli_error());}



?>

<?php
// Konfigurasi koneksi
$server_database = "com-simit-sqlserver-prd.database.windows.net"; // Atau gunakan alamat server Anda
$database_name = "com-simit-db-prd";
$username = "simitlogin"; // Ganti dengan username SQL Server Anda
$password = "simit321."; // Ganti dengan password SQL Server Anda

// $server_database = "Gama-Laptop"; // Atau gunakan alamat server Anda
// $database_name = "sitdl";
// $username = ""; // Ganti dengan username SQL Server Anda
// $password = ""; 

// Parameter koneksi
$connection_options = array(
    "Database" => $database_name,
    "UID" => $username,
    "PWD" => $password
);

// Membuat koneksi menggunakan sqlsrv
$conn = sqlsrv_connect($server_database, $connection_options);

if ($conn === false) {
    die("Koneksi gagal: " . print_r(sqlsrv_errors(), true));
}
?>

