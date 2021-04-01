<?php
    require_once("../setting.php");   
    require_once("../database.php");  

    $daftar_perkiraan = '';
    $query = mysqli_query($db, "SELECT * FROM perkiraan");
    while($fetch = $query->fetch_assoc()) {
        $daftar_perkiraan .= '<option value="'.$fetch['kode'].'">'.$fetch['kode'].'</option>';
    }

    if(isset($_POST['select_id'])) {
        $arr = array();
        $i = 0;
        for ($i=0; $i < COUNT($_POST['select_id']); $i++) { 
            $id = $_POST['select_id'][$i];
            $arr['select_id'][] = $id;
            $arr['jumlah'][] = $_POST['jumlah'][$i];
            $arr['tipe'][] = $_POST['tipe'];

            $p_query = mysqli_query($db, "SELECT nama FROM perkiraan WHERE kode='$id'");
            $p_fetch = mysqli_fetch_assoc($p_query);
            $arr['nama'][] = $p_fetch['nama'];

            $b_query = mysqli_query($db, "SELECT harga FROM barang WHERE kode='$id'");
            $b_fetch = mysqli_fetch_assoc($b_query);
            $arr['modal'][] = $b_fetch['harga'];
        }

        $data = json_encode($arr);
    }
?>
<style>
    input {
        width:100%;
    }

    span {
        position:relative;
        text-align: right;
        font-weight: bold;
    }
</style>
<div class="main">
    <h2>Tambah Transaksi</h2>
    <p>Ingat!! Setiap transaksi harus dicatat!</p>
    <form method="POST">
        <span>Nomor Bukti:</span><br>
        <input type="text" id="nb">
        <br>
        <span>Tanggal Transaksi:</span><br>
        <input type="date" id="tgl">
        <br>
        <span>Keterangan:</span><br>
        <input type="text" id="kt">
        <br><br>
        <span>Kode Perkiraan:</span><br>
        <select id="kd">
            <option selected="" disabled="">Pilih Perkiraan</option>
            <?php echo $daftar_perkiraan; ?>
        </select>
        <br>
        <span>Nama Perkiraan:</span><br>
        <input type="text" id="nm" readonly="">
        <br><br>
        <span>Jenis transaksi:</span><br>
        <select id="jns">
            <option selected="">Pilih Jenis</option>
            <option value="k">Kredit</option>
            <option value="d">Debet</option>
        </select>
        <br>
        <span>Jumlah Transaksi:</span><br>
        <input type="text" id="jml">
        <br><br>
        <span>Debit:</span><br>
        <input type="text" id="db" readonly="">
        <br>
        <span>Kredit:</span><br>
        <input type="text" id="cr" readonly="">
        <br><br>
        <button type="button" id="BtnSimpan">Simpan</button>
        <button type="button" id="BtnTambah" disabled="">Tambahkan</button>
    </form>
</div>
<div class="right">
    <h2>Halaman Terkait</h2>
    <p>Berikut halaman yang terkait</p>

    <ul style="text-align:left;">
        <li onclick="openPage('stok-barang');"><u>Persediaan Barang</u></li>
        <li onclick="openPage('barang-masuk');"><u>Barang Masuk</u></li>
        <li onclick="openPage('barang-keluar');"><u>Barang Keluar</u></li>
        <li onclick="openPage('transaksi-lainnya');">Transaksi Lainnya</li>
    </ul>
</div>

<script>
    var no_bukti, tgl_trx, keterangan, debet = 0, kredit= 0;
    var kode_perkiraan = [];
    var jenis_trx = [];
    var jmlh_trx = [];
</script>
<?php if(isset($_POST['select_id'])) { ?>
<div class="right">
    <h2>Barang Masuk / Keluar</h2>
    <p>Berikut daftar barang yang dipengaruhi</p>

    <ul id="baranglist">
        <li>Tambah Perkiraan</li>
    </ul>
</div>

<script>

    var post = '<?php echo $data; ?>';
    var post_obj = JSON.parse(post);
    console.log(post_obj);
    var total = 0;
    for (let i = 0; i < post_obj.select_id.length; i++) {
        const select_id = post_obj.select_id[i];
        const jumlah = post_obj.jumlah[i];
        const modal = post_obj.modal[i];
        const tipe = post_obj.tipe[i];

        const harga = modal*jumlah;
        $("#baranglist").append('<li>'+select_id+' x '+jumlah+' = Rp. '+harga+'</li>');
        
        
        total = total+harga;
        
        kode_perkiraan[i] = select_id;
        jenis_trx[i] = tipe;
        jmlh_trx[i] = harga;

        if(tipe == 'd') {
            debet = debet+Number(harga);
            $('#db').val(debet);
        } else {
            kredit = kredit+Number(harga);
            $('#cr').val(kredit);
        }
        
        $("#jml").val('');
        $("#nb").focus();

    }

    $("#baranglist").append('<li>Total Keseluruhan = Rp. '+total+'</li>');

</script>
<?php } ?>

<script>
    
    $('#BtnTambah').click(function() {

        if(debet == kredit) {
            no_bukti = $("#nb").val();
            tgl_trx = $("#tgl").val();
            keterangan = $("#kt").val();
            debet = Number($("#db").val());
            kredit = Number($("#cr").val());
            
            if(no_bukti == '' || tgl_trx == '' || keterangan == '' || debet == '' || kredit == '' || kode_perkiraan == [] || jenis_trx==[] || jmlh_trx==[]) {
                alert("Server : Error\nPesan : Data tidak terkirim, karena form tidak terisi penuh")
            } else {
                $.post('proses/add-transaksi.php', {no_bukti:no_bukti, tgl_trx:tgl_trx, keterangan:keterangan, debet:debet, kredit:kredit, kode_perkiraan:kode_perkiraan, jenis_trx:jenis_trx, jmlh_trx:jmlh_trx}, function(result){
                    console.log(result);
                    var obj_r = JSON.parse(result);
                    alert("Server : " + obj_r.status+"\nPesan : "+ obj_r.pesan);
                });

                debet = 0;
                $("#db").val('');
                kredit = 0;
                $("#cr").val('');
                kode_perkiraan = [];
                jenis_trx = [];
                jmlh_trx = [];
            }

            $("input").val('');

        } else {
            alert("Data Belum balance");
        }

    });

    $('#kd').change(function() {
        $.post('proses/cek-perkiraan.php', {kode:this.value}, function(result){
            var obj_r = JSON.parse(result);
            if(obj_r.status == "Sukses") {
                $("#nm").val(obj_r.pesan);
            } else {
                alert("Server : " + obj_r.status+"\nPesan : "+ obj_r.pesan);
            }
        });
    });

    $('#jml').change(function() {
        $("#jml").focus();
    });

    $('#kd').focusout(function() {
        $("#jns").focus();
    });

    $("#jml").keyup(function(event) {
        if (event.keyCode === 13) {
            var type = $('#jns').val();

            if(type == 'd') {
                debet = debet+Number(this.value);
                $('#db').val(debet);
            } else {
                kredit = kredit+Number(this.value);
                $('#cr').val(kredit);
            }

            $("#BtnSimpan").focus();
        }
    });

    $('#BtnSimpan').click(function() {

        var jmlh = $("#jml").val();
        var jns = $("#jns").val();
        var kd = $("#kd").val();

        //var length = kode_perkiraan.length++;
        kode_perkiraan[kode_perkiraan.length++] = kd;
        jenis_trx[jenis_trx.length++] = jns;
        jmlh_trx[jmlh_trx.length++] = jmlh;

        if(debet == kredit) {
            $("#BtnTambah").removeAttr("disabled");
            $("#BtnTambah").focus();
        } else {
            $("#jml").val('');
            $("#kd").focus();

        }
    });
</script>