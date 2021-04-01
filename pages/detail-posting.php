<?php
    require_once("../setting.php");   
    require_once("../database.php");  

    $daftar_perkiraan = '';

    $id = (isset($_POST['select_id']))? $_POST['select_id'] : false;
    $query = mysqli_query($db, "SELECT * FROM posting WHERE id='$id'");
    $fetch = $query->fetch_assoc();

    $query2 = mysqli_query($db, "SELECT * FROM posting_detail WHERE id='$id'");
    $no = 1;
    while($fetch2 = $query2->fetch_assoc()) {
        $query3 = mysqli_query($db, "SELECT * FROM perkiraan WHERE kode='$fetch2[kode_p]'");
        $fetch3 = mysqli_fetch_assoc($query3);

        $daftar_perkiraan .= '
        <tr>
            <td>'.$no++.'</td>
            <td>'.$fetch3['nama'].'</td>
            <td>'.$fetch2['saldo'].'</td>
        </tr>';
    }
?>
<div class="main">
    <h2>Detail Posting : </h2>
    <p>Periode : <?php echo date('F Y', strtotime($fetch['waktu'])); ?><br>
    Create At : <?php echo $fetch['create_at']; ?><br></p>

    <table style="width:100%">
        <tr>
            <th>#</th>
            <th>Perkiraan</th>
            <th>Saldo</th>
        </tr>
        <?php echo $daftar_perkiraan; ?>
    </table>
</div>
<div class="right">
    <h2>Halaman Terkait</h2>
    <p>Berikut halaman yang terkait</p>

    <ul style="text-align:left;">
        <li onclick="openPage('posting');"><u>Posting Data</u></li>
        <li onclick="openPage('daftar-posting');">Daftar Posting</li>
    </ul>
</div>
