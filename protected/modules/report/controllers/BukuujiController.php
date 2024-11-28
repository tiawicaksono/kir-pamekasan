<?php

class BukuujiController extends Controller
{

    public function filters()
    {
        return array(
            'Rights', // perform access control for CRUD operations
        );
    }

    public function actionIndex()
    {
        $this->pageTitle = 'REKAP BUKU UJI';
        $this->render('index');
    }

    public function actionRekap($tgl)
    {
        $tglExplode = explode('-', str_replace(' ', '', $tgl));
        $tglAwal = $tglExplode[0];
        $tglAkhir = $tglExplode[1];

        Yii::import("ext.PHPExcel", TRUE);
        $xls = new PHPExcel();
        $sheet = $xls->getActiveSheet();
        $xls->setActiveSheetIndex(0);
        //======================================================================
        //HEADER
        $sheet->getRowDimension(5)->setRowHeight(40);
        $sheet->mergeCells("A1:H1");
        $sheet->setCellValue("A1", "LAPORAN DAFTAR CETAK BUKU UJI");
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle("A1")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A1")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->mergeCells("A2:H2");
        $sheet->setCellValue("A2", "KENDARAAN BARU, MUTASI MASUK, GANTI BUKU, BUKU HILANG/RUSAK");
        $sheet->getStyle("A2")->getFont()->setSize(20);
        $sheet->getStyle("A2")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A2")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->mergeCells("A3:H3");
        $sheet->setCellValue("A3", $tglAwal . " - " . $tglAkhir);
        $sheet->getStyle("A3")->getFont()->setSize(14);
        $sheet->getStyle("A3")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A3")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("A5", "NO");
        $sheet->getStyle("A5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("A")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension('A')->setAutoSize(true);

        $sheet->setCellValue("B5", "SERI BUKU");
        $sheet->getStyle("B5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("B5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("B5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("B")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension('B')->setAutoSize(true);

        $sheet->getStyle("C5")->getAlignment()->setWrapText(true);
        $sheet->setCellValue("C5", "NO UJI");
        $sheet->getStyle("C5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("C5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("C")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension('C')->setAutoSize(true);

        $sheet->getStyle("D5")->getAlignment()->setWrapText(true);
        $sheet->setCellValue("D5", "NO KENDARAAN");
        $sheet->getStyle("D5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("D5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("D")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension('D')->setAutoSize(true);

        $sheet->setCellValue("E5", "TGL DAFTAR");
        $sheet->getStyle("E5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("E5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("E")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("E")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("E")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('E')->setWidth(20);

        $sheet->setCellValue("F5", "TGL CETAK");
        $sheet->getStyle("F5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("F5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("F")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("F")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("F")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('F')->setWidth(20);

        $sheet->setCellValue("G5", "STATUS");
        $sheet->getStyle("G5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("G5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("G5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("G")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension('G')->setAutoSize(true);

        $sheet->setCellValue("H5", "PETUGAS");
        $sheet->getStyle("H5")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("H5")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("H")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension('H')->setWidth(13);

        $sheet->getStyle('A5:H5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        //END HEADER
        //======================================================================

        $criteria = new CDbCriteria();
        $criteria->addCondition("tgl_cetak >= TO_DATE('" . $tglAwal . "', 'DD/MM/YY')");
        $criteria->addCondition("tgl_cetak <= TO_DATE('" . $tglAkhir . "', 'DD/MM/YY')");
        $result = VGantibuku::model()->findAll($criteria);
        //======================================================================
        //BODY        
        $no = 1;
        $baris = 6;
        $gb = 0;
        foreach ($result as $data) :
            if (($data->id_bk_masuk == 2 && $data->id_uji == 1) || ($data->id_uji == 10) || ($data->id_uji == 11) || ($data->id_uji == 20) || ($data->id_uji == 1)) {
                $status = "Ganti Buku";
            } else {
                $uji = TblUji::model()->findByPk($data->id_uji);
                $status = ucwords(strtolower($uji->nm_uji));
            }
            $sheet->setCellValue("A" . $baris, $no);
            $sheet->setCellValue("B" . $baris, $data->no_seri);
            $sheet->setCellValue("C" . $baris, $data->no_uji);
            $sheet->setCellValue("D" . $baris, $data->no_kendaraan);
            $sheet->setCellValue("E" . $baris, date("d M Y", strtotime($data->tgl_retribusi)));
            $sheet->setCellValue("F" . $baris, date("d M Y", strtotime($data->tgl_cetak)));
            $sheet->setCellValue("G" . $baris, $status);
            $sheet->setCellValue("H" . $baris, $data->petugas);
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
        $sheet->getStyle("A5:H" . $baris_border)->applyFromArray($styleArray);

        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getStyle("K")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("K")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("J6", "Ganti Buku");
        $sheet->getStyle("J6")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->setCellValue("K6", '=COUNTIFS(G6:G' . $baris_border . ', "Ganti Buku")');

        $sheet->setCellValue("J7", "Uji Pertama");
        $sheet->setCellValue("K7", '=COUNTIFS(G6:G' . $baris_border . ', "Uji Pertama")');
        $sheet->getStyle("J7")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("J8", "Mutasi Masuk");
        $sheet->setCellValue("K8", '=COUNTIFS(G6:G' . $baris_border . ', "Mutasi Masuk")');
        $sheet->getStyle("J8")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $sheet->setCellValue("J9", "Ubah Bentuk");
        $sheet->setCellValue("K9", '=COUNTIFS(G6:G' . $baris_border . ', "Ubah Bentuk")');
        $sheet->getStyle("J9")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        //======================================================================

        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Pemakasian_Buku_Uji.xls"');
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
