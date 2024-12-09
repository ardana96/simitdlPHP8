<?php
include('../config.php');

if (isset($_POST['button_selesai'])) {
    $no_faktur = $_POST['no_faktur'];
    $tglbeli = $_POST['tglbeli'];
    $jam = $_POST['jam'];
    $nomor = $_POST['nomor'];
    $idsupp = $_POST['idsupp'];
    $keterangan = $_POST['keterangan'];
    // $tahun = substr($tglbeli, -4, 4);
    // $bulan = substr($tglbeli, -7, 2);
    // $tanggal = substr($tglbeli, 0, 2);
    // $tglbaru = $tahun . '-' . $bulan . '-' . $tanggal;

    // Update data tpembelian
    $query_update = "UPDATE tpembelian SET tglbeli = ?, idsupp = ?, keterangan = ? WHERE nofaktur = ?";
    $params_update = array($tglbeli, $idsupp, $keterangan, $no_faktur);
    $update = sqlsrv_query($conn, $query_update, $params_update);

    // Periksa apakah query update berhasil
    if ($update === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Tambahan untuk permintaan
    if ($nomor != "") {
        $cek_query = "SELECT * FROM trincipembelian WHERE nofaktur = ?";
        $cek_params = array($no_faktur);
        $cek = sqlsrv_query($conn, $cek_query, $cek_params);

        if ($cek === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        while ($result = sqlsrv_fetch_array($cek, SQLSRV_FETCH_ASSOC)) {
            $namabarang = $result['namabarang'];
            $jumlah = $result['jumlah'];

            $perintah = "INSERT INTO rincipermintaan (nomor, nofaktur, namabarang, qtymasuk, tanggal) 
                         VALUES (?, ?, ?, ?, ?)";
            $params_perintah = array($nomor, $no_faktur, $namabarang, $jumlah, $tglbaru);
            $perintahh = sqlsrv_query($conn, $perintah, $params_perintah);

            if ($perintahh === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        }
    }

    // Redirect berdasarkan hasil update
    if ($update) {
        header("Location: ../user.php?menu=returmasuk&stt=Update Berhasil");
    } else {
        header("Location: ../user.php?menu=returmasuk&stt=gagal");
    }
}
?>
