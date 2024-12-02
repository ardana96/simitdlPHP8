<?php
include('../config.php');
if(isset($_POST['tombol'])){
$nopinjam=$_POST['nopinjam'];
$tgl1=$_POST['tgl1'];
$tgl2=$_POST['tgl2'];
$status=$_POST['status'];

$query_update="UPDATE tpinjam SET tgl1= '".$tgl1."' WHERE nopinjam='".$nopinjam."'";
$query_updaterinci="UPDATE trincipinjam SET tgl2= '".$tgl2."',status='".$status."' WHERE nopinjam='".$nopinjam."'";
$update=mysql_query($query_update);	
$updaterinci=mysql_query($query_updaterinci);
if($updaterinci){
header("location:../pemakai.php?menu=daftarpeminjaman&stt= Update Berhasil");}
else{
header("location:../pemakai.php?menu=daftarpeminjaman&stt=gagal");}
}
?>