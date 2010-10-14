<?php
require_once('../../lib/auth.php');
require_once('../../lib/conn.php');
require_once('../../lib/liboperator.php');
auth('input');
if(!empty($_GET['nip'])){
    $nip=$_GET['nip'];
    $dp=getDataPegawaiFoto($nip);
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
        $hobi='';
        foreach($daftarhobi as $brs){
            $hobi.=$brs['hobi'].', ';
        }
    }else{
        echo "Pegawai dengan nip $nip tidak ada";
        die();
    }
}else{
die();
}
require_once('../../lib/PHPExcel.php');
require_once('../../lib/PHPExcel/Cell/AdvancedValueBinder.php');
require_once('../../lib/PHPExcel/IOFactory.php');
// Redirect output to a client’s web browser (Excel5)
$objPHPExcel = PHPExcel_IOFactory::load('template_drh.xls');

$objWorksheet = $objPHPExcel->getActiveSheet();
$objWorksheet->setCellValue('C5',$nip)
             ->setCellValue('C6',$dp['nama'])
             ->setCellValue('C7',$dp['golongan'].' '.$dp['ket'])
             ->setCellValue('C8',$masakerjagolongan)
             ->setCellValue('C9',$masakerjatotal)
             ->setCellValue('C10',$dp['tempat_lahir'].', '.$dp['tgl_lahir'])
             ->setCellValue('C11',$dp['agama'])
             ->setCellValue('C12',($dp['jk']=='P')?'Pria':'Wanita')
             ->setCellValue('C13',$tglcpns)
             ->setCellValue('C14',$tglpns)
             ->setCellValue('C15',$tmt)
             ->setCellValue('C16',$dp['nama_unit_kerja'])
             ->setCellValue('C17',$dp['seksi'])
             ->setCellValue('C18',$dp['jabatan'])
             ->setCellValue('C19',(empty($pnd_terakhir))?'-':$pnd_terakhir['tingkat'].' '.$pnd_terakhir['jurusan'].' '.$pnd_terakhir['nama'].' '.$pnd_terakhir['tahun'].' '.$pnd_terakhir['tempat'])
             ->setCellValue('C20',$dp['jalan'].' '.$dp['kelurahan'].' '.$dp['kecamatan'])
             ->setCellValue('C21',$dp['kabupaten'])
             ->setCellValue('C22',$dp['propinsi'])
             ->setCellValue('C23',$dp['kode_pos'])
             ->setCellValue('C24',$dp['status'])
             ->setCellValue('C25',$dp['status_kawin'])
             ->setCellValue('C26',$dp['keterangan'])
             ->setCellValue('C27',$dp['notelp'])
             ->setCellValue('C29',$hobi)
             ->setCellValue('C30',$dp['tinggi'].' cm')
             ->setCellValue('C31',$dp['berat'].' kg')
             ->setCellValue('C32',$dp['warna_rambut'])
             ->setCellValue('C33',$dp['bentuk_muka'])
             ->setCellValue('C34',$dp['warna_kulit'])
             ->setCellValue('C35',$dp['ciri_khas'])
             ->setCellValue('C36',$dp['cacat_tubuh'])
             ->setCellValue('C39',$dp['pejabat_skkb'])
             ->setCellValue('C40',$dp['no_skkb'])
             ->setCellValue('C41',$dp['tgl_skkb'])
             ->setCellValue('C44',$dp['pejabat_ketsehat'])
             ->setCellValue('C45',$dp['no_ketsehat'])
             ->setCellValue('C46',$dp['tgl_ketsehat']);
             
$objPHPExcel->setActiveSheetIndex(1);
$i=2;
foreach($daftarpendidikan as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['tingkat'])
                                   ->setCellValue('B'.$i,$brs['nama'])
                                   ->setCellValue('C'.$i,$brs['jurusan'])
                                   ->setCellValue('D'.$i,$brs['no_ijazah'])
                                   ->setCellValue('E'.$i,$brs['tahun'])
                                   ->setCellValue('F'.$i,$brs['tempat'])
                                   ->setCellValue('G'.$i,$brs['kepsek']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:G'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(2);
$i=2;
foreach($daftarpelatihan as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['nama'])
                                   ->setCellValue('B'.$i,$brs['tgl_awal'])
                                   ->setCellValue('C'.$i,$brs['tgl_akhir'])
                                   ->setCellValue('D'.$i,$brs['no_tanda_lulus'])
                                   ->setCellValue('E'.$i,$brs['tempat'])
                                   ->setCellValue('F'.$i,$brs['ket']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:F'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(3);
$i=2;
foreach($daftardiklatpeg as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['jenis'])
                                   ->setCellValue('B'.$i,$brs['nama'])
                                   ->setCellValue('C'.$i,$brs['tgl_awal'])
                                   ->setCellValue('D'.$i,$brs['tgl_akhir'])
                                   ->setCellValue('E'.$i,$brs['no_tanda_lulus'])
                                   ->setCellValue('F'.$i,$brs['tempat'])
                                   ->setCellValue('G'.$i,$brs['lama'])
                                   ->setCellValue('H'.$i,$brs['ket']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:H'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(4);
$i=2;
foreach($daftarpenghargaan as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['nama_penghargaan'])
                                   ->setCellValue('B'.$i,$brs['tahun'])
                                   ->setCellValue('C'.$i,$brs['pihak_pemberi']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:C'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(5);
$i=3;
foreach($daftarkepangkatan as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['pangkat'])
                                   ->setCellValue('B'.$i,$brs['golongan'].' '.$brs['ket'])
                                   ->setCellValue('C'.$i,$brs['tanggal_berlaku'])
                                   ->setCellValue('D'.$i,$brs['sk_pejabat'])
                                   ->setCellValue('E'.$i,$brs['sk_nomor'])
                                   ->setCellValue('F'.$i,$brs['sk_tanggal'])
                                   ->setCellValue('G'.$i,$brs['dasar_peraturan']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A3:G'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(6);
$i=3;
foreach($daftarpengalaman as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['pengalaman'])
                                   ->setCellValue('B'.$i,$brs['tgl_mulai'])
                                   ->setCellValue('C'.$i,$brs['tgl_selesai'])
                                   ->setCellValue('D'.$i,$brs['golongan'])
                                   ->setCellValue('E'.$i,$brs['sk_pejabat'])
                                   ->setCellValue('F'.$i,$brs['sk_nomor'])
                                   ->setCellValue('G'.$i,$brs['sk_tanggal']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A3:G'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(7);
$i=2;
foreach($daftarkunjungan as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['negara'])
                                   ->setCellValue('B'.$i,$brs['tujuan'])
                                   ->setCellValue('C'.$i,$brs['tgl_awal'])
                                   ->setCellValue('D'.$i,$brs['tgl_akhir'])
                                   ->setCellValue('E'.$i,$brs['pembiaya']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:E'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(8);
$i=2;
foreach($daftarseminar as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['nama'])
                                   ->setCellValue('B'.$i,$brs['peranan'])
                                   ->setCellValue('C'.$i,$brs['tgl_penyelenggaraan'])
                                   ->setCellValue('D'.$i,$brs['penyelenggara'])
                                   ->setCellValue('E'.$i,$brs['tempat']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:E'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(9);
$i=2;
foreach($daftarpasangan as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['nama'])
                                   ->setCellValue('B'.$i,$brs['tempat_lahir'])
                                   ->setCellValue('C'.$i,$brs['tgl_lahir'])
                                   ->setCellValue('D'.$i,$brs['tgl_menikah'])
                                   ->setCellValue('E'.$i,$brs['pekerjaan'])
                                   ->setCellValue('F'.$i,$brs['keterangan']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:F'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(10);
$i=2;
foreach($daftaranak as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['nama'])
                                   ->setCellValue('B'.$i,($brs['jk']=='P')?'Pria':'Wanita')
                                   ->setCellValue('C'.$i,$brs['tempat_lahir'])
                                   ->setCellValue('D'.$i,$brs['tgl_lahir'])
                                   ->setCellValue('E'.$i,$brs['pekerjaan'])
                                   ->setCellValue('F'.$i,$brs['keterangan']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:F'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(11);
$i=2;
foreach($daftarortu as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['nama'])
                                   ->setCellValue('B'.$i,($brs['jk']=='P')?'Pria':'Wanita')
                                   ->setCellValue('C'.$i,$brs['tgl_lahir'])
                                   ->setCellValue('D'.$i,$brs['pekerjaan'])
                                   ->setCellValue('E'.$i,$brs['keterangan']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:E'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(12);
$i=2;
foreach($daftarmertua as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['nama'])
                                   ->setCellValue('B'.$i,($brs['jk']=='P')?'Pria':'Wanita')
                                   ->setCellValue('C'.$i,$brs['tgl_lahir'])
                                   ->setCellValue('D'.$i,$brs['pekerjaan'])
                                   ->setCellValue('E'.$i,$brs['keterangan']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:E'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(13);
$i=2;
foreach($daftarsaudara as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['nama'])
                                   ->setCellValue('B'.$i,($brs['jk']=='P')?'Pria':'Wanita')
                                   ->setCellValue('C'.$i,$brs['tgl_lahir'])
                                   ->setCellValue('D'.$i,$brs['pekerjaan'])
                                   ->setCellValue('E'.$i,$brs['keterangan']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:E'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(14);
$i=2;
foreach($daftaripar as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['nama'])
                                   ->setCellValue('B'.$i,($brs['jk']=='P')?'Pria':'Wanita')
                                   ->setCellValue('C'.$i,$brs['tgl_lahir'])
                                   ->setCellValue('D'.$i,$brs['pekerjaan'])
                                   ->setCellValue('E'.$i,$brs['keterangan']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:E'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(15);
$i=2;
foreach($daftarorgsma as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['nama'])
                                   ->setCellValue('B'.$i,$brs['kedudukan'])
                                   ->setCellValue('C'.$i,$brs['tahun_awal'])
                                   ->setCellValue('D'.$i,$brs['tahun_akhir'])
                                   ->setCellValue('E'.$i,$brs['tempat'])
                                   ->setCellValue('F'.$i,$brs['nama_pemimpin']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:F'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(16);
$i=2;
foreach($daftarorgpt as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['nama'])
                                   ->setCellValue('B'.$i,$brs['kedudukan'])
                                   ->setCellValue('C'.$i,$brs['tahun_awal'])
                                   ->setCellValue('D'.$i,$brs['tahun_akhir'])
                                   ->setCellValue('E'.$i,$brs['tempat'])
                                   ->setCellValue('F'.$i,$brs['nama_pemimpin']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:F'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(17);
$i=2;
foreach($daftarorgkerja as $brs){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['nama'])
                                   ->setCellValue('B'.$i,$brs['kedudukan'])
                                   ->setCellValue('C'.$i,$brs['tahun_awal'])
                                   ->setCellValue('D'.$i,$brs['tahun_akhir'])
                                   ->setCellValue('E'.$i,$brs['tempat'])
                                   ->setCellValue('F'.$i,$brs['nama_pemimpin']);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('A2:F'.(--$i))->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->setActiveSheetIndex(0);
if($dp['foto']){
    $gdImage=imagecreatefromstring($dp['foto']);
    $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
    $objDrawing->setName('Foto');
    $objDrawing->setDescription('Foto');
    $objDrawing->setImageResource($gdImage);
    $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
    $objDrawing->setMimeType($dp['mime']);
    $objDrawing->setCoordinates('I5');
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
}else{
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Foto');
    $objDrawing->setDescription('Foto');
    $objDrawing->setPath('../../img/nofoto.png');
    $objDrawing->setCoordinates('I5');
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="export drh.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
die();
