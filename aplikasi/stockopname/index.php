<?php include('config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemakai Komputer V2</title>
    <!-- Tambahkan link ke styleop.css -->
    <link rel="stylesheet" href="aplikasi/stockopname/stockopstyle/styleop.css">
    <!-- Jika ada Bootstrap atau CSS lain, pastikan tetap disertakan -->
</head>
<body>
<div class="inner">
    <div class="row">
        <div class="col-lg-12">
            <h2>Daftar Pemakai Komputer V2</h2>
        </div>
    </div>
    <hr />

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="user.php?menu=inputpcV2">
                        <button class="btn btn-primary">Tambah PC</button>
                    </a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive" style='overflow: scroll;'>
                        <table class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>IP PC</th>
                                    <th>ID PC</th>
                                    <th>User</th>
                                    <th>Nama PC</th>
                                    <th>Bagian</th>
                                    <th>Sub Bagian</th>
                                    <th>Lokasi</th>
                                    <th>Prosesor</th>
                                    <th>Motherboard</th>
                                    <th>Ram</th>
                                    <th>Harddisk</th>
                                    <th>Bulan</th>
                                    <th>Cek Perawatan</th>
                                    <th>Perawatan</th>
                                    <th>Spesifikasi</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <tbody id="dataBody">
                                <!-- Data akan dimasukkan lewat AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Tambahkan tempat pagination -->
                    <div id="pagination" style="margin-top: 20px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('scriptstop/scriptop.php'); ?>
</body>
</html>