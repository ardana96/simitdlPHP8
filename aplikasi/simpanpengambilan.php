<?php
session_start();
include('../config.php');


if(isset($_POST['button_selesai'])){
$no_faktur=$_POST['no_faktur'];
$tglambil=$_POST['tglambil'];
$jam=$_POST['jam'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$tgl_penjualan=date('Ymd');


$query="INSERT INTO tpengambilan (nofaktur,tglambil,jam,nama,bagian,divisi) 
VALUES ('".$no_faktur."','".$tglambil."','".$jam."','".$nama."','".$bagian."','".$divisi."')";
$insert=mysql_query($query);

$dd="update trincipengambilan set sesi='' where sesi='USR'";
$ddd=mysql_query($dd);
	
				
				
if($insert){
header('location:../pemakai.php?menu=pengambilan&stt= Simpan Berhasil');}
else{echo "transaksi gagal";}}
else{
header('location:../pemakai.php?menu=pengambilan&stt= Simpan Gagal');
}
?>