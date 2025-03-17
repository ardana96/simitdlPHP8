<?php
// Sertakan file konfigurasi database (misalnya config.php)
include(dirname(dirname(dirname(__FILE__))) . '/config.php');

// Pastikan koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

// Ambil data header dari form
$nama_perangkat = $_POST['nama_perangkat'] ?? ''; // Gunakan null coalescing untuk mencegah undefined index
$nama_perawatan = $_POST['nama_perawatan'] ?? []; // Array nama_perawatan dari form

// Validasi input
if (empty($nama_perangkat) || !is_array($nama_perawatan) || empty($nama_perawatan)) {
    die(json_encode(['error' => 'Input tidak valid.']));
}

// Mulai transaksi
sqlsrv_begin_transaction($conn);

// Insert data ke tabel tipe_perawatan
$insertHeaderQuery = "INSERT INTO tipe_perawatan (nama_perangkat) VALUES (?)";
$paramsHeader = [$nama_perangkat];
$stmtHeader = sqlsrv_prepare($conn, $insertHeaderQuery, $paramsHeader);

if ($stmtHeader === false) {
    sqlsrv_rollback($conn);
    die("Persiapan query insert header gagal: " . print_r(sqlsrv_errors(), true));
}

if (!sqlsrv_execute($stmtHeader)) {
    sqlsrv_rollback($conn);
    die("Eksekusi query insert header gagal: " . print_r(sqlsrv_errors(), true));
}

// Ambil ID header yang baru saja disimpan
$header_id = sqlsrv_get_last_insert_id($conn); // Tidak ada fungsi langsung seperti mysql_insert_id di SQLSRV, gunakan SCOPE_IDENTITY()
// Alternatif: Gunakan query untuk mendapatkan ID terakhir
$stmtId = sqlsrv_query($conn, "SELECT SCOPE_IDENTITY() AS last_id");
if ($stmtId === false) {
    sqlsrv_rollback($conn);
    die("Gagal mendapatkan ID terakhir: " . print_r(sqlsrv_errors(), true));
}
$row = sqlsrv_fetch_array($stmtId, SQLSRV_FETCH_ASSOC);
$header_id = $row['last_id'];
sqlsrv_free_stmt($stmtId);

// Insert data items yang terkait dengan header_id
foreach ($nama_perawatan as $item_name) {
    $item_name = trim($item_name); // Hapus spasi berlebih
    if (!empty($item_name)) {
        $insertItemQuery = "INSERT INTO tipe_perawatan_item (tipe_perawatan_id, nama_perawatan) VALUES (?, ?)";
        $paramsItem = [$header_id, $item_name];
        $stmtItem = sqlsrv_prepare($conn, $insertItemQuery, $paramsItem);

        if ($stmtItem === false) {
            sqlsrv_rollback($conn);
            die("Persiapan query insert item gagal: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_execute($stmtItem)) {
            sqlsrv_rollback($conn);
            die("Eksekusi query insert item gagal: " . print_r(sqlsrv_errors(), true));
        }
        sqlsrv_free_stmt($stmtItem);
    }
}

// Commit transaksi jika semua insert berhasil
sqlsrv_commit($conn);
header('location:../../user.php?menu=perawatan&stt=' . urlencode('Simpan Berhasil'));
exit; // Pastikan script berhenti setelah redirect

// Tutup koneksi
sqlsrv_close($conn);
?>