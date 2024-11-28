<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TerdaftarController extends Controller
{

    public function filters()
    {
        return array(
            'Rights', // perform access control for CRUD operations
        );
    }

    public function actionIndex()
    {
        $this->pageTitle = 'TERDAFTAR';
        $this->render('terdaftar');
    }

    public function actionProsesGantiTglUji()
    {
        $id_retribusi = $_POST['dlg_id_retribusi'];
        $ganti_tgl_uji = date("m/d/Y", strtotime($_POST['ganti_tgl_uji']));
        $updateRetribusi = "Select edit_retribusi(" . $id_retribusi . ",'" . $ganti_tgl_uji . "','tgluji',0,0)";
        Yii::app()->db->createCommand($updateRetribusi)->query();
    }

    public function actionGetListDataTerdaftar()
    {
        //        $selectCategory = $_POST['selectCategory'];
        $textCategory = strtoupper($_POST['textCategory']);
        $selectDate = strtoupper($_POST['selectDate']);
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'numerator';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        if (!empty($textCategory)) {
            $criteria->addCondition("(replace(LOWER(no_uji),' ','') like replace(LOWER('%" . $textCategory . "%'),' ','') OR replace(LOWER(no_kendaraan),' ','') like replace(LOWER('%" . $textCategory . "'),' ',''))");
        }
        $criteria->addCondition("tgl_uji = TO_DATE('" . $selectDate . "', 'DD-Mon-YY')");
        $result = VDaftar::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataJson[] = array(
                "numerator" => $p->numerator,
                "id_retribusi" => $p->id_retribusi,
                "no_uji" => $p->no_uji,
                "no_kendaraan" => $p->no_kendaraan,
                "nama_pemilik" => $p->nama_pemilik,
                "no_chasis" => $p->no_chasis,
                "no_mesin" => $p->no_mesin,
                "nm_uji" => $p->nm_uji,
                "nm_komersil" => $p->nm_komersil,
                "karoseri_jenis" => $p->karoseri_jenis,
                "bahan_bakar" => $p->bahan_bakar,
                "sifat" => $p->sifat,
                "tglmati" => date("d F Y", strtotime($p->tgl_mati_uji))
            );
        }

        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => VDaftar::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionReportTerdaftarExcel()
    {
        $selectDate = strtoupper($_GET['tgl']);
        Yii::import("ext.PHPExcel", TRUE);
        $xls = new PHPExcel();
        $sheet = $xls->getActiveSheet();
        $xls->setActiveSheetIndex(0);
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
        //        echo (int)((847600/65000)*0.7);exit;
        //HEADER
        $sheet->mergeCells("A1:J1");
        $sheet->setCellValue("A1", "LAPORAN KENDARAAN TERDAFTAR");
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle("A1")->applyFromArray($styleTengah);

        $sheet->mergeCells("A2:J2");
        $sheet->setCellValue("A2", "BALAI PKB KAB.PAMEKASAN");
        $sheet->getStyle("A2")->getFont()->setSize(20);
        $sheet->getStyle("A2")->applyFromArray($styleTengah);

        $sheet->mergeCells("A3:J3");
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
        $sheet->getColumnDimension('B')->setAutoSize(true);
        //        $sheet->getColumnDimension('B')->setWidth(14);

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

        $sheet->setCellValue("E5", "JENIS KENDARAAN");
        $sheet->getStyle("E5")->applyFromArray($styleTengah);
        $sheet->getStyle("E")->applyFromArray($styleTengah);
        $sheet->getStyle("E5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("E")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('E')->setWidth(15);

        $sheet->setCellValue("F5", "NAMA KOMERSIL");
        $sheet->getStyle("F5")->applyFromArray($styleTengah);
        $sheet->getStyle("F")->applyFromArray($styleTengah);
        $sheet->getStyle("F5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("F")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('F')->setWidth(15);

        $sheet->setCellValue("G5", "JENIS KENDARAAN");
        $sheet->getStyle("G5")->applyFromArray($styleTengah);
        $sheet->getStyle("G")->applyFromArray($styleTengah);
        $sheet->getStyle("G5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("G")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('G')->setWidth(15);

        $sheet->setCellValue("H5", "SIFAT");
        $sheet->getStyle("H5")->applyFromArray($styleTengah);
        $sheet->getStyle("H")->applyFromArray($styleTengah);
        $sheet->getStyle("H5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("H")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('H')->setWidth(15);

        $sheet->setCellValue("I5", "BAHAN BAKAR");
        $sheet->getStyle("I5")->applyFromArray($styleTengah);
        $sheet->getStyle("I")->applyFromArray($styleTengah);
        $sheet->getStyle("I5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("I")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('I')->setWidth(15);

        $sheet->setCellValue("J5", "JENIS UJI");
        $sheet->getStyle("J5")->applyFromArray($styleTengah);
        $sheet->getStyle("J")->applyFromArray($styleTengah);
        $sheet->getStyle("J5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("J")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('J')->setWidth(15);

        $sheet->getStyle('A5:J5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b3c6cf');
        //END HEADER
        //======================================================================

        $criteria = new CDbCriteria();
        $criteria->addCondition("tgl_uji = TO_DATE('" . $selectDate . "', 'DD-Mon-YY')");
        $criteria->order = "no_uji asc";
        $result = VDaftar::model()->findAll($criteria);
        //======================================================================
        //BODY
        $no = 1;
        $baris = 6;
        foreach ($result as $data) :
            $sheet->setCellValue("A" . $baris, $no);
            $sheet->setCellValue("B" . $baris, $data->no_uji);
            $sheet->setCellValue("C" . $baris, $data->no_kendaraan);
            $sheet->setCellValue("D" . $baris, $data->nama_pemilik);
            $sheet->setCellValue("E" . $baris, $data->jns_kend);
            $sheet->setCellValue("F" . $baris, $data->nm_komersil);
            $sheet->setCellValue("G" . $baris, $data->karoseri_jenis);
            $sheet->setCellValue("H" . $baris, $data->sifat);
            $sheet->setCellValue("I" . $baris, $data->bahan_bakar);
            $sheet->setCellValue("J" . $baris, $data->nm_uji);
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
        $sheet->getStyle("A5:J" . $baris_border)->applyFromArray($styleArray);
        //======================================================================
        //FOOTER
        //        $kepala = $baris + 1;
        //        $sheet->mergeCells("E" . $kepala . ":G" . $kepala);
        //        $sheet->setCellValue("E" . $kepala, "KEPALA UPTD PKB WIYUNG");
        //        $sheet->getStyle("E" . $kepala)->applyFromArray($styleTengah);
        //
        //        $nama = $kepala + 5;
        //        $sheet->mergeCells("E" . $nama . ":G" . $nama);
        //        $sheet->setCellValue("E" . $nama, "Abdul Manab, SH.");
        //        $sheet->getStyle("E" . $nama)->applyFromArray($styleTengah);
        //
        //        $penata = $nama + 1;
        //        $sheet->mergeCells("E" . $penata . ":G" . $penata);
        //        $sheet->setCellValue("E" . $penata, "Penata");
        //        $sheet->getStyle("E" . $penata)->applyFromArray($styleTengah);
        //
        //        $nip = $penata + 1;
        //        $sheet->mergeCells("E" . $nip . ":G" . $nip);
        //        $sheet->setCellValue("E" . $nip, "NIP. 19630402 198910 1 003");
        //        $sheet->getStyle("E" . $nip)->applyFromArray($styleTengah);

        //        $sheet->getHeaderFooter()->setOddFooter('&R&F Page &P / &N');
        //        $sheet->getHeaderFooter()->setEvenFooter('&R&F Page &P / &N');
        $sheet->getHeaderFooter()->setOddFooter('&R Page &P / &N');
        $sheet->getHeaderFooter()->setEvenFooter('&R Page &P / &N');
        //END FOOTER
        //======================================================================
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="TERDAFTAR.xls"');
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
