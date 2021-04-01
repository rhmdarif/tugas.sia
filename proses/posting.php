<?php
    require_once("../setting.php");   
    require_once("../database.php");  
    
    if(isset($_POST['waktu'])) {

        $waktu = mysqli_real_escape_string($db, $_POST['waktu']);

        $time = explode(' ', $waktu);
        $bulan = date('m', strtotime($time[0]));
        $tahun = $time[1];
        $time2 = $tahun.'-'.$bulan.'-01';
        $time3 = $tahun.'-'.$bulan;
        
        $query_cek = mysqli_query($db, "SELECT * FROM posting WHERE waktu='$time2'");
        $query_cek_jurnal = mysqli_query($db, "SELECT * FROM master_jurnal WHERE tanggal LIKE '$time3%'");

        if(!$waktu || !$bulan || !$tahun) {
            $r['status'] = 'Error';
            $r['pesan'] = "Masukan Nilai Waktu dengan benar!!";
        } else if(mysqli_num_rows($query_cek_jurnal) == 0) {
            $r['status'] = 'Error';
            $r['pesan'] = "Data sumber tidak tersedia";
        } else if(mysqli_num_rows($query_cek) > 0) {
            $r['status'] = 'Error';
            $r['pesan'] = "Data dengan waktu ".$waktu." telah diposting";
        } else {
            $id = time();
            $no = 0;
            $query_save = mysqli_query($db, "INSERT INTO posting (id,waktu) VALUES ('$id', '$time2')");
            if($query_save) {
                $data = [];

                // Get daftar perkiraan
                $query_perkiraan = mysqli_query($db, "SELECT * FROM perkiraan");

                while($fetch_perkiraan = mysqli_fetch_assoc($query_perkiraan)) {
                    $saldo = 0;
                    // Get transaksi dengan kode yang sama
                    $query_transaksi = mysqli_query($db, "SELECT *, SUM(debet) as tdebet, SUM(kredit) as tkredit FROM jurnal WHERE ref='$fetch_perkiraan[kode]'");
                    
                    if(mysqli_num_rows($query_transaksi) > 0) {
                        $fetch_transaksi = mysqli_fetch_assoc($query_transaksi);
                        $trx_debet = $fetch_transaksi['tdebet'];
                        $trx_kredit = $fetch_transaksi['tkredit'];
    
                        if(in_array(substr($fetch_transaksi['ref'], 0, 1), array(1,5,6))) {
                            $saldo += $trx_debet-$trx_kredit;
                        } else {
                            $saldo += $trx_kredit-$trx_debet;
                        }
                        
                        // Query Posting
                        $query_posting = mysqli_query($db, "INSERT INTO posting_detail (id, kode_p, saldo) VALUES('$id', '$fetch_perkiraan[kode]', '$saldo')");
    
                        if($query_posting) {
                            $no++;
                            $added['kode'] = $fetch_perkiraan['kode'];
                            $added['nama'] = $fetch_perkiraan['nama'];
                            $added['saldo'] = $saldo;

                            array_push($data, $added);
                        }
                    }
                    
                }

                if($no != 0) {
                    // Delete data posting karena tidak ada data dientry
                    $r['status'] = 'Sukses';
                    $r['pesan'] = "Data telah diposting";
                    $r['data'] = $data;
                } else {
                    mysqli_query($db, "DELETE FROM posting WHERE id='$id'");
                    $r['status'] = 'Error';
                    $r['pesan'] = "Tidak ada data terposting";
                }
            } else {
                $r['status'] = 'Error';
                $r['pesan'] = "Data tidak dapat direkam";
            }
        }

        echo json_encode($r);
        
    }
    