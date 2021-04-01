<?php
    require_once("../setting.php");   
    require_once("../database.php");  

    $daftar_perkiraan = '';
    $query = mysqli_query($db, "SELECT * FROM posting");
    $no = 1;
    while($fetch = $query->fetch_assoc()) {
        $daftar_perkiraan .= '
        <tr>
            <td>'.$no++.'</td>
            <td><a href="#" onclick="linkEkspand(\''.$fetch['id'].'\');">'.date('F Y', strtotime($fetch['waktu'])).'</a></td>
            <td>'.$fetch['create_at'].'</td>
        </tr>';
    }
?>
<div class="main">
    <h2>Neraca Saldo</h2>
    <p>Berikut daftar data yang tersedia.</p>

    <table style="width:100%">
        <tr>
            <th>#</th>
            <th>Periode</th>
            <th>Tgl. Posting</th>
        </tr>
        <?php echo $daftar_perkiraan; ?>
    </table>
</div>

<script>
    function linkEkspand(id) {
        $.post('pages/neraca-saldo.php', {
                select_id: id
            }, function(result) {
                $('#konten').html(result);
            });
    }
</script>