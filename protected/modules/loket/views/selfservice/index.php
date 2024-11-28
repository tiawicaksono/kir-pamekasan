<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/background.png');
            background-color: #cccccc;
        }

        .content {
            max-width: 80%;
            margin: auto;
        }

        .box {
            float: left;
            /* border: 1px;
            border-style: dotted; */
            width: 49%;
            text-align: center;
        }
    </style>
</head>

<body>
    <div style="padding-top: 40%; max-width: 60%;">
        <div class="box">
            <a href="<?php echo $this->createUrl('selfservice/ikm'); ?>">
                <img src="<?php echo Yii::app()->baseUrl; ?>/images/icon_ikm.png" style="width:90%" />
            </a>
        </div>
        <div class="box">
            <a href="<?php echo $this->createUrl('selfservice/retribusi'); ?>">
                <img src="<?php echo Yii::app()->baseUrl; ?>/images/icon_self_service.png" style="width:90%" />
            </a>
        </div>
    </div>
</body>

</html>