<?php
// Konfigurasi koneksi SQL Server
$server_database = "com-simit-sqlserver-prd.database.windows.net";
$database_name = "com-simit-db-prd";
$username = "simitlogin";
$password = "simit321.";

// Parameter koneksi
$connection_options = array(
    "Database" => $database_name,
    "UID" => $username,
    "PWD" => $password,
    "CharacterSet" => "UTF-8"
);

// Membuat koneksi menggunakan sqlsrv
$conn = sqlsrv_connect($server_database, $connection_options);

// Validasi koneksi
if ($conn === false) {
    die(json_encode(array("error" => "Koneksi database gagal: " . print_r(sqlsrv_errors(), true))));
}

// Jangan tampilkan output apapun di sini untuk menghindari masalah header.
?>
