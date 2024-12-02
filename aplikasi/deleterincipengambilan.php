<?php
include('../config.php');
if(isset($_POST['tombol'])){
$kd_barang=$_POST['kd_barang'];
$no_faktur=$_POST['no_faktur'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];


$s="select sum(jumlah) as jum from trincipengambilan where idbarang='".$kd_barang."' and nofaktur='".$no_faktur."'";
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

$query_delete="delete from trincipengambilan where idbarang='".$kd_barang."' and nofaktur='".$no_faktur."'";	
$update=mysql_query($query_delete);


if($update){
header('location:../pemakai.php?menu=pengambilan&nama='.$nama.'&bagian='.$bagian.'&divisi='.$divisi);}
else{
header('location:../pemakai.php?menu=pengambilan&nama='.$nama.'&bagian='.$bagian.'&divisi='.$divisi);}}
?>