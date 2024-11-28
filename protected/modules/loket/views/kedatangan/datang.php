<?php
$assetsUrl = $this->module->assetsUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($assetsUrl . '/js/datang.js', CClientScript::POS_END);
?>
<?php if (!Yii::app()->user->isRole('Admin')) { ?>
<style>
    .datagrid-row{
        height: 40px !important;
    }
</style>
<?php } ?>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Kedatangan</h3>
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
                        <div class="col-lg-2 col-md-3">
                            <input type="text" id="text_category" class="text-besar form-control" placeholder="NO UJI / NO KENDARAAN">
                        </div>
                        <div class="col-lg-2 col-md-2">
                        <select id="choose_proses" class="form-control" onchange="prosesSearchKedatangan(this.value)">
                            <option value="true">Datang</option>
                            <option value="false" selected="true">Belum Datang</option>
                        </select>
                    </div>
                        <?php if (Yii::app()->user->isRole('Admin')) { ?>
                            <div class="col-lg-4 col-md-4">
                                <div class="btn-group" role="group" aria-label="...">
                                    <button type="button" class="btn btn-info" onclick="prosesSearch()">
                                        <span class="glyphicon glyphicon-refresh"></span> 
                                        Refresh
                                    </button>
                                    <button id="buttonDatangkan" type="button" class="btn btn-success" onclick="saveDatangChecked()">
                            <span class="glyphicon glyphicon-random"></span>&nbsp; Datangkan
                        </button>
                        <button style="display: none" id="buttonBelumDatangkan" type="button" class="btn btn-danger" onclick="buttonBelumDatangChecked()">
                            <span class="glyphicon glyphicon-random"></span>&nbsp; Belum Datangkan
                        </button>
                    </div>
                            </div>
                    <?php } ?>
                </div>
                </div>
                <div class="col-lg-12 col-md-12" style="margin-top: 20px">
                    <table id="datangListGrid"></table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#datangListGrid').datagrid({
        url: '<?php echo $this->createUrl('Kedatangan/GetListDataDatang'); ?>',
        width: '100%',
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
        pageList: [20, 50, 100],
        pagePosition: "top bottom",
        columns: [[
                <?php if(Yii::app()->user->isRole('Admin')){ ?>
                {field: 'CHECKED', align: 'center', checkbox: true},
                {field: 'id_campuran', hidden: true},
                {field: 'id', title: '', width: 50, halign: 'center', align: 'center', formatter: buttonDatang},
                <?php } ?>
                {field: 'no_uji', title: 'No Uji', width: 90, sortable: false},
                {field: 'no_kendaraan', width: 100, title: 'No Kendaraan', sortable: true},
                {field: 'nama_pemilik', width: 250, title: 'Nama Pemilik', sortable: true},
                {field: 'jns_kend', width: 120, title: 'Jenis Kendaraan', sortable: false},
                {field: 'nm_uji', width: 120, title: 'Jenis Uji', sortable: false},
            ]],
//        toolbar: "#search",
        onBeforeLoad: function (params) {
            params.textCategory = $('#text_category').val();
            params.chooseProses = $('#choose_proses :selected').val();
//            params.selectCategory = $('#select_category :selected').val();
            params.selectDate = $('#tgl_search').val();
        },
        onLoadError: function () {
            return false;
        },
        onLoadSuccess: function () {
        }
    });
    
    function buttonDatang(value) {
        var explode = value.split('|');
        var id_daftar = explode[0];
        var button;
        var chooseValidasi = $('#choose_proses :selected').val();
        if (chooseValidasi == 'false') {
            button = '<button type="button" data-toggle="tooltip" title="&nbsp;&nbsp;&nbsp;Datangkan" class="btn btn-info" onclick="saveDatang(\'' + value + '\')"><span class="glyphicon glyphicon-random"></span></button>';
        } else {
            button = '<button type="button" data-toggle="tooltip" title="&nbsp;&nbsp;&nbsp;Kembalikan" class="btn btn-danger" onclick="saveBelumDatang(\'' + id_daftar + '\')"><span class="glyphicon glyphicon-random"></span></button>';
//            button = '<button type="button" class="btn btn-info" disabled="true"><span class="glyphicon glyphicon-random"></span></button>';
        }
        return button;
    }

    function cetakReport(urlAct) {
        var tgl = $('#tgl_search').val();
        window.location.href = urlAct + "?tgl=" + tgl;
        return false;
    }
</script>