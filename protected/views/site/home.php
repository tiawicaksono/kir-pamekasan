<?php
$baseThemeUrl = Yii::app()->theme->baseUrl;
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl . '/js/highcharts.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/main.js', CClientScript::POS_END);
?>
<div class="col-md-12">
    <div class="col-lg-8 col-xs-8">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3 id="divTotalRetribusi"><?php echo $totalRetribusi ?></h3>
                <p>Retribusi/hari</p>
            </div>
            <div class="icon">
                <i class="ion ion-cash"></i>
            </div>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-4 col-xs-4">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?php echo $totalKendaraan; ?></h3>
                <p>Kendaraan/hari</p>
            </div>
            <div class="icon">
                <i class="ion ion-model-s"></i>
            </div>
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->

<div class="col-md-12">
    <section class="col-lg-8">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Retribusi</h3>
                <div class="box-tools pull-right">
                    <!--<span class="label label-danger">8 New Members</span>-->
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body no-padding" id="homeBarRetribusi">
                <?php $this->renderPartial('home_bar_retribusi', array('year' => $year)); ?>
            </div><!-- /.box-body -->
        </div>
    </section>
    <section class="col-lg-4">    
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Data Kendaraan Hari ini</h3>
                <div class="box-tools pull-right">
                    <!--<span class="label label-danger">8 New Members</span>-->
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                </div>
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
                <?php
                $this->renderPartial('data_kendaraan', array(
                    'totalLulusU' => $totalLulusU,
                    'totalTidakLulusU' => $totalTidakLulusU,
                    'totalLulusBu' => $totalLulusBu,
                    'totalTidakLulusBu' => $totalTidakLulusBu,
                    
					'mobilBarangU' => $mobilBarangU,
                    'mobilPenumpangU' => $mobilPenumpangU,
                    'mobilBisU' => $mobilBisU,
					'mobilKhususU' => $mobilKhususU,
					'kgU' => $kgU,
					'ktU' => $ktU,
					
                    'mobilBarangBu' => $mobilBarangBu,
                    'mobilPenumpangBu' => $mobilPenumpangBu,
                    'mobilBisBu' => $mobilBisBu,
					'mobilKhususBu' => $mobilKhususBu,
					'kgBu' => $kgBu,
					'ktBu' => $ktBu,
					
                    'mobilDatangU' => $mobilDatangU,
                    'mobilDatangBu' => $mobilDatangBu,
                    'totalTlTdU' => $totalTlTdU,
                    'totalTlTdBu' => $totalTlTdBu
                ));
                ?>
            </div><!-- /.box-body -->
        </div><!--/.box -->

    </section><!-- Left col -->
</div><!-- /.row -->