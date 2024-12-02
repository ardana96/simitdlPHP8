<?php
include('config.php');
if(isset($_POST['idpc'])){
//Sumber untuk update spesifikasi 
$idpc=$_POST['idpc'];
 $a= mysql_query("SELECT * from tpc where idpc='$idpc'");
	while($dataa= mysql_fetch_array($a)){
$idpc=$dataa['idpc'];
$mobo=$dataa['mobo'];
$prosesor=$dataa['prosesor'];
$ps=$dataa['ps'];
$cassing=$dataa['casing'];
$hd1=$dataa['hd1'];
$hd2=$dataa['hd2'];
$ram1=$dataa['ram1'];
$ram2=$dataa['ram2'];
$fan=$dataa['fan'];
$permintaan=$dataa['permintaan'];
$dvd=$dataa['dvd'];
$kett=$dataa['keterangan'];
}}

$aa="SELECT * FROM rincipermintaan WHERE namabarang='".$idpc."' ";
$aaa=mysql_query($aa);
	if(mysql_num_rows($aaa) > 0){
while($rinciaa=mysql_fetch_array($aaa)){
	$nopeminta=$rinciaa['nomor'];}
	$bb="SELECT * FROM permintaan WHERE nomor='".$nopeminta."' ";
$bbb=mysql_query($bb);
while($rincibb=mysql_fetch_array($bbb)){
$nmpeminta=$rincibb['nama'];
$nopeminta=$rincibb['nomor'];}
	}
	
else{$nmpeminta='';}
?>
 <script type="text/javascript">

function dontEnter(evt) { 
var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = dontEnter;

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
                        <h4>EDIT STOCK PC</h4>
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
						
                            <form action="aplikasi/updatestockpc.php" method="post"  enctype="multipart/form-data" name="postform2">
   
									
		
   <div class="form-group">
   <b>ID PC</b>                                              
                                            <input class="form-control" type="text" name="idpc" id="idpc" value="<? echo $idpc;?>"  readonly  >
                                    
                                        </div>
										<div class="form-group">
				 
				   <b> Jenis Permintaan</b>                                     
       <select class="form-control" name="pl2" id='pl2'  onChange='show2()' >
 <option selected="selected" ></option>
 <option value="sudah">Sudah Terdaftar</option>
 <option value="belum">Belum Terdaftar</option>

</select>
				 </div>
	  <div class="form-group">
      
   <select class="form-control" name='noper' style='display:none;' >
             <option selected="selected" value="<?echo $nopeminta;?>"><?echo $nmpeminta;?></option>
			
			<?	$sss = mysql_query("SELECT * FROM permintaan where status<>'selesai' and aktif<>'nonaktif' order by nama ");
				if(mysql_num_rows($sss) > 0){
			 while($datasss = mysql_fetch_array($sss)){
				$nomor=$datasss['nomor'];
				$keterangan=$datasss['keterangan'];
				$tgllll=$datasss['tgl'];
				$t=substr($tgllll,0,4);
				$b=substr($tgllll,-5,2);
				$h=substr($tgllll,-2,2);
				$tglllll=$h.'-'.$b.'-'.$t;
				$bagian=$datasss['bagian'];
				$nama=$datasss['nama'];
				$qty=$datasss['qty'];$sisa=$datasss['sisa'];
				$namabarang=$datasss['namabarang'];
				$divisi=$datasss['divisi'];?>
			 <option value="<? echo $nomor; ?>" ><? echo $nama.'/'.$bagian.'/'.$divisi.'/'.$namabarang.'/'.$keterangan.'/'.$tglllll.'/JUMLAH:'.$qty ; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select>
		  <input  class="form-control" type="text"  id="namapeminta" name="namapeminta" style='display:none;' value='<?echo $permintaan;?>' >   
  
                                        </div>


				    <input class="form-control" type="hidden" name="noperlama" id="noperlama" value="<? echo $nopeminta;?>">						
	
   <div class="form-group">
 <b>Motherboard </b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="mobo" id="mobo" value="<? echo $mobo;?>">
  
                                        </div>
  <div class="form-group">
 <b>Prosessor</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="prosesor" id="prosesor"  value="<? echo $prosesor;?>">
  
                                        </div>
<div class="form-group">
 <b>Power Supply</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="ps" id="ps" value="<? echo $ps;?>">
  
                                        </div>
<div class="form-group">
 <b>Cassing</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="casing" id="casing" value="<? echo $cassing;?>">
  
                                        </div>
 <div class="form-group">
 <b>Harddisk Slot 1</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="hd1" id="hd1" value="<? echo $hd1;?>">
  
                                        </div>
 <div class="form-group">
 <b>Harddisk Slot 2</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="hd2" id="hd2" value="<? echo $hd2;?>">
  
                                        </div>
  <div class="form-group">
 <b>RAM Slot 1</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="ram1" id="ram1" value="<? echo $ram1;?>">
  
                                        </div>
  <div class="form-group">
 <b>RAM Slot 2</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="ram2" id="ram2" value="<? echo $ram2;?>">
  
                                        </div>
  <div class="form-group">
 <b>FAN</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="fan" id="fan" value="<? echo $fan;?>">
  
                                        </div>
  <div class="form-group">
 <b>DVD</b><font color=red>'Tidak Mengurangi Stock'</font>         
      <input class="form-control" type="text" name="dvd" id="dvd" value="<? echo $dvd;?>">
  
                                        </div>
	

<b>Keterangan</b> 
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="ket" size="15px" ><? echo $kett;?></textarea>                                    
  <br>           

									
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