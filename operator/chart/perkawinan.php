<?php
if(!isset($statistik)||!$statistik) die();
$d2=query("SELECT count(*) jml, status_kawin FROM umum where status='CPNS' or status='PNS' group by status_kawin");
$d3=query("SELECT count(*) jml, status_kawin FROM umum where status='mutasi' or status='pensiun' group by status_kawin");


?>
<h2>Statistik Berdasarkan Status Perkawinan <a href="statistik.php" class="tombol">&laquo;Kembali</a> <a href="#" id="cetak" class="tombol">Cetak</a></h2>

<div id="chart2" class="grafik"></div>
<div id="chart3" class="grafik"></div>

<script type="text/javascript">
$(function(){
    new Highcharts.Chart({
	    chart: {
		    renderTo: 'chart2',
		    margin: [50, 200, 60, 180]
	    },
	    title: {
		    text: 'Perbandingan Status Perkawinan Pegawai Aktif (PNS & CPNS)'
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
			    ['<?=$brs['status_kawin']?>', <?=$brs['jml']?>],
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
		    text: 'Perbandingan Status Perkawinan Pegawai Non-Aktif (Mutasi & Pensiun)'
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
			    ['<?=$brs['status_kawin']?>', <?=$brs['jml']?>],
			    <?endforeach;?>
		    ]
	    }],
        credits:{
            enabled:false
        }
    });

});
</script>
