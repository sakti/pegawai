<?php
require_once('../lib/auth.php');
require_once('../lib/conn.php');
require_once('../lib/libadmin.php');
auth('admin');
$dataUser=false;

$daftarUser=getDaftarUser();
if($_GET&&!empty($_GET['eid'])){
    $dataUser=getDataUser($_GET['eid']);
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
                    <li><div>Pengguna</div></li>
                    <li><a href="unitkerja.php">Unit Kerja</a></li>
                    <li><a href="golongan.php">Golongan</a></li>
                    <li><a href="diklat.php">Diklat</a></li>
                    <li><a href="jabatan.php">Jabatan</a></li>
                    <li><a id="logout" href="../login.php?a=logout">Logout</a></li>
                </ul>
            </div>
            <div id="isi">
                <h2>Pengaturan Pengguna</h2>
                <form id="formedituser" action="users.php" method="post">
                    <fieldset id="pnluser">
                    <legend>Detail Pengguna</legend>
                    <input type="hidden" value="<?php echo ($dataUser)?$dataUser['userid']:''; ?>" name="userid" id="userid" />
                    <label for="username">Username (tidak bisa diubah)</label><input type="text" name="username" id="username" size="16" maxlength="16" value="<?php echo ($dataUser)?$dataUser['username']:''; ?>" disabled >
                    <label for="password">Password (isikan password untuk mengganti)</label><input type="password" name="password" id="password" size="16" maxlength="16">
                    <label for="hakakses">Hak Akses</label>
                    <select name="hakakses" id="hakakses">
                        <option value="baca" <?php echo ($dataUser&&$dataUser['priv']!='baca')?'':'selected="selected"'; ?>>Baca</option>
                        <option value="input" <?php echo ($dataUser&&$dataUser['priv']!='input')?'':'selected="selected"'; ?>>Tulis</option>
                        <option value="admin" <?php echo ($dataUser&&$dataUser['priv']!='admin')?'':'selected="selected"'; ?>>Administrator</option>
                    </select> 
                    <input type="submit" value="Update" id="updatepengguna" name="updatepengguna" class="tombol" />
                    <input type="button" value="Batal" id="batal" class="tombol" />
                    </fieldset>
                    
                    <fieldset>
                    <legend>Daftar Pengguna</legend>
                        <table id="daftarpengguna">
                            <thead>
                                <tr><th>Username</th><th>Hak Akses</th><th>Operasi</th></tr>
                            </thead>
                            <tbody> 
                                <?php foreach($daftarUser as $brs): ?>
                                <tr><td><?php echo $brs['username']; ?></td><td><?php echo $brs['priv']; ?></td><td><a href="?eid=<?php echo $brs['userid']; ?>">Edit</a> &nbsp; <a href="?did=<?php echo $brs['userid']; ?>">Delete</a></td></tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <input type="button" value="Tambah Pengguna" id="tambahpengguna" class="tombol" />
                        </fieldset>
                        <br/><br/><br/>
                </form>
            </div>
        </div>
        <div id="footer"> 2010 &copy; Dinas Perhubungan Jawa Barat </div>
    </div>
    <div id="dialog-form" title="Tambah pengguna baru">
        <p class="validateTips">Semua kolom harus diisi.</p>
        <form id="formtambahuser">
        <fieldset>
            <label for="tname">Username</label>
            <input type="text" name="tname" id="tname" size="16" maxlength="16"/>
            <label for="tpassword">Password</label>
            <input type="password" name="tpassword" id="tpassword" value=""  size="16" maxlength="16"/>
            <label for="tpriv">Hak akses</label>
            <select name="tpriv" id="tpriv" class="text ui-widget-content ui-corner-all">
                <option value="baca">Baca</option>
                <option value="input">Tulis</option>
                <option value="admin">Administrator</option>
            </select>
        </fieldset>
        </form>
    </div>
    <div id="dialog-confirm" title="Delete Pengguna"> 
	    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Apakah anda yakin menghapus pengguna dengan nama <span id="namahapus"></span> ?</p> 
    </div> 
</body>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.bgiframe-2.1.1.js"></script>
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function() {
        var pnlPesan=$('#pnlpesan'),ttpPesan=$('#pnlpesan a.close'),isiPesan=$('#isipesan'),btnTambahPengguna=$('#tambahpengguna'),
            userId=$('#userid'),userName=$('#username'),passWord=$('#password'),hakAkses=$('#hakakses'),btnUpdate=$('#updatepengguna'),
            tabelPengguna=$('#daftarpengguna'),pnlUser=$('#pnluser'),tuser,tuserid;
        $('tbody tr:odd').css('background-color','#b6d7e7');
        $('#batal').click(function(){
            userId.val('');
            userName.val('');
            hakAkses.val('baca');
            passWord.val('');
            pnlUser.fadeOut('slow');
            updatePesan('Batal mengedit pengguna');
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
        btnTambahPengguna.click(function(){
            updatePesan('Tambah pengguna baru');
            pnlUser.fadeOut('slow');
            $('#dialog-form').dialog('open');
        });
	    function updateListUser(){
            $.ajax({
                url:'../lib/ajax.php?op=listuser',
                type:'GET',
                timeout:10000,
                dataType: 'json',
                success:function(data){
                        var tbhtbl=$('#daftarpengguna tbody');
                        tbhtbl.children().remove();
                        for(var i=0;i<data.length;i++){
                            tbhtbl.append('<tr>' +
				            '<td>' + data[i].username + '</td>' + 
				            '<td>' + data[i].priv + '</td>' + 
				            '<td><a href="?eid='+data[i].userid+'">Edit</a> &nbsp; <a href="?did='+data[i].userid+'">Delete</a</td>' +
				            '</tr>'); 
                        }
                        $('tbody tr:odd').css('background-color','#b6d7e7');
                },
                error:function(e){                   
                    updatePesan('Terjadi kesalahan koneksi');
                }
            });	
	    }
        btnUpdate.click(function(){
            var pnj=passWord.val().length;
            if(pnj!=0&&pnj<5||pnj>16){
                updatePesan('Panjang password harus lebih dari 5 dan kurang dari 16 karakter');
                return false;
            }
            $.ajax({
                url:'../lib/ajax.php',
                type:'POST',
                timeout:10000,
                dataType: 'json',
                data:'op=updateuser&'+$('#formedituser').serialize(),
                success:function(data){
                    if(data.berhasil){
                        updateListUser();
                        updatePesan(data.pesan);
                    }else{
                        updatePesan(data.pesan);
                    }
                },
                error:function(e){                    
                    updatePesan('Terjadi kesalahan koneksi');
                }
            });
            pnlUser.fadeOut('slow');
            return false;
        });
        tabelPengguna.click(function(e){
            var trg=$(e.target);
            if(trg.attr('href')){
                var id=parseInt(trg.attr('href').match(/\d+$/),10),
                    nama=trg.parents('tr').children().eq(0).text();
                    priv=trg.parents('tr').children().eq(1).text();
                if(trg.html()=='Edit'){
                    userId.val(id);
                    userName.val(nama);
                    hakAkses.val(priv);
                    passWord.val('');
                    pnlUser.fadeIn('slow');
                    $('body').scrollTop(0);
                    $('html').scrollTop(0);
                    updatePesan('Mengedit pengguna dengan username '+nama);
                }else if(trg.html()=='Delete'){
                    tuser=nama;
                    tuserid=id;
                    $('#namahapus').text(tuser);
                    pnlUser.fadeOut('slow')
                    $("#dialog-confirm").dialog('open');
                }
            }
            return false;
        });
        pnlUser.hide();
        
        
        //code dialog form
		var tname = $("#tname"),
			tpassword = $("#tpassword"),
			tpriv=$('#tpriv'),
			allFields = $([]).add(tname).add(tpassword),
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
			height: 350,
			width: 320,
			modal: true,
			buttons: {
				'Tambah pengguna': function() {
					var bValid = true;
					allFields.removeClass('ui-state-error');

					bValid = bValid && checkLength(tname,"username",3,16);
					bValid = bValid && checkLength(tpassword,"password",5,16);

					bValid = bValid && checkRegexp(tname,/^[a-z]([0-9a-z_])+$/i,"Nama pengguna dapat berisi a-z, 0-9, underscore, dimulai dengan huruf.");
					
					if (bValid) {
						$.ajax({
						    url:'../lib/ajax.php',
                            type:'POST',
                            timeout:10000,
                            dataType: 'json',
                            data:'op=inputuser&'+$('#formtambahuser').serialize(),
                            success:function(data){
                                if(data.berhasil){
						            tabelPengguna.children('tbody').append('<tr>' +
							            '<td>' + tname.val() + '</td>' + 
							            '<td>' + tpriv.val() + '</td>' + 
							            '<td><a href="?eid='+data.userid+'">Edit</a> &nbsp; <a href="?did='+data.userid+'">Delete</a></td>' +
							            '</tr>'); 
						            $('tbody tr:odd').css('background-color','#b6d7e7');
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
                        data:'op=deleteuser&userid='+tuserid,
                        success:function(data){
                            if(data.berhasil){
			                    updateListUser();
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
