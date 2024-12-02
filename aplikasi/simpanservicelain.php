<?php
include('../config.php');
if(isset($_POST['tombol'])){
$nomor=$_POST['nomor'];
$tanggal=$_POST['tgl'];
$jam=$_POST['jam'];
$bagian=$_POST['bagian'];
$devisi=$_POST['devisi'];
$perangkat=$_POST['perangkat'];
$permasalahan=$_POST['permasalahan'];
$it=$_POST['it'];
$nama=$_POST['nama'];
$status=$_POST['status'];
$ippc=$_POST['ippc'];


$query_insert="INSERT INTO service (nomor,tgl,jam,nama,bagian,divisi,perangkat,kasus,penerima,status,ippc) VALUES('".$nomor."','".$tanggal."','".$jam."','".$nama."','".$bagian."','".$devisi."','".$perangkat."','".$permasalahan."','".$it."','".$status."','".$ippc."')";
$insert=mysql_query($query_insert);
if($insert){
header("location:../user.php?menu=servicelain&stt=DATA BERHASIL DISIMPAN");}
else{
header("location:../user.php?menu=servicelain&stt=DATA GAGAL DISIMPAN");} }


?>