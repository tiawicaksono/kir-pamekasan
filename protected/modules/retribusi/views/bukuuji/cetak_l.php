<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            .pages {
                margin:0;
                overflow: hidden;
            }

            @page {
                margin-left:0px;
                margin-right:0px;
                margin-top:0px;
                margin-bottom:0px;
            }
            @media print {
                .pages {
                    page-break-after: always;
                    font-family: Calibri;
                    font-size: 14pt;
                    font-style: normal;
                    font-variant: normal;
                    overflow: hidden;
                }
                .kolom_kiri{
                    float: left;
                    width: 50%;
                    max-width: 50%;
                    height: 100%;
                    margin: 0px;
                    padding:0px;
                    display: inline-block;
                    /*border: 1px solid #000;*/
                }
                .kolom_kanan{
                    float: left;
                    width: 50%;
                    max-width: 50%;
                    height: 100%;
                    margin: 0px;
                    padding:0px;
                    display: inline-block;
                    /*border: 1px solid #000;*/
                }
                /*=================================*/
                #konten_kanan{
                    width: 100%;
                    padding-left: 280px;
                    padding-top: 125px;
                }
                #konten_kiri{
                    width: 100%;
                    padding-left: 280px;
                    padding-top: 125px;
                }
                .kolom_hasil_uji{
                    float: left;
                    width: 65%;
                    position: absolute;
                }
                .kolom_keterangan{
                    float: left;
                    width: 29%;
                    position: absolute;
                    text-align: center;
                }
                /*=================================*/
                .total_gaya_pengereman{
                }
                .selisih_gaya_pengereman_sb1{
                    margin-top:5px;
                }
                .selisih_gaya_pengereman_sb2{
                    margin-top:3px;
                }
                .kuat_pancar_lampu_kanan{
                    margin-top: 20px;
                }
                .kuat_pancar_lampu_kiri{
                    margin-top: 12px;
                }
                .penyimpangan_kanan{
                    margin-top: 13px;
                }
                .penyimpangan_kiri{
                    margin-top: 10px;
                }
                .solar{
                    margin-top: 10px;
                }
                .bensin1_co{
                    margin-top: 55px;
                }
                .bensin2_co{
                    margin-top: 15px;
                }
                /*
                *=====================================
                */
                .lokasi{
                    margin-left: -25px;
                    margin-top: 70px;
                    font-size: 16pt;
                }
                .tgl_uji{
                    margin-left: -25px;
                    font-size: 16pt;
                }
                .tgl_mati_uji{
                    margin-left: -25px;
                    margin-top: 50px;
                    font-size: 16pt;
                }
                .nama_penguji{
                    margin-left: -40px;
                    margin-top: 240px;
                    font-family: Calibri;
                    font-size: 12pt;
                    font-style: normal;
                    font-variant: normal;
                }
                .nrp_penguji{
                    margin-left: -30px;
                    font-family: Calibri;
                    font-size: 10pt;
                    font-style: normal;
                    font-variant: normal;
                }

                .petugas{
                    /*width: 100%;*/
                    margin-left: -250px;
                    font-size: 13pt;
                    font-style: normal;
                    font-variant: normal;
                    margin-top: 17px;
                }
                }
        </style>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="ThemeBucket">
        <link rel="shortcut icon" href="#" type="image/png">
        <title>Print Hasil Uji Lulus</title>

    </head>

    <body>
        <!--<div class="pages">a</div>-->
        <div class="pages">
            <?php
            $data = VPrintHasil::model()->findByAttributes(array('id_hasil_uji' => $id));
            if ($posisi == 'kiri') {
                ?>
                <div class="kolom_kiri">
                    <div id="konten_kiri">
                        <div class="kolom_hasil_uji">
                            <div class="total_gaya_pengereman"><?php echo ($data->beratgaya == '0' || $data->beratgaya == '')?'-':$data->beratgaya; ?></div>
                            <div class="selisih_gaya_pengereman_sb1"><?php echo ($data->selgaya == '0' || $data->selgaya == '')?'-':$data->selgaya; ?></div>
                            <div class="selisih_gaya_pengereman_sb2"><?php echo ($data->selkirikanan == '0' || $data->selkirikanan == '')?'-':$data->selkirikanan; ?></div>
                            <div class="selisih_gaya_pengereman_sb3"><?php echo ($data->selgaya3 == '0' || $data->selgaya3 == '')?'-':$data->selgaya3; ?></div>
                            <div class="selisih_gaya_pengereman_sb4"><?php echo ($data->selgaya4 == '0' || $data->selgaya4 == '')?'-':$data->selgaya4; ?></div>
                            <div class="kuat_pancar_lampu_kanan"><?php echo $data->ktlamp_kanan; ?></div>
                            <div class="kuat_pancar_lampu_kiri"><?php echo $data->ktlamp_kiri; ?></div>
                            <div class="penyimpangan_kanan"><?php echo number_format($data->dev_kanan, 2, '.', '.'); ?></div>
                            <div class="penyimpangan_kiri"><?php echo number_format($data->dev_kiri, 2, '.', '.'); ?></div>
                            <div class="solar"><?php
                                if ($data->bahan_bakar == 'SOLAR')
                                    echo $data->ems_diesel;
                                else
                                    echo "&nbsp;";
                                ?>
                            </div>
                            <div class="bensin1_co">
                                <?php
                                if ($data->bahan_bakar == 'BENSIN') {
                                    if ($data->tahun < 2007) {
                                        echo $data->ems_mesin_co;
                                    } else {
                                        echo "&nbsp;";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                            </div>
                            <div class="bensin1_hc">
                                <?php
                                if ($data->bahan_bakar == 'BENSIN') {
                                    if ($data->tahun < 2007) {
                                        echo $data->ems_mesin_hc;
                                    } else {
                                        echo "&nbsp;";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                            </div>
                            <div class="bensin2_co">
                                <?php
                                if ($data->bahan_bakar == 'BENSIN') {
                                    if ($data->tahun >= 2007) {
                                        echo $data->ems_mesin_co;
                                    } else {
                                        echo "&nbsp;";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                            </div>
                            <div class="bensin2_hc">
                                <?php
                                if ($data->bahan_bakar == 'BENSIN') {
                                    if ($data->tahun >= 2007) {
                                        echo $data->ems_mesin_hc;
                                    } else {
                                        echo "&nbsp;";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                            </div>
                            <div class="petugas"><?php echo date('d M Y H:i') . " , " . $data->no_uji . " , " . Yii::app()->session['username']; ?></div>
                            </div>
                        <div class="kolom_keterangan">
                            <div class="lokasi">SITUBONDO</div>
                            <div class="tgl_uji"><?php echo date('d', strtotime($data->tgl_uji)) . " " . Yii::app()->params['blnArrayInd'][date('n', strtotime($data->tgl_uji)) - 1] . " " . date('Y', strtotime($data->tgl_uji)); ?></div>
                            <div class="tgl_mati_uji">
                                <?php
                                $tgl_mati_uji = date("d", strtotime($data->tgl_mati_uji));
                                $bulan_mati_uji = date("n", strtotime($data->tgl_mati_uji));
                                $thn_mati_uji = date("Y", strtotime($data->tgl_mati_uji));
                                $bln_mati_uji = Yii::app()->params['blnArrayInd'][$bulan_mati_uji - 1];
                                echo $tgl_mati_uji . " " . $bln_mati_uji . " " . $thn_mati_uji;
                                ?>
                            </div>
                            <div class="nama_penguji"><u><?php echo $data->nm_penguji; ?></u></div>
                            <div class="nrp_penguji"><?php echo $data->nrp; ?></div>
                        </div>
                    </div>
                </div>
                <div class="kolom_kanan">
                    <div id="konten_kanan">
                        <div class="kolom_hasil_uji">
                            &nbsp;
                        </div>
                    </div>
                </div>
            <?php } else if ($posisi == 'kanan') { ?>
                <div class="kolom_kiri">
                    <div id="konten_kiri">&nbsp;</div>
                </div>
                <div class="kolom_kanan">
                    <div id="konten_kanan">
                        <div class="kolom_hasil_uji">
                            <div class="total_gaya_pengereman"><?php echo ($data->beratgaya == '0' || $data->beratgaya == '')?'-':$data->beratgaya; ?></div>
                            <div class="selisih_gaya_pengereman_sb1"><?php echo ($data->selgaya == '0' || $data->selgaya == '')?'-':$data->selgaya; ?></div>
                            <div class="selisih_gaya_pengereman_sb2"><?php echo ($data->selkirikanan == '0' || $data->selkirikanan == '')?'-':$data->selkirikanan; ?></div>
                            <div class="selisih_gaya_pengereman_sb3"><?php echo ($data->selgaya3 == '0' || $data->selgaya3 == '')?'-':$data->selgaya3; ?></div>
                            <div class="selisih_gaya_pengereman_sb4"><?php echo ($data->selgaya4 == '0' || $data->selgaya4 == '')?'-':$data->selgaya4; ?></div>
                            <div class="kuat_pancar_lampu_kanan"><?php echo $data->ktlamp_kanan; ?></div>
                            <div class="kuat_pancar_lampu_kiri"><?php echo $data->ktlamp_kiri; ?></div>
                            <div class="penyimpangan_kanan"><?php echo number_format($data->dev_kanan, 2, '.', '.'); ?></div>
                            <div class="penyimpangan_kiri"><?php echo number_format($data->dev_kiri, 2, '.', '.'); ?></div>
                            <div class="solar"><?php
                                if ($data->bahan_bakar == 'SOLAR')
                                    echo $data->ems_diesel;
                                else
                                    echo "&nbsp;";
                                ?></div>
                            <div class="bensin1_co">
                                <?php
                                if ($data->bahan_bakar == 'BENSIN') {
                                    if ($data->tahun < 2007) {
                                        echo $data->ems_mesin_co;
                                    } else {
                                        echo "&nbsp;";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                            </div>
                            <div class="bensin1_hc">
                                <?php
                                if ($data->bahan_bakar == 'BENSIN') {
                                    if ($data->tahun < 2007) {
                                        echo $data->ems_mesin_hc;
                                    } else {
                                        echo "&nbsp;";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                            </div>
                            <div class="bensin2_co">
                                <?php
                                if ($data->bahan_bakar == 'BENSIN') {
                                    if ($data->tahun >= 2007) {
                                        echo $data->ems_mesin_co;
                                    } else {
                                        echo "&nbsp;";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                            </div>
                            <div class="bensin2_hc">
                                <?php
                                if ($data->bahan_bakar == 'BENSIN') {
                                    if ($data->tahun >= 2007) {
                                        echo $data->ems_mesin_hc;
                                    } else {
                                        echo "&nbsp;";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                            </div>
                            <div class="petugas"><?php echo date('d M Y H:i') . " , " . $data->no_uji . " , " . Yii::app()->session['username']; ?></div>
                            </div>
                        <div class="kolom_keterangan">
                            <div class="lokasi">SITUBONDO</div>
                            <div class="tgl_uji"><?php echo date('d', strtotime($data->tgl_uji)) . " " . Yii::app()->params['blnArrayInd'][date('n', strtotime($data->tgl_uji)) - 1] . " " . date('Y', strtotime($data->tgl_uji)); ?></div>
                            <div class="tgl_mati_uji">
                                <?php
                                $tgl_mati_uji = date("d", strtotime($data->tgl_mati_uji));
                                $bulan_mati_uji = date("n", strtotime($data->tgl_mati_uji));
                                $thn_mati_uji = date("Y", strtotime($data->tgl_mati_uji));
                                $bln_mati_uji = Yii::app()->params['blnArrayInd'][$bulan_mati_uji - 1];
                                echo $tgl_mati_uji . " " . $bln_mati_uji . " " . $thn_mati_uji;
                                ?>
                            </div>
                            <div class="nama_penguji"><u><?php echo $data->nm_penguji; ?></u></div>
                            <div class="nrp_penguji"><?php echo $data->nrp; ?></div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
        <script type="text/javascript">
            window.print();
            setTimeout(window.close, 0);
        </script>

    </body>
</html>
