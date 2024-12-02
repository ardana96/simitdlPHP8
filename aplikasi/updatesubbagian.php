<?php
include('../config.php');
if(isset($_POST['tombol'])){
$subbag_id=$_POST['subbag_id'];
$subbag_nama=$_POST['subbag_nama'];

$query_update="UPDATE sub_bagian SET subbag_nama= '".$subbag_nama."' WHERE subbag_id='".$subbag_id."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=subbagian&stt= Update Berhasil");}
else{
header("location:../user.php?menu=subbagian&stt=gagal");}}
?>