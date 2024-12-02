<?php
include('../config.php');
if(isset($_POST['tombol'])){
$lokasi_id=$_POST['lokasi_id'];

$query_delete="delete from lokasi where lokasi_id='".$lokasi_id."'";	
$update=mysql_query($query_delete);
if($update){
header("location:../user.php?menu=lokasi");}
else{
header("location:../user.php?menu=lokasi");}}
?>