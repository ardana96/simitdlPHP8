<?php
include('config.php');

?>
 <script type="text/javascript">

function dontEnter(evt) { 
var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = dontEnter;

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
                        <h4>PERAKITAN KOMPUTER</h4>
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
						
                            <form action="aplikasi/simpanperakitan.php" method="post"  enctype="multipart/form-data" name="postform2">
   
									
		
   <div class="form-group">
   <b>Nama Komputer</b>                                              
                                            <input class="form-control" type="text" name="idpc" value="<?php echo kdauto("tpc","PC"); ?>" readonly  >
                                    
                                        </div>
										   <div class="form-group">
                                          
                                            <input class="form-control" type="hidden" name="nofaktur" value="<?php echo kdauto("tpengambilan",""); ?>" readonly  >
                                    
                                        </div>
										 <div class="form-group">
<b>Tanggal Perakitan </b><br>
                                            
                                          <input required='required' type="text" id="from" name="tglrakit" class="isi_tabel" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;"/><a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;">
	  <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0" alt=""></a>
                    
			               
				 </div>	

										
	
   <div class="form-group">
 <b>Motherboard </b><font color=red>'00001'</font>         
 <select class="form-control" name='mobo'>
    <option> </option>
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
 <b>Prosesor</b><font color=red>'00002'</font>           
      <select class="form-control" name='prosesor'>
    <option> </option>
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
 <b>Power Supply</b><font color=red>'00003'</font>          
 <select class="form-control" name='ps'>
    <option> </option>
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
 <b>Cassing</b><font color=red>'00004'</font>           
      <select class="form-control" name='casing' ><option> </option>
            
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
 <b>Harddisk Slot 1</b><font color=red>'00005'</font>           
      	<select class="form-control" name='hd1' ><option> </option>
            
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
 <b>Harddisk Slot 2</b><font color=red>'00005'</font>           
      <select class="form-control" name='hd2' ><option> </option>
            
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
 <b>RAM Slot 1</b><font color=red>'00006'</font>          
      <select class="form-control" name='ram1' ><option> </option>
            
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
 <b>RAM Slot 2</b><font color=red>'00006'</font>          
      <select class="form-control" name='ram2' ><option> </option>
            
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
 <b>Fan Prosesor</b><font color=red>'00007'</font>         
      <select class="form-control" name='fan' ><option> </option>
            
	  <?php
			// Query untuk mengambil data dari tabel tbarang
			$query = "SELECT * FROM tbarang WHERE idkategori = '00007' AND stock > 0";
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
 <b>DVD Internal</b> <font color=red>'00008'</font>         
      <select class="form-control" name='dvd' ><option> </option>
            
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