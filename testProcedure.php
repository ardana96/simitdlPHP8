<?php
// Koneksi ke database
$server = "localhost";
$username = "root";
$password = "dlris30g";
$database = "sitdl";

$connection = mysql_connect($server, $username, $password);
if (!$connection) {
    die("Connection failed: " . mysql_error());
}

// Pilih database
mysql_select_db($database, $connection);

// Query untuk mengambil data
$sql = "SELECT id, idpc, tipe_perawatan_id, tipe_perawatan_item_id, tanggal_perawatan FROM perawatan";
$result = mysql_query($sql);

if (!$result) {
    die("Query failed: " . mysql_error());
}

// Menampilkan hasil dalam tabel HTML
echo "<table border='1'>";
echo "<tr><th>id</th><th>idpc</th><th>tipe_perawatan_id</th><th>tipe_perawatan_item_id</th><th>tanggal_perawatan</th></tr>";

while ($row = mysql_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row["id"] . "</td>";
    echo "<td>" . $row["idpc"] . "</td>";
    echo "<td>" . $row["tipe_perawatan_id"] . "</td>";
    echo "<td>" . $row["tipe_perawatan_item_id"] . "</td>";
    echo "<td>" . $row["tanggal_perawatan"] . "</td>";
    echo "</tr>";
}

echo "</table>";

// Tutup koneksi
mysql_close($connection);
?>
