<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = $_POST['nomor'];

    $query_delete = "DELETE FROM service WHERE nomor = ?";
    $params = [$nomor];

    $stmt = sqlsrv_query($conn, $query_delete, $params);

    if ($stmt === false) {
        // Tangani kesalahan jika query gagal
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Kode Kesalahan: " . $error['code'] . "<br>";
            echo "Pesan Kesalahan: " . $error['message'] . "<br>";
        }
        header("location:../user.php?menu=service&stt=Gagal Hapus");
    } else {
        header("location:../user.php?menu=service&stt=Berhasil Hapus");
    }
}
?>
