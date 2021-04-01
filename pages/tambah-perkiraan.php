<?php
    require_once("../setting.php");   
    require_once("../database.php");   
    $page = 'TAMBAH PERKIRAAN';
    $display_msg = '';
    $display_msg_2 = '';
    $daftar_perkiraan = '';

    if(isset($_POST['btn-tambah'])) {

        $kode = mysqli_real_escape_string($db, $_POST['kode']);
        $nama = mysqli_real_escape_string($db, $_POST['nama']);

        $query_cek = mysqli_query($db, "SELECT * FROM perkiraan WHERE kode='$kode'");

        if(!$kode || !$nama) {
            $messages = "Lengkapis seluruh field";
        } else if(mysqli_num_rows($query_cek) > 0) {
            $messages = "Data telah terdaftar";
        } else {
            $query_save = mysqli_query($db, "INSERT INTO perkiraan (kode,nama) VALUES ('$kode', '$nama')");
            if($query_save) {
                $s = true;
                $messages = "Data berhasil direkam";
            } else {
                $messages = "Data tidak dapat direkam";
            }
        }

        $display_msg = ($s)? '<div class="shadow-large alert alert-small alert-round-medium bg-green1-dark"><i class="fa fa-check"></i><span>'.$messages.'</span></div>' : '<div class="shadow-large alert alert-small alert-round-medium bg-red2-dark"><i class="fa fa-times-circle"></i><span>'.$messages.'</span></div>';
    }

    if(isset($_POST['btnHapus']) AND COUNT($_POST['select_id']) > 0) {
        $kode = implode(",", $_POST['select_id']);
        $query_cek = mysqli_query($db, "SELECT * FROM perkiraan WHERE kode IN ('$kode')");
        if(mysqli_num_rows($query_cek) == 0) {
            $messages = "Data tidak terdaftar";
        } else {
            $query_save = mysqli_query($db, "DELETE FROM perkiraan WHERE kode IN ('$kode')");
            if($query_save) {
                $s = true;
                $messages = "Data berhasil hapus";
            } else {
                $messages = "Data tidak dapat dihapus";
            }
        }

        $display_msg_2 = (isset($s))? '<div class="shadow-large alert alert-small alert-round-medium bg-green1-dark"><i class="fa fa-check"></i><span>'.$messages.'</span></div>' : '<div class="shadow-large alert alert-small alert-round-medium bg-red2-dark"><i class="fa fa-times-circle"></i><span>'.$messages.'</span></div>';
    }
    
    $query = mysqli_query($db, "SELECT * FROM perkiraan");
    while($fetch = $query->fetch_assoc()) {
        $daftar_perkiraan .= '
        <tr>
            <td class="bg-gray-light"><input type="checkbox" name="select_id[]" value="'.$fetch['kode'].'"/></td>
            <td class="bg-gray-light">'.$fetch['kode'].'</td>
            <td class="bg-green-light">'.$fetch['nama'].'</td>
            <td class="bg-green-light">'.$fetch['saldo'].'</td>
        </tr>';
    }
    $daftar_kode = '';
    $query_kode = mysqli_query($db, "SELECT kode FROM perkiraan GROUP BY kode");
    while($fetch = $query_kode->fetch_assoc()) {
        $daftar_kode .= '<option value="'.$fetch['kode'].'"/>';
    }

?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>StickyMobile</title>
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../styles/framework.css">
    <link rel="stylesheet" type="text/css" href="../fonts/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://codeseven.github.io/toastr/build/toastr.min.css">
</head>

<body class="theme-dark" data-background="none" data-highlight="green1">
    <div id="page">
        <div id="page-preloader">
            <div class="loader-main">
                <div class="preload-spinner border-highlight"></div>
            </div>
        </div>
        <?php include '../partial/foot-menu.php'; ?>
        <?php include '../partial/navbar.php'; ?>
        <div class="page-content header-clear-large">
                <form class="content" method="POST">
                    <?php echo $display_msg; ?>
                    <div id="js_respond"></div>
                    <div class="input-style input-style-1 input-required">
                        <em>(required)</em>
                        <input type="tel" placeholder="Kode Perkiraan" id="kode" name="kode" maxLength="5" list="kode_terdaftar">
                        <datalist id="kode_terdaftar">
                            <?php echo $daftar_kode; ?>
                        </datalist>
                    </div>
                    <div class="input-style input-style-1 input-required">
                        <em>(required)</em>
                        <input type="text" placeholder="Perkiraan" id="nama" name="nama">
                    </div>
                    <button class="button button-margins button-m button-full shadow-small bg-highlight bottom-30" type="submit" style="width:95%;" name="btn-tambah">TAMBAHKAN PERKIRAAN</button>
                </form>

                    <div class="content">
                        <h3 class="bolder bottom-10">Daftar Perkiraan</h3>
                        <form method="POST" enctype='multipart/form-data'>
                            <?php echo $display_msg_2; ?>
                            <table class="table-borders">
                                <tbody>
                                    <tr>
                                        <th class="bg-gray-dark">#</th>
                                        <th class="bg-gray-dark">Kode</th>
                                        <th class="bg-gray-dark">Nama Perkiraan</th>
                                        <th class="bg-gray-dark">Saldo Akhir</th>
                                    </tr>
                                    <?php echo $daftar_perkiraan; ?>
                                </tbody>
                            </table>
                            <h5 class="bolder bottom-10">Aksi</h3>
                            <div class="demo-buttons" style="position: relative;float:center;">
                                <button type="submit" name="btnHapus" class="button button-m shadow-small bg-red2-dark" style="width:45%;margin-left:40px;">Hapus</button>
                                <button type="button" id="btnUbah" class="button button-m shadow-small bg-yellow1-dark" style="width:45%;margin-left:30px;">Ubah</button>
                            </div>
                        </form>
                    </div>
            <div class="clear"></div>
        </div>
    </div>
    <script
			  src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
			  crossorigin="anonymous"></script>
    <script>
        $("#kode").keyup(function () {
            console.log(this.value.length);
            if (this.value.length == this.maxLength) {
                // Buat Sikon
                // POST -> CEK ID -> TERSEDIA -> CHANGE FOCUS -> PRES ENTER -> DONE
                //                 |
                //                 -> TIDAK TERSEDIA -> SHOW ALERT "KODE TELAH DIGUNAKAN" -> CLEAR FIELD KODE
                $.post("../ajax/cid_perkiraan.php",{ kode: this.value }, function(data){
                    if(data == 'benar') {
                        $('#nama').focus();
                        console.log(data);
                    } else {
                        $("#kode").val("");
                        toastr['error'](data);
                        $("#kode").focus();
                        $("#nama").attr('disabled','disabled');
                        $("#button").attr('disabled','disabled');
                    }
                });
            }
        });
        
        $('#btnUbah').on('click', function() {
            var input = [];
            $(':checkbox:checked').each(function(i){
                input[i] = $(this).val();
            });
            $.redirect('ubah-perkiraan.php', {command:input});
        });
    </script>
    <script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript" src="../scripts/plugins.js"></script>
    <script type="text/javascript" src="../scripts/custom.js"></script>
    
</body>
</html>