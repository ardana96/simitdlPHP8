<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    // Sumber untuk update spesifikasi 
    $nomor = $_POST['nomorup'];
    $user = $_POST['userup'];
    $divisi = $_POST['divisiup'];
    $bagianup = $_POST['bagianup'];
    $idpc = $_POST['idpcup'];
    $idpcc = $_POST['idpccup'];
    $namapc = $_POST['namapcup'];
    $ippc = $_POST['ippcup'];
    $os = $_POST['osup'];
    $prosesor = $_POST['prosesorup'];
    $mobo = $_POST['moboup'];
    $monitor = $_POST['monitorup'];
    $ram = $_POST['ramup'];
    $harddisk = $_POST['harddiskup'];
    $bulan = $_POST['bulanup'];
    $ram1 = $_POST['ram1up'];
    $ram2 = $_POST['ram2up'];
    $hd1 = $_POST['hd1up'];
    $model = $_POST['model'];
    $dvd = $_POST['dvdup'];
    $noper = $_POST['noper'];
    $keterangan = $_POST['keterangan'];
    $hd2 = $_POST['hd2up'];
    $powersuply = $_POST['powersuplyup'];
    $cassing = $_POST['cassingup'];
    $tgl_update = $_POST['tgl_updateup'];
    // Sumber service dalam
    $tgl2 = $_POST['TglPerbaikan'];
    $jam2 = $_POST['JamPerbaikan'];
    $teknisi = $_POST['TeknisiPerbaikan'];
    $tindakan = $_POST['TindakanPerbaikan'];
    $nomorkasus = $_POST['nomorkasus'];
    $statup = $_POST['statup'];
    $svc_kat = $_POST['svc_kat'];
    $nofaktur = $_POST['nofaktur'];
    $bagianambil = $_POST['bagianambil'];
    $nofakturbeli = $_POST['nofakturbeli'];

    // Simpan service dalam
    $pservice = "UPDATE service 
                 SET tgl2 = ?, keterangan = ?, statup = ?, jam2 = ?, teknisi = ?, tindakan = ?, status = 'selesai', ket = 'D', svc_kat = ?
                 WHERE nomor = ?";
    $params = [$tgl2, $keterangan, $statup, $jam2, $teknisi, $tindakan, $svc_kat, $nomorkasus];
    $ppservice = sqlsrv_query($conn, $pservice, $params);

    // Simpan pengambilan
    $ttt = "SELECT * FROM trincipengambilan WHERE nofaktur = ?";
    $ttt_stmt = sqlsrv_query($conn, $ttt, [$nofaktur]);
    if (sqlsrv_has_rows($ttt_stmt)) {
        $ppengambilan = "INSERT INTO tpengambilan (nofaktur, jam, tglambil, nama, bagian, divisi) 
                         VALUES (?, ?, ?, ?, ?, ?)";
        $pppengambilan = sqlsrv_query($conn, $ppengambilan, [$nofaktur, $jam2, $tgl2, $user, $bagianambil, $divisi]);
    }

    // Simpan update spesifikasi
    $query_update = "UPDATE pcaktif 
                     SET model = ?, tgl_update = ?, user = ?, divisi = ?, bagian = ?, idpc = ?, namapc = ?, ippc = ?, os = ?, prosesor = ?, 
                         mobo = ?, monitor = ?, ram = ?, harddisk = ?, ram1 = ?, ram2 = ?, hd1 = ?, hd2 = ?, powersuply = ?, cassing = ?, dvd = ?
                     WHERE nomor = ?";
    $update_params = [$model, $tgl2, $user, $divisi, $bagianup, $idpc, $namapc, $ippc, $os, $prosesor, $mobo, $monitor, $ram, $harddisk,
                      $ram1, $ram2, $hd1, $hd2, $powersuply, $cassing, $dvd, $nomor];
    $update = sqlsrv_query($conn, $query_update, $update_params);

    // Tambahan untuk permintaan
    if (!empty($noper)) {
        $cekambil = "SELECT * FROM trincipengambilan WHERE nofaktur = ?";
        $cekambil_stmt = sqlsrv_query($conn, $cekambil, [$nofaktur]);
        while ($resultambil = sqlsrv_fetch_array($cekambil_stmt, SQLSRV_FETCH_ASSOC)) {
            $namabarangambil = $resultambil['namabarang'];
            $jumlahambil = $resultambil['jumlah'];
            $perintahambil = "INSERT INTO rincipermintaan (nomor, nofaktur, namabarang, qtykeluar, tanggal) 
                              VALUES (?, ?, ?, ?, ?)";
            sqlsrv_query($conn, $perintahambil, [$noper, $nofaktur, $namabarangambil, $jumlahambil, $tgl2]);
        }

        $cekjumminta = "SELECT qty FROM permintaan WHERE nomor = ?";
        $cekjumminta_stmt = sqlsrv_query($conn, $cekjumminta, [$noper]);
        $jumlahminta = sqlsrv_fetch_array($cekjumminta_stmt, SQLSRV_FETCH_ASSOC)['qty'];

        $cekkeluar = "SELECT SUM(qtykeluar) AS jumkel FROM rincipermintaan WHERE nomor = ?";
        $cekkeluar_stmt = sqlsrv_query($conn, $cekkeluar, [$noper]);
        $jumlahkeluar = sqlsrv_fetch_array($cekkeluar_stmt, SQLSRV_FETCH_ASSOC)['jumkel'];

        if ($jumlahkeluar == $jumlahminta) {
            $perubahan = "UPDATE permintaan SET status = 'SELESAI' WHERE nomor = ?";
            sqlsrv_query($conn, $perubahan, [$noper]);
        }
    }

    // Set sesi kosong di trincipengambilan
    $dd = "UPDATE trincipengambilan SET sesi = '' WHERE sesi = 'ADM'";
    sqlsrv_query($conn, $dd);

    // Redirect berdasarkan hasil update
    if ($update) {
        header("Location: ../user.php?menu=service&stt= Update Berhasil");
    } else {
        header("Location: ../user.php?menu=service&stt=gagal");
    }
}
?>
