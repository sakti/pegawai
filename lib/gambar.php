<?php
require_once("conn.php");
if(!empty($_GET['nip'])){
    $nip=$_GET['nip'];
    $hasil=query("SELECT foto,mime FROM umum WHERE nip='$nip'");
    if(empty($hasil)||empty($hasil[0]['foto'])){
        header("Content-type: image/png");
        $fp=fopen("../img/nofoto.png",'r');
        $content = fread($fp, filesize("../img/nofoto.png"));
        echo $content;
        die();
    }
    $hasil=$hasil[0];
    $type=$hasil['mime'];
    header("Content-type: $type");
    echo $hasil['foto'];
}
