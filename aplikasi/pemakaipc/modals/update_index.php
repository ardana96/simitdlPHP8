<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Update Spesifikasi PC</title>
    <link rel="stylesheet" href="aplikasi/pemakaipc/style/update_style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="aplikasi/pemakaipc/scripts/script_update_pemakaipc.php"></script>
</head>
<body>
    <h4 align="center">UPDATE SPESIFIKASI PC</h4>
    <div id="info_transaksi">
        <form method="post" action="aplikasi/pemakaipc/actions/save_update_pemakaipc.php" enctype="multipart/form-data" name="postform2">
            <div class="form-group">
                Tanggal Service<br>
                <input required value="<?php echo $tglupdate; ?>" type="text" id="from" name="tgl_update" class="isi_tabel" onclick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;">
                <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;">
                    <img name="popcal" align="absmiddle" style="border:none" src="/simitdlPHP8/calender/calender.jpeg" width="34" height="29" border="0" alt="">
                </a>
            </div>

            <div class="form-group">
                Divisi
                <select class="form-control" name="divisi" required>
                    <option value="<?php echo $divisi; ?>"><?php echo $divisi; ?></option>
                    <option value="AMBASADOR">AMBASADOR</option>
                    <option value="EFRATA">EFRATA</option>
                    <option value="GARMENT">GARMENT</option>
                    <option value="MAS">MAS</option>
                    <option value="TEXTILE">TEXTILE</option>
                </select>
            </div>

            <div class="form-group">
                Bagian
                <select class="form-control" name="bagian" required>
                    <option value="<?php echo $bagian; ?>"><?php echo $bagian; ?></option>
                    <?php
                    $query = "SELECT * FROM bagian_pemakai ORDER BY bag_pemakai ASC";
                    $stmt = sqlsrv_query($conn, $query);
                    while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        echo '<option value="' . $datas['bag_pemakai'] . '">' . $datas['bag_pemakai'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                Sub Bagian
                <select class="form-control" name="subbagian" required>
                    <option value="<?php echo $subbagian; ?>"><?php echo $subbagian; ?></option>
                    <?php
                    $query = "SELECT * FROM sub_bagian ORDER BY subbag_nama ASC";
                    $stmt = sqlsrv_query($conn, $query);
                    while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        echo '<option value="' . $datas['subbag_nama'] . '">' . $datas['subbag_nama'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                Lokasi
                <select class="form-control" name="lokasi" required>
                    <option value="<?php echo $lokasi; ?>"><?php echo $lokasi; ?></option>
                    <?php
                    $query = "SELECT * FROM lokasi ORDER BY lokasi_nama ASC";
                    $stmt = sqlsrv_query($conn, $query);
                    while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        echo '<option value="' . $datas['lokasi_nama'] . '">' . $datas['lokasi_nama'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                User
                <input class="form-control" type="text" name="user" value="<?php echo $user; ?>">
            </div>

            <div class="form-group">
                ID Komputer
                <input class="form-control" type="text" name="idpc" value="<?php echo $idpc; ?>">
            </div>

            <div class="form-group">
                Nama Komputer
                <input class="form-control" type="text" name="namapc" value="<?php echo $namapc; ?>">
            </div>
        </div>

        <div id="data_barang">
            <div class="panel-body">
                <div class="form-group">
                    <b>Operation System</b>
                    <input class="form-control" type="text" name="os" value="<?php echo $os; ?>">
                </div>

                <div class="form-group">
                    <b>IP Komputer</b>
                    <input class="form-control" type="text" name="ippc" value="<?php echo $ippc; ?>">
                </div>

                <div class="form-group">
                    <b>Total Kapasitas Harddisk</b>
                    <input class="form-control" type="text" name="harddisk" value="<?php echo $harddisk; ?>">
                </div>

                <div class="form-group">
                    <b>Total Kapasitas RAM</b>
                    <input class="form-control" type="text" name="ram" value="<?php echo $ram; ?>">
                </div>

                <?php if ($model == "CPU") { ?>
                    <div class="form-group">
                        <b>Monitor</b>&nbsp;<font color="red">Tidak Mengurangi Stock Hanya Merubah Nama</font>
                        <select class="form-control" name="monitor">
                            <option value="<?php echo $monitor; ?>"><?php echo $monitor; ?></option>
                            <?php
                            $sql = "SELECT * FROM tbarang WHERE idkategori = ?";
                            $params = ['00009'];
                            $stmt = sqlsrv_query($conn, $sql, $params);
                            while ($datamonitor = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo '<option value="' . $datamonitor['namabarang'] . '">' . $datamonitor['namabarang'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <b>Model</b>
                        <select class="form-control" name="model" required>
                            <option value="<?php echo $model; ?>"><?php echo $model; ?></option>
                            <option value="cpu">CPU</option>
                            <option value="laptop">LAPTOP</option>
                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <b>RAM Slot 1</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <select class="form-control" name="ram1">
                            <option value="<?php echo $ram1; ?>"><?php echo $ram1; ?></option>
                            <?php
                            $query = "SELECT * FROM tbarang WHERE idkategori = '00006' AND stock > 0";
                            $stmt = sqlsrv_query($conn, $query);
                            while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo '<option value="' . $datas['idbarang'] . '">' . $datas['namabarang'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <b>RAM Slot 2</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <select class="form-control" name="ram2">
                            <option value="<?php echo $ram2; ?>"><?php echo $ram2; ?></option>
                            <?php
                            $query = "SELECT * FROM tbarang WHERE idkategori = '00006' AND stock > 0";
                            $stmt = sqlsrv_query($conn, $query);
                            while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo '<option value="' . $datas['idbarang'] . '">' . $datas['namabarang'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <b>Harddisk Slot 1</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <select class="form-control" name="hd1">
                            <option value="<?php echo $hd1; ?>"><?php echo $hd1; ?></option>
                            <?php
                            $query = "SELECT * FROM tbarang WHERE idkategori = '00005' AND stock > 0";
                            $stmt = sqlsrv_query($conn, $query);
                            while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo '<option value="' . $datas['idbarang'] . '">' . $datas['namabarang'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <b>Harddisk Slot 2</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <select class="form-control" name="hd2">
                            <option value="<?php echo $hd2; ?>"><?php echo $hd2; ?></option>
                            <?php
                            $query = "SELECT * FROM tbarang WHERE idkategori = '00005' AND stock > 0";
                            $stmt = sqlsrv_query($conn, $query);
                            while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo '<option value="' . $datas['idbarang'] . '">' . $datas['namabarang'] . '</option>';
                            }
                            ?>
                        </select>
                    </div> -->

                    <div class="form-group">
                        <b>Motherboard</b>&nbsp;<font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <select class="form-control" name="mobo">
                            <option value="<?php echo $mobo; ?>"><?php echo $mobo; ?></option>
                            <?php
                            $query = "SELECT * FROM tbarang WHERE idkategori = '00001' AND stock > 0";
                            $stmt = sqlsrv_query($conn, $query);
                            while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo '<option value="' . $datas['idbarang'] . '">' . $datas['namabarang'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <b>Prosesor</b>&nbsp;<font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <select class="form-control" name="prosesor">
                            <option value="<?php echo $prosesor; ?>"><?php echo $prosesor; ?></option>
                            <?php
                            $query = "SELECT * FROM tbarang WHERE idkategori = '00002' AND stock > 0";
                            $stmt = sqlsrv_query($conn, $query);
                            while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo '<option value="' . $datas['idbarang'] . '">' . $datas['namabarang'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <b>Power Supply</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <select class="form-control" name="powersuply">
                            <option value="<?php echo $powersuply; ?>"><?php echo $powersuply; ?></option>
                            <?php
                            $query = "SELECT * FROM tbarang WHERE idkategori = '00003' AND stock > 0";
                            $stmt = sqlsrv_query($conn, $query);
                            while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo '<option value="' . $datas['idbarang'] . '">' . $datas['namabarang'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <b>Cassing</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <select class="form-control" name="cassing">
                            <option value="<?php echo $cassing; ?>"><?php echo $cassing; ?></option>
                            <?php
                            $query = "SELECT * FROM tbarang WHERE idkategori = '00004' AND stock > 0";
                            $stmt = sqlsrv_query($conn, $query);
                            while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo '<option value="' . $datas['idbarang'] . '">' . $datas['namabarang'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <b>DVD Internal</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <select class="form-control" name="dvd">
                            <option value="<?php echo $dvd; ?>"><?php echo $dvd; ?></option>
                            <?php
                            $query = "SELECT * FROM tbarang WHERE idkategori = '00008' AND stock > 0";
                            $stmt = sqlsrv_query($conn, $query);
                            while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                echo '<option value="' . $datas['idbarang'] . '">' . $datas['namabarang'] . '</option>';
                            }
                            ?>
                        </select>
                    </div> -->
                <?php } else { ?>
                    <div class="form-group">
                        <b>Seri</b>&nbsp;<font color="red">Tidak Mengurangi Stock Hanya Merubah Nama</font>
                        <input class="form-control" type="text" name="seri" value="<?php echo $seri; ?>">
                    </div>

                    <div class="form-group">
                        <b>Monitor</b>&nbsp;<font color="red">Tidak Mengurangi Stock Hanya Merubah Nama</font>
                        <input class="form-control" type="text" name="monitor" value="<?php echo $monitor; ?>">
                    </div>

                    <div class="form-group">
                        <b>Model</b>
                        <select class="form-control" name="model" required>
                            <option value="<?php echo $model; ?>"><?php echo $model; ?></option>
                            <option value="cpu">CPU</option>
                            <option value="laptop">LAPTOP</option>
                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <b>RAM Slot 1</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <input class="form-control" type="text" name="ram1" value="<?php echo $ram1; ?>">
                    </div>

                    <div class="form-group">
                        <b>RAM Slot 2</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <input class="form-control" type="text" name="ram2" value="<?php echo $ram2; ?>">
                    </div>

                    <div class="form-group">
                        <b>Harddisk Slot 1</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <input class="form-control" type="text" name="hd1" value="<?php echo $hd1; ?>">
                    </div>

                    <div class="form-group">
                        <b>Harddisk Slot 2</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <input class="form-control" type="text" name="hd2" value="<?php echo $hd2; ?>">
                    </div> -->

                    <div class="form-group">
                        <b>Motherboard</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <input class="form-control" type="text" name="mobo" value="<?php echo $mobo; ?>">
                    </div>

                    <div class="form-group">
                        <b>Prosesor</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <input class="form-control" type="text" name="prosesor" value="<?php echo $prosesor; ?>">
                    </div>

                    <!-- <div class="form-group">
                        <b>Power Supply</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <input class="form-control" type="text" name="powersuply" value="<?php echo $powersuply; ?>">
                    </div>

                    <div class="form-group">
                        <b>Cassing</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <input class="form-control" type="text" name="cassing" value="<?php echo $cassing; ?>">
                    </div>

                    <div class="form-group">
                        <b>DVD Internal</b><font color="red">Tidak Merubah Stock Hanya Mengganti Nama</font>
                        <input class="form-control" type="text" name="dvd" value="<?php echo $dvd; ?>">
                    </div> -->
                <?php } ?>

                <div class="form-group">
                    Bulan Perawatan
                    <select class="form-control" name="bulan" required>
                        <option value="<?php echo $bulan; ?>"><?php echo $namabulan; ?></option>
                        <?php
                        $sql = "SELECT * FROM bulan ORDER BY id_bulan ASC";
                        $stmt = sqlsrv_query($conn, $sql);
                        while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo '<option value="' . $datas['id_bulan'] . '">' . $datas['bulan'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">

                    Keterangan 
                    <textarea cols="45" rows="7" name="keterangan" class="form-control" size="15px" placeholder="" required="required"><?php echo htmlspecialchars($keterangan); ?></textarea>
               
                </div>

                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="nomor" value="<?php echo $nomor; ?>">
                <button name="tombol" id="button_selesai" class="btn btn-danger" type="submit">Simpan</button>
            </div>
        </div>
    </form>
</body>
</html>

<iframe width="174" height="189" name="gToday:normal:/simitdlPHP8/calender/agenda.js" id="gToday:normal:/simitdlPHP8/calender/agenda.js" src="/simitdlPHP8/calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>