

<?php
include('../config.php'); // Pastikan koneksi menggunakan sqlsrv

// Ambil parameter dari URL
$id_bagian=$_GET['id_bagian'];
$query = "SELECT * from  bagian_pemakai WHERE id_bag_pemakai=?";
$params = array($id_bagian);
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    // Jika query gagal, tampilkan pesan error
    die(print_r(sqlsrv_errors(), true));
}

// Ambil data dari hasil query
$hasil = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if ($hasil) {
    // Ambil nilai kolom
    $id_bag_pemakai=$hasil['id_bag_pemakai'];
    $bag_pemakai=$hasil['bag_pemakai'];

    // Gabungkan data dengan format tertentu
    $data=$id_bag_pemakai."&&&".$bag_pemakai;
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
