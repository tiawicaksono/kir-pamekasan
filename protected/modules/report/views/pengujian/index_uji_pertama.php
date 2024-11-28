<?php
$baseUrl = Yii::app()->baseUrl;
$path = $this->module->assetsUrl;
$cs = Yii::app()->clientScript;
$cs->registerCssFile($path . '/css/report.css');
$cs->registerScriptFile($path . '/js/report.js', CClientScript::POS_END);
$tgl = date('d-M-y');
?>
<div class="row">
    <section class="col-lg-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Export Kendaraan Uji Pertama</h3>
                <div class="box-tools pull-right">
                    <!--<span class="label label-danger">8 New Members</span>-->
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <form class="form-inline" id="REPORT_FORM_SEARCH">
                            <div class="form-group">
                                <label for="tgl_report">Pilih Tanggal : </label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
                                    <?php echo CHtml::textField('tgl_report_uji_pertama', $tgl, array('readonly' => 'readonly', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            <!--<button onclick="showTableUjiPertama()" type="button" class="btn btn-primary">Show Data</button>-->
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <table>
                                <tr>
                                    <td class="tengah">
                                        <a href="javascript:void(0)" onclick="exportExcelReport('<?php echo $this->createUrl('Pengujian/ExportExcelUjiPertama'); ?>')">
                                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/icon_excel.png">
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tengah">export to excel</td>
                                </tr>
                            </table>                     
                        </div>
                    </div>
                </div>

                <div class="content">
                    <table id="reportListGrid"></table>
                </div>
            </div><!-- /.box-body -->
        </div><!--/.box -->
    </section>
</div>
<script>
    $('#reportListGrid').datagrid({
        url: '<?php echo $this->createUrl('Pengujian/UjiPertamaListGrid'); ?>',
        pagination: true,
        singleSelect: false,
        selectOnCheck: false,
        checkOnSelect: true,
        collapsible: true,
        rownumbers: true,
        striped: true,
        loadMsg: 'Loading...',
        method: 'POST',
        nowrap: false,
        pageNumber: 1,
        pageSize: 20,
        pageList: [20, 30, 50],
//        frozenColumns: [[
//                {field: 'no_antrian', title: 'No Antrian', width: 65, sortable: false},
//                {field: 'no_kendaraan', width: 85, title: 'No Kendaraan', sortable: false},
//            ]],
        columns: [[
                {field: 'no_kendaraan', title: 'No Kendaraan', width: 100, sortable: false},
                {field: 'no_uji', width: 150, title: 'No Uji', sortable: false},
                {field: 'merk_tahun', width: 150, title: 'Merk / Tahun', sortable: false},
                {field: 'jenis', width: 150, title: 'Jenis', sortable: false},
                {field: 'umum', width: 80, title: 'Umum', align: 'center', sortable: false},
                {field: 'b_umum', width: 80, title: 'B.Umum', align: 'center', sortable: false},
            ]],
        //        toolbar: "#search",
        onBeforeLoad: function (params) {
            params.tanggal = $('#tgl_report_uji_pertama').val();
        },
        onLoadError: function () {
            return false;
        },
        onLoadSuccess: function () {
        }
    });
</script>