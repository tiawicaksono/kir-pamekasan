<?php

class DefaultController extends Controller {

//    public $layout = '//layouts/main_guru';
//    public function filters() {
//        return array(
//            'Rights',
//        );
//    }

    public function actionIndex() {
        $this->actionHome();
    }

    /**
     * Displays the login page
     */
    public function actionFormChangePassword() {
        $this->layout = '//layouts/main_top';
        $this->render('form_change_password');
    }

    public function actionChangePassword() {
        $id = $_POST['employee_id'];
        $new_password = md5($_POST['new_password']);
        $sql = "UPDATE tbl_user SET user_pass = '$new_password' WHERE id_user = $id ";
        Yii::app()->db->createCommand($sql)->execute();
    }

    public function actionLogin() {
        $this->layout = '/';
        $model = new LoginForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login())
//                $this->redirect(Yii::app()->user->returnUrl);
                $this->redirect('http://' . $_SERVER['SERVER_NAME'] . '/pkb/cis');
        }
        $this->render('main_login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl . 'cis/');
    }

    public function actionHome() {
        if (Yii::app()->user->isGuest) {
//            echo 'a';exit;
            $this->actionLogin();
        } else {
            $bagian_cis = Yii::app()->session['position_id'];
            if (Yii::app()->session['position_id'] != 7) {
                $this->actionLogin();
            } else {
                $this->redirect(Yii::app()->homeUrl . 'cis/Pengujian');
//                if ($bagian_cis == 'prauji') {
//                    $this->redirect(Yii::app()->homeUrl . 'cisbaru/prauji');
//                } else if ($bagian_cis == 'emisi') {
//                    $this->redirect(Yii::app()->homeUrl . 'cisbaru/emisi');
//                } else if ($bagian_cis == 'pitlift') {
//                    $this->redirect(Yii::app()->homeUrl . 'cisbaru/pitlift');
//                } else if ($bagian_cis == 'lampu') {
//                    $this->redirect(Yii::app()->homeUrl . 'cisbaru/lampu');
//                } else if ($bagian_cis == 'rem') {
//                    $this->redirect(Yii::app()->homeUrl . 'cisbaru/rem');
//                }
            }
        }
    }

    public function actionLoadTl() {
        $id_kendaraan = $_POST['idkendaraan'];
        $query = "select id_hasil_uji from tbl_hasil_uji where id_kendaraan=$id_kendaraan order by jdatang desc limit 1 offset 1";
        $result = Yii::app()->db->createCommand($query)->queryRow();
        $query2 = "select id_hasil_uji from tbl_hasil_uji where id_kendaraan=$id_kendaraan order by jdatang desc limit 1";
        $result2 = Yii::app()->db->createCommand($query2)->queryRow();
        $dataTl = '';
        $arListKelulusan2 = TblListKelulusan::model()->findAllByAttributes(array('id_hasil_uji' => $result2['id_hasil_uji']));
        $kolom = 2;
        if (empty($arListKelulusan2)) {
            $arListKelulusan = TblListKelulusan::model()->findAllByAttributes(array('id_hasil_uji' => $result['id_hasil_uji']));
            if (!empty($arListKelulusan)) {
                $i = 1;
                foreach ($arListKelulusan as $listKelulusan):
                    if (($i) % $kolom == 1) {
                        $dataTl .= '<div class="row">';
                    }
                    $dataTl .= "<div class='col-md-6 col-sm-6'><i class='fa fa-fw fa-check-square'></i> [" . $listKelulusan->input_tl . "] " . $listKelulusan->kelulusan . "</div>";
                    if (($i) % $kolom == 0) {
                        $dataTl .= '</div>';
                    }
                    $i++;
                endforeach;
            }
        } else {
            $i = 1;
            foreach ($arListKelulusan2 as $listKelulusan):
                if (($i) % $kolom == 1) {
                    $dataTl .= '<div class="row">';
                }
                $dataTl .= "<div class='col-md-6 col-sm-6'><i class='fa fa-fw fa-check-square'></i> [" . $listKelulusan->input_tl . "] " . $listKelulusan->kelulusan . "</div>";
                if (($i) % $kolom == 0) {
                    $dataTl .= '</div>';
                }
                $i++;
            endforeach;
        }
        $data['dataTl'] = $dataTl;
        echo json_encode($data);
    }
}
