<?php
include('../config.php');
if(isset($_POST['tombol'])){
    $kd_barang = $_POST['kd_barang'];
    $no_faktur = $_POST['no_faktur'];
    $nama = $_POST['nama'];
    $bagian = $_POST['bagian'];
    $divisi = $_POST['divisi'];
    $noper = $_POST['noper'];

    // Menghapus data jika nomor permintaan ada
    if ($noper != '') {
        $cd_query = "DELETE FROM rincipermintaan WHERE nomor = ? AND nofaktur = ?";
        $cd_params = array($noper, $no_faktur);
        $cdd = sqlsrv_query($conn, $cd_query, $cd_params);
    }

    // Mengambil jumlah dari trincipengambilan
    $s_query = "SELECT SUM(jumlah) AS jum FROM trincipengambilan WHERE idbarang = ? AND nofaktur = ?";
    $s_params = array($kd_barang, $no_faktur);
    $ss = sqlsrv_query($conn, $s_query, $s_params);
    while ($dataa = sqlsrv_fetch_array($ss, SQLSRV_FETCH_ASSOC)) {
        $jum = $dataa['jum'];
    }

    // Mengambil data stock dari tbarang
    $b_query = "SELECT * FROM tbarang WHERE idbarang = ?";
    $b_params = array($kd_barang);
    $bb = sqlsrv_query($conn, $b_query, $b_params);
    while ($dataaa = sqlsrv_fetch_array($bb, SQLSRV_FETCH_ASSOC)) {
        $stock = $dataaa['stock'];
    }

    // Menambah stock
    $stockbaru = $stock + $jum;

    // Update stock di tbarang
    $qq_query = "UPDATE tbarang SET stock = ? WHERE idbarang = ?";
    $qq_params = array($stockbaru, $kd_barang);
    $perintah = sqlsrv_query($conn, $qq_query, $qq_params);

    // Menghapus data dari trincipengambilan
    $query_delete = "DELETE FROM trincipengambilan WHERE idbarang = ? AND nofaktur = ?";
    $delete_params = array($kd_barang, $no_faktur);
    $update = sqlsrv_query($conn, $query_delete, $delete_params);

    // Redirect berdasarkan hasil update
    if ($update) {
        header('Location: ../user.php?menu=freturpengambilanadmin&nama=' . urlencode($nama) . '&bagian=' . urlencode($bagian) . '&divisi=' . urlencode($divisi) . '&no_faktur=' . urlencode($no_faktur));
    } else {
        header('Location: ../user.php?menu=freturpengambilanadmin&nama=' . urlencode($nama) . '&bagian=' . urlencode($bagian) . '&divisi=' . urlencode($divisi) . '&no_faktur=' . urlencode($no_faktur));
    }
}
?>
