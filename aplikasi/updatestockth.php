<?php
include('../config.php');
if(isset($_POST['tombol'])){
$idbarang=$_POST['idbarang'];
$blnth=$_POST['blnth'];
$stocka=$_POST['stocka'];


$query_update="UPDATE stockth SET stocka= '".$stocka."'
 WHERE idbarang='".$idbarang."' and blnth='".$blnth."' ";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=stockawalth&stt= Update Berhasil");}
else{
header("location:../user.php?menu=stockawalth&stt=gagal");}}
?>