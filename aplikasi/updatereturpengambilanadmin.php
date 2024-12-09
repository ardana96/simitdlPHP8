<?php
include('../config.php');
if(isset($_POST['button_selesai'])){
    $no_faktur = $_POST['no_faktur'];
    $tglambil = $_POST['tglambil'];
    $jam = $_POST['jam'];
    $nomor = $_POST['nomor'];
    $nama = $_POST['nama'];
    $bagian = $_POST['bagian'];
    $divisi = $_POST['divisi'];
    // $tahun = substr($tglambil, -4, 4);
    // $bulan = substr($tglambil, -7, 2);
    // $tanggal = substr($tglambil, 0, 2);
    $tglbaru = $tahun . '-' . $bulan . '-' . $tanggal;

    // Query update untuk SQL Server
    $query_update = "UPDATE tpengambilan SET nama = ?, bagian = ?, divisi = ? WHERE nofaktur = ?";
    $params = array($nama, $bagian, $divisi, $no_faktur);
    $update = sqlsrv_query($conn, $query_update, $params);

    // Tambahan untuk permintaan
    if ($nomor != "") {
        // Mengecek data dari trincipengambilan
        $cek_query = "SELECT * FROM trincipengambilan WHERE nofaktur = ?";
        $cek_params = array($no_faktur);
        $cek = sqlsrv_query($conn, $cek_query, $cek_params);

        while ($result = sqlsrv_fetch_array($cek, SQLSRV_FETCH_ASSOC)) {
            $namabarang = $result['namabarang'];
            $jumlah = $result['jumlah'];

            // Insert data ke rincipermintaan
            $perintah = "INSERT INTO rincipermintaan (nomor, nofaktur, namabarang, qtykeluar, tanggal) VALUES (?, ?, ?, ?, ?)";
            $perintah_params = array($nomor, $no_faktur, $namabarang, $jumlah, $tglambil);
            $perintahh = sqlsrv_query($conn, $perintah, $perintah_params);
        }

        // Cek status permintaan
        $cstatus_query = "SELECT SUM(qtymasuk) AS totalmasuk, SUM(qtykeluar) AS totalkeluar FROM rincipermintaan WHERE nomor = ?";
        $cstatus_params = array($nomor);
        $cstatus = sqlsrv_query($conn, $cstatus_query, $cstatus_params);

        while ($result = sqlsrv_fetch_array($cstatus, SQLSRV_FETCH_ASSOC)) {
            $totalkeluar = $result['totalkeluar'];
        }

        // Cek total permintaan
        $ccstatus_query = "SELECT * FROM permintaan WHERE nomor = ?";
        $ccstatus_params = array($nomor);
        $ccstatus = sqlsrv_query($conn, $ccstatus_query, $ccstatus_params);

        while ($result = sqlsrv_fetch_array($ccstatus, SQLSRV_FETCH_ASSOC)) {
            $totalpermintaan = $result['qty'];
        }

        // Update status permintaan jika sudah selesai
        if ($totalpermintaan == $totalkeluar) {
            $upstatus_query = "UPDATE permintaan SET status = 'SELESAI' WHERE nomor = ?";
            $upstatus_params = array($nomor);
            $uppstatus = sqlsrv_query($conn, $upstatus_query, $upstatus_params);
        }
    }

    // Cek apakah update berhasil
    if ($update) {
        header("Location: ../user.php?menu=returadmin&stt= Update Berhasil");
    } else {
        header("Location: ../user.php?menu=returadmin&stt=gagal");
    }
}
?>
