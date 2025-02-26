<?php
session_start();
include('config.php'); // Memastikan koneksi ke SQL Server

// 🔹 Cek apakah cookie session tersedia
if (isset($_COOKIE['session_token'])) {
    $session_token = $_COOKIE['session_token'];

    // 🔹 Cari user berdasarkan session token
    $sql = "SELECT * FROM tuser WHERE session_token = ?";
    $query = sqlsrv_query($conn, $sql, array($session_token));

    if ($user = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        // 🔹 Gunakan data user dari database sebagai session aktif
        $status_user = $user['user'];
        $hak_akses = $user['akses'];
    } else {
        // 🔹 Jika tidak ditemukan, redirect ke login
        header("Location: index.php");
        exit();
    }
} else {
    // 🔹 Jika tidak ada session token, redirect ke login
    header("Location: index.php");
    exit();
}

// Set tanggal awal tahun dengan format YYYY-01-01
$tgll = date('Y-01-01');
?>

<?php
// session_start();
// if(!isset($_SESSION['user'])&&!isset($_SESSION['akses'])){
// header('location:index.php');}
// else{
// $status_user=$_SESSION['user'];
// $hak_akses=$_SESSION['akses'];}
// $tanggal = date("20y-m ");
// include('config.php');
// $sql=mysql_query("select * from tuser where user='$status_user'");
// 	if(mysql_num_rows($sql) > 0){
// 				while($data = mysql_fetch_array($sql)){
// 	$file2=$data['file'];
// 	$id_user=$data['id_user'];}}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

 <!-- BEGIN HEAD -->
<head>
     <meta charset="UTF-8" />
    <title>Inventory IT</title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- GLOBAL STYLES -->
    <!-- GLOBAL STYLES -->
	<script src="js/pop_up2.js" type="text/javascript"></script>
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/theme.css" />
    <link rel="stylesheet" href="assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="assets/plugins/Font-Awesome/css/font-awesome.css" />
    <!--END GLOBAL STYLES -->

    <!-- PAGE LEVEL STYLES -->
    <link href="assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- END PAGE LEVEL  STYLES -->
       <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
     <!-- END HEAD -->
     <!-- BEGIN BODY -->
<body class="padTop53 " >
<!--
<font color="white" size=10px><b><marquee scrollamount="20" behavior="right" bgcolor="red">Program Untuk Trial </marquee></b></font>
     <!- MAIN WRAPPER -->
    <div id="wrap">


         <!-- HEADER SECTION -->
        <div id="top">

            <nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;">
                <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
                    <i class="icon-align-justify"></i>
                </a>
                <!-- LOGO SECTION -->
                <header class="navbar-header">

              
                    <img src="assets/img/logo3.png" width=300 height=30 alt=""/>
                </header>
                <!-- END LOGO SECTION -->
                <ul class="nav navbar-top-links navbar-right">

  

           
                  
                </ul>

            </nav>

        </div>
        <!-- END HEADER SECTION -->



        <!-- MENU SECTION -->
       <div id="left">
         

            <ul id="menu" class="collapse">

                
                <li class="panel">
                    <a href="user.php?menu=homeadmin" >
                        <i class="icon-table"></i> Home
	   
                       
                    </a>                   
                </li>



                <li class="panel ">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#component-nav">
                        <i class="icon-tasks"> </i>  Master     
	   
                        <span class="pull-right">
                          <i class="icon-angle-left"></i>
                        </span>
                       &nbsp; <span class="label label-default"></span>&nbsp;
                    </a>
                    <ul class="collapse" id="component-nav">
                       
						<li class=""><a href="user.php?menu=supplier"><i class="icon-angle-right"></i>  Supplier</a></li>
						<li class=""><a href="user.php?menu=kategori"><i class="icon-angle-right"></i>  Kategori</a></li>                        
						<li class=""><a href="user.php?menu=barang"><i class="icon-angle-right"></i>  Barang</a></li>
						<li><a href="user.php?menu=printer"><i class="icon-angle-right"></i>  Printer</a></li>
						<li><a href="user.php?menu=scanner"><i class="icon-angle-right"></i>  Scanner</a></li>
						<li class=""><a href="user.php?menu=divisi"><i class="icon-angle-right"></i> Divisi</a></li>
						<li class=""><a href="user.php?menu=bagian"><i class="icon-angle-right"></i>  Bagian (Pengambilan)</a></li>
						<li class=""><a href="user.php?menu=bagian_pemakai"><i class="icon-angle-right"></i>  Bagian (Perawatan)</a></li>
						<li class=""><a href="user.php?menu=lokasi"><i class="icon-angle-right"></i>  Lokasi</a></li>
						<li class=""><a href="user.php?menu=subbagian"><i class="icon-angle-right"></i>  Sub Bagian</a></li>
						<li class=""><a href="user.php?menu=catridge"><i class="icon-angle-right"></i>  Catridge</a></li>
						<li class=""><a href="user.php?menu=peripheral"><i class="icon-angle-right"></i>  Peripheral</a></li>
                        <li class=""><a href="user.php?menu=perawatan"><i class="icon-angle-right"></i>  Perawatan</a></li>
				    <!--<li class=""><a href="user.php?menu=stockawalth"><i class="icon-angle-right"></i>  Stock Awal Tahun</a></li>-->
             
                    </ul>
                </li>
                <li class="panel ">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#form-nav">
                        <i class="icon-pencil"></i>  Transaksi Barang
	   
                        <span class="pull-right">
                            <i class="icon-angle-left"></i>
                        </span>
                          &nbsp; <span class="label label-success"></span>&nbsp;
                    </a>
                    <ul class="collapse" id="form-nav">
					<li class=""><a href="user.php?menu=masuk"><i class="icon-angle-right"></i>  Barang Masuk</a></li>
							<li class=""><a href="user.php?menu=masukpc"><i class="icon-angle-right"></i>  1Set PC Masuk</a></li>
					<li><a href="user.php?menu=keluar"><i class="icon-angle-right"></i>  Pengeluaran</a></li>
					<li><a href="user.php?menu=returadmin"><i class="icon-angle-right"></i>  Retur Pengeluaran</a></li>
					<li><a href="user.php?menu=returmasuk"><i class="icon-angle-right"></i>  Retur Barang Masuk</a></li>
                        <!--<li class=""><a href="user.php?menu=pembelian"><i class="icon-angle-right"></i>Pembelian</a></li>
			<li><a href="user.php?menu=pengambilan"><i class="icon-angle-right"></i>Pengeluaran </a></li>
			<li><a href="user.php?menu=peminjaman"><i class="icon-angle-right"></i>Peminjaman</a></li>
			<li><a href="user.php?menu=pengembalian"><i class="icon-angle-right"></i>Pengembalian</a></li>-->
                    </ul>
                </li>

                <li class="panel">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#pagesr-nav">
                        <i class="icon-table"></i>  Perakitan
	   
                        <span class="pull-right">
                            <i class="icon-angle-left"></i>
                        </span>
                          &nbsp; <span class="label label-info"></span>&nbsp;
                    </a>
                    <ul class="collapse" id="pagesr-nav">
                        <li><a href="user.php?menu=taperakitan"><i class="icon-angle-right"></i>  Proses Perakitan </a></li>
						<li><a href="user.php?menu=stockpc" style="color: red;"><i class="icon-angle-right"></i> Stock Komputer Show</a> </li>
							<li><a href="user.php?menu=stockpchidden" style="color: red;"><i class="icon-angle-right"></i> Stock Komputer Hidden</a> </li>
<li class=""><a href="user.php?menu=rperakitan" style="color: red;" ><i class="icon-angle-right"></i>  Daftar Perakitan Terpasang</a></li>                   
				   </ul>
                </li>
				 <!--	
				             <li class="panel">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#blank-nav">
                        <i class="icon-check-empty"></i>Service Hardware 
	   
                        <span class="pull-right">
                            <i class="icon-angle-left"></i>
                        </span>
                         &nbsp; <span class="label label-success"></span>&nbsp;
                    </a>
                    <ul class="collapse" id="blank-nav">
                       
                        <li><a href="user.php?menu=service"><i class="icon-angle-right"></i> Service Komputer  </a></li>
	<li><a href="user.php?menu=serviceprinter"><i class="icon-angle-right"></i> Service Printer  </a></li> 
	<li><a href="user.php?menu=servicelain"><i class="icon-angle-right"></i> Service Lainnya  </a></li> 	
					
					
                        <li><a href="user.php?menu=serviceluar"><i class="icon-angle-right"></i> Service Di Luar  </a></li>
                     <li><a href="user.php?menu=riwayat"><i class="icon-angle-right"></i> Riwayat Komputer</a></li>
	  <li><a href="user.php?menu=riwayatprinter"><i class="icon-angle-right"></i> Riwayat Printer</a></li>
	   <li><a href="user.php?menu=riwayatsemua"><i class="icon-angle-right"></i> Riwayat Service Semua</a></li>
					</ul>
                </li>
			
				 <li class="panel">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#error-nav2">
                        <i class="icon-table"></i> Service Printer 
	   
                        <span class="pull-right">
                            <i class="icon-angle-left"></i>
                        </span>
                          &nbsp; <span class="label label-warning"></span>&nbsp;
                    </a>
                    <ul class="collapse" id="error-nav2">
				
					               <li><a href="user.php?menu=inputprinter"><i class="icon-angle-right"></i>Input Excel  </a></li>
                 
                     	  
                    
					</ul>
                </li>  --> 
				 <li class="panel">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#DDL-nav">
                        <i class=" icon-sitemap"></i>  Service Hardware 
	   
                        <span class="pull-right">
                            <i class="icon-angle-left"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="DDL-nav">
                        <li>
                            <a href="#" data-parent="#DDL-nav" data-toggle="collapse" class="accordion-toggle" data-target="#DDL1-nav">
                                <i class="icon-table"></i>&nbsp;  Pilihan Service 
	   
                        <span class="pull-right" style="margin-right: 20px;">
                            <i class="icon-angle-left"></i>
                        </span>


                            </a>
                            <ul class="collapse" id="DDL1-nav">
                                <li><a href="user.php?menu=service"><i class="icon-angle-right"></i>  Service Komputer  </a></li>
	<li><a href="user.php?menu=serviceprinter"><i class="icon-angle-right"></i>  Service Printer  </a></li> 
	<li><a href="user.php?menu=servicelain"><i class="icon-angle-right"></i>  Service Lainnya  </a></li> 	
	  <li><a href="user.php?menu=serviceluar"><i class="icon-angle-right"></i>  Service Di Luar  </a></li>

                            </ul>

                        </li>
                   <li>
                            <a href="#" data-parent="#DDL-nav" data-toggle="collapse" class="accordion-toggle" data-target="#DDL2-nav">
                                <i class="icon-table"></i>&nbsp;  Riwayat Service
	   
                        <span class="pull-right" style="margin-right: 20px;">
                            <i class="icon-angle-left"></i>
                        </span>


                            </a>
                            <ul class="collapse" id="DDL2-nav">
                              <li><a href="user.php?menu=riwayat"><i class="icon-angle-right"></i>  Riwayat Komputer</a></li>
	  <li><a href="user.php?menu=riwayatprinter"><i class="icon-angle-right"></i>  Riwayat Printer</a></li>
	   <li><a href="user.php?menu=riwayatsemua"><i class="icon-angle-right"></i>  Riwayat Service Semua</a></li>

                            </ul>

                        </li>
                   
                    </ul>
                </li>
				  <li class="panel">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#soft-nav">
                        <i class="icon-bar-chart"></i> Software
	   
                        <span class="pull-right">
                            <i class="icon-angle-left"></i>
                        </span>
                      
                    </a>
                    <ul class="collapse" id="soft-nav">



                        <li><a href="user.php?menu=tasoftware"><i class="icon-angle-right"></i> Input Support Software</a></li>
                        <li><a href="user.php?menu=software"><i class="icon-angle-right"></i> Daftar Job Software</a></li>
              
                    </ul>
                </li>
				<li class="panel">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#error-nav">
                        <i class="icon-warning-sign"></i>  Pemakai Komputer
	   
                        <span class="pull-right">
                            <i class="icon-angle-left"></i>
                        </span>
                          &nbsp; <span class="label label-warning"></span>&nbsp;
                    </a>
                    <ul class="collapse" id="error-nav">
                        <li><a href="user.php?menu=rpemakaipc"><i class="icon-angle-right"></i>  Daftar Pemakai PC </a></li>
						<li><a href="user.php?menu=rpemakaipc2"><i class="icon-angle-right"></i>  Daftar Pemakai PC 2 </a></li>
                        <li><a href="user.php?menu=ipcras"><i class="icon-angle-right"></i>  Daftar IP Sama </a></li>
                     
                    </ul>
                </li>
		<li class="panel ">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#form-nav4">
                        <i class="icon-pencil"></i> Permintaan Barang 
	   
                        <span class="pull-right">
                            <i class="icon-angle-left"></i>
                        </span>
                          &nbsp; <span class="label label-success"></span>&nbsp;
                    </a>
                    <ul class="collapse" id="form-nav4">
					<li class=""><a href="user.php?menu=permintaan"><i class="icon-angle-right"></i>Daftar Permintaan Show</a></li>
		<li class=""><a href="user.php?menu=permintaanhidden"><i class="icon-angle-right"></i>Daftar Permintaan Hidden</a></li>
                    </ul>
                </li>		
				       
		
                <li class="panel">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#chart-nav">
                        <i class="icon-bar-chart"></i>  Laporan
	   
                        <span class="pull-right">
                            <i class="icon-angle-left"></i>
                        </span>
                          &nbsp; <span class="label label-danger"></span>&nbsp;
                    </a>
                    <ul class="collapse" id="chart-nav">
                        <li><a href="#" onclick="popup_print(3)"><i class="icon-angle-right"></i>  Pemasukan Barang</a></li>
                        <li><a href="#" onclick="popup_print(5)"><i class="icon-angle-right"></i> Pengambilan Barang</a></li>
                        <li><a href="#" onclick="popup_print(11)"><i class="icon-angle-right"></i>  Peminjaman Barang</a></li>
                        <li><a href="#" onclick="popup_print(12)"><i class="icon-angle-right"></i>  Service Dalam</a></li>
                        <li><a href="#" onclick="popup_print(13)"><i class="icon-angle-right"></i>  Service Luar</a></li>
                        <li><a href="#" onclick="popup_print(20)"><i class="icon-angle-right"></i>  Software</a></li>
        		<!-- <li><a href="#" onclick="popup_print(6)"><i class="icon-angle-right"></i> Peminjaman</a></li>-->
                        <!-- <li><a href="#" onclick="popup_print(9)"><i class="icon-angle-right"></i>  Jadwal Perawatan V1</a></li>
						<li><a href="#" onclick="popup_print(27)"><i class="icon-angle-right"></i>  Jadwal Perawatan V2</a></li> -->
						<li class="">
							<a href="#" data-parent="#chart-nav" data-toggle="collapse" class="accordion-toggle" data-target="#lit-nav">
								<i class="icon-angle-right"></i> <b>Jadwal Perawatan</b>
							   
							</a>
						
						
							<ul class="collapse" id="lit-nav">
								
								<li><a href="#" onclick="popup_print(29)"><i class="icon-angle-right"></i>  PC & Laptop</a></li>
								<li><a href="#" onclick="popup_print(30)"><i class="icon-angle-right"></i>  Printer </a></li>
								<li><a href="#" onclick="popup_print(31)"><i class="icon-angle-right"></i>  Scanner </a></li>
                                <li><a href="#" onclick="popup_print(32)"><i class="icon-angle-right"></i>  Switch / Router </a></li>
                                <li><a href="#" onclick="popup_print(33)"><i class="icon-angle-right"></i>  Kabel Jaringan </a></li>
                                <li><a href="#" onclick="popup_print(34)"><i class="icon-angle-right"></i>  Access Point </a></li>
                                <li><a href="#" onclick="popup_print(35)"><i class="icon-angle-right"></i>  NVR / DVR </a></li>
                                <li><a href="#" onclick="popup_print(36)"><i class="icon-angle-right"></i>  Kamera </a></li>
                                <li><a href="#" onclick="popup_print(37)"><i class="icon-angle-right"></i>  FingerSpot </a></li>
                                <li><a href="#" onclick="popup_print(38)"><i class="icon-angle-right"></i>  Server </a></li>
                                <li><a href="#" onclick="popup_print(39)"><i class="icon-angle-right"></i>  UPS </a></li>
                                <li><a href="#" onclick="popup_print(40)"><i class="icon-angle-right"></i>  Proyektor </a></li>
							</ul>
						
						</li>
                        <li><a href="#" onclick="popup_print(10)"><i class="icon-angle-right"></i>  Daftar Pemakai PC</a></li>
                        <li><a href="#" onclick="popup_print(15)"><i class="icon-angle-right"></i>  Printer</a></li>
                        <li><a href="#" onclick="popup_print(19)"><i class="icon-angle-right"></i> Laptop</a></li>
						<!-- <li><a href="#" onclick="popup_print(28)"><i class="icon-angle-right"></i> Laptop V2</a></li> -->
                        <li><a href="#" onclick="popup_print(16)"><i class="icon-angle-right"></i> Permintaan Barang</a></li>
        	<!--<li class=""><a href="#" onclick="popup_print(7)"><i class="icon-angle-right"></i>  Stock Cetak</a></li>-->
        		        <li class=""><a href="#" onclick="popup_print(17)"><i class="icon-angle-right"></i> Stock Cetak </a></li>
        <!--<li class=""><a href="user.php?menu=stock"><i class="icon-angle-right"></i>Stock Barang</a></li>       
        						 <li><a href="#" onclick="popup_print(4)"><i class="icon-angle-right"></i>  Kartu Stock</a></li> --> 
                        <li><a href="#" onclick="popup_print(18)"><i class="icon-angle-right"></i>  Kartu Stock </a></li>
                        <li><a href="#" onclick="popup_print(25)"><i class="icon-angle-right"></i>  Laporan Pengeluaran </a></li>
						<li><a href="#" onclick="popup_print(26)"><i class="icon-angle-right"></i>  Ceklis CTPAT </a></li>
                   
                    </ul>
                </li>
				
						     
							 	<!--		 <li class="panel">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#lap">
                        <i class=" icon-sitemap"></i> Laporan 
	   
                        <span class="pull-right">
                            <i class="icon-angle-left"></i>
                        </span>
                    </a>
                    <ul class="collapse" id="lap">
                        <li>
                            <a href="#" data-parent="#lap" data-toggle="collapse" class="accordion-toggle" data-target="#lap1">
                                <i class="icon-table"></i>&nbsp;  Barang 
	   
                        <span class="pull-right" style="margin-right: 20px;">
                            <i class="icon-angle-left"></i>
                        </span>


                            </a>
                            <ul class="collapse" id="lap1">
							 <li><a href="#" onclick="popup_print(16)"><i class="icon-angle-right"></i> Permintaan </a></li>
                       <li><a href="#" onclick="popup_print(3)"><i class="icon-angle-right"></i>  Pemasukan </a></li>
	    <li><a href="#" onclick="popup_print(5)"><i class="icon-angle-right"></i> Pengambilan </a></li>
		 <li><a href="#" onclick="popup_print(11)"><i class="icon-angle-right"></i>  Peminjaman </a></li>

                            </ul>

                        </li>
                   <li>
                            <a href="#" data-parent="#lap" data-toggle="collapse" class="accordion-toggle" data-target="#lap2">
                                <i class="icon-table"></i>&nbsp; Service
	   
                        <span class="pull-right" style="margin-right: 20px;">
                            <i class="icon-angle-left"></i>
                        </span>


                            </a>
                            <ul class="collapse" id="lap2">
                           <li><a href="#" onclick="popup_print(12)"><i class="icon-angle-right"></i>  Service Dalam</a></li>
		  <li><a href="#" onclick="popup_print(13)"><i class="icon-angle-right"></i>  Service Luar</a></li>
	

                            </ul>

                        </li>
						<li>
                            <a href="#" data-parent="#lap" data-toggle="collapse" class="accordion-toggle" data-target="#lap4">
                                <i class="icon-table"></i>&nbsp; Pemakai Barang
	   
                        <span class="pull-right" style="margin-right: 20px;">
                            <i class="icon-angle-left"></i>
                        </span>


                            </a>
                            <ul class="collapse" id="lap4">
                           <li><a href="#" onclick="popup_print(10)"><i class="icon-angle-right"></i>  Daftar Pemakai PC</a></li>
	  <li><a href="#" onclick="popup_print(9)"><i class="icon-angle-right"></i>  Jadwal Perawatan</a></li>
	  	      <li><a href="#" onclick="popup_print(15)"><i class="icon-angle-right"></i>  Printer</a></li>

	

                            </ul>

                        </li>
						<li>
                            <a href="#" data-parent="#lap" data-toggle="collapse" class="accordion-toggle" data-target="#lap3">
                                <i class="icon-table"></i>&nbsp; Stock
	   
                        <span class="pull-right" style="margin-right: 20px;">
                            <i class="icon-angle-left"></i>
                        </span>


                            </a>
                            <ul class="collapse" id="lap3">
 	<li class=""><a href="#" onclick="popup_print(7)"><i class="icon-angle-right"></i>  Stock Semua</a></li>
           
						 <li><a href="#" onclick="popup_print(4)"><i class="icon-angle-right"></i>  Kartu Stock</a></li>
	

                            </ul>

                        </li>
						
                   
                    </ul>
                </li>-->


                <?php if ($_SESSION['akses'] == 'super admin') {  ?> 
                <li class="panel">
                    <a href="user.php?menu=users">
                        <i class="icon-user"> </i> User
                    </a>
                </li>
                <?php } ?>		 
	  <li><a href="aplikasi/login_out.php" onclick="return confirm('Terima Kasih telah menggunakan manual guide ini, Yakin Mau Keluar ?')"><i class="icon-signout"></i> Logout </a>
                            </li>




                

            </ul>
<br>

<?php
//if(isset($_GET['menu'])){
//$menu=$_GET['menu'];
//switch($menu){
//case('masuk');include('aplikasi/pmasuk.php');break;
//case('keluar');include('aplikasi/pkeluar.php');break;
//case('taperakitan');include('aplikasi/pperakitan.php');break;
//case('home');include('aplikasi/phome.php');break;
//case('keluarpc');include('aplikasi/ppcbaru.php');break;
//case('stockpc');include('aplikasi/pstockpc.php');break;
//case('rakitupdate');include('aplikasi/prakitupdate.php');break;
//case('service');include('aplikasi/pservice.php');break;
//case('serviceluar');include('aplikasi/pserviceluar.php');break;
//} }
//?>
        </div>
        <!--END MENU SECTION -->


        <!--PAGE CONTENT -->
        <div id="content">
	
<?php
if(isset($_GET['menu'])){
$menu=$_GET['menu'];
switch($menu){
case('catridge');include('aplikasi/catridge.php');break; 
case('supplier');include('aplikasi/supplier.php');break;
case('tasupplier');include('aplikasi/tasupplier.php');break;
case('feditsupp');include('aplikasi/feditsupplier.php');break;
case('tabarang');include('aplikasi/tabarang.php');break;
case('takategori');include('aplikasi/takategori.php');break;
case('kategori');include('aplikasi/kategori.php');break;
case('feditbarang');include('aplikasi/feditbarang.php');break;
case('pembelian');include('aplikasi/pembelian.php');break;
case('stock');include('aplikasi/stock.php');break;
case('returadmin');include('aplikasi/returadmin.php');break;
case('taperakitan');include('aplikasi/taperakitan.php');break;
case('stockpc');include('aplikasi/stockpc.php');break;
case('ambilasesoris');include('aplikasi/ambilasesoris.php');break;
case('contoh');include('aplikasi/contoh.php');break;
case('pengambilan');include('aplikasi/pengambilan.php');break;
case('peminjaman');include('aplikasi/peminjaman.php');break;
case('pengembalian');include('aplikasi/pengembalian.php');break;
case('masuk');include('aplikasi/masuk.php');break;
case('freturmasuk');include('aplikasi/freturmasuk.php');break;
case('returmasuk');include('aplikasi/returmasuk.php');break;
case('masukpc');include('aplikasi/masukpc.php');break;
case('keluar');include('aplikasi/keluar.php');break;
case('permintaanhidden');include('aplikasi/permintaanhidden.php');break;
case('keluarpc');include('aplikasi/keluarpc.php');break;
case('formrakitupdate');include('aplikasi/formrakitupdate.php');break;
case('rakitupdate');include('aplikasi/rakitupdate.php');break;
case('rpemakaipc');include('aplikasi/rpemakaipc.php');break;
case('rpemakaipc2');include('aplikasi/rpemakaipc2.php');break;
case('fupdate_pemakaipc');include('aplikasi/fupdate_pemakaipc.php');break;
case('fupdate_pemakaipc2');include('aplikasi/fupdate_pemakaipc2.php');break;
case('fupdate_kerusakanpc');include('aplikasi/fupdate_kerusakanpc.php');break;
case('fupdate_kerusakanpc2');include('aplikasi/fupdate_kerusakanpc2.php');break;
case('ipcras');include('aplikasi/ipcras.php');break;
case('bagian');include('aplikasi/bagian.php');break;
case('subbagian');include('aplikasi/subbagian.php');break;
case('lokasi');include('aplikasi/lokasi.php');break;
case('editsoftware');include('aplikasi/editsoftware.php');break;
case('tasoftware');include('aplikasi/tasoftware.php');break;
case('freturpengambilanadmin');include('aplikasi/freturpengambilanadmin.php');break;
case('riwayatprinter');include('aplikasi/riwayatprinter.php');break;
case('bagian_pemakai');include('aplikasi/bagian_pemakai.php');break;
case('feditbagian');include('aplikasi/feditbagian.php');break;
case('tabagian');include('aplikasi/tabagian.php');break;
case('tabagian_pemakai');include('aplikasi/tabagian_pemakai.php');break;
case('feditbagian_pemakai');include('aplikasi/feditbagian_pemakai.php');break;
case('homeadmin');include('aplikasi/homeadmin.php');break;
case('service');include('aplikasi/service.php');break;
case('stockpchidden');include('aplikasi/stockpchidden.php');break;
case('serviceluar');include('aplikasi/serviceluar.php');break;
case('riwayat');include('aplikasi/riwayat.php');break;
case('rperakitan');include('aplikasi/rperakitan.php');break;
case('printer');include('aplikasi/printer.php');break;
case('permintaan');include('aplikasi/permintaan.php');break;
case('riwayatsemua');include('aplikasi/riwayatservicesemua.php');break;
case('servicelain');include('aplikasi/servicelain.php');break;
case('inputpc');include('aplikasi/inputpc.php');break;
case('inputpcV2');include('aplikasi/inputpcV2.php');break;
case('fkerusakanprinter');include('aplikasi/fkerusakanprinter.php');break;
case('serviceprinter');include('aplikasi/serviceprinter.php');break;
case('scanner');include('aplikasi/scanner.php');break;
case('software');include('aplikasi/software.php');break;
case('inputprinter');include('aplikasi/inputprinter.php');break;
case('fkerusakanpcbaru');include('aplikasi/fkerusakanpcbaru.php');break;
case('editstockpc');include('aplikasi/editstockpc.php');break;
case('stockawalth');include('aplikasi/stockawalth.php');break;
case('barang'); include('aplikasi/barang.php'); break;
case('peripheral'); include('aplikasi/peripheral.php'); break;
case('divisi'); include('aplikasi/divisi.php'); break;
case('perawatan'); include('aplikasi/perawatan/perawatan.php'); break;
case('perawatanapp'); include('aplikasi/perawatan_app/index.php'); break;
case('users'); include('aplikasi/user/user.php'); break;
} }

?>




        </div>
       <!--END PAGE CONTENT -->


    </div>

     <!--END MAIN WRAPPER -->

   <!-- FOOTER -->
    <div id="footer">
        <p>&copy;  Stock IT &nbsp;2016 &nbsp;</p>
    </div>
    <!--END FOOTER -->
     <!-- GLOBAL SCRIPTS -->
    <script src="assets/plugins/jquery-2.0.3.min.js"></script>
     <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <!-- END GLOBAL SCRIPTS -->
        <!-- PAGE LEVEL SCRIPTS -->
    <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
     <script>
         $(document).ready(function () {
             $('#dataTables-example').dataTable();
         });
    </script>
	
	
	
	
	
	
	
<? 
$date=date('20y-m-d');
?>
<?php
// $user_database="root";
// $password_database="dlris30g";
// $server_database="localhost";
// $nama_database="sitdl";
// $koneksi=mysql_connect($server_database,$user_database,$password_database);
// if(!$koneksi){
// die("Tidak bisa terhubung ke server".mysql_error());}
// $pilih_database=mysql_select_db($nama_database,$koneksi);
// if(!$pilih_database){
// die("Database tidak bisa digunakan".mysql_error());}
?>

<? 
// $sql = mysql_query("SELECT * FROM tbackup where tgl='$date'");
// 						if(mysql_num_rows($sql) == 0){
// //menghapus isi tabel 
// $hapus=mysql_query("delete from tbackup");
// //mengisikan isi tabel 
// $isi=mysql_query("insert into tbackup (tgl) values ('$date')");
				
// 	//membuat nama file
// 	$file='backup.sql';
	
// 	//panggil fungsi dengan memberi parameter untuk koneksi dan nama file untuk backup
// 	backup_tables("localhost","root","","sitdl",$file);

				
// 				}
				
// function backup_tables($host,$user,$pass,$name,$nama_file,$tables = '*')
// {
// 	//untuk koneksi database
// 	$link = mysql_connect($host,$user,$pass);
// 	mysql_select_db($name,$link);
	
// 	if($tables == '*')
// 	{
// 		$tables = array();
// 		$result = mysql_query('SHOW TABLES');
// 		while($row = mysql_fetch_row($result))
// 		{
// 			$tables[] = $row[0];
// 		}
// 	}else{
// 		//jika hanya table-table tertentu
// 		$tables = is_array($tables) ? $tables : explode(',',$tables);
// 	}
	
// 	//looping dulu ah
// 	foreach($tables as $table)
// 	{
// 		$result = mysql_query('SELECT * FROM '.$table);
// 		$num_fields = mysql_num_fields($result);
		
// 		//menyisipkan query drop table untuk nanti hapus table yang lama
// 		$return.= 'DROP TABLE '.$table.';';
// 		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
// 		$return.= "\n\n".$row2[1].";\n\n";
		
// 		for ($i = 0; $i < $num_fields; $i++) 
// 		{
// 			while($row = mysql_fetch_row($result))
// 			{
// 				//menyisipkan query Insert. untuk nanti memasukan data yang lama ketable yang baru dibuat. so toy mode : ON
// 				$return.= 'INSERT INTO '.$table.' VALUES(';
// 				for($j=0; $j<$num_fields; $j++) 
// 				{
// 					//akan menelusuri setiap baris query didalam
// 					$row[$j] = addslashes($row[$j]);
// 					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
// 					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
// 					if ($j<($num_fields-1)) { $return.= ','; }
// 				}
// 				$return.= ");\n";
// 			}
// 		}
// 		$return.="\n\n\n";
// 	}
	
// 	//simpan file di folder yang anda tentukan sendiri. kalo saya sech folder "DATA"
// 	$nama_file;
	
// 	$handle = fopen('./backup/'.$nama_file,'w+');
// 	fwrite($handle,$return);
// 	fclose($handle);
// }

// ?>
     <!-- END PAGE LEVEL SCRIPTS -->
</body>
     <!-- END BODY -->
</html>


