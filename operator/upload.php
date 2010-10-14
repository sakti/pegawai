<?php
require_once('../lib/auth.php');
require_once('../lib/conn.php');
require_once('../lib/liboperator.php');
auth('input');
$_SESSION['error']='';
if(!empty($_POST)&&$_POST['upload']=='Upload'){
    if($_FILES['foto']['error']==UPLOAD_ERR_OK ){
        $foto=true;
        $namafile=md5_file($_FILES['foto']['tmp_name']);
        $ext=substr($_FILES['foto']['name'],strrpos($_FILES['foto']['name'],"."));
        $namafile.=$ext;
        $filter=array(".png",".jpg",".jpeg");
        $mime=mime_content_type($_FILES['foto']['tmp_name']);
        if(in_array(strtolower($ext),$filter)&&strstr($mime,"image")){
            if (move_uploaded_file($_FILES['foto']['tmp_name'],"../tmp/".$namafile)) {
                //jika berhasil
                list($width, $height) = getimagesize("../tmp/".$namafile);
                $thumb = imagecreatetruecolor(200, 300);
                switch($ext){
                    case '.jpg':
                    case '.jpeg':
                        $source = imagecreatefromjpeg("../tmp/".$namafile);
                        imagecopyresized($thumb, $source, 0, 0, 0, 0, 200, 300, $width, $height);
                        imagejpeg($thumb,"../tmp/".$namafile);
                        break;
                    case '.png':
                        $source = imagecreatefrompng("../tmp/".$namafile);
                        imagecopyresized($thumb, $source, 0, 0, 0, 0, 200, 300, $width, $height);
                        imagepng($thumb,"../tmp/".$namafile);
                        break;
                }
                $fp=fopen("../tmp/".$namafile,'r');
                $content = fread($fp, filesize("../tmp/".$namafile));
                $content = addslashes($content);
                fclose($fp);
                $hasil=queryExecute("UPDATE umum SET foto='$content',mime='$mime' WHERE nip='{$_POST['nip']}'");
                if($hasil===true){
                    unlink("../tmp/".$namafile);
                }else{
                    $_SESSION['error'].="File gagal dimasukkan dalam database.";
                    $foto=false;
                }
            } else {
                $_SESSION['error'].="File gagal di upload.";
                $foto=false;
            }
        }else{
            $_SESSION['error'].="File gambar yang bisa di upload .png .jpg .jpeg";
            $foto=false;
        }
    }else if($_FILES['foto']['error']==UPLOAD_ERR_INI_SIZE){
        $_SESSION['error'].="File terlalu besar.";
    }
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
        #formuploadfoto{
            display:none;
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
                    <li><a href="input.php">Input</a></li>
                    <li><a href="edit.php">Edit</a></li>
                    <li><div>Upload Foto</div></li>
                    <li><a href="daftar.php">Daftar</a></li>
                    <li><a href="cari.php">Cari</a></li>
                    <li><a href="laporan.php">Laporan</a></li>
                    <li><a href="statistik.php">Statistik</a><li>
                    <li><a id="logout" href="../login.php?a=logout">Logout</a></li>
                </ul>
            </div>
            <div id="isi">
                <h2>Upload Foto Pegawai</h2>
                <p><?php if(!empty($foto)&&$foto): ?> <h2>Upload Foto berhasil </h2><?php endif;?></p>
                <p class="error"><?php if(!empty($_SESSION['error'])) echo $_SESSION['error']; ?></p>
                <p>Terlebih dahulu masukkan nip pegawai yang akan diupload fotonya. Untuk mengupload foto pegawai silahkan pilih file, untuk pegawai yang sudah ada foto sebelumnya maka akan diganti dengan yang baru</p>
                <form id="formselectpegawai">
	                <fieldset>
	                <legend>Pilih Pegawai</legend>
	                <label for="snip">NIP</label><input type="text" name="snip" id="snip" size="30" maxlength="30">

                    </fieldset>
                    <input type="submit" class="tombol" id="cari" value="Pilih" />
                </form>
                <form action="upload.php" id="formuploadfoto" enctype="multipart/form-data" method="POST">
	                <fieldset>
	                <legend>Foto Pegawai</legend>
	                <input type="hidden" name="nip" id="nip" value="113080014" />
	                <label for="nip">NIP</label><input type="text" name="tnip" id="tnip" size="30" maxlength="30" disabled>
	                <label for="nmpegawai">Nama Pegawai</label><input type="text" name="nmpegawai" id="nmpegawai" size="35" maxlength="60" disabled>
	                <label for="foto">Foto</label>
	                <input name="foto" type="file" id="foto" />
                    </fieldset>
                    <input type="submit" class="tombol" name="upload" value="Upload" />
                    <input type="button" value="Batal" id="batal" class="tombol" />
                </form>
            </div>
        </div>
        <div id="footer"> 2010 &copy; Dinas Perhubungan Jawa Barat </div>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function() {
        var pnlPesan=$('#pnlpesan'),ttpPesan=$('#pnlpesan a.close'),isiPesan=$('#isipesan'),formSelectPegawai=$('#formselectpegawai'),
            formUploadFoto=$('#formuploadfoto'),snip=$('#snip');
        
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
	        },
            submitHandler: function() { 
                $('body').scrollTop(0);
                $('html').scrollTop(0);
                $('#nip').val(snip.val());
                $('#tnip').val(snip.val());
                formUploadFoto.fadeIn('slow');
                formSelectPegawai.fadeOut('slow');
                $.ajax({
                        url:'../lib/ajax.php?op=getnama&nip='+snip.val(),
                        type:'GET',
                        timeout:10000,
                        dataType: 'json',
                        success:function(data){
                            $('#nmpegawai').val(data);
                        },
                        error:function(e){                   
                            updatePesan('Terjadi kesalahan koneksi');
                        }
                    });
            }
        });
        $('#batal').click(function(){
            formUploadFoto.fadeOut('slow');
            formSelectPegawai.fadeIn('slow');
        });
        $('tbody tr:odd').css('background-color','#b6d7e7');
    });
</script>
</html>
