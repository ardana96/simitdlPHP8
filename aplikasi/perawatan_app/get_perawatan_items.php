<?php
// Sertakan file konfigurasi database (misalnya config.php)
include(dirname(dirname(dirname(__FILE__))) . '/config.php');

// Pastikan koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

// Ambil perangkat_id dari parameter GET dengan validasi ketat
if (!isset($_GET['perangkat_id']) || trim($_GET['perangkat_id']) === '' || trim($_GET['perangkat_id']) === 'null' || !is_numeric($_GET['perangkat_id'])) {
    die("Perangkat ID tidak valid.");
}
$perangkat_id = (int)$_GET['perangkat_id'];

$idpc = $_GET['idpc'] ?? '';

if (!isset($_GET['tahun']) || trim($_GET['tahun']) === '' || trim($_GET['tahun']) === 'null' || !is_numeric($_GET['tahun'])) {
    die("Tahun tidak valid.");
}
$tahun = $_GET['tahun']; // Biarkan sebagai string karena kolom tahun adalah VARCHAR

$bulan = isset($_GET['bulan']) && preg_match('/^(0[1-9]|1[0-2])$/', $_GET['bulan']) ? $_GET['bulan'] : '01';

// Debugging
error_log("Raw perangkat_id: " . var_export($_GET['perangkat_id'], true) . ", Type: " . gettype($_GET['perangkat_id']));
error_log("Raw tahun: " . var_export($_GET['tahun'], true) . ", Type: " . gettype($_GET['tahun']));
error_log("Converted perangkat_id: $perangkat_id, Type: " . gettype($perangkat_id));
error_log("Converted tahun: $tahun, Type: " . gettype($tahun));
error_log("Parameters: perangkat_id=$perangkat_id, idpc=$idpc, tahun=$tahun, bulan=$bulan");
error_log("Raw GET data: " . print_r($_GET, true));

// Inisialisasi array parameter untuk prepared statement
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
        array($idpc, SQLSRV_PARAM_IN),
        array($tahun, SQLSRV_PARAM_IN), // Kolom tahun adalah VARCHAR, jadi biarkan sebagai string
        array($bulan, SQLSRV_PARAM_IN),
        array($perangkat_id, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_INT),
        array($perangkat_id, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_INT)
    );
} else {
    $query = "SELECT id, nama_perawatan, 
              (SELECT COUNT(*) FROM perawatan 
               WHERE perawatan.idpc = ? 
               AND YEAR(tanggal_perawatan) = ? 
               AND perawatan.tipe_perawatan_item_id = tipe_perawatan_item.id  
               AND perawatan.tipe_perawatan_id = ?) AS hitung 
              FROM tipe_perawatan_item 
              WHERE tipe_perawatan_id = ?";
    $params = array(
        array($idpc, SQLSRV_PARAM_IN),
        array($tahun, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_INT), // YEAR() menghasilkan INT
        array($perangkat_id, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_INT),
        array($perangkat_id, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_INT)
    );
}

// Persiapkan dan eksekusi query dengan prepared statement
$stmt = sqlsrv_prepare($conn, $query, $params);
if ($stmt === false) {
    die("Persiapan query gagal: " . print_r(sqlsrv_errors(), true));
}

if (sqlsrv_execute($stmt)) {
    $rowCount = 0;
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        if ($row === false) {
            error_log("Gagal mengambil data: " . print_r(sqlsrv_errors(), true));
            continue;
        }
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
        error_log("Tidak ada data ditemukan untuk perangkat_id: $perangkat_id, idpc: $idpc, tahun: $tahun, bulan: $bulan");
        echo "<p>Data tidak ditemukan untuk perangkat yang dipilih.</p>";
    }
} else {
    die("Eksekusi query gagal: " . print_r(sqlsrv_errors(), true));
}

// Bebaskan resource statement
sqlsrv_free_stmt($stmt);

// Tutup koneksi
sqlsrv_close($conn);
?>