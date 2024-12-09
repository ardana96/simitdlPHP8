<?php
include('../config.php');
$datee = date('20y-m-d');
$jam = date("H:i");

if (isset($_POST['tombol'])) {
    if (isset($_POST['idpc'])) {
        $idpc = $_POST['idpc'];
        $mobo = $_POST['mobo'];
        $prosesor = $_POST['prosesor'];
        $casing = $_POST['casing'];
        $ps = $_POST['ps'];
        $nofaktur = $_POST['nofaktur'];
        $hd1 = $_POST['hd1'];
        $hd2 = $_POST['hd2'];
        $ram1 = $_POST['ram1'];
        $ram2 = $_POST['ram2'];
        $tglrakit = $_POST['tglrakit'];

        // Insert ke tabel tpc
        $query = "INSERT INTO tpc (idpc, tglrakit, status) VALUES (?, ?, 'digudang')";
        $params = array($idpc, $tglrakit);
        $insert = sqlsrv_query($conn, $query, $params);

        // Fungsi untuk update barang
        function updateBarang($conn, $nofaktur, $idpc, $idbarang, $field, $tableField)
        {
            // Ambil data barang
            $cek = "SELECT * FROM tbarang WHERE idbarang = ?";
            $cekStmt = sqlsrv_query($conn, $cek, array($idbarang));
            while ($result = sqlsrv_fetch_array($cekStmt, SQLSRV_FETCH_ASSOC)) {
                $namabarang = $result['namabarang'];
                $stock = $result['stock'];

                if ($stock > 0) {
                    $hasil = $stock - 1;

                    // Update ke tabel tpc
                    $updateTpc = "UPDATE tpc SET $tableField = ? WHERE idpc = ?";
                    sqlsrv_query($conn, $updateTpc, array($namabarang, $idpc));

                    // Update stok barang
                    $updateBarang = "UPDATE tbarang SET stock = ? WHERE idbarang = ?";
                    sqlsrv_query($conn, $updateBarang, array($hasil, $idbarang));

                    // Insert ke tabel trincipengambilan
                    $insertPengambilan = "INSERT INTO trincipengambilan (nofaktur, idbarang, namabarang, jumlah, status) 
                        VALUES (?, ?, ?, 1, 'perakitan')";
                    sqlsrv_query($conn, $insertPengambilan, array($nofaktur, $idbarang, $namabarang));
                }
            }
        }

        // Update untuk motherboard
        if (isset($_POST['mobo'])) {
            updateBarang($conn, $nofaktur, $idpc, $mobo, 'mobo', 'mobo');
        }

        // Update untuk prosesor
        if (isset($_POST['prosesor'])) {
            updateBarang($conn, $nofaktur, $idpc, $prosesor, 'prosesor', 'prosesor');
        }

        // Update untuk power supply
        if (isset($_POST['ps'])) {
            updateBarang($conn, $nofaktur, $idpc, $ps, 'ps', 'ps');
        }

        // Update untuk casing
        if (isset($_POST['casing'])) {
            updateBarang($conn, $nofaktur, $idpc, $casing, 'casing', 'casing');
        }

        // Update untuk harddisk 1
        if (isset($_POST['hd1'])) {
            updateBarang($conn, $nofaktur, $idpc, $hd1, 'hd1', 'hd1');
        }

        // Update untuk harddisk 2
        if (isset($_POST['hd2'])) {
            updateBarang($conn, $nofaktur, $idpc, $hd2, 'hd2', 'hd2');
        }

        // Update untuk RAM 1
        if (isset($_POST['ram1'])) {
            updateBarang($conn, $nofaktur, $idpc, $ram1, 'ram1', 'ram1');
        }

        // Update untuk RAM 2
        if (isset($_POST['ram2'])) {
            updateBarang($conn, $nofaktur, $idpc, $ram2, 'ram2', 'ram2');
        }

        // Update untuk fan
        if (isset($_POST['fan'])) {
            updateBarang($conn, $nofaktur, $idpc, $_POST['fan'], 'fan', 'fan');
        }

        // Update untuk DVD
        if (isset($_POST['dvd'])) {
            updateBarang($conn, $nofaktur, $idpc, $_POST['dvd'], 'dvd', 'dvd');
        }

        // Insert ke tabel tpengambilan
        $queryyy = "INSERT INTO tpengambilan (nofaktur, tglambil, jam, nama, bagian, divisi) 
                    VALUES (?, ?, ?, 'IT', 'B034', 'GARMENT')";
        sqlsrv_query($conn, $queryyy, array($nofaktur, $tglrakit, $jam));
    }

    if ($insert) {
        header("location:../user.php?menu=taperakitan&stt= Simpan Berhasil");
    } else {
        header("location:../user.php?menu=taperakitan&stt=gagal");
    }
}
?>
