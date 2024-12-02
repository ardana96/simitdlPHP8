<?php
include('../config.php');
if(isset($_POST['tombol'])){
//Sumber untuk update spesifikasi 
$nomor=$_POST['nomorup'];
$user=$_POST['userup'];
$divisi=$_POST['divisiup'];
$bagianup=$_POST['bagianup'];
$idpc=$_POST['idpcup'];
$idpcc=$_POST['idpccup'];
$namapc=$_POST['namapcup'];
$ippc=$_POST['ippcup'];
$os=$_POST['osup'];
$prosesor=$_POST['prosesorup'];
$mobo=$_POST['moboup'];
$monitor=$_POST['monitorup'];
$ram=$_POST['ramup'];
$harddisk=$_POST['harddiskup'];
$bulan=$_POST['bulanup'];
$ram1=$_POST['ram1up'];
$ram2=$_POST['ram2up'];
$hd1=$_POST['hd1up'];
$model=$_POST['model'];
$dvd=$_POST['dvdup'];
$noper=$_POST['noper'];
$keterangan=$_POST['keterangan'];
$hd2=$_POST['hd2up'];
$powersuply=$_POST['powersuplyup'];
$cassing=$_POST['cassingup'];
$tgl_update=$_POST['tgl_updateup'];
//Sumber service dalam
$tgl2=$_POST['TglPerbaikan'];
$jam2=$_POST['JamPerbaikan'];
$teknisi=$_POST['TeknisiPerbaikan'];
$tindakan=$_POST['TindakanPerbaikan'];
$nomorkasus=$_POST['nomorkasus'];
$statup=$_POST['statup'];
$tahun=substr($tgl2,-4,4);
$bulan=substr($tgl2,-7,2);
$tanggal=substr($tgl2,0,2);
$tglbaru=$tahun.'-'.$bulan.'-'.$tanggal;
//Sumber Pengambilan 
$nofaktur=$_POST['nofaktur'];
$bagianambil=$_POST['bagianambil'];
//Sumber Pemasukan Barang
$nofakturbeli=$_POST['nofakturbeli'];
$svc_kat = $_POST['svc_kat'];


//simpan pemasukan
$tmasuk = mysql_query("SELECT * FROM trincipembelian where nofaktur='$nofakturbeli' ");
				if(mysql_num_rows($tmasuk) > 0){
$katakata='Hasil Update  /  '.$user.'    /    '.$bagianup.'    /    '.$divisi;
$ppembelian="insert into tpembelian (nofaktur,idsupp,tglbeli,keterangan) 
values ('".$nofakturbeli."','00004','".$tglbaru."','".$katakata."')";		
$pppembelian=mysql_query($ppembelian);
				}



		
//simpan service dalam 
$pservice="UPDATE service set tgl2='".$tgl2."',keterangan='".$keterangan."',statup='".$statup."',jam2='".$jam2."',teknisi='".$teknisi."',tindakan='".$tindakan."'
,status='selesai',ket='D', svc_kat ='".$svc_kat."'  where nomor='".$nomorkasus."' ";	
$ppservice=mysql_query($pservice);		

//simpan pengambilan
$ttt = mysql_query("SELECT * FROM trincipengambilan where nofaktur='$nofaktur' ");
				if(mysql_num_rows($ttt) > 0){
		
$ppengambilan="insert into tpengambilan (nofaktur,jam,tglambil,nama,bagian,divisi) 
values ('".$nofaktur."','".$jam2."','".$tglbaru."','".$user."','".$bagianambil."','".$divisi."')";		
$pppengambilan=mysql_query($ppengambilan);
				}
				
//simpan update spesifikasi
$query_update="UPDATE pcaktif SET model= '".$model."',tgl_update= '".$tgl2."',user= '".$user."',divisi= '".$divisi."',bagian= '".$bagianup."',idpc= '".$idpc."',namapc= '".$namapc."',
ippc= '".$ippc."',os= '".$os."',prosesor= '".$prosesor."',mobo= '".$mobo."',monitor= '".$monitor."',ram= '".$ram."',harddisk= '".$harddisk."',
ram1= '".$ram1."',ram2= '".$ram2."',hd1= '".$hd1."',hd2= '".$hd2."',powersuply= '".$powersuply."',cassing= '".$cassing."',dvd= '".$dvd."'
WHERE nomor='".$nomor."'";	


$update=mysql_query($query_update);

//tambahan untuk permintaan 
if($noper<>"" ){

//$cek=mysql_query("select * from trincipembelian where nofaktur='".$nofakturbeli."'");
	  //while($result=mysql_fetch_array($cek)){
	  //$namabarang=$result['namabarang'];
	  //$jumlah=$result['jumlah'];

	//  $perintah="INSERT INTO rincipermintaan (nomor,nofaktur,namabarang,qtymasuk,tanggal) 
//VALUES ('".$noper."','".$nofakturbeli."','".$namabarang."','".$jumlah."','".$tglbaru."')";
	  //$perintahh=mysql_query($perintah);}
	  
$cekambil=mysql_query("select * from trincipengambilan where nofaktur='".$nofaktur."'");
	  while($resultambil=mysql_fetch_array($cekambil)){
	  $namabarangambil=$resultambil['namabarang'];
	  $jumlahambil=$resultambil['jumlah'];

	  $perintahambil="INSERT INTO rincipermintaan (nomor,nofaktur,namabarang,qtykeluar,tanggal) 
VALUES ('".$noper."','".$nofaktur."','".$namabarangambil."','".$jumlahambil."','".$tglbaru."')";
	  $perintahhambil=mysql_query($perintahambil);}
	  
	$cekkeluar=mysql_query("select sum(qtykeluar) as jumkel from rincipermintaan where nomor='".$noper."'");
	  while($rescekkel=mysql_fetch_array($cekkeluar)){
		  $jumlahkeluar=$rescekkel['jumkel'];	}
		  
$cekjumminta=mysql_query("select qty from permintaan where nomor='".$noper."'");
	  while($resjumminta=mysql_fetch_array($cekjumminta)){
		  $jumlahminta=$resjumminta['qty'];	}

if($jumlahkeluar==$jumlahminta){
$perubahan=mysql_query("update permintaan set status='SELESAI' where nomor='".$noper."'");	
}	  
	 
}

$dd="update trincipengambilan set sesi='' where sesi='ADM'";
$ddd=mysql_query($dd);

if($update){
header("location:../user.php?menu=service&stt= Update Berhasil");}
else{
header("location:../user.php?menu=service&stt=gagal");}}

?>