<?php
include('config.php');

?>
<script language="JavaScript" type="text/JavaScript">

   function show()
   {
   if (document.postform2.pl.value =="CPU")
    {
     document.postform2.seri.style.display = "none";
      document.postform2.mobo.style.display = "block";
  document.postform2.prosesor.style.display = "block";
  document.postform2.ps.style.display = "block";
  document.postform2.casing.style.display = "block";
  document.postform2.hd1.style.display = "block";

  document.postform2.ram1.style.display = "block";
  document.postform2.ram2.style.display = "block";
  document.postform2.fan.style.display = "block";
  document.postform2.dvd.style.display = "block";
 
  
   document.postform2.moboo.style.display = "none";
  document.postform2.prosesorr.style.display = "none";
  document.postform2.pss.style.display = "none";
  document.postform2.casingg.style.display = "none";
  document.postform2.hd11.style.display = "none";
 
  document.postform2.ram11.style.display = "none";
  document.postform2.ram22.style.display = "none";
  document.postform2.fann.style.display = "none";
  document.postform2.dvdd.style.display = "none";
 
  document.postform2.hd2.style.display = "block";
   document.postform2.hd22.style.display = "none";
    }
   else if (document.postform2.pl.value =="LAPTOP")
    {
		 document.postform2.seri.style.display = "block";
          document.postform2.moboo.style.display = "block";
  document.postform2.prosesorr.style.display = "block";
  document.postform2.pss.style.display = "block";
  document.postform2.casingg.style.display = "block";
  document.postform2.hd11.style.display = "block";

  document.postform2.ram11.style.display = "block";
  document.postform2.ram22.style.display = "block";
  document.postform2.fann.style.display = "block";
  document.postform2.dvdd.style.display = "block"; 
  
    document.postform2.mobo.style.display = "none";
  document.postform2.prosesor.style.display = "none";
  document.postform2.ps.style.display = "none";
  document.postform2.casing.style.display = "none";
  document.postform2.hd1.style.display = "none";
 
  document.postform2.ram1.style.display = "none";
  document.postform2.ram2.style.display = "none";
  document.postform2.fan.style.display = "none";
  document.postform2.dvd.style.display = "none";
   
    document.postform2.hd2.style.display = "none";
   document.postform2.hd22.style.display = "block";
	
    }
   else
    {
  document.postform2.mobo.style.display = "none";
      document.postform2.moboo.style.display = "none";
  document.postform2.prosesor.style.display = "none";
  document.postform2.ps.style.display = "none";
  document.postform2.casing.style.display = "none";
  document.postform2.hd1.style.display = "none";

  document.postform2.ram1.style.display = "none";
  document.postform2.ram2.style.display = "none";
  document.postform2.fan.style.display = "none";
  document.postform2.dvd.style.display = "none";
    
  document.postform2.prosesorr.style.display = "none";
  document.postform2.pss.style.display = "none";
  document.postform2.casingg.style.display = "none";
  document.postform2.hd11.style.display = "none";

  document.postform2.ram11.style.display = "none";
  document.postform2.ram22.style.display = "none";
  document.postform2.fann.style.display = "none";
  document.postform2.dvdd.style.display = "none";
  
	  document.postform2.hd2.style.display = "none";	
   document.postform2.hd22.style.display = "none";
  }
   }
   
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
                        <h4>1Set KOMPUTER MASUK</h4>
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
						
                            <form action="aplikasi/simpanmasukpc.php" method="post"  enctype="multipart/form-data" name="postform2">
   										  <div class="form-group">                                          
                                            <input class="form-control" type="hidden" name="nofaktur" value="<?php echo kdauto("tpembelian",""); ?>" readonly  >
                                    
                                        </div>
										 <div class="form-group">
<b>Tanggal Pembelian</b><br>
                                            
                                          <input required='required' type="text" id="from" name="tglbeli" class="isi_tabel" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;"/><a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;">
	  <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0" alt=""></a>
                    
			               
				 </div>	
				 
				 <div class="form-group">
				 
				   <b> PC / Laptop </b>                                     
       <select class="form-control" name="pl" id='pl'  onChange='show()' >
 <option selected="selected" ></option>
 <option value="CPU">PC Komputer</option>
 <option value="LAPTOP">Laptop</option>

</select>
				 </div>
				 
				 
	   <div class="form-group">
 <b> Nama Supplier </b>        
	<select class="form-control" name="idsupp" required="required">
		<option></option>
		<?php
		// Query untuk mendapatkan data dari tabel tsupplier
		$query = "SELECT * FROM tsupplier";
		// Eksekusi query
		$ss = sqlsrv_query($conn, $query);

		// Cek apakah query berhasil dijalankan
		if ($ss === false) {
			die(print_r(sqlsrv_errors(), true));
		}

		// Looping untuk menampilkan data di dalam dropdown
		while ($datass = sqlsrv_fetch_array($ss, SQLSRV_FETCH_ASSOC)) {
			$idsupp = $datass['idsupp'];
			$namasupp = $datass['namasupp'];
			?>
			<option value="<?php echo $idsupp; ?>"><?php echo $namasupp; ?></option>
		<?php } ?>
	</select>

                                        
                                    
                                        </div>	
										 <div class="form-group">
				 
				   <b> Jenis Permintaan</b>                                     
       <select class="form-control" name="pl2" id='pl2'  onChange='show2()' >
 <option selected="selected" ></option>
 <option value="sudah">Sudah Terdaftar</option>
 <option value="belum">Belum Terdaftar</option>

</select>
				 </div>
                                 
        <select class="form-control" name='noper' style='display:none;'>
           <option selected="selected" value='' >.:: Pilih Permintaan Terdaftar ::.</option>
			
			 <?php
            // Query untuk mengambil data dari tabel permintaan
            $query = "SELECT * FROM permintaan WHERE status <> 'selesai' AND aktif <> 'nonaktif' ORDER BY nama";
            
            // Menjalankan query menggunakan SQL Server
            $sss = sqlsrv_query($conn, $query);
            
            // Mengecek apakah query berhasil dijalankan
            if ($sss === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            // Mengambil hasil query dan menampilkan data
            while ($datasss = sqlsrv_fetch_array($sss, SQLSRV_FETCH_ASSOC)) {
                $nomor = $datasss['nomor'];
                $keterangan = $datasss['keterangan'];
                $tgllll = $datasss['tgl'];
                
                // Memformat tanggal (menggunakan substring untuk memisah bagian tahun, bulan, hari)
                // $t = substr($tgllll, 0, 4);
                // $b = substr($tgllll, -5, 2);
                // $h = substr($tgllll, -2, 2);
                // $tglllll = $h . '-' . $b . '-' . $t;
                
                $bagian = $datasss['bagian'];
                $nama = $datasss['nama'];
                $qty = $datasss['qty'];
                $sisa = $datasss['sisa'];
                $namabarang = $datasss['namabarang'];
                $divisi = $datasss['divisi'];
            ?>
                <option value="<?php echo $nomor; ?>">
                    <?php echo $nama . '/' . $bagian . '/' . $divisi . '/' . $namabarang . '/' . $keterangan . '/' . $tgllll->format("Y-m-d") . '/JUMLAH:' . $qty; ?>
                </option>
            <?php } ?>
			 
			
    
        </select>	
		   <input  class="form-control" type="text"  id="namapeminta" name="namapeminta" style='display:none;' placeholder='.:: Isikan Permintaan Oleh ::.' >   
		<br>									
		
   <div class="form-group">
   <b>Nama Komputer</b>                                              
                                            <input class="form-control" type="text" name="idpc" value="<?php echo kdauto("tpc","PC"); ?>" readonly  >
                                    
                                        </div>
										   <div class="form-group">
                                          
                                            <input class="form-control" type="hidden" name="nofaktur" value="<?php echo kdauto("tpembelian",""); ?>" readonly  >
                                    
                                        </div>
	<div class="form-group" >
        
      
     <input  class="form-control" placeholder="Seri Laptop" type="text"  id="seri" name="seri" style='display:none;' > 
                                        </div>


										
	

	<div class="form-group" >
		<b>Motherboard </b><font color=red>Tidak Mengurangi Stock Hanya Pemberian Nama</font>         
      	
		<select class="form-control" name='mobo' style='display:none;'>
			<option></option>
			<?php
			// Query untuk mengambil data dari tabel tbarang dengan kategori tertentu
			$query = "SELECT * FROM tbarang WHERE idkategori = '00001'";
			
			// Eksekusi query menggunakan SQL Server
			$s1 = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($s1 === false) {
				die(print_r(sqlsrv_errors(), true)); // Menampilkan error jika query gagal
			}

			// Loop untuk mengambil data dan menampilkan opsi dropdown
			while ($datas1 = sqlsrv_fetch_array($s1, SQLSRV_FETCH_ASSOC)) {
				$idbarang = $datas1['idbarang'];
				$namabarang = $datas1['namabarang'];
				$stock = $datas1['stock'];
			?>
				<option value="<?php echo $namabarang; ?>"> <?php echo $namabarang; ?> </option>
			<?php } ?>
		</select>
     	<input  class="form-control" type="text"  id="moboo" name="moboo" style='display:none;' > 
    </div>
		

	<div class="form-group">
		<b>Prosesor</b><font color=red>  Tidak Mengurangi Stock Hanya Pembelian Nama</font>           
		<select class="form-control" name='prosesor' style='display:none;'>
			<option></option>
			<?php
			// Query untuk mengambil data dari tabel tbarang dengan kategori tertentu
			$query = "SELECT * FROM tbarang WHERE idkategori = '00002'";

			// Eksekusi query menggunakan SQL Server
			$s2 = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($s2 === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Loop untuk mengambil data dan menampilkan opsi dropdown
			while ($datas2 = sqlsrv_fetch_array($s2, SQLSRV_FETCH_ASSOC)) {
				$idbarang2 = $datas2['idbarang'];
				$namabarang2 = $datas2['namabarang'];
			?>
				<option value="<?php echo $namabarang2; ?>"> <?php echo $namabarang2; ?> </option>
			<?php } ?>
		</select>

		<input  class="form-control" type="text"  id="prosesorr" name="prosesorr" style='display:none;' >      
								
	</div>

    
	<div class="form-group">
 		<b>Power Supply</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
		<select class="form-control" name='ps' style='display:none;'>
			<option></option>
			<?php
			// Query untuk mengambil data dari tabel tbarang dengan kategori tertentu
			$query = "SELECT * FROM tbarang WHERE idkategori = '00003'";

			// Eksekusi query menggunakan SQL Server
			$s3 = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($s3 === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Loop untuk mengambil data dan menampilkan opsi dropdown
			while ($datas3 = sqlsrv_fetch_array($s3, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
			?>
				<option value="<?php echo $namabarang3; ?>"> <?php echo $namabarang3; ?> </option>
			<?php } ?>
		</select>

        <input  class="form-control" type="text"  id="pss" name="pss" style='display:none;' >                            
                                    
    </div>

	<div class="form-group">
 		<b>Casing</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
		<select class="form-control" name='casing' style='display:none;'>
			<option></option>
			<?php
			// Query untuk mengambil data dari tabel tbarang dengan kategori tertentu
			$query = "SELECT * FROM tbarang WHERE idkategori = '00004'";

			// Eksekusi query menggunakan SQL Server
			$s4 = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($s4 === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Loop untuk mengambil data dan menampilkan opsi dropdown
			while ($datas4 = sqlsrv_fetch_array($s4, SQLSRV_FETCH_ASSOC)) {
				$idbarang4 = $datas4['idbarang'];
				$namabarang4 = $datas4['namabarang'];
			?>
				<option value="<?php echo $namabarang4; ?>"> <?php echo $namabarang4; ?> </option>
			<?php } ?>
		</select>

    <input  class="form-control" type="text"  id="casingg" name="casingg" style='display:none;' >                     
                                    
    </div>

	<div class="form-group">
 		<b>Harddisk Slot 1</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
		<select class="form-control" name='hd1' style='display:none;'>
			<option></option>
			<?php
			// Query untuk mengambil data dari tabel tbarang dengan kategori tertentu
			$query = "SELECT * FROM tbarang WHERE idkategori = '00005'";

			// Eksekusi query menggunakan SQL Server
			$s5 = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($s5 === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Loop untuk mengambil data dan menampilkan opsi dropdown
			while ($datas5 = sqlsrv_fetch_array($s5, SQLSRV_FETCH_ASSOC)) {
				$idbarang5 = $datas5['idbarang'];
				$namabarang5 = $datas5['namabarang'];
			?>
				<option value="<?php echo $namabarang5; ?>"> <?php echo $namabarang5; ?> </option>
			<?php } ?>
		</select>
                           
     	<input  class="form-control" type="text"  id="hd11" name="hd11" style='display:none;' >                                
    </div>

  
	<div class="form-group">
 		<b>Harddisk Slot 2</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
		<select class="form-control" name='hd2'  style='display:none;'>
			<option></option>
			<?php
			// Query untuk mengambil data dari tabel tbarang dengan kategori tertentu
			$query = "SELECT * FROM tbarang WHERE idkategori = '00005'";

			// Eksekusi query menggunakan SQL Server
			$s5 = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($s5 === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Loop untuk mengambil data dan menampilkan opsi dropdown
			while ($datas5 = sqlsrv_fetch_array($s5, SQLSRV_FETCH_ASSOC)) {
				$idbarang5 = $datas5['idbarang'];
				$namabarang5 = $datas5['namabarang'];
			?>
				<option value="<?php echo $namabarang5; ?>"> <?php echo $namabarang5; ?> </option>
			<?php } ?>
		</select>
     	<input  class="form-control" type="text"  id="hd22" name="hd22" style='display:none;' >                                    
                                    
    </div>	

	<div class="form-group">
 		<b>RAM Slot 1</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
		<select class="form-control" name='ram1' style='display:none;'>
		 	<option></option>

			<?php
			// Query untuk mengambil data dari tabel tbarang dengan kategori tertentu
			$query = "SELECT * FROM tbarang WHERE idkategori = '00006'";

			// Eksekusi query menggunakan SQL Server
			$s6 = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($s6 === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Loop untuk mengambil data dan menampilkan opsi dropdown
			while ($datas6 = sqlsrv_fetch_array($s6, SQLSRV_FETCH_ASSOC)) {
				$idbarang6 = $datas6['idbarang'];
				$namabarang6 = $datas6['namabarang'];
			?>
				<option value="<?php echo $namabarang6; ?>"> <?php echo $namabarang6; ?> </option>
			<?php } ?>
		</select>
                                        
   		<input  class="form-control" type="text"  id="ram11" name="ram11" style='display:none;' >                                  
    </div>

	<div class="form-group">
 		<b>RAM Slot 2</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
      	<select class="form-control" name='ram2' style='display:none;'>
	  		<option></option>

			<?php
			// Query untuk mengambil data dari tabel tbarang dengan kategori tertentu
			$query = "SELECT * FROM tbarang WHERE idkategori = '00006'";

			// Eksekusi query menggunakan SQL Server
			$s6 = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($s6 === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Loop untuk mengambil data dan menampilkan opsi dropdown
			while ($datas6 = sqlsrv_fetch_array($s6, SQLSRV_FETCH_ASSOC)) {
				$idbarang6 = $datas6['idbarang'];
				$namabarang6 = $datas6['namabarang'];
			?>
				<option value="<?php echo $namabarang6; ?>"> <?php echo $namabarang6; ?> </option>
			<?php } ?>
		</select>
   		<input  class="form-control" type="text"  id="ram22" name="ram22" style='display:none;' >                              
    </div>

	<div class="form-group">
 		<b>Fan Prosesor</b> <font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>         
		<select class="form-control" name='fan' style='display:none;'>
			<option></option>

			<?php
			// Query untuk mengambil data dari tabel tbarang dengan kategori tertentu
			$query = "SELECT * FROM tbarang WHERE idkategori = '00007'";

			// Eksekusi query menggunakan SQL Server
			$s12 = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($s12 === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Loop untuk mengambil data dan menampilkan opsi dropdown
			while ($datas12 = sqlsrv_fetch_array($s12, SQLSRV_FETCH_ASSOC)) {
				$idbarang12 = $datas12['idbarang'];
				$namabarang12 = $datas12['namabarang'];
			?>
				<option value="<?php echo $namabarang12; ?>"> <?php echo $namabarang12; ?> </option>
			<?php } ?>
		</select>

    	<input  class="form-control" type="text"  id="fann" name="fann" style='display:none;' >                                     
                                    
    </div>

	<div class="form-group">
 		<b>DVD Internal</b> <font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>         
		<select class="form-control" name='dvd' style='display:none;'>
			<option></option>

			<?php
			// Query untuk mengambil data dari tabel tbarang dengan kategori tertentu
			$query = "SELECT * FROM tbarang WHERE idkategori = '00008'";

			// Eksekusi query menggunakan SQL Server
			$s6 = sqlsrv_query($conn, $query);

			// Periksa apakah query berhasil
			if ($s6 === false) {
				die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
			}

			// Loop untuk mengambil data dan menampilkan opsi dropdown
			while ($datas6 = sqlsrv_fetch_array($s6, SQLSRV_FETCH_ASSOC)) {
				$idbarang6 = $datas6['idbarang'];
				$namabarang6 = $datas6['namabarang'];
			?>
				<option value="<?php echo $namabarang6; ?>"> <?php echo $namabarang6; ?> </option>
			<?php } ?>
		</select>

   		<input  class="form-control" type="text"  id="dvdd" name="dvdd" style='display:none;' >                                      
                                    
    </div>
	<div class="form-group">
		<b>Keterangan</b> 
			<textarea cols="45" rows="7" name="keterangan" class="form-control" id="ket" size="15px" placeholder=""></textarea>                                    
		<br>       
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