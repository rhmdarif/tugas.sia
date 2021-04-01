<?php
    require_once("../setting.php");   
    require_once("../database.php");  

    $daftar_barang = '';
    $kode = "'".implode("','", $_GET['select_id'])."'";
    $query = mysqli_query($db, "SELECT * FROM barang WHERE kode IN ($kode)");
    while($fetch = $query->fetch_assoc()) {
        $id = $fetch['kode'];
        $p_query = mysqli_query($db, "SELECT nama FROM perkiraan WHERE kode ='$id'");
        $f_query = mysqli_fetch_assoc($p_query);
        $daftar_barang .= '
        <tr>
            <td id="kode">'.$id.'</td>
            <td>'.$f_query['nama'].'</td>
            <td>'.$fetch['warna'].'</td>
            <td id="harga-'.$fetch['kode'].'">'.$fetch['harga'].'</td>
            <td>'.$fetch['stok'].'</td>
            <td><input type="number" id="jumlah" onkeyup="trigger()"/></td>
            <td id="total-'.$fetch['kode'].'">0</td>
        </tr>';
    }
?>
    <h2>Barang Keluar</h2>
    <p>Jangan Lupa catat semua barang yang keluar!!</p>
    <button onclick="openPage('barang-masuk')">Kembali</button>
    

    <table style="width:100%">
        <tr id="data">
            <th>Kode</th>
            <th>Varian</th>
            <th>Warna</th>
            <th>Harga satuan</th>
            <th>Stok</th>
            <th>Jumlah -</th>
            <th>Biaya -</th>
        </tr>
        <?php echo $daftar_barang; ?>
        <tr>
            <td colspan="6">Total</td>
            <td id="total">0</td>
        </tr>
    </table>
    <button onclick="btnTambah()" width="100%">Tambahkan</button>

<script>
    function trigger() {
        var kode = $("td[id='kode']").map(function(){
                        return $(this).text();
                    }).get();
        var values = $("input[id='jumlah']").map(function(){
                        return $(this).val();
                    }).get();
        var modal, total;
        var semua = 0;
        for (let i = 0; i < kode.length; i++) {
            const element = kode[i];

            modal = $("#harga-"+element).text();
            total = modal*values[i];
            semua = semua+total;
            $("#total-"+element).text(total);
        }
        $("#total").text(semua);
    }
    function btnTambah() {
        var kode = $("td[id='kode']").map(function(){
                        return $(this).text();
                    }).get();
        var values = $("input[id='jumlah']").map(function(){
                        return $(this).val();
                    }).get();
        
        if (kode.length == values.length) {
            $.post('pages/transaksi-lainnya.php', {
                select_id: kode,
                tipe: 'k',
                jumlah: values
            }, function(result) {
               // console.log(result);
                $('#konten').html(result);
            });
        } else {
            alert("Server: Sepertinya ada yang salah, saya ga tau dimana.")
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
                            openPage('pages/barang-masuk.php')
                        }, 1000);
                    }
                });
            } else {
                alert("Server: Permintaan dibatalkan")
            }
        }
    }
</script>