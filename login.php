<?php
require_once('lib/conn.php');
require_once('lib/auth.php');
if($_GET){
    switch($_GET['a']){
        case 'logout':session_destroy();
                    header('Location:index.php');
                    break;
    }
}else if($_POST){
    if($_POST['kirim']=='Login'){
        $hasil=checkUsernamePassword($_POST['username'],md5($_POST['password']));
        if($hasil){
            $_SESSION['username']=$hasil['username'];
            $_SESSION['priv']=$hasil['priv'];
            $_SESSION['userid']=$hasil['userid'];
            if($_SESSION['priv']=='admin'){
                header('Location:admin/index.php');
            }elseif($_SESSION['priv']=='baca'||$_SESSION['priv']=='input'){
                header('Location:operator/index.php');
            }
        }else{
            $_SESSION['error']="Login gagal, username dan password tidak valid";
            header('Location:index.php');
        }
    }
}else{
    header('Location:index.php');
}

