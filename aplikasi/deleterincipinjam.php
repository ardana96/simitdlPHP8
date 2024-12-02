<?php
include('../config.php');
if(isset($_POST['tombol'])){
$kd_barang=$_POST['kd_barang'];
$no_faktur=$_POST['no_faktur'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$telp=$_POST['telp'];

$s="select sum(jumlah) as jum from trincipinjam where idbarang='".$kd_barang."' and nopinjam='".$no_faktur."'";
$ss=mysql_query($s);
while($dataa=mysql_fetch_array($ss)){
$jum=$dataa['jum'];}

$b="select * from tbarang where idbarang='".$kd_barang."'";
$bb=mysql_query($b);
while($dataaa=mysql_fetch_array($bb)){
$stock=$dataaa['stock'];}

$stockbaru=$stock+$jum;


$qq="update tbarang set stock='$stockbaru',status='ada' where idbarang='".$kd_barang."'";	
$perintah=mysql_query($qq);

$query_delete="delete from trincipinjam where idbarang='".$kd_barang."' and nopinjam='".$no_faktur."'";	
$update=mysql_query($query_delete);


if($update){
header('location:../pemakai.php?menu=peminjaman&nama='.$nama.'&bagian='.$bagian.'&divisi='.$divisi.'&telp='.$telp);}
else{
header("location:../pemakai.php?menu=peminjaman");}}
?>