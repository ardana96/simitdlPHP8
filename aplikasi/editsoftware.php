<?php
include('config.php');
date_default_timezone_set("Asia/Jakarta");
$tglini=date("d-m-20y");
$jamini=date("H:i");

if(isset($_GET['nomor'])){
$nomor=$_GET['nomor'];	
$a = mysql_query("SELECT * from software where nomor='$nomor'");
while($dataa = mysql_fetch_array($a)){
$nomor=$dataa['nomor'];
$tgl=$dataa['tgl'];
$jam=$dataa['jam'];
$nama=$dataa['nama'];
$bagian=$dataa['bagian'];
$divisi=$dataa['divisi'];
$penerima=$dataa['penerima'];
$kasus=$dataa['kasus'];
$tgl2=$dataa['tgl2'];
$jam2=$dataa['jam2'];
$tindakan=$dataa['tindakan'];
$oleh=$dataa['oleh'];
$status=$dataa['status'];
$svc_kat = $dataa['svc_kat'];
$tglRequest=$dataa['tglRequest'];
}}
$b = mysql_query("SELECT namadivisi from divisi where kd='$divisi'");
while($datab = mysql_fetch_array($b)){
$namadivisi=$datab['namadivisi'];}

$c = mysql_query("SELECT username from it where nama='$penerima'");
while($datac = mysql_fetch_array($c)){
$username=$datac['username'];}

?>
 <script type="text/javascript">

function dontEnter(evt) { 
var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = dontEnter;

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
                        <h4>Edit Permintaan Support Software</h4>
						<hr>
                    </div>
                </div>
			   <div class="row">
                   <div class="col-md-6 col-sm-6 col-xs-12">
               <div class="panel panel-danger">
			   <?php if(isset($_GET['stt'])){
$stt=$_GET['stt'];
echo "".$stt."";?><img src="img/centang.png" style="width: 50px; height: 30px; "><?}
?> 
                        <div class="panel-heading">
                   
                        </div>
                        <div class="panel-body">
						
                            <form action="aplikasi/updatesoftware.php" method="post"  enctype="multipart/form-data" name="postform2">
<input type="hidden" name="nomor" value='<?echo $nomor;?>'   >
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
                                            
                                             <input type="text" name="tgl" value='<?echo $tgl;?>'  required="required" >  
	  &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp
&nbsp &nbsp &nbsp &nbsp 

	  <input type="text" name="jam" value='<?echo $jam;?>' required="required">   <br>

<br><b>Tanggal Request</b> <br>

<input type="text" name="tglRequest" value='<?echo $tglRequest;?>'  required="required" > 

	  
			               
				</div>	

				<div class="form-group">
								<b>Nama user</b>     
                                <input  placeholder="Nama user" class="form-control" value='<?echo $nama;?>' type="text" name="nama"  required="required" >
                                    
                </div>						
	
   <div class="form-group">
     <b>Bagian</b>
      <select class="form-control" name='bagian' required="required">	 <option value='<?echo $bagian;?>'><?echo $bagian;?></option>
            
			<?	$s1 = mysql_query("SELECT * FROM bagian order by bagian asc");
				if(mysql_num_rows($s1) > 0){
			 while($datas1 = mysql_fetch_array($s1)){
				$id_bagian=$datas1['id_bagian'];
				$bagian=$datas1['bagian'];
				?>
			 <option value="<? echo $bagian; ?>"> <? echo $bagian; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
			
	   <div class="form-group">
     <b>Divisi</b>
      <select class="form-control" name='divisi'  required="required">	 <option value='<?echo $divisi;?>'><?echo $namadivisi;?></option>
            
			<?	$s1 = mysql_query("SELECT * FROM divisi order by namadivisi asc");
				if(mysql_num_rows($s1) > 0){
			 while($datas1 = mysql_fetch_array($s1)){
				$kd=$datas1['kd'];
				$namadivisi=$datas1['namadivisi'];
				?>
			 <option value="<? echo $kd; ?>"> <? echo $namadivisi; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
     
	   <div class="form-group">
<b>IT Penerima</b> 
      <select class="form-control" name='penerima' required="required">	 <option value='<?echo $penerima;?>'><?echo $username;?></option>
            
			<?	$s1 = mysql_query("SELECT * FROM it order by username asc");
				if(mysql_num_rows($s1) > 0){
			 while($datas1 = mysql_fetch_array($s1)){
				$username=$datas1['username'];
				$nama=$datas1['nama'];
				?>
			 <option value="<? echo $nama; ?>"> <? echo $username; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
<div class="form-group">										
	<b>Kategori</b>                                  
		   <select class="form-control" name="svc_kat" required='required'>
	 <option  ></option>
	 <option  <? if( $svc_kat=='LOW'){echo "selected"; } ?> value="LOW">LOW</option>
	 <option <? if( $svc_kat=='NORMAL'){echo "selected"; } ?> value="MEDIUM">NORMAL</option>
	 <option <? if( $svc_kat=='HIGH'){echo "selected"; } ?> value="HIGH">HIGH</option>
	 <option <? if( $svc_kat=='URGENT'){echo "selected"; } ?> value="URGENT">URGENT</option>
	</select>	
</div>

	<div class="form-group">
            <b>Permasalahan</b>                               
                                         <textarea cols="45" rows="5" name="kasus" class="form-control" id="kasus" placeholder="Isikan Diskripsi Permintaan Support " size="15px" placeholder="" required="required"><?echo $kasus;?></textarea>                              
      
                                        </div>
  <div class="form-group">
<b>Tanggal Selesai</b> &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 


<b>Jam Selesai</b><br>
                                            
     <input type="text" name="tgl2" value='<?echo $tgl2;?>' >   
	  &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp
&nbsp &nbsp &nbsp &nbsp 

	  <input type="text" name="jam2" value='<?echo $jam2;?>'  >               
			               
				 </div>	
<div class="form-group">
              <b> Tindakan </b>                           
                                         <textarea cols="45" rows="5" name="tindakan" class="form-control" id="tindakan" placeholder="Tindakan Dalam Supporting" size="15px" placeholder="" ><?echo $tindakan;?></textarea>                              
      
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