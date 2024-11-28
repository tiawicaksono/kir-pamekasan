<?php

class PengujianController extends Controller
{

    public $layout = '//layouts/main_top';
    public function filters()
    {
        return array(
            'Rights',
        );
    }

    public function actionIndex()
    {
        $this->render('pengujian');
    }

    public function actionFormChangePassword()
    {
        $this->render('form_change_password');
    }

    public function actionChangePassword()
    {
        $id = $_POST['employee_id'];
        $new_password = md5(strtolower($_POST['new_password']));
        $sql = "UPDATE tbl_employee SET password = '$new_password' WHERE employee_id = $id ";
        Yii::app()->db->createCommand($sql)->execute();
    }

    public function actionReplaceFile()
    {
        $this->renderPartial('replace_file');
    }
}
