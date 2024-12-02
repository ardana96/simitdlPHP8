<?php
include('../config.php');
if(isset($_POST['tombol'])){
$idbarang=$_POST['idbarang'];
$nopinjam=$_POST['nopinjam'];
$jumlah=$_POST['jumlah'];
$date=date('20y-m-d');
$jam = date("H:i");


$b="select * from tbarang where idbarang='".$idbarang."'";
$bb=mysql_query($b);
while($dataaa=mysql_fetch_array($bb)){
$stock=$dataaa['stock'];}

//$stockbaru=$stock+$jumlah;


$qq="update tbarang set status='ada' where idbarang='".$idbarang."'";	
$perintah=mysql_query($qq);



$query_update="UPDATE trincipinjam SET tgl2= '".$date."',jam2= '".$jam."',status= 'kembali' WHERE idbarang='".$idbarang."' and nopinjam='".$nopinjam."'";	
$update=mysql_query($query_update);
if($update){
header("location:../pemakai.php?menu=pengembalian&stt= Update Berhasil");}
else{
header("location:../pemakai.php?menu=pengembalian&stt=gagal");}}
?>