<?php
// Koneksi ke database
$conn = mysql_connect("localhost", "root", "dlris30g");
mysql_select_db("sitdl", $conn);

// Ambil perangkat_id dari parameter GET
if (isset($_GET['perangkat'])) {
    $perangkat_id = mysql_real_escape_string($_GET['perangkat']);

    $query = "SELECT nama_perangkat FROM tipe_perawatan WHERE id = '$perangkat_id' LIMIT 1";
    $result = mysql_query($query, $conn);
    if ($result && mysql_num_rows($result) > 0) {
        // Ambil hasil sebagai string
        $row = mysql_fetch_assoc($result);
        $resultString = $row['nama_perangkat'];

        // Tampilkan hasil sebagai string (bukan JSON atau array)
        echo $resultString;
    } else {
        echo "Data tidak ditemukan";
    }
    
} else {
    echo "<p>ID perangkat tidak valid.</p>";
}

mysql_close($conn);
?>
