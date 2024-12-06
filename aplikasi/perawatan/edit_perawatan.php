<?php
include('../../config.php');

$id_perangkat = $_POST['id_perangkat'];
$nama_perangkat = $_POST['nama_perangkat'];
$items = $_POST['items']; // Array of items with 'id' and 'name'

// Cek apakah id_perangkat ada
if ($id_perangkat) {
    // Update perangkat jika ID ada
    $query = "UPDATE tipe_perawatan SET nama_perangkat = ? WHERE id = ?";
    $params = array($nama_perangkat, $id_perangkat);
    $stmt = sqlsrv_query($conn, $query, $params);

    // Cek jika query gagal
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

// Proses penyimpanan item
foreach ($items as $item) {
    $item_id = $item['id'];
    $item_name = $item['name'];
    
    if ($item_id != 'undefined') {
        // Update item jika ID ada
        $updateQuery = "UPDATE tipe_perawatan_item SET nama_perawatan = ? WHERE id = ?";
        $paramsUpdate = array($item_name, $item_id);
        $stmtUpdate = sqlsrv_query($conn, $updateQuery, $paramsUpdate);
        
        // Cek jika query gagal
        if ($stmtUpdate === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        
    } else {
        // Insert item baru jika ID tidak ada
        $insertQuery = "INSERT INTO tipe_perawatan_item (tipe_perawatan_id, nama_perawatan) VALUES (?, ?)";
        $paramsInsert = array($id_perangkat, $item_name);
        $stmtInsert = sqlsrv_query($conn, $insertQuery, $paramsInsert);
        
        // Cek jika query gagal
        if ($stmtInsert === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }
}



// Bebaskan statement dan tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_free_stmt($stmtUpdate);
sqlsrv_close($conn);
echo 'success';
?>
