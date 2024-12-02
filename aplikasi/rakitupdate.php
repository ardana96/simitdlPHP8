<?include('config.php');
	if(isset($_POST['idpc'])){
$idpcc=$_POST['idpc'];
	}
?>  

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2>Pemilihan PC untuk di Upadate Ke PC <? echo $idpcc; ?></h2>



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
										<th>Nomor</th>
											<th>IPPC</th>
                                            <th>User</th>
                                            <th>Nama PC</th>
                                            <th>Bagian</th>
										
											<th>Update</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM pcaktif order by ippc desc ");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$user=$data['user'];
				$nomor=$data['nomor'];
				$bagian=$data['bagian'];
				$namapc=$data['namapc'];
				$ippc=$data['ippc'];
				
			
				?>
				
                                        <tr class="gradeC">
										<td><? echo $nomor ?></td>
												<td><? echo $ippc ?></td>
                                            <td><? echo $user ?></td>
                                            <td><? echo $namapc?></td>
                                            <td><? echo $bagian ?></td>
									
											
                            
											 <td class="center"><form action="user.php?menu=formrakitupdate" method="post" >
											<input type="hidden" name="idpcc" value=<?php echo $idpcc; ?> />
											<input type="hidden" name="nomor" value=<?php echo $nomor; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit">Update</button>
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
           