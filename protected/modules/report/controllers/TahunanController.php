<?php

class TahunanController extends Controller
{

    public function filters()
    {
        return array(
            'Rights', // perform access control for CRUD operations
        );
    }

    /*
     * PENDAPATAN
     */

    public function actionIndexReportPendapatan()
    {
        $this->pageTitle = 'PENDAPATAN';
        $this->render('index_report_pendapatan');
    }

    public function actionReportPendapatan($thn)
    {

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
        $sheet->getRowDimension(5)->setRowHeight(30);
        $sheet->getRowDimension(6)->setRowHeight(30);
        $sheet->getRowDimension(7)->setRowHeight(30);
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
        $dataBiaya = TblBiaya::model()->find();
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
            //JBB > 3500
            $criteria_lebih = new CDbCriteria();
            $criteria_lebih->select = 'SUM(b_jbb_lebih) as b_jbb';
            $criteria_lebih->addCondition("EXTRACT(YEAR FROM tgl_retribusi) =" . $thn);
            $criteria_lebih->addCondition("EXTRACT(MONTH FROM tgl_retribusi) =" . $bln);
            $criteria_lebih->addCondition("validasi = 'true'");
            $result_lebih = VValidasi::model()->find($criteria_lebih);

            $monthName = date('F', mktime(0, 0, 0, $bln, 10));
            $sheet->mergeCells("A" . $baris . ":B" . $baris);
            $sheet->setCellValue("A" . $baris, $monthName);
            $sheet->setCellValue("C" . $baris, floatval($data->b_berkala) + floatval($data->b_pertama));
            $sheet->setCellValue("D" . $baris, '=E' . $baris . '/' . $dataBiaya->b_jbb_kurang);
            $sheet->setCellValue("E" . $baris, floatval($result_kurang->b_jbb));
            $sheet->setCellValue("F" . $baris, '=G' . $baris . '/' . $dataBiaya->b_jbb_lebih);
            $sheet->setCellValue("G" . $baris, floatval($result_lebih->b_jbb));
            $sheet->setCellValue("H" . $baris, '=I' . $baris . '/' . $dataBiaya->b_tnd_samping);
            $sheet->setCellValue("I" . $baris, floatval($data->b_tnd_samping));
            $sheet->setCellValue("J" . $baris, '=K' . $baris . '/' . $dataBiaya->b_plat_uji);
            $sheet->setCellValue("K" . $baris, floatval($data->b_plat_uji));
            $sheet->setCellValue("L" . $baris, '=M' . $baris . '/' . $dataBiaya->b_buku);
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

    /*
     * KELULUSAN KENDARAAN UJI
     */

    public function actionIndexReportKelulusan()
    {
        $this->pageTitle = 'Report Kelulusan Uji';
        $this->render('index_report_kelulusan');
    }

    public function actionReportKelulusan($thn)
    {
        Yii::import("ext.PHPExcel", TRUE);
        $xls = new PHPExcel();

        //======================================================================
        $styleCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $styleVerticalCenter = array(
            'alignment' => array(
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
        //======================================================================
        /*
         * HEADER LULUS DAN TIDAK LULUS
         */
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('LULUS & TIDAK LULUS');
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(false);
        $sheet->getPageSetup()->setHorizontalCentered(true);
        $sheet->getPageSetup()->setScale(82);
        //=============================================
        $sheet->getColumnDimension('A')->setWidth(11.56);
        $sheet->getColumnDimension('O')->setWidth(11.56);
        $sheet->mergeCells("A1:AA1");
        $sheet->mergeCells("A2:AA2");
        $sheet->mergeCells("A3:AA3");
        $sheet->mergeCells("A4:AA4");

        $sheet->setCellValue("A1", "JUMLAH KENDARAAN LULUS & TIDAK LULUS");
        $sheet->setCellValue("A2", "TAHUN " . $thn);
        $sheet->setCellValue("A3", "UPTD PENGUJIAN KENDARAAN BERMOTOR SURABAYA");
        $sheet->setCellValue("A4", "DINAS PERHUBUNGAN KOTA SURABAYA");

        $sheet->getStyle("A1")->applyFromArray($styleCenter);
        $sheet->getStyle("A2")->applyFromArray($styleCenter);
        $sheet->getStyle("A3")->applyFromArray($styleCenter);
        $sheet->getStyle("A4")->applyFromArray($styleCenter);
        /*
         * BODY HEADER LULUS
         */
        $sheet->mergeCells("B6:J6");
        $sheet->mergeCells("A6:A8");
        $sheet->mergeCells("B7:D7");
        $sheet->mergeCells("E7:G7");
        $sheet->mergeCells("H7:J7");
        $sheet->mergeCells("K6:M7");
        $sheet->setCellValue("B6", "LULUS");
        $sheet->setCellValue("A6", "Bulan");
        $sheet->setCellValue("B7", "Mobil Barang");
        $sheet->setCellValue("B8", "Umum");
        $sheet->setCellValue("C8", "BU");
        $sheet->setCellValue("D8", "Total");
        $sheet->setCellValue("E7", "Mobil Penumpang");
        $sheet->setCellValue("E8", "Umum");
        $sheet->setCellValue("F8", "BU");
        $sheet->setCellValue("G8", "Total");
        $sheet->setCellValue("H7", "Mobil Bus");
        $sheet->setCellValue("H8", "Umum");
        $sheet->setCellValue("I8", "BU");
        $sheet->setCellValue("J8", "Total");
        $sheet->setCellValue("K6", "TOTAL KESELURUHAN");
        $sheet->setCellValue("K8", "Umum");
        $sheet->setCellValue("L8", "BU");
        $sheet->setCellValue("M8", "Total");
        $sheet->getStyle("A6:M8")->applyFromArray($styleCenter);
        $sheet->getStyle('A6:M8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        /*
         * BODY LULUS
         */
        $baris = 9;
        $baris_awal = $baris;
        $baris_akhir = $baris_awal + 11;

        for ($bln = 1; $bln <= 12; $bln++) :
            $dataKendaraan = VLapKendaraanBaru::model()->findByAttributes(array('bulan' => $bln, 'tahun' => $thn));

            $sheet->setCellValue("A" . $baris, Yii::app()->params['bulanArrayInd'][$bln - 1]);
            $sheet->setCellValue("B" . $baris, $dataKendaraan['lls_mbrg_umum']);
            $sheet->setCellValue("C" . $baris, '=D' . $baris . '-B' . $baris);
            $sheet->setCellValue("D" . $baris, $dataKendaraan['lls_mbrg']);
            $sheet->setCellValue("E" . $baris, $dataKendaraan['lls_mpnp_umum']);
            $sheet->setCellValue("F" . $baris, '=G' . $baris . '-E' . $baris);
            $sheet->setCellValue("G" . $baris, $dataKendaraan['lls_mpnp']);
            $sheet->setCellValue("H" . $baris, $dataKendaraan['lls_mbus_umum']);
            $sheet->setCellValue("I" . $baris, '=J' . $baris . '-H' . $baris);
            $sheet->setCellValue("J" . $baris, $dataKendaraan['lls_mbus']);
            $sheet->setCellValue("K" . $baris, '=SUM(B' . $baris . ',E' . $baris . ',H' . $baris . ')');
            $sheet->setCellValue("L" . $baris, '=SUM(C' . $baris . ',F' . $baris . ',I' . $baris . ')');
            $sheet->setCellValue("M" . $baris, '=SUM(K' . $baris . ':L' . $baris . ')');
            $baris++;
        endfor;

        $sheet->setCellValue("A" . $baris, "TOTAL");
        $sheet->setCellValue("B" . $baris, "=SUM(B" . $baris_awal . ":B" . $baris_akhir . ")");
        $sheet->setCellValue("C" . $baris, "=SUM(C" . $baris_awal . ":C" . $baris_akhir . ")");
        $sheet->setCellValue("D" . $baris, "=SUM(D" . $baris_awal . ":D" . $baris_akhir . ")");
        $sheet->setCellValue("E" . $baris, "=SUM(E" . $baris_awal . ":E" . $baris_akhir . ")");
        $sheet->setCellValue("F" . $baris, "=SUM(F" . $baris_awal . ":F" . $baris_akhir . ")");
        $sheet->setCellValue("G" . $baris, "=SUM(G" . $baris_awal . ":G" . $baris_akhir . ")");
        $sheet->setCellValue("H" . $baris, "=SUM(H" . $baris_awal . ":H" . $baris_akhir . ")");
        $sheet->setCellValue("I" . $baris, "=SUM(I" . $baris_awal . ":I" . $baris_akhir . ")");
        $sheet->setCellValue("J" . $baris, "=SUM(J" . $baris_awal . ":J" . $baris_akhir . ")");
        $sheet->setCellValue("K" . $baris, "=SUM(K" . $baris_awal . ":K" . $baris_akhir . ")");
        $sheet->setCellValue("L" . $baris, "=SUM(L" . $baris_awal . ":L" . $baris_akhir . ")");
        $sheet->setCellValue("M" . $baris, "=SUM(M" . $baris_awal . ":M" . $baris_akhir . ")");
        $sheet->getStyle('A' . $baris . ':M' . $baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        $sheet->getStyle("A6:M" . $baris)->applyFromArray($styleBorder);
        //======================================================================
        /*
         * BODY HEADER TIDAK LULUS
         */
        $sheet->mergeCells("P6:X6");
        $sheet->mergeCells("O6:O8");
        $sheet->mergeCells("P7:R7");
        $sheet->mergeCells("S7:U7");
        $sheet->mergeCells("V7:X7");
        $sheet->mergeCells("Y6:AA7");
        $sheet->setCellValue("P6", "TIDAK LULUS");
        $sheet->setCellValue("O6", "Bulan");
        $sheet->setCellValue("P7", "Mobil Barang");
        $sheet->setCellValue("P8", "Umum");
        $sheet->setCellValue("Q8", "BU");
        $sheet->setCellValue("R8", "Total");
        $sheet->setCellValue("S7", "Mobil Penumpang");
        $sheet->setCellValue("S8", "Umum");
        $sheet->setCellValue("T8", "BU");
        $sheet->setCellValue("U8", "Total");
        $sheet->setCellValue("V7", "Mobil Bus");
        $sheet->setCellValue("V8", "Umum");
        $sheet->setCellValue("W8", "BU");
        $sheet->setCellValue("X8", "Total");
        $sheet->setCellValue("Y6", "TOTAL KESELURUHAN");
        $sheet->setCellValue("Y8", "Umum");
        $sheet->setCellValue("Z8", "BU");
        $sheet->setCellValue("AA8", "Total");
        $sheet->getStyle("O6:AA8")->applyFromArray($styleCenter);
        $sheet->getStyle('O6:AA8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        /*
         * BODY TIDAK LULUS
         */
        $baris = 9;
        $baris_awal = $baris;
        $baris_akhir = $baris_awal + 11;

        for ($bln = 1; $bln <= 12; $bln++) :
            $dataKendaraan = VLapKendaraanBaru::model()->findByAttributes(array('bulan' => $bln, 'tahun' => $thn));

            $sheet->setCellValue("O" . $baris, Yii::app()->params['bulanArrayInd'][$bln - 1]);
            $sheet->setCellValue("P" . $baris, $dataKendaraan['tl_mbrg_umum']);
            $sheet->setCellValue("Q" . $baris, '=R' . $baris . '-P' . $baris);
            $sheet->setCellValue("R" . $baris, $dataKendaraan['tl_mbrg']);
            $sheet->setCellValue("S" . $baris, $dataKendaraan['tl_mpnp_umum']);
            $sheet->setCellValue("T" . $baris, '=U' . $baris . '-S' . $baris);
            $sheet->setCellValue("U" . $baris, $dataKendaraan['tl_mpnp']);
            $sheet->setCellValue("V" . $baris, $dataKendaraan['tl_mbus_umum']);
            $sheet->setCellValue("W" . $baris, '=X' . $baris . '-V' . $baris);
            $sheet->setCellValue("X" . $baris, $dataKendaraan['tl_mbus']);
            $sheet->setCellValue("Y" . $baris, '=SUM(P' . $baris . ',S' . $baris . ',V' . $baris . ')');
            $sheet->setCellValue("Z" . $baris, '=SUM(Q' . $baris . ',T' . $baris . ',W' . $baris . ')');
            $sheet->setCellValue("AA" . $baris, '=SUM(Y' . $baris . ':Z' . $baris . ')');
            $baris++;
        endfor;

        $sheet->setCellValue("O" . $baris, "TOTAL");
        $sheet->setCellValue("P" . $baris, "=SUM(P" . $baris_awal . ":P" . $baris_akhir . ")");
        $sheet->setCellValue("Q" . $baris, "=SUM(Q" . $baris_awal . ":Q" . $baris_akhir . ")");
        $sheet->setCellValue("R" . $baris, "=SUM(R" . $baris_awal . ":R" . $baris_akhir . ")");
        $sheet->setCellValue("S" . $baris, "=SUM(S" . $baris_awal . ":S" . $baris_akhir . ")");
        $sheet->setCellValue("T" . $baris, "=SUM(T" . $baris_awal . ":T" . $baris_akhir . ")");
        $sheet->setCellValue("U" . $baris, "=SUM(U" . $baris_awal . ":U" . $baris_akhir . ")");
        $sheet->setCellValue("V" . $baris, "=SUM(V" . $baris_awal . ":V" . $baris_akhir . ")");
        $sheet->setCellValue("W" . $baris, "=SUM(W" . $baris_awal . ":W" . $baris_akhir . ")");
        $sheet->setCellValue("X" . $baris, "=SUM(X" . $baris_awal . ":X" . $baris_akhir . ")");
        $sheet->setCellValue("Y" . $baris, "=SUM(Y" . $baris_awal . ":Y" . $baris_akhir . ")");
        $sheet->setCellValue("Z" . $baris, "=SUM(Z" . $baris_awal . ":Z" . $baris_akhir . ")");
        $sheet->setCellValue("AA" . $baris, "=SUM(AA" . $baris_awal . ":AA" . $baris_akhir . ")");
        $sheet->getStyle('O' . $baris . ':AA' . $baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        $sheet->getStyle("O6:AA" . $baris)->applyFromArray($styleBorder);
        //======================================================================
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="report_kelulusan_' . $thn . '.xls"');
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

    /*
     * PENGUJIAN KENDARAAN 
     */

    public function actionIndexReportUjiKendaraan()
    {
        $this->pageTitle = 'Report Uji Kendaraan';
        $this->render('index_report_uji_kendaraan');
    }

    public function actionReportUjiKendaraan($thn)
    {
        Yii::import("ext.PHPExcel", TRUE);
        $xls = new PHPExcel();

        //======================================================================
        $styleCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $styleVerticalCenter = array(
            'alignment' => array(
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
        //======================================================================
        /*
         * HEADER UJI PERTAMA DAN BERKALA
         */
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('UJI PERTAMA & BERKALA');
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(false);
        $sheet->getPageSetup()->setHorizontalCentered(true);
        //        $sheet->getPageSetup()->setVerticalCentered(true);
        $sheet->getPageSetup()->setScale(82);
        //=============================================
        $sheet->getColumnDimension('A')->setWidth(11.56);
        $sheet->getColumnDimension('O')->setWidth(11.56);
        $sheet->mergeCells("A1:AA1");
        $sheet->mergeCells("A2:AA2");
        $sheet->mergeCells("A3:AA3");
        $sheet->mergeCells("A4:AA4");

        $sheet->setCellValue("A1", "JUMLAH KENDARAAN YANG MELAKUKAN PENDAFTARAN UJI");
        $sheet->setCellValue("A2", "TAHUN " . $thn);
        $sheet->setCellValue("A3", "UPTD PENGUJIAN KENDARAAN BERMOTOR SURABAYA");
        $sheet->setCellValue("A4", "DINAS PERHUBUNGAN KOTA SURABAYA");

        $sheet->getStyle("A1")->applyFromArray($styleCenter);
        $sheet->getStyle("A2")->applyFromArray($styleCenter);
        $sheet->getStyle("A3")->applyFromArray($styleCenter);
        $sheet->getStyle("A4")->applyFromArray($styleCenter);
        /*
         * BODY HEADER UJI PERTAMA
         */
        $sheet->mergeCells("B6:J6");
        $sheet->mergeCells("A6:A8");
        $sheet->mergeCells("B7:D7");
        $sheet->mergeCells("E7:G7");
        $sheet->mergeCells("H7:J7");
        $sheet->mergeCells("K6:M7");
        $sheet->setCellValue("B6", "UJI PERTAMA");
        $sheet->setCellValue("A6", "Bulan");
        $sheet->setCellValue("B7", "Mobil Barang");
        $sheet->setCellValue("B8", "Umum");
        $sheet->setCellValue("C8", "BU");
        $sheet->setCellValue("D8", "Total");
        $sheet->setCellValue("E7", "Mobil Penumpang");
        $sheet->setCellValue("E8", "Umum");
        $sheet->setCellValue("F8", "BU");
        $sheet->setCellValue("G8", "Total");
        $sheet->setCellValue("H7", "Mobil Bus");
        $sheet->setCellValue("H8", "Umum");
        $sheet->setCellValue("I8", "BU");
        $sheet->setCellValue("J8", "Total");
        $sheet->setCellValue("K6", "TOTAL KESELURUHAN");
        $sheet->setCellValue("K8", "Umum");
        $sheet->setCellValue("L8", "BU");
        $sheet->setCellValue("M8", "Total");
        $sheet->getStyle("A6:M8")->applyFromArray($styleCenter);
        $sheet->getStyle('A6:M8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        /*
         * BODY UJI PERTAMA
         */
        $baris = 9;
        $baris_awal = $baris;
        $baris_akhir = $baris_awal + 11;

        for ($bln = 1; $bln <= 12; $bln++) :
            $dataKendaraan = VLapKendaraanBaru::model()->findByAttributes(array('bulan' => $bln, 'tahun' => $thn));

            $sheet->setCellValue("A" . $baris, Yii::app()->params['bulanArrayInd'][$bln - 1]);
            $sheet->setCellValue("B" . $baris, $dataKendaraan['ujibaru_mbrg_umum']);
            $sheet->setCellValue("C" . $baris, '=D' . $baris . '-B' . $baris);
            $sheet->setCellValue("D" . $baris, $dataKendaraan['ujibaru_mbrg']);
            $sheet->setCellValue("E" . $baris, $dataKendaraan['ujibaru_mpnp_umum']);
            $sheet->setCellValue("F" . $baris, '=G' . $baris . '-E' . $baris);
            $sheet->setCellValue("G" . $baris, $dataKendaraan['ujibaru_mpnp']);
            $sheet->setCellValue("H" . $baris, $dataKendaraan['ujibaru_mbbus_umum']);
            $sheet->setCellValue("I" . $baris, '=J' . $baris . '-H' . $baris);
            $sheet->setCellValue("J" . $baris, $dataKendaraan['ujibaru_mbus']);
            $sheet->setCellValue("K" . $baris, '=SUM(B' . $baris . ',E' . $baris . ',H' . $baris . ')');
            $sheet->setCellValue("L" . $baris, '=SUM(C' . $baris . ',F' . $baris . ',I' . $baris . ')');
            $sheet->setCellValue("M" . $baris, '=SUM(K' . $baris . ':L' . $baris . ')');
            $baris++;
        endfor;

        $sheet->setCellValue("A" . $baris, "TOTAL");
        $sheet->setCellValue("B" . $baris, "=SUM(B" . $baris_awal . ":B" . $baris_akhir . ")");
        $sheet->setCellValue("C" . $baris, "=SUM(C" . $baris_awal . ":C" . $baris_akhir . ")");
        $sheet->setCellValue("D" . $baris, "=SUM(D" . $baris_awal . ":D" . $baris_akhir . ")");
        $sheet->setCellValue("E" . $baris, "=SUM(E" . $baris_awal . ":E" . $baris_akhir . ")");
        $sheet->setCellValue("F" . $baris, "=SUM(F" . $baris_awal . ":F" . $baris_akhir . ")");
        $sheet->setCellValue("G" . $baris, "=SUM(G" . $baris_awal . ":G" . $baris_akhir . ")");
        $sheet->setCellValue("H" . $baris, "=SUM(H" . $baris_awal . ":H" . $baris_akhir . ")");
        $sheet->setCellValue("I" . $baris, "=SUM(I" . $baris_awal . ":I" . $baris_akhir . ")");
        $sheet->setCellValue("J" . $baris, "=SUM(J" . $baris_awal . ":J" . $baris_akhir . ")");
        $sheet->setCellValue("K" . $baris, "=SUM(K" . $baris_awal . ":K" . $baris_akhir . ")");
        $sheet->setCellValue("L" . $baris, "=SUM(L" . $baris_awal . ":L" . $baris_akhir . ")");
        $sheet->setCellValue("M" . $baris, "=SUM(M" . $baris_awal . ":M" . $baris_akhir . ")");
        $sheet->getStyle('A' . $baris . ':M' . $baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        $sheet->getStyle("A6:M" . $baris)->applyFromArray($styleBorder);
        //======================================================================
        /*
         * BODY HEADER UJI BERKALA
         */
        $sheet->mergeCells("P6:X6");
        $sheet->mergeCells("O6:O8");
        $sheet->mergeCells("P7:R7");
        $sheet->mergeCells("S7:U7");
        $sheet->mergeCells("V7:X7");
        $sheet->mergeCells("Y6:AA7");
        $sheet->setCellValue("P6", "UJI BERKALA");
        $sheet->setCellValue("O6", "Bulan");
        $sheet->setCellValue("P7", "Mobil Barang");
        $sheet->setCellValue("P8", "Umum");
        $sheet->setCellValue("Q8", "BU");
        $sheet->setCellValue("R8", "Total");
        $sheet->setCellValue("S7", "Mobil Penumpang");
        $sheet->setCellValue("S8", "Umum");
        $sheet->setCellValue("T8", "BU");
        $sheet->setCellValue("U8", "Total");
        $sheet->setCellValue("V7", "Mobil Bus");
        $sheet->setCellValue("V8", "Umum");
        $sheet->setCellValue("W8", "BU");
        $sheet->setCellValue("X8", "Total");
        $sheet->setCellValue("Y6", "TOTAL KESELURUHAN");
        $sheet->setCellValue("Y8", "Umum");
        $sheet->setCellValue("Z8", "BU");
        $sheet->setCellValue("AA8", "Total");
        $sheet->getStyle("O6:AA8")->applyFromArray($styleCenter);
        $sheet->getStyle('O6:AA8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        /*
         * BODY UJI BERKALA
         */
        $baris = 9;
        $baris_awal = $baris;
        $baris_akhir = $baris_awal + 11;

        for ($bln = 1; $bln <= 12; $bln++) :
            $dataKendaraan = VLapKendaraanBaru::model()->findByAttributes(array('bulan' => $bln, 'tahun' => $thn));

            $sheet->setCellValue("O" . $baris, Yii::app()->params['bulanArrayInd'][$bln - 1]);
            $sheet->setCellValue("P" . $baris, $dataKendaraan['brkl_mbrg_umum']);
            $sheet->setCellValue("Q" . $baris, '=R' . $baris . '-P' . $baris);
            $sheet->setCellValue("R" . $baris, $dataKendaraan['brkl_mbrg']);
            $sheet->setCellValue("S" . $baris, $dataKendaraan['brkl_mpnp_umum']);
            $sheet->setCellValue("T" . $baris, '=U' . $baris . '-S' . $baris);
            $sheet->setCellValue("U" . $baris, $dataKendaraan['brkl_mpnp']);
            $sheet->setCellValue("V" . $baris, $dataKendaraan['brkl_mbus_umum']);
            $sheet->setCellValue("W" . $baris, '=X' . $baris . '-V' . $baris);
            $sheet->setCellValue("X" . $baris, $dataKendaraan['brkl_mbus']);
            $sheet->setCellValue("Y" . $baris, '=SUM(P' . $baris . ',S' . $baris . ',V' . $baris . ')');
            $sheet->setCellValue("Z" . $baris, '=SUM(Q' . $baris . ',T' . $baris . ',W' . $baris . ')');
            $sheet->setCellValue("AA" . $baris, '=SUM(Y' . $baris . ':Z' . $baris . ')');
            $baris++;
        endfor;

        $sheet->setCellValue("O" . $baris, "TOTAL");
        $sheet->setCellValue("P" . $baris, "=SUM(P" . $baris_awal . ":P" . $baris_akhir . ")");
        $sheet->setCellValue("Q" . $baris, "=SUM(Q" . $baris_awal . ":Q" . $baris_akhir . ")");
        $sheet->setCellValue("R" . $baris, "=SUM(R" . $baris_awal . ":R" . $baris_akhir . ")");
        $sheet->setCellValue("S" . $baris, "=SUM(S" . $baris_awal . ":S" . $baris_akhir . ")");
        $sheet->setCellValue("T" . $baris, "=SUM(T" . $baris_awal . ":T" . $baris_akhir . ")");
        $sheet->setCellValue("U" . $baris, "=SUM(U" . $baris_awal . ":U" . $baris_akhir . ")");
        $sheet->setCellValue("V" . $baris, "=SUM(V" . $baris_awal . ":V" . $baris_akhir . ")");
        $sheet->setCellValue("W" . $baris, "=SUM(W" . $baris_awal . ":W" . $baris_akhir . ")");
        $sheet->setCellValue("X" . $baris, "=SUM(X" . $baris_awal . ":X" . $baris_akhir . ")");
        $sheet->setCellValue("Y" . $baris, "=SUM(Y" . $baris_awal . ":Y" . $baris_akhir . ")");
        $sheet->setCellValue("Z" . $baris, "=SUM(Z" . $baris_awal . ":Z" . $baris_akhir . ")");
        $sheet->setCellValue("AA" . $baris, "=SUM(AA" . $baris_awal . ":AA" . $baris_akhir . ")");
        $sheet->getStyle('O' . $baris . ':AA' . $baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        $sheet->getStyle("O6:AA" . $baris)->applyFromArray($styleBorder);
        //======================================================================
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="report_pengujian_' . $thn . '.xls"');
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

    /*
     * MUTASI
     */

    public function actionIndexReportMutasi()
    {
        $this->pageTitle = 'Report Mutasi';
        $this->render('index_report_mutasi');
    }

    public function actionReportMutasi($thn)
    {
        Yii::import("ext.PHPExcel", TRUE);
        $xls = new PHPExcel();

        //======================================================================
        $styleCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $styleVerticalCenter = array(
            'alignment' => array(
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
        //======================================================================
        /*
         * HEADER MUTASI MASUK DAN MUTASI KELUAR
         */
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('MUTASI MASUK & KELUAR');
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(false);
        $sheet->getPageSetup()->setHorizontalCentered(true);
        $sheet->getPageSetup()->setScale(82);
        //=============================================
        $sheet->getColumnDimension('A')->setWidth(11.56);
        $sheet->getColumnDimension('O')->setWidth(11.56);
        $sheet->mergeCells("A1:AA1");
        $sheet->mergeCells("A2:AA2");
        $sheet->mergeCells("A3:AA3");
        $sheet->mergeCells("A4:AA4");

        $sheet->setCellValue("A1", "JUMLAH KENDARAAN MUTASI MASUK DAN KELUAR");
        $sheet->setCellValue("A2", "TAHUN " . $thn);
        $sheet->setCellValue("A3", "UPTD PENGUJIAN KENDARAAN BERMOTOR SURABAYA");
        $sheet->setCellValue("A4", "DINAS PERHUBUNGAN KOTA SURABAYA");

        $sheet->getStyle("A1")->applyFromArray($styleCenter);
        $sheet->getStyle("A2")->applyFromArray($styleCenter);
        $sheet->getStyle("A3")->applyFromArray($styleCenter);
        $sheet->getStyle("A4")->applyFromArray($styleCenter);
        /*
         * BODY HEADER MUTASI MASUK
         */
        $sheet->mergeCells("B6:J6");
        $sheet->mergeCells("A6:A8");
        $sheet->mergeCells("B7:D7");
        $sheet->mergeCells("E7:G7");
        $sheet->mergeCells("H7:J7");
        $sheet->mergeCells("K6:M7");
        $sheet->setCellValue("B6", "MUTASI MASUK");
        $sheet->setCellValue("A6", "Bulan");
        $sheet->setCellValue("B7", "Mobil Barang");
        $sheet->setCellValue("B8", "Umum");
        $sheet->setCellValue("C8", "BU");
        $sheet->setCellValue("D8", "Total");
        $sheet->setCellValue("E7", "Mobil Penumpang");
        $sheet->setCellValue("E8", "Umum");
        $sheet->setCellValue("F8", "BU");
        $sheet->setCellValue("G8", "Total");
        $sheet->setCellValue("H7", "Mobil Bus");
        $sheet->setCellValue("H8", "Umum");
        $sheet->setCellValue("I8", "BU");
        $sheet->setCellValue("J8", "Total");
        $sheet->setCellValue("K6", "TOTAL KESELURUHAN");
        $sheet->setCellValue("K8", "Umum");
        $sheet->setCellValue("L8", "BU");
        $sheet->setCellValue("M8", "Total");
        $sheet->getStyle("A6:M8")->applyFromArray($styleCenter);
        $sheet->getStyle('A6:M8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        /*
         * BODY MUTASI MASUK
         */
        $baris = 9;
        $baris_awal = $baris;
        $baris_akhir = $baris_awal + 11;

        for ($bln = 1; $bln <= 12; $bln++) :
            $dataKendaraan = VLapKendaraanBaru::model()->findByAttributes(array('bulan' => $bln, 'tahun' => $thn));

            $sheet->setCellValue("A" . $baris, Yii::app()->params['bulanArrayInd'][$bln - 1]);
            $sheet->setCellValue("B" . $baris, $dataKendaraan['mts_msk_mbrg_umum']);
            $sheet->setCellValue("C" . $baris, '=D' . $baris . '-B' . $baris);
            $sheet->setCellValue("D" . $baris, $dataKendaraan['mts_msk_mbrg']);
            $sheet->setCellValue("E" . $baris, $dataKendaraan['mts_msk_mpnp_umum']);
            $sheet->setCellValue("F" . $baris, '=G' . $baris . '-E' . $baris);
            $sheet->setCellValue("G" . $baris, $dataKendaraan['mts_msk_mpnp']);
            $sheet->setCellValue("H" . $baris, $dataKendaraan['mts_msk_mbus_umum']);
            $sheet->setCellValue("I" . $baris, '=J' . $baris . '-H' . $baris);
            $sheet->setCellValue("J" . $baris, $dataKendaraan['mts_msk_mbus']);
            $sheet->setCellValue("K" . $baris, '=SUM(B' . $baris . ',E' . $baris . ',H' . $baris . ')');
            $sheet->setCellValue("L" . $baris, '=SUM(C' . $baris . ',F' . $baris . ',I' . $baris . ')');
            $sheet->setCellValue("M" . $baris, '=SUM(K' . $baris . ':L' . $baris . ')');
            $baris++;
        endfor;

        $sheet->setCellValue("A" . $baris, "TOTAL");
        $sheet->setCellValue("B" . $baris, "=SUM(B" . $baris_awal . ":B" . $baris_akhir . ")");
        $sheet->setCellValue("C" . $baris, "=SUM(C" . $baris_awal . ":C" . $baris_akhir . ")");
        $sheet->setCellValue("D" . $baris, "=SUM(D" . $baris_awal . ":D" . $baris_akhir . ")");
        $sheet->setCellValue("E" . $baris, "=SUM(E" . $baris_awal . ":E" . $baris_akhir . ")");
        $sheet->setCellValue("F" . $baris, "=SUM(F" . $baris_awal . ":F" . $baris_akhir . ")");
        $sheet->setCellValue("G" . $baris, "=SUM(G" . $baris_awal . ":G" . $baris_akhir . ")");
        $sheet->setCellValue("H" . $baris, "=SUM(H" . $baris_awal . ":H" . $baris_akhir . ")");
        $sheet->setCellValue("I" . $baris, "=SUM(I" . $baris_awal . ":I" . $baris_akhir . ")");
        $sheet->setCellValue("J" . $baris, "=SUM(J" . $baris_awal . ":J" . $baris_akhir . ")");
        $sheet->setCellValue("K" . $baris, "=SUM(K" . $baris_awal . ":K" . $baris_akhir . ")");
        $sheet->setCellValue("L" . $baris, "=SUM(L" . $baris_awal . ":L" . $baris_akhir . ")");
        $sheet->setCellValue("M" . $baris, "=SUM(M" . $baris_awal . ":M" . $baris_akhir . ")");
        $sheet->getStyle('A' . $baris . ':M' . $baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        $sheet->getStyle("A6:M" . $baris)->applyFromArray($styleBorder);
        //======================================================================
        /*
         * BODY HEADER MUTASI KELUAR
         */
        $sheet->mergeCells("P6:X6");
        $sheet->mergeCells("O6:O8");
        $sheet->mergeCells("P7:R7");
        $sheet->mergeCells("S7:U7");
        $sheet->mergeCells("V7:X7");
        $sheet->mergeCells("Y6:AA7");
        $sheet->setCellValue("P6", "MUTASI KELUAR");
        $sheet->setCellValue("O6", "Bulan");
        $sheet->setCellValue("P7", "Mobil Barang");
        $sheet->setCellValue("P8", "Umum");
        $sheet->setCellValue("Q8", "BU");
        $sheet->setCellValue("R8", "Total");
        $sheet->setCellValue("S7", "Mobil Penumpang");
        $sheet->setCellValue("S8", "Umum");
        $sheet->setCellValue("T8", "BU");
        $sheet->setCellValue("U8", "Total");
        $sheet->setCellValue("V7", "Mobil Bus");
        $sheet->setCellValue("V8", "Umum");
        $sheet->setCellValue("W8", "BU");
        $sheet->setCellValue("X8", "Total");
        $sheet->setCellValue("Y6", "TOTAL KESELURUHAN");
        $sheet->setCellValue("Y8", "Umum");
        $sheet->setCellValue("Z8", "BU");
        $sheet->setCellValue("AA8", "Total");
        $sheet->getStyle("O6:AA8")->applyFromArray($styleCenter);
        $sheet->getStyle('O6:AA8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        /*
         * BODY MUTASI KELUAR
         */
        $baris = 9;
        $baris_awal = $baris;
        $baris_akhir = $baris_awal + 11;

        for ($bln = 1; $bln <= 12; $bln++) :
            $dataKendaraan = VLapKendaraanBaru::model()->findByAttributes(array('bulan' => $bln, 'tahun' => $thn));

            $sheet->setCellValue("O" . $baris, Yii::app()->params['bulanArrayInd'][$bln - 1]);
            $sheet->setCellValue("P" . $baris, $dataKendaraan['mts_klr_mbrg_umum']);
            $sheet->setCellValue("Q" . $baris, '=R' . $baris . '-P' . $baris);
            $sheet->setCellValue("R" . $baris, $dataKendaraan['mts_klr_mbrg']);
            $sheet->setCellValue("S" . $baris, $dataKendaraan['mts_klr_mpnp_umum']);
            $sheet->setCellValue("T" . $baris, '=U' . $baris . '-S' . $baris);
            $sheet->setCellValue("U" . $baris, $dataKendaraan['mts_klr_mpnp']);
            $sheet->setCellValue("V" . $baris, $dataKendaraan['mts_klr_mbus_umum']);
            $sheet->setCellValue("W" . $baris, '=X' . $baris . '-V' . $baris);
            $sheet->setCellValue("X" . $baris, $dataKendaraan['mts_klr_mbus']);
            $sheet->setCellValue("Y" . $baris, '=SUM(P' . $baris . ',S' . $baris . ',V' . $baris . ')');
            $sheet->setCellValue("Z" . $baris, '=SUM(Q' . $baris . ',T' . $baris . ',W' . $baris . ')');
            $sheet->setCellValue("AA" . $baris, '=SUM(Y' . $baris . ':Z' . $baris . ')');
            $baris++;
        endfor;

        $sheet->setCellValue("O" . $baris, "TOTAL");
        $sheet->setCellValue("P" . $baris, "=SUM(P" . $baris_awal . ":P" . $baris_akhir . ")");
        $sheet->setCellValue("Q" . $baris, "=SUM(Q" . $baris_awal . ":Q" . $baris_akhir . ")");
        $sheet->setCellValue("R" . $baris, "=SUM(R" . $baris_awal . ":R" . $baris_akhir . ")");
        $sheet->setCellValue("S" . $baris, "=SUM(S" . $baris_awal . ":S" . $baris_akhir . ")");
        $sheet->setCellValue("T" . $baris, "=SUM(T" . $baris_awal . ":T" . $baris_akhir . ")");
        $sheet->setCellValue("U" . $baris, "=SUM(U" . $baris_awal . ":U" . $baris_akhir . ")");
        $sheet->setCellValue("V" . $baris, "=SUM(V" . $baris_awal . ":V" . $baris_akhir . ")");
        $sheet->setCellValue("W" . $baris, "=SUM(W" . $baris_awal . ":W" . $baris_akhir . ")");
        $sheet->setCellValue("X" . $baris, "=SUM(X" . $baris_awal . ":X" . $baris_akhir . ")");
        $sheet->setCellValue("Y" . $baris, "=SUM(Y" . $baris_awal . ":Y" . $baris_akhir . ")");
        $sheet->setCellValue("Z" . $baris, "=SUM(Z" . $baris_awal . ":Z" . $baris_akhir . ")");
        $sheet->setCellValue("AA" . $baris, "=SUM(AA" . $baris_awal . ":AA" . $baris_akhir . ")");
        $sheet->getStyle('O' . $baris . ':AA' . $baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        $sheet->getStyle("O6:AA" . $baris)->applyFromArray($styleBorder);
        //======================================================================
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="report_mutasi_' . $thn . '.xls"');
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

    /*
     * NUMPANG UJI
     */

    public function actionIndexReportNumpangUji()
    {
        $this->pageTitle = 'Report Numpang Uji';
        $this->render('index_report_numpang_uji');
    }

    public function actionReportNumpangUji($thn)
    {
        Yii::import("ext.PHPExcel", TRUE);
        $xls = new PHPExcel();

        //======================================================================
        $styleCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $styleVerticalCenter = array(
            'alignment' => array(
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
        //======================================================================
        /*
         * HEADER NUMPANG UJI MASUK DAN NUMPANG KELUAR
         */
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('NUMPANG UJI');
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(false);
        $sheet->getPageSetup()->setHorizontalCentered(true);
        $sheet->getPageSetup()->setScale(82);
        //=============================================
        $sheet->getColumnDimension('A')->setWidth(11.56);
        $sheet->getColumnDimension('O')->setWidth(11.56);
        $sheet->mergeCells("A1:AA1");
        $sheet->mergeCells("A2:AA2");
        $sheet->mergeCells("A3:AA3");
        $sheet->mergeCells("A4:AA4");

        $sheet->setCellValue("A1", "JUMLAH KENDARAAN NUMPANG UJI MASUK DAN NUMPANG UJI KELUAR");
        $sheet->setCellValue("A2", "TAHUN " . $thn);
        $sheet->setCellValue("A3", "UPTD PENGUJIAN KENDARAAN BERMOTOR SURABAYA");
        $sheet->setCellValue("A4", "DINAS PERHUBUNGAN KOTA SURABAYA");

        $sheet->getStyle("A1")->applyFromArray($styleCenter);
        $sheet->getStyle("A2")->applyFromArray($styleCenter);
        $sheet->getStyle("A3")->applyFromArray($styleCenter);
        $sheet->getStyle("A4")->applyFromArray($styleCenter);
        /*
         * BODY HEADER NUMPANG UJI MASUK
         */
        $sheet->mergeCells("B6:J6");
        $sheet->mergeCells("A6:A8");
        $sheet->mergeCells("B7:D7");
        $sheet->mergeCells("E7:G7");
        $sheet->mergeCells("H7:J7");
        $sheet->mergeCells("K6:M7");
        $sheet->setCellValue("B6", "NUMPANG UJI MASUK");
        $sheet->setCellValue("A6", "Bulan");
        $sheet->setCellValue("B7", "Mobil Barang");
        $sheet->setCellValue("B8", "Umum");
        $sheet->setCellValue("C8", "BU");
        $sheet->setCellValue("D8", "Total");
        $sheet->setCellValue("E7", "Mobil Penumpang");
        $sheet->setCellValue("E8", "Umum");
        $sheet->setCellValue("F8", "BU");
        $sheet->setCellValue("G8", "Total");
        $sheet->setCellValue("H7", "Mobil Bus");
        $sheet->setCellValue("H8", "Umum");
        $sheet->setCellValue("I8", "BU");
        $sheet->setCellValue("J8", "Total");
        $sheet->setCellValue("K6", "TOTAL KESELURUHAN");
        $sheet->setCellValue("K8", "Umum");
        $sheet->setCellValue("L8", "BU");
        $sheet->setCellValue("M8", "Total");
        $sheet->getStyle("A6:M8")->applyFromArray($styleCenter);
        $sheet->getStyle('A6:M8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        /*
         * BODY NUMPANG UJI MASUK
         */
        $baris = 9;
        $baris_awal = $baris;
        $baris_akhir = $baris_awal + 11;

        for ($bln = 1; $bln <= 12; $bln++) :
            $dataKendaraan = VLapKendaraanBaru::model()->findByAttributes(array('bulan' => $bln, 'tahun' => $thn));

            $sheet->setCellValue("A" . $baris, Yii::app()->params['bulanArrayInd'][$bln - 1]);
            $sheet->setCellValue("B" . $baris, $dataKendaraan['npu_msk_mbrg_umum']);
            $sheet->setCellValue("C" . $baris, '=D' . $baris . '-B' . $baris);
            $sheet->setCellValue("D" . $baris, $dataKendaraan['npu_msk_mbrg']);
            $sheet->setCellValue("E" . $baris, $dataKendaraan['npu_msk_mpnp_umum']);
            $sheet->setCellValue("F" . $baris, '=G' . $baris . '-E' . $baris);
            $sheet->setCellValue("G" . $baris, $dataKendaraan['npu_msk_mpnp']);
            $sheet->setCellValue("H" . $baris, $dataKendaraan['npu_msk_mbus_umum']);
            $sheet->setCellValue("I" . $baris, '=J' . $baris . '-H' . $baris);
            $sheet->setCellValue("J" . $baris, $dataKendaraan['npu_msk_mbus']);
            $sheet->setCellValue("K" . $baris, '=SUM(B' . $baris . ',E' . $baris . ',H' . $baris . ')');
            $sheet->setCellValue("L" . $baris, '=SUM(C' . $baris . ',F' . $baris . ',I' . $baris . ')');
            $sheet->setCellValue("M" . $baris, '=SUM(K' . $baris . ':L' . $baris . ')');
            $baris++;
        endfor;

        $sheet->setCellValue("A" . $baris, "TOTAL");
        $sheet->setCellValue("B" . $baris, "=SUM(B" . $baris_awal . ":B" . $baris_akhir . ")");
        $sheet->setCellValue("C" . $baris, "=SUM(C" . $baris_awal . ":C" . $baris_akhir . ")");
        $sheet->setCellValue("D" . $baris, "=SUM(D" . $baris_awal . ":D" . $baris_akhir . ")");
        $sheet->setCellValue("E" . $baris, "=SUM(E" . $baris_awal . ":E" . $baris_akhir . ")");
        $sheet->setCellValue("F" . $baris, "=SUM(F" . $baris_awal . ":F" . $baris_akhir . ")");
        $sheet->setCellValue("G" . $baris, "=SUM(G" . $baris_awal . ":G" . $baris_akhir . ")");
        $sheet->setCellValue("H" . $baris, "=SUM(H" . $baris_awal . ":H" . $baris_akhir . ")");
        $sheet->setCellValue("I" . $baris, "=SUM(I" . $baris_awal . ":I" . $baris_akhir . ")");
        $sheet->setCellValue("J" . $baris, "=SUM(J" . $baris_awal . ":J" . $baris_akhir . ")");
        $sheet->setCellValue("K" . $baris, "=SUM(K" . $baris_awal . ":K" . $baris_akhir . ")");
        $sheet->setCellValue("L" . $baris, "=SUM(L" . $baris_awal . ":L" . $baris_akhir . ")");
        $sheet->setCellValue("M" . $baris, "=SUM(M" . $baris_awal . ":M" . $baris_akhir . ")");
        $sheet->getStyle('A' . $baris . ':M' . $baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        $sheet->getStyle("A6:M" . $baris)->applyFromArray($styleBorder);
        //======================================================================
        /*
         * BODY HEADER NUMPANG UJI KELUAR
         */
        $sheet->mergeCells("P6:X6");
        $sheet->mergeCells("O6:O8");
        $sheet->mergeCells("P7:R7");
        $sheet->mergeCells("S7:U7");
        $sheet->mergeCells("V7:X7");
        $sheet->mergeCells("Y6:AA7");
        $sheet->setCellValue("P6", "NUMPANG UJI KELUAR");
        $sheet->setCellValue("O6", "Bulan");
        $sheet->setCellValue("P7", "Mobil Barang");
        $sheet->setCellValue("P8", "Umum");
        $sheet->setCellValue("Q8", "BU");
        $sheet->setCellValue("R8", "Total");
        $sheet->setCellValue("S7", "Mobil Penumpang");
        $sheet->setCellValue("S8", "Umum");
        $sheet->setCellValue("T8", "BU");
        $sheet->setCellValue("U8", "Total");
        $sheet->setCellValue("V7", "Mobil Bus");
        $sheet->setCellValue("V8", "Umum");
        $sheet->setCellValue("W8", "BU");
        $sheet->setCellValue("X8", "Total");
        $sheet->setCellValue("Y6", "TOTAL KESELURUHAN");
        $sheet->setCellValue("Y8", "Umum");
        $sheet->setCellValue("Z8", "BU");
        $sheet->setCellValue("AA8", "Total");
        $sheet->getStyle("O6:AA8")->applyFromArray($styleCenter);
        $sheet->getStyle('O6:AA8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        /*
         * BODY NUMPANG UJI KELUAR
         */
        $baris = 9;
        $baris_awal = $baris;
        $baris_akhir = $baris_awal + 11;

        for ($bln = 1; $bln <= 12; $bln++) :
            $dataKendaraan = VLapKendaraanBaru::model()->findByAttributes(array('bulan' => $bln, 'tahun' => $thn));

            $sheet->setCellValue("O" . $baris, Yii::app()->params['bulanArrayInd'][$bln - 1]);
            $sheet->setCellValue("P" . $baris, $dataKendaraan['npu_klr_mbrg_umum']);
            $sheet->setCellValue("Q" . $baris, '=R' . $baris . '-P' . $baris);
            $sheet->setCellValue("R" . $baris, $dataKendaraan['npu_klr_mbrg']);
            $sheet->setCellValue("S" . $baris, $dataKendaraan['npu_klr_mpnp_umum']);
            $sheet->setCellValue("T" . $baris, '=U' . $baris . '-S' . $baris);
            $sheet->setCellValue("U" . $baris, $dataKendaraan['npu_klr_mpnp']);
            $sheet->setCellValue("V" . $baris, $dataKendaraan['npu_klr_mbus_umum']);
            $sheet->setCellValue("W" . $baris, '=X' . $baris . '-V' . $baris);
            $sheet->setCellValue("X" . $baris, $dataKendaraan['npu_klr_mbus']);
            $sheet->setCellValue("Y" . $baris, '=SUM(P' . $baris . ',S' . $baris . ',V' . $baris . ')');
            $sheet->setCellValue("Z" . $baris, '=SUM(Q' . $baris . ',T' . $baris . ',W' . $baris . ')');
            $sheet->setCellValue("AA" . $baris, '=SUM(Y' . $baris . ':Z' . $baris . ')');
            $baris++;
        endfor;

        $sheet->setCellValue("O" . $baris, "TOTAL");
        $sheet->setCellValue("P" . $baris, "=SUM(P" . $baris_awal . ":P" . $baris_akhir . ")");
        $sheet->setCellValue("Q" . $baris, "=SUM(Q" . $baris_awal . ":Q" . $baris_akhir . ")");
        $sheet->setCellValue("R" . $baris, "=SUM(R" . $baris_awal . ":R" . $baris_akhir . ")");
        $sheet->setCellValue("S" . $baris, "=SUM(S" . $baris_awal . ":S" . $baris_akhir . ")");
        $sheet->setCellValue("T" . $baris, "=SUM(T" . $baris_awal . ":T" . $baris_akhir . ")");
        $sheet->setCellValue("U" . $baris, "=SUM(U" . $baris_awal . ":U" . $baris_akhir . ")");
        $sheet->setCellValue("V" . $baris, "=SUM(V" . $baris_awal . ":V" . $baris_akhir . ")");
        $sheet->setCellValue("W" . $baris, "=SUM(W" . $baris_awal . ":W" . $baris_akhir . ")");
        $sheet->setCellValue("X" . $baris, "=SUM(X" . $baris_awal . ":X" . $baris_akhir . ")");
        $sheet->setCellValue("Y" . $baris, "=SUM(Y" . $baris_awal . ":Y" . $baris_akhir . ")");
        $sheet->setCellValue("Z" . $baris, "=SUM(Z" . $baris_awal . ":Z" . $baris_akhir . ")");
        $sheet->setCellValue("AA" . $baris, "=SUM(AA" . $baris_awal . ":AA" . $baris_akhir . ")");
        $sheet->getStyle('O' . $baris . ':AA' . $baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        $sheet->getStyle("O6:AA" . $baris)->applyFromArray($styleBorder);
        //======================================================================
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="report_numpanguji_' . $thn . '.xls"');
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

    /*
     * TERDAFTAR
     */

    public function actionIndexReportTerdaftar()
    {
        $this->pageTitle = 'Report Terdaftar';
        $this->render('index_report_terdaftar');
    }

    public function actionReportTerdaftar($thn)
    {
        Yii::import("ext.PHPExcel", TRUE);
        $xls = new PHPExcel();

        //======================================================================
        $styleCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $styleVerticalCenter = array(
            'alignment' => array(
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
        //======================================================================
        /*
         * HEADER TERDAFTAR
         */
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('TERDAFTAR');
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(false);
        $sheet->getPageSetup()->setHorizontalCentered(true);
        $sheet->getPageSetup()->setScale(82);
        //=============================================
        $sheet->getColumnDimension('A')->setWidth(11.56);
        $sheet->getColumnDimension('O')->setWidth(11.56);
        $sheet->mergeCells("A1:M1");
        $sheet->mergeCells("A2:M2");
        $sheet->mergeCells("A3:M3");
        $sheet->mergeCells("A4:M4");

        $sheet->setCellValue("A1", "JUMLAH KENDARAAN TERDAFTAR");
        $sheet->setCellValue("A2", "TAHUN " . $thn);
        $sheet->setCellValue("A3", "UPTD PENGUJIAN KENDARAAN BERMOTOR SURABAYA");
        $sheet->setCellValue("A4", "DINAS PERHUBUNGAN KOTA SURABAYA");

        $sheet->getStyle("A1")->applyFromArray($styleCenter);
        $sheet->getStyle("A2")->applyFromArray($styleCenter);
        $sheet->getStyle("A3")->applyFromArray($styleCenter);
        $sheet->getStyle("A4")->applyFromArray($styleCenter);
        /*
         * BODY HEADER MUTASI MASUK
         */
        $sheet->mergeCells("B6:J6");
        $sheet->mergeCells("A6:A8");
        $sheet->mergeCells("B7:D7");
        $sheet->mergeCells("E7:G7");
        $sheet->mergeCells("H7:J7");
        $sheet->mergeCells("K6:M7");
        $sheet->setCellValue("B6", "TERDAFTAR");
        $sheet->setCellValue("A6", "Bulan");
        $sheet->setCellValue("B7", "Mobil Barang");
        $sheet->setCellValue("B8", "Umum");
        $sheet->setCellValue("C8", "BU");
        $sheet->setCellValue("D8", "Total");
        $sheet->setCellValue("E7", "Mobil Penumpang");
        $sheet->setCellValue("E8", "Umum");
        $sheet->setCellValue("F8", "BU");
        $sheet->setCellValue("G8", "Total");
        $sheet->setCellValue("H7", "Mobil Bus");
        $sheet->setCellValue("H8", "Umum");
        $sheet->setCellValue("I8", "BU");
        $sheet->setCellValue("J8", "Total");
        $sheet->setCellValue("K6", "TOTAL KESELURUHAN");
        $sheet->setCellValue("K8", "Umum");
        $sheet->setCellValue("L8", "BU");
        $sheet->setCellValue("M8", "Total");
        $sheet->getStyle("A6:M8")->applyFromArray($styleCenter);
        $sheet->getStyle('A6:M8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        /*
         * BODY MUTASI MASUK
         */
        $baris = 9;
        $baris_awal = $baris;
        $baris_akhir = $baris_awal + 11;

        for ($bln = 1; $bln <= 12; $bln++) :
            $dataKendaraan = VLapKendaraanBaru::model()->findByAttributes(array('bulan' => $bln, 'tahun' => $thn));

            $sheet->setCellValue("A" . $baris, Yii::app()->params['bulanArrayInd'][$bln - 1]);
            $sheet->setCellValue("B" . $baris, $dataKendaraan['terdaftar_mbrg_umum']);
            $sheet->setCellValue("C" . $baris, '=D' . $baris . '-B' . $baris);
            $sheet->setCellValue("D" . $baris, $dataKendaraan['terdaftar_mbrg']);
            $sheet->setCellValue("E" . $baris, $dataKendaraan['terdaftar_mpnp_umum']);
            $sheet->setCellValue("F" . $baris, '=G' . $baris . '-E' . $baris);
            $sheet->setCellValue("G" . $baris, $dataKendaraan['terdaftar_mpnp']);
            $sheet->setCellValue("H" . $baris, $dataKendaraan['terdaftar_mbus_umum']);
            $sheet->setCellValue("I" . $baris, '=J' . $baris . '-H' . $baris);
            $sheet->setCellValue("J" . $baris, $dataKendaraan['terdaftar_mbus']);
            $sheet->setCellValue("K" . $baris, '=SUM(B' . $baris . ',E' . $baris . ',H' . $baris . ')');
            $sheet->setCellValue("L" . $baris, '=SUM(C' . $baris . ',F' . $baris . ',I' . $baris . ')');
            $sheet->setCellValue("M" . $baris, '=SUM(K' . $baris . ':L' . $baris . ')');
            $baris++;
        endfor;

        $sheet->setCellValue("A" . $baris, "TOTAL");
        $sheet->setCellValue("B" . $baris, "=SUM(B" . $baris_awal . ":B" . $baris_akhir . ")");
        $sheet->setCellValue("C" . $baris, "=SUM(C" . $baris_awal . ":C" . $baris_akhir . ")");
        $sheet->setCellValue("D" . $baris, "=SUM(D" . $baris_awal . ":D" . $baris_akhir . ")");
        $sheet->setCellValue("E" . $baris, "=SUM(E" . $baris_awal . ":E" . $baris_akhir . ")");
        $sheet->setCellValue("F" . $baris, "=SUM(F" . $baris_awal . ":F" . $baris_akhir . ")");
        $sheet->setCellValue("G" . $baris, "=SUM(G" . $baris_awal . ":G" . $baris_akhir . ")");
        $sheet->setCellValue("H" . $baris, "=SUM(H" . $baris_awal . ":H" . $baris_akhir . ")");
        $sheet->setCellValue("I" . $baris, "=SUM(I" . $baris_awal . ":I" . $baris_akhir . ")");
        $sheet->setCellValue("J" . $baris, "=SUM(J" . $baris_awal . ":J" . $baris_akhir . ")");
        $sheet->setCellValue("K" . $baris, "=SUM(K" . $baris_awal . ":K" . $baris_akhir . ")");
        $sheet->setCellValue("L" . $baris, "=SUM(L" . $baris_awal . ":L" . $baris_akhir . ")");
        $sheet->setCellValue("M" . $baris, "=SUM(M" . $baris_awal . ":M" . $baris_akhir . ")");
        $sheet->getStyle('A' . $baris . ':M' . $baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        $sheet->getStyle("A6:M" . $baris)->applyFromArray($styleBorder);
        //======================================================================
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="report_terdaftar_' . $thn . '.xls"');
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
