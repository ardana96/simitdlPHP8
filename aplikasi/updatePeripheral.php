<?php
include('../config.php');
if(isset($_POST['tombol'])){
$nomor=$_POST['nomor'];
$id_perangkat=$_POST['id_perangkat'];
$perangkat=$_POST['perangkat'];
$keterangan=$_POST['keterangan'];
$divisi=$_POST['divisi'];
$user = $_POST['user'];
$lokasi = $_POST['lokasi'];
$tgl_perawatan = $_POST['tgl_perawatan'];
$bulan = $_POST['bulan'];

$tipe = $_POST['tipe'];
$brand = $_POST['brand'];
$model = $_POST['model'];
$pembelian_dari = $_POST['pembelian_dari'];
$sn = $_POST['sn'];

$query_update="UPDATE peripheral SET id_perangkat= '".$id_perangkat."',perangkat= '".$perangkat."',
keterangan= '".$keterangan."',divisi= '".$divisi."',user= '".$user."', 
lokasi= '".$lokasi."',tgl_perawatan= '".$tgl_perawatan."',bulan= '".$bulan."',
tipe='".$tipe."', brand ='".$brand."', model ='".$model."', pembelian_dari='".$pembelian_dari."',
sn='".$sn."'

WHERE nomor='".$nomor."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=peripheral&stt= Update Berhasil");}
else{
header("location:../user.php?menu=peripheral&stt=gagal");}}
?>