<style>
    @page {
        margin-left:0px;
        margin-right:0px;
        margin-top:0px;
        margin-bottom:0px;
    }
    @media print {
        /* .pages {
        page-break-after: always;
        }*/

        #pages {
            page-break-after: always;
            overflow: hidden;
            font-family: Arial,Helvetica Neue,Helvetica,sans-serif; 
            letter-spacing: 4px; 
            font-weight: bold;
        }
        .center{
            text-align: center;
        }
        
        #numerator{
            margin-top:91px;
        }

        #div_kendaraan{
            margin-top: 20px;
            margin-left: 200px;
            height: 50px;
        }
        
        #div_retribusi{
            margin-top: 35px;
            margin-left: 310px; 
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
<?php
foreach ($idArray as $id_retribusi):
    $data_retribusi = VValidasi::model()->findByAttributes(array('id_retribusi' => $id_retribusi));
    ?>
    <div id="pages">
        <div id="numerator" class="center"><?php echo $data_retribusi->numerator; ?></div>
        <div id="div_kendaraan">
            <div id="nama_pemilik"><?php echo $data_retribusi->nama_pemilik; ?></div>
            <div id="no_uji_kendaraan"><?php echo $data_retribusi->no_uji . " / " . $data_retribusi->no_kendaraan; ?></div>
            <div id="jenis_uji"><?php echo $data_retribusi->nm_uji; ?></div>
        </div>
        <div id="div_retribusi">
            <div id="retribusi"><?php echo number_format($data_retribusi->b_daftar, 0, ',', '.'); ?></div>
            <div id="buku_uji"><?php echo number_format($data_retribusi->b_gnt_buku, 0, ',', '.'); ?></div>
            <div id="denda"><?php echo number_format($data_retribusi->tlt_uji, 0, ',', '.'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $data_retribusi->lama_tlt; ?> bln)</div>
            <div id="retribusi_total"><?php echo number_format($data_retribusi->rettotal, 0, ',', '.'); ?></div>
        </div>
        <div id="tanggal">
            <?php
            $tgl = date('d/n/Y', strtotime($data_retribusi->tgl_uji));
            $explodeTgl = explode('/', $tgl);
            $bulan = Yii::app()->params['bulanArrayInd'][$explodeTgl[1] - 1];
            echo $explodeTgl[0] . " " . $bulan . " " . $explodeTgl[2];
            ?>
        </div>
        <div id="tandes">TANDES</div>
        <div id="pengurus">Pengurus : <?php echo $data_retribusi->pengurus == '' ? '-' : strtoupper($data_retribusi->pengurus); ?></div>
        <div id="petugas"><span class="baris"><?php echo $data_retribusi->penerima; ?></span></div>
    </div>
<?php endforeach; ?>
<script type="text/javascript">
    window.print();
    setTimeout(window.close, 0);
</script>