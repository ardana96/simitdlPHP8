<?php
// Konfigurasi koneksi
$server_database = "com-simit-sqlserver-prd.database.windows.net"; // Atau gunakan alamat server Anda
$database_name = "com-simit-db-prd";
$username = "simitlogin"; // Ganti dengan username SQL Server Anda
$password = "simit321."; // Ganti dengan password SQL Server Anda
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
}else{
    echo "Koneksi berhasil";
}
?>

