<?php
    require_once("../setting.php");   
    require_once("../database.php");  
    if(isset($_POST['select_id'])) {
        $kode = implode(",", $_POST['select_id']);
        $query_cek = mysqli_query($db, "SELECT * FROM barang WHERE kode IN ($kode)");
        if(mysqli_num_rows($query_cek) == 0) {
            $r['status'] = 'Error';
            $r['pesan'] = "Data tidak terdaftar.";
        } else {
            $query_save = mysqli_query($db, "DELETE FROM barang WHERE kode IN ($kode)");
            if($query_save) {
                $r['status'] = 'Success';
                $r['pesan'] = "Data berhasil hapus.";
            } else {
                $r['status'] = 'Error';
                $r['pesan'] = "Data tidak dapat dihapus.";
            }
        }
        
        echo json_encode($r);
    }