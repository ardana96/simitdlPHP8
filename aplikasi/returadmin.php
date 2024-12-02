<?include('config.php');?>  

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2> Retur Pengambilan</h2>



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
										 <th>No Faktur</th>
										       <th>Tgl </th>
                                            <th>Jam</th>
                                            <th>Nama</th>
                                            
											<th>Bagian</th>
											<th>Divisi</th>
										
											<th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <? $date=date('20y-m');
									   $datee=$date.'%';
									   $sql = mysql_query("SELECT * from tpengambilan,bagian where tpengambilan.bagian=bagian.id_bagian ");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$nofaktur=$data['nofaktur'];
				$tglambil=$data['tglambil'];
				$jam=$data['jam'];
				$nama=$data['nama'];
				$bagian=$data['bagian'];
				$divisi=$data['divisi'];
		
			
				?>
				
                                        <tr class="gradeC">
												<td><? echo $nofaktur ?></td>
										<td><? echo $tglambil ?></td>
                                            <td><? echo $jam ?></td>
                                            <td><? echo $nama?></td>
											<td><? echo $bagian ?></td>
											<td><? echo $divisi ?></td>
										
                             
										
											  <td class="center">
									<form action="user.php?menu=freturpengambilanadmin" method="post" >
									
											<input type="hidden" name="nofaktur" value=<?php echo $nofaktur; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Retur</button>
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
			<meta http-equiv=refresh content=180;url='user.php?menu=homeadmin'>
           