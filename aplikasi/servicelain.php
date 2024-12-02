<?include('config.php');
	
?>  
 <?$jam = date("H:i");
?>
<?$tanggal = date("d-m-20y ");
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

document.getElementById('nomorganti').value = encodeURIComponent(nomor);
document.getElementById('nomoroke').value = encodeURIComponent(nomor);
 
}}

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
document.getElementById('devisi').value = string[1];


}}




</script>
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


                        <h2>Daftar Antrian Service Peripheral</h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                     <button class="btn btn-primary" data-toggle="modal"  data-target="#newReg">
                              +
                            </button>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
										<th>Nomor</th>
										 <th>Tgl</th>
										 <th>Jam</th>
                                            <th>Nama</th>
                                            <th>IP PC</th>
                                            <th>Bagian</th>
											
											<th>Divisi</th>
											<th>Perangkat</th>
											<th>Permasalahan</th>
											<th>IT Penerima</th>
											<th>Pengerjaan</th>
											<th>Pengerjaan</th>
									
										
										
										
											<th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM service where perangkat<>'CPU' and perangkat<>'LAPTOP' and perangkat<>'printer' and status='pending' ");
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
				
				$sqlll = mysql_query("SELECT * FROM bulan where id_bulan='$bulan' ");
			while($dataa = mysql_fetch_array($sqlll)){
			$namabulan=$dataa['bulan'];}
				?>
				
                                        <tr class="gradeC">
											<td><? echo $nomor ?></td>
									<td><? echo $tgl ?></td>
									<td><? echo $jam ?></td>
                                            <td><? echo $nama ?></td>
                                            <td><? echo $ippc?></td>
                                            <td><? echo $bagian ?></td>
											
											<td><? echo $divisi ?></td>
											<td><? echo $perangkat ?></td>
											<td><? echo $kasus ?></td>
											<td><? echo $penerima ?></td>
							<!--					 <td class="center">
<a href='user.php?menu=fkerusakanpcbaru&nomor=<?php echo $nomor; ?>'>			
<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Di Dalam</button>
											</a> </td>-->
											
                            
											 <td class="center"><button class="btn btn-primary" value='<?php echo $nomor; ?>' data-toggle="modal"  data-target="#newReggg" onclick="new sendRequest(this.value)">
                                Di Dalam 
                            </button> </td>
											 <td class="center"><button class="btn btn-primary" value='<?php echo $nomor; ?>' data-toggle="modal"  data-target="#newReggggg" onclick="new sendRequest(this.value)">
                                Di Luar
                            </button> </td>
		
	
											
									<!--			 <td class="center"><form action="user.php?menu=fkerusakanpcbaru" method="post" >
									
											<input type="hidden" name="nomor" value= />
										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Percobaan</button>
											</form> </td>-->
											 
											 <td class="center"><form action="aplikasi/deleteservice.php" method="post" >
											<input type="hidden" name="nomor" value=<?php echo $nomor; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
											</form> </td>
											
                                            
                                        </tr>
                <?}}?>                      
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
                                            <h4 class="modal-title" id="H4"> Permintaan Service</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanservicelain.php" method="post"  enctype="multipart/form-data" name="postform2">
<input type="hidden" name="nomor" id="no" class="texbox" size="25px" value="<? echo kdauto("service",""); ?>" required="required" readonly >
<input name="status" type="hidden" value="PENDING">
			Tanggal
                    <input  type="text" name="tgl"  value='<? echo $tanggal;?>' required="required">
	  Jam            <input  type="text" name="jam" value='<? echo $jam;?>' required="required" ><br><br>
									
									Nama
                                            <input class="form-control" type="text" name="nama"  required="required" >
                                    <!--  IP PC  
                                            <input class="form-control" type="text" name="ippc"  value='192.168.' onchange="new permintaan(this.value)" required="required" >
                                    -->
                                   
											
<div class="form-group">
                                           
Bagian
 <input class="form-control" type="text" name="bagian" id='bagian'  >
Divisi
 <input class="form-control" type="text" name="devisi" id='devisi'  >
                                    
                                        </div>	
	
Perangkat 
<input type="text" name="perangkat" id="perangkat" class="form-control" size="25px"   >
 Permasalahan 
 <textarea cols="45" rows="7" name="permasalahan" class="form-control" id="permasalahan" size="15px" placeholder="" required="required"></textarea>
 Diterima Oleh IT 
 <input type="text" name="it" id="it" class="form-control" size="25px"  required="required" >

                                       
                                
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
					
					

					
							   	   <div class="col-lg-12">
                        <div class="modal fade" id="newReggg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4">Reparasi Teknisi Dalam </h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanservicedalamlain.php" method="post"  enctype="multipart/form-data" name="postform2">
<input type="hidden" name="nomor" id="nomorganti"  class="texbox" size="25px"  required="required" readonly >

			Tanggal
                    <input  type="text" name="tgl2"  value='<? echo $tanggal;?>' required="required">
	  Jam            <input  type="text" name="jam2" value='<? echo $jam;?>' required="required" ><br><br>
									

Teknisi 
<input type="text" name="teknisi" id="teknisi" class="form-control" size="25px" placeholder="" required="required"  >
 Tindakan
 <textarea cols="45" rows="7" name="tindakan" class="form-control" id="tindakan" size="15px" placeholder="" required="required"></textarea>
 Keterangan
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="keterangan" size="15px" placeholder="" ></textarea>


                                       
                                
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
					
					
					
					
					
					
					<div class="col-lg-12">
                        <div class="modal fade" id="newReggggg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4">Dikirim ke Teknisi Luar </h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanservicekeluarlain.php" method="post"  enctype="multipart/form-data" name="postform2">
<input type="hidden" name="nomor" id="nomoroke"  class="texbox" size="25px"  required="required" readonly >

			Tanggal
                    <input  type="text" name="tgl2"  value='<? echo $tanggal;?>' required="required">
	  Jam            <input  type="text" name="jam2" value='<? echo $jam;?>' required="required" ><br><br>
									

Dikirim Ke 
<input type="text" name="luar" id="luar" class="form-control" size="25px"  required="required"  >
 
                                       
                                
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
					
					
					
					
					
				