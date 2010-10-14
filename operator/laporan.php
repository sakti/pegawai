<?php
require_once('../lib/auth.php');
require_once('../lib/conn.php');
require_once('../lib/liboperator.php');
require_once('../lib/PHPExcel.php');
require_once('../lib/PHPExcel/Cell/AdvancedValueBinder.php');
require_once('../lib/PHPExcel/IOFactory.php');
auth('operator');
if(!empty($_GET['lap'])&&in_array($_GET['lap'],array('kpmp','kpmg'))){
    require_once('report/'.$_GET['lap'].'.php');
}
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
        #kat li{
            margin:5px 5px 20px 5px;
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
                    <li><div>Laporan</div></li>
                    <li><a href="statistik.php">Statistik</a><li>
                    <li><a id="logout" href="../login.php?a=logout">Logout</a></li>
                </ul>
            </div>
            <div id="isi">
                <h2>Laporan</h2>
                <ul id="kat">
                    <li><a href="?lap=kpmp" class="tombol">Komposisi Pegawai Menurut Pendidikan</a></li>
                    <li><a href="?lap=kpmg" class="tombol">Komposisi Pegawai Menurut Golongan</a></li>
                </ul>
            </div>
        </div>
        <div id="footer"> 2010 &copy; Dinas Perhubungan Jawa Barat </div>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
    $(function() {
        var pnlPesan=$('#pnlpesan'),ttpPesan=$('#pnlpesan a.close'),isiPesan=$('#isipesan');
        
        ttpPesan.click(function(){
            pnlPesan.fadeOut('fast');
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
