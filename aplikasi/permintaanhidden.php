<?include('config.php');?>  
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
alert("Anda belum Memiliha Permintaan !");}
else{   
http.open('GET', 'aplikasi/filterpermintaan.php?nomor=' + encodeURIComponent(nomor) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('nomor').value = string[0];  
document.getElementById('status').value = string[1];
document.getElementById('ket').value = string[2];
document.getElementById('keterangan').value = string[3];

 
                         
document.getElementById('jumlah').value="";
document.getElementById('jumlah').focus();

}}

var mywin; 
function popup(nomor){
	if(nomor==""){
alert("Anda belum memilih nomor permintaan");}
else{   
mywin=window.open("aplikasi/lap_permintaandetail.php?nomor=" + nomor ,"_blank",	"toolbar=yes,location=yes,menubar=yes,copyhistory=yes,directories=no,status=no,resizable=no,width=500, height=400"); mywin.moveTo(100,100);}
}


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


                        <h2> Data Permintaan Barang Hidden </h2>



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
                                            <th>Tanggal</th>
											  <th>Nama </th>
                                            <th>Bagian</th>
                                            <th>Divisi</th>
											<th>Nama Barang</th>
											<th>Jumlah</th>
											<th>Keterangan</th>
											<th>Status</th>
											<th>Masuk</th>
											<th>Keluar</th>
											<th>Sisa Order</th>
										
											<th>Show</th>
											<th>Nomor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM permintaan where aktif='nonaktif' ");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$nomor=$data['nomor'];
				$tgl=$data['tgl'];
				$nama=$data['nama'];
				$bagian=$data['bagian'];
				$divisi=$data['divisi'];
				$namabarang=$data['namabarang'];
				$qty=$data['qty'];
				$masuk=$data['qtymasuk'];
				$keterangan=$data['keterangan'];
				$status=$data['status'];
				$tgl2=$data['tgl2'];
				
				$cek=mysql_query("select sum(qtymasuk) as totalmasuk,sum(qtykeluar) as totalkeluar from rincipermintaan where nomor='".$nomor."' ");
	  while($result=mysql_fetch_array($cek)){
	  $totalmasuk=$result['totalmasuk'];
	  $totalkeluar=$result['totalkeluar'];
	
	  }
	  $sisa=$qty-$totalmasuk; 
	    $refresh = mysql_query("update permintaan set sisa='".$sisa."' where nomor='".$nomor."'  ");
	  
				?>
				
                                        <tr class="gradeC">
                                            <td><? echo $tgl ?></td>
											   <td><? echo $nama ?></td>
                                            <td><? echo $bagian ?></td>
                                            <td><? echo $divisi ?></td>
											<td><? echo $namabarang ?></td>
											<td><? echo $qty?></td>
											<td><? echo $keterangan ?></td>
											<td><? echo $status ?></td>
											<td><? echo $totalmasuk ?></td>
											<td><? echo $totalkeluar ?></td>
											<td><? echo $qty-$totalmasuk ?></td>
										
                             
											
											  <td class="center"><form action="aplikasi/showpermintaan.php" method="post" >
											<input type="hidden" name="nomor" value=<?php echo $nomor; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan membuka data ini?')">Show</button>
											</form> </td>
										 <td><? echo $nomor ?></td>
                                            
                                        </tr>
                <?}}?>                      
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
     
	 
	  
					
					
					

					
					
					 