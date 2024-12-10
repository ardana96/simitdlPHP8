<?php
include('config.php');
date_default_timezone_set("Asia/Jakarta");
$tglini=date("Y-m-d");
$jamini=date("H:i");

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
                        <h4>Input Permintaan Support Software</h4>
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
						
                            <form action="aplikasi/simpansoftware.php" method="post"  enctype="multipart/form-data" name="postform2">

										 <div class="form-group">
<b>Tanggal Pengerjaan</b> &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 


<b>Jam</b><br>
                                            
                                             <input type="date" name="tgl" value=<?php echo $tglini;?>  required="required" >  
	  &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp
&nbsp &nbsp &nbsp &nbsp 

	  <input type="text" name="jam" value=<?php echo $jamini;?> required="required">    <br><br>           
<b>Tanggal Request</b> 

&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp

 
<b>Tanggal Approve</b> <br>
<input type="date" name="tglRequest" value=<?php echo $tglini;?>  required="required" >       
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp
&nbsp &nbsp &nbsp &nbsp 

<input type="date" name="tglApprove" value=<?php echo $tglini;?>  required="required" >  <br>    
				 </div>	

						<div class="form-group">
         
                                            <input  placeholder="Nama user" class="form-control" type="text" name="nama"  required="required" >
                                    
                                        </div>						
	
   <div class="form-group">
     
   	<select class="form-control" name='bagian' required="required">	 
		<option value="">.: Nama Bagian :. </option>
		
		<?php
		$query = "SELECT * FROM bagian ORDER BY bagian ASC";
		$stmt = sqlsrv_query($conn, $query);

		if ($stmt === false) {
			// Tangani kesalahan
			$errors = sqlsrv_errors();
			foreach ($errors as $error) {
				echo "<option value=''>Error: " . $error['message'] . "</option>";
			}
		} else {
			while ($datas1 = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				$id_bagian = $datas1['id_bagian'];
				$bagian = $datas1['bagian'];
				?>
				<option value="<?php echo htmlspecialchars($bagian); ?>">
					<?php echo htmlspecialchars($bagian); ?>
				</option>
				<?php
			}
		}
		?>
	</select>

                                        
                                    
                                        </div>
			
	   <div class="form-group">
     
	   	<select class="form-control" name='divisi' required="required">	 
			<option value="">.: Nama Divisi :. </option>
			
			<?php
			$query = "SELECT * FROM divisi ORDER BY namadivisi ASC";
			$stmt = sqlsrv_query($conn, $query);

			if ($stmt === false) {
				// Tangani kesalahan
				$errors = sqlsrv_errors();
				foreach ($errors as $error) {
					echo "<option value=''>Error: " . htmlspecialchars($error['message']) . "</option>";
				}
			} else {
				while ($datas1 = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$kd = $datas1['kd'];
					$namadivisi = $datas1['namadivisi'];
					?>
					<option value="<?php echo htmlspecialchars($kd); ?>">
						<?php echo htmlspecialchars($namadivisi); ?>
					</option>
					<?php
				}
			}
			?>
		</select>

                                        
                                    
                                        </div>
     
	   <div class="form-group">
     
	   <select class="form-control" name="penerima" required="required"> 
			<option value="">.: IT Penerima :. </option>
			<?php
			// Query untuk mendapatkan data dari tabel IT
			$query = "SELECT * FROM it ORDER BY username ASC";
			$stmt = sqlsrv_query($conn, $query);

			if ($stmt === false) {
				// Tangani kesalahan
				$errors = sqlsrv_errors();
				foreach ($errors as $error) {
					echo "<option value=''>Error: " . htmlspecialchars($error['message']) . "</option>";
				}
			} else {
				while ($datas1 = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$username = $datas1['username'];
					$nama = $datas1['nama'];
					?>
					<option value="<?php echo htmlspecialchars($nama); ?>"> <?php echo htmlspecialchars($username); ?> </option>
					<?php
				}
			}
			?>
		</select>

                                        
                                    
                                        </div>
	<div class="form-group">
                                           
                                         <textarea cols="45" rows="5" name="kasus" class="form-control" id="kasus" placeholder="Isikan Diskripsi Permintaan Support " size="15px" placeholder="" required="required"></textarea>                              
      
                                        </div>

 <button  name="tombol_new" class="btn text-muted text-center btn-info" type="reset">New</button>

									
                                    <button  name="tombol_simpan" class="btn text-muted text-center btn-primary" type="Submit">Simpan</button>
									
           
			   <button class="btn btn-danger" data-toggle="modal"  data-target="#newReg">
                                Selesai Dikerjakan
                            </button>
			 </td>
				
                                  
									<br>
									
                            </div>
                        </div>
                            </div>
                </div>
				</div>



  <div class="col-lg-12">
                        <div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Selesai Proses Support</h4>
                                        </div>
                                        <div class="modal-body">
                                     
				  <div class="form-group">
<b>Tanggal </b> &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
<b>Jam</b><br>
                                            
     <input type="date" name="tgl2" value=<?php echo $tglini;?> >   
	  &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp
&nbsp &nbsp &nbsp &nbsp 

	  <input type="text" name="jam2" value=<?php echo $jamini;?>  >

			               
				 </div>	
<div class="form-group">
                                          
<b>Kategori</b>                                  
       <select class="form-control" name="svc_kat" >
 <option  ></option>
 <option value="LOW">LOW</option>
 <option value="NORMAL">NORMAL</option>
 <option value="HIGH">HIGH</option>
 <option value="URGENT">URGENT</option>
</select>	
<b>Tindakan</b>									  
                                         <textarea cols="45" rows="5" name="tindakan" class="form-control" id="tindakan" placeholder="Tindakan Dalam Supporting" size="15px" placeholder="" ></textarea>                              
      
                                        </div>
                                       
                                
                                        </div>
	
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="Submit" class="btn btn-danger" name='tombol_selesai'>Simpan</button>
                                        </div>
				
										
										
										  </form>
										
										
										
										
                                    </div>
                                </div>
                            </div>
                    </div>
<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>	