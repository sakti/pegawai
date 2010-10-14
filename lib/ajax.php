<?php
session_start();
header('Content-type: text/javascript');
require_once('conn.php');
require_once('libadmin.php');
require_once('liboperator.php');
if(!empty($_REQUEST['op'])){
    switch($_REQUEST['op']){
        case 'getnama':
            if(!empty($_REQUEST['nip'])){
                $hasil=getNamaByNip($_REQUEST['nip']);
                echo json_encode($hasil);
            }
            break;
        case 'listkat':
            if(!empty($_REQUEST['kat'])){
                $hasil=getListKat($_REQUEST['kat']);
                echo json_encode($hasil);
            }
            break;
        case 'listunitkerja':
            $hasil=getDaftarUnitKerja();
            echo json_encode($hasil);
            break;
        case 'listgolongan':
            $hasil=getDaftarGolongan();
            echo json_encode($hasil);
            break;
        case 'listdiklat':
            $hasil=getDaftarDiklat();
            echo json_encode($hasil);
            break;
        case 'listdiklatbykat':
            if(!empty($_REQUEST['kat'])){
                $hasil=getDaftarDiklatByKat($_REQUEST['kat']);
                echo json_encode($hasil);
            }
            break;
        case 'listjabatan':
            if(!empty($_REQUEST['unitkerja'])){
                $hasil=getDaftarJabatanByUnitKerja($_REQUEST['unitkerja']);
            }else{
                $hasil=getDaftarJabatan();
            }
            echo json_encode($hasil);
            break;
        case 'listseksi':
            if(!empty($_REQUEST['unitkerja'])){
                $hasil=getDaftarSeksiByUnitKerja($_REQUEST['unitkerja']);
                echo json_encode($hasil);
            }
            break;
        case 'listjabatanbysuk':
            if(!empty($_REQUEST['unitkerja'])&&isset($_REQUEST['seksi'])){
                $hasil=getDaftarJabatanBySUK($_REQUEST['unitkerja'],$_REQUEST['seksi']);
                echo json_encode($hasil);
            }
            break;
        case 'ceknippegawai':
            if(!empty($_REQUEST['nip'])){
                echo json_encode(!cekNipPegawai($_REQUEST['nip']));
            }
            break;
        case 'notceknippegawai':
            if(!empty($_REQUEST['snip'])){
                echo json_encode(cekNipPegawai($_REQUEST['snip']));
            }
            break;
    }
    if(!empty($_SESSION['priv']))
    switch($_SESSION['priv']){
        case 'admin':
            switch($_REQUEST['op']){
                //menu user
                case 'inputuser':
                    if(!empty($_REQUEST['tname'])&&!empty($_REQUEST['tpassword'])&&!empty($_REQUEST['tpriv'])){
                        $hasil=tambahPengguna($_REQUEST['tname'],$_REQUEST['tpassword'],$_REQUEST['tpriv']);
                        echo json_encode($hasil);
                    }
                    break;
                case 'updateuser':
                    if(!empty($_REQUEST['userid'])&&!empty($_REQUEST['hakakses'])){
                        $hasil=updatePengguna($_REQUEST['userid'],$_REQUEST['password'],$_REQUEST['hakakses']);
                        echo json_encode($hasil);
                    }
                    break;
                case 'deleteuser':
                    if(!empty($_REQUEST['userid'])){
                        $hasil=deletePengguna($_REQUEST['userid']);
                        echo json_encode($hasil);
                    }
                    break;
                case 'listuser':
                    $hasil=getDaftarUser();
                    echo json_encode($hasil);
                    break;
                //menu unitkerja
                case 'inputunitkerja':
                    if(!empty($_REQUEST['tname'])){
                        $hasil=tambahUnitKerja($_REQUEST['tname']);
                        echo json_encode($hasil);
                    }
                    break;
                case 'updateunitkerja':
                    if(!empty($_REQUEST['id'])&&!empty($_REQUEST['nama'])){
                        $hasil=updateUnitKerja($_REQUEST['id'],$_REQUEST['nama']);
                        echo json_encode($hasil);
                    }
                    break;
                case 'deleteunitkerja':
                    if(!empty($_REQUEST['id'])){
                        $hasil=deleteUnitKerja($_REQUEST['id']);
                        echo json_encode($hasil);
                    }
                    break;
                case 'inputgolongan':
                    if(!empty($_REQUEST['tgolongan'])&&!empty($_REQUEST['tket'])&&!empty($_REQUEST['tnilai'])){
                        $hasil=tambahGolongan($_REQUEST['tgolongan'],$_REQUEST['tket'],$_REQUEST['tnilai']);
                        echo json_encode($hasil);
                    }
                    break;
                case 'updategolongan':
                    if(!empty($_REQUEST['id'])&&!empty($_REQUEST['golongan'])&&!empty($_REQUEST['ket'])&&!empty($_REQUEST['nilai'])){
                        $hasil=updateGolongan($_REQUEST['id'],$_REQUEST['golongan'],$_REQUEST['ket'],$_REQUEST['nilai']);
                        echo json_encode($hasil);
                    }
                    break;
                case 'deletegolongan':
                    if(!empty($_REQUEST['id'])){
                        $hasil=deleteGolongan($_REQUEST['id']);
                        echo json_encode($hasil);
                    }
                case 'inputdiklat':
                    if(!empty($_REQUEST['tjenis'])&&!empty($_REQUEST['tnama'])){
                        $hasil=tambahDiklat($_REQUEST['tjenis'],$_REQUEST['tnama']);
                        echo json_encode($hasil);
                    }
                    break;
                case 'updatediklat':
                    if(!empty($_REQUEST['id'])&&!empty($_REQUEST['jenis'])&&!empty($_REQUEST['nama'])){
                        $hasil=updateDiklat($_REQUEST['id'],$_REQUEST['jenis'],$_REQUEST['nama']);
                        echo json_encode($hasil);
                    }
                    break;
                case 'deletediklat':
                    if(!empty($_REQUEST['id'])){
                        $hasil=deleteDiklat($_REQUEST['id']);
                        echo json_encode($hasil);
                    }

                case 'inputjabatan':
                    if(!empty($_REQUEST['unitkerja'])&&isset($_REQUEST['tseksi'])&&!empty($_REQUEST['tjabatan'])&&isset($_REQUEST['teselon'])){
                        $hasil=tambahJabatan($_REQUEST['unitkerja'],$_REQUEST['tseksi'],$_REQUEST['tjabatan'],$_REQUEST['teselon']);
                        echo json_encode($hasil);
                    }
                    break;
                case 'updatejabatan':
                    if(!empty($_REQUEST['id'])&&!empty($_REQUEST['unitkerja'])&&isset($_REQUEST['seksi'])&&!empty($_REQUEST['jabatan'])&&isset($_REQUEST['eselon'])){
                        $hasil=updateJabatan($_REQUEST['id'],$_REQUEST['unitkerja'],$_REQUEST['seksi'],$_REQUEST['jabatan'],$_REQUEST['eselon']);
                        echo json_encode($hasil);
                    }
                    break;
                case 'deletejabatan':
                    if(!empty($_REQUEST['id'])){
                        $hasil=deleteJabatan($_REQUEST['id']);
                        echo json_encode($hasil);
                    }
            }
            break;
        case 'input':
            switch($_REQUEST['op']){
                case 'x':
                    echo 'x';
                    break;
                case 'insertpegawai':
                    $hasil=tambahPegawai($_POST);
                    echo json_encode($hasil);
                    break;
                case 'updatepegawai':
                    $hasil=updatePegawai($_POST);
                    echo json_encode($hasil);
                    break;
                case 'inputjabatan':
                    if(!empty($_REQUEST['unitkerja'])&&isset($_REQUEST['tseksi'])&&!empty($_REQUEST['tjabatan'])&&isset($_REQUEST['teselon'])){
                        $hasil=tambahJabatan($_REQUEST['unitkerja'],$_REQUEST['tseksi'],$_REQUEST['tjabatan'],$_REQUEST['teselon']);
                        echo json_encode($hasil);
                    }
                    break;
                case 'inputdiklat':
                    if(!empty($_REQUEST['tjenis'])&&!empty($_REQUEST['tnama'])){
                        $hasil=tambahDiklat($_REQUEST['tjenis'],$_REQUEST['tnama']);
                        echo json_encode($hasil);
                    }
                    break;
            }
            break;
        case 'baca':
            switch($_REQUEST['op']){
                case 'y':
                    echo 'y';
                    break;
            }
            break;
    }
}else{
    print_r($_SESSION);
}

