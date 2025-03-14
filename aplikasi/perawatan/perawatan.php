<?php
include('config.php');

// Fungsi untuk menghasilkan kode otomatis (diadaptasi untuk SQL Server)
function kdauto($tabel, $inisial, $pdo) {
    $stmt = $pdo->query("SELECT * FROM $tabel");
    $field = $stmt->getColumnMeta(0)['name'];
    $panjang = $stmt->getColumnMeta(0)['len'];

    $qry = $pdo->query("SELECT MAX($field) FROM $tabel");
    $row = $qry->fetch(PDO::FETCH_NUM);
    
    if (empty($row[0])) {
        $angka = 0;
    } else {
        $angka = substr($row[0], strlen($inisial));
    }
    
    $angka++;
    $angka = strval($angka);
    $tmp = "";
    for ($i = 1; $i <= ($panjang - strlen($inisial) - strlen($angka)); $i++) {
        $tmp .= "0";
    }
    return $inisial . $tmp . $angka;
}
?>

<!DOCTYPE html>
<html>
<head>
    <script language="javascript">
        // Fungsi untuk membuka modal edit atau tambah
        function openEditModal(id) {
            document.getElementById('id_perangkat').value = id || '';
            document.getElementById('nama_perangkat').value = '';
            const tbody = document.querySelector('#itemTableEdit tbody');
            tbody.innerHTML = '';

            if (id) {
                fetch(`aplikasi/perawatan/get_perangkat.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('nama_perangkat').value = data.perangkat.nama_perangkat;
                        data.items.forEach(item => {
                            addRowEdit(item.nama_perawatan, item.id);
                        });
                    });
            } else {
                addRowEdit();
            }

            $('#newRegg').modal('show');
        }

        function addRowEdit(itemName = '', id = '') {
            const row = `
                <tr id="itemRow_${id}">
                    <td><input type="text" name="nama_perawatan[]" value="${itemName}" class="form-control" required></td>
                    <td><input type="hidden" name="item_id[]" value="${id}" class="form-control" required></td>
                    <td><button type="button" class="btn btn-danger" onclick="hapusItem('${id}')">Hapus</button></td>
                </tr>
            `;
            document.querySelector('#itemTableEdit tbody').insertAdjacentHTML('beforeend', row);
        }

        function removeRowEdit(button) {
            button.closest('tr').remove();
        }

        function hapusItem(id_item) {
            fetch('aplikasi/perawatan/hapus_item.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id_item=${id_item}`
            })
            .then(response => response.text())
            .then(response => {
                if (response === 'success') {
                    document.getElementById(`itemRow_${id_item}`).remove();
                } else {
                    alert('Gagal menghapus item. Silakan coba lagi.');
                }
            })
            .catch(() => alert('Terjadi kesalahan saat menghapus item.'));
        }

        function simpanPerubahan() {
            const id_perangkat = document.getElementById('id_perangkat').value;
            const nama_perangkat = document.getElementById('nama_perangkat').value;
            const items = Array.from(document.querySelectorAll('#itemTableEdit tbody tr')).map(tr => ({
                id: tr.querySelector('input[name="item_id[]"]').value,
                name: tr.querySelector('input[name="nama_perawatan[]"]').value
            }));

            fetch('aplikasi/perawatan/edit_perawatan.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id_perangkat,
                    nama_perangkat,
                    items
                })
            })
            .then(response => response.text())
            .then(response => {
                if (response === 'success') {
                    alert('Perubahan berhasil disimpan!');
                    $('#newRegg').modal('hide');
                    refresh();
                } else {
                    alert('Gagal menyimpan perubahan. Silakan coba lagi.');
                }
            })
            .catch(() => alert('Terjadi kesalahan saat menyimpan data.'));
        }

        function refresh() {
            location.reload();
        }

        // AJAX untuk filter kategori
        function createRequestObject() {
            return new XMLHttpRequest();
        }

        const http = createRequestObject();
        function sendRequest(idkategori) {
            if (!idkategori) {
                alert("Anda belum memilih kode kategori!");
                return;
            }
            http.open('GET', `aplikasi/filterkategori.php?idkategori=${encodeURIComponent(idkategori)}`, true);
            http.onreadystatechange = handleResponse;
            http.send(null);
        }

        function handleResponse() {
            if (http.readyState === 4) {
                const [idkategori, kategori] = http.responseText.split('&&&');
                document.getElementById('idkategori').value = idkategori;
                document.getElementById('kategori').value = kategori;
                document.getElementById('jumlah').value = '';
                document.getElementById('jumlah').focus();
            }
        }

        let mywin;
        function popup(idkategori) {
            if (!idkategori) {
                alert("Anda belum memilih kategori");
                return;
            }
            mywin = window.open(`manager/lap_jumkat.php?idkategori=${idkategori}`, "_blank",
                "toolbar=yes,location=yes,menubar=yes,copyhistory=yes,directories=no,status=no,resizable=no,width=500,height=400");
            mywin.moveTo(100, 100);
        }

        function addRow() {
            const table = document.querySelector("#itemTable tbody");
            const newRow = table.rows[0].cloneNode(true);
            Array.from(newRow.getElementsByTagName("input")).forEach(input => input.value = "");
            table.appendChild(newRow);
        }

        function removeRow(button) {
            button.closest('tr').remove();
        }
    </script>
</head>
<body>
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h2>Data Master Perawatan</h2>
            </div>
        </div>
        <hr />

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#newReg">Tambah</button>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive" style="overflow: scroll;">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Nama Perangkat</th>
                                        <th>Edit</th>
                                        <th>Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $pdo = new PDO("sqlsrv:Server=localhost;Database=your_database", "username", "password");
                                    $stmt = $pdo->query("SELECT * FROM tipe_perawatan");
                                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $id = $data['id'];
                                        $nama_perangkat = $data['nama_perangkat'];
                                    ?>
                                        <tr class="gradeC">
                                            <td><?= htmlspecialchars($nama_perangkat) ?></td>
                                            <td class="center">
                                                <button type="button" class="btn btn-primary" onclick="openEditModal('<?= $id ?>')">Edit</button>
                                            </td>
                                            <td class="center">
                                                <form action="aplikasi/perawatan/deleteperawatan.php" method="post">
                                                    <input type="hidden" name="id" value="<?= $id ?>" />
                                                    <button name="tombol" class="btn text-muted text-center btn-danger" type="submit">X</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah -->
        <div class="col-lg-12">
            <div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h4 class="modal-title">Tambah Master Perawatan</h4>
                        </div>
                        <div class="modal-body">
                            <form action="aplikasi/perawatan/save_perawatan.php" method="post" enctype="multipart/form-data" name="postform2">
                                <div class="form-group">
                                    <input placeholder="Nama Perangkat" class="form-control" type="text" name="nama_perangkat">
                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="addRow()" class="btn btn-success">Add Item</button>
                                </div>
                                <div class="table-responsive" style="overflow: scroll;">
                                    <table class="table table-striped table-bordered table-hover" id="itemTable">
                                        <thead>
                                            <tr>
                                                <th>Nama Perangkat</th>
                                                <th>Hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text" name="nama_perawatan[]" required></td>
                                                <td><button name="button" onclick="removeRow(this)" class="btn text-muted text-center btn-danger" type="button">X</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="refresh()">Close</button>
                                    <button type="submit" class="btn btn-danger" name="tombol">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="col-lg-12">
            <div class="modal fade" id="newRegg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h4 class="modal-title">Tambah/Edit</h4>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id_perangkat" id="id_perangkat">
                                <div class="form-group">
                                    <input placeholder="Nama Perangkat" class="form-control" type="text" name="nama_perangkat" id="nama_perangkat">
                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="addRowEdit()" class="btn btn-success">Tambah Item</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="itemTableEdit">
                                        <thead>
                                            <tr>
                                                <th>Nama Item</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="refresh()">Tutup</button>
                                    <button type="button" class="btn btn-danger" name="tombol" onclick="simpanPerubahan()">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>