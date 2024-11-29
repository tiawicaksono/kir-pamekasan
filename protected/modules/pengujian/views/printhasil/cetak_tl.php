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
        /* .pages {
        page-break-after: always;
        }*/

        .pages {
            page-break-after: always;
            overflow: hidden;
            /*border: 1px solid black;*/
            padding: 40px;
            /*letter-spacing: 3pt;*/
            /*line-height:3em;*/
            font-style: normal;
            font-variant: normal;
        }

        .center {
            text-align: center;
        }

        #header {
            text-align: center;
            letter-spacing: 4px;
            font-size: 12pt;
            padding-left: 120px;
            margin-bottom: 20px;
        }

        #underline-gap {
            text-decoration: underline;
            text-underline-position: under;
            margin-bottom: 10px;
        }
    }
</style>
<div class="pages">
    <?php
    $dataProses = VPrintHasil::model()->findByAttributes(array('id_hasil_uji' => $id));
    $dataHasilUji = TblHasilUji::model()->findByPk($id);
    $dataKendaraan = VKendaraan::model()->findByAttributes(array('id_kendaraan' => $dataProses->id_kendaraan));
    $criteriaPenguji = new CDbCriteria();
    $criteriaPenguji->addCondition('nrp like \'%' . $nrp . '%\'');
    $dataPenguji = TblNamaPenguji::model()->find($criteriaPenguji);
    ?>
    <div id="header">
        <img style="position: absolute; margin-left: -120px" src="<?php echo Yii::app()->baseUrl . "/images/logo.png"; ?>" width="120px" />
        <span style="font-weight: bold; font-size: 18pt;">
            PEMERINTAH KABUPATEN PAMEKASAN<br />
            DINAS PERHUBUNGAN<br />
        </span>
        Jl. Bonorogo No.88 Telp. (0324) 326130,322440 / Fax (0324) 322516<br />
        PAMEKASAN<br />
    </div>
    <hr />
    <center><u>SURAT KETERANGAN TIDAK LULUS UJI</u><br />
        <div id="no_surat">551.23 / <?php echo strtoupper($dataHasilUji->no_tl); ?> / <?php
                                                                                        $bln = date('n');
                                                                                        switch ($bln) {
                                                                                            case 1:
                                                                                                echo 'I';
                                                                                                break;
                                                                                            case 2:
                                                                                                echo 'II';
                                                                                                break;
                                                                                            case 3:
                                                                                                echo 'III';
                                                                                                break;
                                                                                            case 4:
                                                                                                echo 'IV';
                                                                                                break;
                                                                                            case 5:
                                                                                                echo 'V';
                                                                                                break;
                                                                                            case 6:
                                                                                                echo 'VI';
                                                                                                break;
                                                                                            case 7:
                                                                                                echo 'VII';
                                                                                                break;
                                                                                            case 8:
                                                                                                echo 'VIII';
                                                                                                break;
                                                                                            case 9:
                                                                                                echo 'IX';
                                                                                                break;
                                                                                            case 10:
                                                                                                echo 'X';
                                                                                                break;
                                                                                            case 11:
                                                                                                echo 'XI';
                                                                                                break;
                                                                                            case 12:
                                                                                                echo 'XII';
                                                                                                break;
                                                                                        }
                                                                                        ?> / 432.313 / <?php echo date('Y'); ?></div>
    </center>
    <p></p>
    <p></p>
    <?php
    $hari = date("D");

    switch ($hari) {
        case 'Sun':
            $hari_ini = "Minggu";
            break;

        case 'Mon':
            $hari_ini = "Senin";
            break;

        case 'Tue':
            $hari_ini = "Selasa";
            break;

        case 'Wed':
            $hari_ini = "Rabu";
            break;

        case 'Thu':
            $hari_ini = "Kamis";
            break;

        case 'Fri':
            $hari_ini = "Jumat";
            break;

        case 'Sat':
            $hari_ini = "Sabtu";
            break;

        default:
            $hari_ini = "Tidak di ketahui";
            break;
    }
    ?>
    Pada hari <?php echo $hari_ini . " tanggal " . date('d') . " bulan " . Yii::app()->params['bulanArrayInd'][date('n') - 1] . " tahun " . date('Y'); ?> bertempat di Unit Pengujian Kendaraan Bermotor Dinas Perhubungan Kab. Pamekasan, yang bertanda tangan dibawah ini :<br />
    <table style="margin-top: 20px; margin-bottom: 20px;">
        <tr>
            <td width="150px">Nama</td>
            <td> : </td>
            <td><?php echo $dataPenguji->nama_penguji; ?></td>
        </tr>
        <tr>
            <td>NRP</td>
            <td> : </td>
            <td><?php echo $dataPenguji->nrp; ?></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td> : </td>
            <td><?php echo $dataPenguji->jabatan; ?></td>
        </tr>
    </table>
    Menyatakan bahwa kendaraan bermotor :
    <table style="margin-top: 20px; margin-bottom: 20px;">
        <tr>
            <td width="150px">Nomor Uji</td>
            <td> : </td>
            <td><?php echo $dataKendaraan->no_uji; ?></td>
        </tr>
        <tr>
            <td>Nomor Kendaraan</td>
            <td> : </td>
            <td><?php echo $dataKendaraan->no_kendaraan; ?></td>
        </tr>
        <tr>
            <td>Merk</td>
            <td> : </td>
            <td><?php echo $dataKendaraan->merk; ?></td>
        </tr>
        <tr>
            <td>Tipe</td>
            <td> : </td>
            <td><?php echo $dataKendaraan->tipe; ?></td>
        </tr>
        <tr>
            <td>Jenis Kendaraan</td>
            <td> : </td>
            <td><?php echo $dataKendaraan->karoseri_jenis; ?></td>
        </tr>
        <tr>
            <td>Nomor Rangka</td>
            <td> : </td>
            <td><?php echo $dataKendaraan->no_chasis; ?></td>
        </tr>
        <tr>
            <td>Nomor Mesin</td>
            <td> : </td>
            <td><?php echo $dataKendaraan->no_mesin; ?></td>
        </tr>
        <tr>
            <td>Nama Pemilik</td>
            <td> : </td>
            <td><?php echo $dataKendaraan->nama_pemilik; ?></td>
        </tr>
        <tr>
            <td>Alamat Pemilik</td>
            <td> : </td>
            <td><?php echo $dataKendaraan->alamat; ?></td>
        </tr>
    </table>
    Dengan hasil pemeriksaan persyaratan teknis dan persyaratan laik jalan, terdapat komponen yang tidak memenuhi persyaratan teknis dan laik jalan sebagai berikut :
    <?php
    $data = VDetailTl::model()->findAllByAttributes(array('id_hasil_uji' => $id));
    $ul = "<ol>";
    foreach ($data as $p) {
        $ul .= "<li>" . $p->kelulusan . "</li>";
    }
    $ul .= "</ol>";
    echo $ul;
    ?>
    <?php
    $tglUji = date("m/d/Y", strtotime($dataProses->jdatang));
    $tglMaxBerlaku = date('m/d/Y', strtotime('+6 days', strtotime($tglUji)));
    $explodeTglUji = explode('/', $tglUji);
    $explodeTglBerlaku = explode('/', $tglMaxBerlaku);
    // echo $explodeTglBerlaku[1] . " " . Yii::app()->params['bulanArrayInd'][$explodeTglBerlaku[0] - 1] . " " . $explodeTglBerlaku[2];
    ?>
    <br />
    Berdasarkan data hasil pemeriksaan persyaratan teknis dan persyaratan laik jalan diatas maka kendaraan tersebut dinyatakan <b>TIDAK LULUS UJI</b>.
    <br />
    Demikian keterangan ini dibuat, selanjutnya kepada pemilik kendaraan agar memperbaiki komponen tersebut dan melakukan uji ulang sebelum tanggal
    <?php echo $explodeTglBerlaku[1] . " " . Yii::app()->params['bulanArrayInd'][$explodeTglBerlaku[0] - 1] . " " . $explodeTglBerlaku[2]; ?>. <br />
    Di Unit Pelaksana Uji Berkala Kendaraan Bermotor Dishub Kab. Pamekasan.
    <div style="float:right;">
        <table style="margin-top: 40px; margin-right: 10px;">
            <tr>
                <td>&nbsp;</td>
                <td>
                    Yang membuat keterangan
                    <br />
                    <?php echo $dataPenguji->jabatan; ?>
                    <br /><br /><br /><br /><br />
                    <b id="underline-gap"><?php echo $dataPenguji->nama_penguji; ?></b>
                    <br />
                    <span>NIP. <?php echo $nrp; ?></span>
                </td>
            </tr>
        </table>
    </div>
</div>
<script type="text/javascript">
    window.print();
    // setTimeout(window.close, 0);
</script>