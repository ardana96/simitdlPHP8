<?php
include('../config.php');
if(isset($_POST['tombol'])){
$kd_barang=$_POST['kd_barang'];
$ip=$_POST['ip'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$nomorbarang = $_POST['nomorbarang'];
$nomorbarangL = $_POST['nomorbarangL'];


$s="select sum(jumlah) as jum from tmprinciambil where idbarang='".$kd_barang."' and ip='".$ip."'";
$ss=mysql_query($s);
while($dataa=mysql_fetch_array($ss)){
$jum=$dataa['jum'];}

$b="select * from tbarang where idbarang='".$kd_barang."'";
$bb=mysql_query($b);
while($dataaa=mysql_fetch_array($bb)){
$stock=$dataaa['stock'];}

$stockbaru=$stock+$jum;



$qq="update tbarang set stock='$stockbaru' where idbarang='".$kd_barang."'";	
$perintah=mysql_query($qq);

$query_update_validasi = "update tvalidasi set IsBack ='1' where IdBarang ='$kd_barang' and NomorBarang ='$nomorbarang'";
$update_validasi = mysql_query($query_update_validasi);

$query_update_validasi_L = "update tvalidasi set IsBack ='0' where IdBarang ='$kd_barang' and NomorBarang ='$nomorbarangL'";
$update_validasi_L = mysql_query($query_update_validasi_L);

$query_delete="delete from tmprinciambil where idbarang='".$kd_barang."' and ip='".$ip."'";	
$update=mysql_query($query_delete);






if($update){
header('location:../pemakai.php?menu=ambiltmp&nama='.$nama.'&bagian='.$bagian.'&divisi='.$divisi);}
else{
header('location:../pemakai.php?menu=ambiltmp&nama='.$nama.'&bagian='.$bagian.'&divisi='.$divisi);}}
?>