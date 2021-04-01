<?php
    require_once("../setting.php");   
    require_once("../database.php");  

    $daftar_perkiraan = '';

    $id = (isset($_POST['select_id']))? $_POST['select_id'] : false;
    $query = mysqli_query($db, "SELECT * FROM posting WHERE id='$id'");
    $fetch = $query->fetch_assoc();

    $query2 = mysqli_query($db, "SELECT * FROM posting_detail WHERE id='$id'");
    $no = 1;

    $totaldebit = 0;
    $totalkredit = 0;

    while($fetch2 = $query2->fetch_assoc()) {
        $query3 = mysqli_query($db, "SELECT * FROM perkiraan WHERE kode='$fetch2[kode_p]'");
        $fetch3 = mysqli_fetch_assoc($query3);
        $debit = 0;
        $kredit = 0;
        //echo substr($fetch3['kode'], 0, 1);

        if(in_array(substr($fetch3['kode'], 0, 1), array('1','5','6'))) {
            if($fetch2['saldo'] >= 0) {
                $debit = $fetch2['saldo'];
                $totaldebit += $debit;
            } else {
                $kredit = abs($fetch2['saldo']);
                $totalkredit += $kredit;
            }
        } else {
            if($fetch2['saldo'] >= 0) {
                $kredit = $fetch2['saldo'];
                $totalkredit += $kredit;
            } else {
                $debit = abs($fetch2['saldo']);
                $totaldebit += $debit;
            }
        }


        $daftar_perkiraan .= '
        <tr>
            <td>'.$no++.'</td>
            <td>'.$fetch3['nama'].'</td>
            <td>'.$debit.'</td>
            <td>'.$kredit.'</td>
        </tr>';
    }
    $daftar_perkiraan .= '
    <tr>
        <td colspan="2">Total</td>
        <td>'.$totaldebit.'</td>
        <td>'.$totalkredit.'</td>
    </tr>';

?>
<div class="main">
    <h2>Neraca Saldo : </h2>
    <p>Periode : <?php echo date('F Y', strtotime($fetch['waktu'])); ?><br>
    Create At : <?php echo $fetch['create_at']; ?><br></p>

    <table style="width:100%">
        <tr>
            <th>#</th>
            <th>Perkiraan</th>
            <th>Debet</th>
            <th>Kredit</th>
        </tr>
        <?php echo $daftar_perkiraan; ?>
    </table>
</div>
