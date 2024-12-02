<?include('config.php');?>  

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2>Stock Komputer Rakitan </h2>



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
                                            <th>IDPC</th>
											    <th>Permintaan</th>
												<th>No Faktur</th>
												<th>Tgl Pembelian</th>
												<th>Supplier</th>
                                            <th>Motherboard</th>
                                            <th>Prosesor</th>
											<th>Power Supply</th>
											<th>Casing</th>
											<th>Harddisk I</th>
											<th>Harddisk II</th>
											<th>Ram I</th>
											<th>Ram II</th>
										<th>Fan Prosesor</th>
										<th>DVD</th>
											<th>Keterangan</th>
											<th>Edit</th>
											<th>PC Baru</th>
												<th>PC Update</th>
													<th>Hidden</th>
									
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM tpc where status='digudang' and aktif<>'nonaktif'");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$idpc=$data['idpc'];
				$mobo=$data['mobo'];
				$prosesor=$data['prosesor'];
				$ps=$data['ps'];
				$tglrakit=$data['tglrakit'];
				$casing=$data['casing'];
				$hd1=$data['hd1'];
				$namapeminta=$data['permintaan'];
				$hd2=$data['hd2'];
				$ram1=$data['ram1'];
				$ram2=$data['ram2'];
				$fan=$data['fan'];
				$dvd=$data['dvd'];
				
				$att=substr($tglrakit,-2,2);
				$abb=substr($tglrakit,-5,2);
				$ahh=substr($tglrakit,0,4);
				$tglrakittt=$att.'-'.$abb.'-'.$ahh;
				
				$keterangan=$data['keterangan'];
				
				$aa="SELECT * FROM rincipermintaan WHERE namabarang='".$idpc."' ";
$aaa=mysql_query($aa);
	if(mysql_num_rows($aaa) > 0){
while($rinciaa=mysql_fetch_array($aaa)){
	$nopeminta=$rinciaa['nomor'];}
	$bb="SELECT * FROM permintaan WHERE nomor='".$nopeminta."' ";
$bbb=mysql_query($bb);
while($rincibb=mysql_fetch_array($bbb)){
$nmpeminta=$rincibb['nama'];}
	}
	
else{$nmpeminta=$namapeminta;}

$bb="SELECT * FROM trincipembelian WHERE namabarang='".$idpc."' ";
$pbb=mysql_query($bb);
	if(mysql_num_rows($pbb) > 0){
while($rincibb=mysql_fetch_array($pbb)){
	$nfak=$rincibb['nofaktur'];}
	
	$cc="SELECT * FROM tpembelian WHERE nofaktur='".$nfak."' ";
$pcc=mysql_query($cc);
	if(mysql_num_rows($pcc) > 0){
while($rincicc=mysql_fetch_array($pcc)){
	$tglbeli=$rincicc['tglbeli'];
	$idsupp=$rincicc['idsupp'];
	$at=substr($tglbeli,-2,2);
				$ab=substr($tglbeli,-5,2);
				$ah=substr($tglbeli,0,4);
				$tgllll=$at.'-'.$ab.'-'.$ah;
	$dd="SELECT namasupp FROM tsupplier WHERE idsupp='".$idsupp."' ";
$pdd=mysql_query($dd);
	while($rincidd=mysql_fetch_array($pdd)){
	$supp=$rincidd['namasupp'];
	}
	
	}
	
	}
	
	}


			
				?>
				
                                        <tr class="gradeC">
                                            <td><? echo $idpc ?></td>
											  <td><? echo $nmpeminta ?></td>
											  <td><? echo $nfak ?></td>
											  	  <td><? echo $tglrakittt ?></td>
												   <td><? echo $supp ?></td>
                                            <td><? echo $mobo ?></td>
                                            <td><? echo $prosesor ?></td>
											<td><? echo $ps ?></td>
											<td><? echo $casing ?></td>
											<td><? echo $hd1 ?></td>
											<td><? echo $hd2 ?></td>
											<td><? echo $ram1 ?></td>
											<td><? echo $ram2 ?></td>
											<td><? echo $fan ?></td>
											<td><? echo $dvd ?></td>
											<td><? echo $keterangan ?></td>
											 <td class="center"><form action="user.php?menu=editstockpc" method="post" >
											<input type="hidden" name="idpc" value=<?php echo $idpc; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Edit</button>
											</form> </td>
                               <td class="center"><form action="user.php?menu=keluarpc" method="post" >
											<input type="hidden" name="idpc" value=<?php echo $idpc; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">PC Baru</button>
											</form> </td>
											 <td class="center"><form action="user.php?menu=rakitupdate" method="post" >
											<input type="hidden" name="idpc" value=<?php echo $idpc; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit">PC Update</button>
											</form> </td>
													  <td class="center"><form action="aplikasi/hiddenstockpc.php" method="post" >
											<input type="hidden" name="idpc" value=<?php echo $idpc; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit" onclick="return confirm('Apakah anda yakin akan menutup data ini?')">Hidden</button>
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
           