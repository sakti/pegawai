<?php
require_once('lib/conn.php');
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kepegawaian DISHUB JABAR</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link type="text/css" href="css/gaya.css" rel="stylesheet" />
    <style type="text/css">
        #isi{
            background:url("img/front.png");
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <div id="header"><p>Data Kepegawaian Dinas Perhubungan</p></div>
        <div id="content">
            <div id="menu">
                <p>Autentifikasi Pengguna</p>
            </div>
            <div id="isi">
                <div id="wlogin">
                    <form action="login.php" method="post">
                        <fieldset>
                        <p class="error"><?php if(!empty($_SESSION['error'])) echo $_SESSION['error']; ?></p>
                        <input type="hidden" name="op" value="inputtrans" />
                        <label for="username">Username</label><input type="text" name="username" id="username" size="25" maxlength="35" autofocus required />
                        <label for="password">Password</label><input type="password" name="password" id="password" size="25" maxlength="35" required />
                        <br/><br/>
                        </fieldset>
                        <div id="wop">
                        <input type="submit" class="tombol" name="kirim" value="Login" />
                        <input type="reset" class="tombol" name="hapus" value="Reset" />
                        </div>
                    </form>
                    <img class="logo" src="img/perhubungan.png" />
                    <img class="logo" src="img/jabar.png" />
                </div>
            </div>
        </div>
        <div id="footer"> 2010 &copy; Dinas Perhubungan Jawa Barat </div>
    </div>
</body>
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('tbody tr:odd').css('background-color','#b6d7e7');
    });
</script>
</html>
