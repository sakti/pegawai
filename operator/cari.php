<?php
require_once('../lib/auth.php');
require_once('../lib/conn.php');
require_once('../lib/liboperator.php');
auth('operator');
$inpt=($_SESSION['priv']=='input')?true:false;
$cari=false;
if(!empty($_GET['q'])){
    $daftarhasil=cariPegawai($_GET['q']);
    $cari=true;
    $cnt=0;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kepegawaian Dinas Perhubungan</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
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
                    <?php if($_SESSION['priv']=='input'):?>
                    <li><a href="input.php">Input</a></li>
                    <li><a href="edit.php">Edit</a></li>
                    <li><a href="upload.php">Upload Foto</a></li>
                    <?php endif;?>
                    <li><a href="daftar.php">Daftar</a></li>
                    <li><div>Cari</div></li>
                    <li><a href="laporan.php">Laporan</a></li>
                    <li><a href="statistik.php">Statistik</a><li>
                    <li><a id="logout" href="../login.php?a=logout">Logout</a></li>
                </ul>
            </div>
            <div id="isi">
                <h2>Cari data pegawai</h2>
                <form id="formpencarian" action="cari.php" method="GET">
					<input type="text" name="q" id="q" size="30" maxlength="35" value="<?=(empty($_GET['q']))?'':$_GET['q'];?>">
                    <input type="submit" class="tombol" value="Cari" />
                </form>
                <?if($cari):?>
                <h3>Hasil Pencarian</h3>
				<table id="daftarpegawai">
					<thead>
						<tr><th>NIP</th><th>Nama</th><th>Jabatan</th><th>Seksi</th><th>Unit Kerja</th><th>Status</th><th>Keterangan</th></tr>
					</thead>
					<tbody>
					    <?foreach($daftarhasil as $brs):?>
                        <tr>
						<td><a href="daftar.php?nip=<?=$brs['nip']?>"><?=$brs['nip']?></a> <?if($inpt):?><br/><a href="edit.php?snip=<?=$brs['nip']?>">Edit</a><?endif;?></td>
						<td><?=$brs['nama']?></td>
						<td><?=$brs['jabatan']?></td><td><?=$brs['seksi']?></td>
						<td><?=$brs['nama_unit_kerja']?></td><td><?=$brs['status']?></td>
						<td><?=$brs['keterangan']?></td>
						</tr>
						<?$cnt++?>
						<?endforeach?>
						<?if($cnt==0):?>
						<tr><td colspan="7">Tidak ada hasil</td></tr>
						<?endif;?>
					</tbody>
				</table>
				<?endif;?>
				<br><br>
            </div>
        </div>
        <div id="footer"> 2010 &copy; Dinas Perhubungan Jawa Barat </div>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function() {
        var pnlPesan=$('#pnlpesan'),ttpPesan=$('#pnlpesan a.close'),isiPesan=$('#isipesan');
        
        ttpPesan.click(function(){
            pnlPesan.fadeOut('fast');
            return false;
        });
        $.validator.addMethod("teks", function(value, element) {
	        return this.optional(element) || /^[0-9a-z-.,()/'\"\s\-]+$/i.test(value);
        }, "Isi hanya berupa huruf/angka atau tanda baca");
        
        $('#formpencarian').validate({
            rules:{
                q:{required:true,minlength:3,teks:true}
            },
            messages:{
                q:{
                    required:"isikan kata kunci",
                    minlength:"isikan minimal 3 karakter"
                }
            }
        });
        function updatePesan(pesan){
            isiPesan.html(pesan).addClass('cahaya');
            setTimeout(function() {
                isiPesan.removeClass('cahaya', 1500);
            }, 500);
            pnlPesan.fadeIn('slow').animate({opacity:0.8});
        }
        $('tbody tr:odd').css('background-color','#b6d7e7');
    });
</script>
</html>
