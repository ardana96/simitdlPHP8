<?php
include('config.php');


if (isset($_POST['idpc'])) {
    // Sumber untuk update spesifikasi 
    $idpc = $_POST['idpc'];

    // Query untuk mengambil data dari tabel tpc
    $query = "SELECT * FROM tpc WHERE idpc = ?";
    $params = array($idpc);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $dataa = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($dataa) {
        $idpc = $dataa['idpc'];
        $mobo = $dataa['mobo'];
        $prosesor = $dataa['prosesor'];
        $ps = $dataa['ps'];
        $cassing = $dataa['casing'];
        $hd1 = $dataa['hd1'];
        $hd2 = $dataa['hd2'];
        $ram1 = $dataa['ram1'];
        $ram2 = $dataa['ram2'];
        $fan = $dataa['fan'];
        $permintaan = $dataa['permintaan'];
        $dvd = $dataa['dvd'];
        $kett = $dataa['keterangan'];
    }
    sqlsrv_free_stmt($stmt);
}

// Query untuk mengambil data dari tabel rincipermintaan
$query_peminta = "SELECT * FROM rincipermintaan WHERE namabarang = ?";
$params_peminta = array($idpc);
$stmt_peminta = sqlsrv_query($conn, $query_peminta, $params_peminta);

$nmpeminta = '';
$nopeminta = '';
if ($stmt_peminta === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_has_rows($stmt_peminta)) {
    $rinciaa = sqlsrv_fetch_array($stmt_peminta, SQLSRV_FETCH_ASSOC);
    $nopeminta = $rinciaa['nomor'];

    // Query untuk mengambil data dari tabel permintaan
    $query_permintaan = "SELECT * FROM permintaan WHERE nomor = ?";
    $params_permintaan = array($nopeminta);
    $stmt_permintaan = sqlsrv_query($conn, $query_permintaan, $params_permintaan);

    if ($stmt_permintaan === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $rincibb = sqlsrv_fetch_array($stmt_permintaan, SQLSRV_FETCH_ASSOC);
    if ($rincibb) {
        $nmpeminta = $rincibb['nama'];
    }
    sqlsrv_free_stmt($stmt_permintaan);
}

sqlsrv_free_stmt($stmt_peminta);

?>


 <script type="text/javascript">

function dontEnter(evt) { 
var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = dontEnter;

 function show2()
   {
   if (document.postform2.pl2.value =="sudah")
    {
     document.postform2.noper.style.display = "block";
	 document.postform2.namapeminta.style.display = "none";
	 }
	else if (document.postform2.pl2.value =="")
    {
     document.postform2.noper.style.display = "none";
	 document.postform2.namapeminta.style.display = "none";
	 }
else{
	document.postform2.noper.style.display = "none";
	document.postform2.namapeminta.style.display = "block";
   }	 
   }

</script>
<?php
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
}?>
    <div class="inner">
		    <div class="row">
                    <div class="col-lg-12">
                        <h4>EDIT STOCK PC</h4>
						<hr>
                    </div>
                </div>
			   <div class="row">
                   <div class="col-md-6 col-sm-6 col-xs-12">
               <div class="panel panel-danger">
			   <?php if(isset($_GET['stt'])){
$stt=$_GET['stt'];
echo "".$stt."";?><img src="img/centang.png" style="width: 50px; height: 30px; "><?php }
?> 
                        <div class="panel-heading">
                   
                        </div>
                        <div class="panel-body">
						
                            <form action="aplikasi/updatestockpc.php" method="post"  enctype="multipart/form-data" name="postform2">
   
									
		
   <div class="form-group">
   <b>ID PC</b>                                              
                                            <input class="form-control" type="text" name="idpc" id="idpc" value="<?php echo $idpc;?>"  readonly  >
                                    
                                        </div>
										<div class="form-group">
				 
				   <b> Jenis Permintaan</b>                                     
       <select class="form-control" name="pl2" id='pl2'  onChange='show2()' >
 <option selected="selected" ></option>
 <option value="sudah">Sudah Terdaftar</option>
 <option value="belum">Belum Terdaftar</option>

</select>
	</div>
	    <div class="form-group">
      
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

		  <input  class="form-control" type="text"  id="namapeminta" name="namapeminta" style='display:none;' value='<?php echo $permintaan;?>' >   
  
                                        </div>


				    <input class="form-control" type="hidden" name="noperlama" id="noperlama" value="<?php  echo $nopeminta;?>">						
	
   <div class="form-group">
 <b>Motherboard </b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="mobo" id="mobo" value="<?php  echo $mobo;?>">
  
                                        </div>
  <div class="form-group">
 <b>Prosessor</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="prosesor" id="prosesor"  value="<?php  echo $prosesor;?>">
  
                                        </div>
<div class="form-group">
 <b>Power Supply</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="ps" id="ps" value="<?php  echo $ps;?>">
  
                                        </div>
<div class="form-group">
 <b>Cassing</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="casing" id="casing" value="<?php  echo $cassing;?>">
  
                                        </div>
 <div class="form-group">
 <b>Harddisk Slot 1</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="hd1" id="hd1" value="<?php  echo $hd1;?>">
  
                                        </div>
 <div class="form-group">
 <b>Harddisk Slot 2</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="hd2" id="hd2" value="<?php  echo $hd2;?>">
  
                                        </div>
  <div class="form-group">
 <b>RAM Slot 1</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="ram1" id="ram1" value="<?php  echo $ram1;?>">
  
                                        </div>
  <div class="form-group">
 <b>RAM Slot 2</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="ram2" id="ram2" value="<?php  echo $ram2;?>">
  
                                        </div>
  <div class="form-group">
 <b>FAN</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="fan" id="fan" value="<?php  echo $fan;?>">
  
                                        </div>
  <div class="form-group">
 <b>DVD</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="dvd" id="dvd" value="<?php  echo $dvd;?>">
  
                                        </div>
	

<b>Keterangan</b> 
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="ket" size="15px" ><?php  echo $kett;?></textarea>                                    
  <br>           

									
                                    <button  name="tombol" class="btn text-muted text-center btn-danger" type="submit">Simpan</button>
            <button  name="button_tambah" class="btn text-muted text-center btn-primary" type="reset">Reset</button>
			 </td>

                                    </form>
									<br>
									
                            </div>
                        </div>
                            </div>
                </div>
				</div>
				<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>