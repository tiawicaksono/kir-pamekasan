<?php

class EmisiController extends Controller
{

    public $layout = '//layouts/main_top';

    public function filters()
    {
        return array(
            'Rights', // perform access control for CRUD operations
        );
    }

    //    public function actionIndex() {
    //        $this->pageTitle = 'Emisi';
    //        $this->render('index');
    //    }

    public function actionReloadData()
    {
        $tahun_kendaraan = $_POST['tahun_kendaraan'];
        $tahun_sekarang = date('Y');

        if ($tahun_kendaraan < 2010) {
            $emdiesel = rand(0, 65);
        } else if ($tahun_kendaraan >= 2010 && $tahun_kendaraan <= 2021) {
            $emdiesel = rand(0, 40);
        } else if ($tahun_kendaraan > 2021) {
            $emdiesel = rand(0, 30);
        }

        if ($tahun_kendaraan < 2007) {
            $emco = $this->random(0, 4);
            $emhc = rand(0, 1000);
        } else if ($tahun_kendaraan >= 2007 && $tahun_kendaraan <= 2018) {
            $emco = $this->random(0, 1);
            $emhc = rand(0, 150);
        } else if ($tahun_kendaraan > 2018) {
            $emco = rand(0, 0.5);
            $emhc = rand(0, 100);
        }
        $data['solar'] = $emdiesel;
        $data['ems_co'] = $emco;
        $data['ems_hc'] = $emhc;

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
        $result = VSmoke::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataJson[] = array(
                "id_kendaraan" => $p->id_kendaraan,
                "id_hasil_uji" => $p->id_hasil_uji,
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
                'total' => VSmoke::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionProses()
    {
        $idhasil = $_POST['id_hasil_uji'];
        $variabel = $_POST['variabel'];
        $posisi = $_POST['cis'];
        $username = $_POST['username'];
        $username = Yii::app()->session['username'];
        $query  = "select update_smoke('$variabel',$idhasil,'$username')";
        Yii::app()->db->createCommand($query)->execute();
    }
}
