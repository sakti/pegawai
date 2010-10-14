<?php
require_once('../lib/auth.php');
require_once('../lib/conn.php');
require_once('../lib/liboperator.php');
auth('operator');
$inpt=($_SESSION['priv']=='input')?true:false;
$nip=false;
$daftarpegawai=array();
if(!empty($_GET['nip'])){
    $nip=$_GET['nip'];
    $dp=getDataPegawai($nip);
    if($dp){
        $daftarseksi=getDaftarSeksiByUnitKerja($dp['id_unit_kerja']);
        $daftarjabatan=getDaftarJabatanBySUK($dp['id_unit_kerja'],$dp['seksi']);
        $daftarhobi=getDaftarHobiPeg($dp['id_pegawai']);
        $daftarpendidikan=getDaftarPendidikanPeg($dp['id_pegawai']);
        $daftarpelatihan=getDaftarPelatihanPeg($dp['id_pegawai']);
        $daftardiklatpeg=getDaftarDiklatPeg($dp['id_pegawai']);
        $daftarkepangkatan=getDaftarKepangkatanPeg($dp['id_pegawai']);
        $daftarpengalaman=getDaftarPengalamanPeg($dp['id_pegawai']);
        $daftarpenghargaan=getDaftarPenghargaanPeg($dp['id_pegawai']);
        $daftarkunjungan=getDaftarKunjunganPeg($dp['id_pegawai']);
        $daftarseminar=getDaftarSeminarPeg($dp['id_pegawai']);
        $daftarpasangan=getDaftarPasanganPeg($dp['id_pegawai']);
        $daftaranak=getDaftarAnakPeg($dp['id_pegawai']);
        $daftarortu=getDaftarOrtuPeg($dp['id_pegawai']);
        $daftarmertua=getDaftarMertuaPeg($dp['id_pegawai']);
        $daftarsaudara=getDaftarSaudaraPeg($dp['id_pegawai']);
        $daftaripar=getDaftarIparPeg($dp['id_pegawai']);
        $daftarorgsma=getDaftarOrgSMAPeg($dp['id_pegawai']);
        $daftarorgpt=getDaftarOrgPTPeg($dp['id_pegawai']);
        $daftarorgkerja=getDaftarOrgKerjaPeg($dp['id_pegawai']);
        $tmt=getTglMulaiTerhitung($dp['id_pegawai']);
        $tglcpns=getTglCPNS($dp['id_pegawai']);
        $tglpns=getTglPNS($dp['id_pegawai']);
        $masakerjagolongan=getMasaKerjaGolongan($dp['id_pegawai']);
        $masakerjatotal=getTotalMasaKerja($dp['id_pegawai']);
        $pnd_terakhir=getPendidikanTerakhir($dp['id_pegawai']);
    }
}else{
    $daftarunitkerja=getListKat('c.nama');
    $baris=10;
    if(!empty($_GET['page'])){
        $page=$_GET['page'];
    }else{
        $page=1;
    }

    if(!empty($_GET['filter'])){
        $filter=$_GET['filter'];
    }else{
        $filter='';
    }
    
    $tmp=getDaftarPegawai($baris,$page,$filter);
    $daftarpegawai=$tmp['hasil'];
    $jml=$tmp['jml'];
    $jmlhlm=ceil($jml/$baris);
}

function cetakPage($halaman,$jml){
?>
<ul>
    <li><span>Halaman</span></li>
    <?
    for($i=1;$i<=$jml;$i++):
        if($i==$halaman){
            echo "<li><span>$i</span></li>";
        }else{
            if(!empty($_GET['filter'])){
                echo "<li><a href=\"?page=$i&filter=".urlencode($_GET['filter'])."\">$i</a></li>";
            }else{
                echo "<li><a href=\"?page=$i\">$i</a></li>";
            }
        }
    endfor;
    ?>
</ul>
<?php
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kepegawaian Dinas Perhubungan</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link type="text/css" href="../css/gaya.css" rel="stylesheet" media="screen"/>
    <link type="text/css" href="../css/cetak.css" rel="stylesheet" media="print"/>
    <style type="text/css">
        #infohasil{
            background:#f8fafb;
            padding:7px;
            color:#081e25;
-moz-border-radius-topleft: 10px;
-moz-border-radius-topright: 10px;
-moz-border-radius-bottomright: 0px;
-moz-border-radius-bottomleft: 0px;
-webkit-border-top-left-radius: 10px;
-webkit-border-top-right-radius: 10px;
-webkit-border-bottom-left-radius: 0px;
-webkit-border-bottom-right-radius: 0px;
            margin-bottom:0;
text-shadow: 2px 2px 5px #bae9ff;
        }
        #infohasil a{
            text-decoration:underline;
            word-spacing:0.1em;
        }
        #infohasil a:hover{
            color:#081e25;
            font-weight:800;
        }
        form label{
            color:#555;
            font-size:1em;
            display:block;
            margin:10px 0 0;
        }
        .read{
            position:relative;
            display:inline;
            color:#222;
            font-size:1.2em;
            font-weight:800;
        }
        #page{
            margin:15px 0 0;
        }
        #page ul{
            list-style:none;
            margin:0;
            padding:0;
        }
        #page ul li{
            display:inline;
        }
        #page ul li a{
            background:#b6d7e7;
            padding:3px 6px;
            margin:2px 3px;
            border:1px solid #69a4c0;
            color:#1a5672;
        }
        #page ul li a:hover{
            font-weight:800;
            background:#6ca9c6;
        }
        #page ul li a:visited{
            color:#1a5672;
        }
        #page ul li span{
            padding:3px 6px;
            background:#f1f7f9;
            font-weight:800;
            margin:2px 3px;
            border:1px solid #f8f8f8;
        }
        hr{
            border:none;
            width:100%;
            border-top:2px solid #f8f8f8;
            margin:30px 0 0;
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
                    <li><div>Daftar</div></li>
                    <li><a href="cari.php">Cari</a></li>
                    <li><a href="laporan.php">Laporan</a></li>
                    <li><a href="statistik.php">Statistik</a><li>
                    <li><a id="logout" href="../login.php?a=logout">Logout</a></li>
                </ul>
            </div>
            <div id="isi">
            <?if(!$nip):?>
                <h2>Daftar Pegawai</h2>
                <?if(empty($_GET['filter'])):?>
                <form id="formfilter" action="daftar.php" method="GET">
                    <fieldset>
                        <legend>Kategori</legend>
                        <input type="hidden" name="filter" id="filter"/>
                        <div class="cond">
                        <select name="kat" class="kat">
                            <option value="c.nama">Unit Kerja</option>
                            <option value="d.golongan">Golongan</option>
                            <option value="b.eselon">Eselon</option>
                            <option value="b.seksi">Seksi</option>
                            <option value="a.tempat_lahir">Tempat Lahir</option>
                            <option value="a.jk">Jenis Kelamin</option>
                            <option value="a.status">Status</option>
                            <option value="a.status_kawin">Status Perkawinan</option>
                            <option value="a.agama">Agama</option>
                        </select>
                        <select name="op" class="op">
                            <option value="=">Samadengan</option>
                            <option value="!=">Tidak samadengan</option>
                        </select>
                        <select name="nilai" class="nilai">
					    <?php foreach($daftarunitkerja as $brs):?>
					        <option value="'<?php echo $brs['nama'];?>'"><?php echo $brs['nama'];?></option>
					    <?php endforeach;?>
                        </select>
                        </div>
                        <input type="button" id="tambah" class="tombol" value="Tambah" />
                        <hr/>
                        <input type="submit" id="kirim" value="Filter" class="tombol"/>
                    </fieldset>
                </form>
                <?endif?>
                <p id="infohasil">
                    <?=$jml?> data pegawai
                    <?if(!empty($filter)):?>
                        [<?=explainQuery($_GET['filter'])?>]
                        <a href="daftar.php">&laquo;reset filter</a>
                        <?if($jml&&$_SESSION['priv']=='input'):?>
                        <a href="export.php?filter=<?=$_GET['filter']?>">export ke excel</a>
                        <?endif;?>
                    <?elseif($jml&&$_SESSION['priv']=='input'):?>
                        <a href="export.php">export ke excel</a>
                    <?endif?>
                </p>
				<table id="daftarpegawai">
					<thead>
						<tr><th>NIP</th><th>Nama</th><th>Jabatan</th><th>Seksi</th><th>Unit Kerja</th><th>Status</th><th>Keterangan</th></tr>
					</thead>
					<tbody>
					    <?foreach($daftarpegawai as $brs):?>
						<tr>
						<td><a href="?nip=<?=$brs['nip']?>"><?=$brs['nip']?></a> <?if($inpt):?><br/><a href="edit.php?snip=<?=$brs['nip']?>">Edit</a><?endif;?></td>
						<td><?=$brs['nama']?></td>
						<td><?=$brs['jabatan']?></td><td><?=$brs['seksi']?></td>
						<td><?=$brs['nama_unit_kerja']?></td><td><?=$brs['status']?></td>
						<td><?=$brs['keterangan']?></td>
						</tr>
						<?endforeach;?>
					</tbody>
				</table>
				<div id="page">
				    <?cetakPage($page,$jmlhlm);?>
				</div>
				<br><br>
            <?else:?>
            <h2>Detail Pegawai <?=$nip?> <a href="daftar.php" class="tombol">&laquo;Kembali</a> 
            <a href="#" id="cetak" class="tombol">Cetak</a>
            <?if($_SESSION['priv']=='input'):?>
                <a href="report/drh.php?nip=<?=$nip?>" class="tombol">Export</a>
            <?endif;?>
            </h2>
			<form>
				<fieldset>
                <img id="foto" src="../lib/gambar.php?nip=<?=$nip?>" width="200" height="300" />
				<label for="nip">NIP</label><div id="nip" class="read"><?=$nip?></div>
				<label for="nmlengkap">Nama Lengkap</label><div id="nmlengkap" class="read"><?=$dp['nama']?></div>
				<label for="golongan">Golongan</label><div id="golongan" class="read"><?php echo $dp['golongan']." ".$dp['ket'];?></div>
				<label for="tmt_jabatan">TMT</label><div id="tmt_jabatan" class="read"><?=$tmt?></div>
				<label for="mk_golongan">Masa Kerja Golongan</label><div id="mk_golongan" class="read"><?=$masakerjagolongan?></div>
				<label for="total_mk">Total Masa Kerja</label><div id="total_mk" class="read"><?=$masakerjatotal?></div>
				<label for="ttl">Tempat Tanggal Lahir</label><div id="ttl" class="read"><?=$dp['tempat_lahir']?>, <?=$dp['tgl_lahir']?></div>
				<label for="agama">Agama</label><div id="agama" class="read"><?=$dp['agama']?></div>
				<label for="jk">Jenis Kelamin</label><div id="jk" class="read"><? echo ($dp['jk']=='P')?'Pria':'Wanita';?></div>
				<br>
				<label for="cpns">CPNS</label><div id="cpns" class="read"><?=$tglcpns?></div>
				<label for="pns">PNS</label><div id="pns" class="read"><?=$tglpns?></div>
				<label for="unitkerja">Unit Kerja</label><div id="unitkerja" class="read"><?=$dp['nama_unit_kerja']?></div>
				<label for="seksi">Seksi</label><div id="seksi" class="read"><?=$dp['seksi']?></div>
		        <label for="jabatan">Jabatan</label><div id="jabatan" class="read"><?=$dp['jabatan']?></div>
		        <label for="pnd_terakhir">Pendidikan terakhir</label><div id="pnd_terakhir" class="read"><?if(!empty($pnd_terakhir)):?><?=$pnd_terakhir['tingkat']?> <?=$pnd_terakhir['jurusan']?> <?=$pnd_terakhir['nama']?> <?=$pnd_terakhir['tahun']?> <?=$pnd_terakhir['tempat']?><?endif;?></div>
				<br>
				<label for="alamat">Alamat</label><div id="alamat" class="read"><?=$dp['jalan']?> <?=$dp['kelurahan']?> <?=$dp['kecamatan']?></div>
				<label for="kab">Kabupaten</label><div id="kab" class="read"><?=$dp['kabupaten']?></div>
				<label for="propinsi">Propinsi</label><div id="propinsi" class="read"><?=$dp['propinsi']?></div>
				<label for="kodepos">Kode Pos</label><div id="kodepos" class="read"><?=$dp['kode_pos']?></div>
                <br>
				<label for="status">Status</label><div id="status" class="read"><?=$dp['status']?></div>
				<label for="statuskawin">Status Pernikahan</label><div id="statuskawin" class="read"><?=$dp['status_kawin']?></div>
				<label for="keterangan">Keterangan</label><div id="keterangan" class="read"><?=$dp['keterangan']?></div>
				<label for="notelp">Nomor Telp.</label><div id="notelp" class="read"><?=$dp['notelp']?></div>
				<br>
				<label for="daftarpendidikan">Pendidikan Formal</label>
				<table id="daftarpendidikan">
	                    <thead>
	                        <tr><th>Tingkat</th><th>Nama</th><th>Jurusan</th><th>No Ijazah</th><th>Tahun</th><th>Tempat</th><th>KepSek/Dekan</th></tr>
	                    </thead>
	                    <tbody>
	                    <?foreach($daftarpendidikan as $brs):?>
	                    <tr>
	                    <td><input type="hidden" name="atingkat_pndd[]" value="<?=$brs['tingkat']?>" ><?=$brs['tingkat']?></td>
                        <td><input type="hidden" name="anm_pndd[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                        <td><input type="hidden" name="ajurusan_pndd[]" value="<?=$brs['jurusan']?>" ><?=$brs['jurusan']?></td>
                        <td><input type="hidden" name="anoijazah_pndd[]" value="<?=$brs['no_ijazah']?>" ><?=$brs['no_ijazah']?></td>
                        <td><input type="hidden" name="athn_pndd[]" value="<?=$brs['tahun']?>" ><?=$brs['tahun']?></td>
                        <td><input type="hidden" name="atmp_pndd[]" value="<?=$brs['tempat']?>" ><?=$brs['tempat']?></td>
                        <td><input type="hidden" name="akepsek_pndd[]" value="<?=$brs['kepsek']?>" ><?=$brs['kepsek']?></td>
                        </tr>
	                    <?endforeach;?>
	                    </tbody>
	            </table>
				<br>
				<label for="nonformal">Pendidikan Non Formal</label>
				<label for="pelatihan">Daftar Pelatihan</label>
				<table id="daftarpelatihan">
					<thead>
						<tr><th>Nama Pelatihan</th><th>Tanggal<br/>Mulai</th><th>Tanggal<br/>Selesai</th><th>No Tanda Lulus</th><th>Tempat</th><th>Ket</th></tr>
					</thead>
					<tbody>
					<?foreach($daftarpelatihan as $brs):?>
					<tr>
                    <td><input type="hidden" name="anm_plthn[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                    <td><input type="hidden" name="atglawal_plthn[]" value="<?=$brs['tgl_awal']?>" ><?=$brs['tgl_awal']?></td>
                    <td><input type="hidden" name="atglakhir_plthn[]" value="<?=$brs['tgl_akhir']?>" ><?=$brs['tgl_akhir']?></td>
                    <td><input type="hidden" name="anobukti_plthn[]" value="<?=$brs['no_tanda_lulus']?>" ><?=$brs['no_tanda_lulus']?></td>
                    <td><input type="hidden" name="atmp_plthn[]" value="<?=$brs['tempat']?>" ><?=$brs['tempat']?></td>
                    <td><input type="hidden" name="aket_plthn[]" value="<?=$brs['ket']?>" ><?=$brs['ket']?></td>
                    </tr>
					<?endforeach;?>
					</tbody>
				</table>
				<br>
				<label for="diklat">Daftar Diklat</label>
				<table id="daftardiklat">
					<thead>
						<tr><th>Jenis<br/>Diklat</th><th>Nama Diklat</th><th>Tanggal<br/>Mulai</th><th>Tanggal<br/>Selesai</th><th>No Tanda Lulus</th><th>Tempat</th><th>Lama (jam)</th><th>Ket</th></tr>
					</thead>
					<tbody>
					<?foreach($daftardiklatpeg as $brs):?>
					<tr>
                    <td><input type="hidden" name="ajns_diklat[]" value="<?=$brs['jenis']?>" ><?=$brs['jenis']?></td>
                    <td><input type="hidden" name="anm_diklat[]" value="<?=$brs['id_jenis_diklat']?>" ><?=$brs['nama']?></td>
                    <td><input type="hidden" name="atglawal_diklat[]" value="<?=$brs['tgl_awal']?>" ><?=$brs['tgl_awal']?></td>
                    <td><input type="hidden" name="atglakhir_diklat[]" value="<?=$brs['tgl_akhir']?>" ><?=$brs['tgl_akhir']?></td>
                    <td><input type="hidden" name="anobukti_diklat[]" value="<?=$brs['no_tanda_lulus']?>" ><?=$brs['no_tanda_lulus']?></td>
                    <td><input type="hidden" name="atmp_diklat[]" value="<?=$brs['tempat']?>" ><?=$brs['tempat']?></td>
                    <td><input type="hidden" name="alama_diklat[]" value="<?=$brs['lama']?>" ><?=$brs['lama']?></td>
                    <td><input type="hidden" name="aket_diklat[]" value="<?=$brs['ket']?>" ><?=$brs['ket']?></td>
                    </tr>
					<?endforeach;?>
					</tbody>
				</table>
				<br>
				
				<label for="penghargaan">Penghargaan</label>
				<table id="daftarpenghargaan">
					<thead>
						<tr><th>Nama Penghargaan</th><th>Tahun Perolehan</th><th>Pihak Pemberi</th></tr>
					</thead>
					<tbody>
                    <?foreach($daftarpenghargaan as $brs):?>
                    <tr>
                    <td><input type="hidden" name="anm_penghargaan[]" value="<?=$brs['nama_penghargaan']?>" ><?=$brs['nama_penghargaan']?></td>
                    <td><input type="hidden" name="athn_penghargaan[]" value="<?=$brs['tahun']?>" ><?=$brs['tahun']?></td>
                    <td><input type="hidden" name="apemberi_penghargaan[]" value="<?=$brs['pihak_pemberi']?>" ><?=$brs['pihak_pemberi']?></td>
                    </tr>
					<?endforeach;?>
					</tbody>
				</table>
						
				</fieldset>
				<fieldset>
					<legend>Riwayat Kepangkatan</legend>
					<table id="daftarkepangkatan">
						<thead>
							<tr><th rowspan=2>Pangkat</th><th rowspan=2>Golongan</th><th rowspan=2>T.M.T</th><th colspan=3 align=center>Surat Keputusan</th><th rowspan=2>Dasar Peraturan</th></tr>
							<tr><th>Pejabat</th><th>Nomor</th><th>Tanggal</th></tr>
						</thead>
						<tbody>
                        <?foreach($daftarkepangkatan as $brs):?>
                        <tr>
                        <td><input type="hidden" name="anm_pangkat[]" value="<?=$brs['pangkat']?>" ><?=$brs['pangkat']?></td>
                        <td><input type="hidden" name="agolongan_pangkat[]" value="<?=$brs['id_golongan']?>" ><?=$brs['golongan']?> <?=$brs['ket']?></td>
                        <td><input type="hidden" name="atmt_pangkat[]" value="<?=$brs['tanggal_berlaku']?>" ><?=$brs['tanggal_berlaku']?></td>
                        <td><input type="hidden" name="ask_pejabat_pangkat[]" value="<?=$brs['sk_pejabat']?>" ><?=$brs['sk_pejabat']?></td>
                        <td><input type="hidden" name="ask_nomor_pangkat[]" value="<?=$brs['sk_nomor']?>" ><?=$brs['sk_nomor']?></td>
                        <td><input type="hidden" name="ask_tgl_pangkat[]" value="<?=$brs['sk_tanggal']?>" ><?=$brs['sk_tanggal']?></td>
                        <td><input type="hidden" name="adasar_pangkat[]" value="<?=$brs['dasar_peraturan']?>" ><?=$brs['dasar_peraturan']?></td>
                        </tr>
						<?endforeach;?>
						</tbody>
					</table>
				</fieldset>
				<br>
				<?if($inpt):?>
				<br>
				<fieldset>
					<legend>Keterangan Badan dan Kegemaran</legend>
					<label for="hobi">Kegemaran (Hobi)</label><div id="hobi" class="read"><? foreach($daftarhobi as $brs):?><?=$brs['hobi']?>, <? endforeach;?></div>
					<label for="tinggi">Tinggi Badan</label><div id="tinggi" class="read"><?=$dp['tinggi']?> cm</div>
					<label for="berat">Berat Badan</label><div id="berat" class="read"><?=$dp['berat']?> kg</div>
					<label for="rambut">Rambut</label><div id="rambut" class="read"><?=$dp['warna_rambut']?></div>
					<label for="bentukmuka">Bentuk Muka</label><div id="bentukmuka" class="read"><?=$dp['bentuk_muka']?></div>
					<label for="warnakulit">Warna Kulit</label><div id="warnakulit" class="read"><?=$dp['warna_kulit']?></div>
					<label for="cirikhas">Ciri-ciri Khas</label><div id="cirikhas" class="read"><?=$dp['ciri_khas']?></div>
					<label for="cacat">Cacat Tubuh</label><div id="cacat" class="read"><?=$dp['cacat_tubuh']?></div>
				</fieldset>
				<br>

				<fieldset>
					<legend>Riwayat Jabatan / Pekerjaan</legend>
					<table id="daftarpengalaman">
							<thead>
								<tr><th rowspan=2>Pengalaman Bekerja</th><th rowspan=2>Tanggal<br/>Mulai</th><th rowspan=2>Tanggal<br/>Selesai</th><th rowspan=2>Golongan</th><th colspan=3 align=center>Surat Keputusan</th></tr>
								<tr><th>Pejabat</th><th>Nomor</th><th>Tanggal</th></tr>
							</thead>
							<tbody>
                            <?foreach($daftarpengalaman as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_pengalaman[]" value="<?=$brs['pengalaman']?>" ><?=$brs['pengalaman']?></td>
                            <td><input type="hidden" name="atglmulai_pengalaman[]" value="<?=$brs['tgl_mulai']?>" ><?=$brs['tgl_mulai']?></td>
                            <td><input type="hidden" name="atglselesai_pengalaman[]" value="<?=$brs['tgl_selesai']?>" ><?=$brs['tgl_selesai']?></td>
                            <td><input type="hidden" name="agol_pengalaman[]" value="<?=$brs['id_golongan']?>" ><?=$brs['golongan']?> <?=$brs['ket']?></td>
                            <td><input type="hidden" name="ask_pejabat_pengalaman[]" value="<?=$brs['sk_pejabat']?>" ><?=$brs['sk_pejabat']?></td>
                            <td><input type="hidden" name="ask_nomor_pengalaman[]" value="<?=$brs['sk_nomor']?>" ><?=$brs['sk_nomor']?></td>
                            <td><input type="hidden" name="ask_tgl_pengalaman[]" value="<?=$brs['sk_tanggal']?>" ><?=$brs['sk_tanggal']?></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
				</fieldset>
				<br>
				<fieldset>
					<legend>Kunjungan Luar Negeri</legend>
					<table id="daftarkunjungan">
						<thead>
							<tr><th>Negara</th><th>Tujuan Kunjungan</th><th>Tanggal<br/>Mulai</th><th>Tanggal<br/>Selesai</th><th>Pembiaya</th></tr>
						</thead>
						<tbody>
                        <?foreach($daftarkunjungan as $brs):?>
                        <tr>
                        <td><input type="hidden" name="anegara_kunjungan[]" value="<?=$brs['negara']?>" ><?=$brs['negara']?></td>
                        <td><input type="hidden" name="atujuan_kunjungan[]" value="<?=$brs['tujuan']?>" ><?=$brs['tujuan']?></td>
                        <td><input type="hidden" name="atglmulai_kunjungan[]" value="<?=$brs['tgl_awal']?>" ><?=$brs['tgl_awal']?></td>
                        <td><input type="hidden" name="atglselesai_kunjungan[]" value="<?=$brs['tgl_akhir']?>" ><?=$brs['tgl_akhir']?></td>
                        <td><input type="hidden" name="apembiaya_kunjungan[]" value="<?=$brs['pembiaya']?>" ><?=$brs['pembiaya']?></td>
                        </tr>
						<?endforeach;?>
						</tbody>
					</table>
				</fieldset>
				<br>
				<fieldset>
					<legend>Seminar / Panitia</legend>
					<table id="daftarseminar">
						<thead>
							<tr><th>Nama</th><th>Peranan</th><th>Tanggal<br/>Penyelenggaraan</th><th>Instansi Penyelenggara</th><th>Tempat</th></tr>
						</thead>
						<tbody>
                        <?foreach($daftarseminar as $brs):?>
                        <tr>
                        <td><input type="hidden" name="anm_seminar[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                        <td><input type="hidden" name="aperanan_seminar[]" value="<?=$brs['peranan']?>" ><?=$brs['peranan']?></td>
                        <td><input type="hidden" name="atgl_seminar[]" value="<?=$brs['tgl_penyelenggaraan']?>" ><?=$brs['tgl_penyelenggaraan']?></td>
                        <td><input type="hidden" name="apenyelenggara_seminar[]" value="<?=$brs['penyelenggara']?>" ><?=$brs['penyelenggara']?></td>
                        <td><input type="hidden" name="atmp_seminar[]" value="<?=$brs['tempat']?>" ><?=$brs['tempat']?></td>
                        </tr>
						<?endforeach;?>
						</tbody>
					</table>
				</fieldset>
				<br>
		        <fieldset>
		            <legend>Keterangan Keluarga</legend>
		            <fieldset>
						<legend>Pasangan Hidup</legend>
						<table id="daftarpasangan">
							<thead>
								<tr><th>Nama</th><th>Tempat Lahir</th><th>Tanggal Lahir</th><th>Tanggal Menikah</th><th>Pekerjaan</th><th>Keterangan</th></tr>
							</thead>
							<tbody>
							<?foreach($daftarpasangan as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_pasangan[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                            <td><input type="hidden" name="atmplhr_pasangan[]" value="<?=$brs['tempat_lahir']?>" ><?=$brs['tempat_lahir']?></td>
                            <td><input type="hidden" name="atgllhr_pasangan[]" value="<?=$brs['tgl_lahir']?>" ><?=$brs['tgl_lahir']?></td>
                            <td><input type="hidden" name="atglmenikah_pasangan[]" value="<?=$brs['tgl_menikah']?>" ><?=$brs['tgl_menikah']?></td>
                            <td><input type="hidden" name="akerja_pasangan[]" value="<?=$brs['pekerjaan']?>" ><?=$brs['pekerjaan']?></td>
                            <td><input type="hidden" name="aket_pasangan[]" value="<?=$brs['keterangan']?>" ><?=$brs['keterangan']?></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
					</fieldset>
					<br>
					<fieldset>
						<legend>Anak</legend>
						<table id="daftaranak">
							<thead>
								<tr><th>Nama</th><th>Jenis Kelamin</th><th>Tempat Lahir</th><th>Tanggal Lahir</th><th>Pekerjaan</th><th>Keterangan</th></tr>
							</thead>
							<tbody>
							<?foreach($daftaranak as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_anak[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                            <td><input type="hidden" name="ajk_anak[]" value="<?=$brs['jk']?>" ><? echo ($brs['jk']=='P')?'Pria':'Wanita';?></td>
                            <td><input type="hidden" name="atmplhr_anak[]" value="<?=$brs['tempat_lahir']?>" ><?=$brs['tempat_lahir']?></td>
                            <td><input type="hidden" name="atgllhr_anak[]" value="<?=$brs['tgl_lahir']?>" ><?=$brs['tgl_lahir']?></td>
                            <td><input type="hidden" name="akerja_anak[]" value="<?=$brs['pekerjaan']?>" ><?=$brs['pekerjaan']?></td>
                            <td><input type="hidden" name="aket_anak[]" value="<?=$brs['keterangan']?>" ><?=$brs['keterangan']?></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
					</fieldset>
					<br>
					<fieldset>
						<legend>Bapak dan Ibu Kandung</legend>
						<table id="daftarortu">
							<thead>
								<tr><th>Nama</th><th>Jenis Kelamin</th><th>Tanggal Lahir</th><th>Pekerjaan</th><th>Keterangan</th></tr>
							</thead>
							<tbody>
                            <?foreach($daftarortu as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_ortu[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                            <td><input type="hidden" name="ajk_ortu[]" value="<?=$brs['jk']?>" ><? echo ($brs['jk']=='P')?'Pria':'Wanita';?></td>
                            <td><input type="hidden" name="atgllhr_ortu[]" value="<?=$brs['tgl_lahir']?>" ><?=$brs['tgl_lahir']?></td>
                            <td><input type="hidden" name="akerja_ortu[]" value="<?=$brs['pekerjaan']?>" ><?=$brs['pekerjaan']?></td>
                            <td><input type="hidden" name="aket_ortu[]" value="<?=$brs['keterangan']?>" ><?=$brs['keterangan']?></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
					</fieldset>
					<br>
					<fieldset>
						<legend>Bapak dan Ibu Mertua</legend>
						<table id="daftarmertua">
							<thead>
								<tr><th>Nama</th><th>Jenis Kelamin</th><th>Tanggal Lahir</th><th>Pekerjaan</th><th>Keterangan</th></tr>
							</thead>
							<tbody>
							<?foreach($daftarmertua as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_mertua[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                            <td><input type="hidden" name="ajk_mertua[]" value="<?=$brs['jk']?>" ><? echo ($brs['jk']=='P')?'Pria':'Wanita';?></td>
                            <td><input type="hidden" name="atgllhr_mertua[]" value="<?=$brs['tgl_lahir']?>" ><?=$brs['tgl_lahir']?></td>
                            <td><input type="hidden" name="akerja_mertua[]" value="<?=$brs['pekerjaan']?>" ><?=$brs['pekerjaan']?></td>
                            <td><input type="hidden" name="aket_mertua[]" value="<?=$brs['keterangan']?>" ><?=$brs['keterangan']?></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
					</fieldset>
					<br>
					<fieldset>
						<legend>Saudara Kandung</legend>
						<table id="daftarsaudara">
							<thead>
								<tr><th>Nama</th><th>Jenis Kelamin</th><th>Tanggal Lahir</th><th>Pekerjaan</th><th>Keterangan</th></tr>
							</thead>
							<tbody>
							<?foreach($daftarsaudara as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_saudara[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                            <td><input type="hidden" name="ajk_saudara[]" value="<?=$brs['jk']?>" ><? echo ($brs['jk']=='P')?'Pria':'Wanita';?></td>
                            <td><input type="hidden" name="atgllhr_saudara[]" value="<?=$brs['tgl_lahir']?>" ><?=$brs['tgl_lahir']?></td>
                            <td><input type="hidden" name="akerja_saudara[]" value="<?=$brs['pekerjaan']?>" ><?=$brs['pekerjaan']?></td>
                            <td><input type="hidden" name="aket_saudara[]" value="<?=$brs['keterangan']?>" ><?=$brs['keterangan']?></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
					</fieldset>
					<br>
					<fieldset>
						<legend>Saudara Kandung Pasangan Hidup</legend>
						<table id="daftaripar">
							<thead>
								<tr><th>Nama</th><th>Jenis Kelamin</th><th>Tanggal Lahir</th><th>Pekerjaan</th><th>Keterangan</th></tr>
							</thead>
							<tbody>
							<?foreach($daftaripar as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_ipar[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                            <td><input type="hidden" name="ajk_ipar[]" value="<?=$brs['jk']?>" ><? echo ($brs['jk']=='P')?'Pria':'Wanita';?></td>
                            <td><input type="hidden" name="atgllhr_ipar[]" value="<?=$brs['tgl_lahir']?>" ><?=$brs['tgl_lahir']?></td>
                            <td><input type="hidden" name="akerja_ipar[]" value="<?=$brs['pekerjaan']?>" ><?=$brs['pekerjaan']?></td>
                            <td><input type="hidden" name="aket_ipar[]" value="<?=$brs['keterangan']?>" ><?=$brs['keterangan']?></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
					</fieldset>
                </fieldset>
				<br>
				<fieldset>
					<legend>Keterangan Organisasi</legend>
					<fieldset>
						<legend>Organisasi saat SMA atau sebelumnya</legend>
						<table id="daftarorg_sma">
							<thead>
								<tr><th>Nama Organisasi</th><th>Kedudukan</th><th>Tahun<br/>Mulai</th><th>Tahun<br/>Selesai</th><th>Tempat</th><th>Pimpinan Organisasi</th></tr>
							</thead>
							<tbody>
							<?foreach($daftarorgsma as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_orgsma[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                            <td><input type="hidden" name="akedudukan_orgsma[]" value="<?=$brs['kedudukan']?>" ><?=$brs['kedudukan']?></td>
                            <td><input type="hidden" name="athnmulai_orgsma[]" value="<?=$brs['tahun_awal']?>" ><?=$brs['tahun_awal']?></td>
                            <td><input type="hidden" name="athnselesai_orgsma[]" value="<?=$brs['tahun_akhir']?>" ><?=$brs['tahun_akhir']?></td>
                            <td><input type="hidden" name="atmp_orgsma[]" value="<?=$brs['tempat']?>" ><?=$brs['tempat']?></td>
                            <td><input type="hidden" name="apimpinan_orgsma[]" value="<?=$brs['nama_pemimpin']?>" ><?=$brs['nama_pemimpin']?></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
					</fieldset>
					<br>
					<fieldset>
						<legend>Organisasi saat Perguruan Tinggi</legend>
						<table id="daftarorg_pt">
							<thead>
								<tr><th>Nama Organisasi</th><th>Kedudukan</th><th>Tahun<br/>Mulai</th><th>Tahun<br/>Selesai</th><th>Tempat</th><th>Pimpinan Organisasi</th></tr>
							</thead>
							<tbody>
                            <?foreach($daftarorgpt as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_orgpt[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                            <td><input type="hidden" name="akedudukan_orgpt[]" value="<?=$brs['kedudukan']?>" ><?=$brs['kedudukan']?></td>
                            <td><input type="hidden" name="athnmulai_orgpt[]" value="<?=$brs['tahun_awal']?>" ><?=$brs['tahun_awal']?></td>
                            <td><input type="hidden" name="athnselesai_orgpt[]" value="<?=$brs['tahun_akhir']?>" ><?=$brs['tahun_akhir']?></td>
                            <td><input type="hidden" name="atmp_orgpt[]" value="<?=$brs['tempat']?>" ><?=$brs['tempat']?></td>
                            <td><input type="hidden" name="apimpinan_orgpt[]" value="<?=$brs['nama_pemimpin']?>" ><?=$brs['nama_pemimpin']?></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
					</fieldset>
					<br>
					<fieldset>
						<legend>Organisasi Selesai Pendidikan</legend>
						<table id="daftarorg_kerja">
							<thead>
								<tr><th>Nama Organisasi</th><th>Kedudukan</th><th>Tahun<br/>Mulai</th><th>Tahun<br/>Selesai</th><th>Tempat</th><th>Pimpinan Organisasi</th></tr>
							</thead>
							<tbody>
                            <?foreach($daftarorgkerja as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_orgkerja[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                            <td><input type="hidden" name="akedudukan_orgkerja[]" value="<?=$brs['kedudukan']?>" ><?=$brs['kedudukan']?></td>
                            <td><input type="hidden" name="athnmulai_orgkerja[]" value="<?=$brs['tahun_awal']?>" ><?=$brs['tahun_awal']?></td>
                            <td><input type="hidden" name="athnselesai_orgkerja[]" value="<?=$brs['tahun_akhir']?>" ><?=$brs['tahun_akhir']?></td>
                            <td><input type="hidden" name="atmp_orgkerja[]" value="<?=$brs['tempat']?>" ><?=$brs['tempat']?></td>
                            <td><input type="hidden" name="apimpinan_orgkerja[]" value="<?=$brs['nama_pemimpin']?>" ><?=$brs['nama_pemimpin']?></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
					</fieldset>
				</fieldset>
				<br>
				<fieldset>
					<legend>Keterangan</legend>
					<fieldset>
					<legend>Keterangan Berkelakuan Baik</legend>
						<label for="skkb_pejabat">Pejabat</label><div id="skkb_pejabat" class="read"><?=$dp['pejabat_skkb']?></div>
						<label for="skkb_nomor">Nomor</label><div id="skkb_nomor" class="read"><?=$dp['no_skkb']?></div>
						<label for="skkb_tgl">Tanggal</label><div id="skkb_tgl" class="read"><?=$dp['tgl_skkb']?></div>
					</fieldset>
					<br>
					<fieldset>
					<legend>Keterangan Berbadan Sehat</legend>
						<label for="sk_sehat_pejabat">Pejabat</label><div id="sk_sehat_pejabat" class="read"><?=$dp['pejabat_ketsehat']?></div>
						<label for="sk_sehat_nomor">Nomor</label><div id="sk_sehat_nomor" class="read"><?=$dp['no_ketsehat']?></div>
						<label for="sk_sehat_tgl">Tanggal</label><div id="sk_sehat_tgl" class="read"><?=$dp['tgl_ketsehat']?></div>
					</fieldset>
					<br>
				</fieldset>
				<?endif;?>
				<br>
				</form>
                <?endif?>
            </div>
        </div>
        <div id="footer"> 2010 &copy; Dinas Perhubungan Jawa Barat </div>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
    $(function() {
        var pnlPesan=$('#pnlpesan'),ttpPesan=$('#pnlpesan a.close'),isiPesan=$('#isipesan'),cond=$('.cond').clone(),filter=$('#filter');
        cond.prepend('<select class="conj">'+
                    '<option value=" and ">Dan</option>'+
                    '<option value=" or ">Atau</option>'+
                    '</select>'
                    );
        $('#cetak').click(function(){
            window.print();
            return false;
        });
        $('#tambah').click(function(){
            $('.cond').last().after(cond.clone());
        });
        ttpPesan.click(function(){
            pnlPesan.fadeOut('fast');
            return false;
        });
        $('.kat').live('change',function(){
            var ini=$(this);
            var nilai=ini.next().next();
            var nama=ini.val();
            nilai.children().remove();
            console.log(ini.val());
            nama=nama.substr(nama.indexOf('.')+1);
            $.ajax({
                url:'../lib/ajax.php?op=listkat&kat='+ini.val(),
                type:'GET',
                timeout:10000,
                dataType: 'json',
                success:function(data){
                        for(var i=0;i<data.length;i++){
                            nilai.append('<option value="\''+data[i][nama]+'\'">'+data[i][nama]+'</option>'); 
                        }
                },
                error:function(e){                   
                    updatePesan('Terjadi kesalahan koneksi');
                }
            });
        });
        $('#kirim').click(function(){
            var query='';
            $('.cond').each(function(){
                $(this).children().each(function(){
                    query+=$(this).val();
                });
            });
            filter.val(query);
        });
        function updatePesan(pesan){
            isiPesan.html(pesan).addClass('cahaya');
            setTimeout(function() {
                isiPesan.removeClass('cahaya', 1500);
            }, 500);
            pnlPesan.fadeIn('slow').animate({opacity:0.8});
        }
        $('table').each(function(){
            $(this).find('tbody').children().filter(':odd').css('background-color','#b6d7e7');
        });
    });
</script>
</html>
