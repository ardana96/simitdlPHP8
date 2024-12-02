<?php
include('../config.php');
$nomor=$_GET['nomor'];
$query="SELECT * from  permintaan WHERE nomor='".$nomor."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$nomor=$hasil['nomor'];
$nama=$hasil['nama'];
$status=$hasil['status'];
$ket=$hasil['ket'];
$qty=$hasil['qty'];
$keterangan=$hasil['keterangan'];

$tgl=$hasil['tgl'];
$bagian=$hasil['bagian'];
$divisi=$hasil['divisi'];
$namabarang=$hasil['namabarang'];



$data=$nomor."&&&".$status."&&&".$ket."&&&".$keterangan."&&&".$qty."&&&".$tgl."&&&".$bagian."&&&".$divisi."&&&".$namabarang."&&&".$nama;
echo $data; ?>