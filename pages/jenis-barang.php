
<div class="main">
    <h2>Tambah Jenis Barang</h2>
    <p>Tambahkan kode dan nama perkiraan yang dibutuhkan sebelum melakukan aktifitas transaksi</p>
    <form method="POST">
        Kode Barang:<br>
        <input type="text" id="kode">
        <br>
        Nama/Jenis Barang:<br>
        <input type="text" id="nama">
        <br>
        Harga Barang:<br>
        <input type="text" id="harga">
        <br>
        Warna Barang:<br>
        <input type="text" id="warna">
        <br><br>
        <input type="button" value="Tambahkan" id="BtnInput" onclick="SendProses()">
    </form>
</div>
<div class="right">
    <h2>Halaman Terkait</h2>
    <p>Berikut halaman yang terkait Perkiraan</p>

    <ul style="text-align:left;">
        <li onclick="openPage('jenis-barang');"><u>Jenis Barang</u></li>
        <li onclick="openPage('stok-barang');">Persediaan Barang</li>
        <li onclick="openPage('barang-masuk');"><u>Barang Masuk</u></li>
        <li onclick="openPage('barang-keluar');"><u>Barang Keluar</u></li>
        <li onclick="openPage('transaki-lainnya');"><u>Transaksi Lainnya</u></li>
    </ul>
</div>

<script>
    function SendProses() {
        var kode = $('#kode').val();
        var nama = $('#nama').val();
        var harga = $('#harga').val();
        var warna = $('#warna').val();
        
        if(kode == '' || warna == '') {
            alert("Server : Error\nPesan : Data tidak terkirim, karena form tidak terisi penuh")
        } else {
            $.post('proses/add-jenis-barang.php', {kode:kode, nama:nama, harga:harga, warna:warna}, function(result){
                var obj_r = JSON.parse(result);
                alert("Server : " + obj_r.status+"\nPesan : "+ obj_r.pesan);
            });
        }

        $('#kode').val('');
        $('#nama').val('');
        $('#harga').val('');
        $('#warna').val('');
    }

    $('#kode').keyup(function() {
        var kode = $('#kode').val();
        if(kode.length > 6) {
            $("#nama").focus();
        }
    });

    $("#nama").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#BtnInput").focus();
        }
    });
</script>