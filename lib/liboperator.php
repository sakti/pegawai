<?php
require_once('libstd.php');

function getPendidikanTerakhir($id){
    $hasil=query("SELECT * FROM pendidikan WHERE id_pegawai=$id ORDER BY tahun DESC LIMIT 1");
    return (!empty($hasil[0]))?$hasil[0]:$hasil;
}

function getNamaByNip($nip){
    $hasil=query("SELECT nama FROM umum where nip='$nip'");
    return $hasil[0]['nama'];
}

function getTglMulaiTerhitung($id){
    $hasil=query("SELECT DATE_FORMAT(tanggal_berlaku,'%e/%c/%Y') tanggal_berlaku2 FROM riwayat_kepangkatan WHERE id_pegawai=$id ORDER BY tanggal_berlaku DESC LIMIT 1");
    return (empty($hasil[0]['tanggal_berlaku2'])?'-':$hasil[0]['tanggal_berlaku2']);
}

function getTglPNS($id){
    $hasil=query("SELECT DATE_FORMAT(tanggal_berlaku,'%e/%c/%Y') tanggal_berlaku2 FROM riwayat_kepangkatan WHERE id_pegawai=$id and pangkat='PNS' ORDER BY tanggal_berlaku LIMIT 1");
    return (empty($hasil[0]['tanggal_berlaku2']))?'-':$hasil[0]['tanggal_berlaku2'];
}

function getTglCPNS($id){
    $hasil=query("SELECT DATE_FORMAT(tanggal_berlaku,'%e/%c/%Y') tanggal_berlaku2 FROM riwayat_kepangkatan WHERE id_pegawai=$id and pangkat='CPNS' ORDER BY tanggal_berlaku LIMIT 1");
    return (empty($hasil[0]['tanggal_berlaku2']))?'-':$hasil[0]['tanggal_berlaku2'];
}

function getMasaKerjaGolongan($id){
    $hasil=query("SELECT tanggal_berlaku FROM riwayat_kepangkatan WHERE id_pegawai=$id ORDER BY tanggal_berlaku DESC LIMIT 1");
    if(!empty($hasil[0]['tanggal_berlaku'])){
        $tgl = new DateTime($hasil[0]['tanggal_berlaku']);
        $interval = $tgl->diff(new DateTime(date('Y-m-d')));
        return $interval->format('%Y tahun %m bulan');
    }else{
        return '-';
    }
}

function getTotalMasaKerja($id){
    $hasil=query("SELECT tanggal_berlaku FROM riwayat_kepangkatan WHERE id_pegawai=$id ORDER BY tanggal_berlaku LIMIT 1");
    if(!empty($hasil[0]['tanggal_berlaku'])){
        $tgl = new DateTime($hasil[0]['tanggal_berlaku']);
        $interval = $tgl->diff(new DateTime(date('Y-m-d')));
        return $interval->format('%Y tahun %m bulan');
    }else{
        return '-';
    }
}

function getDataPegawai($nip){
    $hasil=query("SELECT `id_pegawai`, `nip`, a.`nama`, a.`id_jabatan`, a.`id_golongan`,d.golongan,d.ket,d.nilai, DATE_FORMAT(tgl_lahir,'%e/%c/%Y') tgl_lahir, `tempat_lahir`, `jk`, `agama`, `kepercayaan`, `status`, `status_kawin`, `keterangan`, `tinggi`, `berat`, `warna_rambut`, `bentuk_muka`, `warna_kulit`, `ciri_khas`, `cacat_tubuh`, notelp, `jalan`, `kelurahan`, `kecamatan`, `kabupaten`, `propinsi`, `kode_pos`, `pejabat_skkb`, `no_skkb`, DATE_FORMAT(tgl_skkb,'%e/%c/%Y') tgl_skkb, `pejabat_ketsehat`, `no_ketsehat`, DATE_FORMAT(tgl_ketsehat,'%e/%c/%Y') tgl_ketsehat,jabatan,seksi,eselon,b.id_unit_kerja, c.nama nama_unit_kerja FROM `umum` a, jenis_jabatan b, unit_kerja c, golongan d WHERE a.nip='$nip' and a.id_jabatan=b.id_jabatan and b.id_unit_kerja=c.id_unit_kerja and a.id_golongan=d.id_golongan");
    if(!$hasil) return false;
    return $hasil[0];
}

function getDataPegawaiFoto($nip){
    $hasil=query("SELECT `id_pegawai`, `nip`, a.`nama`, a.`id_jabatan`, a.`id_golongan`,d.golongan,d.ket,d.nilai, DATE_FORMAT(tgl_lahir,'%e/%c/%Y') tgl_lahir, `tempat_lahir`,foto,mime, `jk`, `agama`, `kepercayaan`, `status`, `status_kawin`, `keterangan`, `tinggi`, `berat`, `warna_rambut`, `bentuk_muka`, `warna_kulit`, `ciri_khas`, `cacat_tubuh`, notelp, `jalan`, `kelurahan`, `kecamatan`, `kabupaten`, `propinsi`, `kode_pos`, `pejabat_skkb`, `no_skkb`, DATE_FORMAT(tgl_skkb,'%e/%c/%Y') tgl_skkb, `pejabat_ketsehat`, `no_ketsehat`, DATE_FORMAT(tgl_ketsehat,'%e/%c/%Y') tgl_ketsehat,jabatan,seksi,eselon,b.id_unit_kerja, c.nama nama_unit_kerja FROM `umum` a, jenis_jabatan b, unit_kerja c, golongan d WHERE a.nip='$nip' and a.id_jabatan=b.id_jabatan and b.id_unit_kerja=c.id_unit_kerja and a.id_golongan=d.id_golongan");
    if(!$hasil) return false;
    return $hasil[0];
}

function cariPegawai($q){
    return query("SELECT `id_pegawai`, `nip`, a.`nama`, a.`id_jabatan`, a.`id_golongan`,d.golongan,d.ket,d.nilai, DATE_FORMAT(tgl_lahir,'%e/%c/%Y') tgl_lahir, `tempat_lahir`, `jk`, `agama`, `kepercayaan`, `status`, `status_kawin`, `keterangan`, `tinggi`, `berat`, `warna_rambut`, `bentuk_muka`, `warna_kulit`, `ciri_khas`, `cacat_tubuh`,notelp, `jalan`, `kelurahan`, `kecamatan`, `kabupaten`, `propinsi`, `kode_pos`, `pejabat_skkb`, `no_skkb`, DATE_FORMAT(tgl_skkb,'%e/%c/%Y') tgl_skkb, `pejabat_ketsehat`, `no_ketsehat`, DATE_FORMAT(tgl_ketsehat,'%e/%c/%Y') tgl_ketsehat,jabatan,seksi,eselon,b.id_unit_kerja, c.nama nama_unit_kerja FROM `umum` a, jenis_jabatan b, unit_kerja c, golongan d WHERE (nip LIKE '%$q%' or a.nama LIKE '%$q%') and a.id_jabatan=b.id_jabatan and b.id_unit_kerja=c.id_unit_kerja and a.id_golongan=d.id_golongan");
}

function getListKat($kat){
    return query("SELECT $kat FROM `umum` a, jenis_jabatan b, unit_kerja c, golongan d WHERE a.id_jabatan=b.id_jabatan and b.id_unit_kerja=c.id_unit_kerja and a.id_golongan=d.id_golongan group by $kat");
}

function explainQuery($q){
    $asal=array('=','!=','c.nama','d.golongan','b.eselon','a.tempat_lahir','a.jk','a.status','a.status_kawin','a.agama',' and ',' or ');
    $ke=array(' samadengan ',' tidak samadengan ','Unit Kerja','Golongan','Eselon','Tempat lahir','Jenis Kelamin','Status','Status Perkawinan','Agama',' dan ',' atau ');
    $q=str_replace($asal,$ke,$q);
    return $q;
}
function singkat($teks){
    $asal=array('Balai','Pelayanan','Pemeriksaan','Kendaraan','Bermotor','Pengelolaan','Bandar','Udara','Pelabuhan');
    $ke=array('Bl.','Plyn.','Pmrksn.','Kndrn.','Bmtr.','Pengel.','Bndr.','Udr.','Pel.');
    $teks=str_ireplace($asal,$ke,$teks);
    return $teks;
}

function getDaftarPegawai($jml,$page,$filter){
    $page=$page-1;
    if($page<0) $page=0;
    $index=$page*$jml;
    $tmp=array();
    $select="SELECT `id_pegawai`, `nip`, a.`nama`, a.`id_jabatan`, a.`id_golongan`,d.golongan,d.ket,d.nilai, DATE_FORMAT(tgl_lahir,'%e/%c/%Y') tgl_lahir, `tempat_lahir`, `jk`, `agama`, `kepercayaan`, `status`, `status_kawin`, `keterangan`, `tinggi`, `berat`, `warna_rambut`, `bentuk_muka`, `warna_kulit`, `ciri_khas`, `cacat_tubuh`,notelp, `jalan`, `kelurahan`, `kecamatan`, `kabupaten`, `propinsi`, `kode_pos`, `pejabat_skkb`, `no_skkb`, DATE_FORMAT(tgl_skkb,'%e/%c/%Y') tgl_skkb, `pejabat_ketsehat`, `no_ketsehat`, DATE_FORMAT(tgl_ketsehat,'%e/%c/%Y') tgl_ketsehat,jabatan,seksi,eselon,b.id_unit_kerja, c.nama nama_unit_kerja ";
    $from="FROM `umum` a, jenis_jabatan b, unit_kerja c, golongan d ";
    if(!empty($filter)){
        $filter="and ( $filter )";
    }
    $where="WHERE a.id_jabatan=b.id_jabatan and b.id_unit_kerja=c.id_unit_kerja and a.id_golongan=d.id_golongan ".$filter." ORDER BY nilai DESC ";
    $limit="LIMIT $index,$jml";
    if($jml==0){
        $sql=$select.$from.$where;
    }else{
        $sql=$select.$from.$where.$limit;
    }
    
    $tmp['hasil']=query($sql);
    $jml=query('SELECT count(*) jml '.$from.$where);
    $tmp['jml']=$jml[0]['jml'];
    return $tmp;
}

function getDaftarHobiPeg($id){
    return query("SELECT id_hobi,hobi FROM hobi WHERE id_pegawai=$id");
}

function getDaftarPendidikanPeg($id){
    return query("SELECT * FROM pendidikan WHERE id_pegawai=$id ORDER BY tahun");
}

function getDaftarPelatihanPeg($id){
    return query("SELECT id_pelatihan,nama,DATE_FORMAT(tgl_awal,'%e/%c/%Y') tgl_awal,DATE_FORMAT(tgl_akhir,'%e/%c/%Y') tgl_akhir,no_tanda_lulus,tempat,ket FROM pelatihan WHERE id_pegawai=$id ORDER BY pelatihan.tgl_akhir");
}

function getDaftarDiklatPeg($id){
    return query("SELECT `id_diklat`,b.jenis,b.nama, a.`id_jenis_diklat`, DATE_FORMAT(tgl_awal,'%e/%c/%Y') tgl_awal,DATE_FORMAT(tgl_akhir,'%e/%c/%Y') tgl_akhir, `no_tanda_lulus`, `tempat`, `lama`, `ket` FROM `diklat_penjenjangan` a, jenis_diklat b WHERE a.id_jenis_diklat=b.id_jenis_diklat and id_pegawai=$id ORDER BY a.tgl_akhir");
}

function getDaftarKepangkatanPeg($id){
    return query("SELECT `id_kepangkatan`, a.id_golongan,b.golongan,b.ket,b.nilai, `pangkat`,DATE_FORMAT(`tanggal_berlaku`,'%e/%c/%Y') `tanggal_berlaku`, `sk_pejabat`, `sk_nomor`,  DATE_FORMAT(`sk_tanggal`,'%e/%c/%Y') `sk_tanggal`, `dasar_peraturan` FROM `riwayat_kepangkatan` a, golongan b WHERE a.id_golongan=b.id_golongan and a.id_pegawai=$id ORDER BY a.tanggal_berlaku");
}

function getDaftarPengalamanPeg($id){
    return query("SELECT `id_pekerjaan`, `pengalaman`, DATE_FORMAT(`tgl_mulai`,'%e/%c/%Y') `tgl_mulai`, DATE_FORMAT(`tgl_selesai`,'%e/%c/%Y') `tgl_selesai`, a.`id_golongan`, b.golongan,b.ket,b.nilai, `gaji_pokok`, `sk_pejabat`, `sk_nomor`, DATE_FORMAT(`sk_tanggal`,'%e/%c/%Y') `sk_tanggal` FROM `riwayat_pekerjaan` a, golongan b WHERE a.id_golongan = b.id_golongan and id_pegawai=$id ORDER BY a.tgl_selesai");
}

function getDaftarPenghargaanPeg($id){
    return query("SELECT * FROM penghargaan WHERE id_pegawai=$id ORDER BY tahun");
}

function getDaftarKunjunganPeg($id){
    return query("SELECT `id_kunjungan`, `negara`, `tujuan`, DATE_FORMAT(`tgl_awal`,'%e/%c/%Y') `tgl_awal`, DATE_FORMAT(`tgl_akhir`,'%e/%c/%Y') `tgl_akhir`, `pembiaya` FROM `kunjungan_luar_negeri` WHERE id_pegawai=$id ORDER BY kunjungan_luar_negeri.tgl_akhir");
}

function getDaftarSeminarPeg($id){
    return query("SELECT `id_seminar`, `nama`, `peranan`, DATE_FORMAT(`tgl_penyelenggaraan`,'%e/%c/%Y') `tgl_penyelenggaraan`, `penyelenggara`, `tempat` FROM `pengalaman_seminar` WHERE id_pegawai=$id ORDER BY pengalaman_seminar.tgl_penyelenggaraan");
}

function getDaftarPasanganPeg($id){
    return query("SELECT `id_pasangan`, `nama`, `tempat_lahir`, DATE_FORMAT(`tgl_lahir`,'%e/%c/%Y') `tgl_lahir`,  DATE_FORMAT(`tgl_menikah`,'%e/%c/%Y') `tgl_menikah`, `pekerjaan`, `keterangan` FROM `pasangan_hidup` WHERE id_pegawai=$id ORDER BY pasangan_hidup.tgl_menikah");
}

function getDaftarAnakPeg($id){
    return query("SELECT `id_anak`, `nama`, `jk`, `tempat_lahir`, DATE_FORMAT(`tgl_lahir`,'%e/%c/%Y') `tgl_lahir`, `pekerjaan`, `keterangan` FROM `anak` WHERE id_pegawai=$id ORDER BY anak.tgl_lahir");
}

function getDaftarOrtuPeg($id){
    return query("SELECT `id_kandung`, `nama`, DATE_FORMAT(`tgl_lahir`,'%e/%c/%Y') `tgl_lahir`, `jk`, `pekerjaan`, `keterangan` FROM `bapak_ibu_kandung` WHERE id_pegawai=$id ORDER BY bapak_ibu_kandung.tgl_lahir ");
}

function getDaftarMertuaPeg($id){
    return query("SELECT `id_mertua`, `nama`, DATE_FORMAT(`tgl_lahir`,'%e/%c/%Y') `tgl_lahir`, `jk`, `pekerjaan`, `keterangan` FROM `bapak_ibu_mertua` WHERE id_pegawai=$id ORDER BY bapak_ibu_mertua.tgl_lahir ");
}

function getDaftarSaudaraPeg($id){
    return query("SELECT `id_saudara`, `nama`, DATE_FORMAT(`tgl_lahir`,'%e/%c/%Y') `tgl_lahir`, `jk`, `pekerjaan`, `keterangan` FROM `saudara_kandung` WHERE id_pegawai=$id ORDER BY saudara_kandung.tgl_lahir ");
}

function getDaftarIparPeg($id){
    return query("SELECT `id_saudara`, `nama`, DATE_FORMAT(`tgl_lahir`,'%e/%c/%Y') `tgl_lahir`, `jk`, `pekerjaan`, `keterangan` FROM `saudara_kandung_pasangan_hidup` WHERE id_pegawai=$id ORDER BY saudara_kandung_pasangan_hidup.tgl_lahir ");
}

function getDaftarOrgSMAPeg($id){
    return query("SELECT * FROM `organisasi_sma` WHERE id_pegawai=$id ORDER BY tahun_akhir");
}

function getDaftarOrgPTPeg($id){
    return query("SELECT * FROM `organisasi_pt` WHERE id_pegawai=$id ORDER BY tahun_akhir");
}

function getDaftarOrgKerjaPeg($id){
    return query("SELECT * FROM `organisasi_selesai_pendidikan` WHERE id_pegawai=$id ORDER BY tahun_akhir");
}

function tambahPegawai($p){
    $id=0;
    $hasil=array();
    //insert ke tabel umum
    $sql="INSERT INTO ".
         "umum(".
         "`nip` ,`nama` ,`id_jabatan` ,`id_golongan` ,`tgl_lahir` ,`tempat_lahir` ,`jk` ,`agama` ,`kepercayaan` ,`status` ,`status_kawin` ,".
         "`keterangan` ,`tinggi` ,`berat` ,`warna_rambut` ,`bentuk_muka` ,`warna_kulit` ,`ciri_khas` ,`cacat_tubuh`, notelp ,`jalan` ,`kelurahan` ,".
         "`kecamatan` ,`kabupaten` ,`propinsi` ,`kode_pos`, pejabat_skkb, no_skkb, tgl_skkb, pejabat_ketsehat, no_ketsehat, tgl_ketsehat) ".
         "VALUES(".
         "'{$p['nip']}','{$p['nmlengkap']}','{$p['jabatan']}','{$p['golongan']}','".mysqlDate($p['tgllahir'])."','{$p['tmplahir']}','{$p['jk']}','{$p['agama']}','{$p['kepercayaan']}','{$p['status']}','{$p['statuskawin']}',".
         "'{$p['ket_tambah']}','{$p['tinggi']}','{$p['berat']}','{$p['rambut']}','{$p['bentukmuka']}','{$p['warnakulit']}','{$p['cirikhas']}','{$p['cacat']}','{$p['notelp']}','{$p['jalan']}','{$p['desa']}',".
         "'{$p['kec']}','{$p['kab']}','{$p['propinsi']}','{$p['kodepos']}','{$p['skkb_pejabat']}','{$p['skkb_nomor']}','".mysqlDate($p['skkb_tgl'])."','{$p['sk_sehat_pejabat']}','{$p['sk_sehat_nomor']}','".mysqlDate($p['sk_sehat_tgl'])."')";
    $thasil=queryExecute($sql);
    $id=mysql_insert_id();
    if($thasil===true){
        //insert ke tabel hobi
        if(isset($p['ahobi'])){
            $cnt=count($p['ahobi']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO hobi(id_pegawai,hobi) VALUES($id,'{$p['ahobi'][$i]}')");
            }
        }
        
        //insert ke tabel pendidikan
        if(isset($p['atingkat_pndd'])){
            $cnt=count($p['atingkat_pndd']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO pendidikan(id_pegawai,tingkat,nama,jurusan,no_ijazah,tahun,tempat,kepsek) VALUES($id,'{$p['atingkat_pndd'][$i]}','{$p['anm_pndd'][$i]}','{$p['ajurusan_pndd'][$i]}','{$p['anoijazah_pndd'][$i]}','{$p['athn_pndd'][$i]}','{$p['atmp_pndd'][$i]}','{$p['akepsek_pndd'][$i]}')");
            }
        }
        
        //insert ke tabel pelatihan
        if(isset($p['anm_plthn'])){
            $cnt=count($p['anm_plthn']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO pelatihan(id_pegawai,nama,tgl_awal,tgl_akhir,no_tanda_lulus,tempat,ket) VALUES($id,'{$p['anm_plthn'][$i]}','".mysqlDate($p['atglawal_plthn'][$i])."','".mysqlDate($p['atglakhir_plthn'][$i])."','{$p['anobukti_plthn'][$i]}','{$p['atmp_plthn'][$i]}','{$p['aket_plthn'][$i]}')");
            }
        }
        
        //insert ke tabel diklat_penjenjangan
        if(isset($p['anm_diklat'])){
            $cnt=count($p['anm_diklat']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO diklat_penjenjangan(id_pegawai,id_jenis_diklat,tgl_awal,tgl_akhir,no_tanda_lulus,tempat,lama,ket) VALUES($id,'{$p['anm_diklat'][$i]}','".mysqlDate($p['atglawal_diklat'][$i])."','".mysqlDate($p['atglakhir_diklat'][$i])."','{$p['anobukti_diklat'][$i]}','{$p['atmp_diklat'][$i]}','{$p['alama_diklat'][$i]}','{$p['aket_diklat'][$i]}')");
            }
        }
        
        //insert ke tabel riwayat_kepangkatan
        if(isset($p['anm_pangkat'])){
            $cnt=count($p['anm_pangkat']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO riwayat_kepangkatan(id_pegawai,pangkat,id_golongan,tanggal_berlaku,sk_pejabat,sk_nomor,sk_tanggal,dasar_peraturan) VALUES($id,'{$p['anm_pangkat'][$i]}','{$p['agolongan_pangkat'][$i]}','".mysqlDate($p['atmt_pangkat'][$i])."','{$p['ask_pejabat_pangkat'][$i]}','{$p['ask_nomor_pangkat'][$i]}','".mysqlDate($p['ask_tgl_pangkat'][$i])."','{$p['adasar_pangkat'][$i]}')");
            }
        }
        
        //insert ke tabel riwayat_pekerjaan
        if(isset($p['anm_pengalaman'])){
            $cnt=count($p['anm_pengalaman']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO riwayat_pekerjaan(id_pegawai,pengalaman,tgl_mulai,tgl_selesai,id_golongan,sk_pejabat,sk_nomor,sk_tanggal) VALUES($id,'{$p['anm_pengalaman'][$i]}','".mysqlDate($p['atglmulai_pengalaman'][$i])."','".mysqlDate($p['atglselesai_pengalaman'][$i])."','{$p['agol_pengalaman'][$i]}','{$p['ask_pejabat_pengalaman'][$i]}','{$p['ask_nomor_pengalaman'][$i]}','{$p['ask_tgl_pengalaman'][$i]}')");
            }
        }
        
        //insert ke tabel penghargaan
        if(isset($p['anm_penghargaan'])){
            $cnt=count($p['anm_penghargaan']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO penghargaan(id_pegawai,nama_penghargaan,tahun,pihak_pemberi) VALUES($id,'{$p['anm_penghargaan'][$i]}','{$p['athn_penghargaan'][$i]}','{$p['apemberi_penghargaan'][$i]}')");
            }
        }
        
        //insert ke tabel kunjungan_luar_negeri
        if(isset($p['anegara_kunjungan'])){
            $cnt=count($p['anegara_kunjungan']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO kunjungan_luar_negeri(id_pegawai,negara,tujuan,tgl_awal,tgl_akhir,pembiaya) VALUES($id,'{$p['anegara_kunjungan'][$i]}','{$p['atujuan_kunjungan'][$i]}','".mysqlDate($p['atglmulai_kunjungan'][$i])."','".mysqlDate($p['atglselesai_kunjungan'][$i])."','{$p['apembiaya_kunjungan'][$i]}')");
            }
        }
        
        //insert ke tabel pengalaman_seminar
        if(isset($p['anm_seminar'])){
            $cnt=count($p['anm_seminar']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO pengalaman_seminar(id_pegawai,nama,peranan,tgl_penyelenggaraan,penyelenggara,tempat) VALUES($id,'{$p['anm_seminar'][$i]}','{$p['aperanan_seminar'][$i]}','".mysqlDate($p['atgl_seminar'][$i])."','{$p['apenyelenggara_seminar'][$i]}','{$p['atmp_seminar'][$i]}')");
            }
        }
        
        //insert ke tabel pasangan_hidup
        if(isset($p['anm_pasangan'])){
            $cnt=count($p['anm_pasangan']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO pasangan_hidup(id_pegawai,nama,tempat_lahir,tgl_lahir,tgl_menikah,pekerjaan,keterangan) VALUES($id,'{$p['anm_pasangan'][$i]}','{$p['atmplhr_pasangan'][$i]}','".mysqlDate($p['atgllhr_pasangan'][$i])."','".mysqlDate($p['atglmenikah_pasangan'][$i])."','{$p['akerja_pasangan'][$i]}','{$p['aket_pasangan'][$i]}')");
            }
        }
        
        //insert ke tabel anak
        if(isset($p['anm_anak'])){
            $cnt=count($p['anm_anak']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO anak(id_pegawai,nama,jk,tempat_lahir,tgl_lahir,pekerjaan,keterangan) VALUES($id,'{$p['anm_anak'][$i]}','{$p['ajk_anak'][$i]}','{$p['atmplhr_anak'][$i]}','".mysqlDate($p['atgllhr_anak'][$i])."','{$p['akerja_anak'][$i]}','{$p['aket_anak'][$i]}')");
            }
        }
        
        //insert ke tabel bapak_ibu_kandung
        if(isset($p['anm_ortu'])){
            $cnt=count($p['anm_ortu']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO bapak_ibu_kandung(id_pegawai,nama,jk,tgl_lahir,pekerjaan,keterangan) VALUES($id,'{$p['anm_ortu'][$i]}','{$p['ajk_ortu'][$i]}','".mysqlDate($p['atgllhr_ortu'][$i])."','{$p['akerja_ortu'][$i]}','{$p['aket_ortu'][$i]}')");
            }
        }
        
        //insert ke tabel bapak_ibu_mertua
        if(isset($p['anm_mertua'])){
            $cnt=count($p['anm_mertua']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO bapak_ibu_mertua(id_pegawai,nama,jk,tgl_lahir,pekerjaan,keterangan) VALUES($id,'{$p['anm_mertua'][$i]}','{$p['ajk_mertua'][$i]}','".mysqlDate($p['atgllhr_mertua'][$i])."','{$p['akerja_mertua'][$i]}','{$p['aket_mertua'][$i]}')");
            }
        }
        
        //insert ke tabel saudara_kandung
        if(isset($p['anm_saudara'])){
            $cnt=count($p['anm_saudara']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO saudara_kandung(id_pegawai,nama,jk,tgl_lahir,pekerjaan,keterangan) VALUES($id,'{$p['anm_saudara'][$i]}','{$p['ajk_saudara'][$i]}','".mysqlDate($p['atgllhr_saudara'][$i])."','{$p['akerja_saudara'][$i]}','{$p['aket_saudara'][$i]}')");
            }
        }
        
        //insert ke tabel saudara_kandung_pasangan_hidup
        if(isset($p['anm_ipar'])){
            $cnt=count($p['anm_ipar']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO saudara_kandung_pasangan_hidup(id_pegawai,nama,jk,tgl_lahir,pekerjaan,keterangan) VALUES($id,'{$p['anm_ipar'][$i]}','{$p['ajk_ipar'][$i]}','".mysqlDate($p['atgllhr_ipar'][$i])."','{$p['akerja_ipar'][$i]}','{$p['aket_ipar'][$i]}')");
            }
        }
        
        //insert ke tabel organisasi_sma
        if(isset($p['anm_orgsma'])){
            $cnt=count($p['anm_orgsma']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO organisasi_sma(id_pegawai,nama,kedudukan,tahun_awal,tahun_akhir,tempat,nama_pemimpin) VALUES($id,'{$p['anm_orgsma'][$i]}','{$p['akedudukan_orgsma'][$i]}','{$p['athnmulai_orgsma'][$i]}','{$p['athnselesai_orgsma'][$i]}','{$p['atmp_orgsma'][$i]}','{$p['apimpinan_orgsma'][$i]}')");
            }
        }
        
        //insert ke tabel organisasi_pt
        if(isset($p['anm_orgpt'])){
            $cnt=count($p['anm_orgpt']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO organisasi_pt(id_pegawai,nama,kedudukan,tahun_awal,tahun_akhir,tempat,nama_pemimpin) VALUES($id,'{$p['anm_orgpt'][$i]}','{$p['akedudukan_orgpt'][$i]}','{$p['athnmulai_orgpt'][$i]}','{$p['athnselesai_orgpt'][$i]}','{$p['atmp_orgpt'][$i]}','{$p['apimpinan_orgpt'][$i]}')");
            }
        }
        
        //insert ke tabel organisasi_selesai_pendidikan
        if(isset($p['anm_orgkerja'])){
            $cnt=count($p['anm_orgkerja']);
            for($i=0;$i<$cnt;$i++){
                queryExecute("INSERT INTO organisasi_selesai_pendidikan(id_pegawai,nama,kedudukan,tahun_awal,tahun_akhir,tempat,nama_pemimpin) VALUES($id,'{$p['anm_orgkerja'][$i]}','{$p['akedudukan_orgkerja'][$i]}','{$p['athnmulai_orgkerja'][$i]}','{$p['athnselesai_orgkerja'][$i]}','{$p['atmp_orgkerja'][$i]}','{$p['apimpinan_orgkerja'][$i]}')");
            }
        }
        $hasil['berhasil']=true;
        $hasil['pesan']="pegawai '{$p['nmlengkap']}' dengan nip {$p['nip']}  berhasil disimpan";
    }else{
        if($thasil==1062){
            $hasil['pesan']="gagal, pegawai dengan nip {$p['nip']} sudah ada di database";
        }else{
            $hasil['pesan']="gagal menambahkan pegawai baru";
        }
        $hasil['berhasil']=false;
    }
    return $hasil;
}

function updatePegawai($p){
    $id=$p['id'];
    $hasil=array();
    //update ke tabel umum
    $sql="UPDATE umum SET".
         "`nip`='{$p['nip']}' ,`nama`='{$p['nmlengkap']}' ,`id_jabatan`='{$p['jabatan']}' ,`id_golongan`='{$p['golongan']}' ,`tgl_lahir`='".mysqlDate($p['tgllahir'])."' ,`tempat_lahir`='{$p['tmplahir']}' ,`jk`='{$p['jk']}' ,`agama`='{$p['agama']}' ,`kepercayaan`='{$p['kepercayaan']}' ,`status`='{$p['status']}' ,`status_kawin`='{$p['statuskawin']}' ,".
         "`keterangan`='{$p['ket_tambah']}', notelp='{$p['notelp']}' ,`tinggi`='{$p['tinggi']}' ,`berat`='{$p['berat']}' ,`warna_rambut`='{$p['rambut']}' ,`bentuk_muka`='{$p['bentukmuka']}' ,`warna_kulit`='{$p['warnakulit']}' ,`ciri_khas`='{$p['cirikhas']}' ,`cacat_tubuh`='{$p['cacat']}' ,`jalan`='{$p['jalan']}' ,`kelurahan`='{$p['desa']}',".
         "`kecamatan`='{$p['kec']}' ,`kabupaten`='{$p['kab']}' ,`propinsi`='{$p['propinsi']}' ,`kode_pos`='{$p['kodepos']}', pejabat_skkb='{$p['skkb_pejabat']}', no_skkb='{$p['skkb_nomor']}', tgl_skkb='".mysqlDate($p['skkb_tgl'])."', pejabat_ketsehat='{$p['sk_sehat_pejabat']}', no_ketsehat='{$p['sk_sehat_nomor']}', tgl_ketsehat='".mysqlDate($p['sk_sehat_tgl'])."' WHERE id_pegawai=$id";
    $thasil=queryExecute($sql);
    if($thasil===true){
        //update ke tabel hobi
        if($p['edithobi']=='y'){
            queryExecute("DELETE FROM hobi WHERE id_pegawai=$id");
            if(isset($p['ahobi'])){
                $cnt=count($p['ahobi']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO hobi(id_pegawai,hobi) VALUES($id,'{$p['ahobi'][$i]}')");
                }
            }
        }
        //update ke tabel pendidikan
        if($p['editpendidikan']=='y'){
            queryExecute("DELETE FROM pendidikan WHERE id_pegawai=$id");
            if(isset($p['atingkat_pndd'])){
                $cnt=count($p['atingkat_pndd']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO pendidikan(id_pegawai,tingkat,nama,jurusan,no_ijazah,tahun,tempat,kepsek) VALUES($id,'{$p['atingkat_pndd'][$i]}','{$p['anm_pndd'][$i]}','{$p['ajurusan_pndd'][$i]}','{$p['anoijazah_pndd'][$i]}','{$p['athn_pndd'][$i]}','{$p['atmp_pndd'][$i]}','{$p['akepsek_pndd'][$i]}')");
                }
            }
        }
        //update ke tabel pelatihan
        if($p['editpelatihan']=='y'){
            queryExecute("DELETE FROM pelatihan WHERE id_pegawai=$id");
            if(isset($p['anm_plthn'])){
                $cnt=count($p['anm_plthn']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO pelatihan(id_pegawai,nama,tgl_awal,tgl_akhir,no_tanda_lulus,tempat,ket) VALUES($id,'{$p['anm_plthn'][$i]}','".mysqlDate($p['atglawal_plthn'][$i])."','".mysqlDate($p['atglakhir_plthn'][$i])."','{$p['anobukti_plthn'][$i]}','{$p['atmp_plthn'][$i]}','{$p['aket_plthn'][$i]}')");
                }
            }
        }
        //update ke tabel diklat_penjenjangan
        if($p['editdiklat']=='y'){
            queryExecute("DELETE FROM diklat_penjenjangan WHERE id_pegawai=$id");
            if(isset($p['anm_diklat'])){
                $cnt=count($p['anm_diklat']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO diklat_penjenjangan(id_pegawai,id_jenis_diklat,tgl_awal,tgl_akhir,no_tanda_lulus,tempat,lama,ket) VALUES($id,'{$p['anm_diklat'][$i]}','".mysqlDate($p['atglawal_diklat'][$i])."','".mysqlDate($p['atglakhir_diklat'][$i])."','{$p['anobukti_diklat'][$i]}','{$p['atmp_diklat'][$i]}','{$p['alama_diklat'][$i]}','{$p['aket_diklat'][$i]}')");
                }
            }
        }
        //edit ke tabel riwayat_kepangkatan
        if($p['editkepangkatan']=='y'){
            queryExecute("DELETE FROM riwayat_kepangkatan WHERE id_pegawai=$id");
            if(isset($p['anm_pangkat'])){
                $cnt=count($p['anm_pangkat']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO riwayat_kepangkatan(id_pegawai,pangkat,id_golongan,tanggal_berlaku,sk_pejabat,sk_nomor,sk_tanggal,dasar_peraturan) VALUES($id,'{$p['anm_pangkat'][$i]}','{$p['agolongan_pangkat'][$i]}','".mysqlDate($p['atmt_pangkat'][$i])."','{$p['ask_pejabat_pangkat'][$i]}','{$p['ask_nomor_pangkat'][$i]}','".mysqlDate($p['ask_tgl_pangkat'][$i])."','{$p['adasar_pangkat'][$i]}')");
                }
            }
        }
        //update ke tabel riwayat_pekerjaan
        if($p['editpengalaman']=='y'){
            queryExecute("DELETE FROM riwayat_pekerjaan WHERE id_pegawai=$id");
            if(isset($p['anm_pengalaman'])){
                $cnt=count($p['anm_pengalaman']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO riwayat_pekerjaan(id_pegawai,pengalaman,tgl_mulai,tgl_selesai,id_golongan,sk_pejabat,sk_nomor,sk_tanggal) VALUES($id,'{$p['anm_pengalaman'][$i]}','".mysqlDate($p['atglmulai_pengalaman'][$i])."','".mysqlDate($p['atglselesai_pengalaman'][$i])."','{$p['agol_pengalaman'][$i]}','{$p['ask_pejabat_pengalaman'][$i]}','{$p['ask_nomor_pengalaman'][$i]}','{$p['ask_tgl_pengalaman'][$i]}')");
                }
            }
        }
        //update ke tabel penghargaan
        if($p['editpenghargaan']=='y'){
            queryExecute("DELETE FROM penghargaan WHERE id_pegawai=$id");
            if(isset($p['anm_penghargaan'])){
                $cnt=count($p['anm_penghargaan']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO penghargaan(id_pegawai,nama_penghargaan,tahun,pihak_pemberi) VALUES($id,'{$p['anm_penghargaan'][$i]}','{$p['athn_penghargaan'][$i]}','{$p['apemberi_penghargaan'][$i]}')");
                }
            }
        }
        //update ke tabel kunjungan_luar_negeri
        if($p['editkunjungan']=='y'){
            queryExecute("DELETE FROM kunjungan_luar_negeri WHERE id_pegawai=$id");
            if(isset($p['anegara_kunjungan'])){
                $cnt=count($p['anegara_kunjungan']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO kunjungan_luar_negeri(id_pegawai,negara,tujuan,tgl_awal,tgl_akhir,pembiaya) VALUES($id,'{$p['anegara_kunjungan'][$i]}','{$p['atujuan_kunjungan'][$i]}','".mysqlDate($p['atglmulai_kunjungan'][$i])."','".mysqlDate($p['atglselesai_kunjungan'][$i])."','{$p['apembiaya_kunjungan'][$i]}')");
                }
            }
        }
        //update ke tabel pengalaman_seminar
        if($p['editseminar']=='y'){
            queryExecute("DELETE FROM pengalaman_seminar WHERE id_pegawai=$id");
            if(isset($p['anm_seminar'])){
                $cnt=count($p['anm_seminar']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO pengalaman_seminar(id_pegawai,nama,peranan,tgl_penyelenggaraan,penyelenggara,tempat) VALUES($id,'{$p['anm_seminar'][$i]}','{$p['aperanan_seminar'][$i]}','".mysqlDate($p['atgl_seminar'][$i])."','{$p['apenyelenggara_seminar'][$i]}','{$p['atmp_seminar'][$i]}')");
                }
            }
        }
        //update ke tabel pasangan_hidup
        if($p['editpasangan']=='y'){
            queryExecute("DELETE FROM pasangan_hidup WHERE id_pegawai=$id");
            if(isset($p['anm_pasangan'])){
                $cnt=count($p['anm_pasangan']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO pasangan_hidup(id_pegawai,nama,tempat_lahir,tgl_lahir,tgl_menikah,pekerjaan,keterangan) VALUES($id,'{$p['anm_pasangan'][$i]}','{$p['atmplhr_pasangan'][$i]}','".mysqlDate($p['atgllhr_pasangan'][$i])."','".mysqlDate($p['atglmenikah_pasangan'][$i])."','{$p['akerja_pasangan'][$i]}','{$p['aket_pasangan'][$i]}')");
                }
            }
        }
        //update ke tabel anak
        if($p['editanak']=='y'){
            queryExecute("DELETE FROM anak WHERE id_pegawai=$id");
            if(isset($p['anm_anak'])){
                $cnt=count($p['anm_anak']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO anak(id_pegawai,nama,jk,tempat_lahir,tgl_lahir,pekerjaan,keterangan) VALUES($id,'{$p['anm_anak'][$i]}','{$p['ajk_anak'][$i]}','{$p['atmplhr_anak'][$i]}','".mysqlDate($p['atgllhr_anak'][$i])."','{$p['akerja_anak'][$i]}','{$p['aket_anak'][$i]}')");
                }
            }
        }
        //update ke tabel bapak_ibu_kandung
        if($p['editortu']=='y'){
            queryExecute("DELETE FROM bapak_ibu_kandung WHERE id_pegawai=$id");
            if(isset($p['anm_ortu'])){
                $cnt=count($p['anm_ortu']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO bapak_ibu_kandung(id_pegawai,nama,jk,tgl_lahir,pekerjaan,keterangan) VALUES($id,'{$p['anm_ortu'][$i]}','{$p['ajk_ortu'][$i]}','".mysqlDate($p['atgllhr_ortu'][$i])."','{$p['akerja_ortu'][$i]}','{$p['aket_ortu'][$i]}')");
                }
            }
        }
        //update ke tabel bapak_ibu_mertua
        if($p['editmertua']=='y'){
            queryExecute("DELETE FROM bapak_ibu_mertua WHERE id_pegawai=$id");
            if(isset($p['anm_mertua'])){
                $cnt=count($p['anm_mertua']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO bapak_ibu_mertua(id_pegawai,nama,jk,tgl_lahir,pekerjaan,keterangan) VALUES($id,'{$p['anm_mertua'][$i]}','{$p['ajk_mertua'][$i]}','".mysqlDate($p['atgllhr_mertua'][$i])."','{$p['akerja_mertua'][$i]}','{$p['aket_mertua'][$i]}')");
                }
            }
        }
        //edit ke tabel saudara_kandung
        if($p['editsaudara']=='y'){
            queryExecute("DELETE FROM saudara_kandung WHERE id_pegawai=$id");
            if(isset($p['anm_saudara'])){
                $cnt=count($p['anm_saudara']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO saudara_kandung(id_pegawai,nama,jk,tgl_lahir,pekerjaan,keterangan) VALUES($id,'{$p['anm_saudara'][$i]}','{$p['ajk_saudara'][$i]}','".mysqlDate($p['atgllhr_saudara'][$i])."','{$p['akerja_saudara'][$i]}','{$p['aket_saudara'][$i]}')");
                }
            }
        }
        //update ke tabel saudara_kandung_pasangan_hidup
        if($p['editipar']=='y'){
            queryExecute("DELETE FROM saudara_kandung_pasangan_hidup WHERE id_pegawai=$id");
            if(isset($p['anm_ipar'])){
                $cnt=count($p['anm_ipar']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO saudara_kandung_pasangan_hidup(id_pegawai,nama,jk,tgl_lahir,pekerjaan,keterangan) VALUES($id,'{$p['anm_ipar'][$i]}','{$p['ajk_ipar'][$i]}','".mysqlDate($p['atgllhr_ipar'][$i])."','{$p['akerja_ipar'][$i]}','{$p['aket_ipar'][$i]}')");
                }
            }
        }
        //update ke tabel organisasi_sma
        if($p['editorgsma']=='y'){
            queryExecute("DELETE FROM organisasi_sma WHERE id_pegawai=$id");
            if(isset($p['anm_orgsma'])){
                $cnt=count($p['anm_orgsma']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO organisasi_sma(id_pegawai,nama,kedudukan,tahun_awal,tahun_akhir,tempat,nama_pemimpin) VALUES($id,'{$p['anm_orgsma'][$i]}','{$p['akedudukan_orgsma'][$i]}','{$p['athnmulai_orgsma'][$i]}','{$p['athnselesai_orgsma'][$i]}','{$p['atmp_orgsma'][$i]}','{$p['apimpinan_orgsma'][$i]}')");
                }
            }
        }
        //update ke tabel organisasi_pt
        if($p['editorgpt']=='y'){
            queryExecute("DELETE FROM organisasi_pt WHERE id_pegawai=$id");
            if(isset($p['anm_orgpt'])){
                $cnt=count($p['anm_orgpt']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO organisasi_pt(id_pegawai,nama,kedudukan,tahun_awal,tahun_akhir,tempat,nama_pemimpin) VALUES($id,'{$p['anm_orgpt'][$i]}','{$p['akedudukan_orgpt'][$i]}','{$p['athnmulai_orgpt'][$i]}','{$p['athnselesai_orgpt'][$i]}','{$p['atmp_orgpt'][$i]}','{$p['apimpinan_orgpt'][$i]}')");
                }
            }
        }
        //update ke tabel organisasi_selesai_pendidikan
        if($p['editorgkerja']=='y'){
            queryExecute("DELETE FROM organisasi_selesai_pendidikan WHERE id_pegawai=$id");
            if(isset($p['anm_orgkerja'])){
                $cnt=count($p['anm_orgkerja']);
                for($i=0;$i<$cnt;$i++){
                    queryExecute("INSERT INTO organisasi_selesai_pendidikan(id_pegawai,nama,kedudukan,tahun_awal,tahun_akhir,tempat,nama_pemimpin) VALUES($id,'{$p['anm_orgkerja'][$i]}','{$p['akedudukan_orgkerja'][$i]}','{$p['athnmulai_orgkerja'][$i]}','{$p['athnselesai_orgkerja'][$i]}','{$p['atmp_orgkerja'][$i]}','{$p['apimpinan_orgkerja'][$i]}')");
                }
            }
        }
        $hasil['berhasil']=true;
        $hasil['pesan']="pegawai '{$p['nmlengkap']}' dengan nip {$p['nip']}  berhasil diupdate";
    }else{
        if($thasil==1062){
            $hasil['pesan']="gagal, pegawai dengan nip {$p['nip']} sudah ada di database";
        }else{
            $hasil['pesan']="gagal mengupdate data pegawai";
        }
        $hasil['berhasil']=false;
    }
    return $hasil;
}

function deletePegawai($id){
    $hasil=array();
    $berhasil=true;
    $berhasil = $berhasil and queryExecute("DELETE FROM umum where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM saudara_kandung_pasangan_hidup where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM saudara_kandung where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM riwayat_pekerjaan where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM riwayat_kepangkatan where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM penghargaan where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM pengalaman_seminar where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM pendidikan where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM pelatihan where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM pasangan_hidup where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM organisasi_sma where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM organisasi_selesai_pendidikan where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM organisasi_pt where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM kunjungan_luar_negeri where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM hobi where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM diklat_penjenjangan where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM bapak_ibu_mertua where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM bapak_ibu_kandung where id_pegawai=$id");
    $berhasil = $berhasil and queryExecute("DELETE FROM anak where id_pegawai=$id");
    $hasil['berhasil']=$berhasil;
    $hasil['pesan']='data pegawai berhasil dihapus dari database';
    return $hasil;
}

function mysqlDate($tgl){
    $tmp=explode('/',$tgl);
    if(count($tmp)!=3){
        return "";
    }
    $hasil=$tmp[2].'-'.$tmp[1].'-'.$tmp[0];
    return $hasil;
}
