<?php
// Koneksi ke database
$conn = mysql_connect("localhost", "root", "dlris30g");
mysql_select_db("sitdl", $conn);

// Ambil perangkat_id dari parameter GET
if (isset($_GET['perangkat_id'])) {
    $perangkat_id = mysql_real_escape_string($_GET['perangkat_id']);

    $idpc = mysql_real_escape_string($_GET['idpc']);
    $tahun = mysql_real_escape_string($_GET['tahun']);

    // var_dump($perangkat_id);
    // var_dump($idpc);
    // exit;

    // Query untuk mendapatkan data berdasarkan perangkat_id
    //$query = "SELECT * FROM tipe_perawatan_item WHERE tipe_perawatan_id = '$perangkat_id'";
    
    $query = "SELECT id, nama_perawatan, (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = '$idpc'

AND  YEAR(tanggal_perawatan) = $tahun AND perawatan.tipe_perawatan_item_id = tipe_perawatan_item.id  AND perawatan.`tipe_perawatan_id` = $perangkat_id ) AS hitung FROM tipe_perawatan_item WHERE tipe_perawatan_id = $perangkat_id";


    $result = mysql_query($query);

    if ($result && mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result)) {
          
            echo "<div class='form-group'>";
            echo "<label>";
            if ($row['hitung'] > 0) {
                echo "<input type='checkbox' name='selected_items[]' value='" . $row['id'] . "' checked> " . $row['nama_perawatan'];
            } else {
                echo "<input type='checkbox' name='selected_items[]' value='" . $row['id'] . "'> " . $row['nama_perawatan'];
            }
            
            echo "</label>";
            echo "</div>";
        }
    } else {
        echo "<p>Data tidak ditemukan untuk perangkat yang dipilih.</p>";
    }
} else {
    echo "<p>ID perangkat tidak valid.</p>";
}

mysql_close($conn);
?>
