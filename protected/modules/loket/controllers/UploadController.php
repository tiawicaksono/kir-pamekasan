<?php

class UploadController extends Controller
{

    public function filters()
    {
        return array(
            'Rights',
        );
    }

    public function actionIndex()
    {
        $this->render('upload');
    }

    /* =========================================================================
     * UPLOAD AND DOWNLOAD EXCEL NILAI
      ========================================================================= */

    public function actionReadUpload()
    {
        $file = $_FILES['myfile']['tmp_name'];
        Yii::import("ext.PHPExcel", TRUE);
        Yii::import('ext.PHPExcel.IOFactory', TRUE);

        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($file);

        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        for ($row = 1; $row <= $highestRow; $row++) {
            //===========VARIABLLE===========
            $no_uji = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
            $no_kendaraan = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
            $nama_pemilik = str_replace("'", "`", $objWorksheet->getCellByColumnAndRow(3, $row)->getValue());
            $nik = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
            $jk = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
            if ($jk == 'L') {
                $jenis_kelamin = 'LAKI-LAKI';
            } else {
                $jenis_kelamin = 'PEREMPUAN';
            }
            $tempat_lahir = $objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
            $alamat = str_replace("'", "`", $objWorksheet->getCellByColumnAndRow(11, $row)->getValue());
            $jns = $objWorksheet->getCellByColumnAndRow(14, $row)->getValue();
            if ($jns == 'M. BARANG') {
                $id_jns = 0;
            } else if ($jns == 'M. BUS') {
                $id_jns = 2;
            } else if ($jns == 'M. PENUMPANG') {
                $id_jns = 1;
            } else if ($jns == 'K. GANDENGAN') {
                $id_jns = 4;
            } else if ($jns == 'K. TEMPELAN') {
                $id_jns = 5;
            } else {
                $id_jns = 0;
            }
            $nm_komersil = $objWorksheet->getCellByColumnAndRow(15, $row)->getValue();
            $merk = $objWorksheet->getCellByColumnAndRow(23, $row)->getValue();
            $tipe = $objWorksheet->getCellByColumnAndRow(24, $row)->getValue();
            $isi_silinder = $objWorksheet->getCellByColumnAndRow(25, $row)->getValue();
            $daya_motor = $objWorksheet->getCellByColumnAndRow(26, $row)->getValue();
            $bahan_bakar = $objWorksheet->getCellByColumnAndRow(27, $row)->getValue();
            $thn = $objWorksheet->getCellByColumnAndRow(28, $row)->getValue();
            $stts = $objWorksheet->getCellByColumnAndRow(29, $row)->getValue();
            if ($stts == 'U') {
                $status = 'UMUM';
            } else {
                $status = 'TIDAK UMUM';
            }
            $no_rangka = $objWorksheet->getCellByColumnAndRow(38, $row)->getValue();
            $no_mesin = $objWorksheet->getCellByColumnAndRow(39, $row)->getValue();
            $panjang = $objWorksheet->getCellByColumnAndRow(40, $row)->getValue();
            $lebar = $objWorksheet->getCellByColumnAndRow(41, $row)->getValue();
            $tinggi = $objWorksheet->getCellByColumnAndRow(42, $row)->getValue();
            $roh = $objWorksheet->getCellByColumnAndRow(43, $row)->getValue();
            $foh = $objWorksheet->getCellByColumnAndRow(44, $row)->getValue();
            $jsmb1 = $objWorksheet->getCellByColumnAndRow(45, $row)->getValue();
            $jsmb2 = $objWorksheet->getCellByColumnAndRow(46, $row)->getValue();
            $jsmb3 = $objWorksheet->getCellByColumnAndRow(47, $row)->getValue();
            $q = $objWorksheet->getCellByColumnAndRow(48, $row)->getValue();
            $p1 = $objWorksheet->getCellByColumnAndRow(49, $row)->getValue();
            $p2 = $objWorksheet->getCellByColumnAndRow(50, $row)->getValue();
            $panjang_bak = $objWorksheet->getCellByColumnAndRow(51, $row)->getValue();
            $lebar_bak = $objWorksheet->getCellByColumnAndRow(52, $row)->getValue();
            $tinggi_bak = $objWorksheet->getCellByColumnAndRow(53, $row)->getValue();
            $bahan_bak = $objWorksheet->getCellByColumnAndRow(54, $row)->getValue();
            $pemakaian_sb_ban = $objWorksheet->getCellByColumnAndRow(55, $row)->getValue();
            $konf_sumbu = str_replace('-', '.', $objWorksheet->getCellByColumnAndRow(56, $row)->getValue());
            $jbb = $objWorksheet->getCellByColumnAndRow(57, $row)->getValue();
            $berat_sumbu1 = $objWorksheet->getCellByColumnAndRow(58, $row)->getValue();
            $berat_sumbu2 = $objWorksheet->getCellByColumnAndRow(59, $row)->getValue();
            $berat_sumbu3 = $objWorksheet->getCellByColumnAndRow(60, $row)->getValue();
            $berat_sumbu4 = $objWorksheet->getCellByColumnAndRow(61, $row)->getValue();
            $daya_orang = $objWorksheet->getCellByColumnAndRow(62, $row)->getValue();
            $daya_barang = $objWorksheet->getCellByColumnAndRow(63, $row)->getValue();
            $mst = $objWorksheet->getCellByColumnAndRow(65, $row)->getValue();
            $kls_jln = $objWorksheet->getCellByColumnAndRow(66, $row)->getValue();
            $kelas_jalan = 'III';
            if ($kls_jln != '') {
                if (strtoupper($kls_jln) == 'I') {
                    $kelas_jalan = 'I';
                } elseif (strtoupper($kls_jln) == 'II') {
                    $kelas_jalan = 'II';
                } elseif (strtoupper($kls_jln) == 'III') {
                    $kelas_jalan = 'III';
                } else {
                    $kelas_jalan = 'III';
                }
            }
            //CEK DATA SUDAH ADA ATAU BELUM
            $data_kendaraan = TblKendaraan::model()->findByAttributes(array('no_uji' => $no_uji));
            if (empty($data_kendaraan)) {
                $tbl = new TblKendaraan();
                $tbl->no_uji = $no_uji;
                $tbl->no_kendaraan = $no_kendaraan;
                $tbl->nama_pemilik = $nama_pemilik;
                $tbl->no_identitas = $nik;
                $tbl->kelamin = $jenis_kelamin;
                $tbl->tmp_lahir = $tempat_lahir;
                $tbl->alamat = $alamat;
                $tbl->jenis = $jns;
                $tbl->id_jns_kend = $id_jns;
                $tbl->merk = $merk;
                $tbl->tipe = $tipe;
                $tbl->tahun = $thn;
                $tbl->sifat = $status;
                $tbl->no_chasis = $no_rangka;
                $tbl->no_mesin = $no_mesin;
                $tbl->save();
            } else {
                $id_kendaraan = $data_kendaraan->id_kendaraan;
                $sql = "UPDATE tbl_kendaraan SET no_kendaraan='$no_kendaraan',nama_pemilik='$nama_pemilik',no_identitas='$nik',"
                    . "kelamin='$jenis_kelamin',tmp_lahir='$tempat_lahir',alamat='$alamat',jenis='$jns',id_jns_kend='$id_jns',merk='$merk',"
                    . "tipe='$tipe',tahun='$thn',sifat='$status',no_chasis='$no_rangka',no_mesin='$no_mesin' where id_kendaraan=$id_kendaraan";
                Yii::app()->db->createCommand($sql)->execute();

                $sql = "UPDATE tbl_type SET nm_komersil='$nm_komersil',isi_silinder='$isi_silinder',daya_motor='$daya_motor',bahan_bakar='$bahan_bakar',"
                    . "ukuran_panjang='$panjang',ukuran_lebar='$lebar',ukuran_tinggi='$tinggi',bagian_belakang='$roh',bagian_depan='$foh',"
                    . "jsumbu1='$jsmb1',jsumbu2='$jsmb2',jsumbu3='$jsmb3',ukq='$q',ukp='$p1',ukp2='$p2',dimpanjang='$panjang_bak',dimlebar='$lebar_bak',"
                    . "dimtinggi='$tinggi_bak',karoseri_bahan='$bahan_bak',psumbu1='$pemakaian_sb_ban',konsumbu='$konf_sumbu',kemjbb='$jbb',"
                    . "bsumbu1='$berat_sumbu1',bsumbu2='$berat_sumbu2',bsumbu3='$berat_sumbu3',bsumbu4='$berat_sumbu4',kemorang='$daya_orang',"
                    . "kembarang='$daya_barang',mst1='$mst',kls_jln='$kelas_jalan' where id_kendaraan=$id_kendaraan";
                Yii::app()->db->createCommand($sql)->execute();
            }
        }
    }

    public function actionHai()
    {
        $sql = "select id_kendaraan from tbl_kendaraan where id_kendaraan not in (select id_kendaraan from tbl_type)";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($data as $adat) {
            //            $id_kendaraan = $adat['id_kendaraan'];
            //            $qsl = "INSERT INTO tbl_type(id_kendaraan) VALUES($id_kendaraan)";
            //            Yii::app()->db->createCommand($qsl)->execute();
            echo $adat['id_kendaraan'];
            echo "<br />";
        }
    }
}
