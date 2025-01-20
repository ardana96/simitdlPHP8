<?php
include('../../config.php'); // Pastikan config.php menggunakan sqlsrv_connect()

// **Pastikan koneksi tersedia**
if (!$conn) {
    die("Koneksi ke database gagal: " . print_r(sqlsrv_errors(), true));
}

// **Ambil ID user dari request GET**
$id = $_GET['id'] ?? null;

if (!$id) {
    die(json_encode(["error" => "❌ ID user tidak ditemukan!"]));
}

// **Gunakan parameterized query untuk keamanan**
$query = "SELECT * FROM tuser WHERE id_user = ?";
$params = [$id];

$result = sqlsrv_query($conn, $query, $params);

if ($result === false) {
    die(json_encode(["error" => "❌ Error dalam query: " . print_r(sqlsrv_errors(), true)]));
}

// **Ambil data user**
$user = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

if (!$user) {
    die(json_encode(["error" => "❌ Data user tidak ditemukan!"]));
}

// **Kembalikan data dalam format JSON**
$response = [
    'user' => $user
];

header('Content-Type: application/json');
echo json_encode($response);

// **Tutup koneksi**
sqlsrv_close($conn);
?>

#region old code
<?php
// Konfigurasi koneksi MySQL
// $server = "localhost";
// $username = "root";
// $password = "dlris30g";
// $database = "sitag";

// // Membuka koneksi
// $connection = mysql_connect($server, $username, $password);
// mysql_select_db($database, $connection);

//include('../../config.php');

// $connection = $koneksi;

//$id = $_GET['id'];

// Query untuk mendapatkan data perangkat utama
// $query = "SELECT * FROM tuser WHERE id_user = '$id'";
// $result = mysql_query($query);
// $user = mysql_fetch_assoc($result);

// Gabungkan data perangkat dan item dalam satu array
// $response = array (
//     'user' => $user
// );

// Ubah array menjadi format JSON dan kirim sebagai respons
// echo json_encode($response);

// Tutup koneksi
// mysql_close($connection);
?>
#endregion
