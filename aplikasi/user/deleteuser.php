<?php
include('../../config.php');
if(isset($_POST['tombol'])){
$id=$_POST['id'];

$query_delete="delete from tuser where id_user='".$id."'";	
$update=mysql_query($query_delete);



if($update){
header("location:../../user.php?menu=users");}
else{
header("location:../../user.php?menu=users");}}
?>