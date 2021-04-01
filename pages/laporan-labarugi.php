<?php
    require_once("../setting.php");   
    require_once("../database.php");  

    $daftar_perkiraan = '';
    $query2 = mysqli_query($db, "SELECT * FROM posting_detail");
    $no = 1;

    $pendapatan = 0;
    $biaya = 0;

    while($fetch2 = $query2->fetch_assoc()) {
        $query3 = mysqli_query($db, "SELECT * FROM perkiraan WHERE kode='$fetch2[kode_p]'");
        $fetch3 = mysqli_fetch_assoc($query3);
        $debit = 0;
        $kredit = 0;
        //echo substr($fetch3['kode'], 0, 1);

        if(substr($fetch3['kode'], 0, 1) == 4) {
            $pendapatan += $fetch2['saldo'];

            $daftar_perkiraan .= '
            <tr>
                <td>'.$no++.'</td>
                <td>'.$fetch3['nama'].'</td>
                <td>'.$pendapatan.'</td>
                <td>0</td>
            </tr>';
        } else if(substr($fetch3['kode'], 0, 1) == 5) {
            $biaya += $fetch2['saldo'];

            $daftar_perkiraan .= '
            <tr>
                <td>'.$no++.'</td>
                <td>'.$fetch3['nama'].'</td>
                <td>0</td>
                <td>'.$biaya.'</td>
            </tr>';
        }

    }

    if($pendapatan >= $biaya) {
        $jenis = "Laba";
        $total = $pendapatan-$biaya;
    } else {
        $jenis = "Rugi";
        $total = $biaya-$pendapatan;
    }
    $daftar_perkiraan .= '
    <tr>
        <td colspan="2">'.$jenis.'</td>
        <td colspan="2">'.$total.'</td>
    </tr>';

?>
<div class="main">
    <h2>Laporan Laba/Rugi : </h2>
    <table style="width:100%">
        <tr>
            <th>Nomor</th>
            <th>Perkiraan</th>
            <th>Pendapatan</th>
            <th>Biaya-biaya</th>
        </tr>
        <?php echo $daftar_perkiraan; ?>
    </table>
</div>
