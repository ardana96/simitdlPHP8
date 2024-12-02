<?php
include('../../config.php');
if(isset($_POST['tombol'])){
$id=$_POST['id'];

$query_delete="delete from tipe_perawatan where id='".$id."'";	
$update=mysql_query($query_delete);

$query_delete_item="delete from tipe_perawatan_item where tipe_perawatan_id='".$id."'";	
$update_item=mysql_query($query_delete_item);

if($update){
header("location:../../user.php?menu=perawatan");}
else{
header("location:../../user.php?menu=perawatan");}}
?>