<?php
include('../config.php');
if(isset($_POST['tombol'])){
$nomor=$_POST['nomor'];
$tgl=$_POST['tgl'];
$tgl2=$_POST['tgl2'];
$tgl3=$_POST['tgl3'];
$jam=$_POST['jam'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$perangkat = $_POST['perangkat'];
$permasalahan=$_POST['permasalahan'];
$it=$_POST['it'];


$query_update="UPDATE service SET tgl= '".$tgl."',tgl2= '".$tgl2."',tgl3= '".$tgl3."',jam= '".$jam."',nama= '".$nama."',
			   bagian= '".$bagian."',divisi= '".$divisi."',perangkat= '".$perangkat."',kasus= '".$permasalahan."',penerima= '".$it."' WHERE nomor='".$nomor."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=riwayatprinter&stt= Update Berhasil");}
else{
header("location:../user.php?menu=riwayatprinter&stt=gagal");}
}
?>