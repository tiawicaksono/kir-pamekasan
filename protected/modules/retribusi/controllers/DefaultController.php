<?php

class DefaultController extends Controller
{

    public function filters()
    {
        return array(
            'Rights', // perform access control for CRUD operations
        );
    }

    /* =====================================================================
     * RETRIBUSI
      ===================================================================== */

    public function actionIndex()
    {
        $this->pageTitle = 'RETRIBUSI';
        $tbl_uji = TblUji::model()->getUjiRetribusi();
        //==============================================
        $tbl_jns_kend = TblJnsKend::model()->findAll();
        $this->render('form_retribusi', array(
            'tbl_uji' => $tbl_uji,
            'tbl_jns_kend' => $tbl_jns_kend
        ));
    }

    public function actionDetailNoSb()
    {
        $no_sb = strtoupper($_POST['no_sb']);
        // $pilihan = $_POST['pilihan'];
        $result = VKendaraan::model()->getDataKendaraan($no_sb);

        if (!empty($result)) {
            $jnsKend = TblJnsKend::model()->findByAttributes(array('id_jns_kend' => $result->id_jns_kend));
        }
        if ((!empty($result)) && (!empty($jnsKend))) {
            // $criteriaDetBuku = new CDbCriteria();
            // $criteriaDetBuku->addInCondition('id_kendaraan', array($result->id_kendaraan));
            // $criteriaDetBuku->order = 'berlaku DESC';
            // $detBuku = VDetBuku::model()->find($criteriaDetBuku);
            if ($result->tgl_mati_uji == NULL) {
                $tgl_mati = date('d/m/Y');
            } else {
                $tgl_mati = $result->tgl_mati_uji;
            }

            $data['no_uji'] = $result->no_uji;
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
            $data['jbb'] = $result->kemjbb;
            $data['identitas'] = $result->identitas;
            if (date("d/m/Y", strtotime($tgl_mati)) != '01/01/1970') {
                $data['tgl_mati'] = date('d/m/Y', strtotime($tgl_mati));
            } else {
                $data['tgl_mati'] = date('d/m/Y');
            }
        } else {
            $data = 0;
        }
        echo json_encode($data);
    }

    public function actionPenjumlahanTanggal()
    {
        $tanggal_pengujian = $_POST['tanggal_pengujian'];
        $data['tgl_mati_uji'] = date('d-M-y', strtotime('+6 month', strtotime($tanggal_pengujian)));
        echo json_encode($data);
    }

    public function actionGetListSelect()
    {
        $pilih = $_POST['pilih'];
        $option = '';
        switch ($pilih) {
            case 'jenis_kendaraan':
                $tbl_jns_kend = TblJnsKend::model()->findAll();
                foreach ($tbl_jns_kend as $jns_kend) :
                    $option .= "<option value='$jns_kend->id_jns_kend'>$jns_kend->jns_kend</pilih>";
                endforeach;
                break;
            case 'jenis_uji':
                $tbl_uji = TblUji::model()->getUjiRetribusi();
                foreach ($tbl_uji as $uji) :
                    $option .= "<option value='$uji->id_uji'>$uji->nm_uji</pilih>";
                endforeach;
                break;
            case 'buku':
                $option .= "<option value='0'>TIDAK GANTI</pilih>";
                $option .= "<option value='1'>GANTI</pilih>";
                break;
            case 'platuji':
                $option .= "<option value='0'>TIDAK GANTI</pilih>";
                $option .= "<option value='1'>GANTI</pilih>";
                break;
        }

        echo $option;
    }

    public function actionUpdateRetribusi()
    {
        $ex_idret_tglmati = explode('_', $_POST['dlg_idret_tglmati']);
        $id_retribusi = $ex_idret_tglmati[0];
        $tgl_mati = $ex_idret_tglmati[1];
        $pilih_kategori = $_POST['pilih_kategori'];

        $kategori = 0;
        $jbb = 0;
        $numerator = 0;
        $wilayah_asal = 'PMKSN';
        if ($pilih_kategori == 'tgluji') {
            $tgl_mati = date("m/d/Y", strtotime($_POST['ganti_tgl_uji']));
        } elseif ($pilih_kategori == 'denda') {
            $tgl_mati = $_POST['ganti_tgl_mati'];
            //            Yii::app()->db->createCommand($updateDenda)->query();
        } elseif ($pilih_kategori == 'jbb') {
            $jbb = $_POST['jbb'];
        } elseif ($pilih_kategori == 'numerator') {
            $numerator = $_POST['edit_numerator'];
        } elseif ($pilih_kategori == 'wilayah_asal') {
            $wilayah_asal = $_POST['wilayah_asal'];
        } else {
            $kategori = $_POST['kategori'];
            if (isset($_POST['wilayah_asal'])) {
                $wilayah_asal = $_POST['wilayah_asal'];
            }
        }
        $updateRetribusi = "Select edit_retribusi(" . $id_retribusi . ",'" . $tgl_mati . "','" . $pilih_kategori . "',$kategori, $jbb, $numerator, '" . $wilayah_asal . "')";
        Yii::app()->db->createCommand($updateRetribusi)->query();
    }

    public function actionSaveform()
    {
        $form = $_POST['FORM'];
        $tanda_pengenal = $form['JENIS_PENGENAL'];
        $userlogin = $form['USER_LOGIN'];
        $tgl_retribusi = date("m/d/Y");

        $JENIS_PENGUJIAN = $form['JENIS_PENGUJIAN'];
        $WILAYAH_ASAL = 'PMKSN';
        if ($JENIS_PENGUJIAN == 2 || $JENIS_PENGUJIAN == 4) {
            $WILAYAH_ASAL = empty($form['WILAYAH_ASAL']) ? 'PMKSN' : $form['WILAYAH_ASAL'];
        }
        $BUKU_UJI = $form['BUKU_UJI'];
        $PLAT_UJI = $form['PLAT_UJI'];
        $str = 'NOMOR ' . date('jnGis');
        //        $NO_STUK = ($JENIS_PENGUJIAN == 8) ? substr(strtoupper(base64_encode($str)), 0, 10) : strtoupper($form['NO_STUK']);
        $nomer_uji = ($JENIS_PENGUJIAN == 8) ? strtoupper($str) : strtoupper($form['NO_STUK']);
        $var_no_uji = str_replace("'", " ", $nomer_uji);
        $var_nomor_uji = preg_replace("/([[:alpha:]])([[:digit:]])/", "\\1 \\2", $var_no_uji);
        $NO_STUK = preg_replace("/([[:digit:]])([[:alpha:]])/", "\\1 \\2", $var_nomor_uji);
        $ID_KENDARAAN = $form['ID_KENDARAAN'];
        $TGLPENGUJIAN = DateTime::createFromFormat('d/m/Y', $form['TGL_PENGUJIAN']);
        $TGL_PENGUJIAN = $TGLPENGUJIAN->format('m/d/Y');
        $TGLMATIUJI = DateTime::createFromFormat('d/m/Y', $form['TGL_MATI_UJI']);
        $TGL_MATI_UJI = $TGLMATIUJI->format('m/d/Y');
        //        $NO_KENDARAAN = strtoupper($form['NO_KENDARAAN']);
        $nomer_kendaraan = strtoupper($form['NO_KENDARAAN']);
        $var_no_kendaraan = str_replace("'", " ", $nomer_kendaraan);
        $var_nomor_kendaraan = preg_replace("/([[:alpha:]])([[:digit:]])/", "\\1 \\2", $var_no_kendaraan);
        $NO_KENDARAAN = preg_replace("/([[:digit:]])([[:alpha:]])/", "\\1 \\2", $var_nomor_kendaraan);
        $JENIS_KENDARAAN = $form['JENIS_KENDARAAN'];
        $NAMA_PEMILIK = str_replace("'", "`", strtoupper($form['NAMA_PEMILIK']));
        $ALAMAT = str_replace("'", "`", strtoupper($form['ALAMAT']));
        $NO_KTP = strtoupper($form['NO_KTP']);
        $NO_TELP = strtoupper($form['NO_TELP']);
        $NO_MESIN = strtoupper($form['NO_MESIN']);
        $NO_CHASIS = strtoupper($form['NO_CHASIS']);
        //        $NUMERATOR = strtoupper($form['NUMERATOR']);
        $NUMERATOR = 0;
        $JBB = strtoupper($form['JBB']);

        $hai = 0;
        $dtKendaraan = TblKendaraan::model()->findByAttributes(array('id_kendaraan' => $ID_KENDARAAN));
        if (!empty($dtKendaraan)) {
            if ($dtKendaraan->blokir == 'true') {
                $result['ada'] = 'false';
                $result['message'] = "Kendaraan diblokir! (Ket: " . $dtKendaraan->keterangan_blokir . ")";
                $hai = 1;
            }
        }

        if ($hai == 0) {
            //JIKA (ADA ID KENDARAAN DAN UJI PERTAMA) || (TIDAK ADA KENDARAAN DAN BERKALA)
            if (($ID_KENDARAAN == 0 && $JENIS_PENGUJIAN == 1)) {
                $result['ada'] = 'false';
                $result['message'] = "\"" . $NO_KENDARAAN . '" daftar <b>Jenis Pengujian</b> salah';
            } else {
                $data_kendaraan = $NO_STUK . '~' . $NO_KENDARAAN . '~' . $NO_CHASIS . '~' . $NO_MESIN . '~' . $ID_KENDARAAN . '~' . $JENIS_KENDARAAN . '~' . $JBB;
                $data_uji = $BUKU_UJI . '~' . $JENIS_PENGUJIAN . '~' . $tgl_retribusi . '~' . $TGL_PENGUJIAN . '~' . $TGL_MATI_UJI . '~' . $NUMERATOR . '~' . $WILAYAH_ASAL . '~' . $PLAT_UJI;
                $data_pemilik = $NAMA_PEMILIK . '~' . $ALAMAT . '~' . $NO_KTP . '~' . $NO_TELP . '~' . $tanda_pengenal;

                //TD
                //                $td = 'true';
                //                $result['message'] = "\"" . $NO_STUK . '" TIDAK DATANG pada tanggal ' . date("d F Y", strtotime($TGL_MATI_UJI));
                //                $inputRetribusi = "Select insert_retribusi( '" . $userlogin . "', '" . $data_kendaraan . "','" . $data_uji . "','" . $data_pemilik . "','" . $td . "')";
                //                Yii::app()->db->createCommand($inputRetribusi)->execute();

                //CEK DAFTAR HARI INI
                $criteria = new CDbCriteria();
                $criteria->addCondition('id_kendaraan = ' . $ID_KENDARAAN);
                $criteria->addCondition("tgl_uji =  '$TGL_PENGUJIAN'");
                $data = TblRetribusi::model()->find($criteria);
                //JIKA BELUM TERDAFTAR 
                //ATAU BELI BUKU SAJA 11
                //ATAU REKOM NUMPANG KELUAR  3
                //ATAU REKOM MUTASI KELUAR 5
                //ATAU REKOM UBAH SIFAT 6
                //ATAU REKOM UBAH BENTUK 7
                //ATAU REKOM UJI PERTAMA 9
                //ATAU REKOM UB/US BERKALA 12
                //ATAU REKOM UB/US PERTAMA 13
                //ATAU REKOM MUTASI MASUK 14
                if (empty($data) || in_array($JENIS_PENGUJIAN, array(11, 1, 8, 4, 2, 9, 5, 14, 3, 10))) {
                    $td = 'false';
                    $result['ada'] = 'true';
                    $result['message'] = "\"" . $NO_STUK . '" berhasil didaftarkan';
                    $inputRetribusi = "Select insert_retribusi( '" . $userlogin . "', '" . $data_kendaraan . "','" . $data_uji . "','" . $data_pemilik . "','" . $td . "')";
                    Yii::app()->db->createCommand($inputRetribusi)->query();
                } else {
                    $result['ada'] = 'false';
                    $result['message'] = "\"" . $NO_STUK . '" sudah terdaftar hari ini';
                }
            }
        }
        //        exit;
        $result['buku_uji'] = $BUKU_UJI;
        $result['tgluji'] = date('d/m/Y');
        $result['tglmati'] = date('d/m/Y');
        echo json_encode($result);
    }

    public function actionValidasilistgridPetugas()
    {
        $ok = Yii::app()->baseUrl . "/images/icon_approve.png";
        $reject = Yii::app()->baseUrl . "/images/icon_reject.png";
        $selectCategory = $_POST['selectCategory'];
        $textCategory = strtoupper($_POST['textCategory']);
        $selectDate = strtoupper($_POST['selectDate']);
        $petugas = Yii::app()->session['username'];
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_retribusi';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        if (!empty($textCategory)) {
            if ($selectCategory == 'numerator') {
                $criteria->addCondition("$selectCategory = $textCategory");
            } else {
                $criteria->addCondition("( (replace(LOWER(no_uji),' ','') like replace(LOWER('%" . $textCategory . "%'),' ','')) OR (replace(LOWER(no_kendaraan),' ','') like replace(LOWER('%" . $textCategory . "%'),' ','')) )");
            }
        }
        $criteria->addCondition("tgl_retribusi = TO_DATE('" . $selectDate . "', 'DD-Mon-YY')");
        if (!Yii::app()->user->isRole('Admin')) {
            $criteria->addCondition("penerima like '$petugas' or penerima like 'self service'");
        }
        $result = VValidasi::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $tgl_mati = TblRetribusi::model()->findByPk($p->id_retribusi)->tglmati;
            $dataJson[] = array(
                "id" => $p->id_retribusi,
                "ACTIONS" => $p->id_retribusi,
                "delete" => $p->id_retribusi,
                "idret_tglmati" => $p->id_retribusi . "_" . $tgl_mati,
                "id_retribusi" => $p->id_retribusi,
                "stiker" => $p->id_kendaraan . "_" . $p->id_uji,
                "numerator" => $p->numerator,
                "no_uji" => $p->no_uji,
                "no_kendaraan" => $p->no_kendaraan,
                "uji" => $p->nm_uji,
                "nama_pemilik" => $p->nama_pemilik,
                "jns" => $p->jenis,
                "b_berkala" => number_format($p->b_berkala, 0, ',', '.'),
                "b_pertama" => number_format($p->b_pertama, 0, ',', '.'),
                "b_tlt_uji" => number_format($p->b_tlt_uji, 0, ',', '.'),
                "b_plat_uji" => number_format($p->b_plat_uji, 0, ',', '.'),
                "b_buku" => number_format($p->b_buku, 0, ',', '.'),
                "b_tnd_samping" => number_format($p->b_tnd_samping, 0, ',', '.'),
                "b_jbb" => number_format($p->b_jbb, 0, ',', '.'),
                "b_rekom" => number_format($p->b_rekom, 0, ',', '.'),
                "total" => number_format($p->total, 0, ',', '.'),
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => VValidasi::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionDetailRetribusi()
    {
        $id_retribusi = $_POST['id_retribusi'];
        $data_retribusi = VValidasi::model()->findByAttributes(array('id_retribusi' => $id_retribusi));
        $this->renderPartial('detail_retribusi', array('data' => $data_retribusi));
    }

    public function actionCetakRetribusi($id)
    {
        $this->layout = '//';
        $data_retribusi = VValidasi::model()->findByAttributes(array('id_retribusi' => $id));
        $this->render('cetak_retribusi', array('id' => $id, 'data_retribusi' => $data_retribusi));
    }

    public function actionCetakCheckedRetribusi()
    {
        $this->layout = '//';
        $arrayId = $_REQUEST['idArray'];
        $idArray = explode(',', $arrayId);
        $this->render('cetak_checked_retribusi', array(
            'idArray' => $idArray
        ));
    }

    public function actionCetakStiker($id, $penguji)
    {
        $this->layout = '//';
        $this->render('cetak_stiker', array(
            'id_kendaraan' => $id,
            'penguji' => $penguji
        ));
    }

    public function actionDeleteRetribusi()
    {
        $id = $_POST['id'];
        $sql = "DELETE FROM tbl_retribusi WHERE id_retribusi = $id";
        Yii::app()->db->createCommand($sql)->execute();
    }
}
