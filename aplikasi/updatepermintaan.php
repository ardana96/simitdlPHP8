<?php
include('../config.php');
if(isset($_POST['tombol'])){
$nomor=$_POST['nomor'];
$status=$_POST['status'];
$ket=$_POST['ket'];
$qty=$_POST['qty'];
$keterangan=$_POST['keterangan'];

$tgl=$_POST['tgl'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$namabarang=$_POST['namabarang'];

$query_update="UPDATE permintaan SET tgl= '".$tgl."',nama= '".$nama."',bagian= '".$bagian."',divisi= '".$divisi."',namabarang= '".$namabarang."',qty= '".$qty."',status= '".$status."',keterangan= '".$keterangan."',ket= '".$ket."' WHERE nomor='".$nomor."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=permintaan&stt= Update Berhasil");}
else{
header("location:../user.php?menu=permintaan&stt=gagal");}}
?>