<?php 
    require_once("setting.php");   
    require_once("database.php");  
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    * {
        box-sizing: border-box;
    }

    .menu {
        float: left;
        width: 25%;
        text-align: center;
    }

    .menu a {
        background-color: #e5e5e5;
        padding: 8px;
        margin-top: 7px;
        display: block;
        width: 100%;
        color: black;
    }

    .main {
        float: left;
        width: 50%;
        padding: 0 20px;
    }

    .right {
        background-color: #e5e5e5;
        float: left;
        width: 25%;
        padding: 15px;
        margin-top: 7px;
        text-align: center;
    }

    @media only screen and (max-width:620px) {

        .menu,
        .main,
        .right {
            width: 100%;
        }
    }

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 5px;
        text-align: left;
    }
    </style>
    
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body style="font-family:Verdana;color:#aaaaaa;">

    <div style="background-color:#3492eb;padding:15px;text-align:center;">
        <h1>Sistem Akuntansi Tk. Suci Textile</h1>
    </div>

    <div style="overflow:auto">
        <div class="menu">
            <a href="#" onclick="openPage('beranda')">Beranda</a>
            <a href="#" onclick="openPage('neraca')">Neraca</a>
            <a href="#" onclick="openPage('transaksi')">Transaksi</a>
            <a href="#" onclick="openPage('laporan')">Laporan</a>
            <a href="#" onclick="openPage('posting')">Posting</a>
            <a href="#" onclick="openPage('perkiraan')">Perkiraan</a>
        </div>

        <div id="konten"></div>
    </div>

    <div style="background-color:#e5e5e5;text-align:center;padding:10px;margin-top:7px;">© copyright w3schools.com</div>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        openPage('beranda');
        
        function openPage(name) {
            $('#konten').load("pages/" + name + ".php");
        }
    </script>
</body>

</html>