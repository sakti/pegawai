<?php
require_once('../lib/auth.php');
require_once('../lib/conn.php');
require_once('../lib/libadmin.php');
auth('admin');
$dataunitkerja=false;
$daftarunitkerja=getDaftarUnitKerja();
if($_GET&&!empty($_GET['eid'])){
    $dataunitkerja=getDataUnitKerja($_GET['eid']);
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
                    <li><div>Unit Kerja</div></li>
                    <li><a href="golongan.php">Golongan</a></li>
                    <li><a href="diklat.php">Diklat</a></li>
                    <li><a href="jabatan.php">Jabatan</a></li>
                    <li><a href="../login.php?a=logout" id="logout">Logout</a></li>
                </ul>
            </div>
            <div id="isi">
                <h2>Manajemen Unit Kerja</h2>
                <form id="formeditunitkerja" action="unitkerja.php" method="post">
                    <fieldset id="pnlunitkerja">
                    <legend>Data Unit Kerja</legend>
                    <input type="hidden" value="<?php echo ($dataunitkerja)?$dataunitkerja['id_unit_kerja']:''; ?>" name="id" id="id" />
                    <label for="nama">Nama Unit Kerja</label><input type="text" name="nama" id="nama" size="60" maxlength="100" value="<?php echo ($dataunitkerja)?$dataunitkerja['nama']:''; ?>">
                    <input type="submit" value="Update" id="updateunitkerja" name="updateunitkerja" class="tombol" />
                    <input type="button" value="Batal" id="batal" class="tombol" />
                    </fieldset>
                    
                    <fieldset>
                    <legend>Daftar unit kerja</legend>
                        <table id="daftarunitkerja">
                            <thead>
                                <tr><th>Nama Unit Kerja</th><th>Operasi</th></tr>
                            </thead>
                            <tbody> 
                                <?php foreach($daftarunitkerja as $brs): ?>
                                <tr><td><?php echo $brs['nama']; ?></td><td><a href="?eid=<?php echo $brs['id_unit_kerja']; ?>">Edit</a> &nbsp; <a href="?did=<?php echo $brs['id_unit_kerja']; ?>">Delete</a></td></tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <input type="button" value="Tambah Unit Kerja" id="tambahunitkerja" class="tombol" />
                        </fieldset>
                        <br/><br/><br/>
                </form>
            </div>
        </div>
        <div id="footer"> 2010 &copy; Dinas Perhubungan Jawa Barat </div>
    </div>
    <div id="dialog-form" title="Tambah Unit Kerja baru">
        <p class="validateTips">Isi nama unitkerja.</p>
        <form id="formtambahunitkerja">
        <fieldset>
            <label for="tname">Nama Unit Kerja</label>
            <input type="text" name="tname" id="tname" size="40" maxlength="100"/>
        </fieldset>
        </form>
    </div>
    <div id="dialog-confirm" title="Delete unit kerja"> 
	    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Apakah anda yakin menghapus unit kerja dengan nama <span id="namahapus"></span> ?</p> 
    </div> 
</body>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.bgiframe-2.1.1.js"></script>
<script type="text/javascript">
    $(function() {
        var isiPesan=$('#isipesan'),pnlPesan=$('#pnlpesan'),ttpPesan=$('#pnlpesan a.close'),tabelunitkerja=$('#daftarunitkerja'),id=$('#id'),
            nama=$('#nama'),pnlunitkerja=$('#pnlunitkerja'),tnama,tid,btnTambahunitkerja=$('#tambahunitkerja'),btnUpdate=$('#updateunitkerja');
        $('tbody tr:odd').css('background-color','#b6d7e7');
        $('#batal').click(function(){
            id.val('');
            nama.val('');
            pnlunitkerja.fadeOut('slow');
            updatePesan('Batal mengedit unit kerja');
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
        tabelunitkerja.click(function(e){
            var trg=$(e.target);
            if(trg.attr('href')){
                var id_unitkerja=parseInt(trg.attr('href').match(/\d+$/),10),
                    nama_unitkerja=trg.parents('tr').children().eq(0).text();
                if(trg.html()=='Edit'){
                    id.val(id_unitkerja);
                    nama.val(nama_unitkerja);
                    pnlunitkerja.fadeIn('slow');
                    $('body').scrollTop(0);
                    $('html').scrollTop(0);
                    updatePesan('Mengedit unit kerja '+nama_unitkerja);
                }else if(trg.html()=='Delete'){
                    tnama=nama_unitkerja;
                    tid=id_unitkerja;
                    $('#namahapus').text(tnama);
                    pnlunitkerja.fadeOut('slow')
                    $("#dialog-confirm").dialog('open');
                }
            }
            return false;
        });

	    function updateListUnitKerja(){
            $.ajax({
                url:'../lib/ajax.php?op=listunitkerja',
                type:'GET',
                timeout:10000,
                dataType: 'json',
                success:function(data){
                        var tbhtbl=$('#daftarunitkerja tbody');
                        tbhtbl.children().remove();
                        for(var i=0;i<data.length;i++){
                            tbhtbl.append('<tr>' +
				            '<td>' + data[i].nama + '</td>' + 
				            '<td><a href="?eid='+data[i].id_unit_kerja+'">Edit</a> &nbsp; <a href="?did='+data[i].id_unit_kerja+'">Delete</a></td>' +
				            '</tr>'); 
                        }
                        $('tbody tr:odd').css('background-color','#b6d7e7');
                },
                error:function(e){                   
                    updatePesan('Terjadi kesalahan koneksi');
                }
            });	
	    }
	    
        pnlunitkerja.hide();
        btnTambahunitkerja.click(function(){
            updatePesan('Tambah unit kerja baru');
            pnlunitkerja.fadeOut('slow')
            $('#dialog-form').dialog('open');
        });

        btnUpdate.click(function(){
            var pnj=nama.val().length;
            if(pnj<5||pnj>100){
                updatePesan('Panjang nama unitkerja harus lebih dari 5 dan kurang dari 100 karakter');
                return false;
            }
			$.ajax({
			    url:'../lib/ajax.php',
                type:'POST',
                timeout:10000,
                dataType: 'json',
                data:'op=updateunitkerja&'+$('#formeditunitkerja').serialize(),
                success:function(data){
                    if(data.berhasil){
			            updateListUnitKerja();
                        updatePesan(data.pesan);
                    }else{
                        updatePesan(data.pesan);
                    }
                },
                error:function(e){                    
                    updatePesan('Terjadi kesalahan koneksi');
                }
			});
            pnlunitkerja.fadeOut('slow');
            return false;
        });
        
//code dialog form
		var tname = $("#tname"),
			allFields = $([]).add(tname),
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
		
		$("#dialog-form").dialog({
			autoOpen: false,
			height: 250,
			width: 450,
			modal: true,
			buttons: {
				'Tambah unitkerja': function() {
					var bValid = true;
					allFields.removeClass('ui-state-error');
					bValid = bValid && checkLength(tname,"Nama unitkerja",5,100);
					if (bValid) {
						$.ajax({
						    url:'../lib/ajax.php',
                            type:'POST',
                            timeout:10000,
                            dataType: 'json',
                            data:'op=inputunitkerja&'+$('#formtambahunitkerja').serialize(),
                            success:function(data){
                                if(data.berhasil){
						            tabelunitkerja.children('tbody').append('<tr>' +
							            '<td>' + tname.val() + '</td>' + 
							            '<td><a href="?eid='+data.id_unit_kerja+'">Edit</a> &nbsp; <a href="?did='+data.id_unit_kerja+'">Delete</a</td>' +
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
                        data:'op=deleteunitkerja&id='+tid,
                        success:function(data){
                            if(data.berhasil){
			                    updateListUnitKerja();
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
