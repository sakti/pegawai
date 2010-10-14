<?php
session_start();
function checkUsernamePassword($username,$password){
    $hasil=query("SELECT * FROM users WHERE username='$username' and password='$password'");
    if($hasil){
        return $hasil[0];
    }else{
        return false;
    }
}
function auth($priv){
    switch($priv){
        case 'admin':
            if($_SESSION['priv']!='admin')  header('Location:../index.php');
            break;
        case 'operator':
            if($_SESSION['priv']!='baca' && $_SESSION['priv']!='input') header('Location:../index.php');
            break;
        case 'input':
            if($_SESSION['priv']!='input') header('Location:../index.php');
            break;
        case 'baca':
            if($_SESSION['priv']!='baca') header('Location:../index.php');
            break;
    }
}
