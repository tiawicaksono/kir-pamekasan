<?php

class SiteController extends Controller
{

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    //    public function init() {
    //        $this->pageTitle = 'SICTI - Inventory Swap';
    //        $this->defaultAction = 'swapList';
    //    }
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->pageTitle = 'WELCOME';
        if (Yii::app()->user->isGuest) {
            $this->actionLogin();
        } else {
            //            $this->render('welcome');
            $this->redirect(array('/retribusi'));
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $this->layout = '/';
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('main_login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * HOME
     * CHANGE PASSWORD
     * Report
     */
    public function actionDisplay()
    {
        $this->render('index');
    }

    public function actionHome()
    {
        $this->layout = '//layouts/main_android';
        $this->pageTitle = 'DASHBOARD';
        $year = Yii::app()->params['tahunGrafik'];
        //        $scheduleTestTaxi = TblJadwalUjiTaksi::model()->viewScheduleData();
        //TOTAL HEADER
        $tgl = date('d-M-y');
        $totalRetribusi = TblRetribusi::model()->totalRetribusiPerHari($tgl);
        $totalKendaraanU = TblDaftar::model()->totalKedatanganKendaraan($tgl, 'UMUM');
        $totalKendaraanBu = TblDaftar::model()->totalKedatanganKendaraan($tgl, 'TIDAK UMUM');
        $totalKendaraan = $totalKendaraanU + $totalKendaraanBu;

        $mobilBarangU = TblDaftar::model()->totalKendaraan(0, $tgl, 'UMUM');
        $mobilBarangBu = TblDaftar::model()->totalKendaraan(0, $tgl, 'TIDAK UMUM');
        $mobilPenumpangU = TblDaftar::model()->totalKendaraan(1, $tgl, 'UMUM');
        $mobilPenumpangBu = TblDaftar::model()->totalKendaraan(1, $tgl, 'TIDAK UMUM');
        $mobilBisU = TblDaftar::model()->totalKendaraan(2, $tgl, 'UMUM');
        $mobilBisBu = TblDaftar::model()->totalKendaraan(2, $tgl, 'TIDAK UMUM');
        $mobilKhususU = TblDaftar::model()->totalKendaraan(3, $tgl, 'UMUM');
        $mobilKhususBu = TblDaftar::model()->totalKendaraan(3, $tgl, 'TIDAK UMUM');
        $kgU = TblDaftar::model()->totalKendaraan(4, $tgl, 'UMUM');
        $kgBu = TblDaftar::model()->totalKendaraan(4, $tgl, 'TIDAK UMUM');
        $ktU = TblDaftar::model()->totalKendaraan(5, $tgl, 'UMUM');
        $ktBu = TblDaftar::model()->totalKendaraan(5, $tgl, 'TIDAK UMUM');

        //TOTAL KENDARAAN LULUS
        $totalLulusU = TblDaftar::model()->totalKelulusanKendaraan('true', $tgl, 'UMUM');
        $totalLulusBu = TblDaftar::model()->totalKelulusanKendaraan('true', $tgl, 'TIDAK UMUM');
        //TOTAL KENDARAAN TIDAK LULUS
        $totalTidakLulusU = TblDaftar::model()->totalKelulusanKendaraan('false', $tgl, 'UMUM');
        $totalTidakLulusBu = TblDaftar::model()->totalKelulusanKendaraan('false', $tgl, 'TIDAK UMUM');
        //TL&TD
        $totalTlTdU = TblDaftar::model()->totalTlTd($tgl, 'UMUM');
        $totalTlTdBu = TblDaftar::model()->totalTlTd($tgl, 'TIDAK UMUM');

        $this->render('index', array(
            //            'dataEmployee' => $employee,
            //            'schedule' => $scheduleTestTaxi,
            'year' => $year,
            'totalRetribusi' => number_format($totalRetribusi['total']),
            'totalKendaraan' => $totalKendaraan,
            'totalLulusU' => $totalLulusU,
            'totalTidakLulusU' => $totalTidakLulusU,
            'totalLulusBu' => $totalLulusBu,
            'totalTidakLulusBu' => $totalTidakLulusBu,
            'mobilBarangU' => $mobilBarangU,
            'mobilBarangBu' => $mobilBarangBu,
            'mobilPenumpangU' => $mobilPenumpangU,
            'mobilPenumpangBu' => $mobilPenumpangBu,
            'mobilBisU' => $mobilBisU,
            'mobilBisBu' => $mobilBisBu,
            'mobilKhususU' => $mobilKhususU,
            'mobilKhususBu' => $mobilKhususBu,
            'kgU' => $kgU,
            'kgBu' => $kgBu,
            'ktU' => $ktU,
            'ktBu' => $ktBu,
            'mobilDatangU' => $totalKendaraanU,
            'mobilDatangBu' => $totalKendaraanBu,
            'totalTlTdU' => $totalTlTdU,
            'totalTlTdBu' => $totalTlTdBu,
        ));
    }

    public function actionA()
    {
        $tgl = date('d-M-y');
        //$tgl = '04-Dec-19';
        $totalRetribusi = TblRetribusi::model()->totalRetribusiPerHari($tgl);
        echo number_format($totalRetribusi['total']);
    }

    public function actionB()
    {
        $tgl = date('d-M-y');
        //$tgl = '04-Dec-19';
        $totalKendaraanU = TblDaftar::model()->totalKedatanganKendaraan($tgl, 'UMUM');
        $totalKendaraanBu = TblDaftar::model()->totalKedatanganKendaraan($tgl, 'TIDAK UMUM');
        echo $totalKendaraan = $totalKendaraanU + $totalKendaraanBu;
    }

    public function actionC()
    {
        $tgl = date('d-M-y');
        //$tgl = '04-Dec-19';
        $totalKendaraanU = TblDaftar::model()->totalKedatanganKendaraan($tgl, 'UMUM');
        $totalKendaraanBu = TblDaftar::model()->totalKedatanganKendaraan($tgl, 'TIDAK UMUM');
        $mobilBarangU = TblDaftar::model()->totalKendaraan(0, $tgl, 'UMUM');
        $mobilBarangBu = TblDaftar::model()->totalKendaraan(0, $tgl, 'TIDAK UMUM');
        $mobilPenumpangU = TblDaftar::model()->totalKendaraan(1, $tgl, 'UMUM');
        $mobilPenumpangBu = TblDaftar::model()->totalKendaraan(1, $tgl, 'TIDAK UMUM');
        $mobilBisU = TblDaftar::model()->totalKendaraan(2, $tgl, 'UMUM');
        $mobilBisBu = TblDaftar::model()->totalKendaraan(2, $tgl, 'TIDAK UMUM');
        $mobilKhususU = TblDaftar::model()->totalKendaraan(3, $tgl, 'UMUM');
        $mobilKhususBu = TblDaftar::model()->totalKendaraan(3, $tgl, 'TIDAK UMUM');
        $kgU = TblDaftar::model()->totalKendaraan(4, $tgl, 'UMUM');
        $kgBu = TblDaftar::model()->totalKendaraan(4, $tgl, 'TIDAK UMUM');
        $ktU = TblDaftar::model()->totalKendaraan(5, $tgl, 'UMUM');
        $ktBu = TblDaftar::model()->totalKendaraan(5, $tgl, 'TIDAK UMUM');

        //TOTAL KENDARAAN LULUS
        $totalLulusU = TblDaftar::model()->totalKelulusanKendaraan('true', $tgl, 'UMUM');
        $totalLulusBu = TblDaftar::model()->totalKelulusanKendaraan('true', $tgl, 'TIDAK UMUM');
        //TOTAL KENDARAAN TIDAK LULUS
        $totalTidakLulusU = TblDaftar::model()->totalKelulusanKendaraan('false', $tgl, 'UMUM');
        $totalTidakLulusBu = TblDaftar::model()->totalKelulusanKendaraan('false', $tgl, 'TIDAK UMUM');
        //TL&TD
        $totalTlTdU = TblDaftar::model()->totalTlTd($tgl, 'UMUM');
        $totalTlTdBu = TblDaftar::model()->totalTlTd($tgl, 'TIDAK UMUM');
        $this->renderPartial('data_kendaraan', array(
            'totalLulusU' => $totalLulusU,
            'totalTidakLulusU' => $totalTidakLulusU,
            'totalLulusBu' => $totalLulusBu,
            'totalTidakLulusBu' => $totalTidakLulusBu,
            'mobilBarangU' => $mobilBarangU,
            'mobilBarangBu' => $mobilBarangBu,
            'mobilPenumpangU' => $mobilPenumpangU,
            'mobilPenumpangBu' => $mobilPenumpangBu,
            'mobilBisU' => $mobilBisU,
            'mobilBisBu' => $mobilBisBu,
            'mobilKhususU' => $mobilKhususU,
            'mobilKhususBu' => $mobilKhususBu,
            'kgU' => $kgU,
            'kgBu' => $kgBu,
            'ktU' => $ktU,
            'ktBu' => $ktBu,
            'mobilDatangU' => $totalKendaraanU,
            'mobilDatangBu' => $totalKendaraanBu,
            'totalTlTdU' => $totalTlTdU,
            'totalTlTdBu' => $totalTlTdBu,
        ));
    }

    public function actionFormChangePassword()
    {
        $this->render('form_change_password');
    }

    public function actionChangePassword()
    {
        $id = $_POST['employee_id'];
        $new_password = md5(strtolower($_POST['new_password']));
        $sql = "UPDATE tbl_user SET user_pass = '$new_password' WHERE id_user = $id ";
        Yii::app()->db->createCommand($sql)->execute();
    }

    public function actionFaspay()
    {
        $va = $_GET['VA'];
        $signature = $_GET['signature'];
        $type = $_GET['type'];
        $dataRetribusi = VValidasi::model()->findByAttributes(array('virtual_account' => $va));
        $data['response'] = 'VA Static Response';
        $data['va_number'] = $va;
        $data['amount'] = $dataRetribusi->total;
        $data['cust_name'] = $dataRetribusi->nama_pemilik;
        if (count($dataRetribusi) == 0) {
            $data['response_code'] = '01';
        } else {
            $data['response_code'] = '00';
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function actionConfirmation()
    {
        $xml = urldecode(file_get_contents('php://input'));
        $notification = simplexml_load_string($xml);
        $trx_id = $notification->trx_id;
        $merchant_id = $notification->merchant_id;
        $merchant_name = $notification->merchant;
        $order_id = $notification->bill_no;
        $payment_reff = $notification->payment_reff;
        $payment_status = $notification->payment_status_code;
        $signature = $notification->signature;
        $payment_date = date('Y-m-d H:i:s');
        $user_id = 'bot32142';
        $pass = 'p@ssw0rd';
        $sign = sha1(md5(($user_id . $pass . $order_id . $payment_status)));

        if ($payment_status == '2' && $signature == $sign) {
            //* put your code here for make update or insert to your database status
            $dataRetribusi = VValidasi::model()->findByAttributes(array('virtual_account' => $order_id));
            $update = "UPDATE tbl_retribusi SET status_bayar_faspay = true WHERE id_retribusi = $dataRetribusi->id_retribusi";
            Yii::app()->db->createCommand($update)->execute();

            $xml = "<faspay>" . "\n";
            $xml .= "<response>Payment Notification</response>" . "\n";
            $xml .= "<trx_id>$trx_id</trx_id>" . "\n";
            $xml .= "<merchant_id>$merchant_id</merchant_id>" . "\n";
            $xml .= "<bill_no>$order_id</bill_no>" . "\n";
            $xml .= "<response_code>00</response_code>" . "\n";
            $xml .= "<response_desc>Sukses</response_desc>" . "\n";
            $xml .= "<response_date>$payment_date</response_date>" . "\n";
            $xml .= "</faspay>" . "\n";

            echo "$xml";
        }
    }

    public function actionPrivacy()
    {
        $this->layout = '/';
        $this->render('privacy_policy');
    }
}
