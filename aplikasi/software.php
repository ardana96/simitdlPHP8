<?php
include('config.php');
	date_default_timezone_set("Asia/Jakarta");
$tglini=date("Y-m-d");
$jamini=date("H:i");
?>  
<?php 
  $jam = date("H:i");
?>
<?php
	$tanggal = date("d-m-20y ");
?>
<script language="javascript">
function createRequestObject() {
var ajax;
if (navigator.appName == 'Microsoft Internet Explorer') {
ajax= new ActiveXObject('Msxml2.XMLHTTP');} 
else {
ajax = new XMLHttpRequest();}
return ajax;}

var http = createRequestObject();
function sendRequest(nomor){
if(nomor==""){
alert("Anda belum memilih permasalahan  !");}
else{   

document.getElementById('noedit').value = encodeURIComponent(nomor);

 
}}




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


                        <h2>Daftar Job Software</h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                    
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
									 <th>Nomor</th>
										 <th>Tanggal</th>
										 <th>Jam</th>
                                            <th>Nama</th>
                                            <th>Bagian</th>
											<th>Divisi</th>
											<th>IT Penerima</th>
											<th>Permasalahan</th>
											<th>Tindakan</th>
											<th>Status</th>
											<th>Tidak Cetak</th>
											<th>Edit</th>
											<th>Hapus</th>
								
										
										
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php
				$nou = 1;

				// Query untuk mengambil data dari tabel "software"
				$sql = "SELECT * FROM software ORDER BY nomor DESC";
				$stmt = sqlsrv_query($conn, $sql);
				
				if ($stmt === false) {
					echo "Error in query execution.<br>";
					if (($errors = sqlsrv_errors()) != null) {
						foreach ($errors as $error) {
							echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
							echo "Code: " . $error['code'] . "<br>";
							echo "Message: " . $error['message'] . "<br>";
						}
					}
				} else {
					while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				$tgl=$data['tgl'] ? $data['tgl']->format('Y-m-d') : '';
				$jam=$data['jam'];
				$nama=$data['nama'];
				$bagian=$data['bagian'];
				$divisi=$data['divisi'];
				$kasus=$data['kasus'];
				$nomor=$data['nomor'];
				$penerima=$data['penerima'];
				$status=$data['status'];
				$tindakan=$data['tindakan'];
				$tgl2=$data['tgl2'] ? $data['tgl2']->format('Y-m-d') : '';
				$jam2=$data['jam2'];
				$cetak=$data['cetak'];


						
				
				$sql = "SELECT * FROM divisi WHERE kd = ?";
				$params = [$divisi];

				$stmt = sqlsrv_query($conn, $sql, $params);

				if ($stmt === false) {
					echo "Error in query execution.<br>";
					if (($errors = sqlsrv_errors()) != null) {
						foreach ($errors as $error) {
							echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
							echo "Code: " . $error['code'] . "<br>";
							echo "Message: " . $error['message'] . "<br>";
						}
					}
				} else {
					while ($dataa = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
						$namadivisi = $dataa['namadivisi'];
					}
}
				?>
				
                                        <tr class="gradeC">
									<td><?php echo $nou++ ?></td>	
								
									<td><?php echo $tgl ?></td>
									<td><?php echo $jam ?></td>
                                            <td><?php echo $nama ?></td>
                                            <td><?php echo $bagian?></td>
                                            <td><?php echo $namadivisi ?></td>
											
											<td><?php echo $penerima ?></td>
											<td><?php echo $kasus ?></td>
											<td><?php echo $tindakan ?></td>
											<td>
											<?php if($status=='Selesai'){
											echo $status.' , '.$penerima.' , '.$tgl2; 
											}else{ ?><button type="submit" class="btn btn-info" value='<?php echo $nomor; ?>' data-toggle="modal"  data-target="#newReg" name='tomboledit'  onclick="new sendRequest(this.value)">
                                Diselesaikan
											</button><?php }?>
											</td>
											<td>
<form name="testing" method="POST" action="aplikasi/updateceksoft.php">
<?php


echo "<table><tr>";
    if ($data['cetak'] == 'T')
{ 

echo "<td><input type='hidden' name='nomorr' value='".$data['nomor']."' id='".$data['nomor']."'/>
<input type='checkbox' name='cek' value='' id='".$data['cetak']."' checked='checked' onclick='this.form.submit();' />";
}
else
{ 

echo "<td><input type='hidden' name='nomorr' value='".$data['nomor']."' id='".$data['nomor']."' />
<input type='checkbox' name='cek' value='T' id='".$data['nomor']."' onclick='this.form.submit();' />";
}
echo "</tr></table>";


?>
</form>	
											 </td>
										  <td class="center"><a href="user.php?menu=editsoftware&nomor=<?php echo $nomor ?>" class="btn text-muted text-center btn-primary">Edit</a></td>
	  <td class="center"><form action="aplikasi/deletesoftware.php" method="post" >
											<input type="hidden" name="nomor" value=<?php echo $nomor; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
											</form> </td>											
                            
											 
											
											
                                            
                                        </tr>
                <?php }}?>                      
                                    </tbody>
                                </table>
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
                                             <form action="aplikasi/simpanselsoft.php" method="post"  enctype="multipart/form-data" name="postform2">
				  		  <div class="form-group">
                                   
     <input type="hidden" name="nomor" id="noedit" >   

  
				 </div>	
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
                                            
     <input type="text" name="tgl2" value=<?php echo $tglini;?> >   
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
                                            <button type="Submit" class="btn btn-danger" name='tombol'>Simpan</button>
                                        </div>
				
										
										
										  </form>
										
										
										
										
                                    </div>
                                </div>
                            </div>
                    </div>

					

					