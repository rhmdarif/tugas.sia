<?php
    require_once("../setting.php");   
    require_once("../database.php");  
    if(isset($_POST['kode']) AND isset($_POST['nama'])) {

        $kode = mysqli_real_escape_string($db, $_POST['kode']);
        $nama = mysqli_real_escape_string($db, $_POST['nama']);

        $query_cek = mysqli_query($db, "SELECT * FROM perkiraan WHERE kode='$kode'");

        if(!$kode || !$nama) {
            $r['status'] = 'Error';
            $r['pesan'] = "Lengkapi seluruh field";
        } else if(mysqli_num_rows($query_cek) > 0) {
            $r['status'] = 'Error';
            $r['pesan'] = "Data dengan kode ".$kode." telah terdaftar";
        } else {
            $query_save = mysqli_query($db, "INSERT INTO perkiraan (kode,nama) VALUES ('$kode', '$nama')");
            if($query_save) {
                $r['status'] = 'Sukses';
                $r['pesan'] = "Data berhasil direkam";
            } else {
                $r['status'] = 'Error';
                $r['pesan'] = "Data tidak dapat direkam";
            }
        }

        echo json_encode($r);
    }