<?php

class DefaultController extends Controller
{

    public function filters()
    {
        return array(
            'Rights', // perform access control for CRUD operations
        );
    }

    public function actionIndex()
    {
        $this->pageTitle = 'MASTER DATA';
        $this->render('index');
    }

    /* =====================================================================
     * KEPALA DINAS
      ===================================================================== */

    public function actionKepaladinasListGrid()
    {
        $nama = strtolower($_POST['nama']);
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'nama';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        if (!empty($penguji)) {
            $criteria->addCondition('lower(nama) like \'%' . $nama . '%\'');
        }
        $result = TblKepalaDinas::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataJson[] = array(
                "delete" => $p->id_kepala_dinas,
                "id_kepala_dinas" => $p->id_kepala_dinas . "|kepaladinas",
                "nama" => $p->nama,
                "nip" => $p->nip,
                "pangkat" => $p->pangkat
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => TblKepalaDinas::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionGetDetailEditKepalaDinas()
    {
        $id = $_POST['id'];
        $result = TblKepalaDinas::model()->findByPk($id);
        $data['id'] = $result->id_kepala_dinas;
        $data['nama'] = $result->nama;
        $data['nip'] = $result->nip;
        $data['pangkat'] = $result->pangkat;
        echo json_encode($data);
    }

    public function actionSaveKepalaDinas()
    {
        $id = $_POST['id_kepaladinas'];
        $nip = strtoupper($_POST['nip']);
        $nama = strtoupper($_POST['kepaladinas']);
        $pangkat = $_POST['pangkat'];
        if (empty($id)) {
            $data = new TblKepalaDinas();
            $data->nip = $nip;
            $data->pangkat = $pangkat;
            $data->nama = $nama;
            $data->save();
        } else {
            $sql = "update tbl_kepala_dinas set nip='$nip', pangkat='$pangkat',nama='$nama' where id_kepala_dinas=$id";
            Yii::app()->db->createCommand($sql)->execute();
        }
    }

    public function actionDeleteKepalaDinas()
    {
        $id = $_POST['id'];
        $sql = "DELETE FROM tbl_kepala_dinas WHERE id_kepala_dinas=$id";
        Yii::app()->db->createCommand($sql)->execute();
    }

    /* =====================================================================
     * PENGUJI
      ===================================================================== */

    public function actionPengujiListGrid()
    {
        $penguji = strtolower($_POST['penguji']);
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'nama_penguji';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        if (!empty($penguji)) {
            $criteria->addCondition('lower(nama_penguji) like \'%' . $penguji . '%\'');
        }
        $result = TblNamaPenguji::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataJson[] = array(
                "id_nama_penguji" => $p->id_nama_penguji . "|penguji",
                "nama_penguji" => $p->nama_penguji,
                "nrp" => $p->nrp,
                "jabatan" => $p->jabatan
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => TblNamaPenguji::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionGetDetailEditPenguji()
    {
        $id = $_POST['id'];
        $result = TblNamaPenguji::model()->findByPk($id);
        $data['id'] = $result->id_nama_penguji;
        $data['nama'] = $result->nama_penguji;
        $data['nrp'] = $result->nrp;
        $data['jabatan'] = $result->jabatan;
        $data['status_penguji'] = $result->status_penguji;
        echo json_encode($data);
    }

    public function actionSavePenguji()
    {
        $id = $_POST['id_penguji'];
        $nrp = strtoupper($_POST['nrp']);
        $penguji = strtoupper($_POST['penguji']);
        $jabatan = $_POST['jabatan'];
        if (empty($id)) {
            $data = new TblNamaPenguji();
        } else {
            $data = TblNamaPenguji::model()->findByPk($id);
        }
        $data->nrp = $nrp;
        $data->jabatan = $jabatan;
        $data->nama_penguji = $penguji;
        if (!empty($_POST['ttd'])) {
            $data->status_penguji = true;
        } else {
            $data->status_penguji = false;
        }
        $data->save();
    }

    /* =====================================================================
     * USER
      ===================================================================== */

    public function actionUserListGrid()
    {
        $username = strtolower($_POST['user']);
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'user_name';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        if (!empty($username)) {
            $criteria->addCondition('lower(user_name) like \'%' . $username . '%\'');
        }
        $result = VUser::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataJson[] = array(
                "id_user" => $p->id_user . "|" . $p->itemname,
                "user_name" => $p->user_name,
                "itemname" => $p->itemname
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => VUser::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionDeleteUser()
    {
        $id = $_POST['id'];
        $itemname = $_POST['itemname'];
        $sql = "DELETE FROM authassignment WHERE userid=$id AND itemname='$itemname'";
        Yii::app()->db->createCommand($sql)->execute();

        $auth = Authassignment::model()->findAllByAttributes(array('userid' => $id));
        $count = count($auth);
        if ($count == 0) {
            $sql = "DELETE FROM tbl_user WHERE id_user=$id";
            Yii::app()->db->createCommand($sql)->execute();
        }
    }

    public function actionSaveUser()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hak_akses = $_POST['hak_akses'];
        $dtUser = TblUser::model()->findByAttributes(array('user_name' => $username));
        if (empty($dtUser)) {
            $dataUser = new TblUser();
            $dataUser->user_name = $username;
            $dataUser->user_pass = md5($password);
            if ($hak_akses == 'Penguji') {
                $dataUser->prauji = true;
                $dataUser->emisi = true;
                $dataUser->pitlift = true;
                $dataUser->lampu = true;
                $dataUser->rem = true;
                $dataUser->gandengan = true;
                $dataUser->position_id = 7;
                $dataUser->alat_uji = 'CIS 2';
            }
            if ($dataUser->save()) {
                $criteria = new CDbCriteria();
                $criteria->order = 'id_user DESC';
                $dtUser = TblUser::model()->find($criteria);
                $id_user = $dtUser->id_user;
                $sql = "INSERT INTO authassignment(userid,itemname) VALUES ($id_user,'$hak_akses')";
                Yii::app()->db->createCommand($sql)->execute();
            }
        } else {
            $id_user = $dtUser->id_user;
            $sql = "INSERT INTO authassignment(userid,itemname) VALUES ($id_user,'$hak_akses')";
            Yii::app()->db->createCommand($sql)->execute();
        }
    }

    /* =====================================================================
     * NAMA KOMERSIL
      ===================================================================== */

    public function actionKomersilListGrid()
    {
        $komersil = strtolower($_POST['komersil']);
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'nm_komersil';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        if (!empty($komersil)) {
            $criteria->addCondition('lower(nm_komersil) like \'%' . $komersil . '%\'');
        }
        $result = TblNmKomersil::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataJson[] = array(
                "id_komersil" => $p->id_nm_komersil . "|komersil",
                "komersil" => $p->nm_komersil
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => TblNmKomersil::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionGetDetailEditKomersil()
    {
        $id = $_POST['id'];
        $result = TblNmKomersil::model()->findByPk($id);
        $data['id'] = $result->id_nm_komersil;
        $data['nama'] = $result->nm_komersil;
        echo json_encode($data);
    }

    public function actionSaveKomersil()
    {
        $id = $_POST['id_komersil'];
        $komersil = strtoupper($_POST['komersil']);
        if (empty($id)) {
            $data = new TblNmKomersil();
        } else {
            $data = TblNmKomersil::model()->findByPk($id);
        }
        $data->nm_komersil = $komersil;
        $data->save();
    }

    /* =====================================================================
     * JENIS KAROSERI
      ===================================================================== */

    public function actionKaroseriListGrid()
    {
        $karoseri = strtolower($_POST['karoseri']);
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kar_jenis';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        if (!empty($karoseri)) {
            $criteria->addCondition('lower(kar_jenis) like \'%' . $karoseri . '%\'');
        }
        $result = TblKarJenis::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataJson[] = array(
                "id_karoseri" => $p->id_kar_jenis . "|karoseri",
                "karoseri" => $p->kar_jenis
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => TblKarJenis::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionGetDetailEditKaroseri()
    {
        $id = $_POST['id'];
        $result = TblKarJenis::model()->findByPk($id);
        $data['id'] = $result->id_kar_jenis;
        $data['nama'] = $result->kar_jenis;
        echo json_encode($data);
    }

    public function actionSaveKaroseri()
    {
        $kondisi = $_POST['kondisi'];
        $id = $_POST['id_karoseri'];
        $karoseri = strtoupper($_POST['karoseri']);
        if ($kondisi == 'new') {
            $data = new TblKarJenis();
        } else {
            $data = TblKarJenis::model()->findByPk($id);
        }
        $data->kar_jenis = $karoseri;
        $data->save();
    }

    /* =====================================================================
     * BAHAN UTAMA
      ===================================================================== */

    public function actionBahanListGrid()
    {
        $bahan = strtolower($_POST['bahan']);
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kar_bahan';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        if (!empty($bahan)) {
            $criteria->addCondition('lower(kar_bahan) like \'%' . $bahan . '%\'');
        }
        $result = TblKarBahan::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataJson[] = array(
                "id_bahan" => $p->id_kar_bahan . "|bahan",
                "bahan" => $p->kar_bahan
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => TblKarBahan::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionGetDetailEditBahan()
    {
        $id = $_POST['id'];
        $result = TblKarBahan::model()->findByPk($id);
        $data['id'] = $result->id_kar_bahan;
        $data['nama'] = $result->kar_bahan;
        echo json_encode($data);
    }

    public function actionSaveBahan()
    {
        $id = $_POST['id_bahan'];
        $bahan = strtoupper($_POST['bahan']);
        if (empty($id)) {
            $data = new TblKarBahan();
        } else {
            $data = TblKarBahan::model()->findByPk($id);
        }
        // if (empty($id)) {
        //     $data = new TblKarBahan();
        //     $data->kar_bahan = $bahan;
        //     $data->save();
        // } else {
        //     $sql = "UPDATE tbl_kar_bahan SET kar_bahan='$bahan' WHERE id_kar_bahan=$id";
        //     Yii::app()->db->createCommand($sql)->execute();
        // }
        $data->kar_bahan = $bahan;
        $data->save();
    }

    /* =====================================================================
     * BAHAN UTAMA
      ===================================================================== */

    public function actionMerkListGrid()
    {
        $merk = strtolower($_POST['merk']);
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'merk';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        if (!empty($merk)) {
            $criteria->addCondition('lower(merk) like \'%' . $merk . '%\'');
        }
        $result = TblMerk::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataJson[] = array(
                "id_merk" => $p->id_merk . "|merk",
                "merk" => $p->merk
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => TblMerk::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionGetDetailEditMerk()
    {
        $id = $_POST['id'];
        $result = TblMerk::model()->findByPk($id);
        $data['id'] = $result->id_merk;
        $data['nama'] = $result->merk;
        echo json_encode($data);
    }

    public function actionSaveMerk()
    {
        $id = $_POST['id_merk'];
        $merk = strtoupper($_POST['merk']);
        if (empty($id)) {
            $data = new TblMerk();
        } else {
            $data = TblMerk::model()->findByPk($id);
        }
        $data->merk = $merk;
        $data->save();
    }
}
