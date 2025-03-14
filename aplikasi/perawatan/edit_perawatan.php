<?php
// Sertakan file konfigurasi database (misalnya config.php)
include(dirname(dirname(dirname(__FILE__))) . '/config.php');

// Pastikan koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

// Mengambil data dari POST
$id_perangkat = $_POST['id_perangkat'] ?? ''; // Gunakan null coalescing untuk mencegah undefined index
$nama_perangkat = $_POST['nama_perangkat'] ?? '';
$items = $_POST['items'] ?? []; // Array of items with 'id' and 'name'

// Validasi input
if (empty($id_perangkat) || empty($nama_perangkat) || !is_array($items)) {
    die("Input tidak valid.");
}

// Update perangkat jika ID ada
if ($id_perangkat) {
    $query = "UPDATE tipe_perawatan SET nama_perangkat = ? WHERE id = ?";
    $params = [$nama_perangkat, $id_perangkat];
    $stmt = sqlsrv_prepare($conn, $query, $params);

    if ($stmt === false) {
        die("Persiapan query update tipe_perawatan gagal: " . print_r(sqlsrv_errors(), true));
    }

    if (!sqlsrv_execute($stmt)) {
        die("Eksekusi query update tipe_perawatan gagal: " . print_r(sqlsrv_errors(), true));
    }
    sqlsrv_free_stmt($stmt);
}

// Proses penyimpanan item
foreach ($items as $item) {
    $item_id = $item['id'] ?? '';
    $item_name = $item['name'] ?? '';

    // Validasi item
    if (empty($item_name)) {
        continue; // Lewati jika nama item kosong
    }

    if ($item_id != 'undefined' && !empty($item_id)) {
        // Update item jika ID ada
        $updateQuery = "UPDATE tipe_perawatan_item SET nama_perawatan = ? WHERE id = ?";
        $updateParams = [$item_name, $item_id];
        $updateStmt = sqlsrv_prepare($conn, $updateQuery, $updateParams);

        if ($updateStmt === false) {
            die("Persiapan query update tipe_perawatan_item gagal: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_execute($updateStmt)) {
            die("Eksekusi query update tipe_perawatan_item gagal: " . print_r(sqlsrv_errors(), true));
        }
        sqlsrv_free_stmt($updateStmt);
    } else {
        // Insert item baru jika ID tidak ada
        $insertQuery = "INSERT INTO tipe_perawatan_item (tipe_perawatan_id, nama_perawatan) VALUES (?, ?)";
        $insertParams = [$id_perangkat, $item_name];
        $insertStmt = sqlsrv_prepare($conn, $insertQuery, $insertParams);

        if ($insertStmt === false) {
            die("Persiapan query insert tipe_perawatan_item gagal: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_execute($insertStmt)) {
            die("Eksekusi query insert tipe_perawatan_item gagal: " . print_r(sqlsrv_errors(), true));
        }
        sqlsrv_free_stmt($insertStmt);
    }
}

// Berikan respon sukses
echo 'success';

// Tutup koneksi
sqlsrv_close($conn);
?>