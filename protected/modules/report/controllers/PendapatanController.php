<?php

class PendapatanController extends Controller
{

    public function actionIndex()
    {
        $this->pageTitle = 'Rekap Pendapatan';
        $this->render('index');
    }

    public function actionRekapPerBulan($tgl)
    {
        $blnThn = date("n-Y", strtotime($tgl));
        $explodeBlnThn = explode('-', $blnThn);
        $bln = $explodeBlnThn[0];
        $thn = $explodeBlnThn[1];

        Yii::import("ext.PHPExcel", TRUE);
        $xls = new PHPExcel();
        $sheet = $xls->getActiveSheet();
        $xls->setActiveSheetIndex(0);
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        //======================================================================
        //        $criteriaIndikator = new CDbCriteria();
        //        $criteriaIndikator->addInCondition('bulan', array($bln));
        //        $criteriaIndikator->addInCondition('tahun', array($thn));
        //        $indikator = TblIndikator::model()->find($criteriaIndikator);
        //======================================================================
        //HEADER
        $sheet->getRowDimension(5)->setRowHeight(20);
        $sheet->getRowDimension(6)->setRowHeight(20);
        $sheet->getRowDimension(7)->setRowHeight(20);
        $sheet->mergeCells("A1:P1");
        $sheet->setCellValue("A1", "DINAS PERHUBUNGAN KABUPATEN PAMEKASAN");
        $sheet->getStyle("A1")->getFont()->setSize(16);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A1")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A1")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->mergeCells("A2:P2");
        $sheet->setCellValue("A2", "HASIL PENDAPATAN PENGUJIAN KENDARAAN BERMOTOR");
        $sheet->getStyle("A2")->getFont()->setSize(16);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A2")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->mergeCells("A3:P3");
        $sheet->setCellValue("A3", "BULAN : " . strtoupper(Yii::app()->params['bulanArrayInd'][date("n", strtotime($tgl)) - 1]) . " " . date("Y", strtotime($tgl)));
        $sheet->getStyle("A3")->getFont()->setSize(12);
        $sheet->getStyle("A3")->getFont()->setBold(true);
        $sheet->getStyle("A3")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A3")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->mergeCells("A5:A7");
        $sheet->setCellValue("A5", "TGL");
        $sheet->getStyle("A5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("A")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("A")->setWidth(5);

        $sheet->mergeCells("B5:B7");
        $sheet->setCellValue("B5", "NO STS");
        $sheet->getStyle("B5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("B5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("B")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("B")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("B")->setWidth(8);

        $sheet->mergeCells("C5:G5");
        $sheet->setCellValue("C5", "JENIS PENDAPATAN");
        $sheet->getStyle("C5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("C5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->mergeCells("C6:C7");
        $sheet->setCellValue("C6", "UJI PERTAMA /BERKALA");
        $sheet->getStyle("C6")->getAlignment()->setWrapText(true);
        $sheet->getStyle("C6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("C6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("C")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("C")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("C")->setWidth(12);

        $sheet->mergeCells("D6:E6");
        $sheet->setCellValue("D6", "JBB > 3500");
        $sheet->getStyle("D6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("D6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("D7", "JML");
        $sheet->getStyle("D7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("D7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("D")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("D")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("D")->setWidth(10);

        $sheet->setCellValue("E7", "UANG (RP)");
        $sheet->getStyle("E7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("E7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("E")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("E")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("E")->setWidth(12);

        $sheet->mergeCells("F6:G6");
        $sheet->setCellValue("F6", "JBB <= 3500");
        $sheet->getStyle("F6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("F6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("F7", "JML");
        $sheet->getStyle("F7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("F7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("F")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("F")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("F")->setWidth(10);

        $sheet->setCellValue("G7", "UANG (RP)");
        $sheet->getStyle("G7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("G7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("G")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("G")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("G")->setWidth(12);

        $sheet->mergeCells("H5:I6");
        $sheet->setCellValue("H5", "TANDA SAMPING");
        $sheet->getStyle("H5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("H5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("H7", "JML");
        $sheet->getStyle("H7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("H7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("H")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("H")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("H")->setWidth(10);

        $sheet->setCellValue("I7", "UANG (RP)");
        $sheet->getStyle("I7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("I7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("I")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("I")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("I")->setWidth(12);

        $sheet->mergeCells("J5:K6");
        $sheet->setCellValue("J5", "TANDA UJI");
        $sheet->getStyle("J5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("J5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("J7", "JML");
        $sheet->getStyle("J7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("J7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("J")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("J")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("J")->setWidth(10);

        $sheet->setCellValue("K7", "UANG (RP)");
        $sheet->getStyle("K7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("K7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("K")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("K")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("K")->setWidth(12);

        $sheet->mergeCells("L5:M6");
        $sheet->setCellValue("L5", "BUKU UJI");
        $sheet->getStyle("L5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("L5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("L7", "JML");
        $sheet->getStyle("L7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("L7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("L")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("L")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("L")->setWidth(10);

        $sheet->setCellValue("M7", "UANG (RP)");
        $sheet->getStyle("M7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("M7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("M")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("M")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("M")->setWidth(12);

        $sheet->mergeCells("N5:N7");
        $sheet->setCellValue("N5", "BIAYA REKOM NU KELUAR / MTS KELUAR / ALIH FUNGSI / MODIFIKASI");
        $sheet->getStyle("N5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("N5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("N5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("N")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("N")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("N")->setWidth(13);

        $sheet->mergeCells("O5:O7");
        $sheet->setCellValue("O5", "DENDA");
        $sheet->getStyle("O5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("O5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("O5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("O")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("O")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("O")->setWidth(12);

        $sheet->mergeCells("P5:P7");
        $sheet->setCellValue("P5", "JUMLAH KAS");
        $sheet->getStyle("P5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("P5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("P5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("P")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("P")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("P")->setWidth(12);

        $sheet->getStyle("A5:P7")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        //END HEADER
        //======================================================================
        $criteria = new CDbCriteria();
        $criteria->addCondition("EXTRACT(YEAR FROM tgl_pad) =" . $thn);
        $criteria->addCondition("EXTRACT(MONTH FROM tgl_pad) =" . $bln);
        $criteria->order = "tgl_pad ASC";
        $result = TblLapPad::model()->findAll($criteria);
        //======================================================================
        //BODY
        $no = 1;
        $baris = 8;
        foreach ($result as $data) :
            //JBB <= 3500
            $criteria_kurang = new CDbCriteria();
            $criteria_kurang->select = 'SUM(b_jbb_kurang) as b_jbb';
            $criteria_kurang->addCondition("EXTRACT(YEAR FROM tgl_retribusi) =" . $thn);
            $criteria_kurang->addCondition("EXTRACT(MONTH FROM tgl_retribusi) =" . $bln);
            $criteria_kurang->addCondition("EXTRACT(DAY FROM tgl_retribusi) =" . date("d", strtotime($data->tgl_pad)));
            $result_kurang = VValidasi::model()->find($criteria_kurang);

            $criteria_jbb_kurang = new CDbCriteria();
            $criteria_jbb_kurang->select = 'b_jbb_kurang';
            $criteria_jbb_kurang->addCondition("b_jbb_kurang <> 0");
            $criteria_jbb_kurang->addCondition("EXTRACT(YEAR FROM tgl_retribusi) =" . $thn);
            $criteria_jbb_kurang->addCondition("EXTRACT(MONTH FROM tgl_retribusi) =" . $bln);
            $criteria_jbb_kurang->addCondition("EXTRACT(DAY FROM tgl_retribusi) =" . date("d", strtotime($data->tgl_pad)));
            $result_jbb_kurang = VValidasi::model()->find($criteria_jbb_kurang);
            //JBB > 3500
            $criteria_lebih = new CDbCriteria();
            $criteria_lebih->select = 'SUM(b_jbb_lebih) as b_jbb';
            $criteria_lebih->addCondition("EXTRACT(YEAR FROM tgl_retribusi) =" . $thn);
            $criteria_lebih->addCondition("EXTRACT(MONTH FROM tgl_retribusi) =" . $bln);
            $criteria_lebih->addCondition("EXTRACT(DAY FROM tgl_retribusi) =" . date("d", strtotime($data->tgl_pad)));
            $result_lebih = VValidasi::model()->find($criteria_lebih);

            $criteria_jbb_lebih = new CDbCriteria();
            $criteria_jbb_lebih->select = 'b_jbb_lebih,b_tnd_samping,b_plat_uji,b_buku';
            $criteria_jbb_lebih->addCondition("b_jbb_lebih <> 0 and b_plat_uji <> 0 and b_buku <> 0");
            $criteria_jbb_lebih->addCondition("EXTRACT(YEAR FROM tgl_retribusi) =" . $thn);
            $criteria_jbb_lebih->addCondition("EXTRACT(MONTH FROM tgl_retribusi) =" . $bln);
            $criteria_jbb_lebih->addCondition("EXTRACT(DAY FROM tgl_retribusi) =" . date("d", strtotime($data->tgl_pad)));
            $result_jbb_lebih = VValidasi::model()->find($criteria_jbb_lebih);

            $sheet->setCellValue("A" . $baris, date("d", strtotime($data->tgl_pad)));
            $sheet->setCellValue("B" . $baris, '');
            $sheet->setCellValue("C" . $baris, floatval($data->b_berkala) + floatval($data->b_pertama));
            $sheet->setCellValue("D" . $baris, '=E' . $baris . '/' . $result_jbb_kurang->b_jbb_kurang);
            $sheet->setCellValue("E" . $baris, floatval($result_kurang->b_jbb));
            $sheet->setCellValue("F" . $baris, '=G' . $baris . '/' . $result_jbb_lebih->b_jbb_lebih);
            $sheet->setCellValue("G" . $baris, floatval($result_lebih->b_jbb));
            $sheet->setCellValue("H" . $baris, '=I' . $baris . '/' . $result_jbb_lebih->b_tnd_samping);
            $sheet->setCellValue("I" . $baris, floatval($data->b_tnd_samping));
            $sheet->setCellValue("J" . $baris, '=K' . $baris . '/' . $result_jbb_lebih->b_plat_uji);
            $sheet->setCellValue("K" . $baris, floatval($data->b_plat_uji));
            $sheet->setCellValue("L" . $baris, '=M' . $baris . '/' . $result_jbb_lebih->b_buku);
            $sheet->setCellValue("M" . $baris, floatval($data->b_buku));
            $sheet->setCellValue("N" . $baris, floatval($data->b_rekom));
            $sheet->setCellValue("O" . $baris, floatval($data->b_tlt_uji));
            $sheet->setCellValue("P" . $baris, '=SUM(C' . $baris . ',E' . $baris . ',G' . $baris . ',I' . $baris . ',K' . $baris . ',M' . $baris . ',N' . $baris . ',O' . $baris . ')');
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
        $sheet->getRowDimension($baris)->setRowHeight(20);
        $baris_border = $baris - 1;
        $sheet->getStyle("A5:P" . $baris)->applyFromArray($styleArray);
        $sheet->getStyle("C8:C" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("E8:E" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("G8:G" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("I7:I" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("K7:K" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("M7:M" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("N7:N" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("O7:O" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("P7:P" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        //======================================================================
        //FOOTER
        //TOTAL
        $sheet->mergeCells("A" . $baris . ":B" . $baris);
        $sheet->setCellValue("A" . $baris, "TOTAL");
        $sheet->getStyle("A" . $baris)->getFont()->setBold(true);
        $sheet->getStyle("A" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("C" . $baris, '=SUM(C8:C' . $baris_border . ')');
        $sheet->getStyle("C" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("C" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("D" . $baris, '=SUM(D8:D' . $baris_border . ')');
        $sheet->getStyle("D" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("D" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("E" . $baris, '=SUM(E8:E' . $baris_border . ')');
        $sheet->getStyle("E" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("E" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("F" . $baris, '=SUM(F8:F' . $baris_border . ')');
        $sheet->getStyle("F" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("F" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("G" . $baris, '=SUM(G8:G' . $baris_border . ')');
        $sheet->getStyle("G" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("G" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("H" . $baris, '=SUM(H8:H' . $baris_border . ')');
        $sheet->getStyle("H" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("H" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("I" . $baris, '=SUM(I8:I' . $baris_border . ')');
        $sheet->getStyle("I" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("I" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("J" . $baris, '=SUM(J8:J' . $baris_border . ')');
        $sheet->getStyle("J" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("J" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("K" . $baris, '=SUM(K8:K' . $baris_border . ')');
        $sheet->getStyle("K" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("K" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("L" . $baris, '=SUM(L8:L' . $baris_border . ')');
        $sheet->getStyle("L" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("L" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("M" . $baris, '=SUM(M8:M' . $baris_border . ')');
        $sheet->getStyle("M" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("M" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("N" . $baris, '=SUM(N8:N' . $baris_border . ')');
        $sheet->getStyle("N" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("N" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("O" . $baris, '=SUM(O8:O' . $baris_border . ')');
        $sheet->getStyle("O" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("O" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("P" . $baris, '=SUM(P8:P' . $baris_border . ')');
        $sheet->getStyle("P" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("P" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->getStyle("A" . $baris . ":P" . $baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        //======================================================================
        //TANDA TANGAN
        //        $kepala = $baris + 2;
        //        $sheet->mergeCells("F" . $kepala . ":J" . $kepala);
        //        $sheet->setCellValue("F" . $kepala, "KEPALA UPTD PKB Surabaya");
        //        $sheet->getStyle("F" . $kepala)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        //
        //        $nama = $kepala + 5;
        //        $sheet->mergeCells("F" . $nama . ":J" . $nama);
        //        $sheet->setCellValue("F" . $nama, "Abdul Manab, SH.");
        //        $sheet->getStyle("F" . $nama)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        //
        //        $penata = $nama + 1;
        //        $sheet->mergeCells("F" . $penata . ":J" . $penata);
        //        $sheet->setCellValue("F" . $penata, "Penata");
        //        $sheet->getStyle("F" . $penata)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        //
        //        $nip = $penata + 1;
        //        $sheet->mergeCells("F" . $nip . ":J" . $nip);
        //        $sheet->setCellValue("F" . $nip, "NIP. 19630402 198910 1 003");
        //        $sheet->getStyle("F" . $nip)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        //END FOOTER
        //======================================================================
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Pendapatan per Bulan [' . $bln . '-' . $thn . '].xls"');
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

    public function actionRekapPerTahun($tgl)
    {
        $thn = $tgl;
        Yii::import("ext.PHPExcel", TRUE);
        $xls = new PHPExcel();
        $sheet = $xls->getActiveSheet();
        $xls->setActiveSheetIndex(0);
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(false);
        $sheet->getPageSetup()->setHorizontalCentered(true);
        $sheet->getPageSetup()->setVerticalCentered(true);
        $sheet->getPageSetup()->setScale(90);
        //======================================================================
        $criteriaIndikator = new CDbCriteria();
        //        $criteriaIndikator->addInCondition('bulan', array($bln));
        $criteriaIndikator->addInCondition('tahun', array($thn));
        $indikator = TblIndikator::model()->find($criteriaIndikator);
        //======================================================================
        //HEADER
        $sheet->getRowDimension(5)->setRowHeight(20);
        $sheet->getRowDimension(6)->setRowHeight(20);
        $sheet->getRowDimension(7)->setRowHeight(20);
        $sheet->mergeCells("A1:O1");
        $sheet->setCellValue("A1", "DINAS PERHUBUNGAN KABUPATEN PAMEKASAN");
        $sheet->getStyle("A1")->getFont()->setSize(16);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A1")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A1")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->mergeCells("A2:O2");
        $sheet->setCellValue("A2", "HASIL PENDAPATAN PENGUJIAN KENDARAAN BERMOTOR");
        $sheet->getStyle("A2")->getFont()->setSize(16);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A2")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->mergeCells("A5:B7");
        $sheet->setCellValue("A5", "BULAN");
        $sheet->getStyle("A5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("A")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("A")->setWidth(5);

        $sheet->mergeCells("C5:G5");
        $sheet->setCellValue("C5", "JENIS PENDAPATAN");
        $sheet->getStyle("C5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("C5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->mergeCells("C6:C7");
        $sheet->setCellValue("C6", "UJI PERTAMA /BERKALA");
        $sheet->getStyle("C6")->getAlignment()->setWrapText(true);
        $sheet->getStyle("C6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("C6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("C")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("C")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("C")->setWidth(12);

        $sheet->mergeCells("D6:E6");
        $sheet->setCellValue("D6", "JBB > 3500");
        $sheet->getStyle("D6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("D6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("D7", "JML");
        $sheet->getStyle("D7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("D7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("D")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("D")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("D")->setWidth(10);

        $sheet->setCellValue("E7", "UANG (RP)");
        $sheet->getStyle("E7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("E7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("E")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("E")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("E")->setWidth(12);

        $sheet->mergeCells("F6:G6");
        $sheet->setCellValue("F6", "JBB <= 3500");
        $sheet->getStyle("F6")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("F6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("F7", "JML");
        $sheet->getStyle("F7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("F7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("F")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("F")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("F")->setWidth(10);

        $sheet->setCellValue("G7", "UANG (RP)");
        $sheet->getStyle("G7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("G7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("G")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("G")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("G")->setWidth(12);

        $sheet->mergeCells("H5:I6");
        $sheet->setCellValue("H5", "TANDA SAMPING");
        $sheet->getStyle("H5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("H5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("H7", "JML");
        $sheet->getStyle("H7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("H7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("H")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("H")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("H")->setWidth(10);

        $sheet->setCellValue("I7", "UANG (RP)");
        $sheet->getStyle("I7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("I7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("I")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("I")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("I")->setWidth(12);

        $sheet->mergeCells("J5:K6");
        $sheet->setCellValue("J5", "TANDA UJI");
        $sheet->getStyle("J5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("J5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("J7", "JML");
        $sheet->getStyle("J7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("J7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("J")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("J")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("J")->setWidth(10);

        $sheet->setCellValue("K7", "UANG (RP)");
        $sheet->getStyle("K7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("K7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("K")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("K")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("K")->setWidth(12);

        $sheet->mergeCells("L5:M6");
        $sheet->setCellValue("L5", "BUKU UJI");
        $sheet->getStyle("L5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("L5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("L7", "JML");
        $sheet->getStyle("L7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("L7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("L")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("L")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("L")->setWidth(10);

        $sheet->setCellValue("M7", "UANG (RP)");
        $sheet->getStyle("M7")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("M7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("M")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("M")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("M")->setWidth(12);

        $sheet->mergeCells("N5:N7");
        $sheet->setCellValue("N5", "BIAYA REKOM NU KELUAR / MTS KELUAR / ALIH FUNGSI / MODIFIKASI");
        $sheet->getStyle("N5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("N5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("N5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("N")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("N")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("N")->setWidth(13);

        $sheet->mergeCells("O5:O7");
        $sheet->setCellValue("O5", "DENDA");
        $sheet->getStyle("O5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("O5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("O5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("O")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("O")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("O")->setWidth(12);

        $sheet->mergeCells("P5:P7");
        $sheet->setCellValue("P5", "JUMLAH KAS");
        $sheet->getStyle("P5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("P5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("P5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("P")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("P")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension("P")->setWidth(12);

        $sheet->getStyle("A5:P7")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        //END HEADER
        //======================================================================
        //BODY
        $no = 1;
        $baris = 8;
        for ($bln = 1; $bln <= 12; $bln++) :
            $criteria = new CDbCriteria();
            $criteria->select = 'SUM(b_berkala) as b_berkala,SUM(b_pertama) as b_pertama,SUM(b_tnd_samping) as b_tnd_samping,SUM(b_plat_uji) as b_plat_uji,SUM(b_buku) as b_buku,SUM(b_rekom) as b_rekom,SUM(b_tlt_uji) as b_tlt_uji';
            $criteria->addCondition("EXTRACT(YEAR FROM tgl_retribusi) =" . $thn);
            $criteria->addCondition("EXTRACT(MONTH FROM tgl_retribusi) =" . $bln);
            $criteria->addCondition("validasi = 'true'");
            $data = VValidasi::model()->find($criteria);

            //JBB <= 3500
            $criteria_kurang = new CDbCriteria();
            $criteria_kurang->select = 'SUM(b_jbb_kurang) as b_jbb';
            $criteria_kurang->addCondition("EXTRACT(YEAR FROM tgl_retribusi) =" . $thn);
            $criteria_kurang->addCondition("EXTRACT(MONTH FROM tgl_retribusi) =" . $bln);
            $criteria_kurang->addCondition("validasi = 'true'");
            $result_kurang = VValidasi::model()->find($criteria_kurang);

            $criteria_jbb_kurang = new CDbCriteria();
            $criteria_jbb_kurang->select = 'b_jbb_kurang';
            $criteria_jbb_kurang->addCondition("b_jbb_kurang <> 0");
            $criteria_jbb_kurang->addCondition("EXTRACT(YEAR FROM tgl_retribusi) =" . $thn);
            $criteria_jbb_kurang->addCondition("EXTRACT(MONTH FROM tgl_retribusi) =" . $bln);
            $criteria_jbb_kurang->addCondition("EXTRACT(DAY FROM tgl_retribusi) =" . date("d", strtotime($data->tgl_pad)));
            $result_jbb_kurang = VValidasi::model()->find($criteria_jbb_kurang);

            //JBB > 3500
            $criteria_lebih = new CDbCriteria();
            $criteria_lebih->select = 'SUM(b_jbb_lebih) as b_jbb';
            $criteria_lebih->addCondition("EXTRACT(YEAR FROM tgl_retribusi) =" . $thn);
            $criteria_lebih->addCondition("EXTRACT(MONTH FROM tgl_retribusi) =" . $bln);
            $criteria_lebih->addCondition("validasi = 'true'");
            $result_lebih = VValidasi::model()->find($criteria_lebih);

            $criteria_jbb_lebih = new CDbCriteria();
            $criteria_jbb_lebih->select = 'b_jbb_lebih,b_tnd_samping,b_plat_uji,b_buku';
            $criteria_jbb_lebih->addCondition("b_jbb_lebih <> 0 and b_plat_uji <> 0 and b_buku <> 0");
            $criteria_jbb_lebih->addCondition("EXTRACT(YEAR FROM tgl_retribusi) =" . $thn);
            $criteria_jbb_lebih->addCondition("EXTRACT(MONTH FROM tgl_retribusi) =" . $bln);
            $criteria_jbb_lebih->addCondition("EXTRACT(DAY FROM tgl_retribusi) =" . date("d", strtotime($data->tgl_pad)));
            $result_jbb_lebih = VValidasi::model()->find($criteria_jbb_lebih);

            $monthName = date('F', mktime(0, 0, 0, $bln, 10));
            $sheet->mergeCells("A" . $baris . ":B" . $baris);
            $sheet->setCellValue("A" . $baris, $monthName);
            $sheet->setCellValue("C" . $baris, floatval($data->b_berkala) + floatval($data->b_pertama));
            $sheet->setCellValue("D" . $baris, '=E' . $baris . '/' . $result_jbb_kurang->b_jbb_kurang);
            $sheet->setCellValue("E" . $baris, floatval($result_kurang->b_jbb));
            $sheet->setCellValue("F" . $baris, '=G' . $baris . '/' . $result_jbb_lebih->b_jbb_lebih);
            $sheet->setCellValue("G" . $baris, floatval($result_lebih->b_jbb));
            $sheet->setCellValue("H" . $baris, '=I' . $baris . '/' . $result_jbb_lebih->b_tnd_samping);
            $sheet->setCellValue("I" . $baris, floatval($data->b_tnd_samping));
            $sheet->setCellValue("J" . $baris, '=K' . $baris . '/' . $result_jbb_lebih->b_plat_uji);
            $sheet->setCellValue("K" . $baris, floatval($data->b_plat_uji));
            $sheet->setCellValue("L" . $baris, '=M' . $baris . '/' . $result_jbb_lebih->b_buku);
            $sheet->setCellValue("M" . $baris, floatval($data->b_buku));
            $sheet->setCellValue("N" . $baris, floatval($data->b_rekom));
            $sheet->setCellValue("O" . $baris, floatval($data->b_tlt_uji));
            $sheet->setCellValue("P" . $baris, '=SUM(C' . $baris . ',E' . $baris . ',G' . $baris . ',I' . $baris . ',K' . $baris . ',M' . $baris . ',N' . $baris . ',O' . $baris . ')');
            $sheet->getRowDimension($baris)->setRowHeight(20);
            $baris++;
            $no++;
        endfor;
        //END BODY
        //======================================================================
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $sheet->getRowDimension($baris)->setRowHeight(20);
        $baris_border = $baris - 1;
        $sheet->getStyle("A5:P" . $baris)->applyFromArray($styleArray);
        $sheet->getStyle("C8:C" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("E8:E" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("G8:G" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("I7:I" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("K7:K" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("M7:M" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("N7:N" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("O7:O" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("P7:P" . $baris)->getNumberFormat()->setFormatCode('#,##0');
        //======================================================================
        //FOOTER
        //TOTAL
        $sheet->setCellValue("A" . $baris, "TOTAL");
        $sheet->getStyle("A" . $baris)->getFont()->setBold(true);
        $sheet->getStyle("A" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("C" . $baris, '=SUM(C8:C' . $baris_border . ')');
        $sheet->getStyle("C" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("C" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("D" . $baris, '=SUM(D8:D' . $baris_border . ')');
        $sheet->getStyle("D" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("D" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("E" . $baris, '=SUM(E8:E' . $baris_border . ')');
        $sheet->getStyle("E" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("E" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("F" . $baris, '=SUM(F8:F' . $baris_border . ')');
        $sheet->getStyle("F" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("F" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("G" . $baris, '=SUM(G8:G' . $baris_border . ')');
        $sheet->getStyle("G" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("G" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("H" . $baris, '=SUM(H8:H' . $baris_border . ')');
        $sheet->getStyle("H" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("H" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("I" . $baris, '=SUM(I8:I' . $baris_border . ')');
        $sheet->getStyle("I" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("I" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("J" . $baris, '=SUM(J8:J' . $baris_border . ')');
        $sheet->getStyle("J" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("J" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("K" . $baris, '=SUM(K8:K' . $baris_border . ')');
        $sheet->getStyle("K" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("K" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("L" . $baris, '=SUM(L8:L' . $baris_border . ')');
        $sheet->getStyle("L" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("L" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("M" . $baris, '=SUM(M8:M' . $baris_border . ')');
        $sheet->getStyle("M" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("M" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("N" . $baris, '=SUM(N8:N' . $baris_border . ')');
        $sheet->getStyle("N" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("N" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("O" . $baris, '=SUM(O8:O' . $baris_border . ')');
        $sheet->getStyle("O" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("O" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("P" . $baris, '=SUM(P8:P' . $baris_border . ')');
        $sheet->getStyle("P" . $baris)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
        $sheet->getStyle("P" . $baris)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->getStyle("A" . $baris . ":P" . $baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        //END FOOTER
        //======================================================================
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Pendapatan [' . $thn . '].xls"');
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
}
