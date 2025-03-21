<?php
// Sertakan file konfigurasi database (misalnya config.php)
include(dirname(dirname(dirname(__FILE__))) . '/config.php');

// Pastikan koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

// Ambil dan validasi parameter GET
if (!isset($_GET['perangkat_id']) || empty(trim($_GET['perangkat_id'])) || !is_numeric($_GET['perangkat_id'])) {
    echo "<p>ID perangkat tidak valid.</p>";
    exit;
}
$perangkat_id = (int)$_GET['perangkat_id'];

$idpc = isset($_GET['idpc']) ? trim($_GET['idpc']) : ''; // String kosong sebagai default

if (!isset($_GET['tahun']) || !is_numeric(trim($_GET['tahun']))) {
    echo "<p>Tahun tidak valid.</p>";
    exit;
}
$tahun = trim($_GET['tahun']); // Biarkan sebagai string karena VARCHAR

// Default bulan ke '01' jika tidak valid, khususnya untuk 24/25
//$bulan = trim($_GET['bulan']);
$bulan = isset($_GET['bulan']) ? trim($_GET['bulan']) : ''; 

// Log untuk debugging
error_log("Parameters: perangkat_id=$perangkat_id, idpc=$idpc, tahun=$tahun, bulan=$bulan");
echo "Parameters: perangkat_id=$perangkat_id, idpc=$idpc, tahun=$tahun, bulan=$bulan";


// Tentukan query berdasarkan perangkat_id
if ($perangkat_id == 24 || $perangkat_id == 25) {
    $query = "SELECT id, nama_perawatan, 
              (SELECT COUNT(*) FROM perawatan 
               WHERE perawatan.idpc = ? 
               AND tahun = ? 
               AND bulan = ? 
               AND perawatan.tipe_perawatan_item_id = tipe_perawatan_item.id 
               AND perawatan.tipe_perawatan_id = ?) AS hitung 
              FROM tipe_perawatan_item 
              WHERE tipe_perawatan_id = ?";
    $params = array(
        array($idpc, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_STRING(SQLSRV_ENC_CHAR)),
        array($tahun, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_STRING(SQLSRV_ENC_CHAR)),
        array($bulan, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_STRING(SQLSRV_ENC_CHAR)),
        array($perangkat_id, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_INT),
        array($perangkat_id, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_INT)
    );
} else {
    $query = "SELECT id, nama_perawatan, 
              (SELECT COUNT(*) FROM perawatan 
               WHERE perawatan.idpc = ? 
               --AND YEAR(tanggal_perawatan) = ? 
               AND tahun = ?
               AND perawatan.tipe_perawatan_item_id = tipe_perawatan_item.id 
               AND perawatan.tipe_perawatan_id = ?) AS hitung 
              FROM tipe_perawatan_item 
              WHERE tipe_perawatan_id = ?";
    $params = array(
        array($idpc, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_STRING(SQLSRV_ENC_CHAR)),
        array((int)$tahun, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_INT), // Konversi ke int untuk YEAR()
        array($perangkat_id, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_INT),
        array($perangkat_id, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_INT)
    );
}

// Persiapkan dan eksekusi query
$stmt = sqlsrv_prepare($conn, $query, $params);
if ($stmt === false) {
    die("Persiapan query gagal: " . print_r(sqlsrv_errors(), true));
}

// Log sebelum eksekusi
error_log("Query: $query");
error_log("Params: " . print_r($params, true));

if (sqlsrv_execute($stmt) === false) {
    die("Eksekusi query gagal: " . print_r(sqlsrv_errors(), true));
}

// Tampilkan hasil
$rowCount = 0;
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $rowCount++;
    echo "<div class='form-group'>";
    echo "<label>";
    if ($row['hitung'] > 0) {
        echo "<input type='checkbox' name='selected_items[]' value='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "' checked> " . htmlspecialchars($row['nama_perawatan'], ENT_QUOTES, 'UTF-8');
    } else {
        echo "<input type='checkbox' name='selected_items[]' value='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'> " . htmlspecialchars($row['nama_perawatan'], ENT_QUOTES, 'UTF-8');
    }
    echo "</label>";
    echo "</div>";
}

if ($rowCount == 0) {
    echo "<p>Data tidak ditemukan untuk perangkat yang dipilih.</p>";
}

// Bebaskan resource dan tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>