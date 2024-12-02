<?
// $pathAwal = "C:/xampp/htdocs/simit/backup/backup.sql";
// $pathTujuan = "D:/backupsimit/backup.sql";
// copy($pathAwal, $pathTujuan);  
?>
<?
// $pathAwal2 = "C:/xampp/htdocs/simit/backup/backup.sql";
// $pathTujuan2 = "D:/backupsimit/data/backup.sql";
// copy($pathAwal2, $pathTujuan2);  
?>
<?
include('config.php');
$tgll=date('20y-01-01');

//$l=mysql_query("Select * from stockth where blnth='$tgll'");
//if(mysql_num_rows($l) > 0){}
//else{
//$ll=mysql_query("Select * from tbarang ");	
//if(mysql_num_rows($ll) > 0){
//while($datall = mysql_fetch_array($ll)){
//$idbarang=$datall['idbarang'];
//$stock=$datall['stock'];

//$lll=mysql_query("insert into stockth (idbarang,blnth,stocka) values ('$idbarang','$tgll','$stock')");	
//}
//}}





?>
<?php
//session_start();
//if(!isset($_SESSION['user'])&&!isset($_SESSION['akses'])){
//header('location:index.php');}
//else{
//$status_user=$_SESSION['user'];
//$hak_akses=$_SESSION['akses'];}
//$tanggal = date("20y-m ");
//include('config.php');
//$sql=mysql_query("select * from tuser where user='$status_user'");
	//if(mysql_num_rows($sql) > 0){
		//		while($data = mysql_fetch_array($sql)){
	//$file2=$data['file'];
	//$id_user=$data['id_user'];}}
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
	<script src="js/pop_up.js" type="text/javascript"></script>
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

     <!-- MAIN WRAPPER -->
    <div id="wrap">


         <!-- HEADER SECTION -->
        <div id="top">

            <nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;">
                <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
                    <i class="icon-align-justify"></i>
                </a>
                <!-- LOGO SECTION -->
                <header class="navbar-header">

                
                    <img src="assets/img/logo3.png" alt="" width='300' height='30'/>
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
                    <a href="pemakai.php?menu=home" >
                        <i class="icon-table"></i> Beranda
	   
                       
                    </a>                   
                </li>


 <!--<li><a href="pemakai.php?menu=pengambilan" ><i class="icon-tasks"></i>  Pengambilan</a>
                            </li>-->
							<li><a href="pemakai.php?menu=ambiltmp" ><i class="icon-tasks"></i>  Pengambilan</a>
                            </li>
 <li><a href="pemakai.php?menu=peminjaman" ><i class="icon-pencil"></i>  Peminjaman</a>
                            </li>
 <li><a href="pemakai.php?menu=pengembalian" ><i class="icon-table"></i>  Pengembalian</a>
                            </li>       
<li><a href="pemakai.php?menu=booking" ><i class="icon-pencil"></i> Daftar Booking</a>
<li><a href="pemakai.php?menu=daftarpeminjaman" ><i class="icon-pencil"></i> Daftar Peminjaman</a>
 <li><a href="pemakai.php?menu=retur" ><i class="icon-tasks"></i>  Retur Pengambilan</a>
                            </li>
	  <li><a href="aplikasi/login_out.php" onclick="return confirm('Terima Kasih telah menggunakan manual guide ini, Yakin Mau Keluar ?')"><i class="icon-signout"></i> Logout </a>
                            </li>




                

            </ul>
			<br>
<?php
//if(isset($_GET['menu'])){
//$menu=$_GET['menu'];
//switch($menu){
//case('pengambilan');include('aplikasi/ppengambilan.php');break;
//case('peminjaman');include('aplikasi/ppeminjaman.php');break;
//case('pengembalian');include('aplikasi/ppengembalian.php');break;
//case('home');include('aplikasi/phome.php');break;
//} }
?>
        </div>
        <!--END MENU SECTION -->


        <!--PAGE CONTENT -->
        <div id="content">

		<?php
if(isset($_GET['menu'])){
$menu=$_GET['menu'];
switch($menu){
case('pengambilan');include('aplikasi/pengambilan.php');break;
case('peminjaman');include('aplikasi/peminjaman.php');break;
case('retur');include('aplikasi/retur.php');break;
case('ambiltmp');include('aplikasi/ambiltmp.php');break;
case('freturpengambilan');include('aplikasi/freturpengambilan.php');break;
case('pengembalian');include('aplikasi/pengembalian.php');break;
case('home');include('aplikasi/home.php');break;
case('daftarpeminjaman');include('aplikasi/daftarpeminjaman.php');break;
case('tabooking');include('aplikasi/tabooking.php');break;
case('booking');include('aplikasi/booking.php');break;
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
     <!-- END PAGE LEVEL SCRIPTS -->
	 
	 
	 
	 
	 
	 	
<? 
$date=date('20y-m-d');
?>
<?php
$user_database="root";
$password_database="dlris30g";
$server_database="localhost";
$nama_database="sitdl";
$koneksi=mysql_connect($server_database,$user_database,$password_database);
if(!$koneksi){
die("Tidak bisa terhubung ke server".mysql_error());}
$pilih_database=mysql_select_db($nama_database,$koneksi);
if(!$pilih_database){
die("Database tidak bisa digunakan".mysql_error());}
?>

<? 
$sql = mysql_query("SELECT * FROM tbackup where tgl='$date'");
						if(mysql_num_rows($sql) == 0){
//menghapus isi tabel 
$hapus=mysql_query("delete from tbackup");
//mengisikan isi tabel 
$isi=mysql_query("insert into tbackup (tgl) values ('$date')");
				
	//membuat nama file
	$file='backup.sql';
	
	//panggil fungsi dengan memberi parameter untuk koneksi dan nama file untuk backup
	backup_tables("localhost","root","","sitdl",$file);

				
				}
				
function backup_tables($host,$user,$pass,$name,$nama_file,$tables = '*')
{
	//untuk koneksi database
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}else{
		//jika hanya table-table tertentu
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//looping dulu ah
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		//menyisipkan query drop table untuk nanti hapus table yang lama
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				//menyisipkan query Insert. untuk nanti memasukan data yang lama ketable yang baru dibuat. so toy mode : ON
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					//akan menelusuri setiap baris query didalam
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//simpan file di folder yang anda tentukan sendiri. kalo saya sech folder "DATA"
	$nama_file;
	
	$handle = fopen('./backup/'.$nama_file,'w+');
	fwrite($handle,$return);
	fclose($handle);
}

?>
</body>
     <!-- END BODY -->
</html>
