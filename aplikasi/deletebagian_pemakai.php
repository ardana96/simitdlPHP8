<?php
include('../config.php');
if(isset($_POST['tombol'])){
$id_bag_pemakai=$_POST['id_bag_pemakai'];

$query_delete="delete from bagian_pemakai where id_bag_pemakai='".$id_bag_pemakai."'";	
$update=mysql_query($query_delete);
if($update){
header("location:../user.php?menu=bagian_pemakai");}
else{
header("location:../user.php?menu=bagian_pemakai");}}
?>