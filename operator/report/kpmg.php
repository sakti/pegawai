<?php
//error_reporting(0);
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
$gol=array('I/A','I/B','I/C','I/D','II/A','II/B','II/C','II/D','III/A','III/B','III/C','III/D','IV/A','IV/B','IV/C','IV/D','IV/E');
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
foreach($gol as $nilai){
    foreach($data1 as &$y){
        if(!isset($y[$nilai])) $y[$nilai]=0;
    }
}
foreach($eselon as $nilai){
    foreach($data1 as &$x){
        if(!isset($x[$nilai])) $x[$nilai]=0;
    }
}


foreach($d1 as $a){
    if($a['golongan']){
       $data1[$a['nama_unit']][$a['golongan']]++;
       if(!empty($a['seksi'])){
            $data1[$a['nama_unit'].'::'.$a['seksi']][$a['golongan']]++;
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
$tes="Balai Pelayanan & Pemeriksaan Kendaraan Bermotor Wil. I (Bgr - Pwk)::Sub Bagian Tata Usaha";
echo '<h1>'.substr($tes,strpos($tes,'::')).'</h1>';
echo '<pre>';
var_dump($data1);
echo '</pre>';

die();
*/
$judul="Komposisi Pegawai Menurut Golongan\n";
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
                               ->setCellValue('C3','GOLONGAN IV')
                               ->setCellValue('C4','e')
                               ->setCellValue('D4','d')
                               ->setCellValue('E4','c')
                               ->setCellValue('F4','b')
                               ->setCellValue('G4','a')
                               ->setCellValue('H4','JML')
                               ->setCellValue('I3','GOLONGAN III')
                               ->setCellValue('I4','d')
                               ->setCellValue('J4','c')
                               ->setCellValue('K4','b')
                               ->setCellValue('L4','a')
                               ->setCellValue('M4','JML')
                               ->setCellValue('N3','GOLONGAN II')
                               ->setCellValue('N4','d')
                               ->setCellValue('O4','c')
                               ->setCellValue('P4','b')
                               ->setCellValue('Q4','a')
                               ->setCellValue('R4','JML')
                               ->setCellValue('S3','GOLONGAN I')
                               ->setCellValue('S4','d')
                               ->setCellValue('T4','c')
                               ->setCellValue('U4','b')
                               ->setCellValue('V4','a')
                               ->setCellValue('W4','JML')
                               ->setCellValue('X3',"JML\nTotal")
                               ->setCellValue('Y3','Eselon')
                               ->setCellValue('Y4','2')
                               ->setCellValue('Z4','3')
                               ->setCellValue('AA4','4');
                               
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('A1:AA1');
$objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
$objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
$objPHPExcel->getActiveSheet()->mergeCells('X3:X4');
$objPHPExcel->getActiveSheet()->mergeCells('C3:H3');
$objPHPExcel->getActiveSheet()->mergeCells('I3:M3');
$objPHPExcel->getActiveSheet()->mergeCells('N3:R3');
$objPHPExcel->getActiveSheet()->mergeCells('S3:W3');
$objPHPExcel->getActiveSheet()->mergeCells('Y3:AA3');
$objPHPExcel->getActiveSheet()->getStyle('A1:AA4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A3:AA4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A3:AA4')->applyFromArray(
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
                               ->setCellValue('C'.(4+$i),$hsl['IV/E'])
                               ->setCellValue('D'.(4+$i),$hsl['IV/D'])
                               ->setCellValue('E'.(4+$i),$hsl['IV/C'])
                               ->setCellValue('F'.(4+$i),$hsl['IV/B'])
                               ->setCellValue('G'.(4+$i),$hsl['IV/A'])
                               ->setCellValue('H'.(4+$i),'=SUM(C'.(4+$i).':G'.(4+$i).')')
                               ->setCellValue('I'.(4+$i),$hsl['III/D'])
                               ->setCellValue('J'.(4+$i),$hsl['III/C'])
                               ->setCellValue('K'.(4+$i),$hsl['III/B'])
                               ->setCellValue('L'.(4+$i),$hsl['III/A'])
                               ->setCellValue('M'.(4+$i),'=SUM(I'.(4+$i).':L'.(4+$i).')')
                               ->setCellValue('N'.(4+$i),$hsl['II/D'])
                               ->setCellValue('O'.(4+$i),$hsl['II/C'])
                               ->setCellValue('P'.(4+$i),$hsl['II/B'])
                               ->setCellValue('Q'.(4+$i),$hsl['II/A'])
                               ->setCellValue('R'.(4+$i),'=SUM(N'.(4+$i).':Q'.(4+$i).')')
                               ->setCellValue('S'.(4+$i),$hsl['I/D'])
                               ->setCellValue('T'.(4+$i),$hsl['I/C'])
                               ->setCellValue('U'.(4+$i),$hsl['I/B'])
                               ->setCellValue('V'.(4+$i),$hsl['I/A'])
                               ->setCellValue('W'.(4+$i),'=SUM(S'.(4+$i).':V'.(4+$i).')')
                               ->setCellValue('X'.(4+$i),'=SUM(H'.(4+$i).',M'.(4+$i).',R'.(4+$i).',W'.(4+$i).')')
                               ->setCellValue('Y'.(4+$i),$hsl['2'])
                               ->setCellValue('Z'.(4+$i),$hsl['3'])
                               ->setCellValue('AA'.(4+$i),$hsl['4']);
                            $i++;
}
$i--;
$objPHPExcel->getActiveSheet()->getStyle('A5:AA'.(4+$i))->applyFromArray(
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
$q=ord('Z');
for($i=$a;$i<=$q;$i++){
    $objPHPExcel->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
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
