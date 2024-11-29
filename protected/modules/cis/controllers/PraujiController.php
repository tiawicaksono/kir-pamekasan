<?php

class PraujiController extends Controller
{

    public $layout = '//layouts/main_top';

    public function filters()
    {
        return array(
            'Rights', // perform access control for CRUD operations
        );
    }

    public function actionListGrid()
    {
        $search = $_POST['textSearch'];
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        if (!empty($search)) {
            $criteria->addCondition("(replace(LOWER(no_uji),' ','') like replace(LOWER('%" . $search . "%'),' ','') OR replace(LOWER(no_kendaraan),' ','') like replace(LOWER('%" . $search . "%'),' ',''))");
        }
        $result = VPraUji::model()->findAll($criteria);
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
                "karoseri_bahan" => $p->karoseri_bahan,
                "karoseri_jenis" => $p->karoseri_jenis,
                "nm_uji" => $p->nm_uji,
                "warna" => $p->warna,
                "tempat_duduk" => $p->karoseri_duduk,
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => VPraUji::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionProses()
    {
        $idhasil = $_POST['idhasil'];
        $variabel = $_POST['variabel'];
        $posisi = $_POST['posisi'];
        $username = $_POST['username'];

        $query = "select update_padprauji('$variabel',$idhasil,'$username');";
        Yii::app()->db->createCommand($query)->execute();
    }

    public function actionLoadImage()
    {
        $id_kendaraan = $_POST['idkendaraan'];
        $query = "select img_depan,img_belakang,img_kanan,img_kiri from tbl_hasil_uji where id_kendaraan=$id_kendaraan order by jdatang desc limit 1 offset 1";
        $result = Yii::app()->db->createCommand($query)->queryRow();
        $data['img_depan'] = $result['img_depan'];
        $data['img_kanan'] = $result['img_kanan'];
        $data['img_kiri'] = $result['img_kiri'];
        $data['img_belakang'] = $result['img_belakang'];
        echo json_encode($data);
    }

    public function actionLainListGrid()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        $criteria->addCondition("kd_lulus like ('UM%')");
        $result = VKelulusan::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            $dataJson[] = array(
                "kd_lulus" => $p->kd_lulus,
                "kelulusan" => $p->kelulusan,
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => VKelulusan::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionUploadImage()
    {
        $id_hasil_uji_prauji = $_POST['id_hasil_uji_prauji'];
        require_once Yii::app()->basePath . '/extensions/jquery.fileuploader.php';
        // initialize FileUploader
        $dir = Yii::getPathOfAlias('webroot') . '/downloadsfile/';
        $FileUploader = new FileUploader('files', array(
            'uploadDir' => $dir,
            'title' => 'name',
            'editor' => array(
                // image maxWidth in pixels {null, Number}
                'maxWidth' => 600,
                // image maxHeight in pixels {null, Number}
                'maxHeight' => 600,
                // crop image {Boolean}
                'crop' => true,
                // image quality after save {Number}
                'quality' => 100
            ),
        ));
        // call to upload the files
        $data = $FileUploader->upload();
        // if uploaded and success
        if ($data['isSuccess'] && !empty($data['files'])) {
            $uploadedFiles = $data['files'];

            if (empty($uploadedFiles[0]['name'])) {
                $base64_img1 = '';
            } else {
                $img1 = $uploadedFiles[0]['name'];
                $ext = $uploadedFiles[0]['extension'];
                if ($ext == 'jpeg' || $ext == 'JPEG' || $ext == 'jpg' || $ext == 'JPG') {
                    $image = imagecreatefromjpeg($dir . $img1);
                } elseif ($ext == 'png' || $ext == 'PNG') {
                    $image = imagecreatefrompng($dir . $img1);
                }

                $image = imagescale($image, 600);
                ob_start();
                imagejpeg($image);
                $contents = ob_get_contents();
                ob_end_clean();

                $base64_img1 = base64_encode($contents);
                unlink($dir . $img1);
            }

            if (empty($uploadedFiles[1]['name'])) {
                $base64_img2 = '';
            } else {
                $img2 = $uploadedFiles[1]['name'];

                $ext = $uploadedFiles[1]['extension'];
                if ($ext == 'jpeg' || $ext == 'JPEG' || $ext == 'jpg' || $ext == 'JPG') {
                    $image = imagecreatefromjpeg($dir . $img2);
                } elseif ($ext == 'png' || $ext == 'PNG') {
                    $image = imagecreatefrompng($dir . $img2);
                }

                $image = imagescale($image, 600);
                ob_start();
                imagejpeg($image);
                $contents = ob_get_contents();
                ob_end_clean();

                $base64_img2 = base64_encode($contents);
                unlink($dir . $img2);
            }

            if (empty($uploadedFiles[2]['name'])) {
                $base64_img3 = '';
            } else {
                $img3 = $uploadedFiles[2]['name'];

                $ext = $uploadedFiles[2]['extension'];
                if ($ext == 'jpeg' || $ext == 'JPEG' || $ext == 'jpg' || $ext == 'JPG') {
                    $image = imagecreatefromjpeg($dir . $img3);
                } elseif ($ext == 'png' || $ext == 'PNG') {
                    $image = imagecreatefrompng($dir . $img3);
                }

                $image = imagescale($image, 600);
                ob_start();
                imagejpeg($image);
                $contents = ob_get_contents();
                ob_end_clean();

                $base64_img3 = base64_encode($contents);
                unlink($dir . $img3);
            }

            if (empty($uploadedFiles[3]['name'])) {
                $base64_img4 = '';
            } else {
                $img4 = $uploadedFiles[3]['name'];

                $ext = $uploadedFiles[3]['extension'];
                if ($ext == 'jpeg' || $ext == 'JPEG' || $ext == 'jpg' || $ext == 'JPG') {
                    $image = imagecreatefromjpeg($dir . $img4);
                } elseif ($ext == 'png' || $ext == 'PNG') {
                    $image = imagecreatefrompng($dir . $img4);
                }

                $image = imagescale($image, 600);
                ob_start();
                imagejpeg($image);
                $contents = ob_get_contents();
                ob_end_clean();

                $base64_img4 = base64_encode($contents);
                unlink($dir . $img4);
            }

            $query = "update tbl_hasil_uji set img_depan = '$base64_img1', img_kanan = '$base64_img2', img_belakang = '$base64_img3', img_kiri = '$base64_img4' where id_hasil_uji = $id_hasil_uji_prauji";
            $result = Yii::app()->db->createCommand($query)->execute();
        }
    }

    public function actionSaveCapture()
    {
        $idhasil = $_POST['id_hasil_uji'];
        /**
         * PROSES CAPTURE
         */
        $ip_depan = 'http://192.168.1.10';
        $ch_depan = curl_init($ip_depan);
        curl_setopt($ch_depan, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch_depan, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_depan, CURLOPT_RETURNTRANSFER, true);
        $data_depan = curl_exec($ch_depan);
        $httpdcode_depan = curl_getinfo($ch_depan, CURLINFO_HTTP_CODE);
        curl_close($ch_depan);
        if ($httpdcode_depan != 0) {
            $gmb_depan = file_get_contents('http://admin:1234567890@192.168.1.10/cgi-bin/snapshot.cgi?loginuse=admin&loginpas=1234567890');
            $img_depan = base64_encode($gmb_depan);
        } else {
            $img_depan = '';
        }

        $ip_belakang = 'http://192.168.1.12';
        $ch_belakang = curl_init($ip_belakang);
        curl_setopt($ch_belakang, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch_belakang, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_belakang, CURLOPT_RETURNTRANSFER, true);
        $data_belakang = curl_exec($ch_belakang);
        $httpdcode_belakang = curl_getinfo($ch_belakang, CURLINFO_HTTP_CODE);
        curl_close($ch_belakang);
        if ($httpdcode_belakang != 0) {
            $gmb_belakang = file_get_contents('http://admin:1234567890@192.168.1.12/cgi-bin/snapshot.cgi?loginuse=admin&loginpas=1234567890');
            $img_belakang = base64_encode($gmb_belakang);
        } else {
            $img_belakang = '';
        }

        $ip_kanan = 'http://192.168.1.13';
        $ch_kanan = curl_init($ip_kanan);
        curl_setopt($ch_kanan, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch_kanan, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_kanan, CURLOPT_RETURNTRANSFER, true);
        $data_kanan = curl_exec($ch_kanan);
        $httpdcode_kanan = curl_getinfo($ch_kanan, CURLINFO_HTTP_CODE);
        curl_close($ch_kanan);
        if ($httpdcode_kanan != 0) {
            $gmb_kanan = file_get_contents('http://admin:1234567890@192.168.1.13/cgi-bin/snapshot.cgi?loginuse=admin&loginpas=1234567890');
            $img_kanan = base64_encode($gmb_kanan);
        } else {
            $img_kanan = '';
        }

        $ip_kiri = 'http://192.168.1.11';
        $ch_kiri = curl_init($ip_kiri);
        curl_setopt($ch_kiri, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch_kiri, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_kiri, CURLOPT_RETURNTRANSFER, true);
        $data_kiri = curl_exec($ch_kiri);
        $httpdcode_kiri = curl_getinfo($ch_kiri, CURLINFO_HTTP_CODE);
        curl_close($ch_kiri);
        if ($httpdcode_kiri != 0) {
            $gmb_kiri = file_get_contents('http://admin:1234567890@192.168.1.11/cgi-bin/snapshot.cgi?loginuse=admin&loginpas=1234567890');
            $img_kiri = base64_encode($gmb_kiri);
        } else {
            $img_kiri = '';
        }

        $proses = "UPDATE tbl_hasil_uji set img_depan='" . $img_depan . "',img_belakang='" . $img_belakang . "',img_kiri='" . $img_kanan . "',img_kanan='" . $img_kanan . "' where id_hasil_uji=" . $idhasil;
        Yii::app()->db->createCommand($proses)->execute();

        $data['img_depan'] = $img_depan;
        $data['img_belakang'] = $img_belakang;
        $data['img_kanan'] = $img_kanan;
        $data['img_kiri'] = $img_kanan;
        echo json_encode($data);
    }
}
