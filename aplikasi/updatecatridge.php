<?php
include('../config.php');
if(isset($_POST['tombol'])){
$IdBarang=$_POST['IdBarang'];
$NomorBarang=$_POST['NomorBarang'];
$IsBack=$_POST['IsBack'];
$Id=$_POST['Id'];

$query_update="UPDATE tvalidasi SET IdBarang= '".$IdBarang."',NomorBarang= '".$NomorBarang."',IsBack= '".$IsBack."' WHERE Id='".$Id."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=catridge&stt= Update Berhasil");}
else{
header("location:../user.php?menu=catridge&stt=gagal");}}
?>