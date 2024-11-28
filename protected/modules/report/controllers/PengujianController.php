<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PengujianController
 *
 * @author TIA.WICAKSONO
 */
class PengujianController extends Controller
{

    //put your code here    

    /*     * =====================================================================
     * REPORT UJI PERTAMA
      ====================================================================== */
    public function actionPageReportUjiPertama()
    {
        $this->render('index_uji_pertama');
    }

    public function actionExportExcelUjiPertama($tgl_report_uji_pertama)
    {
        $tgl = $tgl_report_uji_pertama;
        Yii::import("ext.PHPExcel", TRUE);
        $xls = new PHPExcel();
        $sheet = $xls->getActiveSheet();
        $xls->setActiveSheetIndex(0);
        //======================================================================
        //HEADER
        $sheet->setCellValue("A1", "No.");
        $sheet->getStyle("A1")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A1")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("A")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("A")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension('A')->setAutoSize(true);

        $sheet->getStyle("B1")->getAlignment()->setWrapText(true);
        $sheet->setCellValue("B1", "Nomor Kendaraan");
        $sheet->getStyle("B1")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("B1")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("B")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension('B')->setAutoSize(true);

        $sheet->getStyle("C1")->getAlignment()->setWrapText(true);
        $sheet->setCellValue("C1", "Nomor Uji");
        $sheet->getStyle("C1")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("C1")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("C")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension('C')->setAutoSize(true);

        $sheet->getStyle("D")->getAlignment()->setWrapText(true);
        $sheet->setCellValue("D1", "Merk");
        $sheet->getStyle("D1")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("D1")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("D")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension('D')->setAutoSize(true);

        $sheet->setCellValue("E1", "Tahun");
        $sheet->getStyle("E1")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("E1")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("E")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

        $sheet->getStyle("F")->getAlignment()->setWrapText(true);
        $sheet->setCellValue("F1", "Jenis");
        $sheet->getStyle("F1")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("F1")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("F")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $sheet->setCellValue("G1", "Umum");
        $sheet->getStyle("G1")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("G1")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("G")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

        $sheet->getStyle("H1")->getAlignment()->setWrapText(true);
        $sheet->setCellValue("H1", "Bukan Umum");
        $sheet->getStyle("H1")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
        $sheet->getStyle("H1")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $sheet->getStyle("H")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

        $sheet->getStyle('A1:H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        //END HEADER
        //======================================================================
        //======================================================================
        //BODY
        $dataKendaraan = TblBuku::model()->reportUjiPertama($tgl);
        $no = 1;
        $baris = 2;
        foreach ($dataKendaraan as $data) :
            $sheet->setCellValue("A" . $baris, $no);
            $sheet->setCellValue("B" . $baris, $data->no_kendaraan);
            $sheet->setCellValue("C" . $baris, $data->no_uji);
            $sheet->setCellValue("D" . $baris, $data->merk);
            $sheet->setCellValue("E" . $baris, $data->tahun);
            $sheet->setCellValue("F" . $baris, $data->nm_komersil);
            $sheet->setCellValue("G" . $baris, $data->umum == true ? 'v' : '-');
            $sheet->setCellValue("H" . $baris, $data->umum == false ? 'v' : '-');
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
        $sheet->getStyle("A1:H" . $baris_border)->applyFromArray($styleArray);
        //=====================================================================

        $dataCountKendaraan = TblBuku::model()->countReportUjiPertama($tgl);
        $sheet->getStyle("J")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $baris_keterangan = 2;
        foreach ($dataCountKendaraan as $data) :
            //            $sheet->mergeCells("J".$lanjutBaris.":C".$lanjutBaris);
            $sheet->setCellValue("J" . $baris_keterangan, $data->nm_komersil);
            $sheet->setCellValue("K" . $baris_keterangan, $data->jumlah);
            $baris_keterangan++;
        endforeach;

        ob_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export_tracking.xls"');
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

    public function actionUjiPertamaListGrid()
    {
        $tgl = $_POST['tanggal'];
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $offset = ($page - 1) * $rows;

        $criteria = TblBuku::model()->criteriaReportUjiPertama($tgl, 8);
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        $criteria->select = "tk.no_kendaraan, tk.no_uji, tk.merk, tk.tahun, tk.umum, tt.nm_komersil";
        $criteria->order = "tk.no_uji ASC";
        $result = TblBuku::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $data) {
            $dataJson[] = array(
                "no_kendaraan" => $data->no_kendaraan,
                "no_uji" => $data->no_uji,
                "merk_tahun" => $data->merk . " / " . $data->tahun,
                "jenis" => $data->nm_komersil,
                "umum" => $data->umum == true ? 'v' : '-',
                "b_umum" => $data->umum == false ? 'v' : '-',
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => TblBuku::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    /*     * =====================================================================
     * REPORT PEMAKAIAN BUKU UJI
      ====================================================================== */

    public function actionPageReportBukuUji()
    {
        $this->render('index_buku_uji');
    }

    public function actionExportExcelBukuUji()
    {
        $tgl = $_GET['tgl_report'];
        Yii::import("ext.XPHPExcel");
        $xls = XPHPExcel::createPHPExcel();
        $sheet = $xls->getActiveSheet();
        $xls->setActiveSheetIndex(0);
        //======================================================================
        //HEADER
        $sheet->setCellValue("A1", "No.");
        $sheet->setCellValue("B1", "Nomor Kendaraan");
        $sheet->setCellValue("C1", "Nomor Uji");
        $sheet->setCellValue("D1", "Merk/Tahun");
        $sheet->setCellValue("E1", "Jenis");
        $sheet->setCellValue("F1", "Umum");
        $sheet->setCellValue("G1", "Bukan Umum");
        //END HEADER
        //======================================================================
        //======================================================================
        //BODY
        $dataKendaraan = TblBuku::model()->reportUjiPertama($tgl);
        $no = 1;
        $baris = 2;
        foreach ($dataKendaraan as $data) :
            $sheet->setCellValue("A" . $baris, $no);
            $sheet->setCellValue("B" . $baris, $data->no_kendaraan);
            $sheet->setCellValue("C" . $baris, $data->no_uji);
            $sheet->setCellValue("D" . $baris, $data->merk . " / " . $data->tahun);
            $sheet->setCellValue("E" . $baris, $data->nm_komersil);
            $sheet->setCellValue("F" . $baris, $data->umum == true ? 'v' : '-');
            $sheet->setCellValue("G" . $baris, $data->umum == false ? 'v' : '-');
            $baris++;
            $no++;
        endforeach;
        $dataCountKendaraan = TblBuku::model()->countReportUjiPertama($tgl);
        $lanjutBaris = $baris + 1;
        foreach ($dataCountKendaraan as $data) :
            $sheet->mergeCells("A" . $lanjutBaris . ":C" . $lanjutBaris);
            $sheet->setCellValue("A" . $lanjutBaris, $data->nm_komersil);
            $sheet->setCellValue("D" . $lanjutBaris, $data->jumlah);
            $lanjutBaris++;
        endforeach;
        //END BODY
        //======================================================================
        ob_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export_tracking.xls"');
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

    public function actionTableBukuUji()
    {
        $tgl = $_POST['tanggal'];
        $this->renderPartial('table_buku_uji', array('tgl' => $tgl));
    }

    public function actionGrafikBukuUji()
    {
        $tgl = $_POST['tanggal'];
        $this->renderPartial('grafik_buku_uji', array('tgl' => $tgl));
    }
}
