<!doctype html>
<html>
<head>
<title>AJAX Autocomplete With PHP - phphunger.com</title>
</head>
<body>
<?php
include('config.php');
if (isset($_GET['search']) && $_GET['search'] != '') { 
    // Hindari SQL Injection dengan parameterized query
    $search = $_GET['search'];
    $query = "SELECT * FROM printer WHERE keterangan LIKE ?";
    $params = ['%' . $search . '%'];
    
    $stmt = sqlsrv_query($conn, $query, $params);

    // Periksa apakah query berhasil
    if ($stmt === false) {
        // Tangkap error jika query gagal
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Kode Kesalahan: " . $error[0] . "<br>";
            echo "Pesan Kesalahan: " . $error[2] . "<br>";
        }
        die("Query gagal dijalankan.");
    }

    // Fetch dan tampilkan data
    while ($suggest = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo $suggest['keterangan'] . "\n";
    }
}
?>

</body>
</html>