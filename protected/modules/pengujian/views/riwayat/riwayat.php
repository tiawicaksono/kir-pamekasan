<?php
$path = $this->module->assetsUrl;
$cs = Yii::app()->clientScript;
$cs->registerScriptFile($path . '/js/riwayat.js', CClientScript::POS_END);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-header with-border bg-light-blue">
                <h3 class="box-title">Riwayat Kendaraan</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="col-lg-4 col-md-5">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <select class="btn" id="select_category">
                                        <option value="no_uji" selected="selected">No Uji / No Kend</option>
                                        <option value="no_chasis">No Chasis</option>
                                        <option value="no_mesin">No Mesin</option>
                                    </select>
                                </span>
                                <?php
                                echo CHtml::textField('text_category', '', array('class' => 'form-control text-besar'));
                                echo CHtml::hiddenField('id_kendaraan_riwayat', '');
                                ?>
                                <div class="input-group-addon" onclick="prosesSearch('<?php echo $this->createUrl('Riwayat/RiwayatListGrid'); ?>')" style="cursor: pointer; color: white; background-color: #00c0ef; border-color: #00acd6;">
                                    <span class="glyphicon glyphicon-refresh"></span>
                                    Refresh
                                </div>
                            </div>
                        </div>
                        <!--                        <div class="col-lg-3 col-md-3">
                            <button class="btn btn-warning" id="btn-kartu-induk" type="button" onclick="cetakKartuKuning()" disabled="true">
                                Kartu Kuning
                            </button>
                        </div>-->
                    </div>
                </div>
                <div class="col-lg-12 col-md-12" style="margin-top: 20px">
                    <!-- <div class="col-lg-6 col-md-6 col-sm-6"> -->
                    <table id="riwayatListGrid"></table>
                    <!-- </div> -->
                </div>
            </div>
        </div>
        <div class="box box-danger">
            <div class="box-header with-border bg-red">
                <h3 class="box-title">Riwayat Kendaraan Tidak Lulus Uji</h3>
                <div class="box-tools pull-right">
                    <button class="btn bg-red-active btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <table id="riwayatTlListGrid"></table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 no-padding" style="margin-top: 10px;">
            <div class="col-lg-3 col-xs-6">
                <img class="img-thumbnail" id="img_depan">
            </div>
            <div class="col-lg-3 col-xs-6">
                <img class="img-thumbnail" id="img_belakang">
            </div>
            <div class="col-lg-3 col-xs-6">
                <img class="img-thumbnail" id="img_kiri">
            </div>
            <div class="col-lg-3 col-xs-6">
                <img class="img-thumbnail" id="img_kanan">
            </div>
        </div>
    </div>
</div>
<div id="dlg_editNumkeMutke" class="easyui-dialog" title=" DETAIL KENDARAAN" style="width: 400px; padding: 10px; display: none;" data-options="
     iconCls: 'icon-save',
     autoOpen: false,
     buttons: [{
     text:'Ok',
     iconCls:'icon-ok',
     handler:function(){
     insertRiwayat();
     }
     },{
     text:'Cancel',
     iconCls:'icon-cancel',
     handler:function(){
     closeDialogEditNumkeMutke();
     }
     }]
     ">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?php
        echo CHtml::beginForm('', 'post', array('class' => 'form-horizontal', 'id' => 'FORMEDITRIWAYAT'));
        echo CHtml::hiddenField('dlg_id_rekom', '', array('class' => 'form-control text-besar'))
        ?>
        <div class="form-group">
            <label for="dlg_add_tgl_uji" class="col-lg-3 col-md-6 control-label">Tgl Uji</label>
            <div class="col-lg-9 col-md-6">
                <?php echo CHtml::textField('dlg_add_tgl_uji', date('d-M-Y'), array('readonly' => 'readonly', 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="dlg_add_nrp" class="col-lg-3 col-md-6 control-label">Penguji</label>
            <div class="col-lg-9 col-md-6">
                <?php echo CHtml::textField('dlg_add_penguji', '', array('class' => 'form-control text-besar')) ?>
            </div>
        </div>
        <!-- <div class="form-group">
            <label for="dlg_add_catatan" class="col-lg-3 col-md-6 control-label">Catatan</label>
            <div class="col-lg-9 col-md-6">
                <?php // echo CHtml::textArea('dlg_add_catatan', '', array('class' => 'form-control')) 
                ?>
            </div>
        </div> -->
        <?php echo CHtml::endForm(); ?>
    </div>
</div>
<script>
    $('#riwayatListGrid').datagrid({
        url: '',
        width: '100%',
        pagination: true,
        singleSelect: true,
        selectOnCheck: false,
        checkOnSelect: true,
        collapsible: true,
        rownumbers: true,
        striped: true,
        loadMsg: 'Loading...',
        method: 'POST',
        nowrap: false,
        pageNumber: 1,
        pageSize: 5,
        pageList: [5, 10, 20],
        columns: [
            [{
                    field: 'id_hasil_uji',
                    title: 'Foto',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: buttonImage
                },
                {
                    field: 'bap',
                    title: 'BAP',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: buttonDownloadBAP
                },
                {
                    field: 'kartu_kuning',
                    title: 'Kartu Kuning',
                    width: 80,
                    halign: 'center',
                    align: 'center',
                    formatter: buttonKartuKuning
                },
                {
                    field: 'edit',
                    title: 'Edit',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: buttonEditNumkeMutke
                },
                {
                    field: 'no_uji',
                    title: 'No Uji',
                    width: 100,
                    sortable: false
                },
                {
                    field: 'no_kendaraan',
                    width: 90,
                    title: 'No Kendaraan',
                    sortable: false
                },
                {
                    field: 'tgl_uji',
                    width: 120,
                    title: 'Tanggal Uji',
                    sortable: false
                },
                {
                    field: 'mati_uji',
                    width: 120,
                    title: 'Mati Uji',
                    sortable: false
                },
                {
                    field: 'nama_penguji',
                    width: 250,
                    title: 'Nama Penguji',
                    sortable: false
                },
                {
                    field: 'catatan',
                    width: 400,
                    title: 'Riwayat Perbaikan',
                    sortable: false
                },
                {
                    field: 'keterangan',
                    width: 200,
                    title: 'Keterangan',
                    sortable: false
                },
                {
                    field: 'kota',
                    width: 200,
                    title: 'Kota Tujuan',
                    sortable: false
                }
            ]
        ],
        onLoadError: function() {
            return false;
        },
        onLoadSuccess: function() {}
    });

    $('#riwayatTlListGrid').datagrid({
        url: '',
        width: '100%',
        pagination: true,
        singleSelect: true,
        selectOnCheck: false,
        checkOnSelect: true,
        collapsible: true,
        rownumbers: true,
        striped: true,
        loadMsg: 'Loading...',
        method: 'POST',
        nowrap: false,
        pageNumber: 1,
        pageSize: 5,
        pageList: [5, 10, 20],
        columns: [
            [{
                    field: 'id_hasil_uji',
                    title: 'Foto',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: buttonImage
                },
                {
                    field: 'bap',
                    title: 'BAP',
                    width: 80,
                    halign: 'center',
                    align: 'center',
                    formatter: buttonDownloadBAPTL
                },
                {
                    field: 'no_uji',
                    title: 'No Uji',
                    width: 90,
                    sortable: false
                },
                {
                    field: 'no_kendaraan',
                    width: 90,
                    title: 'No Kendaraan',
                    sortable: false
                },
                {
                    field: 'tgl_uji',
                    width: 120,
                    title: 'Tanggal Uji',
                    sortable: false
                },
                {
                    field: 'nama_penguji',
                    width: 250,
                    title: 'Nama Penguji',
                    sortable: false
                },
                {
                    field: 'catatan',
                    width: 450,
                    title: 'Keterangan Tidak Lulus',
                    sortable: false
                }
            ]
        ],
        onLoadError: function() {
            return false;
        },
        onLoadSuccess: function() {}
    });

    function buttonImage(value) {
        var urlAct = '<?php echo $this->createUrl('Riwayat/ViewImage'); ?>';
        var button = '<button type="button" class="btn btn-primary" onclick="viewImage(' + value + ', \'' + urlAct + '\')"><span class="glyphicon glyphicon-picture"></span></button>';
        return button;
    }

    function buttonDownloadBAP(value) {
        var urlAct = '<?php echo $this->createUrl('Bap/ReportRiwayatPemeriksaan'); ?>';
        var button = '<button type="button" class="btn btn-success" onclick="viewDetailPengujian(' + value + ', \'' + urlAct + '\')"><span class="glyphicon glyphicon-duplicate"></span></button>';
        return button;
    }

    function buttonDownloadBAPTL(value) {
        var urlAct = '<?php echo $this->createUrl('BapTl/ReportRiwayatPemeriksaan'); ?>';
        var button = '<button type="button" class="btn btn-success" onclick="viewDetailPengujian(' + value + ', \'' + urlAct + '\')"><span class="glyphicon glyphicon-duplicate"></span></button>';
        return button;
    }

    $(document).on("keypress", '#text_category', function(e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            prosesSearch('<?php echo $this->createUrl('Riwayat/RiwayatListGrid'); ?>', '<?php echo $this->createUrl('Riwayat/RiwayatTlListGrid'); ?>');
            return false;
        }
    });

    function viewDetailPengujian(val, urlAct) {
        window.location.href = urlAct + "?id_hasil_uji=" + val;
        return false;
    }

    function buttonKartuKuning(value) {
        var button = '<button type="button" class="btn btn-warning" onclick="cetakKartuKuning(' + value + ')"><span class="fa fa-book"></span></button>';
        return button;
    }

    function cetakKartuKuning(id) {
        var id_kendaraan = $('#id_kendaraan_riwayat').val();
        var urlAct = '<?php echo $this->createUrl('Riwayat/CetakKartuKuning'); ?>';
        var win = window.open(urlAct + "?id_kendaraan=" + id_kendaraan, '_blank');
        win.focus();
    }

    function buttonEditNumkeMutke(value) {
        if (value != 0) {
            $('#dlg_id_rekom').val(value)
            var button = '<button type="button" class="btn btn-info" onclick="editNumkeMutke()"><span class="glyphicon glyphicon-pencil"></span></button>';
        } else {
            var button = '<button type="button" class="btn btn-default" disabled><span class="glyphicon glyphicon-pencil"></span></button>';
        }
        return button;
    }
</script>