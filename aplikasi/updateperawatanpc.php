<?php
include('../config.php');
if(isset($_POST['tombol'])){
$nomor=$_POST['nomor'];
$user=$_POST['user'];
$divisi=$_POST['divisi'];
$bagian=$_POST['bagian'];
$subbagian=$_POST['subbagian'];
$lokasi = $_POST['lokasi'];
$idpc=$_POST['idpc'];
$idpcc=$_POST['idpcc'];
$namapc=$_POST['namapc'];
$ippc=$_POST['ippc'];
$os=$_POST['os'];
$prosesor=$_POST['prosesor'];
$mobo=$_POST['mobo'];
$monitor=$_POST['monitor'];
$ram=$_POST['ram'];
$harddisk=$_POST['harddisk'];
$bulan=$_POST['bulan'];
$ram1=$_POST['ram1'];
$ram2=$_POST['ram2'];
$hd1=$_POST['hd1'];
$dvd=$_POST['dvd'];
$hd2=$_POST['hd2'];
$powersuply=$_POST['powersuply'];
$cassing=$_POST['cassing'];
$tgl_perawatan=$_POST['tgl_perawatan'];


$query_update="UPDATE pcaktif SET tgl_perawatan= '".$tgl_perawatan."',user= '".$user."',idpc= '".$idpc."',
namapc= '".$namapc."',bulan= '".$bulan."',bagian= '".$bagian."',subbagian= '".$subbagian."',lokasi= '".$lokasi."'
WHERE nomor='".$nomor."'";	


$update=mysql_query($query_update);

if($update){
header("location:../user.php?menu=rpemakaipc&stt= Update Berhasil");}
else{
header("location:../user.php?menu=rpemakaipc&stt=gagal");}}
?>