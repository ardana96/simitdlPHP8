<?php
// session_start(); // Memulai session

// // Cek apakah session sudah diset
// if (isset($_SESSION['user']) && isset($_SESSION['akses'])) {
//     echo "Selamat datang, " . $_SESSION['user'];
//     echo "Akses Anda: " . $_SESSION['akses'];
// } else {
//     // Jika tidak ada session, mungkin redirect ke halaman login
//     header("Location: login.php");
//     exit();
// }
?>
 
	 
	 <div class="inner">
                <div class="row">
            
                </div>

  
                <div class="row">
  <div class="col-lg-12">
    <ul class="pricing-table" >
	<li class="col-lg-4">
		
	<h4>PEMASUKAN BARANG</h4>
		<div class="price-body">
			<div class="price">
			<a href="user.php?menu=masuk" >
			<img src='img/troli.png' width=150 height=150>
			</a>
			</div>
		</div>
		<div class="footer">
			<a href="user.php?menu=masuk" class="btn btn-info btn-rect">MASUK</a>
				<!--<a href="http://192.168.1.6/supportapplication"  class="btn btn-info btn-rect">test</a>-->
		</div>
	</li>
	<li class="active danger col-lg-4">
		<h4>PENGELUARAN BARANG</h4>
		<div class="price-body">
			<div class="price">
				<a href="user.php?menu=keluar" >
			<img src='img/pensil.png' width=150 height=150>
			</a>
			</div>
		</div>
		
		<div class="footer">
			<a href="user.php?menu=keluar" class="btn btn-metis-1 btn-lg btn-rect">KELUAR</a>
		</div>
	</li>
	<li class="col-lg-4">
		<h4>DAFTAR STOCK BARANG</h4>
		<div class="price-body">
			<div class="price">
			<a href="#"  onclick="popup_print(7)">
			<img src='img/buku.png' width=150 height=150>
			</a>
			</div>
		</div>
		<div class="footer">
			<a href="#" class="btn btn-info btn-rect" onclick="popup_print(7)">LIHAT</a>
		</div>
	</li>
        	
</ul>
<div class="clearfix"></div>
  </div>
</div>
                              



			
			
			<div class="row">
  <div class="col-lg-12">
    <ul class="pricing-table dark" >
	<li class="col-lg-4">
	<h4>PERAKITAN KOMPUTER</h4>
		<div class="price-body">
			<div class="price">
			<a href="user.php?menu=taperakitan" >
			<img src='img/teknisi.png' width=150 height=150>
			</a>
			</div>
		</div>
		<div class="footer">
			<a href="user.php?menu=taperakitan" class="btn btn-info btn-rect">RAKIT</a>
		</div>
	</li>
	<li class="active primary col-lg-4">
	<h4>SERVICE KOMPUTER</h4>
		<div class="price-body">
			<div class="price">
				<a href="user.php?menu=service" >
			<img src='img/pc.png' width=150 height=150>
			</a>
			</div>
		</div>
		<div class="footer">
			<a href="user.php?menu=stockpc" class="btn btn-metis-1 btn-lg btn-rect">SERVICE</a>
		</div>
	</li>
	<li class="col-lg-4">
		<h4>DAFTAR PEMAKAI KOMPUTER</h4>
		<div class="price-body">
			<div class="price">
				<a href="user.php?menu=rpemakaipc" >
			<img src='img/user.png' width=150 height=150>
			</a>
			</div>
		</div>
		<div class="footer">
			<a href="user.php?menu=rpemakaipc" class="btn btn-info btn-rect">LIHAT</a>
		</div>
	</li>
	
</ul>
<div class="clearfix"></div>
  </div>
</div>


<div class="row">
  <div class="col-lg-12">
    <ul class="pricing-table dark" >
	<li class="active primary col-lg-4">
	<h4>PERAWATAN</h4>
		<div class="price-body">
			<div class="price">
				<a href="user.php?menu=perawatanapp" >
			<img src='img/perawatan.png' width=150 height=150>
			</a>
			</div>
		</div>
		<div class="footer">
			<a href="user.php?menu=perawatanapp" class="btn btn-metis-1 btn-lg btn-rect">PERAWATAN</a>
		</div>
	</li>
	</div>
</div>	
	
</ul>
<div class="clearfix"></div>
  </div>
</div>