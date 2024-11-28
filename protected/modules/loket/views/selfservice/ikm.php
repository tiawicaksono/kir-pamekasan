<!DOCTYPE html>
<html>

<head>
    <?php
    $baseUrl = Yii::app()->baseUrl;
    $cs = Yii::app()->clientScript;
    $cs->registerScriptFile($baseUrl . '/js/jquery-1.12.0.min.js', CClientScript::POS_BEGIN);
    ?>
    <style>
        body {
            background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/ikm_1920x1080.png');
            background-color: #cccccc;
        }

        .content {
            max-width: 80%;
            margin: auto;
            text-align: center;
        }

        .box {
            float: left;
            width: 32%;
            text-align: center;
            /* border: 1px dotted; */
            /* three boxes (use 25% for four, and 50% for two, etc) */
        }

        .img {
            width: 170%;
            margin-left: -180px;
        }

        .font {
            font-size: 40pt;
            font-weight: bolder;
            color: white;
        }
    </style>
</head>

<body>
    <div class="content">
        <div id="pertanyaan">
            <div style="margin-top:20%">
                <img src="<?php echo Yii::app()->baseUrl; ?>/images/ikm_text.png" width="90%" />
            </div>
            <div>
                <div class="box">
                    <img class="img" src="<?php echo Yii::app()->baseUrl; ?>/images/ikm_puas.png" onclick="ikm('sp')" />
                    <!-- <span class="font">SANGAT PUAS</span> -->
                </div>
                <div class="box">
                    <img class="img" src="<?php echo Yii::app()->baseUrl; ?>/images/ikm_cukup_puas.png" onclick="ikm('p')" />
                    <!-- <span class="font">PUAS</span> -->
                </div>
                <div class="box">
                    <img class="img" src="<?php echo Yii::app()->baseUrl; ?>/images/ikm_tidak_puas.png" onclick="ikm('tp')" />
                    <!-- <span class="font">TIDAK PUAS</span> -->
                </div>
            </div>
        </div>
        <div id="terimakasih" style="display: none;">
            <div style="margin-top:20px">
                <img src="<?php echo Yii::app()->baseUrl; ?>/images/ikm_terimakasih.png" width="90%" />
            </div>
        </div>
    </div>
</body>
<script>
    function ikm(pilihan) {
        $.ajax({
            url: '<?php echo $this->createUrl('selfservice/saveIkm'); ?>',
            type: 'POST',
            data: {
                pilihan: pilihan
            },
            dataType: 'JSON',
            success: function(data) {
                setTimeout(function() {
                    $('#pertanyaan').fadeOut();
                }, 500);
                setTimeout(function() {
                    $('#terimakasih').fadeIn();
                }, 1000);
                setTimeout(function() {
                    $('#terimakasih').fadeOut();
                }, 5000);
                // setTimeout(function() {
                //     $('#pertanyaan').fadeIn();
                // }, 3000)
                setTimeout(function() {
                    (window.location.href = '<?php echo $this->createUrl('/loket/selfservice'); ?>').fadeIn();
                }, 6000);
            },
            error: function(data) {
                return false;
            }
        });
    }
</script>

</html>