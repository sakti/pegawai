<?php
require_once('../lib/PHPExcel.php');
require_once('../lib/auth.php');
require_once('../lib/conn.php');
require_once('../lib/liboperator.php');
require_once('../lib/PHPExcel/Cell/AdvancedValueBinder.php');
require_once('../lib/PHPExcel/IOFactory.php');

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
auth('operator');
if(!empty($_GET['filter'])){
    //echo "<h1>{$_GET['filter']}</h1>";
    $filter=$_GET['filter'];
}else{
    $filter='';
}

$data=getDaftarPegawai(0,0,$filter);
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("DISHUB JABAR by SDC")
							 ->setLastModifiedBy("Dinas Perhubungan Jawa Barat")
							 ->setTitle("Export data pegawai")
							 ->setSubject("aplikasi data kepegawaian dishub jabar")
							 ->setDescription("Export data kepegawaian dari database.")
							 ->setKeywords("dishub jabar kepegawaian")
							 ->setCategory("file export");

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Export Data Kepegawaian');

$objPHPExcel->getActiveSheet()->setCellValue('A3','NIP')
                               ->setCellValue('B3','Nama Pegawai')
                               ->setCellValue('C3','Golongan')
                               ->setCellValue('D3','Ket. Gol.')
                               ->setCellValue('E3','Tempat Lahir')
                               ->setCellValue('F3','Tgl Lahir')
                               ->setCellValue('G3','JK')
                               ->setCellValue('H3','Agama')
                               ->setCellValue('I3','Kepercayaan')
                               ->setCellValue('J3','Pendidikan Terakhir')
                               ->setCellValue('K3','Diklat')
                               ->setCellValue('L3','Status')
                               ->setCellValue('M3','Status Perkawinan')
                               ->setCellValue('N3','No Telp')
                               ->setCellValue('O3','Alamat')
                               ->setCellValue('P3','Unit Kerja')
                               ->setCellValue('Q3','Seksi')
                               ->setCellValue('R3','Jabatan')
                               ->setCellValue('S3','Eselon')
                               ->setCellValue('T3','Penghargaan')
                               ->setCellValue('U3','Keterangan');
$i=4;

foreach($data['hasil'] as $brs){
    $pnd_terakhir=getPendidikanTerakhir($brs['id_pegawai']);
    $tmp_dft_diklat=getDaftarDiklatPeg($brs['id_pegawai']);
    $tmp_dft_phrgn=getDaftarPenghargaanPeg($brs['id_pegawai']);
    $diklat='';$penghargaan='';$pendidikan='';
    foreach($tmp_dft_diklat as $brs2){
        $diklat.="{$brs2['nama']} {$brs2['tempat']} {$brs2['lama']} jam, {$brs2['tgl_awal']} ({$brs2['jenis']}) {$brs2['ket']}\n";
    }
    foreach($tmp_dft_phrgn as $brs2){
        $penghargaan.="{$brs2['nama_penghargaan']}, {$brs2['pihak_pemberi']} ({$brs2['tahun']})\n";
    }
    if(!empty($pnd_terakhir['tingkat'])){
        $pendidikan=$pnd_terakhir['tingkat'].' '.$pnd_terakhir['jurusan'].' '.$pnd_terakhir['nama'].' ('.$pnd_terakhir['tahun'].'), '.$pnd_terakhir['tempat'];
    }
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$brs['nip'])
                                   ->setCellValue('B'.$i,$brs['nama'])
                                   ->setCellValue('C'.$i,$brs['golongan'])
                                   ->setCellValue('D'.$i,$brs['ket'])
                                   ->setCellValue('E'.$i,$brs['tempat_lahir'])
                                   ->setCellValue('F'.$i,$brs['tgl_lahir'])
                                   ->setCellValue('G'.$i,$brs['jk'])
                                   ->setCellValue('H'.$i,$brs['agama'])
                                   ->setCellValue('I'.$i,$brs['kepercayaan'])
                                   ->setCellValue('J'.$i,$pendidikan)
                                   ->setCellValue('K'.$i,$diklat)
                                   ->setCellValue('L'.$i,$brs['status'])
                                   ->setCellValue('M'.$i,$brs['status_kawin'])
                                   ->setCellValue('N'.$i,$brs['notelp'])
                                   ->setCellValue('O'.$i,$brs['jalan'].", ".$brs['kelurahan'].", ".$brs['kabupaten'].", ".$brs['propinsi']."\n".$brs['kode_pos'])
                                   ->setCellValue('P'.$i,$brs['nama_unit_kerja'])
                                   ->setCellValue('Q'.$i,$brs['seksi'])
                                   ->setCellValue('R'.$i,$brs['jabatan'])
                                   ->setCellValue('S'.$i,$brs['eselon'])
                                   ->setCellValue('T'.$i,$penghargaan)
                                   ->setCellValue('U'.$i,$brs['keterangan']);
                                   $i++;
}

$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(30);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('A1:U1');
$objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);

$objPHPExcel->getActiveSheet()->getStyle('A3:U3')->applyFromArray(
		array(
			'font'    => array(
				'bold'      => true,
				'size'      => 14
			),
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			),
			'fill' => array(
	 			'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 			'startcolor' => array(
	 				'argb' => 'FFCCCCCC'
	 			)
	 		)
		)
);
$i--;
$objPHPExcel->getActiveSheet()->getStyle('A4:U'.$i)->applyFromArray(
		array(
			'borders' => array(
				'allborders'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			),
			'fill' => array(
	 			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	  			'rotation'   => 90,
	 			'startcolor' => array(
	 				'argb' => 'FFA0A0A0'
	 			),
	 			'endcolor'   => array(
	 				'argb' => 'FFFFFFFF'
	 			)
	 		)
		)
);
$a=ord('A');
$q=ord('U');
for($i=$a;$i<=$q;$i++){
    $objPHPExcel->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
}

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('export data');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="export_kepegawaian.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
