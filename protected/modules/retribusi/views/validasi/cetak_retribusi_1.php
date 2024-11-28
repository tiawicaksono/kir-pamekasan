<style>
    @page {
        /*        margin-left:0px;
                margin-right:0px;
                margin-top:0px;
                margin-bottom:0px;*/
        margin:0;
    }
    @media print {
        #pages {
            overflow: hidden;
            font-family: Arial,Helvetica Neue,Helvetica,sans-serif;
            padding-top: 5px;
            padding-left: 40px;
            page-break-after: always;
        }
        .center{
            text-align: center;
        }

        #div_atas{
            margin-top: 20px;
            margin-left: 220px;
        }
        #div_tengah{
            margin-top: 30px;
        }

        #retribusi_total{
            margin-top: 10px;
        }

        #tanggal{
            margin-top:10px;
            margin-left: 60px;
        }
    }
</style>

<div id="pages">
    <div style="text-align: right; margin-right: 70px; margin-top: 70px;">
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
                <td>
                    <?php
                    $konversi_uang = Yii::app()->appComponent->konversiUang($data_retribusi->total);
                    echo strtoupper($konversi_uang);
                    ?>
                </td>
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
            <div style="margin-top:49px; margin-left: 100px;">
                <span style="font-size:18px; font-weight: bold;"><?php echo number_format($data_retribusi->total, 2, ',', '.'); ?></span>
            </div>
        </div>
        <div style="float: left; width: 27%; padding-left: 238px">
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
            <div id="retribusi_total"><?php echo number_format($data_retribusi->total, 2, ',', '.'); ?></div>
            <div id="tanggal">
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
<div class="pages">
    <div style="margin-top: 310px">
        <table>
            <tr>
                <td style="width: 20px">&nbsp;</td>
                <td style="width: 150px">&nbsp;</td>
                <td><?php echo $data_retribusi->no_uji; ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><?php echo $data_retribusi->no_kendaraan; ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><?php echo $data_retribusi->nama_pemilik; ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td rowspan="2"><?php echo $data_retribusi->alamat; ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><?php echo $data_retribusi->merk." / ".$data_retribusi->tipe; ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><?php echo $data_retribusi->tahun; ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td></td>
            </tr>
        </table>
    </div>
</div>
<script type="text/javascript">
    window.print();
//    setTimeout(window.close, 0);
</script>