<?php
require_once('../lib/auth.php');
require_once('../lib/conn.php');
require_once('../lib/liboperator.php');
auth('operator');
$statistik=true;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kepegawaian Dinas Perhubungan</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link type="text/css" href="../css/gaya.css" rel="stylesheet" media="screen" />
    <link type="text/css" href="../css/cetak.css" rel="stylesheet" media="print"/>
    <script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="../js/highcharts.js"></script>
    <style type="text/css">
        .grafik{
            margin:30px 0;
        }
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
        h2 + .grafik{
            margin-top:50px;
        }
    </style>
</head>
<body>
    <div id="pnlpesan"><p id="isipesan">ini pesan dari aplikasi ini</p> <p><a href="#" class="close">tutup</a></p></div>
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
                    <li><a href="index.php">Home</a></li>
                    <?php if($_SESSION['priv']=='input'):?>
                    <li><a href="input.php">Input</a></li>
                    <li><a href="edit.php">Edit</a></li>
                    <li><a href="upload.php">Upload Foto</a></li>
                    <?php endif;?>
                    <li><a href="daftar.php">Daftar</a></li>
                    <li><a href="cari.php">Cari</a></li>
                    <li><a href="laporan.php">Laporan</a></li>
                    <li><div>Statistik</div><li>
                    <li><a id="logout" href="../login.php?a=logout">Logout</a></li>
                </ul>
            </div>
            <div id="isi">
                <?php 
                    $kat=(!empty($_GET['kat']))?$_GET['kat']:'';
                    switch($kat){
                        case 'jk':
                            include_once('chart/jk.php');
                            break;
                        case 'umur':
                            include_once('chart/umur.php');
                            break;
                        case 'agama':
                            include_once('chart/agama.php');
                            break;
                        case 'unitkerja':
                            include_once('chart/unitkerja.php');
                            break;
                        case 'golongan':
                            include_once('chart/golongan.php');
                            break;
                        case 'perkawinan':
                            include_once('chart/perkawinan.php');
                            break;
                        case 'tinggiberat':
                            include_once('chart/tinggiberat.php');
                            break;
                        default:
                        ?>
                        <h2>Statistik</h2>
                        <ul id="kat">
                            <li><a href="?kat=jk">Berdasarkan Jenis Kelamin</a></li>
                            <li><a href="?kat=umur">Berdasarkan Umur</a></li>
                            <li><a href="?kat=agama">Berdasarkan Agama</a></li>
                            <li><a href="?kat=unitkerja">Berdasarkan Unit Kerja</a></li>
                            <li><a href="?kat=golongan">Berdasarkan Golongan</a></li>
                            <li><a href="?kat=perkawinan">Berdasarkan Status Perkawinan</a></li>
                            <li><a href="?kat=tinggiberat">Berdasarkan Tinggi & Berat Badan</a></li>
                        <ul>
                        <?
                    }
                ?>
            </div>
        </div>
        <div id="footer"> 2010 &copy; Dinas Perhubungan Jawa Barat </div>
    </div>
</body>
<script type="text/javascript">
    $(function() {
				
        var pnlPesan=$('#pnlpesan'),ttpPesan=$('#pnlpesan a.close'),isiPesan=$('#isipesan');
        
        ttpPesan.click(function(){
            pnlPesan.fadeOut('fast');
            return false;
        });
        $('#cetak').click(function(){
            window.print();
            return false;
        });
        function updatePesan(pesan){
            isiPesan.html(pesan).addClass('cahaya');
            setTimeout(function() {
                isiPesan.removeClass('cahaya', 1500);
            }, 500);
            pnlPesan.fadeIn('slow').animate({opacity:0.8});
        }
        $('tbody tr:odd').css('background-color','#b6d7e7');
    });
</script>
</html>
