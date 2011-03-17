<?php
if(!isset($statistik)||!$statistik) die();
$d1=query('SELECT COUNT(*) jml, jk, status FROM umum GROUP BY jk, status');
$d2=query("SELECT count(*) jml, jk FROM umum where status='CPNS' or status='PNS' group by jk");
$d3=query("SELECT count(*) jml, jk FROM umum where status='mutasi' or status='pensiun' or status='meninggal' group by jk");

$data1=array();
foreach($d1 as $brs){
    $data1[$brs['jk']][$brs['status']]=$brs['jml'];
}
$kunci=array('CPNS','PNS','mutasi','pensiun','meninggal');
foreach($kunci as $nilai){
    if (empty($data1['W'][$nilai])) $data1['W'][$nilai]=0;
    if (empty($data1['P'][$nilai])) $data1['P'][$nilai]=0;
}
$nilai1wanita=$data1['W']['CPNS'].', '.$data1['W']['PNS'].', '.$data1['W']['mutasi'].', '.$data1['W']['pensiun'].', '.$data1['W']['meninggal'];
$nilai1pria=$data1['P']['CPNS'].', '.$data1['P']['PNS'].', '.$data1['P']['mutasi'].', '.$data1['P']['pensiun'].', '.$data1['P']['meninggal'];

$data2=array();
foreach($d2 as $brs){
    $data2[$brs['jk']]=$brs['jml'];
}
$nilai2wanita=(empty($data2['W']))?0:$data2['W'];
$nilai2pria=(empty($data2['P']))?0:$data2['P'];

$data3=array();
foreach($d3 as $brs){
    $data3[$brs['jk']]=$brs['jml'];
}
$nilai3wanita=(empty($data3['W']))?0:$data3['W'];
$nilai3pria=(empty($data3['P']))?0:$data3['P'];

?>
<h2>Statistik Berdasarkan Jenis Kelamin <a href="statistik.php" class="tombol">&laquo;Kembali</a> <a href="#" id="cetak" class="tombol">Cetak</a></h2>

<div id="chart1" class="grafik"></div>
<div id="chart2" class="grafik"></div>
<div id="chart3" class="grafik"></div>

<script type="text/javascript">
$(function(){
    new Highcharts.Chart({
        chart: {
            renderTo: 'chart1',
            defaultSeriesType: 'column'
        },
        title: {
            text: 'Data Pegawai Berdasarkan Jenis Kelamin'
        },
        subtitle: {
            text: 'DISHUB JABAR'
        },
        xAxis: {
            categories: [
	            'CPNS', 
	            'PNS', 
	            'Mutasi',
	            'Pensiun',
	            'Meninggal'
            ],
            title:{
                text:'Status Pegawai'
            }
        },
        yAxis: {
            min: 0,
            title: {
	            text: 'Jumlah (orang)'
            },
            allowDecimals:false
        },
        tooltip: {
            formatter: function() {
	            return ''+
		            this.x + ' '+ this.series.name +': '+ this.y +' orang';
            }
        },
        series: [{
            name: 'Wanita',
            data: [<?=$nilai1wanita?>]

        }, {
            name: 'Pria',
            data: [<?=$nilai1pria?>]

        }],
        credits:{
            enabled:false
        }
    });
    new Highcharts.Chart({
	    chart: {
		    renderTo: 'chart2',
		    margin: [50, 200, 60, 180]
	    },
	    title: {
		    text: 'Perbandingan Jenis Kelamin Pegawai Aktif (PNS & CPNS)'
	    },
	    subtitle: {
            text: 'DISHUB JABAR'
        },
	    plotArea: {
		    shadow: null,
		    borderWidth: null,
		    backgroundColor: null
	    },
	    tooltip: {
		    formatter: function() {
			    return '<b>'+ this.point.name +'</b>: '+ ((this.y/this.total)*100).toFixed(1) +' %';
		    }
	    },
	    plotOptions: {
		    pie: {
			    allowPointSelect: true,
			    cursor: 'pointer',
			    dataLabels: {
				    enabled: true,
				    formatter: function() {
                         return this.point.name +' '+ this.y +' org';
				    },
				    color: 'white',
				    style: {
					    font: '10px Trebuchet MS, Verdana, sans-serif'
				    }
			    }
		    }
	    },
	    legend: {
		    layout: 'vertical',
		    style: {
			    left: 'auto',
			    bottom: 'auto',
			    right: '50px',
			    top: '100px'
		    }
	    },
        series: [{
		    type: 'pie',
		    name: 'Komposisi Jenis Kelamin',
		    data: [
			    ['Wanita', <?=$nilai2wanita?>],
			    ['Pria',   <?=$nilai2pria?>]
		    ]
	    }],
        credits:{
            enabled:false
        }
    });

    new Highcharts.Chart({
	    chart: {
		    renderTo: 'chart3',
		    margin: [50, 200, 60, 180]
	    },
	    title: {
		    text: 'Perbandingan Jenis Kelamin Pegawai Non-Aktif (Mutasi, Pensiun, Meninggal)'
	    },
	    subtitle: {
            text: 'DISHUB JABAR'
        },
	    plotArea: {
		    shadow: null,
		    borderWidth: null,
		    backgroundColor: null
	    },
	    tooltip: {
		    formatter: function() {
			    return '<b>'+ this.point.name +'</b>: '+ ((this.y/this.total)*100).toFixed(1) +' %';
		    }
	    },
	    plotOptions: {
		    pie: {
			    allowPointSelect: true,
			    cursor: 'pointer',
			    dataLabels: {
				    enabled: true,
				    formatter: function() {
                         return this.point.name +' '+ this.y +' org';
				    },
				    color: 'white',
				    style: {
					    font: '10px Trebuchet MS, Verdana, sans-serif'
				    }
			    }
		    }
	    },
	    legend: {
		    layout: 'vertical',
		    style: {
			    left: 'auto',
			    bottom: 'auto',
			    right: '50px',
			    top: '100px'
		    }
	    },
        series: [{
		    type: 'pie',
		    name: 'Komposisi Jenis Kelamin',
		    data: [
			    ['Wanita', <?=$nilai3wanita?>],
			    ['Pria',   <?=$nilai3pria?>]
		    ]
	    }],
        credits:{
            enabled:false
        }
    });
});
</script>
