<?include('config.php');?>  

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2> Data Pengembalian</h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                      
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
										       <th>Nama</th>
                                            <th>Tgl Peminjaman </th>
                                            <th>Jam</th>
                                            
											<th>Bagian</th>
											<th>Divisi</th>
											<th>Nama Barang</th>
											<th>Jumlah</th>
											<th>Telp</th>
											<th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT *,sum(jumlah) as jum FROM tpinjam,trincipinjam,bagian where tpinjam.nopinjam=trincipinjam.nopinjam 
									   and trincipinjam.status='pinjam' and tpinjam.bagian=bagian.id_bagian group by trincipinjam.idbarang");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$nopinjam=$data['nopinjam'];
				$tgl1=$data['tgl1'];
				$jam1=$data['jam1'];
				$jum=$data['jum'];
				$nama=$data['nama'];
				$bagian=$data['bagian'];
				$divisi=$data['divisi'];
				$namabarang=$data['namabarang'];
				$jumlah=$data['jumlah'];
				$telp=$data['telp'];
				$idbarang=$data['idbarang'];
			
				?>
				
                                        <tr class="gradeC">
										<td><? echo $nama ?></td>
                                            <td><? echo $tgl1 ?></td>
                                            <td><? echo $jam1 ?></td>
                                         
											<td><? echo $bagian ?></td>
											<td><? echo $divisi ?></td>
											<td><? echo $namabarang ?></td>
											<td><? echo $jum ?></td>
											<td><? echo $telp ?></td>
                             
										
											  <td class="center"><form action="aplikasi/updatepinjam.php" method="post" >
											<input type="hidden" name="nopinjam" value='<?php echo $nopinjam; ?>'>
										<input type="hidden" name="idbarang" value='<?php echo $idbarang; ?>'>
										<input type="hidden" name="jumlah" value='<?php echo $jumlah; ?>'>
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit">Kembalikan</button>
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
			<meta http-equiv=refresh content=180;url='pemakai.php?menu=home'>
           