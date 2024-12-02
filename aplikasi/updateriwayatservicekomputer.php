<?php
include('../config.php');
if(isset($_POST['tombol'])){
$nomor=$_POST['nomor'];
$tgl=$_POST['tgl'];
$tgl2= $_POST['tgl2'];
$jam=$_POST['jam'];
$nama=$_POST['nama'];
$ippc=$_POST['ippc'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$perangkat = $_POST['perangkat'];
$permasalahan=$_POST['permasalahan'];
$it=$_POST['it'];
$svc_kat = $_POST['svc_kat'];
$tindakan = $_POST['tindakan'];


$query_update="UPDATE service SET tgl= '".$tgl."',jam= '".$jam."',nama= '".$nama."',ippc= '".$ippc."',
			   bagian= '".$bagian."',divisi= '".$divisi."',perangkat= '".$perangkat."',kasus= '".$permasalahan."',penerima= '".$it."',tgl2= '".$tgl2."',svc_kat= '".$svc_kat."' ,tindakan= '".$tindakan."' WHERE nomor='".$nomor."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=riwayat&stt= Update Berhasil");}
else{
header("location:../user.php?menu=riwayat&stt=gagal");}
}
?>