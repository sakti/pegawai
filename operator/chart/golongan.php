<?php
if(!isset($statistik)||!$statistik) die();
$d1=query("SELECT count(*) jml,d.golongan, c.nama
FROM  umum a, jenis_jabatan b, unit_kerja c, golongan d
WHERE a.id_jabatan = b.id_jabatan
AND b.id_unit_kerja = c.id_unit_kerja
AND a.id_golongan = d.id_golongan and
(a.status='PNS' or a.status='CPNS')
GROUP BY c.nama, d.golongan ORDER BY c.nama");
$data1=$data2=$kat=array();
foreach($d1 as $brs){
    $data1[$brs['golongan']][$brs['nama']]=$brs['jml'];
    $data2[$brs['nama']][$brs['golongan']]=$brs['jml'];
}
$i=0;
foreach($data2 as $kunci => $nilai){
    $kat[$kunci]=$i;
    $i++;
}
?>
<h2>Statistik Berdasarkan Golongan <a href="statistik.php" class="tombol">&laquo;Kembali</a> <a href="#" id="cetak" class="tombol">Cetak</a></h2>

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
		    text: 'Jumlah Pegawai Aktif Berdasarkan Golongan'
	    },
        subtitle: {
            text: 'DISHUB JABAR'
        },
	    xAxis: {
		    categories: [
		    <?foreach($kat as $kunci => $nilai){
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
		    }
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
        <?foreach($data1 as $kunci => $nilai):?>
                {
		    name: '<?=$kunci?>',
		    data: [
		    <?foreach($nilai as $kunci2 => $nilai2):?>
		    {
		        y:<?=$nilai2?>,
		        x:<?=$kat[$kunci2]?>
		    },
		    <?endforeach;?>
		    ]
		},
		<?endforeach;?>
	     ],
	    credits:{
            enabled:false
        }
    });
});
</script>
