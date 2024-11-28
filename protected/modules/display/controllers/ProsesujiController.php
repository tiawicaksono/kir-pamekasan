<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportController
 *
 * @author TIA.WICAKSONO
 */
class ProsesujiController extends Controller
{

    public function actionStatusProsesListGrid()
    {
        $ok = Yii::app()->baseUrl . "/images/icon_approve.png";
        $reject = Yii::app()->baseUrl . "/images/icon_reject.png";
        $proses = Yii::app()->baseUrl . "/images/icon_proccess.png";

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'antri';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page - 1) * $rows;

        $tanggal = date('m/d/Y');
        $criteria = new CDbCriteria();
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        $criteria->addCondition("jdatang::date = '$tanggal'");
        $criteria->addCondition("cetak = 'false'");
        $result = VStatusProsesAll::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            //prauji
            //            if ($p->prauji == "true") {
            //                if ($p->lulus_prauji == "true")
            //                    $img_prauji = "<img src='$ok'>";
            //                else
            //                    $img_prauji = "<img src='$reject'>";
            //            }else {
            //                $img_prauji = "<img src='$proses'>";
            //            }
            if ($p->prauji == "true") {
                if ($p->lulus_prauji == "true")
                    $img_prauji = "<img src='$ok'><br/>LULUS";
                else
                    $img_prauji = "<img src='$reject'><br/>TIDAK LULUS";
            } else {
                $img_prauji = "<img src='$proses'><br/>PROSES";
            }
            //smoke
            //            if ($p->smoke == "true") {
            //                if ($p->lulus_smoke == "true")
            //                    $img_smoke = "<img src='$ok'>";
            //                else
            //                    $img_smoke = "<img src='$reject'>";
            //            }else {
            //                $img_smoke = "<img src='$proses'>";
            //            }
            if ($p->smoke == "true") {
                if ($p->lulus_smoke == "true")
                    $img_smoke = "<img src='$ok'><br/>LULUS";
                else
                    $img_smoke = "<img src='$reject'><br/>TIDAK LULUS";
            } else {
                $img_smoke = "<img src='$proses'><br/>PROSES";
            }
            //pitlift
            //            if ($p->pitlift == "true") {
            //                if ($p->lulus_pitlift == "true")
            //                    $img_pitlift = "<img src='$ok'>";
            //                else
            //                    $img_pitlift = "<img src='$reject'>";
            //            }else {
            //                $img_pitlift = "<img src='$proses'>";
            //            }
            if ($p->pitlift == "true") {
                if ($p->lulus_pitlift == "true")
                    $img_pitlift = "<img src='$ok'><br/>LULUS";
                else
                    $img_pitlift = "<img src='$reject'><br/>TIDAK LULUS";
            } else {
                $img_pitlift = "<img src='$proses'><br/>PROSES";
            }
            //lampu
            //            if ($p->lampu == "true") {
            //                if ($p->lulus_lampu == "true")
            //                    $img_lampu = "<img src='$ok'>";
            //                else
            //                    $img_lampu = "<img src='$reject'>";
            //            }else {
            //                $img_lampu = "<img src='$proses'>";
            //            }
            if ($p->lampu == "true") {
                if ($p->lulus_lampu == "true")
                    $img_lampu = "<img src='$ok'><br/>LULUS";
                else
                    $img_lampu = "<img src='$reject'><br/>TIDAK LULUS";
            } else {
                $img_lampu = "<img src='$proses'><br/>PROSES";
            }
            //rem
            //            if ($p->break == "true") {
            //                if ($p->lulus_break == "true")
            //                    $img_break = "<img src='$ok'>";
            //                else
            //                    $img_break = "<img src='$reject'>";
            //            }else {
            //                $img_break = "<img src='$proses'>";
            //            }
            if ($p->break == "true") {
                if ($p->lulus_break == "true")
                    $img_break = "<img src='$ok'><br/>LULUS";
                else
                    $img_break = "<img src='$reject'><br/>TIDAK LULUS";
            } else {
                $img_break = "<img src='$proses'><br/>PROSES";
            }
            $dataJson[] = array(
                "no_antrian" => $p->no_antrian,
                "no_uji" => $p->no_uji,
                "no_kendaraan" => $p->no_kendaraan,
                "ptgs_prauji" => $p->ptgs_prauji,
                "ptgs_smoke" => $p->ptgs_smoke,
                "ptgs_pitlift" => $p->ptgs_pitlift,
                "ptgs_lampu" => $p->ptgs_lampu,
                "ptgs_break" => $p->ptgs_break,
                "prauji" => $img_prauji,
                "emisi" => $img_smoke,
                "pitlift" => $img_pitlift,
                "lampu" => $img_lampu,
                "rem" => $img_break
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => VStatusProsesAll::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionGetKelulusanBrake()
    {
        $cis = $_POST['cis'];
        $result = TblTempBrake::model()->findByAttributes(array('cis' => $cis));
        $data['no_uji'] = $result->no_uji;
        $data['no_kendaraan'] = $result->no_kendaraan;
        $data['kelulusan'] = $result->kelulusan == TRUE ? '<font color="#6ef442">LULUS</font>' : '<font color="red">TIDAK LULUS</font>';
        $data['grem_sb1'] = $result->grem_sb1 . " %";
        $data['grem_sb2'] = $result->grem_sb2 . " %";
        $data['grem_sb3'] = $result->grem_sb3 . " %";
        $data['grem_sb4'] = $result->grem_sb4 . " %";
        $data['selrem_sb1'] = $result->selrem_sb1 . " %";
        $data['selrem_sb2'] = $result->selrem_sb2 . " %";
        $data['selrem_sb3'] = $result->selrem_sb3 . " %";
        $data['selrem_sb4'] = $result->selrem_sb4 . " %";
        if ($result->kelulusan == TRUE) {
            $data['list_kelulusan'] = '...';
        } else {
            $arDataTl = new CDbCriteria();
            $arDataTl->addCondition("id_hasil_uji = $result->id_hasil_uji");
            $arDataTl->addCondition("input_tl = 'Rem' OR input_tl = 'Lampu'");
            $dataTl = VDetailTl::model()->findAll($arDataTl);
            $keterangan = '';
            $no = 1;
            foreach ($dataTl as $p) {
                $keterangan .= $no . ". " . $p->kelulusan . "<br />";
                $no++;
            }
            $data['list_kelulusan'] = $keterangan;
        }
        echo json_encode($data);
    }

    public function actionGetKelulusanHeadlight()
    {
        $cis = $_POST['cis'];
        $result = TblTempHeadlight::model()->findByAttributes(array('cis' => $cis));
        $data['no_uji'] = $result->no_uji;
        $data['no_kendaraan'] = $result->no_kendaraan;
        $data['kelulusan'] = $result->kelulusan == TRUE ? '<font color="#6ef442">LULUS</font>' : '<font color="red">TIDAK LULUS</font>';
        $data['dev_kanan'] = $result->dev_kanan . " &deg;";
        $data['dev_kiri'] = $result->dev_kiri . " &deg;";
        $data['lamp_kt_kanan'] = $result->lamp_kt_kanan . " cd";
        $data['lamp_kt_kiri'] = $result->lamp_kt_kiri . " cd";
        if ($result->kelulusan == TRUE) {
            $data['list_kelulusan'] = '...';
        } else {
            $dataTl = VDetailTl::model()->findAllByAttributes(array('id_hasil_uji' => $result->id_hasil_uji, 'input_tl' => 'Lampu'));
            $keterangan = '';
            $no = 1;
            foreach ($dataTl as $p) {
                $keterangan .= $no . ". " . $p->kelulusan . "<br />";
                $no++;
            }
            $data['list_kelulusan'] = $keterangan;
        }
        echo json_encode($data);
    }

    public function actionGetKelulusanPrauji()
    {
        $cis = $_POST['cis'];
        $result = TblTempPrauji::model()->findByAttributes(array('cis' => $cis));
        $data['no_uji'] = $result->no_uji;
        $data['no_kendaraan'] = $result->no_kendaraan;
        //        $dtKendaraan = TblKendaraan::model()->findByAttributes(array('no_uji' => $result->no_uji))->id_kendaraan;
        //        $query = "select img_depan,img_belakang,img_kanan,img_kiri from tbl_hasil_uji where id_kendaraan=$dtKendaraan order by jdatang desc limit 1 offset 1";
        //        $resultQuery = Yii::app()->db->createCommand($query)->queryRow();
        //        $data['img_depan'] = $resultQuery['img_depan'];
        //        $data['img_kanan'] = $resultQuery['img_kanan'];
        //        $data['img_kiri'] = $resultQuery['img_kiri'];
        //        $data['img_belakang'] = $resultQuery['img_belakang'];

        $data['kelulusan'] = $result->kelulusan == TRUE ? '<font color="#6ef442">LULUS</font>' : '<font color="red">TIDAK LULUS</font>';
        $data['nilai_kelulusan'] = $result->kelulusan == TRUE ? 1 : 0;
        if ($result->kelulusan == TRUE) {
            $data['list_kelulusan'] = '...';
        } else {
            $arDataTl = new CDbCriteria();
            $arDataTl->addCondition("id_hasil_uji = $result->id_hasil_uji");
            $arDataTl->addCondition("input_tl = 'Prauji' OR input_tl = 'Emisi'");
            $dataTl = VDetailTl::model()->findAll($arDataTl);
            $keterangan = '';
            $no = 1;
            foreach ($dataTl as $p) {
                $keterangan .= $no . ". " . $p->kelulusan . "<br />";
                $no++;
            }
            $data['list_kelulusan'] = $keterangan;
        }
        echo json_encode($data);
    }

    public function actionGetKelulusanEmisi()
    {
        $cis = $_POST['cis'];
        $result = TblTempEmisi::model()->findByAttributes(array('cis' => $cis));
        $data['no_uji'] = $result->no_uji;
        $data['no_kendaraan'] = $result->no_kendaraan;
        $data['kelulusan'] = $result->kelulusan == TRUE ? '<font color="#6ef442">LULUS</font>' : '<font color="red">TIDAK LULUS</font>';
        $data['diesel'] = $result->diesel . " %";
        $data['mesin_co'] = $result->mesin_co . " %";
        $data['mesin_hc'] = $result->mesin_hc . " ppm";
        if ($result->kelulusan == TRUE) {
            $data['list_kelulusan'] = '...';
        } else {
            $dataTl = VDetailTl::model()->findAllByAttributes(array('id_hasil_uji' => $result->id_hasil_uji, 'input_tl' => 'Emisi'));
            $keterangan = '';
            $no = 1;
            foreach ($dataTl as $p) {
                $keterangan .= $no . ". " . $p->kelulusan . "<br />";
                $no++;
            }
            $data['list_kelulusan'] = $keterangan;
        }
        echo json_encode($data);
    }

    public function actionGetKelulusanPitlift()
    {
        $cis = $_POST['cis'];
        $result = TblTempPitlift::model()->findByAttributes(array('cis' => $cis));
        $data['no_uji'] = $result->no_uji;
        $data['no_kendaraan'] = $result->no_kendaraan;
        $data['kelulusan'] = $result->kelulusan == TRUE ? '<font color="#6ef442">LULUS</font>' : '<font color="red">TIDAK LULUS</font>';
        //        if($result->kelulusan==TRUE){
        //            $data['list_kelulusan'] = '...';
        //        }else{
        //            $dataTl = VDetailTl::model()->findAllByAttributes(array('id_hasil_uji' => $result->id_hasil_uji, 'input_tl' => 'Pitlift'));
        //            $keterangan = '';
        //            $no = 1;
        //            foreach ($dataTl as $p) {
        //               $keterangan .= $no.". ".$p->kelulusan."<br />";
        //               $no++;
        //            }
        //            $data['list_kelulusan'] = $keterangan;
        //        }
        echo json_encode($data);
    }

    public function actionGetKelulusan()
    {
        $cis = $_POST['cis'];
        $result = TblTempKelulusan::model()->findByAttributes(array('cis' => $cis));
        $data['no_uji'] = $result->no_uji;
        $data['no_kendaraan'] = $result->no_kendaraan;
        $data['kelulusan'] = $result->kelulusan == TRUE ? '<font color="#6ef442">LULUS</font>' : '<font color="red">TIDAK LULUS</font>';
        if ($result->kelulusan == TRUE) {
            $data['list_kelulusan'] = '...';
        } else {
            $dataTl = VDetailTl::model()->findAllByAttributes(array('id_hasil_uji' => $result->id_hasil_uji));
            $keterangan = '';
            $no = 1;
            foreach ($dataTl as $p) {
                $keterangan .= $no . ". " . $p->kelulusan . "<br />";
                $no++;
            }
            $data['list_kelulusan'] = $keterangan;
        }
        echo json_encode($data);
    }
}
