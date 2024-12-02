<?php
include('../config.php');
if(isset($_POST['tombol'])){
$nomor=$_POST['nomor'];
$tgl=$_POST['tgl'];
$tgl2=$_POST['tgl2'];
$tgl3=$_POST['tgl3'];


$query_update="UPDATE service SET tgl= '".$tgl."',tgl2= '".$tgl2."',tgl3= '".$tgl3."' WHERE nomor='".$nomor."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=riwayatsemua&stt= Update Berhasil");}
else{
header("location:../user.php?menu=riwayatsemua&stt=gagal");}
}
?>