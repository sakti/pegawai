<?php
require_once('../lib/auth.php');
require_once('../lib/conn.php');
require_once('../lib/liboperator.php');
auth('operator');
$daftarultah=getDaftarPegUltah();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kepegawaian Dinas Perhubungan</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link type="text/css" href="../css/gaya.css" rel="stylesheet" />
    <style type="text/css">
        #kat{
            font-size:1.2em;
            list-style:url("../img/panah.png");
        }
        #kat a{
            color:#1a5672;
            text-decoration:underline;
            font-weight:800;
        }
        #kat a:hover{
            color:#021017;
            text-shadow: 1px 1px 10px #fff;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <img src="../img/jabar-small.png" />
            <img id="lgperhub" src="../img/perhubungan-small.png" />
            <p>Data Kepegawaian Dinas Perhubungan</p>
            <p class="desc">Operator<sub>(<?php echo $_SESSION['priv']; ?>)</sub></p>
        </div>
        <div id="content">
            <div id="menu">
                <ul>
                    <li><div>Home</div></li>
                    <?php if($_SESSION['priv']=='input'):?>
                    <li><a href="input.php">Input</a></li>
                    <li><a href="edit.php">Edit</a></li>
                    <li><a href="upload.php">Upload Foto</a></li>
                    <?php endif;?>
                    <li><a href="daftar.php">Daftar</a></li>
                    <li><a href="cari.php">Cari</a></li>
                    <li><a href="laporan.php">Laporan</a></li>
                    <li><a href="statistik.php">Statistik</a><li>
                    <li><a id="logout" href="../login.php?a=logout">Logout</a></li>
                </ul>
            </div>
            <div id="isi">
                <h2>Selamat datang <?php echo $_SESSION['username']; ?></h2>
                <p>Daftar Pegawai yang ulang tahun hari ini <?=date('j F , Y') ?> : </p>
                <p>
                <ul id="kat">
                <?$i=20?>
                <?foreach($daftarultah as $brs):?>
                    <li><a href="daftar.php?nip=<?=$brs['nip']?>" style="font-size:<?=$i?>px"><?=$brs['nama']?> (<?=$brs['umur']?>)</a></li>
                    <?$i--?>
                <?endforeach;?>
                </ul>
                </p>
            </div>
        </div>
        <div id="footer"> 2010 &copy; Dinas Perhubungan Jawa Barat </div>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('tbody tr:odd').css('background-color','#b6d7e7');
    });
</script>
</html>
