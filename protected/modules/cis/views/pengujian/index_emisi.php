<?php
$baseUrl = Yii::app()->request->baseUrl;
$assetsUrl = $this->module->assetsUrl;
$cs = Yii::app()->clientScript;
$cs->registerCssFile($assetsUrl . '/css/check_radio.css');
$cs->registerScriptFile($assetsUrl . '/js/emisi.js', CClientScript::POS_END);
$cs->registerScriptFile($assetsUrl . '/js/jquery.numeric.js', CClientScript::POS_END);
?>
<style>
    .datagrid-row {
        height: 40px !important;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">EMISI - KENDARAAN LIST</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12 col-md-12 no-padding" style="margin-top: 20px">
                    <table id="emisiListGrid"></table>
                </div>
                <div class="col-lg-12 col-md-12 no-padding" style="margin-top: 20px">
                    <center>
                        <button type="button" class="btn btn-info" onclick="prosesSearchEmisi()">
                            <span class="glyphicon glyphicon-refresh"></span> REFRESH
                        </button>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-12" style="margin-bottom: 20px;">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12 no-padding tengah">
                <img id="img_depan_emisi" style="height:200px" />
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 no-padding tengah">
                <img id="img_belakang_emisi" style="height:200px" />
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 no-padding tengah">
                <img id="img_kanan_emisi" style="height:200px" />
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 no-padding tengah">
                <img id="img_kiri_emisi" style="height:200px" />
            </div>
        </div>
    </div> -->
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">EMISI</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-lg-12 col-md-12">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="hidden" id="username_emisi" readonly="readonly" value="<?php echo Yii::app()->session['username']; ?>" />
                            <input type="hidden" id="id_hasil_uji_emisi" readonly="readonly" />
                            <input type="hidden" id="tahun_emisi" readonly="readonly" />
                            <input type="hidden" id="bahan_bakar_emisi" readonly="readonly" />
                            <input type="hidden" id="posisi_cis_emisi" readonly="readonly" value="<?php echo Yii::app()->session['posisi_cis']; ?>" />
                            <input type="text" id="no_kendaraan_emisi" class="form-control" placeholder="NO KEND" readonly="readonly" />
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="no_uji_emisi" class="form-control" placeholder="NO UJI" readonly="readonly" />
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-warning" onclick="reloadDataEmisi('<?php echo $this->createUrl('Emisi/ReloadData'); ?>')">RELOAD</button>
                                <button type="button" class="btn btn-primary" onclick="prosesEmisi('<?php echo $this->createUrl('Emisi/Proses'); ?>')">PROSES</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12">
                    <table width="100%">
                        <tr>
                            <td width="107"><b>DIESEL</b></td>
                            <td width="36">
                                <div class="input-group">
                                    <input class="form-control" type="text" id="emdiesel" size="6" maxlength="6" />
                                    <div class="input-group-addon">%</div>
                                </div>
                            </td>
                            <td width="426" align="left">&nbsp;&nbsp;&nbsp;Tahun &lt; 2010 (max = 65%)&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Tahun &gt;= 2010 & &lt;= 2021 (max = 40%)&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Tahun &gt; 2021 (max = 30%)</td>
                        </tr>
                        <tr>
                            <td width="107"><b>MESIN CO</b></td>
                            <td width="36">
                                <div class="input-group">
                                    <input class="form-control" type="text" id="emco" size="6" maxlength="6" />
                                    <div class="input-group-addon">%</div>
                                </div>
                            </td>
                            <td width="426" align="left">&nbsp;&nbsp;&nbsp;Tahun &lt; 2007 (max = 4%)&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Tahun &gt;= 2007 & &lt;= 2018 (max = 1%)&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Tahun &gt; 2018 (max = 0.5%)</td>
                        </tr>
                        <tr>
                            <td width="107"><b>MESIN HC</b></td>
                            <td width="36">
                                <div class="input-group">
                                    <input class="form-control" type="text" id="emhc" size="6" maxlength="6" />
                                    <div class="input-group-addon">ppm</div>
                                </div>
                            </td>
                            <td width="426" align="left">&nbsp;&nbsp;&nbsp;Tahun &lt; 2007 (max = 1000ppm)&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Tahun &gt;= 2007 & &lt;= 2018 (max = 150ppm)&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Tahun &gt; 2018 (max = 100ppm)</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#emisiListGrid').datagrid({
        url: '',
        pagination: true,
        singleSelect: true,
        selectOnCheck: true,
        checkOnSelect: true,
        collapsible: true,
        rownumbers: true,
        striped: true,
        loadMsg: 'Loading...',
        method: 'POST',
        nowrap: true,
        pageNumber: 1,
        pageSize: 5,
        pageList: [5, 10, 20],
        columns: [
            [{
                    field: 'id_kendaraan',
                    title: '',
                    hidden: true
                },
                {
                    field: 'id_hasil_uji',
                    title: '',
                    hidden: true
                },
                {
                    field: 'nm_uji',
                    title: 'Jenis Uji',
                    width: 120,
                    sortable: false,
                    align: 'center'
                },
                {
                    field: 'no_kendaraan',
                    width: 100,
                    title: 'No Kendaraan',
                    sortable: false
                },
                {
                    field: 'no_uji',
                    title: 'No Uji',
                    width: 120,
                    sortable: false
                },
                {
                    field: 'merk',
                    title: 'Merk',
                    width: 95,
                    sortable: false
                },
                {
                    field: 'tipe',
                    title: 'Tipe',
                    width: 80,
                    sortable: false
                },
                {
                    field: 'nm_komersil',
                    title: 'Komersil',
                    width: 130,
                    sortable: false
                },
                {
                    field: 'karoseri_jenis',
                    title: 'Jenis',
                    width: 120,
                    sortable: false
                },
                {
                    field: 'tahun',
                    title: 'Tahun',
                    width: 70,
                    sortable: false,
                    align: 'center'
                },
                {
                    field: 'bahan_bakar',
                    title: 'Bahan Bakar',
                    width: 90,
                    sortable: false
                },
            ]
        ],
        onClickRow: function() {
            getInformationEmisi();
        },
    });
</script>