<?php
$assetsUrl = $this->module->assetsUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($assetsUrl . '/js/terdaftar.js', CClientScript::POS_END);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Terdaftar</h3>
                <div class="box-tools pull-right">
<!--                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            - Report -
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="javascript:void(0)" onclick="cetakReport('<?php // echo $this->createUrl('terdaftar/ReportTerdaftarExcel'); ?>')"><i class="fa fa-file-excel-o" style="color: green;"></i> Excel</a></li>
                            <li><a href="javascript:void(0)" onclick="cetakReport('<?php // echo $this->createUrl('terdaftar/ReportTerdaftarPdf'); ?>')"><i class="fa fa-file-pdf-o" style="color: red;"></i> PDF</a></li>
                        </ul>
                    </div>-->
                    <button class="btn btn-default" type="button" onclick="cetakReport('<?php echo $this->createUrl('Terdaftar/ReportTerdaftarExcel'); ?>')">
                        <i class="fa fa-file-excel-o" style="color: green;"></i> Rekap Terdaftar
                    </button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="col-lg-4 col-md-4">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
                                <?php echo CHtml::textField('tgl_search', date('d-M-Y'), array('readonly' => 'readonly', 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <input type="text" id="text_category" class="text-besar form-control" placeholder="NO UJI / NO KENDARAAN">
                    </div>
                        <div class="col-lg-4 col-md-4">
                            <button type="button" class="btn btn-info pull-left" onclick="prosesSearch()">
                                <span class="glyphicon glyphicon-refresh"></span> 
                                Refresh
                            </button>
                </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12" style="margin-top: 20px">
                    <table id="terdaftarListGrid"></table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dlg" class="easyui-dialog" title="Ganti Tanggal Uji" style="width: 400px; height: auto; padding: 10px;display: none"
     data-options="
     iconCls: 'icon-save',
     autoOpen: false,
     buttons: [{
     text:'Ok',
     iconCls:'icon-ok',
     handler:function(){
     saveEditTerdaftar();
     }
     },{
     text:'Cancel',
     iconCls:'icon-cancel',
     handler:function(){
     closeDialog();
     }
     }]
     ">
    <form id="form_edit">
        <input type="hidden" id="dlg_id_retribusi" name="dlg_id_retribusi">
    <div class="input-group">
        <div class="input-group-addon">
            <i class="glyphicon glyphicon-calendar"></i>
        </div>
            <input type="text" id="ganti_tgl_uji" name="ganti_tgl_uji" class="form-control" readonly="readonly" value="<?php echo date('d-M-Y'); ?>">
        </div>
        </form>
    </div>
<script>
    $('#terdaftarListGrid').datagrid({
        url: '<?php echo $this->createUrl('Terdaftar/GetListDataTerdaftar'); ?>',
        width: '100%',
        rownumbers: true,
        singleSelect: true,
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
        pageList: [20, 50, 100],
        columns: [[
                {field: 'id_retribusi', title: '', width: 50, halign: 'center', align: 'center', formatter: buttonEditTgl},
                {field: 'numerator', title: 'Numerator', width: 90, sortable: true},
                {field: 'no_uji', title: 'No Uji', width: 90, sortable: true},
                {field: 'no_kendaraan', width: 100, title: 'No Kendaraan', sortable: true},
                {field: 'nama_pemilik', width: 200, title: 'Nama Pemilik', sortable: false},
                {field: 'nm_uji', width: 150, title: 'Uji', sortable: false},
                {field: 'nm_komersil', width: 150, title: 'Nama Komersil', sortable: false},
                {field: 'karoseri_jenis', width: 150, title: 'Jenis Kendaraan', sortable: false},
//                {field: 'no_chasis', width: 150, title: 'No Rangka', sortable: false},
//                {field: 'no_mesin', width: 150, title: 'No Mesin', sortable: false},
                {field: 'bahan_bakar', width: 150, title: 'Bahan Bakar', sortable: false},
                {field: 'sifat', width: 150, title: 'Sifat (U/BU)', sortable: false},
                {field: 'tglmati', width: 150, title: 'Tgl Mati', sortable: false},
            ]],
//        toolbar: "#search",
        onBeforeLoad: function (params) {
            params.textCategory = $('#text_category').val();
//            params.selectCategory = $('#select_category :selected').val();
            params.selectDate = $('#tgl_search').val();
        },
        onLoadError: function () {
            return false;
        },
        onLoadSuccess: function () {
        }
    });

    function buttonEditTgl(value) {
        var button = '<button type="button" data-toggle="tooltip" title="Edit Tgl" class="btn btn-info" onclick="buttonEditTerdaftar(' + value + ')"><span class="glyphicon glyphicon-pencil"></span></button>';
        return button;
    }

    function saveEditTerdaftar() {
        var data = $("#form_edit").serialize();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('Terdaftar/ProsesGantiTglUji'); ?>',
            data: data,
            beforeSend: function () {
                showlargeloader();
            },
            success: function (data) {
                hidelargeloader();
                closeDialog();
                prosesSearch();
            },
            error: function () {
                hidelargeloader();
                return false;
            }
        });
    }    

    function cetakReport(urlAct) {
        var tgl = $('#tgl_search').val();
        window.location.href = urlAct + "?tgl=" + tgl;
        return false;
    }
</script>