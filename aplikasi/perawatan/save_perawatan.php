<?php
include('../../config.php');

// Ambil data dari form
$nama_perangkat = $_POST['nama_perangkat'];

// Mulai transaksi
sqlsrv_begin_transaction($conn);

$query_insert = "INSERT INTO tipe_perawatan (nama_perangkat)
    OUTPUT INSERTED.id AS header_id
    VALUES (?);
";

$params = array($nama_perangkat);
$stmt_insert = sqlsrv_query($conn, $query_insert, $params);

if ($stmt_insert) {
    // Mendapatkan header_id dari OUTPUT clause
    $row = sqlsrv_fetch_array($stmt_insert, SQLSRV_FETCH_ASSOC);
    $header_id = $row['header_id'];

    echo "ID: " . $header_id;
} else {
    sqlsrv_rollback($conn);
    die("Error inserting data: " . print_r(sqlsrv_errors(), true));
}


// Ambil ID header yang baru saja disimpan dengan SCOPE_IDENTITY
// $queryId = "SELECT SCOPE_IDENTITY() AS header_id"; 
// $stmtId = sqlsrv_query($conn, $queryId);

// if ($stmtId) {
//     $row = sqlsrv_fetch_array($stmtId, SQLSRV_FETCH_ASSOC);
//     $header_id = $row['header_id'];

//     echo "ID: " . $header_id;
// } else {
//     sqlsrv_rollback($conn);
//     die("Error fetching ID: " . print_r(sqlsrv_errors(), true));
// }

// Insert data items yang terkait dengan header_id
for ($i = 0; $i < count($_POST['nama_perawatan']); $i++) {
    $nama_perawatan = $_POST['nama_perawatan'][$i];

    $insertItemQuery = "INSERT INTO tipe_perawatan_item (tipe_perawatan_id, nama_perawatan) VALUES (?, ?)";
    $paramsItem = array($header_id, $nama_perawatan);
    $stmtItem = sqlsrv_query($conn, $insertItemQuery, $paramsItem);

    if (!$stmtItem) {
        sqlsrv_rollback($conn);
        die("Error inserting item: " . print_r(sqlsrv_errors(), true));
    }
}

// Commit transaksi jika semua insert berhasil
sqlsrv_commit($conn);

// Redirect ke halaman success
header('Location: ../../user.php?menu=perawatan&stt=Simpan Berhasil');
exit();

// Tutup koneksi
sqlsrv_close($conn);
?>
