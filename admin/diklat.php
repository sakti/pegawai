<?php
require_once('../lib/auth.php');
require_once('../lib/conn.php');
require_once('../lib/libadmin.php');
auth('admin');
$dataDiklat=false;
$daftarDiklat=getDaftarDiklat();
if($_GET&&!empty($_GET['eid'])){
    $dataDiklat=getDataDiklat($_GET['eid']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kepegawaian DISHUB JABAR</title>
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
            <p class="desc">Administrator</p>
        </div>
        <div id="content">
            <div id="menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="users.php">Pengguna</a></li>
                    <li><a href="unitkerja.php">Unit Kerja</a></li>
                    <li><a href="golongan.php">Golongan</a></li>
                    <li><div>Diklat</div></li>
                    <li><a href="jabatan.php">Jabatan</a></li>
                    <li><a href="../login.php?a=logout" id="logout">Logout</a></li>
                </ul>
            </div>
            <div id="isi">
                <h2>Manajemen Diklat</h2>
                <form id="formeditdiklat" action="diklat.php" method="post">
                    <fieldset id="pnldiklat">
                    <legend>Data Diklat</legend>
                    <input type="hidden" value="<?php echo ($dataDiklat)?$dataDiklat['id_jenis_diklat']:''; ?>" name="id" id="id" />
                    <label for="jenis">Jenis</label>
                    <select name="jenis" id="jenis">
                        <option value="darat" <?php echo ($dataDiklat&&$dataDiklat['jenis']!='darat')?'':'selected="selected"'; ?>>darat</option>
                        <option value="laut" <?php echo ($dataDiklat&&$dataDiklat['jenis']!='laut')?'':'selected="selected"'; ?>>laut</option>
                        <option value="udara" <?php echo ($dataDiklat&&$dataDiklat['jenis']!='udara')?'':'selected="selected"'; ?>>udara</option>
                        <option value="ketatausahaan" <?php echo ($dataDiklat&&$dataDiklat['jenis']!='ketatausahaan')?'':'selected="selected"'; ?>>udara</option>
                        <option value="umum" <?php echo ($dataDiklat&&$dataDiklat['jenis']!='umum')?'':'selected="selected"'; ?>>udara</option>
                    </select>
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" size="30" maxlength="100" value="<?php echo ($dataDiklat)?$dataDiklat['nama']:''; ?>">
                    <input type="submit" value="Update" id="updatediklat" name="updatediklat" class="tombol" />
                    <input type="button" value="Batal" id="batal" class="tombol" />
                    </fieldset>
                    
                    <fieldset>
                    <legend>Daftar Diklat</legend>
                        <table id="daftardiklat">
                            <thead>
                                <tr><th>Jenis</th><th>Nama</th><th>Operasi</th></tr>
                            </thead>
                            <tbody> 
                                <?php foreach($daftarDiklat as $brs): ?>
                                <tr><td><?php echo $brs['jenis']; ?></td><td><?php echo $brs['nama']; ?></td><td><a href="?eid=<?php echo $brs['id_jenis_diklat']; ?>">Edit</a> &nbsp; <a href="?did=<?php echo $brs['id_jenis_diklat']; ?>">Delete</a></td></tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <input type="button" value="Tambah Diklat" id="tambahdiklat" class="tombol" />
                        </fieldset>
                        <br/><br/><br/>
                </form>
            </div>
        </div>
        <div id="footer"> 2010 &copy; Dinas Perhubungan Jawa Barat </div>
    </div>
    <div id="dialog-form" title="Tambah Diklat baru">
        <p class="validateTips">Isi nama diklat.</p>
        <form id="formtambahdiklat">
        <fieldset>
            <label for="tjenis">Jenis</label>
            <select name="tjenis" id="tjenis">
                <option value="darat" >darat</option>
                <option value="laut" >laut</option>
                <option value="udara">udara</option>
                <option value="ketatausahaan">ketatausahaan</option>
                <option value="umum">umum</option>
            </select>
            <label for="tnama">Nama</label>
            <input type="text" name="tnama" id="tnama" size="25" maxlength="30">
        </fieldset>
        </form>
    </div>
    <div id="dialog-confirm" title="Delete Diklat"> 
	    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Apakah anda yakin menghapus diklat <span id="namahapus"></span> ?</p> 
    </div>
</body>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.bgiframe-2.1.1.js"></script>
<script type="text/javascript">
    $(function() {
        var isiPesan=$('#isipesan'),pnlPesan=$('#pnlpesan'),ttpPesan=$('#pnlpesan a.close'),tabelDiklat=$('#daftardiklat'),id=$('#id'),
            jenis=$('#jenis'),nama=$('#nama'),pnlDiklat=$('#pnldiklat'),tnama,tid,
            btnTambahDiklat=$('#tambahdiklat'),btnUpdate=$('#updatediklat');

        $('tbody tr:odd').css('background-color','#b6d7e7');
        $('#batal').click(function(){
            id.val('');
            jenis.val('darat');
            nama.val('');
            pnlDiklat.fadeOut('slow');
            updatePesan('Batal mengedit diklat');
        });
        $(window).scroll(function(){
            //pnlPesan.stop().animate({top:$(document).scrollTop()},'slow','easeOutBack');
        });
        ttpPesan.click(function(){
            pnlPesan.fadeOut('fast');
            return false;
        })
        function updatePesan(pesan){
            isiPesan.html(pesan).addClass('cahaya');
            setTimeout(function() {
                isiPesan.removeClass('cahaya', 1500);
            }, 500);
            //pnlPesan.css('top',$(document).scrollTop());
            pnlPesan.fadeIn('slow').animate({opacity:0.8});
        }
        
        tabelDiklat.click(function(e){
            var trg=$(e.target);
            if(trg.attr('href')){
                var id_diklat=parseInt(trg.attr('href').match(/\d+$/),10),
                    jenis_diklat=trg.parents('tr').children().eq(0).text(),
                    nama_diklat=trg.parents('tr').children().eq(1).text();
                    //console.log(id_diklat+' : '+jenis_diklat+' : '+nama_diklat);
                if(trg.html()=='Edit'){
                    id.val(id_diklat);
                    jenis.val(jenis_diklat);
                    nama.val(nama_diklat);
                    pnlDiklat.fadeIn('slow');
                    $('body').scrollTop(0);
                    $('html').scrollTop(0);
                    updatePesan('Mengedit diklat '+nama_diklat);
                }else if(trg.html()=='Delete'){
                    tnama=nama_diklat;
                    tid=id_diklat;
                    $('#namahapus').text(tnama);
                    pnlDiklat.fadeOut('slow')
                    $("#dialog-confirm").dialog('open');
                }
            }
            return false;
        });

	    function updateListDiklat(){
            $.ajax({
                url:'../lib/ajax.php?op=listdiklat',
                type:'GET',
                timeout:10000,
                dataType: 'json',
                success:function(data){
                        var tbhtbl=$('#daftardiklat tbody');
                        tbhtbl.children().remove();
                        for(var i=0;i<data.length;i++){
                            tbhtbl.append('<tr>' +
                            '<td>' + data[i].jenis + '</td>' + 
				            '<td>' + data[i].nama + '</td>' + 
				            '<td><a href="?eid='+data[i].id_jenis_diklat+'">Edit</a> &nbsp; <a href="?did='+data[i].id_jenis_diklat+'">Delete</a></td>' +
				            '</tr>'); 
                        }
                        $('tbody tr:odd').css('background-color','#b6d7e7');
                },
                error:function(e){                   
                    updatePesan('Terjadi kesalahan koneksi');
                }
            });	
	    }
	    
        pnlDiklat.hide();
        btnTambahDiklat.click(function(){
            updatePesan('Tambah diklat baru');
            pnlDiklat.fadeOut('slow')
            $('#dialog-form').dialog('open');
        });

        btnUpdate.click(function(){
            var pnj=nama.val().trim().length;
            if(pnj<3||pnj>30){
                updatePesan('Panjang golongan harus lebih dari 3 dan kurang dari 30 karakter');
                nama.focus();
                return false;
            }
            //console.log($('#formeditgolongan').serialize());
			$.ajax({
			    url:'../lib/ajax.php',
                type:'POST',
                timeout:10000,
                dataType: 'json',
                data:'op=updatediklat&'+$('#formeditdiklat').serialize(),
                success:function(data){
                    if(data.berhasil){
			            updateListDiklat();
                        updatePesan(data.pesan);
                    }else{
                        updatePesan(data.pesan);
                    }
                },
                error:function(e){                    
                    updatePesan('Terjadi kesalahan koneksi');
                }
			});
            pnlDiklat.fadeOut('slow');
            return false;
        });
        
//code dialog form
		var tjenis = $("#tjenis"),
		    tnama = $('#tnama'),
			allFields = $([]).add(tnama),
			tips = $(".validateTips");

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
				updateTips("Panjang " + n + " harus diantara "+min+" and "+max+".");
				return false;
			} else {
				return true;
			}
		}

		function checkRegexp(o,regexp,n) {
			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass('ui-state-error');
				updateTips(n);
				return false;
			} else {
				return true;
			}
		}
		
		$("#dialog-form").dialog({
			autoOpen: false,
			height: 300,
			width: 280,
			modal: true,
			buttons: {
				'Tambah Instansi': function() {
					var bValid = true;
					allFields.removeClass('ui-state-error');
					bValid = bValid && checkLength(tnama,"Nama",3,100);
					if (bValid) {
						$.ajax({
						    url:'../lib/ajax.php',
                            type:'POST',
                            timeout:10000,
                            dataType: 'json',
                            data:'op=inputdiklat&'+$('#formtambahdiklat').serialize(),
                            success:function(data){
                                if(data.berhasil){
						            updateListDiklat();
                                    updatePesan(data.pesan);
                                    allFields.val('').removeClass('ui-state-error');
                                }else{
                                    updatePesan(data.pesan);
                                }
                            },
                            error:function(e){                    
                                updatePesan('Terjadi kesalahan koneksi');
                            }
						});
						//console.log($('#formtambahuser').serialize());
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
		

		//code konfirmasi hapus
		$("#dialog-confirm").dialog({
			resizable: false,
			width:350,
			height:210,
			modal: true,
			autoOpen:false,
			buttons: {
				Ya: function() {
				    $.ajax({
			            url:'../lib/ajax.php',
                        type:'POST',
                        timeout:10000,
                        dataType: 'json',
                        data:'op=deletediklat&id='+tid,
                        success:function(data){
                            if(data.berhasil){
			                    updateListDiklat();
                                updatePesan(data.pesan);
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
    });
</script>
</html>
