<?php
    require_once("../setting.php");   
    require_once("../database.php");  
    if(isset($_POST['no_bukti']) AND isset($_POST['tgl_trx']) AND isset($_POST['keterangan'])) {
        $no_bukti = mysqli_real_escape_string($db, $_POST['no_bukti']);
        $tgl_trx = mysqli_real_escape_string($db, $_POST['tgl_trx']);
        $keterangan = mysqli_real_escape_string($db, $_POST['keterangan']);
        $debet = mysqli_real_escape_string($db, $_POST['debet']);
        $kredit = mysqli_real_escape_string($db, $_POST['kredit']);

        file_put_contents('data.txt', json_encode($_POST));

        $query_cek = mysqli_query($db, "SELECT * FROM master_jurnal WHERE no_bukti='$no_bukti'");

        if(mysqli_num_rows($query_cek) > 0) {
            $r['status'] = 'Error';
            $r['pesan'] = "Data dengan kode ".$kode." telah terdaftar";
        } else if($debet != $kredit) {
            $r['status'] = 'Error';
            $r['pesan'] = "Data dientry tidak valid";
        } else {

            $query_save = mysqli_query($db, "INSERT INTO master_jurnal (no_bukti,tanggal,keterangan) VALUES ('$no_bukti', '$tgl_trx', '$keterangan')");
            if($query_save) {
                
                for ($i=0; $i < COUNT($_POST['jenis_trx']); $i++) { 
                    $jenis_trx = $_POST['jenis_trx'][$i];
                    $jumlah_trx = $_POST['jmlh_trx'][$i];
                    $kode_transaksi = $_POST['kode_perkiraan'][$i];

                    $cek_barang = mysqli_query($db, "SELECT * FROM barang WHERE kode LIKE '%$kode_transaksi%'");
                    if(mysqli_num_rows($cek_barang) > 0) {
                        $fetch = mysqli_fetch_assoc($cek_barang);
                        $id_brg = $fetch['kode'];
                
                        // Jika ini barang/stok
                        if($jenis_trx == 'k') {
                            $jmlh_brg = $jumlah_trx/$fetch['harga'];
                            mysqli_query($db, "UPDATE barang SET stok=stok-$jmlh_brg WHERE kode='$id_brg'");
                            mysqli_query($db, "UPDATE perkiraan SET saldo=saldo-$jmlh_brg WHERE kode='$kode_transaksi'");
                        } else if($jenis_trx == 'd') {
                            $jmlh_brg = $jumlah_trx/$fetch['harga'];
                            mysqli_query($db, "UPDATE barang SET stok=stok+$jmlh_brg WHERE kode='$id_brg'");
                            mysqli_query($db, "UPDATE perkiraan SET saldo=saldo+$jmlh_brg WHERE kode='$kode_transaksi'");
                        }
                    } else {
                        /*
                        // Jika ini barang/stok
                        if($jenis_trx == 'k') {
                            $jmlh_brg = $jumlah_trx;
                            mysqli_query($db, "UPDATE perkiraan SET saldo=saldo-$jmlh_brg WHERE kode='$kode_transaksi'");
                        } else if($jenis_trx == 'd') {
                            $jmlh_brg = $jumlah_trx;
                            mysqli_query($db, "UPDATE perkiraan SET saldo=saldo+$jmlh_brg WHERE kode='$kode_transaksi'");
                        }
                        */
                    }

                    if($jenis_trx == 'k') {
                        mysqli_query($db, "INSERT INTO jurnal (no_bukti,ref,kredit) VALUES ('$no_bukti', '$kode_transaksi', '$jumlah_trx')");
                    } else if($jenis_trx == 'd') {
                        mysqli_query($db, "INSERT INTO jurnal (no_bukti,ref,debet) VALUES ('$no_bukti', '$kode_transaksi', '$jumlah_trx')");
                    }
                    
                }

                $r['status'] = 'Sukses';
                $r['pesan'] = "Data berhasil direkam";
            } else {
                $r['status'] = 'Error';
                $r['pesan'] = "Data tidak dapat direkam";
            }
        }

        echo json_encode($r);
    }