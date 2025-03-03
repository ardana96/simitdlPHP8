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

</script>