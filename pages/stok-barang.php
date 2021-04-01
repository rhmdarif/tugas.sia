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
            <td>'.$fetch['harga']*$fetch['stok'].'</td>
        </tr>';
    }
?>
<div class="main">
    <h2>Persediaan Barang</h2>
    <p>Berikut persediaan barang yang kamu miliki.</p>
    <button onclick="openPage('jenis-barang')">Tambahkan Jenis Barang</button>
    

    <table style="width:100%">
        <tr>
            <th>#</th>
            <th>Kode</th>
            <th>Varian</th>
            <th>Warna</th>
            <th>Harga satuan</th>
            <th>Stok</th>
            <th>Total</th>
        </tr>
        <?php echo $daftar_barang; ?>
    </table>
    <button onclick="btnEdit()">Edit</button>
    <button onclick="btnHapus()">Hapus</button>
</div>
<div class="right">
    <h2>Halaman Terkait</h2>
    <p>Berikut halaman yang terkait</p>

    <ul style="text-align:left;">
        <li onclick="openPage('stok-barang');">Persediaan Barang</li>
        <li onclick="openPage('barang-masuk');"><u>Barang Masuk</u></li>
        <li onclick="openPage('barang-keluar');"><u>Barang Keluar</u></li>
        <li onclick="openPage('transaksi-lainnya');"><u>Transaksi Lainnya</u></li>
    </ul>
</div>

<script>
    function btnEdit() {
        var input = [];
        $(':checkbox:checked').each(function(i) {
            input[i] = $(this).val();
        });

        if (input.length == 1) {
            $.post('pages/ubah-perkiraan.php', {
                select_id: input
            }, function(result) {
                $('#konten').html(result);
            });
        } else {
            alert("Server: Hanya dapat merubah 1 data.")
        }
    }

    function btnHapus() {
        var input = [];
        $(':checkbox:checked').each(function(i) {
            input[i] = $(this).val();
        });

        if (input.length > 0) {
            var k = confirm("Perhatian!\nAnda akan menghapus " + input.length + " data.");
            if (k == true) {
                $.post('proses/hapus-barang.php', {
                    select_id: input
                }, function(result) {
                    var obj_r = JSON.parse(result);

                    alert("Server : " + obj_r.status + "\nPesan : " + obj_r.pesan);
                    if (obj_r.status == 'Success') {
                        window.setTimeout(function() {
                            $('#konten').load("pages/jurnal-perkiraan.php");
                        }, 1000);
                    }
                });
            } else {
                alert("Server: Permintaan dibatalkan")
            }
        }
    }
</script>