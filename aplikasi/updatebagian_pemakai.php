<?php
include('../config.php');
if(isset($_POST['tombol'])){
$id_bag_pemakai=$_POST['id_bag_pemakai'];
$bag_pemakai=$_POST['bag_pemakai'];

$query_update="UPDATE bagian_pemakai SET bag_pemakai= '".$bag_pemakai."' WHERE id_bag_pemakai='".$id_bag_pemakai."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=bagian_pemakai&stt= Update Berhasil");}
else{
header("location:../user.php?menu=bagian_pemakai&stt=gagal");}}
?>