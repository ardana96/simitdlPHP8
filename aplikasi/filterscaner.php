<?php
include('../config.php'); // Pastikan koneksi menggunakan sqlsrv

// Ambil parameter dari URL
$nomor = $_GET['nomor'];
$query = "SELECT * FROM scaner WHERE nomor = ?";
$params = array($nomor);
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    // Jika query gagal, tampilkan pesan error
    die(print_r(sqlsrv_errors(), true));
}

// Ambil data dari hasil query
$hasil = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if ($hasil) {
    // Ambil nilai kolom
    $nomor = $hasil['nomor'];
    $id_perangkat = $hasil['id_perangkat'];
    $printer = $hasil['printer'];
    $keterangan = $hasil['keterangan'];
    $status = $hasil['status'];
    $user = $hasil['user']; // Perhatikan jika user adalah keyword SQL Server, gunakan [user]
    $lokasi = $hasil['lokasi'];
    $tgl_perawatan = $hasil['tgl_perawatan'];
    $bulan = $hasil['bulan'];

    // Gabungkan data dengan format tertentu
    $data = $nomor. "&&&" . $id_perangkat . "&&&" . $printer . "&&&" . $keterangan . "&&&" . $status . "&&&" . $user . "&&&" . $lokasi . "&&&" . $tgl_perawatan->format('Y-m-d') . "&&&" . $bulan;
    echo $data;
} else {
    // Jika data tidak ditemukan
    echo "Data tidak ditemukan untuk nomor: " . htmlspecialchars($nomor);
}

// Bebaskan resource statement
sqlsrv_free_stmt($stmt);

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
