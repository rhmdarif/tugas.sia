<?php
    require_once("../setting.php");   
    require_once("../database.php");  

    $daftar_perkiraan = '';

    $id = (isset($_POST['select_id']))? $_POST['select_id'] : false;
    $query = mysqli_query($db, "SELECT * FROM master_jurnal WHERE no_bukti='$id'");
    $fetch = $query->fetch_assoc();
    $query2 = mysqli_query($db, "SELECT * FROM jurnal WHERE no_bukti='$id'");
    $no = 1;
    while($fetch2 = $query2->fetch_assoc()) {
        $daftar_perkiraan .= '
        <tr>
            <td>'.$no++.'</td>
            <td>'.$fetch2['ref'].'</td>
            <td>'.$fetch2['debet'].'</td>
            <td>'.$fetch2['kredit'].'</td>
        </tr>';
    }
?>
<div class="main">
    <h2>Detail Transaksi #<?php echo $id; ?></h2>
    <p>Keterangan : <?php echo $fetch['keterangan']; ?><br>
    Tanggal Trx : <?php echo $fetch['tanggal']; ?><br></p>

    <table style="width:100%">
        <tr>
            <th>#</th>
            <th>Ref</th>
            <th>Debet</th>
            <th>Kredit</th>
        </tr>
        <?php echo $daftar_perkiraan; ?>
    </table>
</div>

<script>
    function linkEkspand(id) {
        $.post('pages/laporan-detail-transaksi.php', {
                select_id: input
            }, function(result) {
                $('#konten').html(result);
            });
    }
</script>