<?php
if(!isset($statistik)||!$statistik) die();
$d1=query("SELECT jk,tinggi,berat FROM umum");
$nilaipria=$nilaiwanita='';
foreach($d1 as $brs){
    if($brs['jk']=='P'){
        $nilaipria.="[{$brs['tinggi']},{$brs['berat']}], ";
    }else{
        $nilaiwanita.="[{$brs['tinggi']},{$brs['berat']}], ";
    }
}
?>
<h2>Statistik Berdasarkan Tinggi & Berat Badan <a href="statistik.php" class="tombol">&laquo;Kembali</a> <a href="#" id="cetak" class="tombol">Cetak</a></h2>

<div id="chart1" class="grafik"></div>

<script type="text/javascript">
$(function(){
    Highcharts.setOptions({
	    lang: {
		    resetZoom:'Reset Pembesaran',
		    resetZoomTitle:'Testing'
	    }
    });
    new Highcharts.Chart({
	    chart: {
		    renderTo: 'chart1', 
		    defaultSeriesType: 'scatter',
		    zoomType: 'xy',
		    height:550
	    },
	    title: {
		    text: 'Data Pegawai Berdasarkan Tinggi & Berat Badan'
	    },
	    subtitle: {
		    text: 'DISHUB JABAR'
	    },
	    xAxis: {
		    title: {
			    enabled: true,
			    text: 'Tinggi (cm)'
		    },
		    startOnTick: true,
		    endOnTick: true,
		    showLastLabel: true
	    },
	    yAxis: {
		    title: {
			    text: 'Berat (kg)'
		    }
	    },
	    tooltip: {
		    formatter: function() {
                    return ''+
				    this.x +' cm, '+ this.y +' kg';
		    }
	    },
	    legend: {
		    layout: 'horizontal',
		    align: 'left',
		    verticalAlign: 'top',
		    x: 750,
		    y: 22,
		    backgroundColor: '#FFFFFF',
		    borderWidth: 1
	    },
	    plotOptions: {
		    scatter: {
			    marker: {
				    radius: 5,
				    states: {
					    hover: {
						    enabled: true,
						    lineColor: 'rgb(100,100,100)'
					    }
				    }
			    },
			    states: {
				    hover: {
					    marker: {
						    enabled: false
					    }
				    }
			    }
		    }
	    },
	    series: [{
		    name: 'Wanita',
		    color: 'rgba(223, 83, 83, .5)',
		    data: [
		    <?=$nilaiwanita?>
		    ]

	    }, {
		    name: 'Pria',
		    color: 'rgba(119, 152, 191, .5)',
		    data: [
		    <?=$nilaipria?>
		    ]

	    }],
	    credits:{
            enabled:false
        }
    });
});
</script>
