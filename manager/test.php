<?php

include "../config.php";



$bulan=mysql_query("select * from bulan");



// looping untuk menampilkan nama kategori


while($k=mysql_fetch_array($bulan)){

  echo "<h3>$k[bulan]</h3>";
  

  $barang=mysql_query("select * from tbarang");



  // looping untuk menampilkan judul berita 

  // yang berhubungan dengan kategori masing-masing

  while($b=mysql_fetch_array($barang)){

    echo "<li>$b[namabarang]</li>";

  } // end while looping berita

} // end while looping kategori

?>