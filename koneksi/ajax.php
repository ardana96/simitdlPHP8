<?php
include('../config.php');

// Ambil parameter barang
$barang = $_GET['barang'];

// Query untuk mendapatkan data barang dan kategori
$query = "SELECT tbarang.idbarang, tbarang.namabarang, tbarang.idkategori,  tkategori.kategori, tbarang.stock
          FROM tbarang
          JOIN tkategori ON tbarang.idkategori = tkategori.idkategori
          WHERE tbarang.namabarang = ?";

// Menyiapkan parameter untuk query
$params = array($barang);

// Menjalankan query dengan parameter
$get_data = sqlsrv_query($conn, $query, $params);

// Cek apakah query berhasil
if ($get_data === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Ambil hasil data
$hasil = sqlsrv_fetch_array($get_data, SQLSRV_FETCH_ASSOC);

if ($hasil) {
    // Ambil data dari hasil query
    $idbarang = $hasil['idbarang'];
    $barang = $hasil['namabarang'];
    $idkategori = $hasil['idkategori'];
   // $jenis = $hasil['jenis'];
    $kategori = $hasil['kategori'];
    $stock = $hasil['stock'];

    // Gabungkan data menjadi string
    $data = $idbarang . "&&&" . $kategori . "&&&" . $kategori;

    // Output data
    echo $data;
} else {
    echo "Data tidak ditemukan.";
}

// Tutup koneksi
sqlsrv_free_stmt($get_data);
?>
