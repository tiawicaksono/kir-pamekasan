<style>
    @page {
        margin-left:0px;
        margin-right:0px;
        margin-top:0px;
        margin-bottom:0px;
        height: 16.5cm;
    }
    @media print {
        #pages {
            overflow: hidden;
            font-family: Arial,Helvetica Neue,Helvetica,sans-serif;
            padding: 5px 40px 40px 40px;
        }
        .center{
            text-align: center;
        }

        #div_atas{
            margin-top: 12px;
            margin-left: 220px;
        }
        #div_tengah{
            margin-top: 20px;
        }

        #retribusi_total{
            margin-top: 25px;
        }

        #tanggal{
            margin-top: 15px;
            margin-left: 350px;
        }

        #tandes{
            margin-top: 10px;
            margin-left: 355px;
        }

        #pengurus{
            margin-top: 90px;
            margin-left: 10px;
        }

        #petugas{
            margin-left: 120px;
            text-transform: uppercase;
        }
    }
</style>

<div id="pages">
    <div style="text-align: right; margin-right: 70px; margin-top: 40px;">
        <?php echo $data_retribusi->numerator; ?>
    </div>
    <div id="div_atas">
        <table style="font-size: 12pt;">
            <tr>
                <td><?php echo $data_retribusi->no_uji . " / " . $data_retribusi->no_kendaraan; ?></td>
            </tr>
            <tr>
                <td><?php echo $data_retribusi->nama_pemilik . " / " . $data_retribusi->nm_uji; ?></td>
            </tr>
            <tr>
                <td><?php echo $baseJs = Yii::app()->appComponent->konversiUang($data_retribusi->total); ?></td>
            </tr>
        </table>
    </div>
    <div id="div_tengah">
        <div style="float: left; width: 35%; padding-left: 30px">
            <div style="margin-top:40px;">
                Tanggal Uji
                <br />
                <?php
                    $tgl = date('d/n/Y', strtotime($data_retribusi->tgl_uji));
                    $explodeTgl = explode('/', $tgl);
                    $bulan = Yii::app()->params['bulanArrayInd'][$explodeTgl[1] - 1];
                    echo $explodeTgl[0] . " " . $bulan . " " . $explodeTgl[2];
                ?>
            </div>
            <div style="margin-top:30px; margin-left: 340px;">
                <?php echo $data_retribusi->lama_tlt; ?>
            </div>
            <div style="margin-top:30px; margin-left: 80px;">
                <?php echo number_format($data_retribusi->total, 2, ',', '.'); ?>
            </div>
        </div>
        <div style="float: left; width: 27%; padding-left: 230px">
            <div>
                <?php
                if ($data_retribusi->b_berkala != 0) {
                    echo number_format($data_retribusi->b_berkala, 2, ',', '.');
                } else {
                    echo number_format($data_retribusi->b_pertama, 2, ',', '.');
                }
                ?>
            </div>
            <div><?php echo number_format($data_retribusi->b_jbb, 2, ',', '.'); ?></div>
            <div><?php echo number_format($data_retribusi->b_plat_uji, 2, ',', '.'); ?></div>
            <div><?php echo number_format($data_retribusi->b_tnd_samping, 2, ',', '.'); ?></div>
            <div><?php echo number_format($data_retribusi->b_buku, 2, ',', '.'); ?></div>
            <div><?php echo number_format($data_retribusi->b_rekom, 2, ',', '.'); ?></div>
            <div><?php echo number_format($data_retribusi->b_tlt_uji, 2, ',', '.'); ?></div>
            <div><?php echo number_format($data_retribusi->total, 2, ',', '.'); ?></div>
            <div style="margin-top:5px; margin-left: 60px;">
                <?php
                $tgl = date('d/n/Y', strtotime($data_retribusi->tgl_retribusi));
                $explodeTgl = explode('/', $tgl);
                $bulan = Yii::app()->params['bulanArrayInd'][$explodeTgl[1] - 1];
                echo $explodeTgl[0] . " " . $bulan . " " . $explodeTgl[2];
                ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.print();
    setTimeout(window.close, 0);
</script>