<?php
$d1=query("select 
a.nama,a.status, a.id_pegawai,
c.eselon,e.golongan,e.nilai,
b.tingkat,d.nama nama_unit, 
c.jabatan,c.seksi
from umum a left join
(select id_pegawai, tingkat from (select id_pegawai,tahun,tingkat from pendidikan order by tahun desc) a group by id_pegawai) b
on a.id_pegawai=b.id_pegawai,  jenis_jabatan c, unit_kerja d, golongan e
where
a.id_jabatan=c.id_jabatan and c.id_unit_kerja=d.id_unit_kerja and
(a.status='CPNS' or a.status='PNS') and
a.id_golongan=e.id_golongan");
$data1=array();
$total=$pns=$cpns=0;
$pnddkn=array("SD","SMP","SMA","SMK","D1","D2","D3","D4","S1","S2","S3");
$eselon=array(2,3,4);
foreach($d1 as $brs){
    if(!isset($data1[$brs['nama_unit']])){
        $data1[$brs['nama_unit']]=array();
    }
    if(!empty($brs['seksi'])){
        $data1[$brs['nama_unit'].'::'.$brs['seksi']]=array();
    }
    if($brs['status']=='PNS'){
        $pns++;
    }else{
        $cpns++;
    }
    $total++;
}
foreach($pnddkn as $nilai){
    foreach($data1 as &$brs){
        if(!isset($brs[$nilai])) $brs[$nilai]=0;
    }
}
foreach($eselon as $nilai){
    foreach($data1 as &$x){
        if(!isset($x[$nilai])) $x[$nilai]=0;
    }
}
foreach($d1 as $a){
    if($a['tingkat']){
       $data1[$a['nama_unit']][$a['tingkat']]++;
       if(!empty($a['seksi'])){
            $data1[$a['nama_unit'].'::'.$a['seksi']][$a['tingkat']]++;
       }
    }
    if($a['eselon']){
        $data1[$a['nama_unit']][$a['eselon']]++;
        if(!empty($a['seksi'])){
            $data1[$a['nama_unit'].'::'.$a['seksi']][$a['eselon']]++;
        }
    }
}

ksort($data1);
/*
echo '<pre>';
var_dump($data1);
echo '</pre>';

die();
*/
$judul="Komposisi Pegawai Menurut Pendidikan\n";
$judul.="DILINGKUNGAN DINAS PERHUBUNGAN PROPINSI JAWA BARAT\nPERIODE ".date('F')." ".date('Y');

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("DISHUB JABAR by SDC")
							 ->setLastModifiedBy("Dinas Perhubungan Jawa Barat")
							 ->setTitle("Export data pegawai")
							 ->setSubject("aplikasi data kepegawaian dishub jabar")
							 ->setDescription("Laporan data kepegawaian dari database.")
							 ->setKeywords("dishub jabar kepegawaian")
							 ->setCategory("file report/laporan");
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', $judul);

$objPHPExcel->getActiveSheet()->setCellValue('A3','No')
                               ->setCellValue('B3','Unit Kerja')
                               ->setCellValue('C3','Pendidikan')
                               ->setCellValue('C4','S3')
                               ->setCellValue('D4','S2')
                               ->setCellValue('E4','S1')
                               ->setCellValue('F4','D4')
                               ->setCellValue('G4','D3')
                               ->setCellValue('H4','D2')
                               ->setCellValue('I4','D1')
                               ->setCellValue('J4','SMA')
                               ->setCellValue('K4','SMK')
                               ->setCellValue('L4','SMP')
                               ->setCellValue('M4','SD')
                               ->setCellValue('N4','JML')
                               ->setCellValue('O3','ESELON')
                               ->setCellValue('O4','2')
                               ->setCellValue('P4','3')
                               ->setCellValue('Q4','4');
                               
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('A1:Q1');
$objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
$objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
$objPHPExcel->getActiveSheet()->mergeCells('C3:N3');
$objPHPExcel->getActiveSheet()->mergeCells('O3:Q3');
$objPHPExcel->getActiveSheet()->getStyle('A1:Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A3:B4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A3:Q4')->applyFromArray(
		array(
			'font'    => array(
				'bold'      => true
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
$i=1;
foreach($data1 as $key => $hsl){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.(4+$i),$i)
                                       ->setCellValue('B'.(4+$i),substr($key,strpos($key,'::')))
                                       ->setCellValue('C'.(4+$i),$hsl['S3'])
                                       ->setCellValue('D'.(4+$i),$hsl['S2'])
                                       ->setCellValue('E'.(4+$i),$hsl['S1'])
                                       ->setCellValue('F'.(4+$i),$hsl['D4'])
                                       ->setCellValue('G'.(4+$i),$hsl['D3'])
                                       ->setCellValue('H'.(4+$i),$hsl['D2'])
                                       ->setCellValue('I'.(4+$i),$hsl['D1'])
                                       ->setCellValue('J'.(4+$i),$hsl['SMA'])
                                       ->setCellValue('K'.(4+$i),$hsl['SMK'])
                                       ->setCellValue('L'.(4+$i),$hsl['SMP'])
                                       ->setCellValue('M'.(4+$i),$hsl['SD'])
                                       ->setCellValue('N'.(4+$i),'=SUM(C'.(4+$i).':M'.(4+$i).')')
                                       ->setCellValue('O'.(4+$i),$hsl['2'])
                                       ->setCellValue('P'.(4+$i),$hsl['3'])
                                       ->setCellValue('Q'.(4+$i),$hsl['4']);
                                       $i++;
}
$i--;
$objPHPExcel->getActiveSheet()->getStyle('A5:Q'.(4+$i))->applyFromArray(
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
$i+=2;
$objPHPExcel->getActiveSheet()->setCellValue('B'.(4+$i),'Keterangan : ')
                              ->setCellValue('B'.(5+$i),"Jumlah Pegawai = $total")
                              ->setCellValue('B'.(6+$i),"-PNS = $pns")
                              ->setCellValue('B'.(7+$i),"-CPNS = $cpns");
$a=ord('A');
$q=ord('Q');
for($i=$a;$i<=$q;$i++){
    $objPHPExcel->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
}
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Laporan');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="laporan.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
die();
