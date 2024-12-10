<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = $_POST['nomor'];

    $query_delete = "DELETE FROM service WHERE nomor = ?";
    $params = array($nomor);

    $stmt = sqlsrv_query($conn, $query_delete, $params);

    if ($stmt) {
        header("Location: ../user.php?menu=riwayatprinter&stt=Berhasil Hapus");
    } else {
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Kode Kesalahan: " . $error[0] . "<br>";
            echo "Pesan Kesalahan: " . $error[2] . "<br>";
        }
        header("Location: ../user.php?menu=riwayatprinter&stt=Gagal Hapus");
    }
}
?>
