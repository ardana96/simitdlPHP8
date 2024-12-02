<?php
$server = "localhost";
$username = "root";
$password = "dlris30g";
$database = "sitdl";

// Membuka koneksi
$connection = mysql_connect($server, $username, $password);
mysql_select_db($database, $connection);

$id_perangkat = $_POST['id_perangkat'];
$nama_perangkat = $_POST['nama_perangkat'];
$items = $_POST['items']; // Array of items with 'id' and 'name'


if ($id_perangkat) {
    // Update perangkat jika ID ada
    $query = "UPDATE tipe_perawatan SET nama_perangkat = '$nama_perangkat' WHERE id = '$id_perangkat'";
    mysql_query($query);
} 
// else {
//     // Insert perangkat baru jika ID tidak ada
//     $query = "INSERT INTO perangkat (nama_perangkat) VALUES ('$nama_perangkat')";
//     mysql_query($query);
//     $id_perangkat = mysql_insert_id(); // Dapatkan ID perangkat yang baru ditambahkan
// }

// Proses penyimpanan item
foreach ($items as $item) {
    $item_id = $item['id'];
    $item_name = $item['name'];
    
    if ($item_id != 'undefined') {
        // Update item jika ID ada
        $updateQuery = "UPDATE tipe_perawatan_item SET nama_perawatan = '$item_name' WHERE id = '$item_id'";
        mysql_query($updateQuery);
        
    } else {
        // Insert item baru jika ID tidak ada
        $insertQuery = "INSERT INTO tipe_perawatan_item (tipe_perawatan_id, nama_perawatan) VALUES ('$id_perangkat', '$item_name')";
        mysql_query($insertQuery);

       
    }
    
}

echo 'success';
mysql_close($connection);
?>
