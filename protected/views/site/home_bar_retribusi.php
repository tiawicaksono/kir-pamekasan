<script type="text/javascript">
    $(document).ready(function ($) {
        Highcharts.setOptions({
            lang: {
                numericSymbols: [' ribu', ' juta', ' milyar']
            }
        });
        $('#containerRetribusi').highcharts({
            title: {
                text: '',
//                x: -20
            },
            subtitle: {
                text: '',
//                x: -20
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Retribusi'
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px"><b>{point.key}</b></span>',
                pointFormat: '<table><tr>' +
                        '<td style="color:{series.color};padding:0"><b>{series.name} : </b></td>' +
                        '<td style="padding:0">{point.y:.0f}</td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
//            legend: {
//                layout: 'vertical',
//                align: 'right',
//                verticalAlign: 'middle',
//                borderWidth: 0
//            },
            series: [
            <?php
//            $year = date('Y') - 2;
            for ($tahun = $year; $tahun <= date('Y'); $tahun++):
                ?>
                {
                    name: '<?php echo $tahun; ?>',
                    data: [
                    <?php
                    for ($bln = 1; $bln <= 12; $bln++):
                        $criteria = new CDbCriteria();
                        $criteria->addCondition("EXTRACT(YEAR FROM tgl_retribusi) =" . $tahun);
                        $criteria->addCondition("EXTRACT(MONTH FROM tgl_retribusi) =" . $bln);
                        $criteria->addCondition("validasi = 'true'");
                        $criteria->select = "SUM(total) as total";
                        $criteria->select = 'SUM(b_berkala) as b_berkala,SUM(b_pertama) as b_pertama,SUM(b_jbb) as b_jbb,'
                                . 'SUM(b_tnd_samping) as b_tnd_samping,SUM(b_plat_uji) as b_plat_uji,SUM(b_buku) as b_buku,'
                                . 'SUM(b_rekom) as b_rekom,SUM(b_tlt_uji) as b_tlt_uji';
                        $data = VValidasi::model()->find($criteria);
                        $total = floatval($data->b_berkala) + floatval($data->b_pertama) + floatval($data->b_jbb) + floatval($data->b_tnd_samping) + floatval($data->b_plat_uji) + floatval($data->b_buku) + floatval($data->b_rekom) + floatval($data->b_tlt_uji);
                        if(!empty($total)){
                            echo $total . ', ';
                        }else{
                            echo '0,';
                        }
                    endfor;
                    ?>
                    ]
                },
            <?php endfor; ?>
            ]
        });
    });
</script>
<div id="containerRetribusi" style="min-width: 310px; height: 310px; margin: 0 auto"></div>