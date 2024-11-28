<html lang="en">

<head>
    <style>
        .pages {
            /*                width: 24cm;
                                height: 28cm;*/
            margin: 0;
            overflow: hidden;
        }

        @page {
            margin-left: 0px;
            margin-right: 0px;
            margin-top: 0px;
            margin-bottom: 0px;
        }

        @media print {
            .pages {
                page-break-after: always;
                overflow: hidden;
                padding: 20px;
                font-style: normal;
                font-variant: normal;
                font-size: 12pt;
            }

            .center {
                text-align: center;
            }

            #header {
                text-align: center;
                letter-spacing: 2px;
                font-size: 10pt;
                padding-left: 90px;
                margin-bottom: 20px;
            }

            #header2 {
                width: 100%;
            }

            #sebelah_kiri {
                float: left;
                width: 50%;
            }

            #sebelah_kanan {
                float: left;
                width: 50%;
            }

            #logo_kab_situbondo {
                position: absolute;
                margin-left: -120px;
            }

            .ttd {
                height: 70px;
            }
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">
    <title>Print Rekom</title>
</head>

<body>
    <div class="pages watermarked">
        <?php
        $path = $this->module->assetsUrl;
        $dataRekom = TblRekom::model()->findByPk($id_rekom);
        $dataKendaraan = VKendaraan::model()->findByAttributes(array('id_kendaraan' => $id_kendaraan));
        $dataKota = MKota::model()->findByAttributes(array('id_kota' => $dataRekom->id_kota_mutmas));
        $dataProvinsi = MProvinsi::model()->findByAttributes(array('id_provinsi' => $dataRekom->id_provinsi_mutmas));
        ?>
        <div id="header">
            <img id="logo_kab_situbondo" src="<?php echo Yii::app()->baseUrl . "/images/logo.png"; ?>" width="120px" />
            <span style="font-weight: bold; font-size: 18pt; letter-spacing: 4px;">
                PEMERINTAH KABUPATEN PAMEKASAN<br />
                DINAS PERHUBUNGAN<br />
            </span>
            <div style="margin-top:10px;">Jl. Bonorogo No.88 Telp. (0324) 326130, 322440 Fax. (0324) 322516 <br />PAMEKASAN 69323<br /></div>
        </div>
        <hr />
        <center><u>SURAT KETERANGAN</u><br />
            <div id="no_surat">Nomor : 551.23/<?php echo $dataRekom->no_surat; ?>/432.313/<?php echo date('Y'); ?></div>
        </center>
        <p></p>
        <p></p>
        <div style="margin-left: 25px;">
            Dengan memperhatikan :
        </div>
        <div>
            <ol type="a">
                <li>
                    &nbsp;&nbsp;Permohonan pemilik.
                </li>
                <?php
                if (($id_uji != 9) && ($dataRekom->mutmasuk == true)) {
                ?>
                    <li>
                        &nbsp;&nbsp;Surat Mutasi Masuk No. <?php echo $dataRekom->no_rekom_mutmasuk; ?> dari DISHUB <?php echo $dataKota->nama; ?>
                        <br />
                        &nbsp;&nbsp;Tanggal Surat Rekom :
                        <?php
                        $a = date("d", strtotime($dataRekom->tgl_rekom_mutmas));
                        $b = date("n", strtotime($dataRekom->tgl_rekom_mutmas));
                        $b2 = Yii::app()->params['bulanArrayInd'][$b - 1];
                        $c = date("Y", strtotime($dataRekom->tgl_rekom_mutmas));
                        echo $a . " " . $b2 . " " . $c;
                        ?>
                    </li>
                <?php } ?>
                <?php
                if ($dataKendaraan->no_regis != '-' && !empty($dataKendaraan->no_regis) && $dataKendaraan->no_regis != '') {
                ?>
                    <li>
                        &nbsp;&nbsp;No. SRUT <?php echo $dataKendaraan->no_regis; ?>
                        <br />
                        &nbsp;&nbsp;Tanggal Surat Rekom :
                        <?php
                        $a = date("d", strtotime($dataKendaraan->tgl_regis));
                        $b = date("n", strtotime($dataKendaraan->tgl_regis));
                        $b2 = Yii::app()->params['bulanArrayInd'][$b - 1];
                        $c = date("Y", strtotime($dataKendaraan->tgl_regis));
                        echo $a . " " . $b2 . " " . $c;
                        ?>
                    </li>
                <?php } ?>
            </ol>
        </div>
        <div>
            <ol>
                <li>
                    Dengan ini menerangkan bahwa kendaraan bermotor tersebut dibawah ini :
                    <table style="margin-left: 25px; margin-top: 10px; margin-bottom: 10px;">
                        <tr>
                            <td>a.</td>
                            <td width="230px">No. Uji / No. Kendaraan</td>
                            <td> : </td>
                            <td>
                                <?php
                                if ($id_uji != 9) {
                                    echo $dataKendaraan->no_uji . ' / ' . $dataKendaraan->no_kendaraan;
                                } else {
                                    echo "BARU";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>b.</td>
                            <td>Nama Pemilik</td>
                            <td> : </td>
                            <td><?php echo $dataKendaraan->nama_pemilik; ?></td>
                        </tr>
                        <tr>
                            <td valign="top">c.</td>
                            <td valign="top">Alamat Pemilik</td>
                            <td valign="top"> : </td>
                            <td valign="top"><?php echo $dataKendaraan->alamat; ?></td>
                        </tr>
                        <tr>
                            <td>d.</td>
                            <td>Jenis Kendaraan</td>
                            <td> : </td>
                            <td><?php echo $dataKendaraan->jenis; ?></td>
                        </tr>
                        <tr>
                            <td>e.</td>
                            <td>Merk / Tipe / Tahun</td>
                            <td> : </td>
                            <td><?php echo $dataKendaraan->merk . " / " . $dataKendaraan->tipe . " / " . $dataKendaraan->tahun; ?></td>
                        </tr>
                        <tr>
                            <td>f.</td>
                            <td>Nomor Rangka / Landasan</td>
                            <td> : </td>
                            <td><?php echo $dataKendaraan->no_chasis; ?></td>
                        </tr>
                        <tr>
                            <td>g.</td>
                            <td>Nomor Mesin</td>
                            <td> : </td>
                            <td><?php echo $dataKendaraan->no_mesin; ?></td>
                        </tr>
                        <tr>
                            <td>h.</td>
                            <td>Bahan Bakar</td>
                            <td> : </td>
                            <td><?php echo $dataKendaraan->bahan_bakar; ?></td>
                        </tr>
                        <tr>
                            <td>i.</td>
                            <td>Nama Pembuat/Perakit/Pengimpor</td>
                            <td> : </td>
                            <td><?php echo $dataKendaraan->pengimport == "" ? "-" : $dataKendaraan->pengimport; ?></td>
                        </tr>
                    </table>
                </li>
                <?php if ($dataRekom->ubhbentuk == true) { ?>
                    <li style="margin-top: 30px">
                        Mengajukan ubah bentuk kendaraan : <?php echo strtoupper($dataRekom->ket_ubah_bentuk); ?>
                    </li>
                <?php } ?>
                <?php if ($dataRekom->ubhsifat == true) { ?>
                    <li style="margin-top: 30px">
                        Mengajukan ubah sifat kendaraan : <?php echo strtoupper($dataRekom->ket_ubah_sifat); ?>
                    </li>
                <?php } ?>
                <li style="margin-top: 30px">
                    <!-- Setelah diadakan penelitian dapat memenuhi syarat kendaraan wajib uji untuk : <br/>
                        Diuji berkala di Dinas Perhubungan Kabupaten Pamekasan sebagai mobil barang (truck/pickup/box) / mobil bis (umum/bukan umum) 
                        untuk angkutan barang dengan menggunakan bak terbuka/tertutup.-->
                    Setelah diadakan penelitian dapat memenuhi syarat kendaraan wajib uji untuk : <br />
                    Diuji berkala di Dinas Perhubungan Kabupaten Pamekasan sebagai <?php echo $dataKendaraan->nm_komersil . ' ( ' . $dataKendaraan->jenis . ' - ' . $dataKendaraan->sifat . ' )'; ?>
                </li>
                <li style="margin-top: 30px">
                    Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
                </li>
            </ol>
        </div>

        <div style="float:right;">
            <?php
            $dtKadis = TblKepalaDinas::model()->findByAttributes(array('id_kepala_dinas' => $ttd));
            ?>
            <table style="margin-top: 10px; margin-right: 10px;">
                <tr>
                    <td align="center">
                        Pamekasan, <?php echo date('d') . " " . Yii::app()->params['bulanArrayInd'][date('n') - 1] . " " . date('Y'); ?><br />
                        KEPALA DINAS PERHUBUNGAN
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        KABUPATEN PAMEKASAN
                    </td>
                </tr>



                <?php
                if ($ttd == 2) {
                ?>
                    <tr>
                        <td align="center">
                            U.b
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            Kepala Bidang Pengujian Kendaraan Bermotor
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td align="center" class="ttd">
                        <!--<img id="ttd" src="<?php // echo Yii::app()->baseUrl . "/images/ttd_kadis.png";      
                                                ?>" width="170px" />-->
                    </td>
                </tr>
                <tr>
                    <td align="center"><b><u><?php echo $dtKadis->nama; ?></u></b></td>
                </tr>
                <tr>
                    <td align="center"><?php echo $dtKadis->pangkat; ?></td>
                </tr>
                <tr>
                    <td align="center">NIP. <?php echo $dtKadis->nip; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        window.print();
        //            setTimeout(window.close, 0);
    </script>
</body>

</html>