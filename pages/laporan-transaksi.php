<?php
    require_once("../setting.php");   
    require_once("../database.php");  

    $daftar_perkiraan = '';
    $query = mysqli_query($db, "SELECT * FROM master_jurnal ORDER BY tanggal");
    $no = 1;
    while($fetch = $query->fetch_assoc()) {
        $daftar_perkiraan .= '
        <tr>
            <td>'.$no++.'</td>
            <td><a href="#" onclick="linkEkspand(\''.$fetch['no_bukti'].'\');">'.$fetch['no_bukti'].'</a></td>
            <td>'.$fetch['keterangan'].'</td>
            <td>'.$fetch['tanggal'].'</td>
        </tr>';
    }
?>
<div class="main">
    <h2>Laporan Transaksi</h2>
    <p>Berikut daftar perkiraan yang telah didaftarkan.</p>

    <table style="width:100%">
        <tr>
            <th>#</th>
            <th>No. Bukti</th>
            <th>Keterangan</th>
            <th>Tgl. Trx</th>
        </tr>
        <?php echo $daftar_perkiraan; ?>
    </table>
</div>
<div class="right">
    <h2>Halaman Terkait</h2>
    <p>Berikut halaman yang terkait</p>

    <ul style="text-align:left;">
        <li onclick="openPage('laporan-perkiraan');"><u>Laporan Perkiraan</u></li>
        <li onclick="openPage('laporan-barang');"><u>Laporan Persediaan Barang</u></li>
        <li onclick="openPage('laporan-transaksi');">Laporan Transaksi</li>
        <li onclick="openPage('laporan-labarugi');"><u>Laporan Laba/Rugi</u></li>
    </ul>
</div>

<script>
    function linkEkspand(id) {
        $.post('pages/laporan-detail-transaksi.php', {
                select_id: id
            }, function(result) {
                $('#konten').html(result);
            });
    }
    
</script>