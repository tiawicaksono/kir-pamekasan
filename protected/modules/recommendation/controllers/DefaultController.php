<?php

class DefaultController extends Controller
{

    public function filters()
    {
        return array(
            'Rights', // perform access control for CRUD operations
        );
    }

    public function init()
    {
        $this->defaultAction = 'statusRecommendation';
    }

    //    public function actionIndex() {
    //        
    //    }
    //    ============================================================================
    public function actionStatusRecommendation()
    {
        $this->pageTitle = 'Rekomendasi';
        if (Yii::app()->session['position_id'] == 2) {
            $step = 2;
            $urlAct = 'Default/ListGridRekomKaUpt';
        } elseif (Yii::app()->session['position_id'] == 3) {
            $step = 3;
            $urlAct = 'Default/ListGridRekomKasubag';
        } else {
            $step = 1;
            $urlAct = 'Default/ListGridRekomKaDis';
        }
        $this->render('status_rekomendasi', array('urlAct' => $urlAct, 'step' => $step));
    }

    public function actionPilihStatusRecommendation()
    {
        $step = $_POST['step'];
        $pilihan = $_POST['pilihan'];
        if ($step == 'step1') {
            $step_no = 3;
            $urlAct = 'Default/ListGridRekomKasubag';
        } elseif ($step == 'step2') {
            $step_no = 2;
            $urlAct = 'Default/ListGridRekomKaUpt';
        } else {
            $step_no = 1;
            $urlAct = 'Default/ListGridRekomKaDis';
        }
        $this->renderPartial('proses_' . $pilihan, array('urlAct' => $urlAct, 'step' => $step_no));
    }

    //    ============================================================================    
    public function actionListGridRekomKasubag()
    {
        $pilihan = $_POST['rekom'];
        $tgl_pengajuan_rekom = $_POST['tgl_pengajuan_rekom'];
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_retribusi';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        if ($pilihan == 'mk') {
            $criteria->addCondition('mutke = true');
        } elseif ($pilihan == 'nk') {
            $criteria->addCondition('numke = true');
        } elseif ($pilihan == 'us') {
            $criteria->addCondition('ubhsifat = true');
        }
        $criteria->addCondition("tgl_rekom = TO_DATE('" . $tgl_pengajuan_rekom . "', 'DD-Mon-YY')");
        //        $criteria->addCondition('tgl_rekom = now()::date');
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        $result = TblRekom::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataKendaraan = TblKendaraan::model()->findByAttributes(array('id_kendaraan' => $p->id_kendaraan));
            $dataKotaProp = TblKota::model()->detailKotaPropinsi($p->kd_kota);

            if ($p->confirm_kupt == false) {
                $dataApprove = 0;
            } else {
                $dataApprove = 1;
            }
            $dataJson[] = array(
                "id_rekom" => $p->id_rekom,
                "no_uji" => $dataKendaraan->no_uji,
                "no_kendaraan" => $dataKendaraan->no_kendaraan,
                "pemilik_baru" => $p->pemilik_baru,
                "alamat_baru" => $p->alamat_baru,
                "pemilik" => $dataKendaraan->nama_pemilik,
                "alamat" => $dataKendaraan->alamat,
                "no_surat" => $p->nosurat,
                "propinsi" => $dataKotaProp['propinsi_rel']['nm_propinsi'],
                "kota" => $dataKotaProp['nm_kota'],
                "keterangan" => $p->keterangan,
                "status" => $dataApprove,
                //                "report" => $dataApprove . "_" . $p->id_rekom
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => TblRekom::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionListGridRekomKaUpt()
    {
        $pilihan = $_POST['rekom'];
        $tgl_pengajuan_rekom = $_POST['tgl_pengajuan_rekom'];
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_retribusi';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        if ($pilihan == 'mk') {
            $criteria->addCondition('mutke = true');
        } elseif ($pilihan == 'nk') {
            $criteria->addCondition('numke = true');
        } elseif ($pilihan == 'us') {
            $criteria->addCondition('ubhsifat = true');
        }
        $criteria->addCondition("tgl_rekom = TO_DATE('" . $tgl_pengajuan_rekom . "', 'DD-Mon-YY')");
        //        $criteria->addCondition('tgl_rekom = now()::date');
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        $result = TblRekom::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataKendaraan = TblKendaraan::model()->findByAttributes(array('id_kendaraan' => $p->id_kendaraan));
            $dataKotaProp = TblKota::model()->detailKotaPropinsi($p->kd_kota);

            if ($p->confirm_kupt == false) {
                $dataApprove = 0;
            } else {
                $dataApprove = 1;
            }
            $dataJson[] = array(
                "id_rekom" => $p->id_rekom,
                "no_uji" => $dataKendaraan->no_uji,
                "no_kendaraan" => $dataKendaraan->no_kendaraan,
                "pemilik_baru" => $p->pemilik_baru,
                "alamat_baru" => $p->alamat_baru,
                "pemilik" => $dataKendaraan->nama_pemilik,
                "alamat" => $dataKendaraan->alamat,
                "no_surat" => $p->nosurat,
                "propinsi" => $dataKotaProp['propinsi_rel']['nm_propinsi'],
                "kota" => $dataKotaProp['nm_kota'],
                "keterangan" => $p->keterangan,
                "status" => $dataApprove,
                //                "report" => $p->approve2 . "_" . $p->id_rekom
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => TblRekom::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionListGridRekomKaDis()
    {
        $pilihan = $_POST['rekom'];
        $tgl_pengajuan_rekom = $_POST['tgl_pengajuan_rekom'];
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_retribusi';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        if ($pilihan == 'mk') {
            $criteria->addCondition('mutke = true');
        } elseif ($pilihan == 'nk') {
            $criteria->addCondition('numke = true');
        } elseif ($pilihan == 'us') {
            $criteria->addCondition('ubhsifat = true');
        }
        $criteria->addCondition("tgl_rekom = TO_DATE('" . $tgl_pengajuan_rekom . "', 'DD-Mon-YY')");
        $criteria->addCondition("confirm_kupt = true");
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        $result = TblRekom::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataKendaraan = TblKendaraan::model()->findByAttributes(array('id_kendaraan' => $p->id_kendaraan));
            $dataKotaProp = TblKota::model()->detailKotaPropinsi($p->kd_kota);

            if ($p->confirm_kadis == false) {
                $dataApprove = 0;
            } else {
                $dataApprove = 1;
            }
            $dataJson[] = array(
                "id_rekom" => $p->id_rekom,
                "no_uji" => $dataKendaraan->no_uji,
                "no_kendaraan" => $dataKendaraan->no_kendaraan,
                "pemilik_baru" => $p->pemilik_baru,
                "alamat_baru" => $p->alamat_baru,
                "pemilik" => $dataKendaraan->nama_pemilik,
                "alamat" => $dataKendaraan->alamat,
                "no_surat" => $p->nosurat,
                "propinsi" => $dataKotaProp['propinsi_rel']['nm_propinsi'],
                "kota" => $dataKotaProp['nm_kota'],
                "keterangan" => $p->keterangan,
                "status" => $dataApprove,
                //                "report" => $p->approve3 . "_" . $p->id_rekom
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => TblRekom::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionApproveRejectRekom()
    {
        $pilihan = $_POST['pilihan'];
        if ($pilihan == 1) {
            $persetujuan = 'true';
        } else {
            $persetujuan = 'false';
        }
        $idAll = $_POST['id'];
        if (!empty($idAll)) {
            foreach ($idAll as $id) {
                if (Yii::app()->session['position_id'] == 1) {
                    $update = "UPDATE tbl_rekom SET disetujui = " . $persetujuan . ", confirm_kadis=" . $persetujuan . ", tgl_confirm_kadis = '" . date('Y-m-d') . "' WHERE id_rekom = " . $id;
                } else {
                    $update = "UPDATE tbl_rekom SET confirm_kupt = " . $persetujuan . ", tgl_confirm_upt = '" . date('Y-m-d') . "' WHERE id_rekom = " . $id;
                }
                Yii::app()->db->createCommand($update)->query();
            }
            $status = TRUE;
        } else {
            $status = FALSE;
        }
        echo json_encode(array('success' => $status));
    }

    public function actionApproveAllDate()
    {
        $update = "UPDATE tbl_rekom SET disetujui = true, confirm_kadis = true, tgl_confirm_kadis = '" . date('Y-m-d') . "' WHERE confirm_kupt = true";
        Yii::app()->db->createCommand($update)->query();
    }

    //    ============================================================================

    public function actionReportRecommendation()
    {
        $this->pageTitle = 'Status Rekomendasi';
        $urlAct = 'Default/ListGridRekomKasubag';
        $step = 3;
        if (Yii::app()->session['username'] == 'dian' || Yii::app()->session['username'] == 'irvan') {
            $step = 1;
            $urlAct = 'Default/ListGridRekomKaDis';
        }
        $this->render('../report/rekomendasi', array('urlAct' => $urlAct, 'step' => $step));
    }

    public function actionPilihStatusReportRecommendation()
    {
        $step = $_POST['step'];
        $pilihan = $_POST['pilihan'];
        if ($step == 'step1') {
            $step_no = 3;
            $urlAct = 'Default/ListGridRekomKasubag';
        } elseif ($step == 'step2') {
            $step_no = 2;
            $urlAct = 'Default/ListGridRekomKaUpt';
        } else {
            $step_no = 1;
            $urlAct = 'Default/ListGridRekomKaDis';
        }
        $this->renderPartial('../report/proses_' . $pilihan, array('urlAct' => $urlAct, 'step' => $step_no));
    }

    //    ============================================================================    
    public function actionDetailNoSb()
    {
        $no_sb = strtoupper($_POST['no_sb']);
        $pilihan = $_POST['pilihan'];
        $criteria = new CDbCriteria();
        $criteria->addCondition('UPPER(no_uji) LIKE UPPER(\'' . $no_sb . '\')');
        // if ($pilihan == 1) {
        $result = TblKendaraan::model()->find($criteria);
        if (!empty($result)) {
            $jnsKend = TblJnsKend::model()->findByAttributes(array('id_jns_kend' => $result->id_jns_kend));
        }
        // } else {
        //     $result = TblKendaraanTandes::model()->find($criteria);
        //     if (!empty($result)) {
        //         $jnsKend = TblJnsKendTandes::model()->findByAttributes(array('id_jns_kend' => $result->id_jns_kend));
        //     }
        // }
        if ((!empty($result)) && (!empty($jnsKend) != 0)) {
            $data['no_uji'] = $no_sb;
            $data['id_kendaraan'] = $result->id_kendaraan;
            $data['no_kendaraan'] = $result->no_kendaraan;
            $data['id_jns_kend'] = $result->id_jns_kend;
            $data['jns_kend'] = $jnsKend->jns_kend;
            $data['nama_pemilik'] = $result->nama_pemilik;
            $data['alamat'] = $result->alamat;
            $data['no_identitas'] = $result->no_identitas;
            $data['no_telp'] = $result->no_telp;
            $data['no_mesin'] = $result->no_mesin;
            $data['no_chasis'] = $result->no_chasis;
            $data['tgl_mati'] = date('d-M-y', strtotime($result->tgl_mati_uji));
        } else {
            $data = 0;
        }
        echo json_encode($data);
    }

    public function actionSendSms()
    {
        $tgl = $_POST['tgl'];
        $formatTgl = date("d/m/Y", strtotime($tgl));

        $criteriaMutke = new CDbCriteria();
        $criteriaMutke->addCondition('mutke = true');
        $criteriaMutke->addCondition("tgl_rekom = TO_DATE('" . $tgl . "', 'DD-Mon-YY')");
        $criteriaMutke->addCondition("confirm_kupt = true");
        $jumlahMutke = TblRekom::model()->count($criteriaMutke);

        $criteriaNumke = new CDbCriteria();
        $criteriaNumke->addCondition('numke = true');
        $criteriaNumke->addCondition("tgl_rekom = TO_DATE('" . $tgl . "', 'DD-Mon-YY')");
        $criteriaNumke->addCondition("confirm_kupt = true");
        $jumlahNumke = TblRekom::model()->count($criteriaNumke);

        //$nomera = '+6285755124535';
        $nomera = '+6281931056701';
        $nomerb = '+6282139009839';
        //$nomera = '+6281330391999';
        //$nomerb = '+6282233633329';
        $text_sms = "[REKOMENDASI TANDES]
Mohon approve melalui http://36.67.46.113/pkbsurabaya/
Terimakasih. 
=================
Tanggal = " . $formatTgl . "
Rekom = " . $jumlahMutke . "Mutasi Keluar
=================
Tanggal = " . $formatTgl . "
Rekom = " . $jumlahNumke . "Numpang Uji Keluar
=================";
        $jmlSMS = ceil(strlen($text_sms) / 153);
        $pecah = str_split($text_sms, 151);

        $queryId = "SHOW TABLE STATUS LIKE 'outbox'";
        $hasilId = Yii::app()->db_sms->createCommand($queryId);
        $dataId = $hasilId->queryRow();
        $newID = $dataId['Auto_increment'];

        for ($i = 1; $i <= $jmlSMS; $i++) {
            $udh = "050003A7" . sprintf("%02s", $jmlSMS) . sprintf("%02s", $i);
            $msg = $pecah[$i - 1];
            if ($i == 1) {
                $sql = "INSERT INTO outbox(DestinationNumber,UDH,TextDecoded,ID,Multipart,CreatorID) VALUES ('$nomera','$udh','$msg',$newID,'true','Gammu')";
                Yii::app()->db_sms->createCommand($sql)->query();
            } else {
                $sqlMultipart = "INSERT INTO outbox_multipart(UDH,TextDecoded,ID,SequencePosition) VALUES ('$udh','$msg',$newID,'$i')";
                Yii::app()->db_sms->createCommand($sqlMultipart)->query();
            }
        }

        $queryId = "SHOW TABLE STATUS LIKE 'outbox'";
        $hasilId = Yii::app()->db_sms->createCommand($queryId);
        $dataId = $hasilId->queryRow();
        $newID = $dataId['Auto_increment'];

        for ($i = 1; $i <= $jmlSMS; $i++) {
            $udh = "050003A7" . sprintf("%02s", $jmlSMS) . sprintf("%02s", $i);
            $msg = $pecah[$i - 1];
            if ($i == 1) {
                $sql = "INSERT INTO outbox(DestinationNumber,UDH,TextDecoded,ID,Multipart,CreatorID) VALUES ('$nomerb','$udh','$msg',$newID,'true','Gammu')";
                Yii::app()->db_sms->createCommand($sql)->query();
            } else {
                $sqlMultipart = "INSERT INTO outbox_multipart(UDH,TextDecoded,ID,SequencePosition) VALUES ('$udh','$msg',$newID,'$i')";
                Yii::app()->db_sms->createCommand($sqlMultipart)->query();
            }
        }
    }
}
