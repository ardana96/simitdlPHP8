<?php
include('../config.php');
if(isset($_POST['tombol'])){
$lokasi_id=$_POST['lokasi_id'];
$lokasi_nama=$_POST['lokasi_nama'];

$query_update="UPDATE sub_bagian SET lokasi_nama= '".$lokasi_nama."' WHERE lokasi_id='".$lokasi_id."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=lokasi&stt= Update Berhasil");}
else{
header("location:../user.php?menu=lokasi&stt=gagal");}}
?>