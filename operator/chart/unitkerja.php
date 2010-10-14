<?php
if(!isset($statistik)||!$statistik) die();
$d1=query('SELECT count(*) jml,a.status, c.nama
FROM  umum a, jenis_jabatan b, unit_kerja c, golongan d
WHERE a.id_jabatan = b.id_jabatan
AND b.id_unit_kerja = c.id_unit_kerja
AND a.id_golongan = d.id_golongan
GROUP BY c.nama, a.status ORDER BY c.nama');
$data1=array();
foreach($d1 as $brs){
    $data1[$brs['nama']][$brs['status']]=$brs['jml'];
}
$kat=array();
$nilaicpns=$nilaipns=$nilaimutasi=$nilaipensiun=$nilaimeninggal='';
foreach($data1 as $kunci => $nilai){
    $kat[]=$kunci;
    if(empty($nilai['CPNS'])){
        $nilaicpns.= '0, ';
    }else{
        $nilaicpns.= $nilai['CPNS'].', ';
    }
    if(empty($nilai['PNS'])){
        $nilaipns.= '0, ';
    }else{
        $nilaipns.= $nilai['PNS'].', ';
    }
    if(empty($nilai['mutasi'])){
        $nilaimutasi.= '0, ';
    }else{
        $nilaimutasi.= $nilai['mutasi'].', ';
    }
    if(empty($nilai['pensiun'])){
        $nilaipensiun.= '0, ';
    }else{
        $nilaipensiun.= $nilai['pensiun'].', ';
    }
    if(empty($nilai['meninggal'])){
        $nilaimeninggal.= '0, ';
    }else{
        $nilaimeninggal.= $nilai['meninggal'].', ';
    }
}
?>
<h2>Statistik Berdasarkan Unit Kerja <a href="statistik.php" class="tombol">&laquo;Kembali</a> <a href="#" id="cetak" class="tombol">Cetak</a></h2>

<div id="chart1" class="grafik"></div>

<script type="text/javascript">
$(function(){
    new Highcharts.Chart({
	    chart: {
		    renderTo: 'chart1',
		    defaultSeriesType: 'column',
		    height:560,
		    marginTop:100,
	    },
	    title: {
		    text: 'Jumlah Pegawai Berdasarkan Unit Kerja'
	    },
        subtitle: {
            text: 'DISHUB JABAR'
        },
	    xAxis: {
		    categories: [
		    <?foreach($kat as $kunci){
                echo "'".$kunci."', ";
            }?>
		    ],
		    labels: {
				rotation: -20,
				align: 'right',
				style: {
					 font: 'normal 8px Verdana, sans-serif'
				}
			},
			title:{
			    text:''
			}
	    },
	    yAxis: {
		    min: 0,
		    title: {
			    text: 'Jumlah Pegawai (orang)'
		    },
            allowDecimals:false
	    },
	    legend: {
		    style: {
			    left: 'auto',
			    bottom: 'auto',
			    right: '30px',
			    top: '55px'
		    },
		    backgroundColor: '#FFFFFF',
		    borderColor: '#CCC',
		    borderWidth: 1,
		    shadow: false
	    },
	    tooltip: {
		    formatter: function() {
			    return '<b>'+ this.x +'</b><br/>'+
				     this.series.name +': '+ this.y +' orang<br/>'+
				     'Total: '+ this.point.stackTotal +' orang';
		    }
	    },
	    plotOptions: {
		    column: {
			    stacking: 'normal'
		    }
	    },
        series: [{
		    name: 'CPNS',
		    data: [<?=$nilaicpns?>]
	    }, {
		    name: 'PNS',
		    data: [<?=$nilaipns?>]
	    }, {
		    name: 'mutasi',
		    data: [<?=$nilaimutasi?>]
	    }, {
		    name: 'pensiun',
		    data: [<?=$nilaipensiun?>]
	    }, {
		    name: 'meninggal',
		    data: [<?=$nilaimeninggal?>]
	    }],
	    credits:{
            enabled:false
        }
    });
});
</script>
