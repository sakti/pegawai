<?php
require_once('../lib/auth.php');
require_once('../lib/conn.php');
require_once('../lib/liboperator.php');
auth('input');
$daftarunitkerja=getDaftarUnitKerja();
$daftargolongan=getDaftarGolongan();
$daftardiklat=getDaftarDiklatByKat('darat');
$edit=false;
if(!empty($_GET['snip'])){
    $edit=true;
    $snip=$_GET['snip'];
    $dp=getDataPegawai($snip);
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
    }
}else{
    $daftarseksi=getDaftarSeksiByUnitKerja($daftarunitkerja[0]['id_unit_kerja']);
    $daftarjabatan=getDaftarJabatanBySUK($daftarunitkerja[0]['id_unit_kerja'],$daftarseksi[0]['seksi']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kepegawaian Dinas Perhubungan</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link type="text/css" href="../css/start/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
    <link type="text/css" href="../css/gaya.css" rel="stylesheet" />
    <style type="text/css">
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
                    <li><a href="input.php">Input</a></li>
                    <li><div>Edit</div></li>
                    <li><a href="upload.php">Upload Foto</a></li>
                    <li><a href="daftar.php">Daftar</a></li>
                    <li><a href="cari.php">Cari</a></li>
                    <li><a href="laporan.php">Laporan</a></li>
                    <li><a href="statistik.php">Statistik</a><li>
                    <li><a id="logout" href="../login.php?a=logout">Logout</a></li>
                </ul>
            </div>
            <div id="isi">
                <h2>Edit data pegawai</h2>
                <?php if(!$edit): ?>
                <form id="formselectpegawai" action="edit.php" method="GET">
	                <fieldset>
	                <legend>Pilih Pegawai</legend>
	                <p>Pilih pegawai yang akan diedit terlebih dahulu. Masukkan nip pegawai yang akan diedit</p>
	                <label for="snip">NIP</label><input type="text" name="snip" id="snip" size="30" maxlength="30">
                    </fieldset>
                    <input type="submit" class="tombol" id="cari" value="Pilih" />
                </form>
                <?php else: ?>
                <?php if($dp):?>
                <form id="formselectpegawai" action="edit.php" method="GET" style="display:none">
	                <fieldset>
	                <legend>Pilih Pegawai</legend>
	                <p>Pilih pegawai yang akan diedit terlebih dahulu. Masukkan nip pegawai yang akan diedit</p>
	                <label for="snip">NIP</label><input type="text" name="snip" id="snip" size="30" maxlength="30">
                    </fieldset>
                    <input type="submit" class="tombol" id="cari" value="Pilih" />
                </form>
                <form id="formeditpegawai" action="../lib/ajax.php" method="POST">
                    <input type="hidden" name="op" id="op" value="updatepegawai" />
                    <input type="hidden" name="id" id="id" value="<?=$dp['id_pegawai']?>">
                    <input type="hidden" name="oldnip" id="oldnip" value="<?=$snip?>" />
                    <input type="hidden" name="edithobi" id="edithobi" value="t" />
                    <input type="hidden" name="editpendidikan" id="editpendidikan" value="t" />
                    <input type="hidden" name="editpelatihan" id="editpelatihan" value="t" />
                    <input type="hidden" name="editdiklat" id="editdiklat" value="t" />
                    <input type="hidden" name="editkepangkatan" id="editkepangkatan" value="t" />
                    <input type="hidden" name="editpengalaman" id="editpengalaman" value="t" />
                    <input type="hidden" name="editpenghargaan" id="editpenghargaan" value="t" />
                    <input type="hidden" name="editkunjungan" id="editkunjungan" value="t" />
                    <input type="hidden" name="editseminar" id="editseminar" value="t" />
                    <input type="hidden" name="editpasangan" id="editpasangan" value="t" />
                    <input type="hidden" name="editanak" id="editanak" value="t" />
                    <input type="hidden" name="editortu" id="editortu" value="t" />
                    <input type="hidden" name="editmertua" id="editmertua" value="t" />
                    <input type="hidden" name="editsaudara" id="editsaudara" value="t" />
                    <input type="hidden" name="editipar" id="editipar" value="t" />
                    <input type="hidden" name="editorgsma" id="editorgsma" value="t" />
                    <input type="hidden" name="editorgpt" id="editorgpt" value="t" />
                    <input type="hidden" name="editorgkerja" id="editorgkerja" value="t" />
	                <fieldset>
	                <legend>Keterangan Perseorangan</legend>
	                <img id="foto" src="../lib/gambar.php?nip=<?=$snip?>" width="200" height="300" />
	                <label for="nmlengkap">Nama Lengkap</label>
	                <input type="text" value="<?=$dp['nama']?>" name="nmlengkap" id="nmlengkap" size="30" maxlength="50">
                    <label for="nip">NIP</label>
                    <input type="text" value="<?=$dp['nip']?>" name="nip" id="nip" size="20" maxlength="30">
					<label for="golongan">Golongan Ruang</label>
					<select name="golongan" id="golongan">
					    <?php foreach($daftargolongan as $brs):?>
					    <option value="<?php echo $brs['id_golongan'];?>" <?if($brs['id_golongan']==$dp['id_golongan']) echo 'selected="selected"';?>><?php echo $brs['golongan']." ".$brs['ket'];?></option>
					    <?php endforeach;?>
                    </select>
					<label for="unitkerja">Unit Kerja</label>
					<select name="unitkerja" id="unitkerja">
					    <?php foreach($daftarunitkerja as $brs):?>
					    <option value="<?=$brs['id_unit_kerja']?>" <? if($brs['id_unit_kerja']==$dp['id_unit_kerja']) echo 'selected="selected"';?>><?php echo $brs['nama'];?></option>
					    <?php endforeach;?>
					</select>
                    <label for="seksi">Seksi</label>
                    <select name="seksi" id="seksi">
					    <?php foreach($daftarseksi as $brs):?>
					    <option value="<?php echo $brs['seksi'];?>" <? if($brs['seksi']==$dp['seksi']) echo 'selected="selected"'; ?>><?php echo $brs['seksi'];?></option>
					    <?php endforeach;?>
                    </select>
					<label for="jabatan">Jabatan</label>
					<select name="jabatan" id="jabatan">
					    <?php foreach($daftarjabatan as $brs):?>
					    <option value="<?php echo $brs['id_jabatan'];?>" <? if($brs['id_jabatan']==$dp['id_jabatan']) echo 'selected="selected"';?>><?php echo $brs['jabatan'];?></option>
					    <?php endforeach;?>
                    </select>
                    <a href="#" class="tombol" id="tambahjabatan">Tambah Jabatan</a>
					<label for="tgllahir">Tanggal Lahir</label>
					<input type="text" value="<?=$dp['tgl_lahir']?>"name="tgllahir" id="tgllahir" size="10" maxlength="20" class="tanggal">
					<label for="tmplahir">Tempat Lahir</label>
					<input type="text" value="<?=$dp['tempat_lahir']?>" name="tmplahir" id="tmplahir" size="30" maxlength="35">
					<label for="jk">Jenis Kelamin</label>
					<select name="jk" id="jk">
					    <option value="P" <? if($dp['jk']=='P') echo 'selected="selected"';?>>Pria</option>
					    <option value="W" <? if($dp['jk']=='W') echo 'selected="selected"';?>>Wanita</option>
					</select>
					<label for="agama">Agama</label>
					<select id="agama" name="agama">
					    <option value="islam" <?if($dp['agama']=='islam') echo 'selected="selected"';?>>Islam</option>
					    <option value="kristen" <?if($dp['agama']=='kristen') echo 'selected="selected"';?>>Kristen</option>
					    <option value="katolik" <?if($dp['agama']=='katolik') echo 'selected="selected"';?>>Katolik</option>
					    <option value="budha" <?if($dp['agama']=='budha') echo 'selected="selected"';?>>Budha</option>
					    <option value="hindu" <?if($dp['agama']=='hindu') echo 'selected="selected"';?>>Hindu</option>
					    <option value="konghochu" <?if($dp['agama']=='konghochu') echo 'selected="selected"';?>>Konghochu</option>
					</select>
					<label for="kepercayaan">Kepercayaan terhadap Tuhan YME</label>
					<input type="text" value="<?=$dp['kepercayaan']?>" name="kepercayaan" id="kepercayaan" size="15" maxlength="20">
					<label for="status">Status</label>
					<select name="status" id="status">
					    <option value="CPNS" <?if($dp['status']=='CPNS') echo 'selected="selected"';?>>CPNS</option>
					    <option value="PNS" <?if($dp['status']=='PNS') echo 'selected="selected"';?>>PNS</option>
					    <option value="mutasi" <?if($dp['status']=='mutasi') echo 'selected="selected"';?>>Mutasi</option>
					    <option value="pensiun" <?if($dp['status']=='pensiun') echo 'selected="selected"';?>>Pensiun</option>
					    <option value="meninggal" <?if($dp['status']=='meninggal') echo 'selected="selected"';?>>Meninggal</option>
					</select>
					<label for="statuskawin">Status Perkawinan</label>
					<select name="statuskawin" id="statuskawin">
                        <option value="belumkawin" <?if($dp['status_kawin']=='belumkawin') echo 'selected="selected"';?>>Belum Kawin</option>
						<option value="kawin" <?if($dp['status_kawin']=='kawin') echo 'selected="selected"';?>>Kawin</option>
						<option value="janda" <?if($dp['status_kawin']=='janda') echo 'selected="selected"';?>>Janda</option>
						<option value="duda" <?if($dp['status_kawin']=='duda') echo 'selected="selected"';?>>Duda</option>
                    </select>
                    <label for="notelp">Nomor Telp.</label>
                    <input type="text" name="notelp" id="notelp" size="20" maxlength="25" value="<?=$dp['notelp']?>"/>
					<br><br>
					<fieldset>
					<legend>Daftar Kegemaran</legend>
					<table id="daftarhobi">
							<thead>
								<tr><th>Kegemaran</th><th>&nbsp;</th></tr>
							</thead>
							<tbody>
							<? foreach($daftarhobi as $brs):?>
							    <tr>
							    <td><input type="hidden" name="ahobi[]" value="<?=$brs['hobi']?>" /><?=$brs['hobi']?></td>
							    <td><a href="#">Delete</a></td>
							    </tr>
							<? endforeach;?>
							</tbody>
						</table>
					<label for="hobi">Kegemaran (Hobi)</label><input type="text" name="hobi" id="hobi" size="15" maxlength="30">
					<input type="button" value="Tambahkan" id="tambahhobi" class="tombol">
					</fieldset>
					<br>
					<fieldset>
						<legend>Alamat Rumah</legend>
						<label for="jalan">Jalan</label>
						<input type="text" value="<?=$dp['jalan']?>" name="jalan" id="jalan" size="50" maxlength="100">
						<label for="desa">Desa</label>
						<input type="text" value="<?=$dp['kelurahan']?>" name="desa" id="desa" size="20" maxlength="30">
						<label for="kec">Kecamatan</label>
						<input type="text" value="<?=$dp['kecamatan']?>" name="kec" id="kec" size="20" maxlength="30">
						<label for="kab">Kabupaten</label>
						<input type="text" value="<?=$dp['kabupaten']?>" name="kab" id="kab" size="20" maxlength="30">
						<label for="propinsi">Propinsi</label>
						<input type="text" value="<?=$dp['propinsi']?>" name="propinsi" id="propinsi" size="20" maxlength="30">
						<label for="kodepos">Kode Pos</label>
						<input type="text" value="<?=$dp['kode_pos']?>" name="kodepos" id="kodepos" size="5" maxlength="5">
					</fieldset>
                    <br>
					<fieldset>
					<legend>Keterangan Badan</legend>
						<label for="tinggi">Tinggi Badan (Cm)</label>
						<input type="text" value="<?=$dp['tinggi']?>" name="tinggi" id="tinggi" size="4" maxlength="4">
						<label for="berat">Berat Badan (Kg)</label>
						<input type="text" value="<?=$dp['berat']?>" name="berat" id="berat" size="4" maxlength="4">
						<label for="rambut">Rambut</label>
						<input type="text" value="<?=$dp['warna_rambut']?>" name="rambut" id="rambut" size="15" maxlength="30">
						<label for="bentukmuka">Bentuk Muka</label>
						<input type="text" value="<?=$dp['bentuk_muka']?>" name="bentukmuka" id="bentukmuka" size="15" maxlength="30">
						<label for="warnakulit">Warna Kulit</label>
						<input type="text" value="<?=$dp['warna_kulit']?>" name="warnakulit" id="warnakulit" size="15" maxlength="30">
						<label for="cirikhas">Ciri-ciri Khas</label>
						<input type="text" value="<?=$dp['ciri_khas']?>" name="cirikhas" id="cirikhas" size="20" maxlength="30">
						<label for="cacat">Cacat Tubuh</label>
						<input type="text" value="<?=$dp['cacat_tubuh']?>" name="cacat" id="cacat" size="30" maxlength="30" value="-">
					</fieldset>
                    </fieldset>
					<br>
	                <fieldset>
	                <legend>Pendidikan</legend>
	                <table id="daftarpendidikan">
	                    <thead>
	                        <tr><th>Tingkat</th><th>Nama</th><th>Jurusan</th><th>No Ijazah</th><th>Tahun</th><th>Tempat</th><th>KepSek/Dekan</th><th>&nbsp;</th></tr>
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
                        <td><a href="#">Delete</a></td>
                        </tr>
	                    <?endforeach;?>
	                    </tbody>
	                </table>
						<label for="opsitingkat">Tingkat</label>
						<select name="opsitingkat" id="opsitingkat">
							<option value="SD">SD</option>
							<option value="SMP">SMP</option>
							<option value="SMA">SMA</option>
							<option value="SMK">SMK</option>
							<option value="D1">D1</option>
							<option value="D2">D2</option>
							<option value="D3">D3</option>
							<option value="D4">D4</option>
							<option value="S1">S1</option>
							<option value="S2">S2</option>
							<option value="S3">S3</option>
						</select>
	                <label for="nmpendidikan">Nama Pendidikan</label><input type="text" name="nmpendidikan" id="nmpendidikan" size="35" maxlength="60">
                    <label for="jurusan">Jurusan</label><input type="text" name="jurusan" id="jurusan" size="30" maxlength="30">
                    <label for="noijazah">No Ijazah</label><input type="text" name="noijazah" id="noijazah" size="30" maxlength="40" />
					<label for="thnpendidikan">Tahun</label><input type="text" name="thnpendidikan" id="thnpendidikan" size="4" maxlength="4">
					<label for="tmppendidikan">Tempat</label><input type="text" name="tmppendidikan" id="tmppendidikan" size="20" maxlength="30">
					<label for="kepsek">Nama Kepala Sekolah / Dekan</label><input type="text" name="kepsek" id="kepsek" size="30" maxlength="50">
                    <input type="button" value="Tambahkan" id="tambahsekolah" class="tombol">
					<br>
					<fieldset>
						<legend>Pelatihan</legend>
						<table id="daftarpelatihan">
							<thead>
								<tr><th>Nama Pelatihan</th><th>Tanggal<br/>Mulai</th><th>Tanggal<br/>Selesai</th><th>No Tanda Lulus</th><th>Tempat</th><th>Ket</th><th>&nbsp;</th></tr>
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
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="nmpelatihan">Nama Pelatihan</label><input type="text" name="nmpelatihan" id="nmpelatihan" size="35" maxlength="60">
						<label for="tgl_awalpelatihan">Tanggal Mulai</label><input type="text" name="tgl_awalpelatihan" id="tgl_awalpelatihan" size="10" maxlength="15" class="tanggal">
						<label for="tgl_akhirpelatihan">Tanggal Selesai</label><input type="text" name="tgl_akhirpelatihan" id="tgl_akhirpelatihan" size="10" maxlength="15" class="tanggal">
						<label for="nobuktipelatihan">No Tanda Lulus</label><input type="text" name="nobuktipelatihan" id="nobuktipelatihan" size="30" maxlength="40">
						<label for="tmppelatihan">Tempat</label><input type="text" name="tmppelatihan" id="tmppelatihan" size="20" maxlength="30">
						<label for="ketpelatihan">Keterangan</label><input type="text" name="ketpelatihan" id="ketpelatihan" size="30" maxlength="40"/>
						<input type="button" value="Tambahkan" id="tambahpelatihan" class="tombol">
					</fieldset>
					<br>
					<fieldset>
						<legend>Diklat Penjenjangan</legend>
						<table id="daftardiklat">
							<thead>
								<tr><th>Jenis<br/>Diklat</th><th>Nama Diklat</th><th>Tanggal<br/>Mulai</th><th>Tanggal<br/>Selesai</th><th>No Tanda Lulus</th><th>Tempat</th><th>Lama (jam)</th><th>Ket</th><th>&nbsp;</th></tr>
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
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="opsidiklat">Tingkat</label>
						<select name="opsidiklat" id="opsidiklat">
							<option value="darat">Darat</option>
							<option value="laut">Laut</option>
							<option value="udara">Udara</option>
							<option value="ketatausahaan">Ketatausahaan</option>
							<option value="umum">Umum</option>
						</select>
						<label for="nmdiklat">Nama Diklat</label>
					    <select name="nmdiklat" id="nmdiklat">
					        <?php foreach($daftardiklat as $brs):?>
				            <option value="<?php echo $brs['id_jenis_diklat'];?>"><?php echo $brs['nama'];?></option>
				            <?php endforeach;?>
				        </select>
				        <a href="#" class="tombol" id="tambahdiklatbaru">Tambah Diklat</a>
						<label for="tgl_awaldiklat">Tanggal Mulai</label><input type="text" name="tgl_awaldiklat" id="tgl_awaldiklat" size="10" maxlength="15" class="tanggal">
						<label for="tgl_akhirdiklat">Tanggal Selesai</label><input type="text" name="tgl_akhirdiklat" id="tgl_akhirdiklat" size="10" maxlength="15" class="tanggal">
						<label for="nobuktidiklat">No Bukti Lulus Diklat</label><input type="text" name="nobuktidiklat" id="nobuktidiklat" size="20" maxlength="40">
						<label for="tmpdiklat">Tempat</label><input type="text" name="tmpdiklat" id="tmpdiklat" size="20" maxlength="30">
						<label for="lamadiklat">Lama(jam)</label><input type="text" name="lamadiklat" id="lamadiklat" size="3" maxlength="4" />
						<label for="ketdiklat">Keterangan</label><input type="text" name="ketdiklat" id="ketdiklat" size="30" maxlength="35"/>
						<input type="button" value="Tambahkan" id="tambahdiklat" class="tombol">
					</fieldset>
					
                    </fieldset>
					<br>
					<fieldset>
						<legend>Riwayat Kepangkatan</legend>
						<table id="daftarkepangkatan">
							<thead>
								<tr><th rowspan=2>Pangkat</th><th rowspan=2>Golongan</th><th rowspan=2>T.M.T</th><th colspan=3 align=center>Surat Keputusan</th><th rowspan=2>Dasar Peraturan</th><th rowspan=2>&nbsp;</th></tr>
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
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="pangkat">Pangkat</label>
						<select name="pangkat" id="pangkat">
						    <option value="CPNS">CPNS</option>
						    <option value="PNS">PNS</option>
						</select>
						<label for="pangkat_gol">Golongan</label>
							<select name="pangkat_gol" id="pangkat_gol">
					            <?php foreach($daftargolongan as $brs):?>
					            <option value="<?php echo $brs['id_golongan'];?>"><?php echo $brs['golongan']." ".$brs['ket'];?></option>
					            <?php endforeach;?>
							</select>
						<label for="tgl_berlaku">Terhitung Mulai Tanggal</label><input type="text" name="tgl_berlaku" id="tgl_berlaku" size="10" maxlength="15" class="tanggal">
						<label for="pangkat_sk_pejabat">Pejabat SK</label><input type="text" name="pangkat_sk_pejabat" id="pangkat_sk_pejabat" size="20" maxlength="40">
						<label for="pangkat_sk_nomor">Nomor SK</label><input type="text" name="pangkat_sk_nomor" id="pangkat_sk_nomor" size="20" maxlength="40">
						<label for="pangkat_sk_tgl">Tanggal SK</label><input type="text" name="pangkat_sk_tgl" id="pangkat_sk_tgl" size="10" maxlength="15" class="tanggal">
						<label for="dasarperaturan">Dasar Peraturan</label><input type="text" name="dasarperaturan" id="dasarperaturan" size="20" maxlength="40">
						<input type="button" value="Tambahkan" id="tambahkepangkatan" class="tombol">
					</fieldset>
					<br>
					
					<fieldset>
						<legend>Riwayat Jabatan / Pekerjaan</legend>
						<table id="daftarpengalaman">
							<thead>
								<tr><th rowspan=2>Pengalaman Bekerja</th><th rowspan=2>Tanggal<br/>Mulai</th><th rowspan=2>Tanggal<br/>Selesai</th><th rowspan=2>Golongan</th><th colspan=3 align=center>Surat Keputusan</th><th rowspan=2>&nbsp;</th></tr>
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
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="pengalaman">Pengalaman Bekerja</label><input type="text" name="pengalaman" id="pengalaman" size="40" maxlength="60">
						<label for="tgl_mulaipengalaman">Tanggal Mulai</label><input type="text" name="tgl_mulaipengalaman" id="tgl_mulaipengalaman" size="10" maxlength="15" class="tanggal">
						<label for="tgl_selesaipengalaman">Tanggal Selesai</label><input type="text" name="tgl_selesaipengalaman" id="tgl_selesaipengalaman" size="10" maxlength="15" class="tanggal">
						<label for="pengalaman_gol">Golongan</label>
							<select name="pengalaman_gol" id="pengalaman_gol">
					            <?php foreach($daftargolongan as $brs):?>
					            <option value="<?php echo $brs['id_golongan'];?>"><?php echo $brs['golongan']." ".$brs['ket'];?></option>

					            <?php endforeach;?>
							</select>
						<label for="pengalaman_sk_pejabat">Pejabat SK</label><input type="text" name="pengalaman_sk_pejabat" id="pengalaman_sk_pejabat" size="30" maxlength="40">
						<label for="pengalaman_sk_nomor">Nomor SK</label><input type="text" name="pengalaman_sk_nomor" id="pengalaman_sk_nomor" size="30" maxlength="40">
						<label for="pengalaman_sk_tgl">Tanggal SK</label><input type="text" name="pengalaman_sk_tgl" id="pengalaman_sk_tgl" size="10" maxlength="15" class="tanggal">
						<input type="button" value="Tambahkan" id="tambahpekerjaan" class="tombol">
					</fieldset>
					<br>
					<fieldset>
						<legend>Penghargaan</legend>
						<table id="daftarpenghargaan">
							<thead>
								<tr><th>Nama Penghargaan</th><th>Tahun Perolehan</th><th>Pihak Pemberi</th><th>&nbsp;</th></tr>
							</thead>
							<tbody>
                            <?foreach($daftarpenghargaan as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_penghargaan[]" value="<?=$brs['nama_penghargaan']?>" ><?=$brs['nama_penghargaan']?></td>
                            <td><input type="hidden" name="athn_penghargaan[]" value="<?=$brs['tahun']?>" ><?=$brs['tahun']?></td>
                            <td><input type="hidden" name="apemberi_penghargaan[]" value="<?=$brs['pihak_pemberi']?>" ><?=$brs['pihak_pemberi']?></td>
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="nmpenghargaan">Nama Penghargaan</label><input type="text" name="nmpenghargaan" id="nmpenghargaan" size="45" maxlength="60">
						<label for="tahunpenghargaan">Tahun Penghargaan</label><input type="text" name="tahunpenghargaan" id="tahunpenghargaan" size="4" maxlength="4">
						<label for="pihakpemberi">Pihak Pemberi</label><input type="text" name="pihakpemberi" id="pihakpemberi" size="40" maxlength="60">
						<input type="button" value="Tambahkan" id="tambahpenghargaan" class="tombol">
					</fieldset>
					<br>
					<fieldset>
						<legend>Kunjungan Luar Negeri</legend>
						<table id="daftarkunjungan">
							<thead>
								<tr><th>Negara</th><th>Tujuan Kunjungan</th><th>Tanggal<br/>Mulai</th><th>Tanggal<br/>Selesai</th><th>Pembiaya</th><th>&nbsp;</th></tr>
							</thead>
							<tbody>
                            <?foreach($daftarkunjungan as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anegara_kunjungan[]" value="<?=$brs['negara']?>" ><?=$brs['negara']?></td>
                            <td><input type="hidden" name="atujuan_kunjungan[]" value="<?=$brs['tujuan']?>" ><?=$brs['tujuan']?></td>
                            <td><input type="hidden" name="atglmulai_kunjungan[]" value="<?=$brs['tgl_awal']?>" ><?=$brs['tgl_awal']?></td>
                            <td><input type="hidden" name="atglselesai_kunjungan[]" value="<?=$brs['tgl_akhir']?>" ><?=$brs['tgl_akhir']?></td>
                            <td><input type="hidden" name="apembiaya_kunjungan[]" value="<?=$brs['pembiaya']?>" ><?=$brs['pembiaya']?></td>
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="negara">Negara</label><input type="text" name="negara" id="negara" size="35" maxlength="35">
						<label for="tujuan">Tujuan Kunjungan</label><input type="text" name="tujuan" id="tujuan" size="30" maxlength="50">
						<label for="tgl_mulaikunjungan">Tanggal Mulai</label><input type="text" name="tgl_mulaikunjungan" id="tgl_mulaikunjungan" size="10" maxlength="15" class="tanggal">
						<label for="tgl_selesaikunjungan">Tanggal Selesai</label><input type="text" name="tgl_selesaikunjungan" id="tgl_selesaikunjungan" size="10" maxlength="15" class="tanggal">
						<label for="pembiaya">Pembiaya</label><input type="text" name="pembiaya" id="pembiaya" size="35" maxlength="35">
						<input type="button" value="Tambahkan" id="tambahkunjungan" class="tombol">
					</fieldset>
					<br>
					<fieldset>
						<legend>Seminar / Panitia</legend>
						<table id="daftarseminar">
							<thead>
								<tr><th>Nama</th><th>Peranan</th><th>Tanggal<br/>Penyelenggaraan</th><th>Instansi Penyelenggara</th><th>Tempat</th><th>&nbsp;</th></tr>
							</thead>
							<tbody>
                            <?foreach($daftarseminar as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_seminar[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                            <td><input type="hidden" name="aperanan_seminar[]" value="<?=$brs['peranan']?>" ><?=$brs['peranan']?></td>
                            <td><input type="hidden" name="atgl_seminar[]" value="<?=$brs['tgl_penyelenggaraan']?>" ><?=$brs['tgl_penyelenggaraan']?></td>
                            <td><input type="hidden" name="apenyelenggara_seminar[]" value="<?=$brs['penyelenggara']?>" ><?=$brs['penyelenggara']?></td>
                            <td><input type="hidden" name="atmp_seminar[]" value="<?=$brs['tempat']?>" ><?=$brs['tempat']?></td>
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="nmseminar">Nama</label><input type="text" name="nmseminar" id="nmseminar" size="35" maxlength="40">
						<label for="peranan">Peranan</label><input type="text" name="peranan" id="peranan" size="20" maxlength="35">
						<label for="tgl_penyelenggaraan">Tanggal Penyelenggaraan</label><input type="text" name="tgl_penyelenggaraan" id="tgl_penyelenggaraan" size="10" maxlength="15" class="tanggal">
						<label for="penyelenggara">Instansi Penyelenggara</label><input type="text" name="penyelenggara" id="penyelenggara" size="20" maxlength="15">
						<label for="tmpseminar">Tempat</label><input type="text" name="tmpseminar" id="tmpseminar" size="20" maxlength="35">
						<input type="button" value="Tambahkan" id="tambahseminar" class="tombol">
					</fieldset>
					<br>
	                <fieldset>
	                <legend>Keterangan Keluarga</legend>
	                <fieldset>
						<legend>Pasangan Hidup</legend>
						<table id="daftarpasangan">
							<thead>
								<tr><th>Nama</th><th>Tempat Lahir</th><th>Tanggal Lahir</th><th>Tanggal Menikah</th><th>Pekerjaan</th><th>Keterangan</th><th>&nbsp;</th></tr>
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
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="nmpasangan">Nama</label><input type="text" name="nmpasangan" id="nmpasangan" size="30" maxlength="30">
						<label for="tmplahirpasangan">Tempat Lahir</label><input type="text" name="tmplahirpasangan" id="tmplahirpasangan" size="15" maxlength="30">
						<label for="tgllahirpasangan">Tanggal Lahir</label><input type="text" name="tgllahirpasangan" id="tgllahirpasangan" size="10" maxlength="20" class="tanggal">
						<label for="tglmenikah">Tanggal Menikah</label><input type="text" name="tglmenikah" id="tglmenikah" size="10" maxlength="20" class="tanggal">
						<label for="kerjapasangan">Pekerjaan</label><input type="text" name="kerjapasangan" id="kerjapasangan" size="15" maxlength="30">
						<label for="ket_pasangan">Keterangan</label><input type="text" name="ket_pasangan" id="ket_pasangan" size="15" maxlength="30">
						<input type="button" value="Tambahkan" id="tambahpasangan" class="tombol">
					</fieldset>
					<br>
					<fieldset>
						<legend>Anak</legend>
						<table id="daftaranak">
							<thead>
								<tr><th>Nama</th><th>Jenis Kelamin</th><th>Tempat Lahir</th><th>Tanggal Lahir</th><th>Pekerjaan</th><th>Keterangan</th><th>&nbsp;</th></tr>
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
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="nmanak">Nama</label><input type="text" name="nmanak" id="nmanak" size="35" maxlength="60">
						<label for="jk_anak">Jenis Kelamin</label>
					    <select name="jk_anak" id="jk_anak">
						    <option value="P">Pria</option>
						    <option value="W">Wanita</option>
						</select>
						<label for="tmplahiranak">Tempat Lahir</label><input type="text" name="tmplahiranak" id="tmplahiranak" size="25" maxlength="30">
						<label for="tgllahiranak">Tanggal Lahir</label><input type="text" name="tgllahiranak" id="tgllahiranak" size="10" maxlength="20" class="tanggal">
						<label for="kerjaanak">Pekerjaan</label><input type="text" name="kerjaanak" id="kerjaanak" size="15" maxlength="30">
						<label for="ket_anak">Keterangan</label><input type="text" name="ket_anak" id="ket_anak" size="15" maxlength="30">
						<input type="button" value="Tambahkan" id="tambahanak" class="tombol">
					</fieldset>
					<br>
					<fieldset>
						<legend>Bapak dan Ibu Kandung</legend>
						<table id="daftarortu">
							<thead>
								<tr><th>Nama</th><th>Jenis Kelamin</th><th>Tanggal Lahir</th><th>Pekerjaan</th><th>Keterangan</th><th>&nbsp;</th></tr>
							</thead>
							<tbody>
                            <?foreach($daftarortu as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_ortu[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                            <td><input type="hidden" name="ajk_ortu[]" value="<?=$brs['jk']?>" ><? echo ($brs['jk']=='P')?'Pria':'Wanita';?></td>
                            <td><input type="hidden" name="atgllhr_ortu[]" value="<?=$brs['tgl_lahir']?>" ><?=$brs['tgl_lahir']?></td>
                            <td><input type="hidden" name="akerja_ortu[]" value="<?=$brs['pekerjaan']?>" ><?=$brs['pekerjaan']?></td>
                            <td><input type="hidden" name="aket_ortu[]" value="<?=$brs['keterangan']?>" ><?=$brs['keterangan']?></td>
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>


						</table>
						<label for="nmortu">Nama</label><input type="text" name="nmortu" id="nmortu" size="30" maxlength="30">
						<label for="jk_ortu">Jenis Kelamin</label>
						<select name="jk_ortu" id="jk_ortu">
							<option value="P">Pria</option>
							<option value="W">Wanita</option>
						</select>
						<label for="tgllahirortu">Tanggal Lahir</label><input type="text" name="tgllahirortu" id="tgllahirortu" size="10" maxlength="20" class="tanggal">
						<label for="kerjaortu">Pekerjaan</label><input type="text" name="kerjaortu" id="kerjaortu" size="20" maxlength="30">
						<label for="ket_ortu">Keterangan</label><input type="text" name="ket_ortu" id="ket_ortu" size="20" maxlength="30">
						<input type="button" value="Tambahkan" id="tambahortu" class="tombol">
					</fieldset>
					<br>
					<fieldset>
						<legend>Bapak dan Ibu Mertua</legend>
						<table id="daftarmertua">
							<thead>
								<tr><th>Nama</th><th>Jenis Kelamin</th><th>Tanggal Lahir</th><th>Pekerjaan</th><th>Keterangan</th><th>&nbsp;</th></tr>
							</thead>
							<tbody>
							<?foreach($daftarmertua as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_mertua[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                            <td><input type="hidden" name="ajk_mertua[]" value="<?=$brs['jk']?>" ><? echo ($brs['jk']=='P')?'Pria':'Wanita';?></td>
                            <td><input type="hidden" name="atgllhr_mertua[]" value="<?=$brs['tgl_lahir']?>" ><?=$brs['tgl_lahir']?></td>
                            <td><input type="hidden" name="akerja_mertua[]" value="<?=$brs['pekerjaan']?>" ><?=$brs['pekerjaan']?></td>
                            <td><input type="hidden" name="aket_mertua[]" value="<?=$brs['keterangan']?>" ><?=$brs['keterangan']?></td>
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="nmmertua">Nama</label><input type="text" name="nmmertua" id="nmmertua" size="30" maxlength="30">
						<label for="jk_mertua">Jenis Kelamin</label>
						<select name="jk_mertua" id="jk_mertua">
							<option value="P">Pria</option>
							<option value="W">Wanita</option>
						</select>
						<label for="tgllahirmertua">Tanggal Lahir</label><input type="text" name="tgllahirmertua" id="tgllahirmertua" size="10" maxlength="20" class="tanggal">
						<label for="kerjamertua">Pekerjaan</label><input type="text" name="kerjamertua" id="kerjamertua" size="20" maxlength="30">
						<label for="ket_mertua">Keterangan</label><input type="text" name="ket_mertua" id="ket_mertua" size="20" maxlength="30">
						<input type="button" value="Tambahkan" id="tambahmertua" class="tombol">
					</fieldset>
					<br>
					<fieldset>
						<legend>Saudara Kandung</legend>
						<table id="daftarsaudara">
							<thead>
								<tr><th>Nama</th><th>Jenis Kelamin</th><th>Tanggal Lahir</th><th>Pekerjaan</th><th>Keterangan</th><th>&nbsp;</th></tr>
							</thead>
							<tbody>
							<?foreach($daftarsaudara as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_saudara[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                            <td><input type="hidden" name="ajk_saudara[]" value="<?=$brs['jk']?>" ><? echo ($brs['jk']=='P')?'Pria':'Wanita';?></td>
                            <td><input type="hidden" name="atgllhr_saudara[]" value="<?=$brs['tgl_lahir']?>" ><?=$brs['tgl_lahir']?></td>
                            <td><input type="hidden" name="akerja_saudara[]" value="<?=$brs['pekerjaan']?>" ><?=$brs['pekerjaan']?></td>
                            <td><input type="hidden" name="aket_saudara[]" value="<?=$brs['keterangan']?>" ><?=$brs['keterangan']?></td>
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="nmsaudara">Nama</label><input type="text" name="nmsaudara" id="nmsaudara" size="30" maxlength="30">
						<label for="jk_saudara">Jenis Kelamin</label>
						<select name="jk_saudara" id="jk_saudara">
							<option value="P">Pria</option>
							<option value="W">Wanita</option>
						</select>
						<label for="tgllahirsaudara">Tanggal Lahir</label><input type="text" name="tgllahirsaudara" id="tgllahirsaudara" size="10" maxlength="20" class="tanggal">
						<label for="kerjasaudara">Pekerjaan</label><input type="text" name="kerjasaudara" id="kerjasaudara" size="15" maxlength="30">
						<label for="ket_saudara">Keterangan</label><input type="text" name="ket_saudara" id="ket_saudara" size="15" maxlength="30">
						<input type="button" value="Tambahkan" id="tambahsaudara" class="tombol">
					</fieldset>
					<br>
					<fieldset>
						<legend>Saudara Kandung Pasangan Hidup</legend>
						<table id="daftaripar">
							<thead>
								<tr><th>Nama</th><th>Jenis Kelamin</th><th>Tanggal Lahir</th><th>Pekerjaan</th><th>Keterangan</th><th>&nbsp;</th></tr>
							</thead>
							<tbody>
							<?foreach($daftaripar as $brs):?>
                            <tr>
                            <td><input type="hidden" name="anm_ipar[]" value="<?=$brs['nama']?>" ><?=$brs['nama']?></td>
                            <td><input type="hidden" name="ajk_ipar[]" value="<?=$brs['jk']?>" ><? echo ($brs['jk']=='P')?'Pria':'Wanita';?></td>
                            <td><input type="hidden" name="atgllhr_ipar[]" value="<?=$brs['tgl_lahir']?>" ><?=$brs['tgl_lahir']?></td>
                            <td><input type="hidden" name="akerja_ipar[]" value="<?=$brs['pekerjaan']?>" ><?=$brs['pekerjaan']?></td>
                            <td><input type="hidden" name="aket_ipar[]" value="<?=$brs['keterangan']?>" ><?=$brs['keterangan']?></td>
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="nmipar">Nama</label><input type="text" name="nmipar" id="nmipar" size="30" maxlength="30">
						<label for="jk_ipar">Jenis Kelamin</label>
						<select name="jk_ipar" id="jk_ipar">
							<option value="P">Pria</option>
							<option value="W">Wanita</option>
						</select>
						<label for="tgllahiripar">Tanggal Lahir</label><input type="text" name="tgllahiripar" id="tgllahiripar" size="10" maxlength="20" class="tanggal">
						<label for="kerjaipar">Pekerjaan</label><input type="text" name="kerjaipar" id="kerjaipar" size="20" maxlength="30">
						<label for="ket_ipar">Keterangan</label><input type="text" name="ket_ipar" id="ket_ipar" size="20" maxlength="30">
						<input type="button" value="Tambahkan" id="tambahipar" class="tombol">
					</fieldset>
                    </fieldset>
					<br>
					<fieldset>
					<legend>Keterangan Organisasi</legend>
					<fieldset>
						<legend>Organisasi saat SMA atau sebelumnya</legend>
						<table id="daftarorg_sma">
							<thead>
								<tr><th>Nama Organisasi</th><th>Kedudukan</th><th>Tahun<br/>Mulai</th><th>Tahun<br/>Selesai</th><th>Tempat</th><th>Pimpinan Organisasi</th><th>&nbsp;</th></tr>
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
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="nmorg_sma">Nama</label><input type="text" name="nmorg_sma" id="nmorg_sma" size="30" maxlength="30">
						<label for="kedudukansma">Kedudukan</label><input type="text" name="kedudukansma" id="kedudukansma" size="25" maxlength="30">
						<label for="thnmulaiorg_sma">Tahun Mulai</label><input type="text" name="thnmulaiorg_sma" id="thnmulaiorg_sma" size="5" maxlength="4">
						<label for="thnselesaiorg_sma">Tahun Selesai</label><input type="text" name="thnmselesaiorg_sma" id="thnselesaiorg_sma" size="5" maxlength="4">
						<label for="tmp_org_sma">Tempat</label><input type="text" name="tmp_org_sma" id="tmp_org_sma" size="25" maxlength="30">
						<label for="pimpinan_org_sma">Pimpinan Organisasi</label><input type="text" name="pimpinan_org_sma" id="pimpinan_org_sma" size="25" maxlength="30">
						<input type="button" value="Tambahkan" id="tambahorg_sma" class="tombol">
					</fieldset>
					<br>
					<fieldset>
						<legend>Organisasi saat Perguruan Tinggi</legend>
						<table id="daftarorg_pt">
							<thead>
								<tr><th>Nama Organisasi</th><th>Kedudukan</th><th>Tahun<br/>Mulai</th><th>Tahun<br/>Selesai</th><th>Tempat</th><th>Pimpinan Organisasi</th><th>&nbsp;</th></tr>
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
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="nmorg_pt">Nama</label><input type="text" name="nmorg_pt" id="nmorg_pt" size="30" maxlength="30">
						<label for="kedudukanpt">Kedudukan</label><input type="text" name="kedudukanpt" id="kedudukanpt" size="25" maxlength="30">
						<label for="thnmulaiorg_pt">Tahun Mulai</label><input type="text" name="thnmulaiorg_pt" id="thnmulaiorg_pt" size="5" maxlength="4">
						<label for="thnselesaiorg_pt">Tahun Selesai</label><input type="text" name="thnmselesaiorg_pt" id="thnselesaiorg_pt" size="5" maxlength="4">
						<label for="tmp_org_pt">Tempat</label><input type="text" name="tmp_org_pt" id="tmp_org_pt" size="25" maxlength="30">
						<label for="pimpinan_org_pt">Pimpinan Organisasi</label><input type="text" name="pimpinan_org_pt" id="pimpinan_org_pt" size="25" maxlength="30">
						<input type="button" value="Tambahkan" id="tambahorg_pt" class="tombol">
					</fieldset>
					<br>
					<fieldset>
						<legend>Organisasi Selesai Pendidikan</legend>
						<table id="daftarorg_kerja">
							<thead>
								<tr><th>Nama Organisasi</th><th>Kedudukan</th><th>Tahun<br/>Mulai</th><th>Tahun<br/>Selesai</th><th>Tempat</th><th>Pimpinan Organisasi</th><th>&nbsp;</th></tr>
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
                            <td><a href="#">Delete</a></td>
                            </tr>
							<?endforeach;?>
							</tbody>
						</table>
						<label for="nmorg_kerja">Nama</label><input type="text" name="nmorg_kerja" id="nmorg_kerja" size="30" maxlength="30">
						<label for="kedudukankerja">Kedudukan</label><input type="text" name="kedudukankerja" id="kedudukankerja" size="25" maxlength="30">
						<label for="thnmulaiorg_kerja">Tahun Mulai</label><input type="text" name="thnmulaiorg_kerja" id="thnmulaiorg_kerja" size="5" maxlength="4">
						<label for="thnselesaiorg_kerja">Tahun Selesai</label><input type="text" name="thnmselesaiorg_kerja" id="thnselesaiorg_kerja" size="5" maxlength="4">
						<label for="tmp_org_kerja">Tempat</label><input type="text" name="tmp_org_kerja" id="tmp_org_kerja" size="25" maxlength="30">
						<label for="pimpinan_org_kerja">Pimpinan Organisasi</label><input type="text" name="pimpinan_org_kerja" id="pimpinan_org_kerja" size="25" maxlength="30">
						<input type="button" value="Tambahkan" id="tambahorg_kerja" class="tombol">
					</fieldset>
					</fieldset>
					<br>
					<fieldset>
					<legend>Keterangan</legend>
					<fieldset>
					<legend>Keterangan Berkelakuan Baik</legend>
						<label for="skkb_pejabat">Pejabat</label>
						<input type="text" value="<?=$dp['pejabat_skkb']?>" name="skkb_pejabat" id="skkb_pejabat" size="20" maxlength="40">
						<label for="skkb_nomor">Nomor</label>
						<input type="text" value="<?=$dp['no_skkb']?>" name="skkb_nomor" id="skkb_nomor" size="20" maxlength="30">
						<label for="skkb_tgl">Tanggal</label>
						<input type="text" value="<?=$dp['tgl_skkb']?>" name="skkb_tgl" id="skkb_tgl" size="10" maxlength="15" class="tanggal">
					</fieldset>
					<br>
					<fieldset>
					<legend>Keterangan Berbadan Sehat</legend>
						<label for="sk_sehat_pejabat">Pejabat</label>
						<input type="text" value="<?=$dp['pejabat_ketsehat']?>" name="sk_sehat_pejabat" id="sk_sehat_pejabat" size="20" maxlength="40">
						<label for="sk_sehat_nomor">Nomor</label>
						<input type="text" value="<?=$dp['no_ketsehat']?>" name="sk_sehat_nomor" id="sk_sehat_nomor" size="20" maxlength="30">
						<label for="sk_sehat_tgl">Tanggal</label>
						<input type="text" value="<?=$dp['tgl_ketsehat']?>" name="sk_sehat_tgl" id="sk_sehat_tgl" size="10" maxlength="15" class="tanggal" />
					</fieldset>
					<br>
					<legend>Keterangan Tambahan</legend>
						<label for="ket_tambah"></label>
						<input type="text" value="<?=$dp['keterangan']?>" name="ket_tambah" id="ket_tambah" size="35" maxlength="60">
					</fieldset>
					<br>
                    <input type="submit" class="tombol" name="kirim" value="Proses" />
                    <input type="reset" class="tombol" name="hapus" value="Hapus" />
                </form>
                <?php else:?>
                <h3>Kesalahan</h3>
                <p>Data Pegawai dengan nip <?php echo $snip;?> tidak ditemukan</p>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <div id="footer"> 2010 &copy; Dinas Perhubungan Jawa Barat </div>
    </div>
    <div id="dialog-confirm" title="Edit Pegawai"> 
	    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Apakah anda yakin data yang dimasukkan sudah benar ?</p> 
    </div>
    <div id="dialog-form" title="Tambah Jabatan baru">
        <p class="validateTips">Isikan nama jabatan.</p>
        <form id="formtambahjabatan">
        <fieldset>
            <label for="tjabatan">Jabatan</label>
            <input type="text" name="tjabatan" id="tjabatan" size="40" maxlength="80" />
        </fieldset>
        </form>
    </div>
    <div id="dialog-form-diklat" title="Tambah Diklat baru">
        <p class="validateTips">Isikan nama diklat.</p>
        <form id="formtambahdiklat">
        <fieldset>
            <label for="tdiklat">Diklat</label>
            <input type="text" name="tdiklat" id="tdiklat" size="40" maxlength="100" />
        </fieldset>
        </form>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.ui.datepicker-id.js"></script>
<script type="text/javascript" src="../js/jquery.bgiframe-2.1.1.js"></script>
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function() {
        var pnlPesan=$('#pnlpesan'),ttpPesan=$('#pnlpesan a.close'),isiPesan=$('#isipesan'),formSelectPegawai=$('#formselectpegawai'),
        unitKerja=$('#unitkerja'),seksi=$('#seksi'),jabatan=$('#jabatan'),opsiDiklat=$('#opsidiklat'),nmDiklat=$('#nmdiklat'),
        btnTambahHobi=$('#tambahhobi'),btnTambahSekolah=$('#tambahsekolah'),btnTambahPelatihan=$('#tambahpelatihan'),
        btnTambahDiklat=$('#tambahdiklat'),btnTambahKepangkatan=$('#tambahkepangkatan'),btnTambahPekerjaan=$('#tambahpekerjaan'),
        btnTambahPenghargaan=$('#tambahpenghargaan'),btnTambahKunjungan=$('#tambahkunjungan'),btnTambahSeminar=$('#tambahseminar'),
        btnTambahPasangan=$('#tambahpasangan'),btnTambahAnak=$('#tambahanak'),btnTambahOrtu=$('#tambahortu'),btnTambahMertua=$('#tambahmertua'),
        btnTambahSaudara=$('#tambahsaudara'),btnTambahIpar=$('#tambahipar'),btnTambahOrgSMA=$('#tambahorg_sma'),btnTambahOrgPT=$('#tambahorg_pt'),
        btnTambahOrgKerja=$('#tambahorg_kerja'),formEditPegawai=$('#formeditpegawai'),
        editHobi=$('#edithobi'),editPendidikan=$('#editpendidikan'),editPelatihan=$('#editpelatihan'),editDiklat=$('#editdiklat'),
        editKepangkatan=$('#editkepangkatan'),editPengalaman=$('#editpengalaman'),editPenghargaan=$('#editpenghargaan'),
        editKunjungan=$('#editkunjungan'),editSeminar=$('#editseminar'),editPasangan=$('#editpasangan'),editAnak=$('#editanak'),
        editOrtu=$('#editortu'),editMertua=$('#editmertua'),editSaudara=$('#editsaudara'),editIpar=$('#editipar'),editOrgsma=$('#editorgsma'),
        editOrgpt=$('#editorgpt'),editOrgkerja=$('#editorgkerja'),tjabatan=$('#tjabatan'),tips = $(".validateTips"),tdiklat=$('#tdiklat');
        
		function updateTips(t) {
			tips
				.text(t)
				.addClass('ui-state-highlight');
			setTimeout(function() {
				tips.removeClass('ui-state-highlight', 1500);
			}, 500);
		}
        function checkLength(o,n,min,max) {
			if ( o.val().length > max || o.val().length < min ) {
				o.addClass('ui-state-error');
				updateTips("Panjang " + n + " harus diantara "+min+" dan "+max+".");
				return false;
			} else {
				return true;
			}
		}
		$('#tambahjabatan').click(function(){
		    $("#dialog-form").dialog('open');
		    return false;
		});
		$('#tambahdiklatbaru').click(function(){
		    $("#dialog-form-diklat").dialog('open');
		    return false;
		});
		$("#dialog-form-diklat").dialog({
			autoOpen: false,
			height: 270,
			width: 450,
			modal: true,
			buttons: {
				'Tambah Diklat': function() {
					var bValid = true;
					tdiklat.removeClass('ui-state-error');
					bValid = bValid && checkLength(tdiklat,"Diklat",4,100);
					if (bValid) {
						$.ajax({
						    url:'../lib/ajax.php',
                            type:'POST',
                            timeout:10000,
                            dataType: 'json',
                            data:'op=inputdiklat&tjenis='+opsiDiklat.val()+'&tnama='+tdiklat.val(),
                            success:function(data){
                                if(data.berhasil){
                                    updatePesan(data.pesan);
                                    opsiDiklat.trigger('change');
                                    tdiklat.val('').removeClass('ui-state-error');
                                }else{
                                    updatePesan(data.pesan);
                                }
                            },
                            error:function(e){                    
                                updatePesan('Terjadi kesalahan koneksi');
                            }
						});
						$(this).dialog('close');
					}
				},
				Batal: function() {
					$(this).dialog('close');
				}
			}
			//close: function() {
				//nothing
			//}
		});
        $("#dialog-form").dialog({
			autoOpen: false,
			height: 270,
			width: 450,
			modal: true,
			buttons: {
				'Tambah Jabatan': function() {
					var bValid = true;
					tjabatan.removeClass('ui-state-error');
					bValid = bValid && checkLength(tjabatan,"Jabatan",4,80);
					if (bValid) {
						$.ajax({
						    url:'../lib/ajax.php',
                            type:'POST',
                            timeout:10000,
                            dataType: 'json',
                            data:'op=inputjabatan&teselon=&tseksi='+seksi.val()+'&tjabatan='+tjabatan.val()+'&unitkerja='+unitKerja.val(),
                            success:function(data){
                                if(data.berhasil){
                                    updatePesan(data.pesan);
                                    seksi.trigger('change');
                                    tjabatan.val('').removeClass('ui-state-error');
                                }else{
                                    updatePesan(data.pesan);
                                }
                            },
                            error:function(e){                    
                                updatePesan('Terjadi kesalahan koneksi');
                            }
						});
						$(this).dialog('close');
					}
				},
				Batal: function() {
					$(this).dialog('close');
				}
			}
			//close: function() {
				//nothing
			//}
		});
        function stripTabel(){
            $('table').each(function(){
                $(this).find('tbody').children().filter(':odd').css('background-color','#b6d7e7').parent().filter(':even').css('background-color','#f1f7f9');
            });
        }
        $('table').click(function(e){
            var trg=$(e.target);
            if(trg.attr('href')){
                if(trg.html()=='Delete'){
                    switch($(this).attr('id')){
                        case "daftarhobi":
                            editHobi.val('y');
                            break;
                        case 'daftarpendidikan':
                            editPendidikan.val('y');
                            break;
                        case 'daftarpelatihan':
                            editPelatihan.val('y');
                            break;
                        case 'daftardiklat':
                            editDiklat.val('y');
                            break;
                        case 'daftarkepangkatan':
                            editKepangkatan.val('y');
                            break;
                        case 'daftarpengalaman':
                            editPengalaman.val('y');
                            break;
                        case 'daftarpenghargaan':
                            editPenghargaan.val('y');
                            break;
                        case 'daftarkunjungan':
                            editKunjungan.val('y');
                            break;
                        case 'daftarseminar':
                            editSeminar.val('y');
                            break;
                        case 'daftarpasangan':
                            editPasangan.val('y');
                            break;
                        case 'daftaranak':
                            editAnak.val('y');
                            break;
                        case 'daftarortu':
                            editOrtu.val('y');
                            break;
                        case 'daftarmertua':
                            editMertua.val('y');
                            break;
                        case 'daftarsaudara':
                            editSaudara.val('y');
                            break;
                        case 'daftaripar':
                            editIpar.val('y');
                            break;
                        case 'daftarorg_sma':
                            editOrgsma.val('y');
                            break;
                        case 'daftarorg_pt':
                            editOrgpt.val('y');
                            break;
                        case 'daftarorg_kerja':
                            editOrgkerja.val('y');
                            break;
                    }
                    trg.parents('tr').remove();
                    stripTabel();
                }
            }
            return false;
        });
        
        var hobi=$('#hobi');
        
        btnTambahHobi.click(function(){
            if(hobi.val().trim().length<3||!/^[a-zA-Z ]+$/.test(hobi.val().trim())){
                updatePesan('Hobi harus lebih dari dua karakter hanya berisi alfabet dan spasi');
                hobi.focus();
                return false;
            }
			$('#daftarhobi > tbody').append('<tr><td><input type="hidden" name="ahobi[]" value="'+hobi.val().trim()+'" >'+hobi.val().trim()+'</td><td><a href="#">Delete</a></td></tr>');
			stripTabel();
			hobi.val('');
			editHobi.val('y');
        });
        
        var opsiTingkat=$('#opsitingkat'),
            nmPendidikan=$('#nmpendidikan'),
            jurusan=$('#jurusan'),
            noIjazah=$('#noijazah'),
            thnPendidikan=$('#thnpendidikan'),
            tmpPendidikan=$('#tmppendidikan'),
            kepSek=$('#kepsek')

        btnTambahSekolah.click(function(){
            if(nmPendidikan.val().trim().length<5||!/^[\w\'\., ]+$/.test(nmPendidikan.val())){
                updatePesan('Nama pendidikan harus lebih dari 4 karakter dan hanya berisi alfabet, spasi dan bilangan');
                nmPendidikan.focus();
                return false;
            }
            if(noIjazah.val().trim().length<6||!/^[\w._/\- ]+$/.test(noIjazah.val())){
                updatePesan("No Ijazah harus lebih dari 5 karakter");
                noIjazah.focus();
                return false;
            }
            if(!/^\d{4}$/.test(thnPendidikan.val())){
                updatePesan('Tahun kelulusan terdiri dari 4 digit');
                thnPendidikan.focus();
                return false;
            }
            if(tmpPendidikan.val().trim().length<4||!/^[\w\'\., ]+$/.test(tmpPendidikan.val())){
                updatePesan('Tempat pendidikan harus lebih dari 4 karakter dan hanya berisi alfabet, spasi dan bilangan')
                tmpPendidikan.focus();
                return false;
            }
            if(kepSek.val().trim().length<4||!/^[\w\'\., ]+$/.test(kepSek.val())){
                updatePesan('Nama Kepala Sekolah/Dekan harus lebih dari 4 karakter dan hanya berisi alfabet, spasi dan bilangan')
                kepSek.focus();
                return false;
            }
            $('#daftarpendidikan > tbody').append('<tr>'+
                '<td><input type="hidden" name="atingkat_pndd[]" value="'+opsiTingkat.val()+'" >'+opsiTingkat.val()+'</td>'+
                '<td><input type="hidden" name="anm_pndd[]" value="'+nmPendidikan.val()+'" >'+nmPendidikan.val()+'</td>'+
                '<td><input type="hidden" name="ajurusan_pndd[]" value="'+jurusan.val()+'" >'+jurusan.val()+'</td>'+
                '<td><input type="hidden" name="anoijazah_pndd[]" value="'+noIjazah.val()+'" >'+noIjazah.val()+'</td>'+
                '<td><input type="hidden" name="athn_pndd[]" value="'+thnPendidikan.val()+'" >'+thnPendidikan.val()+'</td>'+
                '<td><input type="hidden" name="atmp_pndd[]" value="'+tmpPendidikan.val()+'" >'+tmpPendidikan.val()+'</td>'+
                '<td><input type="hidden" name="akepsek_pndd[]" value="'+kepSek.val()+'" >'+kepSek.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            stripTabel();
            opsiTingkat.val('SD');
            nmPendidikan.val('');
            jurusan.val('');
            noIjazah.val('');
            thnPendidikan.val('');
            tmpPendidikan.val('');
            kepSek.val('');
            editPendidikan.val('y');
        });
        
        var nmPelatihan=$('#nmpelatihan'),
            tglAwalPelatihan=$('#tgl_awalpelatihan'),
            tglAkhirPelatihan=$('#tgl_akhirpelatihan'),
            noBuktiPelatihan=$('#nobuktipelatihan'),
            tmpPelatihan=$('#tmppelatihan'),
            ketPelatihan=$('#ketpelatihan');
            
        btnTambahPelatihan.click(function(){
            if(nmPelatihan.val().trim().length<4||!/^[\w\'\., ]+$/.test(nmPelatihan.val())){
                updatePesan('Nama Pelatihan harus lebih dari 4 karakter dan hanya berisi alfabet, spasi dan bilangan');
                nmPelatihan.focus();
                return false;
            }
            if(tglAwalPelatihan.val().trim().length<8){
                updatePesan('Isikan tanggal awal pelatihan');
                tglAwalPelatihan.focus();
                return false;
            }
            if(tglAkhirPelatihan.val().trim().length<8){
                updatePesan('Isikan tanggal akhir pelatihan');
                tglAkhirPelatihan.focus();
                return false;
            }
            if(noBuktiPelatihan.val().trim().length<1||!/^[\w._/\- ]+$/.test(noBuktiPelatihan.val())){
                updatePesan('Isikan no bukti pelatihan hanya berisi alfabet, spasi dan bilangan');
                noBuktiPelatihan.focus();
                return false;
            }
            if(tmpPelatihan.val().trim().length<4||!/^[\w\'\., ]+$/.test(tmpPelatihan.val())){
                updatePesan('Tempat pelatihan harus lebih dari 4 karakter dan hanya berisi alfabet, spasi dan bilangan');
                tmpPelatihan.focus();
                return false;
            }
            $('#daftarpelatihan > tbody').append('<tr>'+
                '<td><input type="hidden" name="anm_plthn[]" value="'+nmPelatihan.val()+'" >'+nmPelatihan.val()+'</td>'+
                '<td><input type="hidden" name="atglawal_plthn[]" value="'+tglAwalPelatihan.val()+'" >'+tglAwalPelatihan.val()+'</td>'+
                '<td><input type="hidden" name="atglakhir_plthn[]" value="'+tglAkhirPelatihan.val()+'" >'+tglAkhirPelatihan.val()+'</td>'+
                '<td><input type="hidden" name="anobukti_plthn[]" value="'+noBuktiPelatihan.val()+'" >'+noBuktiPelatihan.val()+'</td>'+
                '<td><input type="hidden" name="atmp_plthn[]" value="'+tmpPelatihan.val()+'" >'+tmpPelatihan.val()+'</td>'+
                '<td><input type="hidden" name="aket_plthn[]" value="'+ketPelatihan.val()+'" >'+ketPelatihan.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            nmPelatihan.val('');
            tglAwalPelatihan.val('');
            tglAkhirPelatihan.val('');
            noBuktiPelatihan.val('');
            tmpPelatihan.val('');
            ketPelatihan.val('');
            stripTabel();
            editPelatihan.val('y');
        });
        
        //opsiDiklat dan nmDiklat sudah di deklarasikan
        var tglAwalDiklat=$('#tgl_awaldiklat'),
            tglAkhirDiklat=$('#tgl_akhirdiklat'),
            noBuktiDiklat=$('#nobuktidiklat'),
            tmpDiklat=$('#tmpdiklat'),
            lamaDiklat=$('#lamadiklat'),
            ketDiklat=$('#ketdiklat');

        btnTambahDiklat.click(function(){
            if(tglAwalDiklat.val().trim().length<8){
                updatePesan('Isikan tanggal awal diklat');
                tglAwalDiklat.focus();
                return false;
            }
            if(tglAkhirDiklat.val().trim().length<8){
                updatePesan('Isikan tanggal akhir diklat');
                tglAkhirDiklat.focus();
                return false;
            }
            if(noBuktiDiklat.val().trim().length<1||!/^[\w._/\- ]+$/.test(noBuktiDiklat.val())){
                updatePesan('Isikan no bukti diklat, hanya berisi alfabet, spasi dan bilangan');
                noBuktiDiklat.focus();
                return false;
            }
            if(tmpDiklat.val().trim().length<3||!/^[\w\'\., ]+$/.test(tmpDiklat.val())){
                updatePesan('Tempat diklat harus lebih dari 3 karakter dan hanya berisi alfabet, spasi dan bilangan');
                tmpDiklat.focus();
                return false;
            }
            if(!/^\d+$/.test(lamaDiklat.val())){
                updatePesan('Lama diklat hanya berupa bilangan (dalam jam)');
                lamaDiklat.focus();
                return false;
            }
            $('#daftardiklat > tbody').append('<tr>'+
                '<td><input type="hidden" name="ajns_diklat[]" value="'+opsiDiklat.val()+'" >'+opsiDiklat.val()+'</td>'+
                '<td><input type="hidden" name="anm_diklat[]" value="'+nmDiklat.val()+'" >'+nmDiklat.children().filter(':selected').html()+'</td>'+
                '<td><input type="hidden" name="atglawal_diklat[]" value="'+tglAwalDiklat.val()+'" >'+tglAwalDiklat.val()+'</td>'+
                '<td><input type="hidden" name="atglakhir_diklat[]" value="'+tglAkhirDiklat.val()+'" >'+tglAkhirDiklat.val()+'</td>'+
                '<td><input type="hidden" name="anobukti_diklat[]" value="'+noBuktiDiklat.val()+'" >'+noBuktiDiklat.val()+'</td>'+
                '<td><input type="hidden" name="atmp_diklat[]" value="'+tmpDiklat.val()+'" >'+tmpDiklat.val()+'</td>'+
                '<td><input type="hidden" name="alama_diklat[]" value="'+lamaDiklat.val()+'" >'+lamaDiklat.val()+'</td>'+
                '<td><input type="hidden" name="aket_diklat[]" value="'+ketDiklat.val()+'" >'+ketDiklat.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            tglAwalDiklat.val('');
            tglAkhirDiklat.val('');
            noBuktiDiklat.val('');
            tmpDiklat.val('');
            lamaDiklat.val('');
            ketDiklat.val('');
            stripTabel();
            editDiklat.val('y');
        });
        
        var pangkat=$('#pangkat'),
            pangkatGol=$('#pangkat_gol'),
            tglBerlaku=$('#tgl_berlaku'),
            pangkatSKPejabat=$('#pangkat_sk_pejabat'),
            pangkatSKNomor=$('#pangkat_sk_nomor'),
            pangkatSKTgl=$('#pangkat_sk_tgl'),
            dasarPeraturan=$('#dasarperaturan');
        
        btnTambahKepangkatan.click(function(){
            if(tglBerlaku.val().trim().length<8){
                updatePesan('Isikan tanggal mulai terhitung');
                tglBerlaku.focus();
                return false;
            }
            if(pangkatSKPejabat.val().trim().length<2||!/^[\w\'\., ]+$/.test(pangkatSKPejabat.val())){
                updatePesan('Isikan nama pejabat');
                pangkatSKPejabat.focus();
                return false;
            }
            if(pangkatSKNomor.val().trim().length<1||!/^[\w._/\- ]+$/.test(pangkatSKNomor.val())){
                updatePesan('Isikan Nomor Surat Keputusan');
                pangkatSKNomor.focus();
                return false;
            }
            if(pangkatSKTgl.val().trim().length<5){
                updatePesan('Isikan Tanggal Surat Keputusan');
                pangkatSKTgl.focus();
                return false;
            }
            $('#daftarkepangkatan > tbody').append('<tr>'+
                '<td><input type="hidden" name="anm_pangkat[]" value="'+pangkat.val()+'" >'+pangkat.val()+'</td>'+
                '<td><input type="hidden" name="agolongan_pangkat[]" value="'+pangkatGol.val()+'" >'+pangkatGol.children().filter(':selected').html()+'</td>'+
                '<td><input type="hidden" name="atmt_pangkat[]" value="'+tglBerlaku.val()+'" >'+tglBerlaku.val()+'</td>'+
                '<td><input type="hidden" name="ask_pejabat_pangkat[]" value="'+pangkatSKPejabat.val()+'" >'+pangkatSKPejabat.val()+'</td>'+
                '<td><input type="hidden" name="ask_nomor_pangkat[]" value="'+pangkatSKNomor.val()+'" >'+pangkatSKNomor.val()+'</td>'+
                '<td><input type="hidden" name="ask_tgl_pangkat[]" value="'+pangkatSKTgl.val()+'" >'+pangkatSKTgl.val()+'</td>'+
                '<td><input type="hidden" name="adasar_pangkat[]" value="'+dasarPeraturan.val()+'" >'+dasarPeraturan.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            tglBerlaku.val('');
            pangkatSKPejabat.val('');
            pangkatSKNomor.val('');
            pangkatSKTgl.val('');
            dasarPeraturan.val('');
            stripTabel();
            editKepangkatan.val('y');
        });
        
        var pengalaman = $('#pengalaman'),
            tglMulaiPengalaman = $('#tgl_mulaipengalaman'),
            tglSelesaiPengalaman = $('#tgl_selesaipengalaman'),
            pengalamanGol = $('#pengalaman_gol'),
            pengalamanSKPejabat = $('#pengalaman_sk_pejabat'),
            pengalamanSKNomor = $('#pengalaman_sk_nomor'),
            pengalamanSKTgl = $('#pengalaman_sk_tgl');
            
        btnTambahPekerjaan.click(function(){
            if(pengalaman.val().trim()<4||!/^[\w ]+$/.test(pengalaman.val())){
                updatePesan('Pengalaman berkerja harus lebih dari 4 karakter dan hanya berisi alfabet, spasi dan bilangan');
                pengalaman.focus();
                return false;
            }
            if(tglMulaiPengalaman.val().trim().length<8){
                updatePesan('Isikan tanggal mulai jabatan/pekerjaan');
                tglMulaiPengalaman.focus();
                return false;
            }
            if(tglSelesaiPengalaman.val().trim().length<8){
                updatePesan('Isikan tanggal selesai jabatan/pekerjaan');
                tglSelesaiPengalaman.focus();
                return false;
            }
            if(pengalamanSKPejabat.val().trim().length<3||!/^[\w\'\.,\- ]+$/.test(pengalamanSKPejabat.val())){
                updatePesan('Isikan nama pejabat');
                pengalamanSKPejabat.focus();
                return false;
            }
            if(pengalamanSKNomor.val().trim().length<1||!/^[\w._/\-]+$/.test(pengalamanSKNomor.val())){
                updatePesan('Isikan Nomor Surat Keputusan');
                pengalamanSKNomor.focus();
                return false;
            }
            if(pengalamanSKTgl.val().trim().length<5){
                updatePesan('Isikan Tanggal Surat Keputusan');
                pengalamanSKTgl.focus();
                return false;
            }
            $('#daftarpengalaman > tbody').append('<tr>'+
                '<td><input type="hidden" name="anm_pengalaman[]" value="'+pengalaman.val()+'" >'+pengalaman.val()+'</td>'+
                '<td><input type="hidden" name="atglmulai_pengalaman[]" value="'+tglMulaiPengalaman.val()+'" >'+tglMulaiPengalaman.val()+'</td>'+
                '<td><input type="hidden" name="atglselesai_pengalaman[]" value="'+tglSelesaiPengalaman.val()+'" >'+tglSelesaiPengalaman.val()+'</td>'+
                '<td><input type="hidden" name="agol_pengalaman[]" value="'+pengalamanGol.val()+'" >'+pengalamanGol.children().filter(':selected').html()+'</td>'+
                '<td><input type="hidden" name="ask_pejabat_pengalaman[]" value="'+pengalamanSKPejabat.val()+'" >'+pengalamanSKPejabat.val()+'</td>'+
                '<td><input type="hidden" name="ask_nomor_pengalaman[]" value="'+pengalamanSKNomor.val()+'" >'+pengalamanSKNomor.val()+'</td>'+
                '<td><input type="hidden" name="ask_tgl_pengalaman[]" value="'+pengalamanSKTgl.val()+'" >'+pengalamanSKTgl.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            pengalaman.val('');
            tglMulaiPengalaman.val('');
            tglSelesaiPengalaman.val('');
            pengalamanSKPejabat.val('');
            pengalamanSKNomor.val('');
            pengalamanSKTgl.val('');
            stripTabel();
            editPengalaman.val('y');
        });
        
        var nmPenghargaan = $('#nmpenghargaan'),
            thnPenghargaan = $('#tahunpenghargaan'),
            pihakPemberi = $('#pihakpemberi');
        
        btnTambahPenghargaan.click(function(){
            if(nmPenghargaan.val().trim().length<3||!/^[\w\'\., ]+$/.test(nmPenghargaan.val())){
                updatePesan('Isikan nama penghargaan');
                nmPenghargaan.focus();
                return false;
            }
            if(!/^\d{4}$/.test(thnPenghargaan.val())){
                updatePesan('Tahun penghargaan terdiri dari 4 digit');
                thnPenghargaan.focus();
                return false;
            }
            if(pihakPemberi.val().trim().length<3||!/^[\w\'\., ]+$/.test(pihakPemberi.val())){
                updatePesan('Isikan pihak pemberi penghargaan');
                pihakPemberi.focus();
                return false;
            }
            $('#daftarpenghargaan > tbody').append('<tr>'+
                '<td><input type="hidden" name="anm_penghargaan[]" value="'+nmPenghargaan.val()+'" >'+nmPenghargaan.val()+'</td>'+
                '<td><input type="hidden" name="athn_penghargaan[]" value="'+thnPenghargaan.val()+'" >'+thnPenghargaan.val()+'</td>'+
                '<td><input type="hidden" name="apemberi_penghargaan[]" value="'+pihakPemberi.val()+'" >'+pihakPemberi.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            nmPenghargaan.val('');
            thnPenghargaan.val('');
            pihakPemberi.val('');
            stripTabel();
            editPenghargaan.val('y');
        });
        
        var negara = $('#negara'),
            tujuan = $('#tujuan'),
            tglMulaiKunjungan = $('#tgl_mulaikunjungan'),
            tglSelesaiKunjungan = $('#tgl_selesaikunjungan'),
            pembiaya = $('#pembiaya');
        
        btnTambahKunjungan.click(function(){
            if(negara.val().trim().length<3||!/^[\w\'\., ]+$/.test(negara.val())){
                updatePesan('Isikan negara kunjungan');
                negara.focus();
                return false;
            }
            if(tujuan.val().trim().length<3||!/^[\w\'\., ]+$/.test(negara.val())){
                updatePesan('Isikan tujuan kunjungan');
                tujuan.focus();
                return false;
            }
            if(tglMulaiKunjungan.val().length<8){
                updatePesan('Isikan tanggal mulai kunjungan');
                tglMulaiKunjungan.focus();
                return false;
            }
            if(tglSelesaiKunjungan.val().length<8){
                updatePesan('Isikan tanggal selesai kunjungan');
                tglSelesaiKunjungan.focus();
                return false;
            }
            if(pembiaya.val().trim().length<3||!/^[\w\'\., ]+$/.test(pembiaya.val())){
                updatePesan('Isikan pembiaya kunjungan');
                pembiaya.focus();
                return false;
            }
            $('#daftarkunjungan > tbody').append('<tr>'+
                '<td><input type="hidden" name="anegara_kunjungan[]" value="'+negara.val()+'" >'+negara.val()+'</td>'+
                '<td><input type="hidden" name="atujuan_kunjungan[]" value="'+tujuan.val()+'" >'+tujuan.val()+'</td>'+
                '<td><input type="hidden" name="atglmulai_kunjungan[]" value="'+tglMulaiKunjungan.val()+'" >'+tglMulaiKunjungan.val()+'</td>'+
                '<td><input type="hidden" name="atglselesai_kunjungan[]" value="'+tglSelesaiKunjungan.val()+'" >'+tglSelesaiKunjungan.val()+'</td>'+
                '<td><input type="hidden" name="apembiaya_kunjungan[]" value="'+pembiaya.val()+'" >'+pembiaya.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            negara.val('');
            tujuan.val('');
            tglMulaiKunjungan.val('');
            tglSelesaiKunjungan.val('');
            pembiaya.val('');
            stripTabel();
            editKunjungan.val('y');
        });
        
        var nmSeminar = $('#nmseminar'),
            peranan = $('#peranan'),
            tglPenyelenggaraan = $('#tgl_penyelenggaraan'),
            penyelenggara = $('#penyelenggara'),
            tmpSeminar = $('#tmpseminar');
        
        btnTambahSeminar.click(function(){
            if(nmSeminar.val().trim().length<3||!/^[\w\'\., ]+$/.test(nmSeminar.val())){
                updatePesan('Isikan Seminar / Kegiatan');
                nmSeminar.focus();
                return false;
            }
            if(peranan.val().trim().length<3||!/^[\w\'\., ]+$/.test(peranan.val())){
                updatePesan('Isikan peranan dalam kegiatan');
                peranan.focus();
                return false;
            }
            if(tglPenyelenggaraan.val().length<8){
                updatePesan('Isikan tanggal penyelenggaraan');
                tglPenyelenggaraan.focus();
                return false;
            }
            if(penyelenggara.val().trim().length<3||!/^[\w\'\., ]+$/.test(penyelenggara.val())){
                updatePesan('Isikan penyelenggara seminar/kegiatan');
                penyelenggara.focus();
                return false;
            }
            if(tmpSeminar.val().trim().length<3||!/^[\w\'\., ]+$/.test(tmpSeminar.val())){
                updatePesan('Isikan tempat seminar/kegiatan');
                tmpSeminar.focus();
                return false;
            }
            $('#daftarseminar > tbody').append('<tr>'+
                '<td><input type="hidden" name="anm_seminar[]" value="'+nmSeminar.val()+'" >'+nmSeminar.val()+'</td>'+
                '<td><input type="hidden" name="aperanan_seminar[]" value="'+peranan.val()+'" >'+peranan.val()+'</td>'+
                '<td><input type="hidden" name="atgl_seminar[]" value="'+tglPenyelenggaraan.val()+'" >'+tglPenyelenggaraan.val()+'</td>'+
                '<td><input type="hidden" name="apenyelenggara_seminar[]" value="'+penyelenggara.val()+'" >'+penyelenggara.val()+'</td>'+
                '<td><input type="hidden" name="atmp_seminar[]" value="'+tmpSeminar.val()+'" >'+tmpSeminar.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            nmSeminar.val('');
            peranan.val('');
            tglPenyelenggaraan.val('');
            penyelenggara.val('');
            tmpSeminar.val('');
            editSeminar.val('y');
            stripTabel();
        });
        
        var nmPasangan = $('#nmpasangan'),
            tmpLhrPasangan = $('#tmplahirpasangan'),
            tglLhrPasangan = $('#tgllahirpasangan'),
            tglMenikah = $('#tglmenikah'),
            kerjaPasangan = $('#kerjapasangan'),
            ketPasangan = $('#ket_pasangan');
        
        btnTambahPasangan.click(function(){
            if(nmPasangan.val().trim().length<3||!/^[\w\'\., ]+$/.test(nmPasangan.val())){
                updatePesan('Isikan nama pasangan');
                nmPasangan.focus();
                return false;
            }
            if(tmpLhrPasangan.val().trim().length<3||!/^[\w\'\., ]+$/.test(tmpLhrPasangan.val())){
                updatePesan('Isikan tempat lahir pasangan');
                tmpLhrPasangan.focus();
                return false;
            }
            if(tglLhrPasangan.val().length<8){
                updatePesan('Isikan tanggal lahir pasangan');
                tglLhrPasangan.focus();
                return false;
            }
            if(tglMenikah.val().length<8){
                updatePesan('Isikan tanggal menikah');
                tglMenikah.focus();
                return false;
            }
            if(kerjaPasangan.val().trim().length<3||!/^[\w\'\., ]+$/.test(kerjaPasangan.val())){
                updatePesan('Isikan pekerjaan pasangan');
                kerjaPasangan.focus();
                return false;
            }
            $('#daftarpasangan > tbody').append('<tr>'+
                '<td><input type="hidden" name="anm_pasangan[]" value="'+nmPasangan.val()+'" >'+nmPasangan.val()+'</td>'+
                '<td><input type="hidden" name="atmplhr_pasangan[]" value="'+tmpLhrPasangan.val()+'" >'+tmpLhrPasangan.val()+'</td>'+
                '<td><input type="hidden" name="atgllhr_pasangan[]" value="'+tglLhrPasangan.val()+'" >'+tglLhrPasangan.val()+'</td>'+
                '<td><input type="hidden" name="atglmenikah_pasangan[]" value="'+tglMenikah.val()+'" >'+tglMenikah.val()+'</td>'+
                '<td><input type="hidden" name="akerja_pasangan[]" value="'+kerjaPasangan.val()+'" >'+kerjaPasangan.val()+'</td>'+
                '<td><input type="hidden" name="aket_pasangan[]" value="'+ketPasangan.val()+'" >'+ketPasangan.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            nmPasangan.val('');
            tmpLhrPasangan.val('');
            tglLhrPasangan.val('');
            tglMenikah.val('');
            kerjaPasangan.val('');
            ketPasangan.val('');
            stripTabel();
            editPasangan.val('y');
        });
        
        var nmAnak = $('#nmanak'),
            jkAnak = $('#jk_anak'),
            tmpLhrAnak = $('#tmplahiranak'),
            tglLhrAnak = $('#tgllahiranak'),
            kerjaAnak = $('#kerjaanak'),
            ketAnak = $('#ket_anak');
        
        btnTambahAnak.click(function(){
            if(nmAnak.val().trim().length<3||!/^[\w\'\., ]+$/.test(nmAnak.val())){
                updatePesan('Isikan nama anak');
                nmAnak.focus();
                return false;
            }
            if(tmpLhrAnak.val().trim().length<3||!/^[\w\'\., ]+$/.test(tmpLhrAnak.val())){
                updatePesan('Isikan tempat lahir anak');
                tmpLhrAnak.focus();
                return false;
            }
            if(tglLhrAnak.val().length<8){
                updatePesan('Isikan tanggal lahir anak');
                tglLhrAnak.focus();
                return false;
            }
            if(kerjaAnak.val().trim().length<3||!/^[\w\'\., ]+$/.test(kerjaAnak.val())){
                updatePesan('Isikan pekerjaan anak');
                kerjaAnak.focus();
                return false;
            }
            $('#daftaranak > tbody').append('<tr>'+
                '<td><input type="hidden" name="anm_anak[]" value="'+nmAnak.val()+'" >'+nmAnak.val()+'</td>'+
                '<td><input type="hidden" name="ajk_anak[]" value="'+jkAnak.val()+'" >'+jkAnak.children().filter(':selected').html()+'</td>'+
                '<td><input type="hidden" name="atmplhr_anak[]" value="'+tmpLhrAnak.val()+'" >'+tmpLhrAnak.val()+'</td>'+
                '<td><input type="hidden" name="atgllhr_anak[]" value="'+tglLhrAnak.val()+'" >'+tglLhrAnak.val()+'</td>'+
                '<td><input type="hidden" name="akerja_anak[]" value="'+kerjaAnak.val()+'" >'+kerjaAnak.val()+'</td>'+
                '<td><input type="hidden" name="aket_anak[]" value="'+ketAnak.val()+'" >'+ketAnak.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            nmAnak.val('');
            tmpLhrAnak.val('');
            tglLhrAnak.val('');
            kerjaAnak.val('');
            ketAnak.val('');
            stripTabel();
            editAnak.val('y');
        });
        
        var nmOrtu = $('#nmortu'),
            jkOrtu = $('#jk_ortu'),
            tglLhrOrtu = $('#tgllahirortu'),
            kerjaOrtu = $('#kerjaortu'),
            ketOrtu = $('#ket_ortu');
        
        btnTambahOrtu.click(function(){
            if(nmOrtu.val().trim().length<3||!/^[\w\'\., ]+$/.test(nmOrtu.val())){
                updatePesan('Isikan nama orang tua');
                nmOrtu.focus();
                return false;
            }
            if(tglLhrOrtu.val().length<8){
                updatePesan('Isikan tanggal lahir orang tua');
                tglLhrOrtu.focus();
                return false;
            }
            if(kerjaOrtu.val().trim().length<3||!/^[\w\'\., ]+$/.test(kerjaOrtu.val())){
                updatePesan('Isikan pekerjaan orang tua');
                kerjaOrtu.focus();
                return false;
            }
            $('#daftarortu > tbody').append('<tr>'+
                '<td><input type="hidden" name="anm_ortu[]" value="'+nmOrtu.val()+'" >'+nmOrtu.val()+'</td>'+
                '<td><input type="hidden" name="ajk_ortu[]" value="'+jkOrtu.val()+'" >'+jkOrtu.children().filter(':selected').html()+'</td>'+
                '<td><input type="hidden" name="atgllhr_ortu[]" value="'+tglLhrOrtu.val()+'" >'+tglLhrOrtu.val()+'</td>'+
                '<td><input type="hidden" name="akerja_ortu[]" value="'+kerjaOrtu.val()+'" >'+kerjaOrtu.val()+'</td>'+
                '<td><input type="hidden" name="aket_ortu[]" value="'+ketOrtu.val()+'" >'+ketOrtu.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            nmOrtu.val('');
            tglLhrOrtu.val('');
            kerjaOrtu.val('');
            ketOrtu.val('');
            stripTabel();
            editOrtu.val('y');
        });
        
        var nmMertua = $('#nmmertua'),
            jkMertua = $('#jk_mertua'),
            tglLhrMertua = $('#tgllahirmertua'),
            kerjaMertua = $('#kerjamertua'),
            ketMertua = $('#ket_mertua');
        
        btnTambahMertua.click(function(){
            if(nmMertua.val().trim().length<3||!/^[\w\'\., ]+$/.test(nmMertua.val())){
                updatePesan('Isikan nama mertua');
                nmMertua.focus();
                return false;
            }
            if(tglLhrMertua.val().length<8){
                updatePesan('Isikan tanggal lahir mertua');
                tglLhrMertua.focus();
                return false;
            }
            if(kerjaMertua.val().trim().length<3||!/^[\w\'\., ]+$/.test(kerjaMertua.val())){
                updatePesan('Isikan pekerjaan mertua');
                kerjaMertua.focus();
                return false;
            }
            $('#daftarmertua > tbody').append('<tr>'+
                '<td><input type="hidden" name="anm_mertua[]" value="'+nmMertua.val()+'" >'+nmMertua.val()+'</td>'+
                '<td><input type="hidden" name="ajk_mertua[]" value="'+jkMertua.val()+'" >'+jkMertua.children().filter(':selected').html()+'</td>'+
                '<td><input type="hidden" name="atgllhr_mertua[]" value="'+tglLhrMertua.val()+'" >'+tglLhrMertua.val()+'</td>'+
                '<td><input type="hidden" name="akerja_mertua[]" value="'+kerjaMertua.val()+'" >'+kerjaMertua.val()+'</td>'+
                '<td><input type="hidden" name="aket_mertua[]" value="'+ketMertua.val()+'" >'+ketMertua.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            nmMertua.val('');
            tglLhrMertua.val('');
            kerjaMertua.val('');
            ketMertua.val('');
            stripTabel();
            editMertua.val('y');
        });
        
        var nmSaudara = $('#nmsaudara'),
            jkSaudara = $('#jk_saudara'),
            tglLhrSaudara = $("#tgllahirsaudara"),
            kerjaSaudara = $('#kerjasaudara'),
            ketSaudara = $('#ket_saudara');
        
        btnTambahSaudara.click(function(){
            if(nmSaudara.val().trim().length<3||!/^[\w\'\., ]+$/.test(nmSaudara.val())){
                updatePesan('Isikan nama saudara kandung');
                nmSaudara.focus();
                return false;
            }
            if(tglLhrSaudara.val().length<8){
                updatePesan('Isikan tanggal lahir saudara kandung');
                tglLhrSaudara.focus();
                return false;
            }
            if(kerjaSaudara.val().trim().length<3||!/^[\w\'\., ]+$/.test(kerjaSaudara.val())){
                updatePesan('Isikan pekerjaan saudara kandung');
                kerjaSaudara.focus();
                return false;
            }
            $('#daftarsaudara > tbody').append('<tr>'+
                '<td><input type="hidden" name="anm_saudara[]" value="'+nmSaudara.val()+'" >'+nmSaudara.val()+'</td>'+
                '<td><input type="hidden" name="ajk_saudara[]" value="'+jkSaudara.val()+'" >'+jkSaudara.children().filter(':selected').html()+'</td>'+
                '<td><input type="hidden" name="atgllhr_saudara[]" value="'+tglLhrSaudara.val()+'" >'+tglLhrSaudara.val()+'</td>'+
                '<td><input type="hidden" name="akerja_saudara[]" value="'+kerjaSaudara.val()+'" >'+kerjaSaudara.val()+'</td>'+
                '<td><input type="hidden" name="aket_saudara[]" value="'+ketSaudara.val()+'" >'+ketSaudara.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            nmSaudara.val('');
            tglLhrSaudara.val('');
            kerjaSaudara.val('');
            ketSaudara.val('');
            stripTabel();
            editSaudara.val('y');
        });
        
        var nmIpar = $('#nmipar'),
            jkIpar = $('#jk_ipar'),
            tglLhrIpar = $('#tgllahiripar'),
            kerjaIpar = $('#kerjaipar'),
            ketIpar = $('#ket_ipar');
        
        btnTambahIpar.click(function(){
            if(nmIpar.val().trim().length<3||!/^[\w\'\., ]+$/.test(nmIpar.val())){
                updatePesan('Isikan nama saudara kandung pasangan hidup');
                nmIpar.focus();
                return false;
            }
            if(tglLhrIpar.val().length<8){
                updatePesan('Isikan tanggal lahir saudara kandung pasangan hidup');
                tglLhrIpar.focus();
                return false;
            }
            if(kerjaIpar.val().trim().length<3||!/^[\w\'\., ]+$/.test(kerjaIpar.val())){
                updatePesan('Isikan pekerjaan saudara kandung pasangan hidup');
                kerjaIpar.focus();
                return false;
            }
            $('#daftaripar > tbody').append('<tr>'+
                '<td><input type="hidden" name="anm_ipar[]" value="'+nmIpar.val()+'" >'+nmIpar.val()+'</td>'+
                '<td><input type="hidden" name="ajk_ipar[]" value="'+jkIpar.val()+'" >'+jkIpar.children().filter(':selected').html()+'</td>'+
                '<td><input type="hidden" name="atgllhr_ipar[]" value="'+tglLhrIpar.val()+'" >'+tglLhrIpar.val()+'</td>'+
                '<td><input type="hidden" name="akerja_ipar[]" value="'+kerjaIpar.val()+'" >'+kerjaIpar.val()+'</td>'+
                '<td><input type="hidden" name="aket_ipar[]" value="'+ketIpar.val()+'" >'+ketIpar.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            nmIpar.val('');
            tglLhrIpar.val('');
            kerjaIpar.val('');
            ketIpar.val('');
            stripTabel();
            editIpar.val('y');
        });
        
        var nmOrgSMA = $('#nmorg_sma'),
            kedudukanSMA = $('#kedudukansma'),
            thnMulaiOrgSMA = $('#thnmulaiorg_sma'),
            thnSelesaiOrgSMA = $('#thnselesaiorg_sma'),
            tmpOrgSMA = $('#tmp_org_sma'),
            pimpinanOrgSMA = $('#pimpinan_org_sma');
        
        btnTambahOrgSMA.click(function(){
            if(nmOrgSMA.val().trim().length<4||!/^[\w\'\., ]+$/.test(nmOrgSMA.val())){
                updatePesan('Isikan nama organisasi, min 4 karakter');
                nmOrgSMA.focus();
                return false;
            }
            if(kedudukanSMA.val().trim().length<3||!/^[\w\'\., ]+$/.test(kedudukanSMA.val())){
                updatePesan('Isikan kedudukan dalam organisasi, min 3 karakter');
                kedudukanSMA.focus();
                return false;
            }
            if(!/^\d{4}$/.test(thnMulaiOrgSMA.val())){
                updatePesan('Tahun terdiri dari 4 digit');
                thnMulaiOrgSMA.focus();
                return false;
            }
            if(!/^\d{4}$/.test(thnSelesaiOrgSMA.val())){
                updatePesan('Tahun terdiri dari 4 digit');
                thnSelesaiOrgSMA.focus();
                return false;
            }
            if(tmpOrgSMA.val().trim().length<4||!/^[\w\'\., ]+$/.test(tmpOrgSMA.val())){
                updatePesan('Isikan tempat organisasi, min 4 karakter');
                tmpOrgSMA.focus();
                return false;
            }
            if(pimpinanOrgSMA.val().trim().length<4||!/^[\w\'\., ]+$/.test(pimpinanOrgSMA.val())){
                updatePesan('Isikan nama pimpinan organisasi, min 4 karakter');
                pimpinanOrgSMA.focus();
                return false;
            }
            $('#daftarorg_sma > tbody').append('<tr>'+
                '<td><input type="hidden" name="anm_orgsma[]" value="'+nmOrgSMA.val()+'" >'+nmOrgSMA.val()+'</td>'+
                '<td><input type="hidden" name="akedudukan_orgsma[]" value="'+kedudukanSMA.val()+'" >'+kedudukanSMA.val()+'</td>'+
                '<td><input type="hidden" name="athnmulai_orgsma[]" value="'+thnMulaiOrgSMA.val()+'" >'+thnMulaiOrgSMA.val()+'</td>'+
                '<td><input type="hidden" name="athnselesai_orgsma[]" value="'+thnSelesaiOrgSMA.val()+'" >'+thnSelesaiOrgSMA.val()+'</td>'+
                '<td><input type="hidden" name="atmp_orgsma[]" value="'+tmpOrgSMA.val()+'" >'+tmpOrgSMA.val()+'</td>'+
                '<td><input type="hidden" name="apimpinan_orgsma[]" value="'+pimpinanOrgSMA.val()+'" >'+pimpinanOrgSMA.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            nmOrgSMA.val('');
            kedudukanSMA.val('');
            thnMulaiOrgSMA.val('');
            thnSelesaiOrgSMA.val('');
            tmpOrgSMA.val('');
            pimpinanOrgSMA.val('');
            stripTabel();
            editOrgsma.val('y');
        });
        
        var nmOrgPT = $('#nmorg_pt'),
            kedudukanPT = $('#kedudukanpt'),
            thnMulaiOrgPT = $('#thnmulaiorg_pt'),
            thnSelesaiOrgPT = $('#thnselesaiorg_pt'),
            tmpOrgPT = $('#tmp_org_pt'),
            pimpinanOrgPT = $('#pimpinan_org_pt');

        btnTambahOrgPT.click(function(){
            if(nmOrgPT.val().trim().length<4||!/^[\w\'\., ]+$/.test(nmOrgPT.val())){
                updatePesan('Isikan nama organisasi, min 4 karakter');
                nmOrgPT.focus();
                return false;
            }
            if(kedudukanPT.val().trim().length<3||!/^[\w\'\., ]+$/.test(kedudukanPT.val())){
                updatePesan('Isikan kedudukan dalam organisasi, min 3 karakter');
                nmOrgPT.focus();
                return false;
            }
            if(!/^\d{4}$/.test(thnMulaiOrgPT.val())){
                updatePesan('Tahun terdiri dari 4 digit');
                thnMulaiOrgPT.focus();
                return false;
            }
            if(!/^\d{4}$/.test(thnSelesaiOrgPT.val())){

                updatePesan('Tahun terdiri dari 4 digit');
                thnSelesaiOrgPT.focus();
                return false;
            }
            if(tmpOrgPT.val().trim().length<4||!/^[\w\'\., ]+$/.test(tmpOrgPT.val())){
                updatePesan('Isikan tempat organisasi, min 4 karakter');
                tmpOrgPT.focus();
                return false;
            }
            if(pimpinanOrgPT.val().trim().length<4||!/^[\w\'\., ]+$/.test(pimpinanOrgPT.val())){
                updatePesan('Isikan nama pimpinan organisasi, min 4 karakter');
                pimpinanOrgPT.focus();
                return false;
            }
            $('#daftarorg_pt > tbody').append('<tr>'+
                '<td><input type="hidden" name="anm_orgpt[]" value="'+nmOrgPT.val()+'" >'+nmOrgPT.val()+'</td>'+
                '<td><input type="hidden" name="akedudukan_orgpt[]" value="'+kedudukanPT.val()+'" >'+kedudukanPT.val()+'</td>'+
                '<td><input type="hidden" name="athnmulai_orgpt[]" value="'+thnMulaiOrgPT.val()+'" >'+thnMulaiOrgPT.val()+'</td>'+
                '<td><input type="hidden" name="athnselesai_orgpt[]" value="'+thnSelesaiOrgPT.val()+'" >'+thnSelesaiOrgPT.val()+'</td>'+
                '<td><input type="hidden" name="atmp_orgpt[]" value="'+tmpOrgPT.val()+'" >'+tmpOrgPT.val()+'</td>'+
                '<td><input type="hidden" name="apimpinan_orgpt[]" value="'+pimpinanOrgPT.val()+'" >'+pimpinanOrgPT.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            nmOrgPT.val('');
            kedudukanPT.val('');
            thnMulaiOrgPT.val('');
            thnSelesaiOrgPT.val('');
            tmpOrgPT.val('');
            pimpinanOrgPT.val('');
            stripTabel();
            editOrgpt.val('y');
        });
        
        var nmOrgKerja = $('#nmorg_kerja'),
            kedudukanKerja = $('#kedudukankerja'),
            thnMulaiOrgKerja= $('#thnmulaiorg_kerja'),
            thnSelesaiOrgKerja = $('#thnselesaiorg_kerja'),
            tmpOrgKerja = $('#tmp_org_kerja'),
            pimpinanOrgKerja = $('#pimpinan_org_kerja');
        
        btnTambahOrgKerja.click(function(){
            if(nmOrgKerja.val().trim().length<4||!/^[\w\'\., ]+$/.test(nmOrgKerja.val())){
                updatePesan('Isikan nama organisasi, min 4 karakter');
                nmOrgKerja.focus();
                return false;
            }
            if(kedudukanKerja.val().trim().length<3||!/^[\w\'\., ]+$/.test(kedudukanKerja.val())){
                updatePesan('Isikan kedudukan dalam organisasi, min 3 karakter');
                kedudukanKerja.focus();
                return false;
            }
            if(!/^\d{4}$/.test(thnMulaiOrgKerja.val())){
                updatePesan('Tahun terdiri dari 4 digit');
                thnMulaiOrgKerja.focus();
                return false;
            }
            if(!/^\d{4}$/.test(thnSelesaiOrgKerja.val())){
                updatePesan('Tahun terdiri dari 4 digit');
                thnSelesaiOrgKerja.focus();
                return false;
            }
            if(tmpOrgKerja.val().trim().length<4||!/^[\w\'\., ]+$/.test(tmpOrgKerja.val())){
                updatePesan('Isikan tempat organisasi, min 4 karakter');
                tmpOrgKerja.focus();
                return false;
            }
            if(pimpinanOrgKerja.val().trim().length<4||!/^[\w\'\., ]+$/.test(pimpinanOrgKerja.val())){
                updatePesan('Isikan nama pimpinan organisasi, min 4 karakter');
                pimpinanOrgKerja.focus();
                return false;
            }
            $('#daftarorg_kerja > tbody').append('<tr>'+
                '<td><input type="hidden" name="anm_orgkerja[]" value="'+nmOrgKerja.val()+'" >'+nmOrgKerja.val()+'</td>'+
                '<td><input type="hidden" name="akedudukan_orgkerja[]" value="'+kedudukanKerja.val()+'" >'+kedudukanKerja.val()+'</td>'+
                '<td><input type="hidden" name="athnmulai_orgkerja[]" value="'+thnMulaiOrgKerja.val()+'" >'+thnMulaiOrgKerja.val()+'</td>'+
                '<td><input type="hidden" name="athnselesai_orgkerja[]" value="'+thnSelesaiOrgKerja.val()+'" >'+thnSelesaiOrgKerja.val()+'</td>'+
                '<td><input type="hidden" name="atmp_orgkerja[]" value="'+tmpOrgKerja.val()+'" >'+tmpOrgKerja.val()+'</td>'+
                '<td><input type="hidden" name="apimpinan_orgkerja[]" value="'+pimpinanOrgKerja.val()+'" >'+pimpinanOrgKerja.val()+'</td>'+
                '<td><a href="#">Delete</a></td>'+
                '</tr>');
            nmOrgKerja.val('');
            kedudukanKerja.val('');
            thnMulaiOrgKerja.val('');
            thnSelesaiOrgKerja.val('');
            tmpOrgKerja.val('');
            pimpinanOrgKerja.val('');
            stripTabel();
            editOrgkerja.val('y');
        });
        
        $.validator.addMethod('notNull',function(value,element,param){
		    return $(element).val()!=null;
		},'Pilih diantara pilihan');
		
        $.validator.addMethod("teks", function(value, element) {
	        return this.optional(element) || /^[0-9a-z-.,()/'\"\s\-]+$/i.test(value);
        }, "Isi hanya berupa huruf/angka atau tanda baca");
        
        $.validator.addMethod("notlp", function(value, element) {
	        return this.optional(element) || /^[0-9()+\s]+$/i.test(value);
        }, "Isikan notelp");
        
		formEditPegawai.validate({
	        rules:{
	            nmlengkap:{required:true,teks:true},
	            nip:{required:true,digits:true},
	            seksi:{notNull:true},
	            jabatan:{notNull:true},
	            tgllahir:"required",
	            tmplahir:{required:true,teks:true},
	            notelp:{notlp:true},
	            jalan:{required:true,teks:true},
	            desa:{required:true,teks:true},
	            kec:{required:true,teks:true},
	            kab:{required:true,teks:true},
	            propinsi:{required:true,teks:true},
	            kodepos:{required:true,digits:true,minlength:5,teks:true},
	            tinggi:{required:true,number:true},
	            berat:{required:true,number:true},
	            rambut:{required:true,teks:true},
	            bentukmuka:{required:true,teks:true},
	            warnakulit:{required:true,teks:true},
	            cirikhas:{required:true,teks:true},
	            cacat:{required:true,teks:true},
	            skkb_pejabat:{teks:true},
	            skkb_nomor:{teks:true},
	            sk_sehat_pejabat:{teks:true},
	            sk_sehat_nomor:{teks:true},
	            ket_tambah:{teks:true}
	            },
	        messages:{
	            nmlengkap:{
	                required:"Isikan nama lengkap pegawai"
	            },
	            nip:{
	                required:"isikan NIP pegawai",
	                digits:"NIP berupa angka"
	            },
	            seksi:"Pilih seksi yang ada",
	            jabatan:"Pilih jabatan yang ada",
	            tgllahir:"Isikan tanggal lahir pegawai",
	            tmplahir:{
	                required:"Isikan tempat lahir pegawai"
	            },
	            jalan:{
	                required:"Isikan alamat jalan pegawai"
	            },
	            desa:{
	                required:"Alamat desa/kelurahan pegawai"
	            },
	            kec:{
	                required:"Kecamatan pegawai"
	            },
	            kab:{
	                required:"Kabupaten pegawai"
	            },
	            propinsi:{
	                required:"Propinsi pegawai"
	            },
	            kodepos:{
	                required:"isikan kode pos",
	                digits:"Kodepos hanya berupa digit",
	                minlength:"Kodepos terdiri dari 5 digit"
	            },
	            tinggi:{required:"Isikan tinggi pegawai",number:"Tinggi pegawai berupa bilangan dalam satuan (cm)"},
	            berat:{required:"Isikan berat pegawai",number:"Berat pegawai berupa bilangan dalam satuan (kg)"},
	            rambut:{
	                required:"Deskripsikan rambut pegawai"
	            },
	            bentukmuka:{
	                required:"Deskripsikan bentuk muka pegawai"
	            },
	            warnakulit:{
	                required:"Deskripsikan warna kulit pegawai"
	            },
	            cirikhas:{
	                required:"Ciri khas tertentu pegawai"
	            },
	            cacat:{
	                required:"Jika tidak ada cacat fisik isi dengan (-)"
	            }
	        },
            submitHandler: function() { 
                $('body').scrollTop(0);
                $('html').scrollTop(0);
                //open dialog
                $("#dialog-confirm").dialog('open');
            }
	    });
	    
        $("#dialog-confirm").dialog({
			resizable: false,
			height:180,
			modal: true,
			autoOpen:false,
			buttons: {
				Ya: function() {
				    $.ajax({
                        url:'../lib/ajax.php',
                        type:'POST',
                        timeout:10000,
                        dataType: 'json',
                        data:formEditPegawai.serialize(),
                        success:function(data){
                            if(data.berhasil){
                                //formEditPegawai.trigger('reset');
                                //$('tbody').children().remove();
                                updatePesan(data.pesan);
                                formEditPegawai.fadeOut('slow');
                                formSelectPegawai.fadeIn('slow');
                            }else{
                                updatePesan(data.pesan);
                            }
                        },
                        error:function(e){                    
                            updatePesan('Terjadi kesalahan koneksi');
                        }
                    });
					$(this).dialog('close');
				},
				Tidak: function() {
					$(this).dialog('close');
				}
			}
		});
		
	    unitKerja.change(function(){
            $.ajax({
                url:'../lib/ajax.php?op=listseksi&unitkerja='+unitKerja.val(),
                type:'GET',
                timeout:10000,
                dataType: 'json',
                success:function(data){
                        seksi.children().remove();
                        for(var i=0;i<data.length;i++){
                            seksi.append('<option value="'+data[i].seksi+'">'+data[i].seksi+'</option>'); 
                        }
                        if(seksi.val()==null){
                            updatePesan('Seksi di unit kerja ini tidak ada silahkan pilih yang lain');
                        }else{
                            updatePesan('Daftar seksi terupdate');
                        }
                        seksi.trigger('change');
                },
                error:function(e){                   
                    updatePesan('Terjadi kesalahan koneksi');
                }
            });
	    });
	    
	    seksi.change(function(){
	        if($(this).val()!=null){
                $.ajax({
                    url:'../lib/ajax?op=listjabatanbysuk&unitkerja='+unitKerja.val()+'&seksi='+escape($(this).val()),
                    type:'GET',
                    timeout:10000,
                    dataType: 'json',
                    success:function(data){
                            jabatan.children().remove();
                            for(var i=0;i<data.length;i++){
                                jabatan.append('<option value="'+data[i].id_jabatan+'">'+data[i].jabatan+'</option>'); 
                            }
                    },
                    error:function(e){
                        updatePesan('Terjadi kesalahan koneksi');
                    }
                });
	        }else{
	            jabatan.children().remove();
	        }
	    });
	    
	    opsiDiklat.change(function(){
            $.ajax({
                url:'../lib/ajax.php?op=listdiklatbykat&kat='+$(this).val(),
                type:'GET',
                timeout:10000,
                dataType: 'json',
                success:function(data){
                        nmDiklat.children().remove();
                        for(var i=0;i<data.length;i++){
                            nmDiklat.append('<option value="'+data[i].id_jenis_diklat+'">'+data[i].nama+'</option>' +
			                '</tr>'); 
                        }
                        updatePesan('Data pilihan diklat terupdate');
                },
                error:function(e){                   
                    updatePesan('Terjadi kesalahan koneksi');
                }
            });
	    });
        ttpPesan.click(function(){
            pnlPesan.fadeOut('fast');
            return false;
        });
        
        function updatePesan(pesan){
            isiPesan.html(pesan).addClass('cahaya');
            setTimeout(function() {
                isiPesan.removeClass('cahaya', 1500);
            }, 500);
            pnlPesan.fadeIn('slow').animate({opacity:0.8});
        }
        
        formSelectPegawai.validate({
	        rules:{
	            snip:{required:true,remote:"../lib/ajax.php?op=notceknippegawai"},
	            },
	        messages:{
	            snip:{
	                required:"isikan NIP pegawai",
	                remote:"NIP pegawai tidak ditemukan"
	            },
	        }
        });
        
        stripTabel();
        $.datepicker.setDefaults($.datepicker.regional['id']);
		$('.tanggal').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'd/m/yy',
			defaultDate: '-30y',
			yearRange: 'c-20:c+20'
		}).keypress(function(e){
		    return false;
		});
        
    });
	
</script>
</html>
