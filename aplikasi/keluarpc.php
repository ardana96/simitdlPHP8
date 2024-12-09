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
if(isset($_POST['idpc'])){
	$idpcc = $_POST['idpc'];

	// Query untuk mendapatkan data dari tabel tpc
	$query = "SELECT * FROM tpc WHERE idpc = ?";
	$params = array($idpcc);
	$stmt = sqlsrv_query($conn, $query, $params);

	// Validasi apakah query berhasil
	if ($stmt === false) {
		die(print_r(sqlsrv_errors(), true));
	}

	// Iterasi hasil query
	while ($result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
		$idpc = $result['idpc'];
		$mobo = $result['mobo'];
		$prosesor = $result['prosesor'];
		$ps = $result['ps'];
		$casing = $result['casing'];
		$hd1 = $result['hd1'];
		$ram1 = $result['ram1'];
		$ram2 = $result['ram2'];
		$hd2 = $result['hd2'];
		$fan = $result['fan'];
		$dvd = $result['dvd'];
		$model = $result['model'];
		$seri = $result['seri'];
	}
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
$datee=date('20y-m-d');
 $jam = date("H:i");
$date=date('ymd');
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
$query_rinci_jual = "SELECT * FROM trincipengambilan WHERE nofaktur = ?";
$params = array($no_faktur);
$stmt = sqlsrv_query($conn, $query_rinci_jual, $params);

// Validasi apakah query berhasil
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Menghitung jumlah baris
$hitung = 0;
$total_jual = 0;
$total_item = 0;

// Iterasi hasil query
while ($hitung_total = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $jml = $hitung_total['jumlah'];
    //$sub_total = $hitung_total['sub_total_jual'];
    //$total_jual += $sub_total;
    $total_item += $jml;
    $hitung++;
}

// Bebaskan statement
sqlsrv_free_stmt($stmt);

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

<script language="javascript">
function onEnter(e){
var key=e.keyCode || e.which;
var kd_barang=document.getElementById('kd_barang').value;
var no_faktur=document.getElementById('no_faktur').value;
if(key==13){
document.location.href="aplikasi/simpanrincipengeluaran.php?kd_barang="+kd_barang+"&no_faktur="+no_faktur;} }
</script>
</head>

<body onload="document.getElementById('kd_barang').focus()">
<h4 align='center'>PENGELUARAN KOMPUTER BARU </h4>
<div id="info_transaksi">



      <form id="form_penjualan" name="form_penjualan" method="post" action="aplikasi/simpankeluarpc.php" >
Nomor
		
                                            
                                            <input  readonly class="form-control"  type="text" name="nomor" value="<?php echo kdauto("pcaktif",""); ?>" >
                       
Permintaan Dari                                     
       

		<select class="form-control" name='nomorminta' >
			<option selected="selected" ></option>

			<?php
			// Query untuk mengambil data dari tabel 'permintaan'
			$query = "SELECT * FROM permintaan WHERE status <> 'selesai' ORDER BY nama";
			$stmt = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($stmt !== false) {
				while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$nomor = $row['nomor'];
					$keterangan = $row['keterangan'];
					$tgllll = $row['tgl']->format('Y-m-d'); // Konversi DateTime ke format string
					// $t = substr($tgllll, 0, 4);
					// $b = substr($tgllll, 5, 2);
					// $h = substr($tgllll, 8, 2);
					// $tglllll = $h . '-' . $b . '-' . $t;
					$bagian = $row['bagian'];
					$nama = $row['nama'];
					$qty = $row['qty'];
					$sisa = $row['sisa'];
					$namabarang = $row['namabarang'];
					$divisi = $row['divisi'];
			?>
					<option value="<?php echo $nomor; ?>">
						<?php echo $nama . '/' . $bagian . '/' . $divisi . '/' . $namabarang . '/' . $keterangan . '/' . $tgllll . '/JUM:' . $qty . '/SISA:' . $sisa; ?>
					</option>
			<?php
				}
			} else {
				echo "<option>Error fetching data</option>";
			}
			?>

		</select>
		
		 <select class="form-control" name='noper' style='display:none;'>
            <option selected="selected" value="<?php echo $nopeminta; ?>"><?php echo $nmpeminta; ?></option>
    
                <?php
                // Query untuk mengambil data dari tabel permintaan
                $query = "SELECT * FROM permintaan WHERE status <> 'selesai' AND aktif <> 'nonaktif' ORDER BY nama";
                $stmt = sqlsrv_query($conn, $query);

                if ($stmt === false) {
                    die(print_r(sqlsrv_errors(), true));
                }

                // Loop untuk menampilkan data dalam elemen select
                while ($datasss = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $nomor = $datasss['nomor'];
                    $keterangan = $datasss['keterangan'];
                    $tgllll = $datasss['tgl']->format('Y-m-d'); // Format DateTime ke string
                  
                    $bagian = $datasss['bagian'];
                    $nama = $datasss['nama'];
                    $qty = $datasss['qty'];
                    $sisa = $datasss['sisa'];
                    $namabarang = $datasss['namabarang'];
                    $divisi = $datasss['divisi'];
                    ?>
                    <option value="<?php echo $nomor; ?>">
                        <?php echo $nama . '/' . $bagian . '/' . $divisi . '/' . $namabarang . '/' . $keterangan . '/' . $tgllll . '/JUMLAH:' . $qty; ?>
                    </option>
                <?php
                }
                sqlsrv_free_stmt($stmt);
                ?>
        </select>
			Divisi                                    
       <select class="form-control" name="divisi" required='required'>
			<option selected="selected" ></option>
			<option value="AMBASADOR">AMBASADOR</option>
			<option value="EFRATA">EFRATA</option>
			<option value="GARMENT">GARMENT</option>
			<option value="MAS">MAS</option>
			<option value="TEXTILE">TEXTILE</option>
		</select>						
		Bagian Pemakai                                     
        <select class="form-control" name='bagian' required='required'>
			<option selected="selected"></option>

			<?php
			// Query untuk mengambil data dari tabel 'bagian_pemakai'
			$query = "SELECT * FROM bagian_pemakai ORDER BY bag_pemakai ASC";
			$stmt = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($stmt !== false) {
				while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$id_bag_pemakai = $row['id_bag_pemakai'];
					$bag_pemakai = $row['bag_pemakai'];
			?>
					<option value="<?php echo $bag_pemakai; ?>">
						<?php echo $bag_pemakai; ?>
					</option>
			<?php
				}
			} else {
				echo "<option>Error fetching data</option>";
			}
			?>

		</select>
		User
		
                                            
                                            <input  class="form-control"  type="text" name="user" >
                                    
 ID Komputer
		
                                            
                                            <input  class="form-control"  type="text" name="idpc" >
                                           
Nama Komputer
		
                                            
                                            <input  class="form-control"  type="text" name="namapc" >   
                                    

                                           
   
                                   
<br>
     

    
    </div>
</div>
<div style="overflow:scroll;width:600px;height:450px;" id="data_barang">
       
	                           <div class="panel-body">
						
	
										
	
  
   							
	<div class="form-group">
 		<b>Monitor </b><font color=red>'00009'</font>          
		<select class="form-control" name='monitor'>
			<option> </option>

			<?php
			// Query untuk mengambil data dari tabel 'tbarang' dengan idkategori '00009'
			$query = "SELECT * FROM tbarang WHERE idkategori = '00009'";
			$stmt = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($stmt !== false) {
				while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$idbarang = $row['idbarang'];
					$namabarang = $row['namabarang'];
					$stock = $row['stock'];
			?>
					<option value="<?php echo $namabarang; ?>">
						<?php echo $namabarang; ?>
					</option>
			<?php
				}
			} else {
				echo "<option>Error fetching data</option>";
			}
			?>

		</select>

                                        
                                    
    </div>
										
	<div class="form-group">
 		<b>Keyboard </b><font color=red>'00018'</font>          
     	<select class="form-control" name='keyboard' >	 
			
			<option> </option>

			<?php
			// Query untuk mengambil data dari tabel 'tbarang' dengan idkategori '00009'
			$query = "SELECT * FROM tbarang WHERE idkategori = '00018'";
			$stmt = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($stmt !== false) {
				while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$idbarang = $row['idbarang'];
					$namabarang = $row['namabarang'];
					$stock = $row['stock'];
			?>
					<option value="<?php echo $namabarang; ?>">
						<?php echo $namabarang; ?>
					</option>
			<?php
				}
			} else {
				echo "<option>Error fetching data</option>";
			}
			?>
			
    
        </select> 
                                        
                                    
    </div>
										
 <div class="form-group">
 <b>Mouse </b><font color=red>'00019'</font>          
      <select class="form-control" name='mouse' >	 <option> </option>
            
			
			<?php
			// Query untuk mengambil data dari tabel 'tbarang' dengan idkategori '00009'
			$query = "SELECT * FROM tbarang WHERE idkategori = '00019'";
			$stmt = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($stmt !== false) {
				while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$idbarang = $row['idbarang'];
					$namabarang = $row['namabarang'];
					$stock = $row['stock'];
			?>
					<option value="<?php echo $namabarang; ?>">
						<?php echo $namabarang; ?>
					</option>
			<?php
				}
			} else {
				echo "<option>Error fetching data</option>";
			}
			?>
			
    
        </select> 
                                        
                                    
        </div>										
		<b>Bagian Pengambilan</b>                                      
        <select class="form-control" name='bagianambil' required='required'> <option selected="selected" ></option>
            
			

			<?php
				$query = "SELECT * FROM bagian ORDER BY bagian ASC";
				$stmt = sqlsrv_query($conn, $query);

				// Periksa apakah query berhasil
				if ($stmt !== false) {
					while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
						$idbagian = $row['id_bagian'];
						$bagian = $row['bagian'];
						?>
						<option value="<?php echo $idbagian; ?>">
							<?php echo $bagian; ?>
						</option>
						<?php
					}
				} else {
					echo "<option>Error fetching data</option>";
				}
			?>

			
    
        </select>	
		
		<br>	
 		<b> Keterangan</b> 
 			<textarea cols="45" rows="7" name="keterangan" class="form-control" id="ket" size="15px"  ></textarea>                                    
        <div class="form-group">
 			<b>Teknisi</b>         
            <input   class="form-control"  type="text" name="teknisi"  >                         
        </div>                           			
	   	<div class="form-group">
 			<b>Operation System</b>         
        	<input  class="form-control"  type="text" name="os" >
                                        
                                    
    	</div>	
		
		
		<div class="form-group">
 			<b>IP Komputer</b>         
        	<input  class="form-control"  type="text" name="ippc" >            
                                    
        </div>
		<div class="form-group">
 			<b>Bulan Perawatan</b>         
			
			<select class="form-control" name='bulan'>
				<option> </option>

				<?php
				$query = "SELECT * FROM bulan";
				$stmt = sqlsrv_query($conn, $query);

				// Periksa apakah query berhasil
				if ($stmt !== false) {
					while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
						$id_bulan = $row['id_bulan'];
						$bulan = $row['bulan'];
						?>
						<option value="<?php echo $id_bulan; ?>"><?php echo $bulan; ?></option>
						<?php
					}
				} else {
					echo "<option>Error fetching data</option>";
				}
				?>
			</select>                  
                                        
                                    
        </div>			
	    <div class="form-group">
 			<b>Total Kapasitas Harddsik</b>         
        	<input  class="form-control"  type="text" name="harddisk" >
        </div>
                                    
 
	   <div class="form-group">
 			<b>Total Kapasitas RAM</b>         
        	<input  class="form-control"  type="text" name="ram" >
        </div>

		<div class="form-group">
 			<b>Model</b>         
         	<input  readonly class="form-control"  type="text" name="model" value="<?php echo $model; ?>" >		
        </div>

		<div class="form-group">
 			<b>Seri</b>         
         	<input  readonly class="form-control"  type="text" name="seri" value="<?php echo $seri; ?>" >
        </div>										
  		<div class="form-group">
 			<b>RAM Slot 1</b>         
         	<input  readonly class="form-control"  type="text" name="ram1" value="<?php echo $ram1; ?>" >
        </div>
  		<div class="form-group">
 			<b>RAM Slot 2</b>         
          	<input readonly class="form-control"  type="text" name="ram2" value="<?php echo $ram2; ?>" >
		</div>
 		<div class="form-group">
 			<b>Harddisk Slot 1</b>         
        	<input readonly class="form-control"  type="text" name="hd1"  value="<?php echo $hd1; ?>" >
        </div>
  		<div class="form-group">
 			<b>Harddisk Slot 2</b>         
         	<input readonly class="form-control"  type="text" name="hd2" value="<?php echo $hd2; ?>" >
        </div>										
	 	<div class="form-group">
 			<b>Motherboard</b>         
         	<input readonly class="form-control"  type="text" name="mobo"  value="<?php echo $mobo; ?>" >
        </div>
   		<div class="form-group">
 			<b>Prosesor</b>         
         	<input readonly class="form-control"  type="text" name="prosesor"  value="<?php echo $prosesor; ?>" >
		</div>
   		<div class="form-group">
 			<b>Power Supply</b>         
          	<input readonly class="form-control"  type="text" name="powersupply" value="<?php echo $ps; ?>" >
        </div>
   		<div class="form-group">
 			<b>Cassing</b>         
          	<input readonly class="form-control"  type="text" name="cassing" value="<?php echo $casing; ?>" >
        </div>
   		<div class="form-group">
 			<b>DVD Internal</b>         
          	<input readonly class="form-control"  type="text" name="dvd" value="<?php echo $dvd; ?>" >
        </div>
   		<input readonly class="form-control"  type="hidden" name="idpcc" value="<?php echo $idpcc; ?>" >
 		<button  name="button_selesai" id="button_selesai" class="btn text-muted text-center btn-danger" type="submit">Simpan</button>


									
       
			 </td>

                                    </form>
									<br>
									
                            </div>
	   
	   
	   
</div>
           
</body>
</html>
