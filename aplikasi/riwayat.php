<?include('config.php');
	
?>  
 <?$jam = date("H:i");
?>
<?$tanggal = date("d-m-20y ");
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

<?
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
                                       <?$nou=1;
									   $sql = mysql_query("SELECT * FROM service where status='selesai' and perangkat in ('CPU', 'LAPTOP') order by nomor desc ");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
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
						$tgl3=$data['tgl3'];
							$keterangan=$data['keterangan'];
						$nomor=$data['nomor'];
						$statup=$data['statup'];
				
				$sqlll = mysql_query("SELECT * FROM bulan where id_bulan='$bulan' ");
			while($dataa = mysql_fetch_array($sqlll)){
			$namabulan=$dataa['bulan'];}
				?>
				
                                        <tr class="gradeC">
									<td><? echo $nou++ ?></td>	
									<td><? echo $nomor ?></td>
								
									<td><? echo $tgl ?></td>
                                    <td><? echo $nama ?></td>
                                    <td><? echo $ippc?></td>
                                    <td><? echo $bagian ?></td>
									
									<td><? echo $divisi ?></td>
									<td><? echo $perangkat ?></td>
									<td><? echo $kasus ?></td>
									<td><? echo $tindakan ?></td>
									<td><?php echo $status; ?>,<?php echo $teknisi; ?>,<?php echo $tgl2; ?>,<?php echo $luar; ?>,<?php echo $tgl3; ?>
									</td>
									<td><? echo $keterangan ?></td>
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
                <?}}?>                      
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
							<input  type="text" name="tgl"   id="tgl"  required="required">
							Jam     
							<input  type="text" name="jam" id = "jam" required="required" ><br><br>

							Tanggal Selesai 
							<input  class="form-control" type="text" name="tgl2"   id="tgl2"  required="required">
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
     
           
		   
		   
		   

					

					