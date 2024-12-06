<?php
session_start();
include('../config.php');

if (isset($_POST['button_selesai'])) {
    $no_faktur = $_POST['no_faktur'];
    $tglbeli = $_POST['tglbeli'];
    $jam = $_POST['jam'];
    $keterangan = $_POST['keterangan'];
    $idsupp = $_POST['idsupp'];
    // $bagian = $_POST['bagian'];
    // $divisi = $_POST['divisi'];
    $nomor = $_POST['nomor'];
    // $tahun = substr($tglbeli, -4, 4);
    // $bulan = substr($tglbeli, -7, 2);
    // $tanggal = substr($tglbeli, 0, 2);
    // $tglbaru = $tahun . '-' . $bulan . '-' . $tanggal;

    // Query untuk memasukkan data ke tabel tpembelian
    $query = "INSERT INTO tpembelian (nofaktur, idsupp, tglbeli, keterangan) 
              VALUES (?, ?, ?, ?)";
    $params = array($no_faktur, $idsupp, $tglbeli, $keterangan);

    $insert = sqlsrv_query($conn, $query, $params);

    // Tambahan untuk permintaan
    if ($nomor <> "") {
        $cek_query = "SELECT * FROM trincipembelian WHERE nofaktur = ?";
        $cek_params = array($no_faktur);
        $cek = sqlsrv_query($conn, $cek_query, $cek_params);

        // Periksa apakah query berhasil
        if ($cek === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        while ($result = sqlsrv_fetch_array($cek, SQLSRV_FETCH_ASSOC)) {
            $namabarang = $result['namabarang'];
            $jumlah = $result['jumlah'];

            // Query untuk memasukkan data ke tabel rincipermintaan
            $perintah = "INSERT INTO rincipermintaan (nomor, nofaktur, namabarang, qtymasuk, tanggal) 
                         VALUES (?, ?, ?, ?, ?)";
            $perintah_params = array($nomor, $no_faktur, $namabarang, $jumlah, $tglbeli);

            $perintahh = sqlsrv_query($conn, $perintah, $perintah_params);

            // Periksa jika query gagal
            if ($perintahh === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        }
    }

    // Redirect jika transaksi berhasil
    if ($insert) {
        header('Location: ../user.php?menu=masuk');
    } else {
        $errors = sqlsrv_errors();
        $error_message = "Gagal menyimpan data. Detail error: " . print_r($errors, true);
        echo $idsupp." ". $tglbeli." ". $keterangan. " ". $no_faktur;    
    }
} else {
    header('Location: ../user.php?menu=masuk');
}
?>
