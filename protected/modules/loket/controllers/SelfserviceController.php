<?php

class SelfserviceController extends Controller
{
    // public $layout = '//layouts/main_top';
    public $layout = '//';
    public function actionCobaprint()
    {
        $this->render('print');
    }
    public function actionIndex()
    {
        $this->render('index');
    }
    public function actionIkm()
    {
        $this->render('ikm');
    }
    public function actionRetribusi()
    {
        $this->render('retribusi');
    }
    public function actionSaveIkm()
    {
        $pilihan = $_POST['pilihan'];
        $now = date("m/d/Y");
        $dt_TblIkm = TblIkm::model()->findByAttributes(array('tgl_ikm' => $now));
        if (empty($dt_TblIkm)) {
            if ($pilihan == 'sp') {
                $query = "insert into tbl_ikm(sangat_puas) values (1)";
            } else if ($pilihan == 'p') {
                $query = "insert into tbl_ikm(puas) values (1)";
            } else if ($pilihan == 'tp') {
                $query = "insert into tbl_ikm(tidak_puas) values (1)";
            }
            Yii::app()->db->createCommand($query)->execute();
        } else {
            if ($pilihan == 'sp') {
                $data_sp = $dt_TblIkm->sangat_puas + 1;
                $query = "update tbl_ikm set sangat_puas = $data_sp where tgl_ikm = '$now'";
            } else if ($pilihan == 'p') {
                $data_p = $dt_TblIkm->puas + 1;
                $query = "update tbl_ikm set puas = $data_p where tgl_ikm = '$now'";
            } else if ($pilihan == 'tp') {
                $data_tp = $dt_TblIkm->tidak_puas + 1;
                $query = "update tbl_ikm set tidak_puas = $data_tp where tgl_ikm = '$now'";
            }
            Yii::app()->db->createCommand($query)->execute();
        }
        echo json_encode($pilihan);
    }
    public function actionCekDataKendaraan()
    {
        $no_sb = strtoupper($_POST['no_sb']);
        $result = VKendaraan::model()->getDataKendaraan($no_sb);
        if (!empty($result)) {
            $data['id_kendaraan'] = $result->id_kendaraan;
            $data['no_uji'] = $result->no_uji;
            $data['no_kendaraan'] = $result->no_kendaraan;
            $data['nama_pemilik'] = $result->nama_pemilik;
            $data['alamat_pemilik'] = $result->alamat;
        } else {
            $data = 0;
        }
        echo json_encode($data);
    }

    public function actionSaveRetribusi()
    {
        $ID_KENDARAAN = $_POST['id_kendaraan'];
        $data_kendaraan = VKendaraan::model()->findByAttributes(array('id_kendaraan' => $ID_KENDARAAN));
        $userlogin = 'self service';
        $JENIS_PENGUJIAN = $_POST['jenis_uji'];
        $tgl_retribusi = date("m/d/Y");
        $newDate_retribusi = date("d F Y", strtotime($tgl_retribusi));
        $TGL_PENGUJIAN = date("m/d/Y");
        $WILAYAH_ASAL = 'PMKSN';
        /**
         * 2 = Numpang Masuk
         * 4 = Mutasi Masuk
         */
        // if ($JENIS_PENGUJIAN == 4) {
        //     $dt_TblRekom = TblRekom::model()->findByAttributes(array('id_kendaraan' => $ID_KENDARAAN, 'mutmasuk' => 'true'), array(
        //         'order' => 'id_rekom desc',
        //         'limit' => 1,
        //     ));
        //     $id_kota = $dt_TblRekom->id_kota_mutmas;
        //     $dt_TblKota = MKota::model()->findByAttributes(array('id_kota' => $id_kota));
        //     $nm_kota = $dt_TblKota->nama;

        //     $criteria = new CDbCriteria;
        //     $criteria->addCondition("namawilayah ilike '%$nm_kota%'");
        //     $data_kode_wilayah = Kodewilayah::model()->find($criteria);
        //     $WILAYAH_ASAL = $data_kode_wilayah->namawilayah;
        // }


        $tanda_pengenal = $data_kendaraan->identitas;
        $BUKU_UJI = 1;
        $PLAT_UJI = 1;
        $NO_STUK = $data_kendaraan->no_uji;
        $NO_KENDARAAN = $data_kendaraan->no_kendaraan;
        $JENIS_KENDARAAN = $data_kendaraan->id_jns_kend;
        $TGL_MATI_UJI = empty($data_kendaraan->tgl_mati_uji) ? date("m/d/Y") : $data_kendaraan->tgl_mati_uji;
        $NAMA_PEMILIK = str_replace("'", "`", strtoupper($data_kendaraan->nama_pemilik));
        $ALAMAT = str_replace("'", "`", strtoupper($data_kendaraan->alamat));
        $NO_KTP = strtoupper($data_kendaraan->no_identitas);
        $NO_TELP = strtoupper($data_kendaraan->no_telp);
        $NO_MESIN = strtoupper($data_kendaraan->no_mesin);
        $NO_CHASIS = strtoupper($data_kendaraan->no_chasis);
        $NUMERATOR = 0;
        $JBB = strtoupper($data_kendaraan->kemjbb);

        $data_kendaraan_db = $NO_STUK . '~' . $NO_KENDARAAN . '~' . $NO_CHASIS . '~' . $NO_MESIN . '~' . $ID_KENDARAAN . '~' . $JENIS_KENDARAAN . '~' . $JBB;
        $data_uji = $BUKU_UJI . '~' . $JENIS_PENGUJIAN . '~' . $tgl_retribusi . '~' . $TGL_PENGUJIAN . '~' . $TGL_MATI_UJI . '~' . $NUMERATOR . '~' . $WILAYAH_ASAL . '~' . $PLAT_UJI;
        $data_pemilik = $NAMA_PEMILIK . '~' . $ALAMAT . '~' . $NO_KTP . '~' . $NO_TELP . '~' . $tanda_pengenal;


        //CEK DAFTAR HARI INI
        $criteria = new CDbCriteria();
        $criteria->addCondition('id_kendaraan = ' . $ID_KENDARAAN);
        $criteria->addCondition("tgl_uji =  '$TGL_PENGUJIAN'");
        $data = TblRetribusi::model()->find($criteria);
        if (empty($data)) {
            $td = 'false';
            $result['ada'] = 'true';
            $result['message'] = "\"" . $NO_STUK . '" berhasil didaftarkan';
            $inputRetribusi = "Select insert_retribusi( '" . $userlogin . "', '" . $data_kendaraan_db . "','" . $data_uji . "','" . $data_pemilik . "','" . $td . "')";
            Yii::app()->db->createCommand($inputRetribusi)->query();
            $criteria = new CDbCriteria();
            $criteria->limit = 1;
            $criteria->addCondition("id_kendaraan = $ID_KENDARAAN");
            $criteria->addCondition("tgl_retribusi = '$tgl_retribusi'");
            $dt_VValidasi = VValidasi::model()->find($criteria);
            $nomor = $dt_VValidasi->numerator;
        } else {
            $result['ada'] = 'false';
            $result['message'] = "\"" . $NO_STUK . '" sudah terdaftar hari ini';
        }
        $result['nouji'] = $NO_STUK;
        $result['nokendaraan'] = $NO_KENDARAAN;
        $result['namapemilik'] = $NAMA_PEMILIK;
        $result['alamatpemilik'] = $ALAMAT;
        $result['nomor'] = $nomor;
        $result['tglretribusi'] = $newDate_retribusi;
        echo json_encode($result);
    }
}
