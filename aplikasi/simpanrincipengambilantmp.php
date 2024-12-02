<?php
//session_start();
include('../config.php');
if(isset($_POST['idbarang'])&&isset($_POST['idtmp'])){
$kd_barang=$_POST['idbarang'];
$idtmp=$_POST['idtmp'];
$jml=$_POST['jumlah'];
$nama=$_POST['nama'];
$ip=$_POST['ip'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$catOut = $_POST['catOut'];
$catBack = $_POST['catBack'];

$query="SELECT * from tbarang,tkategori where tbarang.idkategori=tkategori.idkategori and  tbarang.idbarang='$kd_barang' ";
$get_data=mysql_query($query);
$found=mysql_num_rows($get_data);
if($found>0){
$data=mysql_fetch_array($get_data);
$idbarang=$data['idbarang'];
$kategori=$data['kategori'];
$namabarang=$data['namabarang'];
$stock=$data['stock'];
$stockbaru=$stock-$jml;


$query_rinci_jual="INSERT INTO tmprinciambil (id,idbarang,namabarang,jumlah,ip,NomorBarang, NomorBarangL)VALUES ('".$idtmp."','".$idbarang."','".$namabarang."','".$jml."','".$ip."','".$catOut."', '".$catBack."') ";
//$insert_rinci_jual=mysql_query($query_rinci_jual);


$query_update="update tbarang set stock='$stockbaru' where idbarang='$kd_barang'";
$query_update_back="update tvalidasi set IsBack ='1' where IdBarang ='$kd_barang' and NomorBarang ='$catBack'";
$query_update_out="update tvalidasi set IsBack ='0' where IdBarang ='$kd_barang' and NomorBarang ='$catOut'";
//$update=mysql_query($query_update);

$query="SELECT * from tvalidasi where IdBarang = '$kd_barang' and  NomorBarang = '$catOut' and IsBack = 1";
$get_data=mysql_query($query);
$data=mysql_num_rows($get_data);

$query_kembali="SELECT * from tvalidasi where IdBarang = '$kd_barang' and  NomorBarang = '$catBack' and IsBack = 0";
$get_data_kembali=mysql_query($query_kembali);
$data_kembali=mysql_num_rows($get_data_kembali);
if($catOut == ""){

	$insert_rinci_jual=mysql_query($query_rinci_jual);
	$update=mysql_query($query_update);
}else{
	if($data == 1 && $data_kembali == 1 )
	{
		$insert_rinci_jual=mysql_query($query_rinci_jual);
		$update=mysql_query($query_update);
		$update_back=mysql_query($query_update_back);
		$update_out=mysql_query($query_update_out);
//echo "<script type='text/javascript'> alert('Barang ditambahkan'); document.location.href='../pemakai.php?menu=ambiltmp'; </script>;";
	}else{
		echo "<script type='text/javascript'> alert('Catridge Tidak tersedia Atau Catridge yang dikembalikan adalah catridge Stock'); document.location.href='../pemakai.php?menu=ambiltmp'; </script>;";
	}

}


if($insert_rinci_jual){
header('location:../pemakai.php?menu=ambiltmp&nama='.$nama.'&bagian='.$bagian.'&divisi='.$divisi);}
else{
echo "Terjadi Kesalahan, Tidak dapat melanjutkan proses";}}
else{
echo "<script type='text/javascript'> alert('Kode Barang Tidak Terdaftar/Stock Habis!'); document.location.href='../pemakai.php?menu=ambiltmp'; </script>;";}}
?>