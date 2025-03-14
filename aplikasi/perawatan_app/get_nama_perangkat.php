<?php
// Sertakan file konfigurasi database (misalnya config.php)
include(dirname(dirname(dirname(__FILE__))) . '/config.php');

// Pastikan koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

// Ambil perangkat_id dari parameter GET
if (isset($_GET['perangkat'])) {
    $perangkat_id = $_GET['perangkat']; // Tidak perlu escape manual dengan prepared statements

    // Query untuk mengambil nama_perangkat dengan prepared statement
    $query = "SELECT TOP 1 nama_perangkat FROM tipe_perawatan WHERE id = ?";
    $params = [$perangkat_id];
    $stmt = sqlsrv_prepare($conn, $query, $params);

    if ($stmt === false) {
        die("Persiapan query gagal: " . print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_execute($stmt)) {
        // Ambil hasil sebagai array
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // Tampilkan hasil sebagai string
            echo $row['nama_perangkat'] ?? 'Data tidak ditemukan';
        } else {
            echo "Data tidak ditemukan";
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