<?php
require_once('libstd.php');
function getJmlUser(){
    $hasil=query("SELECT count(*) as jml FROM users");
    $hasil=$hasil[0]['jml'];
    return $hasil;
}
function getJmlPegawai(){
    $hasil=query("SELECT count(*) as jml FROM umum");
    $hasil=$hasil[0]['jml'];
    return $hasil;
}
function getJmlUnitKerja(){
    $hasil=query("SELECT count(*) as jml FROM unit_kerja");
    $hasil=$hasil[0]['jml'];
    return $hasil;
}
function getJmlJabatan(){
    $hasil=query("SELECT count(*) as jml FROM jenis_jabatan");
    $hasil=$hasil[0]['jml'];
    return $hasil;
}
function tambahPengguna($username,$password,$priv){
    $password=md5($password);
    $hasil=queryExecute("INSERT INTO users(username,password,priv) values('$username','$password','$priv')");
    $hasil2=array();
    if($hasil===true){
        $hasil2['pesan']="berhasil, pengguna dengan nama $username berhasil ditambahkan";
        $hasil2['berhasil']=true;
        $hasil2['userid']=mysql_insert_id();
    }elseif($hasil==1062){
        $hasil2['pesan']="Pengguna baru gagal ditambahkan nama $username sudah ada";
        $hasil2['berhasil']=false;
    }else{
        $hasil2['pesan']=$hasil;
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}
function updatePengguna($userid,$password,$hakakses){
    if(!empty($password)){
        $password=md5($password);
        $hasil=queryExecute("UPDATE users SET password='$password',priv='$hakakses' WHERE userid=$userid");
    }else{
        $hasil=queryExecute("UPDATE users SET priv='$hakakses' WHERE userid=$userid");
    }
    $hasil2=array();
    if($hasil===true){
        $hasil2['pesan']="Data berhasil diperbaharui";
        $hasil2['berhasil']=true;
    }else{
        $hasil2['pesan']="Pembaruan data gagal";
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}
function deletePengguna($userid){
    $hasil2=array();
    $hasil=queryExecute("DELETE FROM users WHERE userid=$userid");
    if($hasil===true){
        $hasil2['pesan']="Pengguna berhasil dihapus";
        $hasil2['berhasil']=true;
    }else{
        $hasil2['pesan']="Kesalahan: penghapusan pengguna gagal";
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}
function tambahUnitKerja($nama){
    $hasil=queryExecute("INSERT INTO unit_kerja(nama) values('$nama')");
    $hasil2=array();
    if($hasil===true){
        $hasil2['pesan']="berhasil, unit kerja dengan nama $nama berhasil ditambahkan";
        $hasil2['berhasil']=true;
        $hasil2['id_unit_kerja']=mysql_insert_id();
    }elseif($hasil==1062){
        $hasil2['pesan']="unit kerja baru gagal ditambahkan nama $nama sudah ada";
        $hasil2['berhasil']=false;
    }else{
        $hasil2['pesan']=$hasil;
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}
function updateUnitKerja($id,$nama){
    $hasil=queryExecute("UPDATE unit_kerja SET nama='$nama' WHERE id_unit_kerja=$id");
    $hasil2=array();
    if($hasil===true){
        $hasil2['pesan']="Data berhasil diperbaharui";
        $hasil2['berhasil']=true;
    }else{
        $hasil2['pesan']="Pembaruan data gagal";
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}
function deleteUnitKerja($id){
    $hasil2=array();
    $tmp=query("SELECT count(*) jml FROM jenis_jabatan WHERE id_unit_kerja=$id");
    $tmp=$tmp[0]['jml'];
    if($tmp==0){
        $hasil=queryExecute("DELETE FROM unit_kerja WHERE id_unit_kerja=$id");
        if($hasil===true){
            $hasil2['pesan']="unit kerja berhasil dihapus";
            $hasil2['berhasil']=true;
        }else{
            $hasil2['pesan']="Kesalahan: penghapusan unit kerja gagal";
            $hasil2['berhasil']=false;
        }
    }else{
        $hasil2['pesan']="Penghapusan data tidak bisa dilanjutkan, masih ada jabatan di unit kerja ini";
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}
function tambahGolongan($gol,$ket,$nilai){
    $hasil=queryExecute("INSERT INTO golongan(golongan,ket,nilai) values('$gol','$ket',$nilai)");
    $hasil2=array();
    if($hasil===true){
        $hasil2['pesan']="berhasil, golongan $gol berhasil ditambahkan";
        $hasil2['berhasil']=true;
        $hasil2['id_golongan']=mysql_insert_id();
    }else{
        $hasil2['pesan']=$hasil;
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}
function updateGolongan($id,$gol,$ket,$nilai){
    $hasil=queryExecute("UPDATE golongan SET golongan='$gol',ket='$ket',nilai=$nilai WHERE id_golongan=$id");
    $hasil2=array();
    if($hasil===true){
        $hasil2['pesan']="Data berhasil diperbaharui";
        $hasil2['berhasil']=true;
    }else{
        $hasil2['pesan']="Pembaruan data gagal";
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}
function deleteGolongan($id){
    $hasil2=array();
    $tmp=query("SELECT count(*) jml FROM umum WHERE id_golongan=$id");
    $tmp=$tmp[0]['jml'];
    if($tmp==0){
        $hasil=queryExecute("DELETE FROM golongan WHERE id_golongan=$id");
        if($hasil===true){
            $hasil2['pesan']="Golongan berhasil dihapus";
            $hasil2['berhasil']=true;
        }else{
            $hasil2['pesan']="Kesalahan: penghapusan golongan gagal";
            $hasil2['berhasil']=false;
        }
    }else{
        $hasil2['pesan']="Penghapusan data tidak bisa dilanjutkan, masih ada pegawai di golongan ini";
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}

function tambahDiklat($jenis,$nama){
    $hasil=queryExecute("INSERT INTO jenis_diklat(jenis,nama) values('$jenis','$nama')");
    $hasil2=array();
    if($hasil===true){
        $hasil2['pesan']="berhasil, diklat $nama berhasil ditambahkan";
        $hasil2['berhasil']=true;
        $hasil2['id_jenis_diklat']=mysql_insert_id();
    }else{
        $hasil2['pesan']=$hasil;
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}
function updateDiklat($id,$jenis,$nama){
    $hasil=queryExecute("UPDATE jenis_diklat SET jenis='$jenis',nama='$nama' WHERE id_jenis_diklat=$id");
    $hasil2=array();
    if($hasil===true){
        $hasil2['pesan']="Data berhasil diperbaharui";
        $hasil2['berhasil']=true;
    }else{
        $hasil2['pesan']="Pembaruan data gagal";
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}
function deleteDiklat($id){
    $hasil2=array();
    $tmp=query("SELECT count(*) jml FROM diklat_penjenjangan WHERE id_jenis_diklat=$id");
    $tmp=$tmp[0]['jml'];
    if($tmp==0){
        $hasil=queryExecute("DELETE FROM jenis_diklat WHERE id_jenis_diklat=$id");
        if($hasil===true){
            $hasil2['pesan']="Diklat berhasil dihapus";
            $hasil2['berhasil']=true;
        }else{
            $hasil2['pesan']="Kesalahan: penghapusan diklat gagal";
            $hasil2['berhasil']=false;
        }
    }else{
        $hasil2['pesan']="Penghapusan data tidak bisa dilanjutkan, diklat ini masih dipakai di data penjenjangan";
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}

function tambahJabatan($unitkerja,$seksi,$jabatan,$eselon){
    $hasil=queryExecute("INSERT INTO jenis_jabatan(id_unit_kerja,seksi,jabatan,eselon) values($unitkerja,'$seksi','$jabatan','$eselon')");
    $hasil2=array();
    if($hasil===true){
        $hasil2['pesan']="berhasil, Jabatan $jabatan berhasil ditambahkan";
        $hasil2['berhasil']=true;
        $hasil2['id_jabatan']=mysql_insert_id();
    }else{
        $hasil2['pesan']=$hasil;
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}
function updateJabatan($id,$unitkerja,$seksi,$jabatan,$eselon){
    $hasil=queryExecute("UPDATE jenis_jabatan SET id_unit_kerja=$unitkerja,seksi='$seksi',jabatan='$jabatan',eselon='$eselon' WHERE id_jabatan=$id");
    $hasil2=array();
    if($hasil===true){
        $hasil2['pesan']="Data berhasil diperbaharui";
        $hasil2['berhasil']=true;
    }else{
        $hasil2['pesan']="Pembaruan data gagal";
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}
function deleteJabatan($id){
    $hasil2=array();
    $tmp=query("SELECT count(*) jml FROM umum WHERE id_jabatan=$id");
    $tmp=$tmp[0]['jml'];
    if($tmp==0){
        $hasil=queryExecute("DELETE FROM jenis_jabatan WHERE id_jabatan=$id");
        if($hasil===true){
            $hasil2['pesan']="Jabatan berhasil dihapus";
            $hasil2['berhasil']=true;
        }else{
            $hasil2['pesan']="Kesalahan: penghapusan jabatan gagal";
            $hasil2['berhasil']=false;
        }
    }else{
        $hasil2['pesan']="Penghapusan data tidak bisa dilanjutkan, masih ada pegawai di jabatan ini";
        $hasil2['berhasil']=false;
    }
    return $hasil2;
}
