<?php
if(!isset($statistik)||!$statistik) die();
$d1=query("SELECT count(*) jml, DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(tgl_lahir, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(tgl_lahir, '00-%m-%d')) AS umur from umum where status='CPNS' or status='PNS' group by umur");
$d2=query("SELECT count(*) jml, DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(tgl_lahir, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(tgl_lahir, '00-%m-%d')) AS umur from umum where status='mutasi' or status='pensiun' group by umur");
$d3=query("SELECT count(*) jml,golongan,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(tgl_lahir, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(tgl_lahir, '00-%m-%d')) AS umur from umum natural join golongan where  (status='CPNS' or status='PNS') group by umur,golongan");
$nilai1='';
$nilai2='';
$data1=$data2=$data3=array();
for($i=0;$i<8;$i++){
    $data1[$i]=$data2[$i]=0;
}
foreach($d1 as $brs){
    if($brs['umur']<=20){
        $data1[0]+=$brs['jml'];
    }elseif($brs['umur']<=30){
        $data1[1]+=$brs['jml'];
    }elseif($brs['umur']<=40){
        $data1[2]+=$brs['jml'];
    }elseif($brs['umur']<=50){
        $data1[3]+=$brs['jml'];
    }elseif($brs['umur']<=60){
        $data1[4]+=$brs['jml'];
    }elseif($brs['umur']<=70){
        $data1[5]+=$brs['jml'];
    }elseif($brs['umur']<=80){
        $data1[6]+=$brs['jml'];
    }elseif($brs['umur']<=90){
        $data1[7]+=$brs['jml'];
    }
}

foreach($d2 as $brs){
    if($brs['umur']<=20){
        $data2[0]+=$brs['jml'];
    }elseif($brs['umur']<=30){
        $data2[1]+=$brs['jml'];
    }elseif($brs['umur']<=40){
        $data2[2]+=$brs['jml'];
    }elseif($brs['umur']<=50){
        $data2[3]+=$brs['jml'];
    }elseif($brs['umur']<=60){
        $data2[4]+=$brs['jml'];
    }elseif($brs['umur']<=70){
        $data2[5]+=$brs['jml'];
    }elseif($brs['umur']<=80){
        $data2[6]+=$brs['jml'];
    }elseif($brs['umur']<=90){
        $data2[7]+=$brs['jml'];
    }
}
foreach($d3 as $brs){
    if(!isset($data3[$i][$brs['golongan']])){
        for($i=0;$i<8;$i++){
            $data3[$i][$brs['golongan']]=0;
        }
    }
}
foreach($d3 as $brs){
    if($brs['umur']<=20){
        $data3[0][$brs['golongan']]+=$brs['jml'];
    }elseif($brs['umur']<=30){
        $data3[1][$brs['golongan']]+=$brs['jml'];
    }elseif($brs['umur']<=40){
        $data3[2][$brs['golongan']]+=$brs['jml'];
    }elseif($brs['umur']<=50){
        $data3[3][$brs['golongan']]+=$brs['jml'];
    }elseif($brs['umur']<=60){
        $data3[4][$brs['golongan']]+=$brs['jml'];
    }elseif($brs['umur']<=70){
        $data3[5][$brs['golongan']]+=$brs['jml'];
    }elseif($brs['umur']<=80){
        $data3[6][$brs['golongan']]+=$brs['jml'];
    }elseif($brs['umur']<=90){
        $data3[7][$brs['golongan']]+=$brs['jml'];
    }
}

$tmp=array();
foreach($data3[0] as $kunci => $nilai){
            $tmp[$kunci]='';
}

for($i=0;$i<8;$i++){
    foreach($data3[$i] as $kunci => $nilai){
            $tmp[$kunci].=$nilai.', ';
    }
}
$data3=$tmp;

foreach($data1 as $brs){
    $nilai1.= $brs.",";
}
foreach($data2 as $brs){
    $nilai2.= $brs.",";
}

?>
<h2>Statistik Berdasarkan Umur Pegawai <a href="statistik.php" class="tombol">&laquo;Kembali</a> <a href="#" id="cetak" class="tombol">Cetak</a></h2>

<div id="chart1" class="grafik"></div>
<div id="chart3" class="grafik"></div>
<div id="chart2" class="grafik"></div>

<script type="text/javascript">
$(function(){
    new Highcharts.Chart({
        chart: {
            renderTo: 'chart1',
            defaultSeriesType: 'column'
        },
        title: {
            text: 'Data Pegawai Aktif (PNS & CPNS) Berdasarkan Umur'
        },
        subtitle: {
            text: 'DISHUB JABAR'
        },
        xAxis: {
            categories: [
	            '10 - 20', 
	            '21 - 30', 
	            '31 - 40',
	            '41 - 50',
	            '51 - 60',
	            '61 - 70',
	            '71 - 80',
	            '81 - 90'
            ],
            title:{
                text:'Rentang Umur (tahun)'
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
		            this.series.name + ' '+ this.x +': '+ this.y +' orang';
            }
        },
        series: [{
            name: 'Umur',
            data: [<?=$nilai1?>]

        }],
        credits:{
            enabled:false
        }
    });
    new Highcharts.Chart({
        chart: {
            renderTo: 'chart2',
            defaultSeriesType: 'column'
        },
        title: {
            text: 'Data Pegawai Non-Aktif (Mutasi & Pensiun) Berdasarkan Umur'
        },
        subtitle: {
            text: 'DISHUB JABAR'
        },
        xAxis: {
            categories: [
	            '10 - 20', 
	            '21 - 30', 
	            '31 - 40',
	            '41 - 50',
	            '51 - 60',
	            '61 - 70',
	            '71 - 80',
	            '81 - 90'
            ],
            title:{
                text:'Rentang Umur (tahun)'
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
		            this.series.name + ' '+ this.x +': '+ this.y +' orang';
            }
        },
        series: [{
            name: 'Umur',
            data: [<?=$nilai2?>]

        }],
        credits:{
            enabled:false
        }
    });

new Highcharts.Chart({
	    chart: {
		    renderTo: 'chart3',
		    defaultSeriesType: 'column'
	    },
	    title: {
		    text: 'Komposisi Golongan Pegawai Aktif Berdasarkan Umur'
	    },
        subtitle: {
            text: 'DISHUB JABAR'
        },
	    xAxis: {
		    categories: [
	            '10 - 20', 
	            '21 - 30', 
	            '31 - 40',
	            '41 - 50',
	            '51 - 60',
	            '61 - 70',
	            '71 - 80',
	            '81 - 90'
		    ],
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
        series: [
        <?foreach($data3 as $kunci => $nilai):?>
            {
		    name: '<?=$kunci?>',
		    data: [<?=$nilai?>]
		},
		<?endforeach;?>
		],
	    credits:{
            enabled:false
        }
    });
});
</script>
