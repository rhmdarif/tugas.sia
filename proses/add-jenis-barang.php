<?php
    require_once("../setting.php");   
    require_once("../database.php");  
    if(isset($_POST['kode'])) {

        $kode = mysqli_real_escape_string($db, $_POST['kode']);
        $harga = mysqli_real_escape_string($db, $_POST['harga']);
        $warna = mysqli_real_escape_string($db, $_POST['warna']);

        $query_cek = mysqli_query($db, "SELECT * FROM barang WHERE kode='$kode'");

        if(!$kode || !$harga || !$warna) {
            $r['status'] = 'Error';
            $r['pesan'] = "Lengkapis seluruh field";
        } else if(mysqli_num_rows($query_cek) > 0) {
            $r['status'] = 'Error';
            $r['pesan'] = "Data dengan kode ".$kode." telah terdaftar";
        } else {
            $query_save = mysqli_query($db, "INSERT INTO barang (kode,harga,warna) VALUES ('$kode', '$harga', '$warna')");
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