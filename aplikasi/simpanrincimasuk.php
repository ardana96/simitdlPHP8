<?php
include('../config.php'); // Pastikan sudah terkoneksi dengan SQL Server

if (isset($_POST['idbarang']) && isset($_POST['nofaktur'])) {
    $kd_barang = $_POST['idbarang'];
    $no_faktur = $_POST['nofaktur'];
    $jml = $_POST['jumlah'];

    // Query untuk mendapatkan data barang dan kategori
    $query = "SELECT tbarang.idbarang, tbarang.namabarang, tbarang.stock, tkategori.kategori 
              FROM tbarang 
              INNER JOIN tkategori ON tbarang.idkategori = tkategori.idkategori 
              WHERE tbarang.idbarang = ?";
    
    // Menyiapkan parameter untuk query
    $params = array($kd_barang);
    
    // Eksekusi query
    $get_data = sqlsrv_query($conn, $query, $params);
   
   
    if ($get_data) {
        

        $found = 0;
        while ($data = sqlsrv_fetch_array($get_data, SQLSRV_FETCH_ASSOC)) {
            $found++;
            $idbarang = $data['idbarang'];
            $kategori = $data['kategori'];
            $namabarang = $data['namabarang'];
            $stock = $data['stock'];
        }
       
        if ($found > 0) {
            // Ambil data dari query
            //$data = sqlsrv_fetch_array($get_data, SQLSRV_FETCH_ASSOC);
            
            $stockbaru = $stock + $jml;

            // Query untuk memasukkan rincian pembelian
            $query_rinci_jual = "INSERT INTO trincipembelian (nofaktur, idbarang, namabarang, jumlah) 
                                 VALUES (?, ?, ?, ?)";
            
            // Parameter untuk query insert rincian pembelian
            $params_rinci = array($no_faktur, $idbarang, $namabarang, $jml);
            
            // Eksekusi insert
            $insert_rinci_jual = sqlsrv_query($conn, $query_rinci_jual, $params_rinci);

            if (!$insert_rinci_jual) {
                die("Error inserting data into trincipembelian: " . print_r(sqlsrv_errors(), true));
            }

            // Query untuk update stock barang
            $query_update = "UPDATE tbarang SET stock = ? WHERE idbarang = ?";
            
            // Parameter untuk query update stock
            $params_update = array($stockbaru, $kd_barang);
            
            // Eksekusi update
            $update = sqlsrv_query($conn, $query_update, $params_update);

            if (!$update) {
                die("Error updating stock: " . print_r(sqlsrv_errors(), true));
            }

            // Redirect jika semua proses berhasil
            header('Location: ../user.php?menu=masuk');
        }
         else {
            echo "<script type='text/javascript'> 
                    alert('Kode Barang Tidak Terdaftar/Stock Habis!'); 
                    document.location.href='../user.php?menu=masuk'; 
                  </script>";
        }
    } else {
        echo "Error executing query: " . print_r(sqlsrv_errors(), true);
    }

    echo $found;
}
?>
