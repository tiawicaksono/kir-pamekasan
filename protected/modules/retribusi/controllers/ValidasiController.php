<?php

class ValidasiController extends Controller
{

    public function filters()
    {
        return array(
            'Rights', // perform access control for CRUD operations
        );
    }

    public function actionIndex()
    {
        $this->pageTitle = 'VALIDASI';
        $this->render('list_validasi');
    }

    public function actionValidasilistgrid()
    {
        $ok = Yii::app()->baseUrl . "/images/icon_approve.png";
        $reject = Yii::app()->baseUrl . "/images/icon_reject.png";
        $validasi = $_POST['chooseValidasi'];
        $selectCategory = $_POST['selectCategory'];
        $textCategory = strtoupper($_POST['textCategory']);
        $selectDate = strtoupper($_POST['selectDate']);
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
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
                $criteria->addCondition("(replace(LOWER(no_uji),' ','') like replace(LOWER('%" . $textCategory . "%'),' ','') OR replace(LOWER(no_kendaraan),' ','') like replace(LOWER('" . $textCategory . "'),' ',''))");
            }
        }
        if ($validasi != 'all') {
            $criteria->addCondition("validasi = $validasi");
        }
        $criteria->addCondition("tgl_retribusi = TO_DATE('" . $selectDate . "', 'DD-Mon-YY')");
        //        $criteria->addCondition("tgl_retribusi = 'now' ::text::date");
        //        $criteria->addCondition("tgl_retribusi = TO_DATE('26/10/16', 'DD/MM/YY')");
        $result = VValidasi::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataJson[] = array(
                "ACTIONS" => $p->id_retribusi,
                "kuitansi" => $p->id_retribusi,
                "id_retribusi" => $p->id_retribusi,
                "numerator" => $p->numerator,
                "no_uji" => $p->no_uji,
                "no_kendaraan" => $p->no_kendaraan,
                "uji" => $p->nm_uji,
                "nama_pemilik" => $p->nama_pemilik,
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

    public function actionValidasilistgridPetugas()
    {
        $ok = Yii::app()->baseUrl . "/images/icon_approve.png";
        $reject = Yii::app()->baseUrl . "/images/icon_reject.png";
        $validasi = $_POST['chooseValidasi'];
        $selectCategory = $_POST['selectCategory'];
        $textCategory = strtoupper($_POST['textCategory']);
        $selectDate = strtoupper($_POST['selectDate']);
        $petugas = Yii::app()->session['username'];
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
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
                $criteria->addCondition("(replace(LOWER($selectCategory),' ','') like replace(LOWER('%" . $textCategory . "%'),' ',''))");
            }
        }
        if ($validasi != 'all') {
            $criteria->addCondition("validasi = $validasi");
        }
        $criteria->addCondition("tgl_retribusi = TO_DATE('" . $selectDate . "', 'DD-Mon-YY')");
        //        $criteria->addCondition("tgl_retribusi = 'now' ::text::date");
        $criteria->addCondition("penerima like '$petugas'");
        $result = VValidasi::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $data_kendaran = TblKendaraan::model()->getDataKendaraan($p->no_uji);
            $tgl_mati = TblRetribusi::model()->findByPk($p->id_retribusi)->tglmati;
            $dataJson[] = array(
                "ACTIONS" => $p->id_retribusi,
                "idret_tglmati" => $p->id_retribusi . "_" . $tgl_mati,
                "id_retribusi" => $p->id_retribusi,
                "numerator" => $p->numerator,
                "no_uji" => $p->no_uji,
                "no_kendaraan" => $p->no_kendaraan,
                "uji" => $p->nm_uji,
                "nama_pemilik" => $data_kendaran->nama_pemilik,
                //                "no_mesin" => $data_kendaran->no_mesin,
                //                "no_chasis" => $data_kendaran->no_chasis,
                "b_berkala" => $p->b_berkala,
                "b_pertama" => $p->b_pertama,
                "b_tlt_uji" => $p->b_tlt_uji,
                "b_plat_uji" => $p->b_plat_uji,
                "b_buku" => $p->b_buku,
                "b_tnd_samping" => $p->b_tnd_samping,
                "b_jbb" => $p->b_jbb,
                "b_rekom" => $p->b_rekom,
                "total" => $p->total,
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

    public function actionProsesValidChecked()
    {
        $idArray = $_POST['idArray'];
        $kondisi = $_POST['kondisi'];
        foreach ($idArray as $key => $arrayId) :
            $sqlUpdRetribusi = "UPDATE tbl_retribusi SET validasi = $kondisi WHERE id_retribusi = $arrayId ";
            Yii::app()->db->createCommand($sqlUpdRetribusi)->execute();
        endforeach;
    }

    public function actionProsesValid()
    {
        $idRetribusi = $_POST['idRetribusi'];
        $kondisi = $_POST['kondisi'];
        $sqlUpdRetribusi = "UPDATE tbl_retribusi SET validasi = $kondisi WHERE id_retribusi = $idRetribusi";
        Yii::app()->db->createCommand($sqlUpdRetribusi)->execute();
    }

    public function actionRekapValidasi($tgl)
    {
        Yii::import("ext.PHPExcel", TRUE);
        $xls = new PHPExcel();
        $sheet = $xls->getActiveSheet();
        $xls->setActiveSheetIndex(0);
        $tglIndonesia = date("d", strtotime($tgl)) . " " . strtoupper(Yii::app()->params['bulanArrayInd'][date("n", strtotime($tgl)) - 1]) . " " . date("Y", strtotime($tgl));
        //======================================================================
        //HEADER
        $sheet->mergeCells("A1:M1");
        $sheet->setCellValue("A1", "DINAS PERHUBUNGAN");
        $sheet->getStyle("A1")->getFont()->setSize(16);
        $sheet->getStyle("A1")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A1")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("A1")->getFont()->setBold(true);

        $sheet->mergeCells("A2:M2");
        $sheet->setCellValue("A2", "KABUPATEN PAMEKASAN");
        $sheet->getStyle("A2")->getFont()->setSize(16);
        $sheet->getStyle("A2")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A2")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("A2")->getFont()->setBold(true);

        $sheet->mergeCells("A3:M3");
        $sheet->setCellValue("A3", "DAFTAR PENERIMAAN UANG PENGUJIAN KENDARAAN BERMOTOR");
        $sheet->getStyle("A3")->getFont()->setSize(12);
        $sheet->getStyle("A3")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A3")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("A3")->getFont()->setBold(true);

        $sheet->mergeCells("A4:M4");
        $sheet->setCellValue("A4", $tglIndonesia);
        $sheet->getStyle("A4")->getFont()->setSize(12);
        $sheet->getStyle("A4")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A4")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("A4")->getFont()->setBold(true);

        $sheet->mergeCells("A6:A7");
        $sheet->setCellValue("A6", "NO");
        $sheet->getStyle("A6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("A")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("A")->setWidth(5);
        $sheet->getRowDimension(6)->setRowHeight(55);
        $sheet->getRowDimension(7)->setRowHeight(55);

        $sheet->mergeCells("B6:C6");
        $sheet->setCellValue("B6", "URAIAN");
        $sheet->getStyle("B6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("B6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("B")->setWidth(15);
        $sheet->setCellValue("B7", "NO. KENDARAAN");
        $sheet->getStyle("B7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("B7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("B")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->setCellValue("C7", "NAMA PEMILIK");
        $sheet->getStyle("C7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("C7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("C")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("C")->setAutoSize(true);

        $sheet->mergeCells("D6:D7");
        $sheet->setCellValue("D6", "NO BUKTI KAS");
        $sheet->getStyle("D6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("D6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("D6")->getAlignment()->setWrapText(true);
        $sheet->getStyle("D")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("D")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension("D")->setWidth(10);

        $sheet->mergeCells("E6:E7");
        $sheet->setCellValue("E6", "UJI PERTAMA / BERKALA");
        $sheet->getStyle("E6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("E6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("E6")->getAlignment()->setWrapText(true);
        $sheet->getStyle("E")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("E")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("E")->setWidth(12);

        $sheet->mergeCells("F6:G6");
        $sheet->setCellValue("F6", "RETRIBUSI UJI");
        $sheet->getStyle("F6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("F6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->setCellValue("F7", "JBB > 3500");
        $sheet->getStyle("F7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("F7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("F")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("F")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("F")->setWidth(12);
        $sheet->setCellValue("G7", "JBB <= 3500");
        $sheet->getStyle("G7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("G7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("G")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("G")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("G")->setWidth(12);

        $sheet->mergeCells("H6:I6");
        $sheet->setCellValue("H6", "PENETAPAN LULUS UJI");
        $sheet->getStyle("H6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("H6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->setCellValue("H7", "TANDA SAMPING");
        $sheet->getStyle("H7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("H7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("H7")->getAlignment()->setWrapText(true);
        $sheet->getStyle("H")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("H")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("H")->setWidth(12);
        $sheet->setCellValue("I7", "PLAT UJI");
        $sheet->getStyle("I7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("I7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("I")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("I")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("I")->setWidth(12);

        $sheet->mergeCells("J6:J7");
        $sheet->setCellValue("J6", "BUKU UJI");
        $sheet->getStyle("J6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("J6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("J")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("J")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("J")->setWidth(12);

        $sheet->mergeCells("K6:K7");
        $sheet->setCellValue("K6", "BIAYA REKOM NU KELUAR / MTS KELUAR / ALIH FUNGSI / MODIFIKASI");
        $sheet->getStyle("K6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("K6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("K6")->getAlignment()->setWrapText(true);
        $sheet->getStyle("K")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("K")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("K")->setWidth(12);

        $sheet->mergeCells("L6:L7");
        $sheet->setCellValue("L6", "DENDA");
        $sheet->getStyle("L6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("L6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("L")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("L")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("L")->setWidth(12);

        $sheet->mergeCells("M6:M7");
        $sheet->setCellValue("M6", "TOTAL");
        $sheet->getStyle("M6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("M6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("M")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("M")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("M")->setWidth(12);

        $sheet->getStyle("A6:M7")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        //END HEADER
        //======================================================================
        $criteria = new CDbCriteria();
        $criteria->addCondition("tgl_retribusi = TO_DATE('" . $tgl . "', 'DD-Mon-YY')");
        $criteria->addCondition('validasi = true');
        $result = VValidasi::model()->findAll($criteria);
        //======================================================================
        //BODY
        $no = 1;
        $baris = 8;
        foreach ($result as $data) :
            $sheet->setCellValue("A" . $baris, $no);
            $sheet->setCellValue("B" . $baris, $data->no_kendaraan);
            $sheet->setCellValue("C" . $baris, $data->nama_pemilik);
            $sheet->setCellValue("D" . $baris, $data->numerator);
            $sheet->setCellValue("E" . $baris, floatval($data->b_berkala) + floatval($data->b_pertama));
            $sheet->setCellValue("F" . $baris, floatval($data->b_jbb_lebih));
            $sheet->setCellValue("G" . $baris, floatval($data->b_jbb_kurang));
            $sheet->setCellValue("H" . $baris, floatval($data->b_tnd_samping));
            $sheet->setCellValue("I" . $baris, floatval($data->b_plat_uji));
            $sheet->setCellValue("J" . $baris, floatval($data->b_buku));
            $sheet->setCellValue("K" . $baris, floatval($data->b_rekom));
            $sheet->setCellValue("L" . $baris, floatval($data->b_tlt_uji));
            $sheet->setCellValue("M" . $baris, "=SUM(E" . $baris . ":L" . $baris . ")");
            $sheet->getRowDimension($baris)->setRowHeight(20);
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
        $sheet->getStyle("A" . $baris . ":M" . $baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        $sheet->getStyle("A6:M" . $baris)->applyFromArray($styleArray);
        $sheet->getStyle("D8:M" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        //======================================================================
        //FOOTER
        $sheet->mergeCells("A" . $baris . ":D" . $baris);
        $sheet->setCellValue("A" . $baris, "TOTAL");
        $sheet->getStyle("A" . $baris)->getFont()->setBold(true);
        $sheet->getStyle("A" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("E" . $baris, '=SUM(E8:E' . $baris_border . ')');
        $sheet->getStyle("E" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("E" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("F" . $baris, '=SUM(F8:F' . $baris_border . ')');
        $sheet->getStyle("F" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("F" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("G" . $baris, '=SUM(G8:G' . $baris_border . ')');
        $sheet->getStyle("G" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("G" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("H" . $baris, '=SUM(H8:H' . $baris_border . ')');
        $sheet->getStyle("H" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("H" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("I" . $baris, '=SUM(I8:I' . $baris_border . ')');
        $sheet->getStyle("I" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("I" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("J" . $baris, '=SUM(J8:J' . $baris_border . ')');
        $sheet->getStyle("J" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("J" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("K" . $baris, '=SUM(K8:K' . $baris_border . ')');
        $sheet->getStyle("K" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("K" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("L" . $baris, '=SUM(L8:L' . $baris_border . ')');
        $sheet->getStyle("L" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("L" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("M" . $baris, '=SUM(M8:M' . $baris_border . ')');
        $sheet->getStyle("M" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("M" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        //END FOOTER
        //======================================================================
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="RETRIBUSI_' . $tglIndonesia . '.xls"');
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

    public function actionCobaSts($tgl)
    {
        $function_no_sts = "select get_no_sts('$tgl')";
        $no_sts = Yii::app()->db->createCommand($function_no_sts)->queryRow();
        print_r($no_sts['get_no_sts']);
    }

    public function actionRekapSts($tgl)
    {
        Yii::import("ext.PHPExcel", TRUE);
        $xls = new PHPExcel();
        $sheet = $xls->getActiveSheet();
        $xls->setActiveSheetIndex(0);
        $tglIndonesia = date("d", strtotime($tgl)) . " " . strtoupper(Yii::app()->params['bulanArrayInd'][date("n", strtotime($tgl)) - 1]) . " " . date("Y", strtotime($tgl));
        $function_no_sts = "select get_no_sts('$tgl')";
        $get_no_sts = Yii::app()->db->createCommand($function_no_sts)->queryRow();
        $no_sts = $get_no_sts['get_no_sts'];
        //======================================================================
        //======================================================================
        //NILAI RETRIBUSI
        $criteria = new CDbCriteria();
        $criteria->select = "SUM(b_berkala) as b_berkala, SUM(b_pertama) as b_pertama, SUM(b_tnd_samping) as b_tnd_samping, SUM(b_plat_uji) as b_plat_uji, SUM(b_buku) as b_buku, SUM(b_tlt_uji) as b_tlt_uji, SUM(b_jbb_lebih) as b_jbb_lebih, SUM(b_jbb_kurang) as b_jbb_kurang, SUM(b_rekom) as b_rekom";
        $criteria->addCondition("tgl_retribusi = TO_DATE('" . $tgl . "', 'DD-Mon-YY')");
        $criteria->addCondition("validasi = 'true'");
        $result = VValidasi::model()->find($criteria);

        $b_pendaftaran = $result->b_berkala + $result->b_pertama;
        $b_tnd_samping = $result->b_tnd_samping;
        $b_plat_uji = $result->b_plat_uji;
        $buku_uji = $result->b_buku;
        $b_tlt_uji = $result->b_tlt_uji;
        $b_jbb_lebih = $result->b_jbb_lebih;
        $b_jbb_kurang = $result->b_jbb_kurang;
        $b_rekom = $result->b_rekom;
        //======================================================================
        $sheet->getColumnDimension("A")->setWidth(6);
        $sheet->getColumnDimension("B")->setWidth(44.89);
        $sheet->getColumnDimension("C")->setWidth(5);
        $sheet->getColumnDimension("D")->setWidth(14.89);
        $sheet->getColumnDimension("E")->setWidth(9.11);
        $sheet->getColumnDimension("F")->setWidth(9.11);
        $sheet->getColumnDimension("G")->setWidth(6.45);
        //        $sheet->getColumnDimension("A")->setWidth(5.22);
        //        $sheet->getColumnDimension("B")->setWidth(39.11);
        //        $sheet->getColumnDimension("C")->setWidth(4.22);
        //        $sheet->getColumnDimension("D")->setWidth(14.11);
        //        $sheet->getColumnDimension("E")->setWidth(8.33);
        //        $sheet->getColumnDimension("F")->setWidth(8.33);
        //        $sheet->getColumnDimension("G")->setWidth(5.67);
        for ($i = 1; $i <= 54; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(15.60);
        }
        //======================================================================
        $styleFontBold12 = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Times New Roman'
            )
        );
        $styleFontNormal12 = array(
            'font'  => array(
                'bold'  => false,
                'size'  => 12,
                'name'  => 'Times New Roman'
            )
        );
        $styleFontNormal10 = array(
            'font'  => array(
                'bold'  => false,
                'size'  => 10,
                'name'  => 'Times New Roman'
            )
        );
        $styleTengah = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $styleTengahKiri = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $styleTengahKanan = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $styleBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $styleBorderBottom = array(
            'borders' => array(
                'bottomborder' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $sheet->getStyle("D9:D19")->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle("D37:D47")->getNumberFormat()->setFormatCode('#,##0.00');
        //======================================================================
        //YANG PAGE ATAS
        //======================================================================
        //HEADER
        $sheet->mergeCells("F3:G3");
        $sheet->setCellValue("F3", "NO : " . $no_sts);
        $sheet->getStyle("F3")->applyFromArray($styleTengah);
        $sheet->getStyle("F3")->applyFromArray($styleFontNormal12);

        $sheet->mergeCells("A4:G4");
        $sheet->setCellValue("A4", "DINAS PERHUBUNGAN");
        $sheet->getStyle("A4")->applyFromArray($styleTengah);
        $sheet->getStyle("A4")->applyFromArray($styleFontBold12);

        $sheet->mergeCells("A5:G5");
        $sheet->setCellValue("A5", "KABUPATEN PAMEKASAN");
        $sheet->getStyle("A5")->applyFromArray($styleTengah);
        $sheet->getStyle("A5")->applyFromArray($styleFontBold12);

        $sheet->mergeCells("A6:G6");
        $sheet->setCellValue("A6", "JL. BONOROGO NO. 88 TELP. (0324) 322440, 326130");
        $sheet->getStyle("A6")->applyFromArray($styleTengah);
        $sheet->getStyle("A6")->applyFromArray($styleFontNormal10);

        $sheet->mergeCells("A7:G7");
        $sheet->setCellValue("A7", "RETRIBUSI PENGUJIAN KENDARAAN BERMOTOR");
        $sheet->getStyle("A7")->applyFromArray($styleTengah);
        $sheet->getStyle("A7")->applyFromArray($styleFontNormal12);
        //======================================================================
        //CONTENT
        //PENDAFTARAN
        $sheet->setCellValue("B9", "Pendaftaran");
        $sheet->getStyle("B9")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B9")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C9", ":");
        $sheet->getStyle("C9")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C9")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D9", $b_pendaftaran);
        $sheet->getStyle("D9")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D9")->applyFromArray($styleFontNormal12);
        //RETRIBUSI UJI TRUCK
        $sheet->setCellValue("B10", "Retribusi Uji Truck / Bus");
        $sheet->getStyle("B10")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B10")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C10", ":");
        $sheet->getStyle("C10")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C10")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D10", $b_jbb_lebih);
        $sheet->getStyle("D10")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D10")->applyFromArray($styleFontNormal12);
        //RETRIBUSI UJI MPU / Pick Up / Microbus
        $sheet->setCellValue("B11", "Retribusi Uji MPU / Pick Up / Microbus");
        $sheet->getStyle("B11")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B11")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C11", ":");
        $sheet->getStyle("C11")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C11")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D11", $b_jbb_kurang);
        $sheet->getStyle("D11")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D11")->applyFromArray($styleFontNormal12);
        //TANDA SAMPING
        $sheet->setCellValue("B12", "Tanda Samping");
        $sheet->getStyle("B12")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B12")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C12", ":");
        $sheet->getStyle("C12")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C12")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D12", $b_tnd_samping);
        $sheet->getStyle("D12")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D12")->applyFromArray($styleFontNormal12);
        //TANDA UJI
        $sheet->setCellValue("B13", "Tanda Uji");
        $sheet->getStyle("B13")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B13")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C13", ":");
        $sheet->getStyle("C13")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C13")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D13", $b_plat_uji);
        $sheet->getStyle("D13")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D13")->applyFromArray($styleFontNormal12);
        //BUKU UJI
        $sheet->setCellValue("B14", "Buku Uji");
        $sheet->getStyle("B14")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B14")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C14", ":");
        $sheet->getStyle("C14")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C14")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D14", $buku_uji);
        $sheet->getStyle("D14")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D14")->applyFromArray($styleFontNormal12);
        //ALIH FUNGSI / MODIFIKASI
        $sheet->setCellValue("B15", "Rek Numpang / Mutasi / Alih Fungsi / Modifikasi");
        $sheet->getStyle("B15")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B15")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C15", ":");
        $sheet->getStyle("C15")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C15")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D15", $b_rekom);
        $sheet->getStyle("D15")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D15")->applyFromArray($styleFontNormal12);
        //REKOMENDASI NUMPANG UJI / MUTASI
        //        $sheet->setCellValue("B16", "Rekomendasi Numpang Uji / Mutasi");
        //        $sheet->getStyle("B16")->applyFromArray($styleTengahKiri);
        //        $sheet->getStyle("B16")->applyFromArray($styleFontNormal12);
        //        $sheet->setCellValue("C16", ":");
        //        $sheet->getStyle("C16")->applyFromArray($styleTengahKiri);
        //        $sheet->getStyle("C16")->applyFromArray($styleFontNormal12);
        //        $sheet->setCellValue("D16", $b_rekom_numpang_mutasi);
        //        $sheet->getStyle("D16")->applyFromArray($styleTengahKanan);
        //        $sheet->getStyle("D16")->applyFromArray($styleFontNormal12);
        //TERLAMBAT DAFTAR / DENDA
        $sheet->setCellValue("B16", "Terlambat Daftar / Denda");
        $sheet->getStyle("B16")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B16")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C16", ":");
        $sheet->getStyle("C16")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C16")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D16", $b_tlt_uji);
        $sheet->getStyle("D16")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D16")->applyFromArray($styleFontNormal12);
        $sheet->getStyle("B17:F17")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        //JUMLAH
        $sheet->setCellValue("B19", "JUMLAH");
        $sheet->getStyle("B19")->applyFromArray($styleTengah);
        $sheet->getStyle("B19")->applyFromArray($styleFontBold12);
        $sheet->setCellValue("C19", ": Rp.");
        $sheet->getStyle("C19")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C19")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D19", "=SUM(D9:D17)");
        $sheet->getStyle("D19")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D19")->applyFromArray($styleFontNormal12);
        //======================================================================
        //BAWAH
        $sheet->mergeCells("C21:F21");
        $sheet->setCellValue("C21", "Pamekasan, " . ucwords(strtolower($tglIndonesia)));
        $sheet->getStyle("C21")->applyFromArray($styleTengah);
        $sheet->getStyle("C21")->applyFromArray($styleFontNormal12);

        $sheet->setCellValue("B22", "Penyetor");
        $sheet->getStyle("B22")->applyFromArray($styleTengah);
        $sheet->getStyle("B22")->applyFromArray($styleFontNormal12);

        $sheet->mergeCells("C22:F22");
        $sheet->setCellValue("C22", "Kasir Penerima");
        $sheet->getStyle("C22")->applyFromArray($styleTengah);
        $sheet->getStyle("C22")->applyFromArray($styleFontNormal12);

        $sheet->setCellValue("B25", "R. MOH. JUFFRI");
        $sheet->getStyle("B25")->applyFromArray($styleTengah);
        $sheet->getStyle("B25")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("B26", "NIP. 19760125 200701 1 004");
        $sheet->getStyle("B26")->applyFromArray($styleTengah);
        $sheet->getStyle("B26")->applyFromArray($styleFontNormal12);

        $sheet->mergeCells("C25:F25");
        $sheet->mergeCells("C26:F26");
        $sheet->setCellValue("C25", "MARWATI");
        $sheet->getStyle("C25")->applyFromArray($styleTengah);
        $sheet->getStyle("C25")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C26", "NIP. 19660412 200801 2 008");
        $sheet->getStyle("C26")->applyFromArray($styleTengah);
        $sheet->getStyle("C26")->applyFromArray($styleFontNormal12);
        //======================================================================
        //YANG PAGE BAWAH
        //======================================================================
        //HEADER
        $sheet->mergeCells("F31:G31");
        $sheet->setCellValue("F31", "=F3");
        $sheet->getStyle("F31")->applyFromArray($styleTengah);
        $sheet->getStyle("F31")->applyFromArray($styleFontNormal12);

        $sheet->mergeCells("A32:G32");
        $sheet->setCellValue("A32", "DINAS PERHUBUNGAN");
        $sheet->getStyle("A32")->applyFromArray($styleTengah);
        $sheet->getStyle("A32")->applyFromArray($styleFontBold12);

        $sheet->mergeCells("A33:G33");
        $sheet->setCellValue("A33", "KABUPATEN PAMEKASAN");
        $sheet->getStyle("A33")->applyFromArray($styleTengah);
        $sheet->getStyle("A33")->applyFromArray($styleFontBold12);

        $sheet->mergeCells("A34:G34");
        $sheet->setCellValue("A34", "JL. BONOROGO NO. 88 TELP. (0324) 322440, 326130");
        $sheet->getStyle("A34")->applyFromArray($styleTengah);
        $sheet->getStyle("A34")->applyFromArray($styleFontNormal10);

        $sheet->mergeCells("A35:G35");
        $sheet->setCellValue("A35", "RETRIBUSI PENGUJIAN KENDARAAN BERMOTOR");
        $sheet->getStyle("A35")->applyFromArray($styleTengah);
        $sheet->getStyle("A35")->applyFromArray($styleFontNormal12);
        //======================================================================
        //CONTENT
        //PENDAFTARAN
        $sheet->setCellValue("B37", "Pendaftaran");
        $sheet->getStyle("B37")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B37")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C37", ":");
        $sheet->getStyle("C37")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C37")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D37", "=D9");
        $sheet->getStyle("D37")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D37")->applyFromArray($styleFontNormal12);
        //RETRIBUSI UJI TRUCK
        $sheet->setCellValue("B38", "Retribusi Uji Truck / Bus");
        $sheet->getStyle("B38")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B38")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C38", ":");
        $sheet->getStyle("C38")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C38")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D38", "=D10");
        $sheet->getStyle("D38")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D38")->applyFromArray($styleFontNormal12);
        //RETRIBUSI UJI MPU / Pick Up / Microbus
        $sheet->setCellValue("B39", "Retribusi Uji MPU / Pick Up / Microbus");
        $sheet->getStyle("B39")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B39")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C39", ":");
        $sheet->getStyle("C39")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C39")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D39", "=D11");
        $sheet->getStyle("D39")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D39")->applyFromArray($styleFontNormal12);
        //TANDA SAMPING
        $sheet->setCellValue("B40", "Tanda Samping");
        $sheet->getStyle("B40")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B40")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C40", ":");
        $sheet->getStyle("C40")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C40")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D40", "=D12");
        $sheet->getStyle("D40")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D40")->applyFromArray($styleFontNormal12);
        //TANDA UJI
        $sheet->setCellValue("B41", "Tanda Uji");
        $sheet->getStyle("B41")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B41")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C41", ":");
        $sheet->getStyle("C41")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C41")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D41", "=D13");
        $sheet->getStyle("D41")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D41")->applyFromArray($styleFontNormal12);
        //BUKU UJI
        $sheet->setCellValue("B42", "Buku Uji");
        $sheet->getStyle("B42")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B42")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C42", ":");
        $sheet->getStyle("C42")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C42")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D42", "=D14");
        $sheet->getStyle("D42")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D42")->applyFromArray($styleFontNormal12);
        //ALIH FUNGSI / MODIFIKASI
        $sheet->setCellValue("B43", "Rek Numpang / Mutasi / Alih Fungsi / Modifikasi");
        $sheet->getStyle("B43")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B43")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C43", ":");
        $sheet->getStyle("C43")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C43")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D43", "=D15");
        $sheet->getStyle("D43")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D43")->applyFromArray($styleFontNormal12);
        //REKOMENDASI NUMPANG UJI / MUTASI
        //        $sheet->setCellValue("B44", "Rekomendasi Numpang Uji / Mutasi");
        //        $sheet->getStyle("B44")->applyFromArray($styleTengahKiri);
        //        $sheet->getStyle("B44")->applyFromArray($styleFontNormal12);
        //        $sheet->setCellValue("C44", ":");
        //        $sheet->getStyle("C44")->applyFromArray($styleTengahKiri);
        //        $sheet->getStyle("C44")->applyFromArray($styleFontNormal12);
        //        $sheet->setCellValue("D44", "=D16");
        //        $sheet->getStyle("D44")->applyFromArray($styleTengahKanan);
        //        $sheet->getStyle("D44")->applyFromArray($styleFontNormal12);
        //TERLAMBAT DAFTAR / DENDA
        $sheet->setCellValue("B44", "Terlambat Daftar / Denda");
        $sheet->getStyle("B44")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("B44")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C44", ":");
        $sheet->getStyle("C44")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C44")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D44", "=D16");
        $sheet->getStyle("D44")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D44")->applyFromArray($styleFontNormal12);
        $sheet->getStyle("B45:F45")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        //JUMLAH
        $sheet->setCellValue("B47", "JUMLAH");
        $sheet->getStyle("B47")->applyFromArray($styleTengah);
        $sheet->getStyle("B47")->applyFromArray($styleFontBold12);
        $sheet->setCellValue("C47", ": Rp.");
        $sheet->getStyle("C47")->applyFromArray($styleTengahKiri);
        $sheet->getStyle("C47")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("D47", "=SUM(D37:D45)");
        $sheet->getStyle("D47")->applyFromArray($styleTengahKanan);
        $sheet->getStyle("D47")->applyFromArray($styleFontNormal12);
        //======================================================================
        //BAWAH
        $sheet->mergeCells("C49:F49");
        $sheet->setCellValue("C49", "Pamekasan, " . ucwords(strtolower($tglIndonesia)));
        $sheet->getStyle("C49")->applyFromArray($styleTengah);
        $sheet->getStyle("C49")->applyFromArray($styleFontNormal12);

        $sheet->setCellValue("B50", "Penyetor");
        $sheet->getStyle("B50")->applyFromArray($styleTengah);
        $sheet->getStyle("B50")->applyFromArray($styleFontNormal12);

        $sheet->mergeCells("C50:F50");
        $sheet->setCellValue("C50", "Kasir Penerima");
        $sheet->getStyle("C50")->applyFromArray($styleTengah);
        $sheet->getStyle("C50")->applyFromArray($styleFontNormal12);

        $sheet->setCellValue("B53", "R. MOH. JUFFRI");
        $sheet->getStyle("B53")->applyFromArray($styleTengah);
        $sheet->getStyle("B53")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("B54", "NIP. 19760125 200701 1 004");
        $sheet->getStyle("B54")->applyFromArray($styleTengah);
        $sheet->getStyle("B54")->applyFromArray($styleFontNormal12);

        $sheet->mergeCells("C53:F53");
        $sheet->mergeCells("C54:F54");
        $sheet->setCellValue("C53", "MARWATI");
        $sheet->getStyle("C53")->applyFromArray($styleTengah);
        $sheet->getStyle("C53")->applyFromArray($styleFontNormal12);
        $sheet->setCellValue("C54", "NIP. 19660412 200801 2 008");
        $sheet->getStyle("C54")->applyFromArray($styleTengah);
        $sheet->getStyle("C54")->applyFromArray($styleFontNormal12);
        //======================================================================
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="STS_' . $tglIndonesia . '.xls"');
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

    public function actionCetakRetribusi($id)
    {
        $this->layout = '//';
        $data_retribusi = VValidasi::model()->findByAttributes(array('id_retribusi' => $id));
        $this->render('cetak_retribusi', array('id' => $id, 'data_retribusi' => $data_retribusi));
    }

    public function actionCetakRetribusis($id)
    {
        $this->layout = '//';
        $data_retribusi = VValidasi::model()->findByAttributes(array('id_retribusi' => $id));
        $this->render('cetak_retribusi_1', array('id' => $id, 'data_retribusi' => $data_retribusi));
    }

    public function actionGetListCalculator()
    {
        $idArray = $_POST['idArray'];

        $jmlTotal = 0;
        foreach ($idArray as $key => $arrayId) :
            $dtRetribusi = VValidasi::model()->findByAttributes(array('id_retribusi' => $arrayId));
            $no_uji = $dtRetribusi->no_uji;
            $numerator = $dtRetribusi->numerator;
            $total = number_format($dtRetribusi->total, 0, ',', '.');
            $jmlTotal += $dtRetribusi->total;
            $dataJson[] = array(
                "no_uji" => $no_uji,
                "numerator" => $numerator,
                "total" => $total,
            );
        endforeach;
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => count($idArray),
                'rows' => $dataJson,
                'totalcalculator' => number_format($jmlTotal, 0, ',', '.'),
            )
        );
    }
}
