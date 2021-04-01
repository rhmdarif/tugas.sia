<?php
    require_once("../setting.php");   
    require_once("../database.php");  
    if(isset($_POST['kode'])) {

        $kode = mysqli_real_escape_string($db, $_POST['kode']);

        $query_cek = mysqli_query($db, "SELECT * FROM perkiraan WHERE kode='$kode'");

        if(!$kode) {
            $r['status'] = 'Error';
            $r['pesan'] = "Lengkapis seluruh field";
        } else if(mysqli_num_rows($query_cek) == 0) {
            $r['status'] = 'Error';
            $r['pesan'] = "Data dengan kode ".$kode." tidak terdaftar";
        } else {
            $fetch = mysqli_fetch_assoc($query_cek);
            $r['status'] = 'Sukses';
            $r['pesan'] = $fetch['nama'];
        }

        echo json_encode($r);
    }