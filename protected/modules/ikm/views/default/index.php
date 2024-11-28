<?php
$baseUrl = Yii::app()->request->baseUrl;
$path = $this->module->assetsUrl;
$cs = Yii::app()->getClientScript();
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Indeks Kepuasan Masyarakat</title>
        <meta content="IE=edge" http-equiv="x-ua-compatible">
        <meta content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" name="viewport">
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta content="yes" name="apple-touch-fullscreen">
        <script>
            function tambah(idQuestion,answerQuestion, urutan) {
                var simpan_array = $('#simpan_array').val();                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('Default/Pertanyaan'); ?>',
                    data:{id_question:idQuestion, answer_question:answerQuestion, arr_jawaban: simpan_array, urutan:urutan},
                    dataType: "json",
                    success: function (data) {
                        $('#target-content').html(data.pertanyaan);
                        $('#divTombol').html(data.tombol);
                        $('#simpan_array').val(data.arrJawaban);
                    },
                    error: function () {
                        return false;
                    }
                });
            }
        </script>
        <?php
        $cs->registerCssFile($path . '/css/bootstrap.css');
        $cs->registerCssFile($path . '/css/keyframes.css');
        $cs->registerCssFile($path . '/css/style.css');
        $cs->registerScriptFile($path . '/js/jquery.min.js', CClientScript::POS_BEGIN);
        $cs->registerScriptFile($path . '/js/jquery.smoothState.min.js', CClientScript::POS_BEGIN);
        $cs->registerScriptFile($path . '/js/functions.js', CClientScript::POS_BEGIN);
        ?>
    </head>
    <body>
        <input type="hidden" id="simpan_array">
        <div id="headerbar">
            <div class="col-lg-1 col-md-1">
                <img src="<?php echo $path; ?>/img/logo-surabaya.png" class="pull-left" style="width: 100px">
            </div>
            <div class="col-lg-10 col-md-10 judul">
                UPTD PKB Wiyung<br />Dinas Perhubungan Kota Surabaya
            </div>
            <div class="col-lg-1 col-md-1">
                <img src="<?php echo $path; ?>/img/logo-dishub.png" class="pull-right" style="width: 100px">
            </div>
        </div>
        <div id="toolbar" class="primary-color fov">
            <div id="target-content">
                <div class="page animated fadeinright" style="text-align: center;">
                    <input id="question_id" type="hidden" value="<?php echo $dataquestion->question_id; ?>">
                    <h1 style=" color: white;"><?php echo $dataquestion->question; ?></h1>
                </div>
            </div>
        </div>
        <div id="divTombol" class="page animated fadeinright">
            <div class="col-md-4">
                <center>
                    <a href="javascript:void(0)" onClick="tambah('<?php echo $dataquestion->question_id; ?>','A',0)"><img src="<?php echo $path; ?>/img/tombol.png" style="width:250px" /></a>
                </center>
            </div>
            <div class="col-md-4">
                <center>
                    <a href="javascript:void(0)" onClick="tambah('<?php echo $dataquestion->question_id; ?>','B',0)"><img src="<?php echo $path; ?>/img/tombol2.png" style="width:250px" /></a>
                </center>
            </div>
            <div class="col-md-4">
                <center>
                    <a href="javascript:void(0)" onClick="tambah('<?php echo $dataquestion->question_id; ?>','C',0)"><img src="<?php echo $path; ?>/img/tombol3.png" style="width:250px" /></a>
                </center>
            </div>
        </div>
        <div id="footerbar">
            &nbsp;
        </div>
    </body>
</html>