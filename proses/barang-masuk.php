<?php
    require_once("../setting.php");   
    require_once("../database.php");  
    if(isset($_POST['select_id']) AND isset($_POST['jumlah'])) {

        for($i=0; $i<count($_POST['select_id']); $i++) {
            $kode = $_POST['select_id'][$i];
            $jumlah = $_POST['jumlah'][$i];

            $query_cek = mysqli_query($db, "SELECT * FROM barang WHERE kode='$kode'");
            if(mysqli_num_rows($query_cek) != 0) {
                $query_save = mysqli_query($db, "UPDATE barang SET stok=stok+$jumlah WHERE kode='$kode'");
                if($query_save) {
                    $r['status'] = 'Success';
                    $r['pesan'] = "Barang berhasil ditambahkan.";
                }
            }
        }

    } else {
        $r['status'] = 'Error';
        $r['pesan'] = "Barang tidak bertambah.";
    }
    
    echo json_encode($r);