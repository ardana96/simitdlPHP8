<!-- <?php
header('Content-Type: application/javascript');
?>

// Pastikan jQuery sudah dimuat sebelum kode ini dijalankan
function dontEnter(evt) { 
    evt = evt || window.event;
    var node = evt.target || evt.srcElement;
    if (evt.keyCode == 13 && node.type == "text") return false;
}

$(document).ready(function() {
    // Bind fungsi dontEnter ke event keypress
    $(document).on('keypress', dontEnter);

    // Fokus ke input 'from' saat halaman dimuat
    $('#from').focus();
}); -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Pastikan jQuery sudah dimuat sebelum kode ini dijalankan
function dontEnter(evt) { 
    evt = evt || window.event;
    var node = evt.target || evt.srcElement;
    if (evt.keyCode == 13 && node.type == "text") return false;
}

$(document).ready(function() {
    // Bind fungsi dontEnter ke event keypress
    $(document).on('keypress', dontEnter);

    // Fokus ke input 'from' saat halaman dimuat
    $('#from').focus();
});
$(document).ready(function() {
        // Panggil save_lastpage.php untuk menyimpan status halaman saat membuka formulir
        $.ajax({
            url: 'aplikasi/stockopname/actionstop/save_lastpage.php',
            method: 'POST',
            data: {
                page: <?php echo isset($_SESSION['current_page']) ? $_SESSION['current_page'] : 1; ?>,
                recordsPerPage: <?php echo isset($_SESSION['records_per_page']) ? $_SESSION['records_per_page'] : 10; ?>
            },
            success: function(response) {
                console.log("Status halaman disimpan saat membuka update:", response);
            },
            error: function(xhr, status, error) {
                console.error("Gagal menyimpan status halaman:", error);
            }
        });

        // Tambahkan validasi atau logika tambahan jika diperlukan, misalnya:
        $('form').on('submit', function(e) {
            // Validasi formulir sebelum submit (opsional)
            console.log("Formulir disubmit dengan data:", $(this).serialize());
        });
    });
</script>