<?php
include('config.php');
date_default_timezone_set("Asia/Jakarta");
$tglini=date("Y-m-d");
$jamini=date("H:i");



if (isset($_GET['nomor'])) {
    $nomor = $_GET['nomor'];

    // Query untuk mendapatkan data dari tabel software
    $query_software = "SELECT * FROM software WHERE nomor = ?";
    $params_software = [$nomor];
    $stmt_software = sqlsrv_query($conn, $query_software, $params_software);

    if ($stmt_software === false) {
        // Menangani error jika terjadi
        echo "Error in query execution.<br>";
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
                echo "Code: " . $error['code'] . "<br>";
                echo "Message: " . $error['message'] . "<br>";
            }
        }
    } else {
        // Fetch data software
        $dataa = sqlsrv_fetch_array($stmt_software, SQLSRV_FETCH_ASSOC);
        $nomor = $dataa['nomor'];
        $tgl = $dataa['tgl'] ? $dataa['tgl']->format('Y-m-d') : '';
        $jam = $dataa['jam'];
        $nama = $dataa['nama'];
        $bagian = $dataa['bagian'];
        $divisi = $dataa['divisi'];
        $penerima = $dataa['penerima'];
        $kasus = $dataa['kasus'];
        $tgl2 = $dataa['tgl2'] ? $dataa['tgl2']->format('Y-m-d') : '';
        $jam2 = $dataa['jam2'];
        $tindakan = $dataa['tindakan'];
        $oleh = $dataa['oleh'];
        $status = $dataa['status'];
        $svc_kat = $dataa['svc_kat'];
        $tglRequest = $dataa['tglRequest'] ? $dataa['tglRequest']->format('Y-m-d') : '';
    }

    // Query untuk mendapatkan nama divisi
    $query_divisi = "SELECT namadivisi FROM divisi WHERE kd = ?";
    $params_divisi = [$divisi];
    $stmt_divisi = sqlsrv_query($conn, $query_divisi, $params_divisi);

    if ($stmt_divisi !== false) {
        $datab = sqlsrv_fetch_array($stmt_divisi, SQLSRV_FETCH_ASSOC);
        $namadivisi = $datab['namadivisi'];
    }

    // Query untuk mendapatkan username dari tabel IT
    $query_it = "SELECT username FROM it WHERE nama = ?";
    $params_it = [$penerima];
    $stmt_it = sqlsrv_query($conn, $query_it, $params_it);

    if ($stmt_it !== false) {
        $datac = sqlsrv_fetch_array($stmt_it, SQLSRV_FETCH_ASSOC);
        $username = $datac['username'];
    }
}
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
                        <h4>Edit Permintaan Support Software</h4>
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
						
                            <form action="aplikasi/updatesoftware.php" method="post"  enctype="multipart/form-data" name="postform2">
<input type="hidden" name="nomor" value='<?php echo $nomor;?>'   >
										 <div class="form-group">
<b>Tanggal Pengerjaan</b> &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 

<b>Jam</b><br>
                                            
                                             <input type="date" name="tgl" value='<?php echo $tgl;?>'  required="required" >  
	  &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp
&nbsp &nbsp &nbsp &nbsp 

	  <input type="text" name="jam" value='<?php echo $jam;?>' required="required">   <br>

<br><b>Tanggal Request</b> <br>

<input type="date" name="tglRequest" value='<?php echo $tglRequest;?>'  required="required" > 

	  
			               
				</div>	

				<div class="form-group">
								<b>Nama user</b>     
                                <input  placeholder="Nama user" class="form-control" value='<?php echo $nama;?>' type="text" name="nama"  required="required" >
                                    
                </div>						
	
   <div class="form-group">
     <b>Bagian</b>
	 <select class="form-control" name='bagian' required="required">	 
		<option value='<?php echo $bagian; ?>'><?php echo $bagian; ?></option>

		<?php
		$query_bagian = "SELECT * FROM bagian ORDER BY bagian ASC";
		$stmt_bagian = sqlsrv_query($conn, $query_bagian);

		if ($stmt_bagian === false) {
			// Menangani error jika terjadi
			echo "Error fetching data.<br>";
			if (($errors = sqlsrv_errors()) != null) {
				foreach ($errors as $error) {
					echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
					echo "Code: " . $error['code'] . "<br>";
					echo "Message: " . $error['message'] . "<br>";
				}
			}
		} else {
			while ($datas1 = sqlsrv_fetch_array($stmt_bagian, SQLSRV_FETCH_ASSOC)) {
				$id_bagian = $datas1['id_bagian'];
				$bagian = $datas1['bagian'];
				?>
				<option value="<?php echo $bagian; ?>"> <?php echo $bagian; ?> </option>
				<?php
			}
		}
		?>
	</select>
                   
                                    
                                        </div>
			
	   <div class="form-group">
     <b>Divisi</b>
	 <select class="form-control" name='divisi' required="required">
			<option value='<?php echo $divisi; ?>'><?php echo $namadivisi; ?></option>

			<?php
			$query_divisi = "SELECT * FROM divisi ORDER BY namadivisi ASC";
			$stmt_divisi = sqlsrv_query($conn, $query_divisi);

			if ($stmt_divisi === false) {
				// Menangani error jika terjadi
				echo "Error fetching data.<br>";
				if (($errors = sqlsrv_errors()) != null) {
					foreach ($errors as $error) {
						echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
						echo "Code: " . $error['code'] . "<br>";
						echo "Message: " . $error['message'] . "<br>";
					}
				}
			} else {
				while ($datas1 = sqlsrv_fetch_array($stmt_divisi, SQLSRV_FETCH_ASSOC)) {
					$kd = $datas1['kd'];
					$namadivisi = $datas1['namadivisi'];
					?>
					<option value="<?php echo $kd; ?>"> <?php echo $namadivisi; ?> </option>
					<?php
				}
			}
			?>
		</select>

                                        
                                    
                                        </div>
     
	   <div class="form-group">
<b>IT Penerima</b> 
<select class="form-control" name='penerima' required="required">
    <option value='<?php echo $penerima; ?>'><?php echo $username; ?></option>

    <?php
    $query_it = "SELECT * FROM it ORDER BY username ASC";
    $stmt_it = sqlsrv_query($conn, $query_it);

    if ($stmt_it === false) {
        // Menangani error jika terjadi
        echo "Error fetching data.<br>";
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
                echo "Code: " . $error['code'] . "<br>";
                echo "Message: " . $error['message'] . "<br>";
            }
        }
    } else {
        while ($datas1 = sqlsrv_fetch_array($stmt_it, SQLSRV_FETCH_ASSOC)) {
            $username = $datas1['username'];
            $nama = $datas1['nama'];
            ?>
            <option value="<?php echo $nama; ?>"> <?php echo $username; ?> </option>
            <?php
        }
    }
    ?>
</select>

                                        
                                    
                                        </div>
<div class="form-group">										
	<b>Kategori</b>                                  
		   <select class="form-control" name="svc_kat" required='required'>
	 <option  ></option>
	 <option  <?php if( $svc_kat=='LOW'){echo "selected"; } ?> value="LOW">LOW</option>
	 <option <?php if( $svc_kat=='NORMAL'){echo "selected"; } ?> value="MEDIUM">NORMAL</option>
	 <option <?php if( $svc_kat=='HIGH'){echo "selected"; } ?> value="HIGH">HIGH</option>
	 <option <?php if( $svc_kat=='URGENT'){echo "selected"; } ?> value="URGENT">URGENT</option>
	</select>	
</div>

	<div class="form-group">
            <b>Permasalahan</b>                               
                                         <textarea cols="45" rows="5" name="kasus" class="form-control" id="kasus" placeholder="Isikan Diskripsi Permintaan Support " size="15px" placeholder="" required="required"><?php echo $kasus;?></textarea>                              
      
                                        </div>
  <div class="form-group">
<b>Tanggal Selesai</b> &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 


<b>Jam Selesai</b><br>
                                            
     <input type="date" name="tgl2" value='<?php echo $tgl2;?>' >   
	  &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp
&nbsp &nbsp &nbsp &nbsp 

	  <input type="text" name="jam2" value='<?php echo $jam2;?>'  >               
			               
				 </div>	
<div class="form-group">
              <b> Tindakan </b>                           
                                         <textarea cols="45" rows="5" name="tindakan" class="form-control" id="tindakan" placeholder="Tindakan Dalam Supporting" size="15px" placeholder="" ><?php echo $tindakan;?></textarea>                              
      
                                        </div>
 <button  name="tombol_new" class="btn text-muted text-center btn-primary" type="reset">Cancel</button>

									
                                    <button  name="tombol" class="btn text-muted text-center btn-danger" type="submit">Edit</button>
           
			  
			 </td>
				
                                  
									<br>
									
                            </div>
                        </div>
                            </div>
                </div>
				</div>




<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>	