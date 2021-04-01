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
<div class="main">
    <h2>Barang Masuk</h2>
    <p>Pencatatan Barang masuk di toko mu</p>

    <table style="width:100%">
        <tr>
            <th>#</th>
            <th>Kode</th>
            <th>Varian</th>
            <th>Warna</th>
            <th>Harga satuan</th>
            <th>Stok</th>
        </tr>
        <?php echo $daftar_barang; ?>
    </table>
    <button onclick="btnTambah()">Tambahkan Barang</button>
</div>
<div class="right">
    <h2>Halaman Terkait</h2>
    <p>Berikut halaman yang terkait</p>

    <ul style="text-align:left;">
        <li onclick="openPage('stok-barang');"><u>Persediaan Barang</u></li>
        <li onclick="openPage('barang-masuk');">Barang Masuk</li>
        <li onclick="openPage('barang-keluar');"><u>Barang Keluar</u></li>
        <li onclick="openPage('transaksi-lainnya');"><u>Transaksi Lainnya</u></li>
    </ul>
</div>

<script>
    function btnTambah() {
        var input = [];
        $(':checkbox:checked').each(function(i) {
            input[i] = $(this).val();
        });

        if (input.length > 0) {
            var k = confirm("Perhatian!\nAnda akan menambah  stok sebanyak" + input.length + ".");
            if (k == true) {
                $.get('pages/barang-masuk_2.php', {
                    select_id: input
                }, function(result) {
                    $('.main').html(result);
                });
            } else {
                alert("Server: Permintaan dibatalkan")
            }
        }
    }
</script>