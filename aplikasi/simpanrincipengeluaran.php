<?php
//session_start();
include('../config.php');
if(isset($_GET['kd_barang'])&&isset($_GET['no_faktur'])){
$kd_barang=$_GET['kd_barang'];
$no_faktur=$_GET['no_faktur'];

$query="SELECT * from tbarang,tkategori where tbarang.idkategori=tkategori.idkategori and  tbarang.barcode='$kd_barang' ";
$get_data=mysql_query($query);
$found=mysql_num_rows($get_data);
if($found>0){
$data=mysql_fetch_array($get_data);
$idbarang=$data['idbarang'];
$kategori=$data['kategori'];
$namabarang=$data['namabarang'];
$stock=$data['stock'];

$jml=1;
$stockbaru=$stock-$jml;


$query_rinci_jual="INSERT INTO trincipengambilan (nofaktur,idbarang,namabarang,jumlah)VALUES ('".$no_faktur."','".$idbarang."','".$namabarang."','".$jml."') ";
$insert_rinci_jual=mysql_query($query_rinci_jual);


$query_update="update tbarang set stock='$stockbaru' where barcode='$kd_barang'";
$update=mysql_query($query_update);



if($insert_rinci_jual){
header('location:../user.php?menu=keluar');}
else{
echo "Terjadi Kesalahan, Tidak dapat melanjutkan proses";}}
else{
echo "<script type='text/javascript'> alert('Kode Barang Tidak Terdaftar/Stock Habis!'); document.location.href='../user.php?menu=keluar'; </script>;";}}
?>