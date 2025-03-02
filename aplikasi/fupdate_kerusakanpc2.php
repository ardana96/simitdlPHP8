<script type="text/javascript">

function dontEnter(evt) { 
var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = dontEnter;

</script>
<?php
include('config.php');
?>
<?php

if (isset($_POST['nomor'])) {
    $nomor = $_POST['nomor'];
    $sql = "SELECT * FROM pcaktif WHERE nomor = ?";
    $params = [$nomor];
    $stmt = sqlsrv_query($conn, $sql, $params);

    while ($result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $nomor = $result['nomor'];
        $user = $result['user'];
        $divisi = $result['divisi'];
        $bagian = $result['bagian'];
        $subbagian = $result['subbagian'];
        $lokasi = $result['lokasi'];
        // $id_bulan = $result['id_bulan'];
        // $id_bagian = $result['id_bagian'];
        $idpc = $result['idpc'];
        $ippc = $result['ippc'];
        $os = $result['os'];
        $prosesor = $result['prosesor'];
        $mobo = $result['mobo'];
        $monitor = $result['monitor'];
        $ram = $result['ram'];
        $harddisk = $result['harddisk'];
        $jumlah = $result['jumlah'];
        $tgl_update = $result['tgl_update'];
        $bulan = $result['bulan'];
        $tgl_masuk = $result['tgl_masuk'];
        $ram1 = $result['ram1'];
        $ram2 = $result['ram2'];
        $hd1 = $result['hd1'];
        $hd2 = $result['hd2'];
        $model = $result['model'];
        $namapc = $result['namapc'];
        $powersuply = $result['powersuply'];
        $cassing = $result['cassing'];
        $dvd = $result['dvd'];
        $model = $result['model'];
        $seri = $result['seri'];
    }

    $sql_bulan = "SELECT * FROM bulan WHERE id_bulan = ?";
    $params_bulan = [$bulan];
    $stmt_bulan = sqlsrv_query($conn, $sql_bulan, $params_bulan);

    while ($dataa = sqlsrv_fetch_array($stmt_bulan, SQLSRV_FETCH_ASSOC)) {
        $namabulan = $dataa['bulan'];
    }

    $tgll = substr($tgl_update, 8, 2);
    $blnn = substr($tgl_update, 5, 2);
    $thnn = substr($tgl_update, 0, 4);
    $tglupdate = $thnn . '-' . $blnn . '-' . $tgll;
}


?>


<script language="JavaScript" type="text/javascript" src="suggest.js"></script>
<style>
.isi_tabelll {
border:1px;
	font-size: 14pt; color: black;
	background-color: #FFF;}
</style>

<?php
$datee=date('Y-m-d');
 $jam = date("H:i");
$date=date('Y-m-d');
function kdauto($tabel, $inisial) {
    global $conn; // Pastikan koneksi sqlsrv tersedia

    // Ambil nama kolom pertama dan panjang maksimum kolom
  
    $query_struktur = "
    WITH ColumnInfo AS (
        SELECT 
            COLUMN_NAME,
            ROW_NUMBER() OVER (ORDER BY ORDINAL_POSITION) AS RowNum,
            CHARACTER_MAXIMUM_LENGTH  AS Columnlength
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = ?
    )
    SELECT 
        Columnlength AS TotalColumns,
        COLUMN_NAME AS SecondColumnName
    FROM ColumnInfo
    WHERE RowNum = 2;
    ";
    $params_struktur = array($tabel);
    $stmt_struktur = sqlsrv_query($conn, $query_struktur, $params_struktur);

    if ($stmt_struktur === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $field = null;
    $maxLength = null; // Default jika tidak ditemukan panjang kolom
    if ($row = sqlsrv_fetch_array($stmt_struktur, SQLSRV_FETCH_ASSOC)) {
        $field = $row['SecondColumnName']; // Ambil nama kolom pertama
        $maxLength = $row['TotalColumns'] ?? $maxLength;
    }
    sqlsrv_free_stmt($stmt_struktur);

    if ($field === null) {
        die("Kolom tidak ditemukan pada tabel: $tabel");
    }

    // Ambil nilai maksimum dari kolom tersebut
    $query_max = "SELECT MAX($field) AS maxKode FROM $tabel";
    $stmt_max = sqlsrv_query($conn, $query_max);

    if ($stmt_max === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt_max, SQLSRV_FETCH_ASSOC);

    $angka = 0;
    if (!empty($row['maxKode'])) {
        $angka = (int) substr($row['maxKode'], strlen($inisial));
    }
    $angka++;

    sqlsrv_free_stmt($stmt_max);

    // Tentukan padding berdasarkan panjang kolom
    $padLength = $maxLength - strlen($inisial);
    if ($padLength <= 0) {
        die("Panjang padding tidak valid untuk kolom: $field");
    }

    // Menghasilkan kode baru
    return  $inisial. str_pad($angka, $padLength, "0", STR_PAD_LEFT); // Misalnya SUPP0001
}
$no_faktur=kdauto("tpengambilan",'');
?>

<?php
// $query_rinci_jual="SELECT * FROM trincipengambilan WHERE nofaktur='".$no_faktur."'";
// $get_hitung_rinci=mysql_query($query_rinci_jual);
// $hitung=mysql_num_rows($get_hitung_rinci);
// $total_jual=0; $total_item=0;
// while($hitung_total=mysql_fetch_array($get_hitung_rinci)){
// $jml=$hitung_total['jumlah'];
// $sub_total=$hitung_total['sub_total_jual'];
// $total_jual=$sub_total+$total_jual;
// $total_item=$jml+$total_item;}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
#info_transaksi{
	height: 455px; width: 25%; float: left;
	background-color: #E8E8E8;
	font-family: Arial, Helvetica, sans-serif;}
#info_service{
	height: 455px; width: 25%; float: left;
	background-color: #E8E8E8;
	font-family: Arial, Helvetica, sans-serif;}
#info_user{
	background-color: #CCC;
	height: 450px; width: 20%; float: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt; color: #000;
	font-weight: bold; padding-top: 5px;}

#kalkulator{
	height: 90px; width: 100%; border-bottom-width: 2px;
	border-bottom-color:#933; border-bottom-style:solid;
	padding-left: 10px; padding-top: 10px;}
#scanner{
	height:50px; width: 100%;
	border-bottom-width: 2px; border-bottom-color: #933;
	border-bottom-style: solid;
	padding-top: 10px; padding-left: 10px;}
#button_transaksi{
	height:45px; width: 100%;
	padding-top: 5px; padding-left: 10px;}
#data_barang{
	background-color: white; height: 450px; width:50%;
	float: left; overflow: scroll; padding-top: 5px;}
.td_total{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 25px; font-weight: bold; color: #03F;
	text-decoration: none;}
.td_cash{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 25px; font-weight: bold; color: #FF0;
	text-decoration: none;}
.td_kembali{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 25px; font-weight: bold;
	color: #F00; text-decoration: none;}
.tr_header_footer{
	background-color: #09F;
	font-size: 14px; color: #FFF; font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;}
.tr_isi{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px; color: #000;
	background-color: #FFF;}
</style>

<!-- <script language="javascript">
function onEnter(e){
var key=e.keyCode || e.which;
var kd_barang=document.getElementById('kd_barang').value;
var no_faktur=document.getElementById('no_faktur').value;
if(key==13){
document.location.href="aplikasi/simpanrincipengeluaran.php?kd_barang="+kd_barang+"&no_faktur="+no_faktur;} }
</script> -->
</head>

<body onload="document.getElementById('kd_barang').focus()">
	<h4 align='center'>UPDATE SPESIFIKASI PC</h4>
	<div id="info_transaksi">
    	<form id="form_penjualan"  method="post" action="aplikasi/updatekerusakanpc.php" enctype="multipart/form-data" name="postform2" >
		
		<div class="form-group">
			Tanggal Service <br>
			<input required='required' value=<?php echo $tglupdate; ?> type="text" id="from" name="tgl_update" class="isi_tabel" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;"/><a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;">
	  		<img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0" alt=""></a>
        </div>		
		
		Divisi                                    
        <select class="form-control" name="divisi" required='required'>
			 <option value=<?php echo $divisi; ?> ><?php echo $divisi; ?></option>
			 <option value="AMBASADOR">AMBASADOR</option>
			 <option value="EFRATA">EFRATA</option>
			 <option value="GARMENT">GARMENT</option>
			 <option value="MAS">MAS</option>
			 <option value="TEXTILE">TEXTILE</option>
		</select>											
 		Bagian                                      
        <select class="form-control" name='bagian' required='required'> 
        	<option value=<?php echo $bagian; ?> ><?php echo $bagian; ?></option>
            
			<?php
			$query = "SELECT * FROM bagian_pemakai ORDER BY bag_pemakai ASC";
			$stmt = sqlsrv_query($conn, $query);

			if ($stmt !== false) {
				while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$id_bag_pemakai = $datas['id_bag_pemakai'];
					$bag_pemakai = $datas['bag_pemakai'];
					?>
					<option value="<?php echo $bag_pemakai; ?>"><?php echo $bag_pemakai; ?></option>
					<?php
				}
			} else {
				echo "Error executing query.<br>";
				if (($errors = sqlsrv_errors()) != null) {
					foreach ($errors as $error) {
						echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
						echo "Code: " . $error['code'] . "<br>";
						echo "Message: " . $error['message'] . "<br>";
					}
				}
			}
			?>
        </select>

        Sub Bagian                                      
        <select class="form-control" name='subbagian' required='required'> 
        	<option value="<?php echo $subbagian; ?>" ><?php echo $subbagian; ?></option>
            
			<?php
			$query = "SELECT * FROM sub_bagian ORDER BY subbag_nama ASC";
			$stmt = sqlsrv_query($conn, $query);

			if ($stmt !== false) {
				while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$subbag_id = $datas['subbag_id'];
					$subbag_nama = $datas['subbag_nama'];
					?>
					<option value="<?php echo $subbag_nama; ?>"><?php echo $subbag_nama; ?></option>
					<?php
				}
			} else {
				echo "Error executing query.<br>";
				if (($errors = sqlsrv_errors()) != null) {
					foreach ($errors as $error) {
						echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
						echo "Code: " . $error['code'] . "<br>";
						echo "Message: " . $error['message'] . "<br>";
					}
				}
			}
			?>
        </select>

       Lokasi                                      
        <select class="form-control" name='lokasi' required='required'> 
        	<option value="<?php echo $lokasi; ?>" ><?php echo $lokasi; ?></option>
            
			<?php
			$query = "SELECT * FROM lokasi ORDER BY lokasi_nama ASC";
			$stmt = sqlsrv_query($conn, $query);

			if ($stmt !== false) {
				while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$lokasi_id = $datas['lokasi_id'];
					$lokasi_nama = $datas['lokasi_nama'];
					?>
					<option value="<?php echo $lokasi_nama; ?>"><?php echo $lokasi_nama; ?></option>
					<?php
				}
			} else {
				echo "Error executing query.<br>";
				if (($errors = sqlsrv_errors()) != null) {
					foreach ($errors as $error) {
						echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
						echo "Code: " . $error['code'] . "<br>";
						echo "Message: " . $error['message'] . "<br>";
					}
				}
			}
			?>
        </select>

		User
		<input  class="form-control"  type="text" name="user" value="<?php echo $user; ?>">                         
 		ID Komputer
		<input  class="form-control"  type="text" name="idpc" value="<?php echo $idpc; ?>" >                                  
		Nama Komputer
		<input  class="form-control"  type="text" name="namapc" value="<?php echo $namapc; ?>">   
        <br>
    </div>

	<div style="overflow:scroll;width:600px;height:1200px;" id="data_barang">
       
	                           <div class="panel-body">
						
	
										

   							

	   <div class="form-group">
 <b>Operation System</b>         
        <input  class="form-control"  type="text" name="os" value="<?php echo $os; ?>" >
                                        
                                    
                                        </div>	
											   <div class="form-group">
 <b>IP Komputer</b>         
        <input    class="form-control"  type="text" name="ippc"  value="<?php echo $ippc; ?>">
                                        
                                    
                                        </div>
						
	                                       <div class="form-group">
 <b>Total Kapasitas Harddsik</b>         
        <input  class="form-control"  type="text" name="harddisk" value="<?php echo $harddisk; ?>">
                                        </div>
                                    
 
	   <div class="form-group">
 <b>Total Kapasitas RAM</b>         
        <input   class="form-control"  type="text" name="ram" value="<?php echo $ram; ?>">
                                        
                                    
                                        </div>		
<!--Titit Mulai untuk Case -->
<?php if($model=="CPU"){?>
<div class="form-group">
 <b>Monitor</b><font color=red>Tidak Mengurangi Stock Hanya Merubah Nama</font>          
    <select class="form-control" name='monitor'>
		<option value="<?php echo $monitor; ?>"> <?php echo $monitor; ?></option>

		<?php
		$sql = "SELECT * FROM tbarang WHERE idkategori = ?";
		$params = ['00009'];
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ($stmt !== false) {
			while ($datamonitor = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				$idbarangmonitor = $datamonitor['idbarang'];
				$namabarangmonitor = $datamonitor['namabarang'];
				?>
				<option value="<?php echo $namabarangmonitor; ?>"> <?php echo $namabarangmonitor; ?> </option>
				<?php
			}
		}
		?>
	</select>

                                        
                                    
</div>
											
<b>Model</b>                                    
       <select class="form-control" name="model" required='required'>
 <option value=<?php echo $model; ?> ><?php echo $model; ?></option>
 <option value="cpu">CPU</option>
 <option value="laptop">LAPTOP</option>
</select>

  <div class="form-group">
 <b>RAM Slot 1</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
      <select class="form-control" name='ram1' >
	  <option value="<?php echo $ram1; ?>"> <?php echo $ram1; ?></option>
            
	  		<?php
			// Query untuk mengambil data dari tabel tbarang
			$query = "SELECT * FROM tbarang WHERE idkategori = '00006' AND stock > 0";
			$result = sqlsrv_query($conn, $query); // Eksekusi query menggunakan sqlsrv_query

			// Periksa apakah query berhasil
			if ($result === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Iterasi data hasil query
			while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
			?>
				<option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
			<?php } ?>
			
    
        </select> 
                                        
                                    
                                        </div>

		  <div class="form-group">
 <b>RAM Slot 2</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
      <select class="form-control" name='ram2' >
	  <option value="<?php echo $ram2; ?>" ><?php echo $ram2; ?> </option>
            
	  		<?php
			// Query untuk mengambil data dari tabel tbarang
			$query = "SELECT * FROM tbarang WHERE idkategori = '00006' AND stock > 0";
			$result = sqlsrv_query($conn, $query); // Eksekusi query menggunakan sqlsrv_query

			// Periksa apakah query berhasil
			if ($result === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Iterasi data hasil query
			while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
			?>
				<option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
			<?php } ?>
			
    
        </select> 
                                        
                                    
                                        </div>

   <div class="form-group">
 <b>Harddisk Slot 1</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
      <select class="form-control" name='hd1' >
	  <option value="<?php echo $hd1; ?>"><?php echo $hd1; ?> </option>
            
	  		<?php
			// Query untuk mengambil data dari tabel tbarang
			$query = "SELECT * FROM tbarang WHERE idkategori = '00005' AND stock > 0";
			$result = sqlsrv_query($conn, $query); // Eksekusi query menggunakan sqlsrv_query

			// Periksa apakah query berhasil
			if ($result === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Iterasi data hasil query
			while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
			?>
				<option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
			<?php } ?>
			
    
        </select> 
                                        
                                    
                                        </div>

  <div class="form-group">
 <b>Harddisk Slot 2</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
      <select class="form-control" name='hd2' >
	  <option value="<?php echo $hd2; ?>" ><?php echo $hd2; ?> </option>
            
	  		<?php
			// Query untuk mengambil data dari tabel tbarang
			$query = "SELECT * FROM tbarang WHERE idkategori = '00005' AND stock > 0";
			$result = sqlsrv_query($conn, $query); // Eksekusi query menggunakan sqlsrv_query

			// Periksa apakah query berhasil
			if ($result === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Iterasi data hasil query
			while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
			?>
				<option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
			<?php } ?>
			
    
        </select> 
                                        
                                    
                                        </div>										
	
<div class="form-group">
 <b>Motherboard </b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>         
      <select class="form-control" name='mobo' >	
	  <option value="<?php echo $mobo; ?>"><?php echo $mobo; ?> </option>
            
	  <?php
    // Query untuk mengambil data dari tabel tbarang
		$query = "SELECT * FROM tbarang WHERE idkategori = '00001' AND stock > 0";
		$result = sqlsrv_query($conn, $query); // Eksekusi query menggunakan sqlsrv_query

		// Periksa apakah query berhasil
		if ($result === false) {
			die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
		}

		// Iterasi data hasil query
		while ($datas1 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$idbarang = $datas1['idbarang'];
			$namabarang = $datas1['namabarang'];
			$stock = $datas1['stock'];
		?>
			<option value="<?php echo $idbarang; ?>"><?php echo $namabarang; ?></option>
		<?php } ?>
			
    
        </select> 
                                        
                                    
                                        </div>

 <div class="form-group">
 <b>Prosesor</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
      <select class="form-control" name='prosesor'>
	  <option value="<?php echo $prosesor; ?>"><?php echo $prosesor; ?> </option>
            
	  	<?php
		// Query untuk mengambil data dari tabel tbarang
		$query = "SELECT * FROM tbarang WHERE idkategori = '00002' AND stock > 0";
		$result = sqlsrv_query($conn, $query); // Eksekusi query menggunakan sqlsrv_query

		// Periksa apakah query berhasil
		if ($result === false) {
			die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
		}

		// Iterasi data hasil query
		while ($datas2 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$idbarang2 = $datas2['idbarang'];
			$namabarang2 = $datas2['namabarang'];
		?>
			<option value="<?php echo $idbarang2; ?>"><?php echo $namabarang2; ?></option>
		<?php } ?>
			
    
        </select> 
                                        
                                    
                                        </div>
 
   <div class="form-group">
 <b>Power Supply</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
      <select class="form-control" name='powersuply'>
	  <option value="<?php echo $powersuply; ?>"><?php echo $powersuply; ?> </option>
            
			<?php
			// Query untuk mengambil data dari tabel tbarang
			$query = "SELECT * FROM tbarang WHERE idkategori = '00003' AND stock > 0";
			$result = sqlsrv_query($conn, $query); // Eksekusi query menggunakan sqlsrv_query

			// Periksa apakah query berhasil
			if ($result === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Iterasi data hasil query
			while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
			?>
				<option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
			<?php } ?>
			
    
        </select> 
                                        
                                    
                                        </div>

   <div class="form-group">
 <b>Cassing</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
      <select class="form-control" name='cassing' >
	  <option value="<?php echo $cassing; ?>"><?php echo $cassing; ?> </option>
            
	  	<?php
			// Query untuk mengambil data dari tabel tbarang
			$query = "SELECT * FROM tbarang WHERE idkategori = '00004' AND stock > 0";
			$result = sqlsrv_query($conn, $query); // Eksekusi query menggunakan sqlsrv_query

			// Periksa apakah query berhasil
			if ($result === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Iterasi data hasil query
			while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
			?>
				<option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
		<?php } ?>
			
    
        </select> 
                                        
                                    
                                        </div>

	<div class="form-group">
 <b>DVD Internal</b> <font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>         
      <select class="form-control" name='dvd' >
	  <option value="<?php echo $dvd; ?>" ><?php echo $dvd; ?> </option>
            
	  	<?php
			// Query untuk mengambil data dari tabel tbarang
			$query = "SELECT * FROM tbarang WHERE idkategori = '00008' AND stock > 0";
			$result = sqlsrv_query($conn, $query); // Eksekusi query menggunakan sqlsrv_query

			// Periksa apakah query berhasil
			if ($result === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Iterasi data hasil query
			while ($datas3 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
			?>
				<option value="<?php echo $idbarang3; ?>"><?php echo $namabarang3; ?></option>
		<?php } ?>
			
    
        </select> 
                                        
                                    
                                        </div>
<?php }else{ ?>


<div class="form-group">
 <b>Seri</b><font color=red>Tidak Mengurangi Stock Hanya Merubah Nama</font>          
         <input  class="form-control"  type="text" name="seri" value="<?php echo $seri; ?>">
                                        
                                    
                                        </div>




<div class="form-group">
 <b>Monitor</b><font color=red>Tidak Mengurangi Stock Hanya Merubah Nama</font>          
         <input  class="form-control"  type="text" name="monitor" value="<?php echo $monitor; ?>">
                                        
                                    
                                        </div>
											
<b>Model</b>                                    
       <select class="form-control" name="model" required='required'>
 <option value=<?php echo $model; ?> ><?php echo $model; ?></option>
 <option value="cpu">CPU</option>
 <option value="laptop">LAPTOP</option>
</select>

  <div class="form-group">
 <b>RAM Slot 1</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
        <input  class="form-control"  type="text" name="ram1" value="<?php echo $ram1; ?>">
                                        
                                    
                                        </div>

		  <div class="form-group">
 <b>RAM Slot 2</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
         <input  class="form-control"  type="text" name="ram2" value="<?php echo $ram2; ?>">
                                        
                                    
                                        </div>

   <div class="form-group">
 <b>Harddisk Slot 1</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
         <input  class="form-control"  type="text" name="hd1" value="<?php echo $hd1; ?>">
                                        
                                    
                                        </div>

  <div class="form-group">
 <b>Harddisk Slot 2</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
        <input  class="form-control"  type="text" name="hd2" value="<?php echo $hd2; ?>">
                                        
                                    
                                        </div>										
	
	   <div class="form-group">
 <b>Motherboard </b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>         
       <input  class="form-control"  type="text" name="mobo" value="<?php echo $mobo; ?>">
                                        
                                    
                                        </div>

 <div class="form-group">
 <b>Prosesor</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
         <input  class="form-control"  type="text" name="prosesor" value="<?php echo $prosesor; ?>">
                                        
                                    
                                        </div>
 
   <div class="form-group">
 <b>Power Supply</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
        <input  class="form-control"  type="text" name="powersuply" value="<?php echo $powersuply; ?>">
                                        
                                    
                                        </div>

   <div class="form-group">
 <b>Cassing</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
         <input  class="form-control"  type="text" name="cassing" value="<?php echo $cassing; ?>">
                                        
                                    
                                        </div>

	<div class="form-group">
 <b>DVD Internal</b> <font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>         
         <input  class="form-control"  type="text" name="dvd" value="<?php echo $dvd; ?>"> 
                                        
                                    
                                        </div>
										
<?php }?>
<!-- Titik Akhir untuk Case -->
<!--										 <div class="form-group">
 Bulan Perawatan         
      <input readonly class="form-control"  type="text" name="bulan" value="<?php echo $namabulan; ?>" >    


                                        
                                    
                                        </div> -->
	<div  class="form-group">
		Bulan Perawatan                                      
        <select class="form-control" name='bulan' required='required'>
			<option value="<?php echo $bulan; ?>"><?php echo $namabulan; ?></option>

			<?php
			$sql = "SELECT * FROM bulan ORDER BY id_bulan ASC";
			$stmt = sqlsrv_query($conn, $sql);

			if ($stmt !== false) {
				while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$id_bulan = $datas['id_bulan'];
					$bulan = $datas['bulan'];
					?>
					<option value="<?php echo $id_bulan; ?>"><?php echo $bulan; ?></option>
					<?php
				}
			}
			?>
		</select>

	
	
	</div>
	
										
   <input  class="form-control"  type="hidden" name="nomor" value="<? echo $nomor; ?>" >
 <button  name="tombol" id="button_selesai" class="btn text-muted text-center btn-danger" type="submit">Simpan</button>


									
       
			 </td>

                                    </form>
									<br>
									
                            </div>

	   
</div>
  


  
</body>
</html>
<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>
           
		    