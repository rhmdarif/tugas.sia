<?php
    require_once("../setting.php");   
    require_once("../database.php");   

    (isset($_POST['select_id']))? true : die();

    $select_id = mysqli_real_escape_string($db, $_POST['select_id'][0]);
    
    $query_s = mysqli_query($db, "SELECT nama FROM perkiraan WHERE kode='$select_id'");
    $fetch_s = mysqli_fetch_assoc($query_s);

?>
<div class="main">
    <h2>Ubah Perkiraan</h2>
    <p>Ubah nama perkiraan</p>
    <button type="button" style="margin-bottom: 25px;" onclick="openPage('jurnal-perkiraan')">Kembali</button>
    <form method="POST">
        Kode Perkiraan:<br>
        <input type="text" id="kode" value="<?php echo $select_id; ?>" disabled="">
        <br>
        Nama Perkiraan:<br>
        <input type="text" id="nama" value="<?php echo $fetch_s['nama']; ?>" onfocus="this.value = this.value;">
        <br><br>
        <input type="button" id="BtnInput" value="Submit" onclick="SendProses()">
    </form>
</div>
<div class="right">
    <h2>Halaman Terkait</h2>
    <p>Berikut halaman yang terkait Perkiraan</p>

    <ul>
        <li>Tambah Perkiraan</li>
        <li onclick="openPage('jurnal-perkiraan');"><u>Jurnal Perkiraan</u></li>
    </ul>
</div>

<script>
    $('#nama').focus();
    var nama = $('#nama').val();
    $('#nama').val('');
    $('#nama').val(nama);
    
    function SendProses() {
        var kode = '<?php echo $select_id; ?>';
        var nama = $('#nama').val();
        
        if(kode == '' || nama == '') {
            alert("Server : Error\nPesan : Data tidak terkirim, karena form tidak terisi penuh")
        } else {
            $.post('proses/edit-perkiraan.php', {kode:kode, nama:nama}, function(result){
                var obj_r = JSON.parse(result);
                alert("Server : " + obj_r.status+"\nPesan : "+ obj_r.pesan);
            });
        }
    }

    
    $("#nama").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#BtnInput").focus();
        }
    });
</script>