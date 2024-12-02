<?php
include('../config.php');
if(isset($_POST['tombol'])){
$kd=$_POST['kd'];
$namadivisi=$_POST['namadivisi'];
$alamatsupp=$_POST['alamatsupp'];
$telpsupp=$_POST['telpsupp'];

$query_update="UPDATE divisi SET kd= '".$kd."',namadivisi= '".$namadivisi."' WHERE kd='".$kd."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=divisi&stt= Update Berhasil");}
else{
header("location:../user.php?menu=divisi&stt=gagal");}}
?>