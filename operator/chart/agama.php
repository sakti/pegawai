<?php
if(!isset($statistik)||!$statistik) die();
$d1=query('SELECT COUNT( * ) jml, agama, status FROM umum GROUP BY agama, status');
$d2=query("SELECT count(*) jml, agama FROM umum where status='CPNS' or status='PNS' group by agama");
$d3=query("SELECT count(*) jml, agama FROM umum where status='mutasi' or status='pensiun' or status='meninggal' group by agama");

$data1=array();
foreach($d1 as $brs){
    $data1[$brs['agama']][$brs['status']]=$brs['jml'];
}

$kunci=array('CPNS','PNS','mutasi','pensiun','meninggal');
foreach($kunci as $nilai){
    if (empty($data1['islam'][$nilai])) $data1['islam'][$nilai]=0;
    if (empty($data1['kristen'][$nilai])) $data1['kristen'][$nilai]=0;
    if (empty($data1['katolik'][$nilai])) $data1['katolik'][$nilai]=0;
    if (empty($data1['budha'][$nilai])) $data1['budha'][$nilai]=0;
    if (empty($data1['hindu'][$nilai])) $data1['hindu'][$nilai]=0;
    if (empty($data1['konghochu'][$nilai])) $data1['konghochu'][$nilai]=0;
}
$nilai1islam=$nilai1kristen=$nilai1katolik=$nilai1budha=$nilai1hindu=$nilai1konghochu='';

foreach($kunci as $nilai){
    $nilai1islam.=$data1['islam'][$nilai].', ';
    $nilai1kristen.=$data1['kristen'][$nilai].', ';
    $nilai1katolik.=$data1['katolik'][$nilai].', ';
    $nilai1budha.=$data1['budha'][$nilai].', ';
    $nilai1hindu.=$data1['hindu'][$nilai].', ';
    $nilai1konghochu.=$data1['konghochu'][$nilai].', ';
}

?>
<h2>Statistik Berdasarkan Agama <a href="statistik.php" class="tombol">&laquo;Kembali</a> <a href="#" id="cetak" class="tombol">Cetak</a></h2>

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
            text: 'Data Pegawai Berdasarkan Agama'
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
            name: 'Islam',
            data: [<?=$nilai1islam?>]

        },{
            name: 'Kristen',
            data: [<?=$nilai1kristen?>]

        },{
            name: 'Katolik',
            data: [<?=$nilai1katolik?>]
            
        },{
            name: 'Budha',
            data: [<?=$nilai1budha?>]

        }, {
            name: 'Hindu',
            data: [<?=$nilai1hindu?>]

        }, {
            name: 'Konghochu',
            data: [<?=$nilai1konghochu?>]

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
		    text: 'Perbandingan Agama Pegawai Aktif (PNS & CPNS)'
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
		        <?foreach($d2 as $brs):?>
			    ['<?=$brs['agama']?>', <?=$brs['jml']?>],
			    <?endforeach;?>
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
		    text: 'Perbandingan Agama Pegawai Non-Aktif (Mutasi, Pensiun, Meninggal)'
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
		        <?foreach($d3 as $brs):?>
			    ['<?=$brs['agama']?>', <?=$brs['jml']?>],
			    <?endforeach;?>
		    ]
	    }],
        credits:{
            enabled:false
        }
    });

});
</script>
