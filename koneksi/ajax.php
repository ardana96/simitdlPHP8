<?php
$user_database="root";
$password_database="dlris30g";
$server_database="localhost";
$nama_database="sitdl";
$koneksi=mysql_connect($server_database,$user_database,$password_database);
if(!$koneksi){
die("Tidak bisa terhubung ke server".mysql_error());}
$pilih_database=mysql_select_db($nama_database,$koneksi);
if(!$pilih_database){
die("Database tidak bisa digunakan".mysql_error());}

$barang=$_GET['barang'];
$query="SELECT * From tbarang,tkategori
WHERE  tbarang.idkategori=tkategori.idkategori and namabarang='".$barang."'";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$idbarang=$hasil['idbarang'];
$barang=$hasil['barang'];
$idkategori=$hasil['idkategori'];
$jenis=$hasil['jenis'];
$kategori=$hasil['kategori'];
$stock=$hasil['stock'];
$data=$idbarang."&&&".$kategori."&&&".$kategori;
echo $data; ?>