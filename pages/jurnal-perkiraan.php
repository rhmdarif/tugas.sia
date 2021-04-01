<?php
    require_once("../setting.php");   
    require_once("../database.php");  

    $daftar_perkiraan = '';
    $query = mysqli_query($db, "SELECT * FROM perkiraan");
    while($fetch = $query->fetch_assoc()) {
        $daftar_perkiraan .= '
        <tr>
            <td><input type="checkbox" name="select_id[]" value="'.$fetch['kode'].'"/></td>
            <td>'.$fetch['kode'].'</td>
            <td>'.$fetch['nama'].'</td>
        </tr>';
    }
?>
<div class="main">
    <h2>Jurnal Perkiraan</h2>
    <p>Berikut daftar perkiraan yang telah didaftarkan.</p>

    <table style="width:100%">
        <tr>
            <th>#</th>
            <th>Kode</th>
            <th>Perkiraan</th>
        </tr>
        <?php echo $daftar_perkiraan; ?>
    </table>
    <span onclick="btnEdit()">Edit</span>
    <span onclick="btnHapus()">Hapus</span>
</div>
<div class="right">
    <h2>Halaman Terkait</h2>
    <p>Berikut halaman yang terkait Perkiraan</p>

    <ul>
        <li onclick="openPage('perkiraan')"><u>Tambah Perkiraan</u></li>
        <li>Daftar Perkiraan</li>
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
                $.post('proses/hapus-perkiraan.php', {
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