<?php
mysql_connect('localhost','pegawai','pegawai');
mysql_select_db('pegawai');
mysql_set_charset("utf8");

function query($sql){
    $hasil=mysql_query($sql);
    if (!$hasil) {
        $pesan  = 'ERROR NO: ' . mysql_errno() . "\n";
        $pesan .= 'Invalid query: ' . mysql_error() . "\n";
        $pesan .= 'Whole query: ' . $sql;
        die($pesan);
    }
    $temp=array();
    while($row = mysql_fetch_assoc($hasil)){
        $temp[]=$row;
    }
    return $temp;
}

function queryExecute($sql){
    $hasil=mysql_query($sql);
    if (!$hasil) {
        $pesan  = 'ERROR NO: ' . mysql_errno() . "\n";
        $pesan .= 'Invalid query: ' . mysql_error() . "\n";
        $pesan .= 'Whole query: ' . $sql;
        return mysql_errno();
    }
    return true;
}
