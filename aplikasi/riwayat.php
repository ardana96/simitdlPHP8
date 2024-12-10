<?php include('config.php');
	
?>  
 <?php
 $jam = date("H:i");
?>
<?php
$tanggal = date("d-m-20y ");
?>
<!-- <script language="javascript">
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

document.getElementById('nomorganti').value = encodeURIComponent(nomor);
document.getElementById('nomoroke').value = encodeURIComponent(nomor);
 
}}

</script> -->




<script language="javascript">
function createRequestObject() {
var ajax;
if (navigator.appName == 'Microsoft Internet Explorer') {
ajax= new ActiveXObject('Msxml2.XMLHTTP');} 
else {
ajax = new XMLHttpRequest();}
return ajax;}

var http = createRequestObject();
function sendRequest(idsupp){
if(idsupp==""){
alert("Anda belum memilih kode Data !");}
else{   
http.open('GET', 'aplikasi/filterriwayatkomputer.php?id_user=' + encodeURIComponent(idsupp) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('nomor').value = string[0];  
document.getElementById('tgl').value = string[1];
document.getElementById('jam').value = string[2];
document.getElementById('nama').value = string[3];
document.getElementById('ippc').value = string[4];
document.getElementById('bagian').value = string[5];
document.getElementById('divisi').value = string[6];
document.getElementById('kasus').value = string[7];
document.getElementById('penerima').value = string[8];
document.getElementById('tgl2').value = string[9];
document.getElementById('svc_kat').value = string[10]; 
document.getElementById('tindakan').value = string[11]; 


console.log(string[10]);
                                        


}}


</script>

<!-- <script language="javascript">
function createRequestObject() {
var ajax;
if (navigator.appName == 'Microsoft Internet Explorer') {
ajax= new ActiveXObject('Msxml2.XMLHTTP');} 
else {
ajax = new XMLHttpRequest();}
return ajax;}

var http = createRequestObject();


function permintaan(ippc){
if(ippc==""){
alert("Anda belum memilih ippc  !");}
else{  
http.open('GET', 'aplikasi/filterippc.php?ippc=' + encodeURIComponent(ippc) , true);
http.onreadystatechange = handleResponse;
http.send(null);
 }}
function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('bagian').value = string[0];  
document.getElementById('divisi').value = string[1];


}}




</script> -->

<?php
function kdauto($tabel, $inisial){
	$struktur	= mysql_query("SELECT * FROM $tabel");
	$field		= mysql_field_name($struktur,0);
	$panjang	= mysql_field_len($struktur,0);

 	$qry	= mysql_query("SELECT max(".$field.") FROM ".$tabel);
 	$row	= mysql_fetch_array($qry); 
 	if ($row[0]=="") {
 		$angka=0;
	}
 	else {
 		$angka		= substr($row[0], strlen($inisial));
 	}
	
 	$angka++;
 	$angka	=strval($angka); 
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
 	return $inisial.$tmp.$angka;
}?>

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2>Daftar Riwayat Kerusakan</h2>



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
									 <th>No Data</th>
										 <th>Tgl</th>
									
                                            <th>Nama</th>
                                            <th>IPPC</th>
                                            <th>Bagian</th>
											
											<th>Divisi</th>
											<th>Perangkat</th>
											<th>Permasalahan</th>
											<th>Tindakan</th>
											<th>Status</th>
											<th>Keterangan</th>
											<th>Edit</th>
											<th>Hapus</th>
										
										
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php
									   
			$nou = 1;
			$sql = "SELECT * FROM service WHERE status = 'selesai' AND perangkat IN ('CPU', 'LAPTOP') ORDER BY nomor DESC";
			$stmt = sqlsrv_query($conn, $sql);

			if ($stmt !== false) {
    		while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				$tgl=$data['tgl'];
				$jam=$data['jam'];
				$nama=$data['nama'];
				$ippc=$data['ippc'];
				$bagian=$data['bagian'];
				$divisi=$data['divisi'];
				$perangkat=$data['perangkat'];
				$kasus=$data['kasus'];
				$nomor=$data['nomor'];
				$penerima=$data['penerima'];
				$status=$data['status'];
				$teknisi=$data['teknisi'];
				$tindakan=$data['tindakan'];
				$tgl2=$data['tgl2'];
				$luar=$data['luar'];
				$tgl3=$data['tgl3'] == null ? '' : $data['tgl3']->format('Y-m-d');	;
				$keterangan=$data['keterangan'];
				$nomor=$data['nomor'];
				$statup=$data['statup'];
				
						// $sql = "SELECT * FROM bulan WHERE id_bulan = ?";
						// $params = array($bulan);
						// $stmt = sqlsrv_query($conn, $sql, $params);
						
						// if ($stmt !== false) {
						// 	while ($dataa = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
						// 		$namabulan = $dataa['bulan'];
						// 	}
						// } else {
						// 	echo "Query failed: " . print_r(sqlsrv_errors(), true);
						// }
				?>
				
                            	<tr class="gradeC">
									<td><?php echo $nou++ ?></td>	
									<td><?php echo $nomor ?></td>
								
									<td><?php echo $tgl->format('Y-m-d') ?></td>
                                    <td><?php echo $nama ?></td>
                                    <td><?php echo $ippc?></td>
                                    <td><?php echo $bagian ?></td>
									
									<td><?php echo $divisi ?></td>
									<td><?php echo $perangkat ?></td>
									<td><?php echo $kasus ?></td>
									<td><?php echo $tindakan ?></td>
									<td><?php echo $status; ?>,<?php echo $teknisi; ?>,<?php echo $tgl2->format('Y-m-d'); ?>,<?php echo $luar; ?>,<?php echo $tgl3 ; ?>
									</td>
									<td><?php echo $keterangan ?></td>
									<td>
										<button type="submit" class="btn btn-primary btn-line" value='<?php echo $nomor; ?>' data-toggle="modal"  data-target="#newReggg" name='tomboledit'  onclick="new sendRequest(this.value)">
                                		Edit
                            			</button>
                            		</td> 
                    				<td class="center">
                    					<form action="aplikasi/deleteriwayatkomputer.php" method="post" >
											<input type="hidden" name="nomor" value=<?php echo $nomor; ?> />
								
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X
											</button>
									  	</form>
									</td>
											 
											
											
                                            
                                        </tr>
                <?php }}?>                      
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="newReggg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

						
				<div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="H4">Edit Tanggal Service</h4>
                        </div>
                        <div class="modal-body">
						

                        <form action="aplikasi/updateriwayatservicekomputer.php" method="post"  enctype="multipart/form-data" name="postform2">

                            <input class="form-control" type="hidden" name="nomor" id="nomor"  readonly>

							Tanggal 
							<input  type="date" name="tgl"   id="tgl"  required="required">
							Jam     
							<input  type="text" name="jam" id = "jam" required="required" ><br><br>

							Tanggal Selesai 
							<input  class="form-control" type="date" name="tgl2"   id="tgl2"  required="required">
					        Nama    
					        <input class="form-control" type="text" name="nama" id="nama" required="required" >
							
							Kategori                                  
							<select class="form-control" name="svc_kat" id = "svc_kat" required='required'>
								<option  ></option>
								<option value="NON_SP">NON SPAREPART</option>
								<option value="SP">SPAREPART</option>
							</select>
                            IP PC  
                            <input class="form-control" type="text" name="ippc" id="ippc" value='192.168.' onchange="new permintaan(this.value)" required="required" readonly>
               										
							<div class="form-group">
								Bagian 
								<input class="form-control" type="text" name="bagian" id='bagian' readonly>
								Divisi 
								<input class="form-control" type="text" name="divisi" id='divisi' readonly>
                        	</div>	

							Perangkat 
							<input type="text" name="perangkat" id="perangkat" class="form-control" size="25px" value="CPU" readonly  >
								Permasalahan 
								<textarea cols="45" rows="7" name="permasalahan" class="form-control" id="kasus" size="15px" placeholder="" required="required"></textarea>
								
								Tindakan
								<textarea cols="45" rows="7" name="tindakan" class="form-control" id="tindakan" size="15px" placeholder="" required="required"></textarea>
							Diterima Oleh IT 
							<input type="text" name="it" id="penerima" class="form-control" size="25px"  required="required" >

                       
                
                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-line" data-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-danger btn-line" name='tombol'>Update</button>
                    </div>
					</form>
                </div>
            </div>
        </div>

    </div>
     
           
		   
		   
		   

					

					