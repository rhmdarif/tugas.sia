<?php
    define("IZIN", false);

    $whitelist = array('::1', '127.0.0.1');

    define("PERANGKAT", implode(',', $whitelist));

    if(IZIN == false AND !preg_match("/".$_SERVER['SERVER_ADDR']."/i", PERANGKAT)) {
        die('Hanya perangkat tertentu yang boleh pakai');
    }