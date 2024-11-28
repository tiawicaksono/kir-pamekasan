<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RiwayatController extends Controller
{

    public function filters()
    {
        return array(
            'Rights', // perform access control for CRUD operations
        );
    }

    public function actionIndex()
    {
        $this->pageTitle = 'RIWAYAT KENDARAAN';
        $this->render('riwayat');
    }

    public function actionRiwayatListGrid()
    {
        $selectCategory = $_POST['selectCategory'];
        $textCategory = strtoupper($_POST['textCategory']);
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tgl_uji';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        if (!empty($textCategory)) {
            if ($selectCategory == 'no_chasis' || $selectCategory == 'no_mesin') {
                $criteria->addCondition("(replace(LOWER($selectCategory),' ','') like replace(LOWER('%" . $textCategory . "%'),' ',''))");
            } else {
                $criteria->addCondition("(replace(LOWER(no_uji),' ','') like replace(LOWER('%" . $textCategory . "%'),' ','') OR replace(LOWER(no_kendaraan),' ','') like replace(LOWER('" . $textCategory . "'),' ',''))");
            }
        }
        $result = VRiwayat::model()->findAll($criteria);

        $criteriaKend = new CDbCriteria();
        $criteriaKend->addCondition("(replace(LOWER(no_uji),' ','') like replace(LOWER('%" . $textCategory . "%'),' ','') OR replace(LOWER(no_kendaraan),' ','') like replace(LOWER('" . $textCategory . "'),' ',''))");
        $resultKend = TblKendaraan::model()->find($criteriaKend);
        $id_kendaraan = 0;
        if (!empty($resultKend)) {
            $id_kendaraan = $resultKend->id_kendaraan;
        }

        /**
         * REKOM
         */
        $criteriaRekom = new CDbCriteria();
        $criteriaRekom->addCondition("id_kendaraan = $id_kendaraan");
        $criteriaRekom->addCondition("mutke = true or numke = true");
        $resultRekom = TblRekom::model()->findAll($criteriaRekom);

        $dataJsonRekom = array();
        if (!empty($resultRekom)) {
            foreach ($resultRekom as $p) {
                $dataKendaraan = TblKendaraan::model()->findByAttributes(array('id_kendaraan' => $p->id_kendaraan));
                $dtRetribusi = VValidasi::model()->findByAttributes(array('id_kendaraan' => $p->id_kendaraan, 'tgl_retribusi' => $p->tgl_rekom));
                $provinsi_mutke = $p->id_provinsi_mutke;
                $kota_mutke = $p->id_kota_mutke;
                $provinsi_numke = $p->id_provinsi_numke;
                $kota_numke = $p->id_kota_numke;
                if ($p->mutke == true) {
                    $provinsi = '';
                    $kota = '';
                    if (!empty($provinsi_mutke)) {
                        $provinsi = MProvinsi::model()->findByPk($provinsi_mutke)->nama;
                    }
                    if (!empty($kota_mutke)) {
                        $kota = MKota::model()->findByPk($kota_mutke)->nama;
                    }
                } else {
                    $provinsi = '';
                    $kota = '';
                    if (!empty($provinsi_numke)) {
                        $provinsi = MProvinsi::model()->findByPk($provinsi_numke)->nama;
                    }
                    if (!empty($kota_numke)) {
                        $kota = MKota::model()->findByPk($kota_numke)->nama;
                    }
                }

                $tgl_uji_rekom = empty($p->tgl_uji) ? date("d F Y", strtotime($p->tgl_rekom)) : date("d F Y", strtotime($p->tgl_uji));
                $tgl_mati_uji_rekom = empty($p->mati_uji) ? '' : date("d F Y", strtotime($p->mati_uji));
                $dataJsonRekom[] = array(
                    "kartu_kuning" => "",
                    "id_kendaraan" => "",
                    "id_hasil_uji" => "",
                    "bap" => "",
                    "no_uji" => $dataKendaraan->no_uji,
                    "no_kendaraan" => $dataKendaraan->no_kendaraan,
                    "tgl_uji" => $tgl_uji_rekom,
                    "mati_uji" => $tgl_mati_uji_rekom,
                    "nama_penguji" => $p->penguji,
                    "catatan" => "",
                    "keterangan" => substr($dtRetribusi->nm_uji, 6),
                    "kota" => $kota . ", " . $provinsi,
                    "tgl" => date("Y-m-d", strtotime($p->tgl_rekom)),
                    "edit" => $p->id_rekom
                );
            }
        }

        $dataJsonBerkala = array();
        if (!empty($result)) {
            foreach ($result as $p) {
                $dataJsonBerkala[] = array(
                    "kartu_kuning" => $p->id_kendaraan,
                    "id_kendaraan" => $p->id_kendaraan,
                    "id_hasil_uji" => $p->id_hasil_uji,
                    "bap" => $p->id_hasil_uji,
                    "no_uji" => $p->no_uji,
                    "no_kendaraan" => $p->no_kendaraan,
                    "tgl_uji" => date("d F Y", strtotime($p->tgl_uji)),
                    "mati_uji" => date("d F Y", strtotime($p->tglmati)),
                    "nama_penguji" => $p->nama_penguji,
                    "catatan" => $this->catatan($p->id_hasil_uji),
                    "keterangan" => "",
                    "kota" => "",
                    "tgl" => date("Y-m-d", strtotime($p->tgl_uji)),
                    "edit" => 0
                );
            }
        }

        $array_merge = array_merge($dataJsonRekom, $dataJsonBerkala);
        array_multisort(array_map(function ($element) {
            return $element['tgl'];
        }, $array_merge), SORT_DESC, $array_merge);

        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => VRiwayat::model()->count($criteria),
                'rows' => $array_merge,
                'id_kendaraan' => $id_kendaraan,
            )
        );
        Yii::app()->end();
    }

    public function actionRiwayatTlListGrid()
    {
        $selectCategory = $_POST['selectCategory'];
        $textCategory = strtoupper($_POST['textCategory']);
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'jdatang';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;

        if (!empty($textCategory)) {
            if ($selectCategory == 'no_chasis' || $selectCategory == 'no_mesin') {
                $criteria->addCondition("(replace(LOWER($selectCategory),' ','') like replace(LOWER('%" . $textCategory . "%'),' ',''))");
            } else {
                $criteria->addCondition("(replace(LOWER(no_uji),' ','') like replace(LOWER('%" . $textCategory . "%'),' ','') OR replace(LOWER(no_kendaraan),' ','') like replace(LOWER('" . $textCategory . "'),' ',''))");
            }
        }
        $criteria->addCondition('hasil = false');
        $result = VVerifikasi::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $cek = VDetailTl::model()->findByAttributes(array('id_hasil_uji' => $p->id_hasil_uji));
            if (!empty($cek)) {
                $dataJson[] = array(
                    "id_hasil_uji" => $p->id_hasil_uji,
                    "bap" => $p->id_hasil_uji,
                    "no_uji" => $p->no_uji,
                    "no_kendaraan" => $p->no_kendaraan,
                    "tgl_uji" => date("d F Y", strtotime($p->jdatang)),
                    "nama_penguji" => $p->nm_penguji,
                    "catatan" => $this->catatan($p->id_hasil_uji)
                );
            }
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => VVerifikasi::model()->count($criteria),
                'rows' => $dataJson
            )
        );
        Yii::app()->end();
    }

    public function actionViewImage()
    {
        $id_hasil_uji = $_POST['idHasilUji'];
        $data = TblHasilUji::model()->findByPk($id_hasil_uji);
        echo CJSON::encode(
            array(
                'img_depan' => $data->img_depan,
                'img_belakang' => $data->img_belakang,
                'img_kanan' => $data->img_kanan,
                'img_kiri' => $data->img_kiri,
            )
        );
    }

    public function actionDetailKendaraan()
    {
        $id_kendaraan = $_POST['id_kendaraan'];
        $data_kendaraan = VKendaraan::model()->findByAttributes(array('id_kendaraan' => $id_kendaraan));
        $this->renderPartial('detail_kendaraan', array('data' => $data_kendaraan));
    }

    public function actionDetailPengujian()
    {
        $id_hasil_uji = $_POST['id_hasil_uji'];
        $data_hasil_uji = VRiwayatHasil::model()->findByAttributes(array('id_hasil_uji' => $id_hasil_uji));
        $this->renderPartial('detail_pengujian', array('data' => $data_hasil_uji));
    }

    public function actionCetakKartuKuning($id_kendaraan)
    {
        $this->layout = '//';
        $this->render('cetak_kartu_kuning', array('id_kendaraan' => $id_kendaraan));
    }

    private function catatan($id_hasil_uji)
    {
        $data = VDetailTl::model()->findAllByAttributes(array('id_hasil_uji' => $id_hasil_uji));
        $ul = "<ul style='padding:10px;'>";
        foreach ($data as $p) {
            $ul .= "<li>" . $p->kelulusan . "</li>";
        }
        $ul .= "</ul>";
        return $ul;
    }

    public function actionSaveEditNumkeMutke()
    {
        $id_rekom = $_POST['id_rekom'];
        $tgl_uji = $_POST['tgl_uji'];
        $tgl_mati_uji = date('n/j/Y', strtotime('+6 month', strtotime($tgl_uji)));
        $nama_penguji = $_POST['nama_penguji'];
        $sql = "UPDATE tbl_rekom SET penguji='$nama_penguji', tgl_uji='$tgl_uji', mati_uji='$tgl_mati_uji' where id_rekom = $id_rekom";
        Yii::app()->db->createCommand($sql)->execute();
    }
}
