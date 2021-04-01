
<div class="main">
    <h2>Tambah Perkiraan</h2>
    <p>Tambahkan kode dan nama perkiraan yang dibutuhkan sebelum melakukan aktifitas transaksi</p>
    <form method="POST">
        Kode Perkiraan:<br>
        <input type="text" id="kode">
        <br>
        Nama Perkiraan:<br>
        <input type="text" id="nama">
        <br><br>
        <input type="button" value="Tambahkan" id="BtnInput" onclick="SendProses()">
    </form>
</div>
<div class="right">
    <h2>Halaman Terkait</h2>
    <p>Berikut halaman yang terkait Perkiraan</p>

    <ul>
        <li>Tambah Perkiraan</li>
        <li onclick="openPage('jurnal-perkiraan');"><u>Daftar Perkiraan</u></li>
    </ul>
</div>

<script>
    function SendProses() {
        var kode = $('#kode').val();
        var nama = $('#nama').val();
        
        if(kode == '' || nama == '') {
            alert("Server : Error\nPesan : Data tidak terkirim, karena form tidak terisi penuh")
        } else {
            $.post('proses/add-perkiraan.php', {kode:kode, nama:nama}, function(result){
                var obj_r = JSON.parse(result);
                alert("Server : " + obj_r.status+"\nPesan : "+ obj_r.pesan);
            });
        }

        $('#kode').val('');
        $('#nama').val('');
    }

    $('#kode').keyup(function() {
        var kode = $('#kode').val();
        if(kode.length > 4) {
            $("#nama").focus();
        }
    });

    $("#nama").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#BtnInput").focus();
        }
    });
</script>