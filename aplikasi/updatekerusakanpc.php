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
$model=$_POST['model'];
$seri=$_POST['seri'];
$powersuply=$_POST['powersuply'];
$cassing=$_POST['cassing'];
$tgl_update=$_POST['tgl_update'];

$tgll=substr($tgl_update,-2,2);
$blnn=substr($tgl_update,-5,2);
$thnn=substr($tgl_update,0,4);
$tglupdate=$tgll.'-'.$blnn.'-'.$thnn;


$query_update="UPDATE pcaktif SET seri= '".$seri."',model= '".$model."',tgl_update= '".$tglupdate."',user= '".$user."',divisi= '".$divisi."',bagian= '".$bagian."',idpc= '".$idpc."',namapc= '".$namapc."',subbagian= '".$subbagian."',lokasi= '".$lokasi."',
ippc= '".$ippc."',os= '".$os."',prosesor= '".$prosesor."',mobo= '".$mobo."',monitor= '".$monitor."',ram= '".$ram."',harddisk= '".$harddisk."',
ram1= '".$ram1."',ram2= '".$ram2."',hd1= '".$hd1."',hd2= '".$hd2."',powersuply= '".$powersuply."',cassing= '".$cassing."',dvd= '".$dvd."',bulan= '".$bulan."'
WHERE nomor='".$nomor."'";	


$update=mysql_query($query_update);
//var_dump($query_update);
if($update){
header("location:../user.php?menu=rpemakaipc&stt= Update Berhasil");}
else{
header("location:../user.php?menu=rpemakaipc&stt=gagal");}}
?>