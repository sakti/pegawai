<?php
require_once('../lib/auth.php');
require_once('../lib/conn.php');
require_once('../lib/libadmin.php');
auth('admin');
$dataGolongan=false;
$daftarGolongan=getDaftarGolongan();
if($_GET&&!empty($_GET['eid'])){
    $dataGolongan=getDataGolongan($_GET['eid']);
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
                    <li><div>Golongan</div></li>
                    <li><a href="diklat.php">Diklat</a></li>
                    <li><a href="jabatan.php">Jabatan</a></li>
                    <li><a href="../login.php?a=logout" id="logout">Logout</a></li>
                </ul>
            </div>
            <div id="isi">
                <h2>Manajemen Golongan Pegawai</h2>
                <form id="formeditgolongan" action="golongan.php" method="post">
                    <fieldset id="pnlgolongan">
                    <legend>Data Golongan</legend>
                    <input type="hidden" value="<?php echo ($dataGolongan)?$dataGolongan['id_golongan']:''; ?>" name="id" id="id" />
                    <label for="golongan">Golongan</label><input type="text" name="golongan" id="golongan" size="8" maxlength="20" value="<?php echo ($dataGolongan)?$dataGolongan['golongan']:''; ?>">
                    <label for="ket">Keterangan</label><input type="text" name="ket" id="ket" size="20" maxlength="25" value="<?php echo ($dataGolongan)?$dataGolongan['ket']:''; ?>">
                    <label for="nilai">Nilai</label><input type="text" name="nilai" id="nilai" size="4" maxlength="6" value="<?php echo ($dataGolongan)?$dataGolongan['nilai']:''; ?>">
                    <input type="submit" value="Update" id="updategolongan" name="updategolongan" class="tombol" />
                    <input type="button" value="Batal" id="batal" class="tombol" />
                    </fieldset>
                    
                    <fieldset>
                    <legend>Daftar Golongan</legend>
                        <table id="daftargolongan">
                            <thead>
                                <tr><th>Golongan</th><th>Keterangan</th><th>Nilai</th><th>Operasi</th></tr>
                            </thead>
                            <tbody> 
                                <?php foreach($daftarGolongan as $brs): ?>
                                <tr><td><?php echo $brs['golongan']; ?></td><td><?php echo $brs['ket']; ?></td><td><?php echo $brs['nilai']; ?></td><td><a href="?eid=<?php echo $brs['id_golongan']; ?>">Edit</a> &nbsp; <a href="?did=<?php echo $brs['id_golongan']; ?>">Delete</a></td></tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <input type="button" value="Tambah Golongan" id="tambahgolongan" class="tombol" />
                        </fieldset>
                        <br/><br/><br/>
                </form>
            </div>
        </div>
        <div id="footer"> 2010 &copy; Dinas Perhubungan Jawa Barat </div>
    </div>
    <div id="dialog-form" title="Tambah Golongan baru">
        <p class="validateTips">Isi semua field.</p>
        <form id="formtambahgolongan">
        <fieldset>
            <label for="tgolongan">Golongan</label>
            <input type="text" name="tgolongan" id="tgolongan" size="8" maxlength="20" />
            <label for="tket">Keterangan</label>
            <input type="text" name="tket" id="tket" size="20" maxlength="25" />
            <label for="tnilai">Nilai</label>
            <input type="text" name="tnilai" id="tnilai" size="4" maxlength="6" />
        </fieldset>
        </form>
    </div>
    <div id="dialog-confirm" title="Delete Golongan"> 
	    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Apakah anda yakin menghapus golongan <span id="namahapus"></span> ?</p> 
    </div>
</body>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.bgiframe-2.1.1.js"></script>
<script type="text/javascript">
    $(function() {
        var isiPesan=$('#isipesan'),pnlPesan=$('#pnlpesan'),ttpPesan=$('#pnlpesan a.close'),tabelGolongan=$('#daftargolongan'),id=$('#id'),
            golongan=$('#golongan'),ket=$('#ket'),nilai=$('#nilai'),pnlGolongan=$('#pnlgolongan'),tnama,tid,
            btnTambahGolongan=$('#tambahgolongan'),btnUpdate=$('#updategolongan');
        $('tbody tr:odd').css('background-color','#b6d7e7');
        $('#batal').click(function(){
            id.val('');
            golongan.val('');
            ket.val('');
            nilai.val('');
            pnlGolongan.fadeOut('slow');
            updatePesan('Batal mengedit golongan');
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
        tabelGolongan.click(function(e){
            var trg=$(e.target);
            if(trg.attr('href')){
                var id_golongan=parseInt(trg.attr('href').match(/\d+$/),10),
                    nama_golongan=trg.parents('tr').children().eq(0).text(),
                    ket_golongan=trg.parents('tr').children().eq(1).text(),
                    nilai_golongan=trg.parents('tr').children().eq(2).text();
                    //console.log(id_golongan+' : '+nama_golongan+' : '+ket_golongan+' : '+nilai_golongan);
                if(trg.html()=='Edit'){
                    id.val(id_golongan);
                    golongan.val(nama_golongan);
                    ket.val(ket_golongan);
                    nilai.val(nilai_golongan)
                    pnlGolongan.fadeIn('slow');
                    $('body').scrollTop(0);
                    $('html').scrollTop(0);
                    updatePesan('Mengedit golongan '+nama_golongan);
                }else if(trg.html()=='Delete'){
                    tnama=nama_golongan;
                    tid=id_golongan;
                    $('#namahapus').text(tnama);
                    pnlGolongan.fadeOut('slow')
                    $("#dialog-confirm").dialog('open');
                }
            }
            return false;
        });

	    function updateListGolongan(){
            $.ajax({
                url:'../lib/ajax.php?op=listgolongan',
                type:'GET',
                timeout:10000,
                dataType: 'json',
                success:function(data){
                        var tbhtbl=$('#daftargolongan tbody');
                        tbhtbl.children().remove();
                        for(var i=0;i<data.length;i++){
                            tbhtbl.append('<tr>' +
                            '<td>' + data[i].golongan + '</td>' + 
				            '<td>' + data[i].ket + '</td>' + 
				            '<td>' + data[i].nilai + '</td>' + 
				            '<td><a href="?eid='+data[i].id_golongan+'">Edit</a> &nbsp; <a href="?did='+data[i].id_golongan+'">Delete</a></td>' +
				            '</tr>'); 
                        }
                        $('tbody tr:odd').css('background-color','#b6d7e7');
                },
                error:function(e){                   
                    updatePesan('Terjadi kesalahan koneksi');
                }
            });	
	    }
	    
        pnlGolongan.hide();
        btnTambahGolongan.click(function(){
            updatePesan('Tambah golongan baru');
            pnlGolongan.fadeOut('slow')
            $('#dialog-form').dialog('open');
        });

        btnUpdate.click(function(){
            var pnj=golongan.val().trim().length,pnjket=ket.val().trim().length;
            if(pnj<1||pnj>20){
                updatePesan('Panjang golongan harus lebih dari 1 dan kurang dari 20 karakter');
                golongan.focus();
                return false;
            }
            if(pnjket<3||pnjket>25){
                updatePesan('Panjang Keterangan harus lebih dari 3 dan kurang dari 25 karakter');
                ket.focus();
                return false;
            }
            if(!(/^[0-9]+$/.test(nilai.val()))){
                updatePesan('Nilai harus berupa angka');
                nilai.focus();
                return false;
            }
            //console.log($('#formeditgolongan').serialize());
			$.ajax({
			    url:'../lib/ajax.php',
                type:'POST',
                timeout:10000,
                dataType: 'json',
                data:'op=updategolongan&'+$('#formeditgolongan').serialize(),
                success:function(data){
                    if(data.berhasil){
			            updateListGolongan();
                        updatePesan(data.pesan);
                    }else{
                        updatePesan(data.pesan);
                    }
                },
                error:function(e){                    
                    updatePesan('Terjadi kesalahan koneksi');
                }
			});
            pnlGolongan.fadeOut('slow');
            return false;
        });
        
//code dialog form
		var tgolongan = $("#tgolongan"),
		    tket = $('#tket'),
		    tnilai = $('#tnilai'),
			allFields = $([]).add(tgolongan).add(tket).add(tnilai),
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
			width: 300,
			modal: true,
			buttons: {
				'Tambah Instansi': function() {
					var bValid = true;
					allFields.removeClass('ui-state-error');
					bValid = bValid && checkLength(tgolongan,"golongan",1,20);
					bValid = bValid && checkLength(tket,"Keterangan",3,25);
					bValid = bValid && checkRegexp(tnilai,/^[0-9]+$/,"Nilai harus berupa angka");
					if (bValid) {
						$.ajax({
						    url:'../lib/ajax.php',
                            type:'POST',
                            timeout:10000,
                            dataType: 'json',
                            data:'op=inputgolongan&'+$('#formtambahgolongan').serialize(),
                            success:function(data){
                                if(data.berhasil){
						            updateListGolongan();
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
                        data:'op=deletegolongan&id='+tid,
                        success:function(data){
                            if(data.berhasil){
			                    updateListGolongan();
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
