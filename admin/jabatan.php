<?php
require_once('../lib/auth.php');
require_once('../lib/conn.php');
require_once('../lib/libadmin.php');
auth('admin');
$dataJabatan=false;
$daftarUnitKerja=getDaftarUnitKerja();
$daftarJabatan=getDaftarJabatanByUnitKerja($daftarUnitKerja[0]['id_unit_kerja']);
if($_GET&&!empty($_GET['eid'])){
    $dataJabatan=getDataJabatan($_GET['eid']);
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
                    <li><a href="diklat.php">Diklat</a></li>
                    <li><div>Jabatan</div></li>
                    <li><a href="../login.php?a=logout" id="logout">Logout</a></li>
                </ul>
            </div>
            <div id="isi">
                <h2>Manajemen Jabatan</h2>
                <form id="formeditjabatan" action="jabatan.php" method="post">
                    <fieldset id="pnljabatan">
                    <legend>Data Jabatan</legend>
                    <input type="hidden" value="<?php echo ($dataJabatan)?$dataJabatan['id_jabatan']:''; ?>" name="id" id="id" />
                    <label for="unitkerja">Unit Kerja</label>
                    <select name="unitkerja" id="unitkerja">
                        <?php foreach($daftarUnitKerja as $brs): ?>
                        <option value="<?php echo $brs['id_unit_kerja']; ?>"><?php echo $brs['nama']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="seksi">Seksi</label>
                    <input type="text" name="seksi" id="seksi" size="35" maxlength="80" value="<?php echo ($dataJabatan)?$dataJabatan['unit_kerja']:''; ?>">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" size="25" maxlength="80" value="<?php echo ($dataJabatan)?$dataJabatan['jabatan']:''; ?>">
                    <label for="eselon">Eselon</label>
                    <input type="text" name="eselon" id="eselon" size="5" maxlength="10" value="<?php echo ($dataJabatan)?$dataJabatan['eselon']:''; ?>">
                    <input type="submit" value="Update" id="updatejabatan" name="updatejabatan" class="tombol" />
                    <input type="button" value="Batal" id="batal" class="tombol" />
                    </fieldset>

                    <fieldset>
                    <legend>Daftar Jabatan</legend>
                        <label for="cunitkerja">UnitKerja</label>
                        <select name="cunitkerja" id="cunitkerja">
                            <?php foreach($daftarUnitKerja as $brs): ?>
                            <option value="<?php echo $brs['id_unit_kerja']; ?>"><?php echo $brs['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br/><br/>
                        <table id="daftarjabatan">
                            <thead>
                                <tr><th>Seksi</th><th>Jabatan</th><th>Eselon</th><th>Operasi</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach($daftarJabatan as $brs): ?>
                                <tr>
                                    <td><?php echo $brs['seksi']; ?></td>
                                    <td><?php echo $brs['jabatan']; ?></td>
                                    <td><?php echo $brs['eselon']; ?></td>
                                    <td>
                                        <a href="?eid=<?php echo $brs['id_jabatan']; ?>">Edit</a> &nbsp;
                                        <a href="?did=<?php echo $brs['id_jabatan']; ?>">Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <br/>
                        <input type="button" value="Tambah Jabatan" id="tambahjabatan" class="tombol" />
                        </fieldset>
                </form>
            </div>
        </div>
        <div id="footer"> 2010 &copy; Dinas Perhubungan Jawa Barat </div>
    </div>
    <div id="dialog-form" title="Tambah Jabatan baru">
        <p class="validateTips">Isi semua field.</p>
        <form id="formtambahjabatan">
        <fieldset>
            <label for="tseksi">Seksi</label>
            <input type="text" name="tseksi" id="tseksi" size="35" maxlength="80" />
            <label for="tjabatan">Jabatan</label>
            <input type="text" name="tjabatan" id="tjabatan" size="25" maxlength="40" />
            <label for="teselon">Eselon</label>
            <input type="text" name="teselon" id="teselon" size="5" maxlength="10" />
        </fieldset>
        </form>
    </div>
    <div id="dialog-confirm" title="Delete Jabatan">
	    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Apakah anda yakin menghapus jabatan <span id="namahapus"></span> ?</p>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.bgiframe-2.1.1.js"></script>
<script type="text/javascript">
    $(function() {
        var isiPesan=$('#isipesan'),pnlPesan=$('#pnlpesan'),ttpPesan=$('#pnlpesan a.close'),cunitkerja=$('#cunitkerja'),
            tabelJabatan=$('#daftarjabatan'),pnlJabatan=$('#pnljabatan'),
            id=$('#id'),unitkerja=$('#unitkerja'),seksi=$('#seksi'),jabatan=$('#jabatan'),eselon=$('#eselon'),
            tnama,tid,
            btnTambahJabatan=$('#tambahjabatan'),btnUpdate=$('#updatejabatan');

        $('tbody tr:odd').css('background-color','#b6d7e7');
        $('#batal').click(function(){
            id.val('');
            seksi.val('');
            jabatan.val('');
            eselon.val('');
            pnlJabatan.fadeOut('slow');
            updatePesan('Batal mengedit jabatan');
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
        cunitkerja.change(function(){
            //console.log('berubah '+$(this).val());
            pnlJabatan.fadeOut('slow');
            updateListJabatan();
        });
	    function updateListJabatan(){
            $.ajax({
                url:'../lib/ajax.php?op=listjabatan&unitkerja='+cunitkerja.val(),
                type:'GET',
                timeout:10000,
                dataType: 'json',
                success:function(data){
                        var tbhtbl=$('#daftarjabatan tbody');
                        tbhtbl.children().remove();
                        for(var i=0;i<data.length;i++){
                            tbhtbl.append('<tr>' +
                            '<td>' + data[i].seksi + '</td>' +
                            '<td>' + data[i].jabatan + '</td>' +
				            '<td>' + data[i].eselon + '</td>' +
				            '<td><a href="?eid='+data[i].id_jabatan+'">Edit</a> &nbsp; <a href="?did='+data[i].id_jabatan+'">Delete</a></td>' +
				            '</tr>');
                        }
                        $('tbody tr:odd').css('background-color','#b6d7e7');
                },
                error:function(e){
                    updatePesan('Terjadi kesalahan koneksi');
                }
            });
	    }

        tabelJabatan.click(function(e){
            var trg=$(e.target);
            if(trg.attr('href')){
                var id_jabatan=parseInt(trg.attr('href').match(/\d+$/),10),
                    nm_seksi=trg.parents('tr').children().eq(0).text(),
                    nm_jabatan=trg.parents('tr').children().eq(1).text(),
                    nm_eselon=trg.parents('tr').children().eq(2).text();
                    //console.log(id_jabatan+' : '+unit_kerja+' : '+nm_jabatan+' : '+nm_eselon);
                if(trg.html()=='Edit'){
                    id.val(id_jabatan);
                    unitkerja.val(cunitkerja.val());
                    seksi.val(nm_seksi);
                    jabatan.val(nm_jabatan);
                    eselon.val(nm_eselon);
                    pnlJabatan.fadeIn('slow');
                    $('body').scrollTop(0);
                    $('html').scrollTop(0);
                    updatePesan('Mengedit jabatan '+nm_jabatan);
                }else if(trg.html()=='Delete'){
                    tnama=nm_jabatan;
                    tid=id_jabatan;
                    $('#namahapus').text(tnama);
                    pnlJabatan.fadeOut('slow');
                    $("#dialog-confirm").dialog('open');
                }
            }
            return false;
        });

        pnlJabatan.hide();
        btnTambahJabatan.click(function(){
            updatePesan('Tambah jabatan baru');
            pnlJabatan.fadeOut('slow');
            $('#dialog-form').dialog('open');
        });

        btnUpdate.click(function(){
            var pnj=seksi.val().trim().length,pnjJbtn=jabatan.val().trim().length,pnjEselon=eselon.val().trim().length;
            if(pnj<0||pnj>80){
                updatePesan('Panjang seksi antara 0 - 80 karakter');
                seksi.focus();
                return false;
            }
            if(pnjJbtn<4||pnjJbtn>80){
                updatePesan('Panjang jabatan antara 4 - 80 karakter');
                jabatan.focus();
                return false;
            }
            if(pnjEselon<0||pnjEselon>10){
                updatePesan('Panjang eselon antara 0 - 10 karakter');
                eselon.focus();
                return false;
            }
            if(!/^\d*$/.test(eselon.val())){
                updatePesan('Eselon harus berupa digit');
                eselon.focus();
                return false;
            }
            //console.log($('#formeditjabatan').serialize());
			$.ajax({
			    url:'../lib/ajax.php',
                type:'POST',
                timeout:10000,
                dataType: 'json',
                data:'op=updatejabatan&'+$('#formeditjabatan').serialize(),
                success:function(data){
                    if(data.berhasil){
			            updateListJabatan();
                        updatePesan(data.pesan);
                    }else{
                        updatePesan(data.pesan);
                    }
                },
                error:function(e){
                    updatePesan('Terjadi kesalahan koneksi');
                }
			});
            pnlJabatan.fadeOut('slow');
            return false;
        });

//code dialog form
		var tseksi = $("#tseksi"),
		    tjabatan = $('#tjabatan'),
		    teselon = $('#teselon'),
			allFields = $([]).add(tseksi).add(tjabatan).add(teselon),
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
				updateTips("Panjang " + n + " harus diantara "+min+" dan "+max+".");
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
			height: 400,
			width: 380,
			modal: true,
			buttons: {
				'Tambah UnitKerja': function() {
					var bValid = true;
					allFields.removeClass('ui-state-error');
					bValid = bValid && checkLength(tseksi,"Seksi",0,80);
					bValid = bValid && checkLength(tjabatan,"Jabatan",4,80);
					bValid = bValid && checkLength(teselon,"Eselon",0,10);
					bValid = bValid && checkRegexp(teselon,/^\d*$/,"Eselon harus berupa digit");
					//console.log($('#formtambahjabatan').serialize()+'unitkerja='+cunitkerja.val())
					if (bValid) {
						$.ajax({
						    url:'../lib/ajax.php',
                            type:'POST',
                            timeout:10000,
                            dataType: 'json',
                            data:'op=inputjabatan&'+$('#formtambahjabatan').serialize()+'&unitkerja='+cunitkerja.val(),
                            success:function(data){
                                if(data.berhasil){
						            updateListJabatan();
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
                        data:'op=deletejabatan&id='+tid,
                        success:function(data){
                            if(data.berhasil){
			                    updateListJabatan();
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
