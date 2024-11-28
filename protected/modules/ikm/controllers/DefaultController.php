<?php

class DefaultController extends Controller {

    public $layout = '/';

    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria->order = 'question_id asc';
        $data = TblIkmQuestion::model()->find($criteria);
        $criteria->limit = 1;
        $criteria->offset = 1;
        $data2 = TblIkmQuestion::model()->find($criteria);
        $this->render('index', array(
            'dataquestion' => $data,
            'dataquestion2' => $data2
        ));
    }

    public function actionPertanyaan() {
        $path = $this->module->assetsUrl;
        $arrJawaban = $_POST['arr_jawaban'];
        $idQuestion = $_POST['id_question'];
        $answerQuestion = $_POST['answer_question'];
        $urutan = $_POST['urutan'] + 1;
        $concatIdJawaban = $urutan . $answerQuestion;
        $criteria = new CDbCriteria();
        $criteria->order = 'question_id asc';
        $criteria->limit = 1;
        $criteria->offset = $urutan;
        $criteria->addCondition('question_status = 1');
        $data = TblIkmQuestion::model()->find($criteria);

        $criteriaCount = new CDbCriteria();
        $criteriaCount->addCondition('question_status = 1');
        $countData = TblIkmQuestion::model()->count($criteriaCount);

        if (empty($arrJawaban)) {
            $arrayJawaban = array($concatIdJawaban);
        } else {
            $arrayJawaban = array($arrJawaban);
            array_push($arrayJawaban, "$concatIdJawaban");
        }
        $arrdata['arrJawaban'] = $arrayJawaban;

        if ($countData == $urutan) {
            $comma_separated = implode(",", $arrayJawaban);
            $data_new = new TblIkm();
            $data_new->tgl_ikm = date('m/d/Y');
            $data_new->no_kendaraan = 'L 123123 MN';
            $data_new->jawaban = $comma_separated;
            $data_new->save();
            $url = $this->createUrl('/ikm');
            $arrdata['pertanyaan'] = '<div class="page animated fadeinright" style="text-align: center;">
                    <h1 style=" color: white;">Terimakasih</h1></div>';
            $arrdata['tombol'] = '<script>
		setTimeout(function(){ location.href = "'.$url.'"; }, 1000);
		</script>';
        } else {
            $arrdata['pertanyaan'] = '<div class="page animated fadeinright" style="text-align: center;">
                    <input id="question_id" type="hidden" value="' . $data->question_id . '">
                    <h1 style=" color: white;">' . $data->question . '</h1></div>';
            $arrdata['tombol'] = '<div class="page animated fadeinright">
                <div class="col-md-4">
                    <center>
                        <a href="javascript:void(0)" onClick="tambah(\'' . $data->question_id . '\',\'A\',' . $urutan . ')"><img src="' . $path . '/img/tombol.png" style="width:250px" /></a>
                    </center>
                </div>
                <div class="col-md-4">
                    <center>
                        <a href="javascript:void(0)" onClick="tambah(\'' . $data->question_id . '\',\'B\',' . $urutan . ')"><img src="' . $path . '/img/tombol2.png" style="width:250px" /></a>
                    </center>
                </div>
                <div class="col-md-4">
                    <center>
                        <a href="javascript:void(0)" onClick="tambah(\'' . $data->question_id . '\',\'C\',' . $urutan . ')"><img src="' . $path . '/img/tombol3.png" style="width:250px" /></a>
                    </center>
                </div>
            </div>';
        }
        echo CJSON::encode($arrdata);
    }

}
