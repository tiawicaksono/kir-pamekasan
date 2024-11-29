<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OtherController
 *
 * @author TIA.WICAKSONO
 */
class OtherController extends Controller
{

    //put your code here

    public function filters()
    {
        return array(
            //            'Rights', // perform access control for CRUD operations
        );
    }

    public function actionGrafik($param)
    {
        $page = 'grafik';
        $year = Yii::app()->params['tahunGrafik'];
        $this->render('grafik_bar', array(
            'year' => $year,
            'param' => $param,
            'page' => $page
        ));
    }

    public function actionGetListHasilPemeriksaan()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        $result = VVerifikasi::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $hasilUji = TblHasilUji::model()->findByAttributes(array('id_hasil_uji' => $p->id_hasil_uji));
            $jdatang = $hasilUji->jdatang;
            $jselesai = $hasilUji->jselesai;
            $dataJson[] = array(
                "ACTIONS" => $p->no_uji,
                "no_antrian" => $p->no_antrian,
                "no_uji" => $p->no_uji,
                "no_kendaraan" => $p->no_kendaraan,
                "nama_pemilik" => $p->nama_pemilik,
                "jam_datang" => date("H:i", strtotime($jdatang)),
                "jam_selesai" => date("H:i", strtotime($jselesai)),
                "prauji" => $p->lulus_prauji == "true" ? "Lulus" : "Tidak Lulus",
                "emisi" => $p->lulus_smoke == "true" ? "Lulus" : "Tidak Lulus",
                "pitlift" => $p->lulus_pitlift == "true" ? "Lulus" : "Tidak Lulus",
                "lampu" => $p->lulus_lampu == "true" ? "Lulus" : "Tidak Lulus",
                "rem" => $p->lulus_break == "true" ? "Lulus" : "Tidak Lulus",
                "status" => $p->hasil == "true" ? "Lulus" : "Tidak Lulus"
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => VVerifikasi::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionAutoComplete()
    {
        if (isset($_REQUEST['term'])) {
            $term = $_REQUEST['term'];
            //                        echo $term;
            $criteria = new CDbCriteria;
            $criteria->compare('lower(user_name)', strtolower($term), true);
            //            $criteria->addCondition('employee_status=1');
            $criteria->limit = 10;
            $datas = TblUser::model()->findAll($criteria);

            $return_array = array();
            foreach ($datas as $data) :
                $return_array[] = array(
                    'id' => $data->id_user,
                    'value' => $data->user_name,
                );
            endforeach;
            //			echo CJSON::encode($return_array);
            if (count($return_array) > 0) {
                echo CJSON::encode($return_array);
            } else {
                $return_array[] = array(
                    'id' => '',
                    'value' => 'data not found!',
                );
                echo CJSON::encode($return_array);
            }
        }
    }

    public function actionUploadFileMaster()
    {
        $file = Yii::getPathOfAlias('webroot') . '/uploads/11.xlsx';
        //        $file = $_FILES['myfile']['tmp_name'];
        Yii::import("ext.PHPExcel.PHPExcel", TRUE);
        Yii::import('ext.PHPExcel.PHPExcel.IOFactory', TRUE);

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($file);

        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIdex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        for ($row = 1; $row <= $highestRow; $row++) {
            //===========VARIABLLE===========
            $no_uji = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
            $no_kendaraan = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
            $pemilik = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
            $alamat = $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
            $kecamatan = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
            $no_chasis = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
            $no_mesin = $objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
            $jenis = $objWorksheet->getCellByColumnAndRow(7, $row)->getValue();
            if ($jenis == "MOBIL BARANG") {
                $id_jenis = 0;
                $jenis_kend = "M. BARANG";
            } else if ($jenis == "MOBIL BIS") {
                $id_jenis = 2;
                $jenis_kend = "M. BIS";
            } else if ($jenis == "MOBIL PENUMPANG") {
                $id_jenis = 1;
                $jenis_kend = "M. PENUMPANG";
            } else if ($jenis == "K.Gandeng") {
                $id_jenis = 4;
                $jenis_kend = "K. GANDENGAN";
            } else if ($jenis == "K.Tempel") {
                $id_jenis = 5;
                $jenis_kend = "K. TEMPELAN";
            } else if ($jenis == "KENDARAAN KHUSUS") {
                $id_jenis = 3;
                $jenis_kend = "K. KHUSUS";
            }
            $stts = $objWorksheet->getCellByColumnAndRow(8, $row)->getValue();
            if ($stts == 'U') {
                $umum = 'UMUM';
            } else {
                $umum = 'BUKAN UMUM';
            }
            $nama_komersil = $objWorksheet->getCellByColumnAndRow(9, $row)->getValue();
            $bahan_bakar = $objWorksheet->getCellByColumnAndRow(10, $row)->getValue();
            $merk = $objWorksheet->getCellByColumnAndRow(12, $row)->getValue();
            $tipe = $objWorksheet->getCellByColumnAndRow(13, $row)->getValue();
            $tahun = $objWorksheet->getCellByColumnAndRow(14, $row)->getValue();
            $tgl_pakai = $objWorksheet->getCellByColumnAndRow(15, $row)->getValue();
            if ($tgl_pakai != "") {
                $awal_pakai = date('m/d/Y', PHPExcel_Shared_Date::ExcelToPHP($tgl_pakai));
            } else {
                $awal_pakai = NULL;
            }
            $karoseri_bahan = $objWorksheet->getCellByColumnAndRow(16, $row)->getValue();
            $no_srut = $objWorksheet->getCellByColumnAndRow(17, $row)->getValue();
            $no_uji_tipe = $objWorksheet->getCellByColumnAndRow(18, $row)->getValue();
            $no_rancang_bangun = $objWorksheet->getCellByColumnAndRow(19, $row)->getValue();
            $no_seri_buku = $objWorksheet->getCellByColumnAndRow(20, $row)->getValue();
            $tgl_srut = $objWorksheet->getCellByColumnAndRow(23, $row)->getValue();
            if ($tgl_srut != "") {
                $tanggal_srut = date('m/d/Y', PHPExcel_Shared_Date::ExcelToPHP($tgl_srut));
            } else {
                $tanggal_srut = NULL;
            }
            $daya_motor = $objWorksheet->getCellByColumnAndRow(24, $row)->getValue();
            $duduk = $objWorksheet->getCellByColumnAndRow(25, $row)->getValue();
            $orang = intval($duduk) * 60;
            $jsb1 = $objWorksheet->getCellByColumnAndRow(26, $row)->getValue();
            $jsb2 = $objWorksheet->getCellByColumnAndRow(27, $row)->getValue();
            $jsb3 = $objWorksheet->getCellByColumnAndRow(28, $row)->getValue();
            $jsb4 = $objWorksheet->getCellByColumnAndRow(29, $row)->getValue();
            $panjang = $objWorksheet->getCellByColumnAndRow(30, $row)->getValue();
            $lebar = $objWorksheet->getCellByColumnAndRow(31, $row)->getValue();
            $tinggi = $objWorksheet->getCellByColumnAndRow(32, $row)->getValue();
            $foh = $objWorksheet->getCellByColumnAndRow(33, $row)->getValue();
            $roh = $objWorksheet->getCellByColumnAndRow(34, $row)->getValue();
            $isi_silinder = $objWorksheet->getCellByColumnAndRow(37, $row)->getValue();
            $jbkb = $objWorksheet->getCellByColumnAndRow(38, $row)->getValue();
            $jbi = $objWorksheet->getCellByColumnAndRow(39, $row)->getValue();
            $konfigurasi_sumbu = $objWorksheet->getCellByColumnAndRow(41, $row)->getValue();
            $pemakaian_sumbu_ban1 = $objWorksheet->getCellByColumnAndRow(42, $row)->getValue();
            $pemakaian_sumbu_ban2 = $objWorksheet->getCellByColumnAndRow(43, $row)->getValue();
            $pemakaian_sumbu_ban3 = $objWorksheet->getCellByColumnAndRow(44, $row)->getValue();
            $pemakaian_sumbu_ban4 = $objWorksheet->getCellByColumnAndRow(45, $row)->getValue();
            $bak_panjang = $objWorksheet->getCellByColumnAndRow(47, $row)->getValue();
            $bak_lebar = $objWorksheet->getCellByColumnAndRow(48, $row)->getValue();
            $bak_tinggi = $objWorksheet->getCellByColumnAndRow(49, $row)->getValue();
            $kls_jalan = $objWorksheet->getCellByColumnAndRow(50, $row)->getValue();
            $mati_uji = $objWorksheet->getCellByColumnAndRow(53, $row)->getValue();
            if ($mati_uji != "") {
                $tanggal_mati_uji = date('m/d/Y', PHPExcel_Shared_Date::ExcelToPHP($mati_uji));
            } else {
                $tanggal_mati_uji = NULL;
            }
            //            $tgl_uji = DateTime::createFromFormat('d/m/Y', $mati_uji);
            //            $tglUji = $tgl_uji->format('m/d/Y');
            //CEK DATA SUDAH ADA ATAU BELUM
            $data_kendaraan = TblKendaraan::model()->findByAttributes(array('no_uji' => $no_uji));
            if (count($data_kendaraan) == 0) {
                $tbl = new TblKendaraan();
                $tbl->no_uji = $no_uji;
                $tbl->no_kendaraan = $no_kendaraan;
                $tbl->nama_pemilik = $pemilik;
                $tbl->alamat = $alamat;
                $tbl->kecamatan = $kecamatan;
                $tbl->no_chasis = $no_chasis;
                $tbl->no_mesin = $no_mesin;
                $tbl->id_jns_kend = $id_jenis;
                $tbl->jenis = $jenis_kend;
                $tbl->merk = $merk;
                $tbl->tipe = $tipe;
                $tbl->tahun = $tahun;
                $tbl->awal_pakai = $awal_pakai;
                $tbl->tgl_mati_uji = $tanggal_mati_uji;
                if ($tbl->save()) {

                    $criteria = new CDbCriteria();
                    $criteria->order = "id_kendaraan DESC";
                    $id_kendaraan = TblKendaraan::model()->find($criteria)->id_kendaraan;

                    $tbl_type = new TblType();
                    $tbl_type->id_kendaraan = $id_kendaraan;
                    $tbl_type->nm_komersil = $nama_komersil;
                    $tbl_type->bahan_bakar = $bahan_bakar;
                    $tbl_type->karoseri_bahan = $karoseri_bahan;
                    $tbl_type->daya_motor = $daya_motor;
                    $tbl_type->karoseri_duduk = $duduk;
                    $tbl_type->kemorang = $orang;
                    $tbl_type->jsumbu1 = $jsb1;
                    $tbl_type->jsumbu2 = $jsb2;
                    $tbl_type->jsumbu3 = $jsb3;
                    $tbl_type->jsumbu4 = $jsb4;
                    $tbl_type->ukuran_panjang = $panjang;
                    $tbl_type->ukuran_lebar = $lebar;
                    $tbl_type->ukuran_tinggi = $tinggi;
                    $tbl_type->bagian_depan = $foh;
                    $tbl_type->bagian_belakang = $roh;
                    $tbl_type->isi_silinder = $isi_silinder;
                    $tbl_type->kemjbkb = $jbkb;
                    $tbl_type->kemjbb = $jbkb;
                    $tbl_type->konsumbu = $konfigurasi_sumbu;
                    $tbl_type->psumbu1 = $pemakaian_sumbu_ban1;
                    $tbl_type->psumbu2 = $pemakaian_sumbu_ban2;
                    $tbl_type->psumbu3 = $pemakaian_sumbu_ban3;
                    $tbl_type->psumbu4 = $pemakaian_sumbu_ban4;
                    $tbl_type->dimpanjang = $bak_panjang;
                    $tbl_type->dimlebar = $bak_lebar;
                    $tbl_type->dimtinggi = $bak_tinggi;
                    $tbl_type->kls_jln = $kls_jalan;
                    $tbl_type->save();

                    $tbl_sertifikasi = new TblSertifikasi();
                    $tbl_sertifikasi->id_kendaraan = $id_kendaraan;
                    $tbl_sertifikasi->no_regis = $no_srut;
                    $tbl_sertifikasi->no_tipe = $no_uji_tipe;
                    $tbl_sertifikasi->no_rancang = $no_rancang_bangun;
                    $tbl_sertifikasi->tgl_regis = $tanggal_srut;
                    $tbl_sertifikasi->save();
                }
            } else {
                echo $no_uji . "<br>";
            }
        }
    }

    public function actionUpdateData()
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'id_kendaraan, merk, bahan_bakar';
        $a = VKendaraan::model()->findAll($criteria);
        foreach ($a as $key => $value) {
            // BAHAN BAKAR
            // if ($value->bahan_bakar == "SOLAR") {
            //     $sql = "UPDATE tbl_kendaraan SET fuel_id=2 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            //     $sql = "UPDATE tbl_type SET bahan_bakar='Solar' where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // } else if ($value->bahan_bakar == "BENSIN") {
            //     $sql = "UPDATE tbl_kendaraan SET fuel_id=1 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            //     $sql = "UPDATE tbl_type SET bahan_bakar='Bensin' where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // } else {
            //     $sql = "UPDATE tbl_kendaraan SET fuel_id=0 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            //     $sql = "UPDATE tbl_type SET bahan_bakar='-' where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }


            // KELAS JALAN
            // if ($value->kls_jln == "I") {
            //     $sql = "UPDATE tbl_kendaraan SET kelasjalan_id=1 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            //     $sql = "UPDATE tbl_type SET kls_jln='KELAS I' where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }else if ($value->kls_jln == "II") {
            //     $sql = "UPDATE tbl_kendaraan SET kelasjalan_id=2 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            //     $sql = "UPDATE tbl_type SET kls_jln='KELAS II' where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }else if ($value->kls_jln == "III") {
            //     $sql = "UPDATE tbl_kendaraan SET kelasjalan_id=54 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            //     $sql = "UPDATE tbl_type SET kls_jln='KELAS III' where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }else{
            //     $sql = "UPDATE tbl_kendaraan SET kelasjalan_id=0 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            //     $sql = "UPDATE tbl_type SET kls_jln='-' where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }

            // MERK
            // if ($value->merk == "AUSTIN") {
            //     $sql = "UPDATE tbl_kendaraan SET merk='Austin', vehicle_brand_id=1 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }
            // if ($value->merk == "DODGE") {
            //     $sql = "UPDATE tbl_kendaraan SET merk='Dodge', vehicle_brand_id=11 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }
            // if ($value->merk == "TATA") {
            //     $sql = "UPDATE tbl_kendaraan SET merk='Tata', vehicle_brand_id=39 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }
            // if ($value->merk == "DFSK") {
            //     $sql = "UPDATE tbl_kendaraan SET merk='DFSK', vehicle_brand_id=1381 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }
            // if ($value->merk == "KIA") {
            //     $sql = "UPDATE tbl_kendaraan SET merk='Kia', vehicle_brand_id=24 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }
            // if ($value->merk == "FOTON") {
            //     $sql = "UPDATE tbl_kendaraan SET merk='FOTON', vehicle_brand_id=1213 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }
            // if ($value->merk == "HINO") {
            //     $sql = "UPDATE tbl_kendaraan SET merk='HINO', vehicle_brand_id=1227 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }
            // if ($value->merk == "MAZDA") {
            //     $sql = "UPDATE tbl_kendaraan SET merk='Mazda', vehicle_brand_id=28 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }
            // if ($value->merk == "MERCEDES BENZ") {
            //     $sql = "UPDATE tbl_kendaraan SET merk='MERCEDES BENZ', vehicle_brand_id=1620 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }
            // if ($value->merk == "WULING") {
            //     $sql = "UPDATE tbl_kendaraan SET merk='WULING', vehicle_brand_id=1409 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }
            // if ($value->merk == "FORD") {
            //     $sql = "UPDATE tbl_kendaraan SET merk='FORD', vehicle_brand_id=1212 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }
            // if ($value->merk == "DAIHATSU") {
            //     $sql = "UPDATE tbl_kendaraan SET merk='Daihatsu', vehicle_brand_id=8 where id_kendaraan = $value->id_kendaraan";
            //     Yii::app()->db->createCommand($sql)->execute();
            // }
            // if ($value->merk == "NISSAN") {
            //     if ($value->bahan_bakar == "SOLAR") {
            //         $sql = "UPDATE tbl_kendaraan SET merk='NISSAN DIESEL', vehicle_brand_id=1448 where id_kendaraan = $value->id_kendaraan";
            //         Yii::app()->db->createCommand($sql)->execute();
            //     } else {
            //         $sql = "UPDATE tbl_kendaraan SET merk='NISSAN', vehicle_brand_id=32 where id_kendaraan = $value->id_kendaraan";
            //         Yii::app()->db->createCommand($sql)->execute();
            //     }
            // }
        }
    }
}
