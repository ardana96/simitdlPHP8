<!doctype html>
<html>
<head>
<title>AJAX Autocomplete With PHP - phphunger.com</title>
</head>
<body>
<?php
include('config.php');
if (isset($_GET['search']) && $_GET['search'] != '') {
    // Ambil parameter pencarian
    $search = $_GET['search'];

    // Query untuk mendapatkan data barang berdasarkan nama yang mengandung kata kunci pencarian
    $query = "SELECT * FROM tbarang WHERE namabarang LIKE ?";

    // Menyiapkan parameter pencarian
    $params = array('%' . $search . '%');

    // Menjalankan query dengan parameter
    $suggest_query = sqlsrv_query($conn, $query, $params);

    // Cek apakah query berhasil
    if ($suggest_query === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Menampilkan hasil pencarian
    while ($suggest = sqlsrv_fetch_array($suggest_query, SQLSRV_FETCH_ASSOC)) {
        echo $suggest['namabarang'] . "\n";
    }

    // Membebaskan hasil query
    sqlsrv_free_stmt($suggest_query);
}
?>
</body>
</html>