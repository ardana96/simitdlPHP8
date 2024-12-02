<?php
session_start();
include('../config.php');


if(isset($_POST['tombol_selesai'])){
$no_faktur=$_POST['no_faktur'];
$tgl1=$_POST['tgl1'];
$jam1=$_POST['jam1'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$telp=$_POST['telp'];
$tgl_penjualan=date('Ymd');


$query="INSERT INTO tpinjam (nopinjam,tgl1,jam1,nama,bagian,divisi,telp) 
VALUES ('".$no_faktur."','".$tgl1."','".$jam1."','".$nama."','".$bagian."','".$divisi."','".$telp."')";
$insert=mysql_query($query);
	
				
				
if($insert){
header('location:../pemakai.php?menu=peminjaman&stt= Simpan Berhasil');}
else{echo "transaksi gagal";}}
else{
header('location:../pemakai.php?menu=peminjaman&stt= Simpan Gagal');
}
?>