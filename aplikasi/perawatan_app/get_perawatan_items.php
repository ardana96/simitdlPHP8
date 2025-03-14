<?php
// Sertakan file konfigurasi database (misalnya config.php)
include(dirname(dirname(dirname(__FILE__))) . '/config.php');

// Pastikan koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

// Ambil perangkat_id dari parameter GET
if (isset($_GET['perangkat_id'])) {
    $perangkat_id = $_GET['perangkat_id']; // Tidak perlu escape manual dengan prepared statements
    $idpc = $_GET['idpc'] ?? '';
    $tahun = $_GET['tahun'] ?? '';
    $bulan = $_GET['bulan'] ?? '';

    // Inisialisasi array parameter untuk prepared statement
    $params = [$perangkat_id];

    // Cek apakah perangkat adalah UPS atau Server (24 atau 25)
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
        $params = [$idpc, $tahun, $bulan, $perangkat_id, $perangkat_id];
    } else {
        $query = "SELECT id, nama_perawatan, 
                  (SELECT COUNT(*) FROM perawatan 
                   WHERE perawatan.idpc = ? 
                   AND YEAR(tanggal_perawatan) = ? 
                   AND perawatan.tipe_perawatan_item_id = tipe_perawatan_item.id  
                   AND perawatan.tipe_perawatan_id = ?) AS hitung 
                  FROM tipe_perawatan_item 
                  WHERE tipe_perawatan_id = ?";
        $params = [$idpc, $tahun, $perangkat_id, $perangkat_id];
    }

    // Persiapkan dan eksekusi query dengan prepared statement
    $stmt = sqlsrv_prepare($conn, $query, $params);
    if ($stmt === false) {
        die("Persiapan query gagal: " . print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_execute($stmt)) {
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
    } else {
        die("Eksekusi query gagal: " . print_r(sqlsrv_errors(), true));
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
} else {
    echo "<p>ID perangkat tidak valid.</p>";
}

// Tutup koneksi
sqlsrv_close($conn);
?>