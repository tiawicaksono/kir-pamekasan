<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VerifikasiController extends Controller
{

    public function filters()
    {
        return array(
            'Rights', // perform access control for CRUD operations
        );
    }

    public function actionIndex()
    {
        $this->pageTitle = 'VERIFIKASI';
        $this->render('verifikasi');
    }

    public function actionFormEditKelulusan()
    {
        $this->pageTitle = 'Edit Kelulusan';
        $id_hasil_uji = $_REQUEST['id'];
        $data = TblHasilUji::model()->findByAttributes(array('id_hasil_uji' => $id_hasil_uji));
        $posisi = $data->posisi;
        if ($data->grem_sb1 != 0) {
            $selrem1 = ceil(($data->selrem_sb1 / $data->grem_sb1) * 100);
        } else {
            $selrem1 = 0;
        }
        if ($data->grem_sb2 != 0) {
            $selrem2 = ceil(($data->selrem_sb2 / $data->grem_sb2) * 100);
        } else {
            $selrem2 = 0;
        }
        if ($data->grem_sb3 != 0) {
            $selrem3 = ceil(($data->selrem_sb3 / $data->grem_sb3) * 100);
        } else {
            $selrem3 = 0;
        }
        if ($data->grem_sb4 != 0) {
            $selrem4 = ceil(($data->selrem_sb4 / $data->grem_sb4) * 100);
        } else {
            $selrem4 = 0;
        }
        $selgaya1 = $data->selgaya;
        $selgaya2 = $data->selkirikanan;
        $selgaya3 = $data->selgaya3;
        $selgaya4 = $data->selgaya4;
        $this->render('edit_kelulusan', array(
            'id_hasil_uji' => $id_hasil_uji,
            'posisi' => $posisi,
            'selrem1' => $selrem1,
            'selrem2' => $selrem2,
            'selrem3' => $selrem3,
            'selrem4' => $selrem4,
            'selgaya1' => $selgaya1,
            'selgaya2' => $selgaya2,
            'selgaya3' => $selgaya3,
            'selgaya4' => $selgaya4,
        ));
    }

    public function actionVerifikasiListGrid()
    {
        $ok = Yii::app()->baseUrl . "/images/icon_approve.png";
        $reject = Yii::app()->baseUrl . "/images/icon_reject.png";
        $proses = Yii::app()->baseUrl . "/images/icon_proccess.png";
        $tgl = $_POST['tanggal'];
        $hasil = $_POST['chooseProses'];
        $selectCategory = $_POST['selectCategory'];
        $textCategory = strtoupper($_POST['textCategory']);
        $tanggal = date("Y-m-d", strtotime($tgl));
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'nomor_antrian';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        if (!empty($textCategory)) {
            if ($selectCategory == 'nomor_antrian') {
                $criteria->addCondition("$selectCategory = $textCategory");
            } else {
                $criteria->addCondition("(replace(LOWER(no_uji),' ','') like replace(LOWER('%" . $textCategory . "%'),' ','') OR replace(LOWER(no_kendaraan),' ','') like replace(LOWER('%" . $textCategory . "'),' ',''))");
            }
        }
        if ($hasil != 'all') {
            $criteria->addCondition("hasil = $hasil");
        }
        $criteria->addCondition("jdatang::date = '$tanggal'");
        $result = VVerifikasi::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataKend = TblKendaraan::model()->findByAttributes(array('id_kendaraan' => $p->id_kendaraan));
            $id_hasil_uji = $p->id_hasil_uji;
            //PRAUJI
            if ($p->prauji == FALSE) {
                //                $a = '1';
                $img_prauji = "<img src='$proses'>";
            } else {
                //                $a = '2';
                if ($p->lulus_prauji == "true") {
                    $img_prauji = '<img src="' . $ok . '" onclick="buttonBanding(' . $id_hasil_uji . ', \'prauji\')" style="cursor:pointer">';
                } else {
                    $img_prauji = '<img src="' . $reject . '" onclick="buttonBanding(' . $id_hasil_uji . ', \'prauji\')" style="cursor:pointer">';
                }
            }
            //EMISI
            if ($p->smoke == FALSE) {
                $img_smoke = "<img src='$proses'>";
            } else {
                if ($p->lulus_smoke == "true") {
                    $img_smoke = '<img src="' . $ok . '" onclick="buttonBanding(' . $id_hasil_uji . ', \'emisi\')" style="cursor:pointer">';
                } else {
                    $img_smoke = '<img src="' . $reject . '" onclick="buttonBanding(' . $id_hasil_uji . ', \'emisi\')" style="cursor:pointer">';
                }
            }
            //PITLIFT
            if ($p->pitlift == FALSE) {
                $img_pitlift = "<img src='$proses'>";
            } else {
                if ($p->lulus_pitlift == "true") {
                    $img_pitlift = '<img src="' . $ok . '" onclick="buttonBanding(' . $id_hasil_uji . ', \'pitlift\')" style="cursor:pointer">';
                } else {
                    $img_pitlift = '<img src="' . $reject . '" onclick="buttonBanding(' . $id_hasil_uji . ', \'pitlift\')" style="cursor:pointer">';
                }
            }
            //LAMPU
            if ($p->lampu == FALSE) {
                $img_lampu = "<img src='$proses'>";
            } else {
                if ($p->lulus_lampu == "true") {
                    $img_lampu = '<img src="' . $ok . '" onclick="buttonBanding(' . $id_hasil_uji . ', \'lampu\')" style="cursor:pointer">';
                } else {
                    $img_lampu = '<img src="' . $reject . '" onclick="buttonBanding(' . $id_hasil_uji . ', \'lampu\')" style="cursor:pointer">';
                }
            }
            //BRAKE
            if ($p->break == FALSE) {
                $img_brake = "<img src='$proses'>";
            } else {
                if ($p->lulus_break == "true") {
                    $img_brake = '<img src="' . $ok . '" onclick="buttonBanding(' . $id_hasil_uji . ', \'rem\')" style="cursor:pointer">';
                } else {
                    $img_brake = '<img src="' . $reject . '" onclick="buttonBanding(' . $id_hasil_uji . ', \'rem\')" style="cursor:pointer">';
                }
            }

            if ($p->hasil == "true") {
                $ltl = 'l';
            } else {
                $ltl = 'tl';
            }
            $noSurat = '';
            $penguji = $p->nrp;
            $noSurat = empty($p->no_tl) ? '' : $p->no_tl;

            $dataJson[] = array(
                "foto" => $p->id_hasil_uji,
                "cetak" => $ltl . "|" . $p->id_hasil_uji . "|" . $noSurat . "|" . $penguji,
                "id_kendaraan" => $p->id_kendaraan,
                "kendaraan_id" => $p->id_kendaraan,
                "blokir" => $p->blokir == false ? '-' : '<font style="color:red">' . $p->keterangan_blokir . '</font>',
                // "hasil_uji_id" => $p->id_hasil_uji,
                // "hasilUjiId" => $p->id_hasil_uji,
                "id_hasil_uji" => $id_hasil_uji,
                "no_antrian" => $p->no_antrian,
                "no_uji" => $p->no_uji,
                "no_kendaraan" => $p->no_kendaraan,
                // "ptgs_prauji" => $p->ptgs_prauji,
                // "ptgs_smoke" => $p->ptgs_smoke,
                // "ptgs_pitlift" => $p->ptgs_pitlift,
                // "ptgs_lampu" => $p->ptgs_lampu,
                // "ptgs_break" => $p->ptgs_break,
                "prauji" => $img_prauji . "<br />" . $p->ptgs_prauji,
                "emisi" => $img_smoke . "<br />" . $p->ptgs_smoke,
                "pitlift" => $img_pitlift . "<br />" . $p->ptgs_pitlift,
                "lampu" => $img_lampu . "<br />" . $p->ptgs_lampu,
                "rem" => $img_brake . "<br />" . $p->ptgs_break,
                "status" => $p->hasil == "true" ? "<img src='$ok'>" : "<img src='$reject'>",
                "bsumbu1" => $p->bsumbu1,
                "bsumbu2" => $p->bsumbu2,
                "bsumbu3" => $p->bsumbu3,
                "bsumbu4" => $p->bsumbu4,
                "catatan" => $this->catatan($p->id_hasil_uji)
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

    public function actionUpdateVerifikasi()
    {
        $id_hasil_uji = $_POST['id_hasil_uji'];
        $lain_lain = $_POST['lain_lain'];
        $pos_tl = $_POST['form_uji'];
        $lulus_pos = 'lulus_' . $pos_tl;
        $kelulusan = $_POST['form_kelulusan'];

        $updateHasilUji = "UPDATE tbl_hasil_uji SET $pos_tl = 'true', $lulus_pos = $kelulusan, cetak='false' WHERE id_hasil_uji = $id_hasil_uji";
        Yii::app()->db->createCommand($updateHasilUji)->execute();

        $hasil_uji = TblHasilUji::model()->findByPk($id_hasil_uji);
        $smoke = $hasil_uji->lulus_smoke;
        $pitlift = $hasil_uji->lulus_pitlift;
        $lampu = $hasil_uji->lulus_lampu;
        $break = $hasil_uji->lulus_break;
        $prauji = $hasil_uji->lulus_prauji;
        $ujimekanis = $hasil_uji->lulus_ujimekanis;
        $id_daftar = $hasil_uji->id_daftar;

        if ($smoke == true && $pitlift == true && $lampu == true && $break == true) {
            $updateHasilUji = "UPDATE tbl_hasil_uji SET lulus_ujimekanis = true WHERE id_hasil_uji = $id_hasil_uji";
        } else {
            //            echo "c";
            $updateHasilUji = "UPDATE tbl_hasil_uji SET lulus_ujimekanis = false WHERE id_hasil_uji = $id_hasil_uji";
        }
        Yii::app()->db->createCommand($updateHasilUji)->execute();

        if ($prauji == true && $ujimekanis == true) {
            $updateDaftar = "UPDATE tbl_daftar SET lulus = true WHERE id_daftar = $id_daftar";
            Yii::app()->db->createCommand($updateDaftar)->execute();
        } else {
            $updateDaftar = "UPDATE tbl_daftar SET lulus = false WHERE id_daftar = $id_daftar";
            Yii::app()->db->createCommand($updateDaftar)->execute();
            //            echo "a";
            if ($lain_lain != '') {
                //                echo "b";
                $listKelulusan = new TblListKelulusan();
                $listKelulusan->id_hasil_uji = $id_hasil_uji;
                $listKelulusan->kelulusan = $lain_lain;
                $listKelulusan->save();
            }
            //            $deleteRiwayat = "DELETE FROM tbl_riwayat WHERE id_hasil_uji = $id_hasil_uji";
            //            Yii::app()->db->createCommand($deleteRiwayat)->execute();
            //            foreach ($_POST['list_kelulusan'] as $data) {
            //                $data_kelulusan = TblKelulusan::model()->findByAttributes(array('kd_lulus' => $data));
            //                $data_list_kelulusan = new TblListKelulusan();
            //                $data_list_kelulusan->id_hasil_uji = $id_hasil_uji;
            //                $data_list_kelulusan->kd_lulus = $data;
            //                $data_list_kelulusan->kelulusan = $data_kelulusan->kelulusan;
            //                $data_list_kelulusan->save();
            //            }
        }
    }

    public function actionProsesBlokir()
    {
        $id_kedaraan = $_POST['id_kendaraan'];
        $blokir = $_POST['keterangan_blokir'];
        $dtKend = TblKendaraan::model()->findByAttributes(array('id_kendaraan' => $id_kedaraan));
        $nm_pemilik = $dtKend->nama_pemilik;
        $tanggal = date("m/d/Y");
        //        $update = "UPDATE tbl_kendaraan SET nama_pemilik = '[DIBLOKIR JANGAN DIPROSES]-$nm_pemilik', blokir='true', keterangan_blokir='$blokir', tgl_blokir='$tanggal' WHERE id_kendaraan = $id_kedaraan";
        $update = "UPDATE tbl_kendaraan SET blokir='true', keterangan_blokir='$blokir', tgl_blokir='$tanggal' WHERE id_kendaraan = $id_kedaraan";
        Yii::app()->db->createCommand($update)->execute();
    }

    public function actionProsesUnBlokir()
    {
        $id_kendaraan = $_POST['id_kendaraan'];
        $dtKend = TblKendaraan::model()->findByAttributes(array('id_kendaraan' => $id_kendaraan));
        //        $nm_pemilik = explode('-', $dtKend->nama_pemilik);
        //        $nama_pemilik = $nm_pemilik[1];
        $update = "UPDATE tbl_kendaraan SET blokir='false', keterangan_blokir='', tgl_blokir=NULL WHERE id_kendaraan = $id_kendaraan";
        Yii::app()->db->createCommand($update)->execute();
    }

    public function actionProsesPrauji()
    {
        $idhasil = $_POST['idhasil'];
        $lain_lain = $_POST['lain_lain'];
        $variabel = $_POST['variabel'];
        $posisi = $_POST['posisi'];
        $username = Yii::app()->session['username'];
        $query = "select update_padprauji('$variabel',$idhasil,'$username','$posisi');";
        Yii::app()->db->createCommand($query)->execute();
        $deleteRiwayat = "DELETE FROM tbl_riwayat WHERE id_hasil_uji = $idhasil";
        Yii::app()->db->createCommand($deleteRiwayat)->execute();

        if ($lain_lain != '') {
            $listKelulusan = new TblListKelulusan();
            $listKelulusan->id_hasil_uji = $idhasil;
            $listKelulusan->kelulusan = $lain_lain;
            $listKelulusan->save();
            $update = "UPDATE tbl_hasil_uji SET prauji='true', lulus_prauji='false' WHERE id_hasil_uji = $idhasil";
            Yii::app()->db->createCommand($update)->execute();

            $deleteRiwayat = "DELETE FROM tbl_riwayat WHERE id_hasil_uji = $idhasil";
            Yii::app()->db->createCommand($deleteRiwayat)->execute();
        }
    }

    public function actionProsesBrake()
    {
        $idhasil = $_POST['idhasil'];
        $variabel = $_POST['variabel'];
        $lain_lain = $_POST['lain_lain'];
        $username = Yii::app()->session['username'];
        $query = "select update_break('$variabel',$idhasil,'$username');";
        Yii::app()->db->createCommand($query)->execute();
        $deleteRiwayat = "DELETE FROM tbl_riwayat WHERE id_hasil_uji = $idhasil";
        Yii::app()->db->createCommand($deleteRiwayat)->execute();

        if ($lain_lain != '') {
            $listKelulusan = new TblListKelulusan();
            $listKelulusan->id_hasil_uji = $idhasil;
            $listKelulusan->kelulusan = $lain_lain;
            $listKelulusan->save();
            $update = "UPDATE tbl_hasil_uji SET break='true', lulus_break='false' WHERE id_hasil_uji = $idhasil";
            Yii::app()->db->createCommand($update)->execute();

            $deleteRiwayat = "DELETE FROM tbl_riwayat WHERE id_hasil_uji = $idhasil";
            Yii::app()->db->createCommand($deleteRiwayat)->execute();
        }
    }

    /*
     * PROSES BANDING
     */

    public function actionProsesBandingPrauji()
    {
        $id_hasil_uji = $_POST['id_hasil_uji'];
        $hari_ini = date('m/d/Y');

        $dataHasilUji = TblHasilUji::model()->findByPk($id_hasil_uji);
        //JIKA TGL UJI ULANG == HARI INI
        /*$updateHasilUji = "UPDATE tbl_hasil_uji SET prauji=FALSE, lulus_prauji=FALSE, lulus_ujimekanis=FALSE, ujimekanis=FALSE, cetak=FALSE, 
        break=FALSE, lulus_break=FALSE, 
        lampu=FALSE, lulus_lampu=FALSE, 
        pitlift=FALSE, lulus_pitlift=FALSE, 
        smoke=FALSE, lulus_smoke=FALSE 
        WHERE id_hasil_uji = $id_hasil_uji";*/
        $updateHasilUji = "UPDATE tbl_hasil_uji SET prauji=FALSE, lulus_prauji=FALSE, cetak=FALSE  
        WHERE id_hasil_uji = $id_hasil_uji";
        Yii::app()->db->createCommand($updateHasilUji)->execute();

        // $delete = "DELETE FROM tbl_list_kelulusan WHERE id_hasil_uji = $id_hasil_uji";
        // Yii::app()->db->createCommand($delete)->execute();
    }

    public function actionProsesBandingEmisi()
    {
        $id_hasil_uji = $_POST['id_hasil_uji'];
        $hari_ini = date('m/d/Y');

        $dataHasilUji = TblHasilUji::model()->findByPk($id_hasil_uji);
        //JIKA TGL UJI ULANG == HARI INI
        /*$updateHasilUji = "UPDATE tbl_hasil_uji SET ujimekanis=FALSE, lulus_ujimekanis=FALSE, cetak=FALSE, 
        break=FALSE, lulus_break=FALSE,  
        lampu=FALSE, lulus_lampu=FALSE, 
        pitlift=FALSE, lulus_pitlift=FALSE, 
        smoke=FALSE, lulus_smoke=FALSE 
        WHERE id_hasil_uji = $id_hasil_uji";*/
        $updateHasilUji = "UPDATE tbl_hasil_uji SET ujimekanis=FALSE, lulus_ujimekanis=FALSE, cetak=FALSE, 
        smoke=FALSE, lulus_smoke=FALSE 
        WHERE id_hasil_uji = $id_hasil_uji";
        Yii::app()->db->createCommand($updateHasilUji)->execute();

        // $delete = "DELETE FROM tbl_list_kelulusan WHERE id_hasil_uji = $id_hasil_uji AND input_tl != 'Prauji'";
        // Yii::app()->db->createCommand($delete)->execute();
    }

    public function actionProsesBandingPitlift()
    {
        $id_hasil_uji = $_POST['id_hasil_uji'];
        $hari_ini = date('m/d/Y');

        $dataHasilUji = TblHasilUji::model()->findByPk($id_hasil_uji);
        //JIKA TGL UJI ULANG == HARI INI
        /*$updateHasilUji = "UPDATE tbl_hasil_uji SET ujimekanis=FALSE, lulus_ujimekanis=FALSE, cetak=FALSE, 
        break=FALSE, lulus_break=FALSE,  
        lampu=FALSE, lulus_lampu=FALSE, 
        pitlift=FALSE, lulus_pitlift=FALSE 
        WHERE id_hasil_uji = $id_hasil_uji";*/
        $updateHasilUji = "UPDATE tbl_hasil_uji SET ujimekanis=FALSE, lulus_ujimekanis=FALSE, cetak=FALSE, 
        pitlift=FALSE, lulus_pitlift=FALSE 
        WHERE id_hasil_uji = $id_hasil_uji";
        Yii::app()->db->createCommand($updateHasilUji)->execute();

        // $delete = "DELETE FROM tbl_list_kelulusan WHERE id_hasil_uji = $id_hasil_uji AND input_tl != 'Prauji' AND input_tl != 'Emisi'";
        // Yii::app()->db->createCommand($delete)->execute();
    }

    public function actionProsesBandingLampu()
    {
        $id_hasil_uji = $_POST['id_hasil_uji'];
        $hari_ini = date('m/d/Y');

        $dataHasilUji = TblHasilUji::model()->findByPk($id_hasil_uji);
        //JIKA TGL UJI ULANG == HARI INI
        /*$updateHasilUji = "UPDATE tbl_hasil_uji SET ujimekanis=FALSE, lulus_ujimekanis=FALSE, cetak=FALSE, 
        break=FALSE, lulus_break=FALSE,  
        lampu=FALSE, lulus_lampu=FALSE 
        WHERE id_hasil_uji = $id_hasil_uji";*/
        $updateHasilUji = "UPDATE tbl_hasil_uji SET ujimekanis=FALSE, lulus_ujimekanis=FALSE, cetak=FALSE, 
        lampu=FALSE, lulus_lampu=FALSE 
        WHERE id_hasil_uji = $id_hasil_uji";
        Yii::app()->db->createCommand($updateHasilUji)->execute();

        // $delete = "DELETE FROM tbl_list_kelulusan WHERE id_hasil_uji = $id_hasil_uji AND input_tl = 'Lampu' AND input_tl = 'Break'";
        // Yii::app()->db->createCommand($delete)->execute();
    }

    public function actionProsesBandingRem()
    {
        $id_hasil_uji = $_POST['id_hasil_uji'];
        $hari_ini = date('m/d/Y');

        $dataHasilUji = TblHasilUji::model()->findByPk($id_hasil_uji);
        //JIKA TGL UJI ULANG == HARI INI
        $updateHasilUji = "UPDATE tbl_hasil_uji SET ujimekanis=FALSE, lulus_ujimekanis=FALSE, cetak=FALSE, 
        break=FALSE, lulus_break=FALSE  
        WHERE id_hasil_uji = $id_hasil_uji";
        Yii::app()->db->createCommand($updateHasilUji)->execute();

        // $delete = "DELETE FROM tbl_list_kelulusan WHERE id_hasil_uji = $id_hasil_uji AND input_tl = 'Break'";
        // Yii::app()->db->createCommand($delete)->execute();
    }

    public function actionReportKelulusanExcel()
    {
        $selectDate = strtoupper($_GET['tgl']);
        Yii::import("ext.PHPExcel", TRUE);
        $xls = new PHPExcel();
        $sheet = $xls->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(false);
        $sheet->getPageSetup()->setHorizontalCentered(true);
        $sheet->getPageSetup()->setVerticalCentered(true);
        $sheet->getPageSetup()->setScale(90);
        //======================================================================
        $styleTengah = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $styleTengahHorizontal = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        //======================================================================
        // DATA KENDARAAN YANG DATANG UJI 
        //HEADER
        $xls->createSheet(0);
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('LULUS');

        $sheet->mergeCells("A1:F1");
        $sheet->setCellValue("A1", "LAPORAN KELULUSAN KENDARAAN UJI");
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle("A1")->applyFromArray($styleTengah);

        $sheet->mergeCells("A2:F2");
        $sheet->setCellValue("A2", "UPTD PKB WIYUNG DISHUB SURABAYA");
        $sheet->getStyle("A2")->getFont()->setSize(20);
        $sheet->getStyle("A2")->applyFromArray($styleTengah);

        $sheet->mergeCells("A3:F3");
        $sheet->setCellValue("A3", date("d F Y", strtotime($selectDate)));
        $sheet->getStyle("A3")->getFont()->setSize(14);
        $sheet->getStyle("A3")->applyFromArray($styleTengah);

        $sheet->setCellValue("A5", "NO");
        $sheet->getStyle("A5")->applyFromArray($styleTengah);
        $sheet->getStyle("A")->applyFromArray($styleTengah);
        $sheet->getColumnDimension('A')->setAutoSize(true);

        $sheet->setCellValue("B5", "NO UJI");
        $sheet->getStyle("B5")->applyFromArray($styleTengah);
        $sheet->getStyle("B")->applyFromArray($styleTengahHorizontal);
        $sheet->getStyle("B")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('B')->setWidth(14);

        $sheet->setCellValue("C5", "NO KENDARAAN");
        $sheet->getStyle("C5")->applyFromArray($styleTengah);
        $sheet->getStyle("C")->applyFromArray($styleTengahHorizontal);
        $sheet->getStyle("C5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("C")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('C')->setWidth(12);

        $sheet->setCellValue("D5", "NAMA PEMILIK");
        $sheet->getStyle("D5")->applyFromArray($styleTengah);
        $sheet->getStyle("D")->applyFromArray($styleTengahHorizontal);
        $sheet->getStyle("D")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('D')->setWidth(30);

        $sheet->setCellValue("E5", "NAMA KOMERSIL");
        $sheet->getStyle("E5")->applyFromArray($styleTengah);
        $sheet->getStyle("E")->applyFromArray($styleTengahHorizontal);
        $sheet->getStyle("E5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("E")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('E')->setWidth(15.56);

        $sheet->setCellValue("F5", "JENIS KAROSERI");
        $sheet->getStyle("F5")->applyFromArray($styleTengah);
        $sheet->getStyle("F")->applyFromArray($styleTengahHorizontal);
        $sheet->getStyle("F5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("F")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('F')->setWidth(12.78);

        $sheet->getStyle('A5:F5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        //END HEADER
        //======================================================================

        $criteria = new CDbCriteria();
        $criteria->addCondition("hasil = true");
        $criteria->addCondition("jdatang::date = '$selectDate'");
        $result = VVerifikasi::model()->findAll($criteria);
        //======================================================================
        //BODY
        $no = 1;
        $baris = 6;
        foreach ($result as $data) :
            $sheet->setCellValue("A" . $baris, $no);
            $sheet->setCellValue("B" . $baris, $data->no_uji);
            $sheet->setCellValue("C" . $baris, $data->no_kendaraan);
            $sheet->setCellValue("D" . $baris, $data->nama_pemilik);
            $sheet->setCellValue("E" . $baris, $data->nm_komersil);
            $sheet->setCellValue("F" . $baris, $data->karoseri_jenis);
            //            $sheet->getRowDimension($baris)->setRowHeight(20);
            $baris++;
            $no++;
        endforeach;
        //END BODY
        //======================================================================
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $baris_border = $baris - 1;
        $sheet->getStyle("A5:F" . $baris_border)->applyFromArray($styleArray);
        //======================================================================
        //FOOTER
        $kepala = $baris + 1;
        $sheet->mergeCells("E" . $kepala . ":F" . $kepala);
        $sheet->setCellValue("E" . $kepala, "KEPALA UPTD PKB SURABAYA");
        $sheet->getStyle("E" . $kepala)->applyFromArray($styleTengah);

        $nama = $kepala + 5;
        $sheet->mergeCells("E" . $nama . ":F" . $nama);
        $sheet->setCellValue("E" . $nama, "Abdul Manab, SH.");
        $sheet->getStyle("E" . $nama)->applyFromArray($styleTengah);

        $penata = $nama + 1;
        $sheet->mergeCells("E" . $penata . ":F" . $penata);
        $sheet->setCellValue("E" . $penata, "Penata");
        $sheet->getStyle("E" . $penata)->applyFromArray($styleTengah);

        $nip = $penata + 1;
        $sheet->mergeCells("E" . $nip . ":F" . $nip);
        $sheet->setCellValue("E" . $nip, "NIP. 19630402 198910 1 003");
        $sheet->getStyle("E" . $nip)->applyFromArray($styleTengah);

        //        $sheet->getHeaderFooter()->setOddFooter('&R&F Page &P / &N');
        //        $sheet->getHeaderFooter()->setEvenFooter('&R&F Page &P / &N');
        $sheet->getHeaderFooter()->setOddFooter('&R Page &P / &N');
        $sheet->getHeaderFooter()->setEvenFooter('&R Page &P / &N');
        //END FOOTER
        //======================================================================
        //======================================================================
        // DATA KENDARAAN YANG TIDAK DATANG UJI 
        //HEADER
        $xls->createSheet(1);
        $xls->setActiveSheetIndex(1);
        $sheetTidakDatang = $xls->getActiveSheet();
        $sheetTidakDatang->setTitle('TIDAK LULUS');

        $sheetTidakDatang->mergeCells("A1:F1");
        $sheetTidakDatang->setCellValue("A1", "LAPORAN KELULUSAN KENDARAAN UJI");
        $sheetTidakDatang->getStyle("A1")->getFont()->setSize(20);
        $sheetTidakDatang->getStyle("A1")->applyFromArray($styleTengah);

        $sheetTidakDatang->mergeCells("A2:F2");
        $sheetTidakDatang->setCellValue("A2", "UPTD PKB WIYUNG DISHUB SURABAYA");
        $sheetTidakDatang->getStyle("A2")->getFont()->setSize(20);
        $sheetTidakDatang->getStyle("A2")->applyFromArray($styleTengah);

        $sheetTidakDatang->mergeCells("A3:F3");
        $sheetTidakDatang->setCellValue("A3", date("d F Y", strtotime($selectDate)));
        $sheetTidakDatang->getStyle("A3")->getFont()->setSize(14);
        $sheetTidakDatang->getStyle("A3")->applyFromArray($styleTengah);

        $sheetTidakDatang->setCellValue("A5", "NO");
        $sheetTidakDatang->getStyle("A5")->applyFromArray($styleTengah);
        $sheetTidakDatang->getStyle("A")->applyFromArray($styleTengah);
        $sheetTidakDatang->getColumnDimension('A')->setAutoSize(true);

        $sheetTidakDatang->setCellValue("B5", "NO UJI");
        $sheetTidakDatang->getStyle("B5")->applyFromArray($styleTengah);
        $sheetTidakDatang->getStyle("B")->applyFromArray($styleTengahHorizontal);
        $sheetTidakDatang->getStyle("B")->getAlignment()->setWrapText(true);
        $sheetTidakDatang->getColumnDimension('B')->setWidth(14);

        $sheetTidakDatang->setCellValue("C5", "NO KENDARAAN");
        $sheetTidakDatang->getStyle("C5")->applyFromArray($styleTengah);
        $sheetTidakDatang->getStyle("C")->applyFromArray($styleTengahHorizontal);
        $sheetTidakDatang->getStyle("C5")->getAlignment()->setWrapText(true);
        $sheetTidakDatang->getStyle("C")->getAlignment()->setWrapText(true);
        $sheetTidakDatang->getColumnDimension('C')->setWidth(12);

        $sheetTidakDatang->setCellValue("D5", "NAMA PEMILIK");
        $sheetTidakDatang->getStyle("D5")->applyFromArray($styleTengah);
        $sheetTidakDatang->getStyle("D")->applyFromArray($styleTengahHorizontal);
        $sheetTidakDatang->getStyle("D")->getAlignment()->setWrapText(true);
        $sheetTidakDatang->getColumnDimension('D')->setWidth(30);

        $sheetTidakDatang->setCellValue("E5", "NAMA KOMERSIL");
        $sheetTidakDatang->getStyle("E5")->applyFromArray($styleTengah);
        $sheetTidakDatang->getStyle("E")->applyFromArray($styleTengahHorizontal);
        $sheetTidakDatang->getStyle("E5")->getAlignment()->setWrapText(true);
        $sheetTidakDatang->getStyle("E")->getAlignment()->setWrapText(true);
        $sheetTidakDatang->getColumnDimension('E')->setWidth(15.56);

        $sheetTidakDatang->setCellValue("F5", "JENIS KAROSERI");
        $sheetTidakDatang->getStyle("F5")->applyFromArray($styleTengah);
        $sheetTidakDatang->getStyle("F")->applyFromArray($styleTengahHorizontal);
        $sheetTidakDatang->getStyle("F5")->getAlignment()->setWrapText(true);
        $sheetTidakDatang->getStyle("F")->getAlignment()->setWrapText(true);
        $sheetTidakDatang->getColumnDimension('F')->setWidth(12.78);


        $sheetTidakDatang->getStyle('A5:F5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        //END HEADER
        //======================================================================

        $criteria = new CDbCriteria();
        $criteria->addCondition("hasil = false");
        $criteria->addCondition("jdatang::date = '$selectDate'");
        $result = VVerifikasi::model()->findAll($criteria);
        //======================================================================
        //BODY
        $no = 1;
        $baris = 6;
        foreach ($result as $data) :
            $sheetTidakDatang->setCellValue("A" . $baris, $no);
            $sheetTidakDatang->setCellValue("B" . $baris, $data->no_uji);
            $sheetTidakDatang->setCellValue("C" . $baris, $data->no_kendaraan);
            $sheetTidakDatang->setCellValue("D" . $baris, $data->nama_pemilik);
            $sheetTidakDatang->setCellValue("E" . $baris, $data->nm_komersil);
            $sheetTidakDatang->setCellValue("F" . $baris, $data->karoseri_jenis);
            //            $sheetTidakDatang->getRowDimension($baris)->setRowHeight(20);
            $baris++;
            $no++;
        endforeach;
        //END BODY
        //======================================================================
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $baris_border = $baris - 1;
        $sheetTidakDatang->getStyle("A5:F" . $baris_border)->applyFromArray($styleArray);
        //======================================================================
        //FOOTER
        $kepala = $baris + 1;
        $sheetTidakDatang->mergeCells("E" . $kepala . ":F" . $kepala);
        $sheetTidakDatang->setCellValue("E" . $kepala, "KEPALA UPTD PKB SURABAYA");
        $sheetTidakDatang->getStyle("E" . $kepala)->applyFromArray($styleTengah);

        $nama = $kepala + 5;
        $sheetTidakDatang->mergeCells("E" . $nama . ":F" . $nama);
        $sheetTidakDatang->setCellValue("E" . $nama, "Abdul Manab, SH.");
        $sheetTidakDatang->getStyle("E" . $nama)->applyFromArray($styleTengah);

        $penata = $nama + 1;
        $sheetTidakDatang->mergeCells("E" . $penata . ":F" . $penata);
        $sheetTidakDatang->setCellValue("E" . $penata, "Penata");
        $sheetTidakDatang->getStyle("E" . $penata)->applyFromArray($styleTengah);

        $nip = $penata + 1;
        $sheetTidakDatang->mergeCells("E" . $nip . ":F" . $nip);
        $sheetTidakDatang->setCellValue("E" . $nip, "NIP. 19630402 198910 1 003");
        $sheetTidakDatang->getStyle("E" . $nip)->applyFromArray($styleTengah);

        //        $sheetTidakDatang->getHeaderFooter()->setOddFooter('&R&F Page &P / &N');
        //        $sheetTidakDatang->getHeaderFooter()->setEvenFooter('&R&F Page &P / &N');
        $sheetTidakDatang->getHeaderFooter()->setOddFooter('&R Page &P / &N');
        $sheetTidakDatang->getHeaderFooter()->setEvenFooter('&R Page &P / &N');
        //END FOOTER
        //======================================================================
        ob_clean();
        $tgl_sekarang = date('d-m-Y');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Kelulusan[' . $tgl_sekarang . '].xls"');
        header('Set-Cookie: fileDownload=true; path=/');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $xlsWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel5');
        $xlsWriter->save('php://output');
        Yii::app()->end();
    }

    private function catatan($id_hasil_uji)
    {
        $data = VDetailTl::model()->findAllByAttributes(array('id_hasil_uji' => $id_hasil_uji));
        $ul = "<ul>";
        foreach ($data as $p) {
            $ul .= "<li>" . $p->kelulusan . "</li>";
        }
        $ul .= "</ul>";
        return $ul;
    }

    public function actionSaveCetakl()
    {
        $id = $_POST['id'];
        $posisi = $_POST['posisi'];
        $nrp = $_POST['penguji'];

        //PENGUJI
        $tblPenguji = TblNamaPenguji::model()->findByAttributes(array('nrp' => $nrp));
        $nm_penguji = $tblPenguji['nama_penguji'];
        $jabatan = $tblPenguji['jabatan'];
        $jam_selesai = date('m/d/Y g:i:s');

        $tblHasilUji = TblHasilUji::model()->findByAttributes(array('id_hasil_uji' => $id));
        //        if ($tblHasilUji->cetak == false) {
        $sql = "UPDATE tbl_hasil_uji SET nm_penguji='$nm_penguji', jabatan = '$jabatan', jselesai = '$jam_selesai', cetak = 'true', nrp = '$nrp'  WHERE id_hasil_uji = $id";
        Yii::app()->db->createCommand($sql)->query();
        $today = date('Y-m-d');
        //            ==============
        //            CARA 1
        //            ==============
        $tgl_mati_uji = date('n/j/Y', strtotime('+6 month', strtotime($today)));
        //            ==============
        //            CARA 2
        //            ==============
        //            $tambah_tanggal = mktime(0,0,0,date('m')+6);
        //            $tgl_mati_uji = date('n/j/Y',$tambah_tanggal);
        //            ==============
        //            CARA 3
        //            ==============
        //            $date = date_create($today);
        //            date_add($date, date_interval_create_from_date_string('6 months'));
        //            $tgl_mati_uji = date_format($date, 'n/j/Y');
        $sql_mati_uji = "UPDATE tbl_kendaraan SET tgl_mati_uji = '$tgl_mati_uji' where id_kendaraan = $tblHasilUji->id_kendaraan";
        Yii::app()->db->createCommand($sql_mati_uji)->query();
        $sql_daftar = "UPDATE tbl_daftar SET lulus = 'true' where id_daftar = $tblHasilUji->id_daftar";
        Yii::app()->db->createCommand($sql_daftar)->query();
        /*
         * CREATE RIWAYAT
         */
        $cekRiwayat = TblRiwayat::model()->findByAttributes(array('id_hasil_uji' => $id));
        if (!empty($cekRiwayat)) {
            $sql_riwayat = "UPDATE tbl_riwayat SET nama_penguji='$nm_penguji', nrp = '$nrp'  WHERE id_hasil_uji = $id";
            Yii::app()->db->createCommand($sql_riwayat)->query();
        } else {
            $modelRiwayat = new TblRiwayat();
            $modelRiwayat->tgl_uji = date("m/d/Y");
            $modelRiwayat->tempat = 'PAMEKASAN';
            $modelRiwayat->catatan = '';
            $modelRiwayat->nama_penguji = $nm_penguji;
            $modelRiwayat->id_hasil_uji = $id;
            $modelRiwayat->id_kendaraan = $tblHasilUji->id_kendaraan;
            $modelRiwayat->nrp = $nrp;
            $modelRiwayat->stts_kirim = 0;
            $modelRiwayat->save();
        }
        //        } else {
        //            $sql = "UPDATE tbl_hasil_uji SET nm_penguji='$nm_penguji', jabatan = '$jabatan', cetak = 'true', nrp = '$nrp'  WHERE id_hasil_uji = $id";
        //            Yii::app()->db->createCommand($sql)->query();
        //        }
    }

    public function actionCetakl($id, $posisi, $nrp)
    {
        $this->layout = '//';
        $this->render('cetak_l', array('id' => $id, 'nrp' => $nrp, 'posisi' => $posisi));
    }

    public function actionViewImage()
    {
        $id_hasil_uji = $_POST['idHasilUji'];
        $data = TblHasilUji::model()->findByPk($id_hasil_uji);
        echo json_encode(
            array(
                'img_depan' => $data->img_depan,
                'img_belakang' => $data->img_belakang,
                'img_kanan' => $data->img_kanan,
                'img_kiri' => $data->img_kiri,
            )
        );
    }
}
