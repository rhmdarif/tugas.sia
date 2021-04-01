<?php
    require_once("../setting.php");   
    require_once("../database.php");   

    (isset($_POST['select_id']))? true : die();

    $select_id = mysqli_real_escape_string($db, $_POST['select_id']);
    
    $query_s = mysqli_query($db, "SELECT nama FROM perkiraan WHERE kode='$select_id'");
    $fetch_s = mysqli_fetch_assoc($query_s);

?>
<div class="main">
    <h2>Ubah Perkiraan</h2>
    <p>Ubah nama perkiraan</p>
    <form method="POST">
        Kode Perkiraan:<br>
        <input type="text" id="kode" value="<?php echo $select_id; ?>">
        <br>
        Nama Perkiraan:<br>
        <input type="text" id="nama" value="<?php echo $fetch_s['nama']; ?>">
        <br><br>
        <input type="button" value="Submit" onclick="SendProses()">
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
    function SendProses() {
        var kode = $('#kode').val();
        var nama = $('#nama').val();
        
        if(kode == '' || nama == '') {
            alert("Server : Error\nPesan : Data tidak terkirim, karena form tidak terisi penuh")
        } else {
            $.post('proses/ubah-perkiraan.php', {kode:kode, nama:nama}, function(result){
                var obj_r = JSON.parse(result);
                alert("Server : " + obj_r.status+"\nPesan : "+ obj_r.pesan);
            });
        }
    }
</script>