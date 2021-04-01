<?php
    require_once 'setting.php';
    
    $host = "localhost";
    $nama_db = "db_sia";
    $user_db = "root";
    $pass_db = "";

    $db = mysqli_connect($host, $user_db, $pass_db, $nama_db);

    if(mysqli_connect_errno()) {
        die("ERROR KONEKSI -> ".mysqli_connect_error());
    }