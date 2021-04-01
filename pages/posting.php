<?php
    require_once("../setting.php");   
    require_once("../database.php");  

    $daftar_barang = '';
    $query = mysqli_query($db, "SELECT * FROM barang");
    while($fetch = $query->fetch_assoc()) {
        $id = $fetch['kode'];
        $p_query = mysqli_query($db, "SELECT nama FROM perkiraan WHERE kode ='$id'");
        $f_query = mysqli_fetch_assoc($p_query);
        $daftar_barang .= '
        <tr>
            <td><input type="checkbox" name="select_id[]" value="'.$id.'"/></td>
            <td>'.$id.'</td>
            <td>'.$f_query['nama'].'</td>
            <td>'.$fetch['warna'].'</td>
            <td>'.$fetch['harga'].'</td>
            <td>'.$fetch['stok'].'</td>
        </tr>';
    }
?>
<style>
.ui-datepicker-calendar {
    display: none;
    }
</style>
<div class="main">
    <h2>Posting</h2>
    <p>Pencatatan data di toko mu</p>

    
    <form method="POST">
        Bulan-Tahun Posting :<br>
        <input type="text" class="date-picker" id="waktu">
        <br><br>
        Kode Perkiraan:<br>
        <input type="text" id="kode" disabled="">
        <br>
        Nama Perkiraan:<br>
        <input type="text" id="nama" disabled="">
        <br><br>
        Saldo Akhir:<br>
        <input type="text" id="saldo" readonly="">
        <br><br>
    </form>
    <button onclick="btnPosting()">Tambahkan Barang</button>
</div>
<div class="right">
    <h2>Halaman Terkait</h2>
    <p>Berikut halaman yang terkait</p>

    <ul style="text-align:left;">
        <li onclick="openPage('posting');">Posting Data</li>
        <li onclick="openPage('daftar-posting');"><u>Daftar Posting</u></li>
    </ul>
</div>
<script>
    $(function() {
        $('.date-picker').datepicker( {
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'MM yy',
            yearRange: "-20:+0",
            onClose: function(dateText, inst) { 
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
        });
    });
    function btnPosting() {
        var waktu = $('#waktu').val();
        console.log(waktu);
        
        $.post('proses/posting.php', {
            waktu: waktu
        }, function(result) {
            console.log(result);

            var obj = JSON.parse(result);
            var dkode, dnama, dsaldo;
            alert(obj.pesan);
            if(obj.status == "Sukses") {
                for (let i = 0; i < obj.data.length; i++) {
                     dkode = obj.data[i].kode;
                     dnama = obj.data[i].nama;
                     dsaldo = obj.data[i].saldo;

                    var klik = confirm('Saldo akhir pada '+dnama+' sebesar Rp. '+dsaldo);
                    
                    $('#kode').val(dkode);
                    $('#nama').val(dnama);
                    $('#saldo').val(dsaldo);
                    
                    if(klik) {
                        show(obj.data[i]);
                    }
                }
            }
        });
    }

    function show(obj) {
        $('#kode').val(obj.kode);
        $('#nama').val(obj.nama);
        $('#saldo').val(obj.saldo);

        console.log(obj);

        return;
    }

    function sleep(milliseconds) {
        const date = Date.now();
        let currentDate = null;
        do {
            currentDate = Date.now();
        } while (currentDate - date < milliseconds);
    }
</script>