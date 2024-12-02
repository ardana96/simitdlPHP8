<?php
include('../config.php');
$idbarang=$_GET['idbarang'];
$query="SELECT * from  tbarang,tkategori WHERE tbarang.idkategori=tkategori.idkategori and tbarang.idbarang='".$idbarang."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$namabarang=$hasil['namabarang'];
$kategori=$hasil['kategori'];

$data=$namabarang."&&&".$kategori."&&&".$namabarang;
echo $data; ?>