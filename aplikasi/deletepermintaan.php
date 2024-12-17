<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = $_POST['nomor'];

    // Query update untuk menonaktifkan permintaan
    $query_delete = "UPDATE permintaan SET aktif = 'nonaktif' WHERE nomor = ?";
    
    // Parameter query
    $params = [$nomor];

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_delete, $params);

    if ($stmt) {
        header("location:../user.php?menu=permintaan&sukses");
    } else {
        // Menampilkan pesan error jika query gagal
        echo "Error in query preparation/execution: ";
        die(print_r(sqlsrv_errors(), true));
    }
}
?>
