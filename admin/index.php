<?php
require_once('../lib/auth.php');
require_once('../lib/conn.php');
require_once('../lib/libadmin.php');
auth('admin');
$jmlusers=getJmlUser();
$jmlpegawai=getJmlPegawai();
$jmlunitkerja=getJmlUnitKerja();
$jmljabatan=getJmlJabatan();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Kepegawaian DISHUB JABAR</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link type="text/css" href="../css/gaya.css" rel="stylesheet" />
    <style type="text/css">
            .read{
            position:relative;
            display:inline;
            color:#063044;
            font-size:1.7em;
            font-weight:800;
        }
        label{
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <img src="../img/jabar-small.png" />
            <img id="lgperhub" src="../img/perhubungan-small.png" />
            <p>Data Kepegawaian Dinas Perhubungan</p>
            <p class="desc">Administrator</p>
        </div>
        <div id="content">
            <div id="menu">
                <ul>
                    <li><div>Home</div></li>
                    <li><a href="users.php">Pengguna</a></li>
                    <li><a href="unitkerja.php">Unit Kerja</a></li>
                    <li><a href="golongan.php">Golongan</a></li>
                    <li><a href="diklat.php">Diklat</a></li>
                    <li><a href="jabatan.php">Jabatan</a></li>
                    <li><a href="../login.php?a=logout" id="logout">Logout</a></li>
                </ul>
            </div>
            <div id="isi">
                <h2>Selamat datang <?php echo $_SESSION['username']; ?></h2>
                <p>Anda login sebagai Administrator ... </p>
                <label>Jumlah Pengguna Aplikasi : </label><div class="read"><?=$jmlusers?></div>
                <label>Total Jumlah Pegawai : </label><div class="read"><?=$jmlpegawai?></div>
                <label>Total Jumlah Unit Kerja : </label><div class="read"><?=$jmlunitkerja?></div>
                <label>Total Jumlah Jabatan : </label><div class="read"><?=$jmljabatan?></div>
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
