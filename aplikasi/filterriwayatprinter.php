<?php
include('../config.php');
$nomor=$_GET['id_user'];
$query="SELECT * from  service WHERE nomor='".$nomor."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);


$nomor		= $hasil['nomor'];
$tgl  		= $hasil['tgl'];
$jam		= $hasil['jam'];
$tgl2		= $hasil['tgl2'];
$tgl3		= $hasil['tgl3'];
$nama		= $hasil['nama'];
$bagian 	= $hasil['bagian'];
$divisi 	= $hasil['divisi'];
$perangkat 	= $hasil['perangkat'];
$kasus 		= $hasil['kasus'];
$penerima 	= $hasil['penerima'];



$data=$nomor."&&&".$jam."&&&".$tgl."&&&".$tgl2."&&&".$tgl3."&&&".$nama."&&&".$bagian."&&&".$divisi."&&&".$perangkat."&&&".$kasus."&&&".$penerima;
echo $data; ?>