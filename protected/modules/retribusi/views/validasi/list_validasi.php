<?php
$path = $this->module->assetsUrl;
$cs = Yii::app()->clientScript;
$cs->registerScriptFile($path . '/js/validasi.js', CClientScript::POS_END);
?>
<style>
    .datagrid-row {
        min-height: 40px;
        height: 43px;
    }

    .datagrid-cell-c1-total {
        font-weight: bold;
        color: red;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Validasi</h3>
                <div class="box-tools pull-right">
                    <!--                        <button class="btn btn-default" type="button" onclick="cetak('<?php // echo $this->createUrl('Validasi/RekapValidasi'); 
                                                                                                                ?>')">
                            <i class="fa fa-file-excel-o" style="color: green;"></i> Rekap Retribusi
                        </button>-->
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            - Report -
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="javascript:void(0)" onclick="cetak('<?php echo $this->createUrl('Validasi/RekapValidasi'); ?>')"><i class="fa fa-file-excel-o" style="color: green;"></i> Rekap Retribusi</a></li>
                            <li><a href="javascript:void(0)" onclick="cetak('<?php echo $this->createUrl('Validasi/RekapSts'); ?>')"><i class="fa fa-file-excel-o" style="color: green;"></i> STS</a></li>
                        </ul>
                    </div>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="col-lg-2 col-md-3">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
                                <?php echo CHtml::textField('tgl_search', date('d-M-Y'), array('readonly' => 'readonly', 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <select class="btn" id="select_category">
                                        <option value="no_uji_kend" selected="selected">No. Uji / Kend</option>
                                        <option value="numerator">Numerator</option>
                                    </select>
                                </span>
                                <?php echo CHtml::textField('text_category', '', array('class' => 'form-control text-besar')); ?>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <select id="choose_validasi" class="form-control" onchange="prosesSearch()">
                                <!--<option value="all">- Semua -</option>-->
                                <option value="false">Belum Valid</option>
                                <option value="true" selected="true">Valid</option>
                            </select>
                        </div>
                        <?php if ((Yii::app()->user->id == '34') || (Yii::app()->user->isRole('Admin'))) { ?>
                            <div class="col-lg-4 col-md-3">
                                <div class="btn-group" role="group" aria-label="...">
                                    <button type="button" id="btn-valid" class="btn btn-primary" onclick="prosesValidChecked('<?php echo $this->createUrl('Validasi/ProsesValidChecked'); ?>', 'true')">Validasi</button>
                                    <button type="button" id="btn-batal" class="btn btn-danger" onclick="prosesValidChecked('<?php echo $this->createUrl('Validasi/ProsesValidChecked'); ?>', 'false')" disabled="true">Batal</button>
                                    <button type="button" id="btn-batal" class="btn btn-info" onclick="prosesSearch()">Refresh</button>
                                    <button type="button" class="btn btn-soundcloud" onclick="buttonCalculatorChecked()">Calc</button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12" style="margin-top: 20px">
                    <table id="validasiListGrid"></table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dlgKalkulator" class="easyui-dialog" title="Total" style="width: 500px; height: 400px; padding: 10px;display: none" data-options="
     iconCls: 'icon-save',
     autoOpen: false,
     buttons: [{
     text:'Close',
     iconCls:'icon-cancel',
     handler:function(){
     closeDialog();
     }
     }]
     ">
    <table id="calculatorListGrid" style="height:200px"></table>
    <hr />
    <span style="font-weight: bold; font-size: 20pt;">Total :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rp <span id="totalcalculator"></span>,00</span>
</div>
<script>
    $('#validasiListGrid').datagrid({
        url: '<?php echo $this->createUrl('Validasi/ValidasiListGrid'); ?>',
        width: '100%',
        //        view: scrollview,
        rownumbers: true,
        singleSelect: false,
        pagination: true,
        selectOnCheck: false,
        checkOnSelect: true,
        collapsible: true,
        striped: true,
        loadMsg: 'Loading...',
        method: 'POST',
        nowrap: false,
        pageNumber: 1,
        pageSize: 20,
        pageList: [20, 50, 100, 250],
        columns: [
            [{
                    field: 'CHECKED',
                    align: 'center',
                    checkbox: true
                },
                {
                    field: 'kuitansi',
                    title: 'Kuitansi',
                    width: 60,
                    halign: 'center',
                    align: 'center',
                    formatter: actionPrint
                },
                {
                    field: 'ACTIONS',
                    title: 'Validasi',
                    width: 60,
                    halign: 'center',
                    align: 'center',
                    formatter: formatAction
                },
                {
                    field: 'id_retribusi',
                    hidden: true
                },
                {
                    field: 'numerator',
                    title: 'Numerator',
                    width: 100,
                    sortable: true
                },
                {
                    field: 'no_uji',
                    title: 'No Uji',
                    width: 120,
                    sortable: false
                },
                {
                    field: 'no_kendaraan',
                    width: 100,
                    title: 'No Kendaraan',
                    sortable: false
                },
                {
                    field: 'uji',
                    width: 170,
                    title: 'Uji',
                    sortable: false
                },
                {
                    field: 'b_berkala',
                    width: 70,
                    title: 'B.Berkala',
                    sortable: false
                },
                {
                    field: 'b_pertama',
                    width: 70,
                    title: 'B.Pertama',
                    sortable: false
                },
                {
                    field: 'b_jbb',
                    width: 70,
                    title: 'B.JBB',
                    sortable: false
                },
                {
                    field: 'b_rekom',
                    width: 70,
                    title: 'B.Rekom',
                    sortable: false
                },
                {
                    field: 'b_buku',
                    width: 70,
                    title: 'B.Kartu Uji',
                    sortable: false
                },
                {
                    field: 'b_tlt_uji',
                    width: 70,
                    title: 'B.Denda',
                    sortable: false
                },
                {
                    field: 'b_plat_uji',
                    width: 90,
                    title: 'B.Sertifikat',
                    sortable: false
                },
                {
                    field: 'b_tnd_samping',
                    width: 90,
                    title: 'B.Stiker',
                    sortable: false
                },
                {
                    field: 'total',
                    width: 70,
                    title: 'TOTAL',
                    sortable: false
                },
            ]
        ],
        //        toolbar: "#search",
        onBeforeLoad: function(params) {
            params.chooseValidasi = $('#choose_validasi :selected').val();
            params.textCategory = $('#text_category').val();
            params.selectCategory = $('#select_category :selected').val();
            params.selectDate = $('#tgl_search').val();
        },
        onLoadError: function() {
            return false;
        },
        onLoadSuccess: function() {}
    });

    function closeDialog() {
        $('#dlgKalkulator').dialog('close');
    }

    function formatAction(value) {
        var button;
        var urlact = '<?php echo $this->createUrl('Validasi/ProsesValid'); ?>';
        var chooseValidasi = $('#choose_validasi :selected').val();
        if (chooseValidasi == 'false') {
            button = '<button type="button" data-toggle="tooltip" title="Valid" class="btn btn-primary" onclick="prosesValid(\'' + urlact + '\', ' + value + ', \'true\')"><span class="glyphicon glyphicon-random"></span></button>';
        } else {
            button = '<button type="button" data-toggle="tooltip" title="Batal" class="btn btn-danger" onclick="prosesValid(\'' + urlact + '\', ' + value + ', \'false\')"><span class="glyphicon glyphicon-random"></span></button>';
        }
        return button;
    }

    function prosesSearch() {
        var chooseValidasi = $('#choose_validasi :selected').val();
        if (chooseValidasi == 'true') {
            $("#btn-batal").prop("disabled", false);
            $("#btn-valid").prop("disabled", true);
        } else {
            $("#btn-valid").prop("disabled", false);
            $("#btn-batal").prop("disabled", true);
        }
        $('#validasiListGrid').datagrid('reload');
    }

    $(document).on("keypress", '#text_category', function(e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            prosesSearch();
            return false;
        }
    });

    function cetak(urlAct) {
        var tgl = $('#tgl_search').val();
        window.location.href = urlAct + "?tgl=" + tgl;
        return false;
    }

    $(document).ready(function() {
        closeDialog();
        $('#tgl_search').datepicker({
            format: 'dd-M-yyyy',
            daysOfWeekDisabled: [0, 7],
            autoclose: true,
        }).on('changeDate', prosesSearch);
    });

    function actionPrint(value) {
        var button = '<button type="button" class="btn btn-success edit-retribusi" onclick="cetakRetribusi(\'' + value + '\')"><span class="glyphicon glyphicon-print"></span></button>';
        return button;
    }

    function cetakRetribusi(id) {
        var url = '<?php echo $this->createUrl('Validasi/CetakRetribusi'); ?>';
        var win = window.open(url + "?id=" + id, '_blank');
        win.focus();
    }

    function buttonCalculatorChecked() {
        var rows = $('#validasiListGrid').datagrid('getChecked');
        var ids = [];
        for (var i = 0; i < rows.length; i++) {
            ids.push(rows[i].id_retribusi);
        }
        if (rows.length > 0) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('Validasi/getListCalculator'); ?>',
                data: {
                    idArray: ids
                },
                dataType: 'JSON',
                beforeSend: function() {
                    showlargeloader();
                },
                success: function(data) {
                    hidelargeloader();
                    $('#dlgKalkulator').dialog('open');
                    $('#dlgKalkulator').dialog('center');
                    $('#calculatorListGrid').datagrid({
                        data: data,
                        width: '100%',
                        singleSelect: false,
                        pagination: false,
                        selectOnCheck: false,
                        checkOnSelect: true,
                        collapsible: true,
                        striped: true,
                        loadMsg: 'Loading...',
                        nowrap: false,
                        pageNumber: 1,
                        pageSize: 200,
                        pageList: [200],
                        showPageInfo: false,
                        columns: [
                            [{
                                    field: 'numerator',
                                    title: 'Numerator',
                                    width: 80,
                                    sortable: true
                                },
                                {
                                    field: 'no_uji',
                                    title: 'No Uji',
                                    width: 120,
                                    sortable: false
                                },
                                {
                                    field: 'total',
                                    width: 80,
                                    title: 'Total',
                                    sortable: false,
                                    align: 'right'
                                },
                            ]
                        ],
                        onBeforeLoad: function(params) {},
                        onLoadError: function() {
                            return false;
                        },
                        onLoadSuccess: function() {}
                    });
                    $('#totalcalculator').html(data.totalcalculator);
                },
                error: function() {
                    hidelargeloader();
                    return false;
                }
            });
        } else {
            $.messager.alert('Warning', 'You must select at least one item!', 'error');
            return false;
        }
    }
</script>