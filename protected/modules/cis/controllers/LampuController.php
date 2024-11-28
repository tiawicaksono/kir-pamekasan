<?php

class LampuController extends Controller
{

    public $layout = '//layouts/main_top';

    public function filters()
    {
        return array(
            'Rights', // perform access control for CRUD operations
        );
    }

    //    public function actionIndex() {
    //        $this->pageTitle = 'Lampu';
    //        $this->render('index');
    //    }

    public function actionReloadData()
    {
        $tahun_kendaraan = intval($_POST['tahun_kendaraan']);
        $tahun_sekarang = intval(date('Y'));

        /*
         * LAMPU
         */
        if (($tahun_sekarang - $tahun_kendaraan) <= 5) {
            $lampu_kanan_kiri = rand(30, 35);
            $dev_kanan = $this->random(0.1, 0.34);
            $dev_kiri = $this->random(1, 1.09);
        } else {
            $lampu_kanan_kiri = rand(14, 20);
            $dev_kanan = $this->random(0.1, 0.34);
            $dev_kiri = $this->random(1, 1.09);
        }
        $data['lampu_kanan'] = $lampu_kanan_kiri;
        $data['lampu_kiri'] = $lampu_kanan_kiri;
        $data['dev_kanan'] = $dev_kanan;
        $data['dev_kiri'] = $dev_kiri;

        echo json_encode($data);
    }

    public function random($min, $max, $mul = 10)
    {
        return mt_rand($min * $mul, $max * $mul) / $mul;
    }

    public function actionListGrid()
    {
        $posisi = Yii::app()->session['posisi_cis'];
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        //        $criteria->addCondition("posisi = '$posisi'");
        $result = VLampu::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataJson[] = array(
                "id_kendaraan" => $p->id_kendaraan,
                "id_hasil_uji" => $p->id_hasil_uji,
                //                "posisi" => $p->posisi,
                "no_antrian" => $p->no_antrian,
                "no_uji" => $p->no_uji,
                "no_kendaraan" => $p->no_kendaraan,
                "merk" => $p->merk,
                "tipe" => $p->tipe,
                "tahun" => $p->tahun,
                "bahan_bakar" => $p->bahan_bakar,
                "nm_komersil" => $p->nm_komersil,
                "karoseri_jenis" => $p->karoseri_jenis,
                "nm_uji" => $p->nm_uji,
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => VLampu::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionProses()
    {
        $idhasil = $_POST['id_hasil_uji'];
        $variabel = $_POST['variabel'];
        $username = $_POST['username'];

        $query = "select update_lampu('$variabel',$idhasil,'$username');";
        Yii::app()->db->createCommand($query)->execute();
    }
}
