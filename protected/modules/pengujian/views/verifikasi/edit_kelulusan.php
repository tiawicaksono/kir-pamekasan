<?php
$path = $this->module->assetsUrl;
$baseJs = Yii::app()->appComponent->urlJs();
$baseCss = Yii::app()->appComponent->urlCss();
$cs = Yii::app()->clientScript;
$cs->registerCssFile($path . '/css/verifikasi_edit_kelulusan.css');
$cs->registerScriptFile($path . '/js/verifikasi_edit_kelulusan.js', CClientScript::POS_END);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Form Edit Kelulusan</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-12">
                    <?php 
                    echo CHtml::beginForm('', 'post', array('class' => 'form-horizontal', 'id' => 'formEditKelulusan'));
                    echo CHtml::hiddenField('id_hasil_uji', $id_hasil_uji, array('class' => 'form-control'));
                    echo CHtml::hiddenField('posisi', $posisi, array('class' => 'form-control'));
                    ?>
                    <div class="row col-md-6">
                        <div class="form-group">
                            <label for="form_uji" class="col-md-3 control-label">Uji</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-wrench"></i>
                                    </div>
                                    <select id="form_uji" name="form_uji" class="form-control" onchange="showHide()">
                                        <option value="prauji" selected="true">Pra uji</option>
                                        <option value="smoke">Emisi</option>
                                        <option value="pitlift">Pitlift</option>
                                        <option value="lampu">Lampu</option>
                                        <option value="break">Rem</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="form_kelulusan" class="col-md-3 control-label">Kelulusan</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-ok"></i>
                                    </div>
                                    <select id="form_kelulusan" name="form_kelulusan" class="form-control" onchange="showHide()">
                                        <option value="true" selected="true">Lulus</option>
                                        <option value="false">Tidak Lulus</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="lain_lain" style="display:none">
                            <label for="form_lain" class="col-md-3 control-label">Lain-lain</label>
                            <div class="col-md-9">
                                <textarea id="form_lain" class="form-input col-md-12" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="form_prauji" style="display:none">
                        <?php $this->renderPartial('prauji'); ?>
                    </div>
                    <div id="form_brake" style="display:none">
                        <?php $this->renderPartial('brake',array(
                            'selrem1' => $selrem1,
                            'selrem2' => $selrem2,
                            'selrem3' => $selrem3,
                            'selrem4' => $selrem4,
                            'selgaya1' => $selgaya1,
                            'selgaya2' => $selgaya2,
                            'selgaya3' => $selgaya3,
                            'selgaya4' => $selgaya4,
                        )); ?>
                    </div>
                    <div class="row col-md-12" style="margin-top:10px;" id="buttonSave">
                        <div class="col-md-6">
                            <label class="col-md-3 control-label">&nbsp;</label>
                            <div class="col-md-9 no-padding">
                                <button type="button" class="btn btn-primary pull-right" onclick="updateVerifikasi('<?php echo $this->createUrl('Verifikasi/UpdateVerifikasi'); ?>')">SAVE</button>
                            </div>
                        </div>
                    </div>
                    <?php echo CHtml::endForm(); ?>
                </div>
            </div>
        </div>
    </div>
</div>