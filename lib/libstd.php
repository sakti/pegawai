<?php

function cekNipPegawai($nip){
    $hasil=query("SELECT * FROM umum WHERE nip='$nip'");
    if($hasil){
        return true;
    }else{
        return false;
    }
}
function getDaftarPegUltah(){
    return query("SELECT nip,nama,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(tgl_lahir, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(tgl_lahir, '00-%m-%d')) AS umur FROM `umum` WHERE date_format(tgl_lahir,'%m-%d')=date_format(now(),'%m-%d') and (status='CPNS' or status='PNS') ORDER BY umur DESC");
}
function getDaftarUser(){
    return query('SELECT * FROM users');
}
function getDaftarUnitKerja(){
    return query('SELECT * FROM unit_kerja');
}
function getDaftarGolongan(){
    return query('SELECT * FROM golongan ORDER BY nilai');
}
function getDaftarDiklat(){
    return query("SELECT * FROM jenis_diklat ORDER BY jenis,nama");
}
function getDaftarDiklatByKat($kat){
    return query("SELECT * FROM jenis_diklat WHERE jenis='$kat' ORDER BY nama");
}
function getDaftarJabatan(){
    return query('SELECT a.id_jabatan,a.jabatan,a.seksi,a.eselon,a.id_unit_kerja,b.nama FROM jenis_jabatan a, unit_kerja b WHERE a.id_unit_kerja=b.id_unit_kerja');
}
function getDaftarSeksiByUnitKerja($id){
    return query("SELECT seksi FROM jenis_jabatan WHERE id_unit_kerja=$id GROUP BY seksi");
}
function getDaftarJabatanByUnitKerja($id){
    return query("SELECT * FROM jenis_jabatan WHERE id_unit_kerja=$id");
}
function getDaftarJabatanBySUK($unitkerja,$seksi){
    return query("SELECT * FROM `jenis_jabatan` WHERE id_unit_kerja=$unitkerja and seksi='$seksi'");
}
function getDataUser($userid){
    $hasil=query("SELECT * FROM users WHERE userid=$userid");
    if($hasil){
        return $hasil[0];
    }else{
        return false;
    }
}
function getDataUnitKerja($id){
    $hasil=query("SELECT * FROM unit_kerja WHERE id_unit_kerja=$id");
    if($hasil){
        return $hasil[0];
    }else{
        return false;
    }
}
function getDataGolongan($id){
    $hasil=query("SELECT * FROM golongan WHERE id_golongan=$id");
    if($hasil){
        return $hasil[0];
    }else{
        return false;
    }
}
function getDataDiklat($id){
    $hasil=query("SELECT * FROM jenis_diklat WHERE id_jenis_diklat=$id");
    if($hasil){
        return $hasil[0];
    }else{
        return false;
    }
}
function getDataJabatan($id){
    $hasil=query("SELECT * FROM jenis_jabatan WHERE id_jabatan=$id");
    if($hasil){
        return $hasil[0];
    }else{
        return false;
    }
}
