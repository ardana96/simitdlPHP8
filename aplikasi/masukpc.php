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
                        <h4>1Set KOMPUTER MASUK</h4>
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
						
                            <form action="aplikasi/simpanmasukpc.php" method="post"  enctype="multipart/form-data" name="postform2">
   										  <div class="form-group">                                          
                                            <input class="form-control" type="hidden" name="nofaktur" value="<? echo kdauto("tpembelian",""); ?>" readonly  >
                                    
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
      <select class="form-control" name='idsupp' required='required'>	 
	  <option> </option>
            
			<?	$ss = mysql_query("SELECT * FROM tsupplier  ");
				if(mysql_num_rows($ss) > 0){
			 while($datass = mysql_fetch_array($ss)){
				$idsupp=$datass['idsupp'];
				$namasupp=$datass['namasupp'];
				?>
			 <option value="<? echo $idsupp; ?>"> <? echo $namasupp; ?>
			 </option>
			 
			 <?}}?>
			
    
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
		   <input  class="form-control" type="text"  id="namapeminta" name="namapeminta" style='display:none;' placeholder='.:: Isikan Permintaan Oleh ::.' >   
		<br>									
		
   <div class="form-group">
   <b>Nama Komputer</b>                                              
                                            <input class="form-control" type="text" name="idpc" value="<? echo kdauto("tpc","PC"); ?>" readonly  >
                                    
                                        </div>
										   <div class="form-group">
                                          
                                            <input class="form-control" type="hidden" name="nofaktur" value="<? echo kdauto("tpembelian",""); ?>" readonly  >
                                    
                                        </div>
	<div class="form-group" >
        
      
     <input  class="form-control" placeholder="Seri Laptop" type="text"  id="seri" name="seri" style='display:none;' > 
                                        </div>


										
	

										   <div class="form-group" >
 <b>Motherboard </b><font color=red>Tidak Mengurangi Stock Hanya Pemberian Nama</font>         
      <select class="form-control" name='mobo' style='display:none;' >	 <option> </option>
            
			<?	$s1 = mysql_query("SELECT * FROM tbarang where idkategori='00001'  ");
				if(mysql_num_rows($s1) > 0){
			 while($datas1 = mysql_fetch_array($s1)){
				$idbarang=$datas1['idbarang'];
				$namabarang=$datas1['namabarang'];
				$stock=$datas1['stock'];?>
			 <option value="<? echo $namabarang; ?>"> <? echo $namabarang; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
     <input  class="form-control" type="text"  id="moboo" name="moboo" style='display:none;' > 
                                        </div>
		

										   <div class="form-group">
 <b>Prosesor</b><font color=red>  Tidak Mengurangi Stock Hanya Pembelian Nama</font>           
      <select class="form-control" name='prosesor' style='display:none;'><option> </option>
            
			<?	$s2 = mysql_query("SELECT * FROM tbarang where idkategori='00002' ");
				if(mysql_num_rows($s2) > 0){
			 while($datas2 = mysql_fetch_array($s2)){
				$idbarang2=$datas2['idbarang'];
				$namabarang2=$datas2['namabarang'];?>
			 <option value="<? echo $namabarang2; ?>"> <? echo $namabarang2; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                   <input  class="form-control" type="text"  id="prosesorr" name="prosesorr" style='display:none;' >      
                                    
                                        </div>

    
										   <div class="form-group">
 <b>Power Supply</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
      <select class="form-control" name='ps' style='display:none;'>
	  <option value="<? echo $powersuply; ?>"><? echo $powersuply; ?> </option>
            
			<?	$s3 = mysql_query("SELECT * FROM tbarang where idkategori='00003' ");
				if(mysql_num_rows($s3) > 0){
			 while($datas3 = mysql_fetch_array($s3)){
				$idbarang3=$datas3['idbarang'];
				$namabarang3=$datas3['namabarang'];?>
			 <option value="<? echo $namabarang3; ?>"> <? echo $namabarang3; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
             <input  class="form-control" type="text"  id="pss" name="pss" style='display:none;' >                            
                                    
                                        </div>

										   <div class="form-group">
 <b>Casing</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
      <select class="form-control" name='casing'  style='display:none;'>
	  <option value="<? echo $cassing; ?>"><? echo $cassing; ?> </option>
            
			<?	$s4 = mysql_query("SELECT * FROM tbarang where idkategori='00004'  ");
				if(mysql_num_rows($s4) > 0){
			 while($datas4 = mysql_fetch_array($s4)){
				$idbarang4=$datas4['idbarang'];
				$namabarang4=$datas4['namabarang'];?>
			 <option value="<? echo $namabarang4; ?>"> <? echo $namabarang4; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
    <input  class="form-control" type="text"  id="casingg" name="casingg" style='display:none;' >                     
                                    
                                        </div>

										   <div class="form-group">
 <b>Harddisk Slot 1</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
      <select class="form-control" name='hd1'  style='display:none;'>
	  <option value="<? echo $hd1; ?>"><? echo $hd1; ?> </option>
            
			<?	$s5 = mysql_query("SELECT * FROM tbarang where idkategori='00005' ");
				if(mysql_num_rows($s5) > 0){
			 while($datas5 = mysql_fetch_array($s5)){
				$idbarang5=$datas5['idbarang'];
				$namabarang5=$datas5['namabarang'];?>
			 <option value="<? echo $namabarang5; ?>"> <? echo $namabarang5; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
     <input  class="form-control" type="text"  id="hd11" name="hd11" style='display:none;' >                                
                                        </div>

  
					  <div class="form-group">
 <b>Harddisk Slot 2</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>           
     <select class="form-control" name='hd2'  style='display:none;'>
	  <option value="<? echo $hd2; ?>" ><? echo $hd2; ?> </option>
            
			<?	$s5 = mysql_query("SELECT * FROM tbarang where idkategori='00005' ");
				if(mysql_num_rows($s5) > 0){
			 while($datas5 = mysql_fetch_array($s5)){
				$idbarang5=$datas5['idbarang'];
				$namabarang5=$datas5['namabarang'];?>
			 <option value="<? echo $namabarang5; ?>"> <? echo $namabarang5; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
     <input  class="form-control" type="text"  id="hd22" name="hd22" style='display:none;' >                                    
                                    
                                        </div>	

										<div class="form-group">
 <b>RAM Slot 1</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
      <select class="form-control" name='ram1' style='display:none;'>
	  <option value="<? echo $ram1; ?>"> <? echo $ram1; ?></option>
            
			<?	$s6 = mysql_query("SELECT * FROM tbarang where idkategori='00006' ");
				if(mysql_num_rows($s6) > 0){
			 while($datas6 = mysql_fetch_array($s6)){
				$idbarang6=$datas6['idbarang'];
				$namabarang6=$datas6['namabarang'];?>
			 <option value="<? echo $namabarang6; ?>"> <? echo $namabarang6; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
   <input  class="form-control" type="text"  id="ram11" name="ram11" style='display:none;' >                                  
                                        </div>

										  <div class="form-group">
 <b>RAM Slot 2</b><font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>          
      <select class="form-control" name='ram2' style='display:none;'>
	  <option value="<? echo $ram2; ?>" ><? echo $ram2; ?> </option>
            
			<?	$s6 = mysql_query("SELECT * FROM tbarang where idkategori='00006' ");
				if(mysql_num_rows($s6) > 0){
			 while($datas6 = mysql_fetch_array($s6)){
				$idbarang6=$datas6['idbarang'];
				$namabarang6=$datas6['namabarang'];?>
			 <option value="<? echo $namabarang6; ?>"> <? echo $namabarang6; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
   <input  class="form-control" type="text"  id="ram22" name="ram22" style='display:none;' >                                      
                                    
                                        </div>

											<div class="form-group">
 <b>Fan Prosesor</b> <font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>         
      <select class="form-control" name='fan' style='display:none;'>
	  <option value="<? echo $dvd; ?>" ><? echo $dvd; ?> </option>
            
			<?	$s12 = mysql_query("SELECT * FROM tbarang where idkategori='00007' ");
				if(mysql_num_rows($s12) > 0){
			 while($datas12 = mysql_fetch_array($s12)){
				$idbarang12=$datas12['idbarang'];
				$namabarang12=$datas12['namabarang'];?>
			 <option value="<? echo $namabarang12; ?>"> <? echo $namabarang12; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
    <input  class="form-control" type="text"  id="fann" name="fann" style='display:none;' >                                     
                                    
                                        </div>

										<div class="form-group">
 <b>DVD Internal</b> <font color=red>Tidak Merubah Stock Hanya Mengganti Nama</font>         
      <select class="form-control" name='dvd' style='display:none;'>
	  <option value="<? echo $dvd; ?>" ><? echo $dvd; ?> </option>
            
			<?	$s6 = mysql_query("SELECT * FROM tbarang where idkategori='00008' ");
				if(mysql_num_rows($s6) > 0){
			 while($datas6 = mysql_fetch_array($s6)){
				$idbarang6=$datas6['idbarang'];
				$namabarang6=$datas6['namabarang'];?>
			 <option value="<? echo $namabarang6; ?>"> <? echo $namabarang6; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
   <input  class="form-control" type="text"  id="dvdd" name="dvdd" style='display:none;' >                                      
                                    
                                        </div>
	 <b>Keterangan</b> 
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="ket" size="15px" placeholder=""></textarea>                                    
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