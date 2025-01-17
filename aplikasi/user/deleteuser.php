<?php
include('../../config.php'); // Pastikan file ini memiliki koneksi SQL Server dengan `$conn`

// **Pastikan tombol submit ditekan**
if (isset($_POST['tombol'])) {
    $id = $_POST['id'] ?? null; // Pastikan ID ada

    if (!$id) {
        die("❌ ID user tidak ditemukan!");
    }

    // **Gunakan parameterized query untuk mencegah SQL Injection**
    $query_delete = "DELETE FROM tuser WHERE id_user = ?";
    $params = [$id];

    $stmt = sqlsrv_query($conn, $query_delete, $params);

    if ($stmt === false) {
        die("❌ Error saat menghapus user: " . print_r(sqlsrv_errors(), true));
    } else {
        header("location:../../user.php?menu=users&stt=delete_success");
        exit();
    }
}

// **Tutup koneksi**
sqlsrv_close($conn);
?>
