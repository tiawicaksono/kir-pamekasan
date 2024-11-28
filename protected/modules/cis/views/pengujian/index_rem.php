<?php
$baseUrl = Yii::app()->request->baseUrl;
$assetsUrl = $this->module->assetsUrl;
$cs = Yii::app()->clientScript;
$cs->registerCssFile($assetsUrl . '/css/check_radio.css');
$cs->registerScriptFile($assetsUrl . '/js/rem.js', CClientScript::POS_END);
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
                <h3 class="box-title">REM - KENDARAAN LIST</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12 col-md-12 no-padding" style="margin-top: 20px">
                    <table id="remListGrid"></table>
                </div>
                <div class="col-lg-12 col-md-12 no-padding" style="margin-top: 20px">
                    <center>
                        <button type="button" class="btn btn-info" onclick="prosesSearchRem()">
                            <span class="glyphicon glyphicon-refresh"></span> REFRESH
                        </button>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">REM</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-lg-12 col-md-12">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="hidden" value="biasa" readonly="readonly" id="text_category_rem" />
                            <input type="hidden" id="username_rem" readonly="readonly" value="<?php echo Yii::app()->session['username']; ?>" />
                            <input type="hidden" id="id_hasil_uji_rem" readonly="readonly" />
                            <input type="hidden" id="tahun_rem" readonly="readonly" />
                            <input type="hidden" id="posisi_cis_rem" readonly="readonly" value="<?php echo Yii::app()->session['posisi_cis']; ?>" />
                            <input type="text" id="no_kendaraan_rem" class="form-control" placeholder="NO KEND" readonly="readonly" />
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="no_uji_rem" class="form-control" placeholder="NO UJI" readonly="readonly" />
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-warning" onclick="reloadDataRem('<?php echo $this->createUrl('Rem/ReloadData'); ?>')">RELOAD</button>
                                <button type="button" class="btn btn-primary" onclick="prosesRem('<?php echo $this->createUrl('Rem/Proses'); ?>')">PROSES</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12">
                    <table width="100%">
                        <tr>
                            <td width="10%"></td>
                            <td>KIRI</td>
                            <td width="18"></td>
                            <td>KANAN</td>
                            <td width="18"></td>
                            <td>GAYA REM (%)</td>
                            <td></td>
                            <td></td>
                            <td>SELISIH REM (%)</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>1. SUMBU I </td>
                            <td>
                                <input type="hidden" id="bsumbu1" />
                                <div class="input-group">
                                    <input onkeyup="perhitungan()" class="form-control" type="text" id="bsb1kr" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">Kg</div>
                                </div>
                            </td>
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <input onkeyup="perhitungan()" class="form-control" type="text" id="bsb1kn" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">Kg</div>
                                </div>
                            </td>
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <input style="background-color: #ddd" readonly="readonly" class="form-control" type="text" id="bsb1" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">%</div>
                                </div>
                            </td>
                            <td>Max = 100 %</td>
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <input class="form-control" style="background-color: #ddd" readonly="readonly" type="text" id="bsel1" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">%</div>
                                </div>
                            </td>
                            <td>Max = 8 %</td>
                        </tr>
                        <tr>
                            <td>2. SUMBU II </td>
                            <td>
                                <input type="hidden" id="bsumbu2" />
                                <div class="input-group">
                                    <input onkeyup="perhitungan()" class="form-control" type="text" id="bsb2kr" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">Kg</div>
                                </div>
                            </td>
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <input onkeyup="perhitungan()" class="form-control" type="text" id="bsb2kn" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">Kg</div>
                                </div>
                            </td>
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <input style="background-color: #ddd" readonly="readonly" class="form-control" type="text" id="bsb2" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">%</div>
                                </div>
                            </td>
                            <td>Max = 100 %</td>
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <input class="form-control" style="background-color: #ddd" readonly="readonly" type="text" id="bsel2" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">%</div>
                                </div>
                            </td>
                            <td>Max = 8 %</td>
                        </tr>
                        <tr>
                            <td>3. SUMBU III </td>
                            <td>
                                <input type="hidden" id="bsumbu3" />
                                <div class="input-group">
                                    <input onkeyup="perhitungan()" class="form-control" type="text" id="bsb3kr" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">Kg</div>
                                </div>
                            </td>
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <input onkeyup="perhitungan()" class="form-control" type="text" id="bsb3kn" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">Kg</div>
                                </div>
                            </td>
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <input style="background-color: #ddd" readonly="readonly" class="form-control" type="text" id="bsb3" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">%</div>
                                </div>
                            </td>
                            <td>Max = 100 %</td>
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <input class="form-control" style="background-color: #ddd" readonly="readonly" type="text" id="bsel3" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">%</div>
                                </div>
                            </td>
                            <td>Max = 8 %</td>
                        </tr>
                        <tr>
                            <td>4. SUMBU IV </td>
                            <td>
                                <input type="hidden" id="bsumbu4" />
                                <div class="input-group">
                                    <input onkeyup="perhitungan()" class="form-control" type="text" id="bsb4kr" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">Kg</div>
                                </div>
                            </td>
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <input onkeyup="perhitungan()" class="form-control" type="text" id="bsb4kn" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">Kg</div>
                                </div>
                            </td>
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <input style="background-color: #ddd" readonly="readonly" class="form-control" type="text" id="bsb4" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">%</div>
                                </div>
                            </td>
                            <td>Max = 100 %</td>
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <input class="form-control" style="background-color: #ddd" readonly="readonly" type="text" id="bsel4" value="" size="8" maxlength="8" />
                                    <div class="input-group-addon">%</div>
                                </div>
                            </td>
                            <td>Max = 8 %</td>
                        </tr>
                        <tr>
                            <td colspan="10">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Berat S-I</td>
                            <td colspan="2">
                                <label>
                                    <input id="um21" type="checkbox" class="flat-red"> Tidak Sesuai STUK
                                </label>
                            </td>
                            <td colspan="7">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Berat S-II</td>
                            <td colspan="2">
                                <label>
                                    <input id="um22" type="checkbox" class="flat-red"> Tidak Sesuai STUK
                                </label>
                            </td>
                            <td colspan="7">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Berat S-III</td>
                            <td colspan="2">
                                <label>
                                    <input id="um23" type="checkbox" class="flat-red"> Tidak Sesuai STUK
                                </label>
                            </td>
                            <td colspan="7">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Berat S-IV</td>
                            <td colspan="2">
                                <label>
                                    <input id="um24" type="checkbox" class="flat-red"> Tidak Sesuai STUK
                                </label>
                            </td>
                            <td colspan="7">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Rem parkir</td>
                            <td colspan="2">
                                <label>
                                    <input id="g34" type="checkbox" class="flat-red"> Tidak Berfungsi
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#remListGrid').datagrid({
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
                    field: 'id_jns_kend',
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
                //                {field: 'no_antrian', width: 100, title: 'No Antrian', sortable: false},
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
                    field: 'tahun',
                    title: 'Tahun',
                    width: 70,
                    sortable: false,
                    align: 'center'
                },
                {
                    field: 'konsumbu',
                    title: 'CNF.S',
                    width: 70,
                    sortable: false,
                    align: 'center'
                },
                {
                    field: 'bsumbu1',
                    title: 'S I',
                    width: 70,
                    sortable: false,
                    align: 'center'
                },
                {
                    field: 'bsumbu2',
                    title: 'S II',
                    width: 70,
                    sortable: false,
                    align: 'center'
                },
                {
                    field: 'bsumbu3',
                    title: 'S III',
                    width: 70,
                    sortable: false,
                    align: 'center'
                },
                {
                    field: 'bsumbu4',
                    title: 'S IV',
                    width: 70,
                    sortable: false,
                    align: 'center'
                },
            ]
        ],
        //        toolbar: "#search",
        onBeforeLoad: function(params) {
            params.textCategory = $('#text_category_rem').val();
        },
        onClickRow: function() {
            getInformationRem();
        },
        //        onLoadError: function () {
        //            return false;
        //        },
        //        onLoadSuccess: function () {
        //        }
    });

    function perhitungan() {
        var prosentase_total = 0;
        var selisih = 0;
        var prosentase_selisih = 0;
        //---------------------------------------------------
        var bsb1kr = parseInt($('#bsb1kr').val());
        var bsb1kn = parseInt($('#bsb1kn').val());
        var berat_sumbu1 = parseInt($('#bsumbu1').val());
        var prosentase_total_sumbu1 = 0;
        var selisih_sumbu1 = 0;
        var prosentase_selisih_sumbu1 = 0;
        prosentase_total_sumbu1 = Math.ceil((((bsb1kr + bsb1kn) / berat_sumbu1) * 100));
        selisih_sumbu1 = (bsb1kr - bsb1kn);
        if (selisih_sumbu1 < 0) {
            selisih_sumbu1 = selisih_sumbu1 * (-1);
        }
        prosentase_selisih_sumbu1 = Math.ceil(((selisih_sumbu1 / berat_sumbu1) * 100));
        if (berat_sumbu1 == 0) {
            prosentase_total_sumbu1 = 0;
            prosentase_selisih_sumbu1 = 0;
        }
        //---------------------------------------------------
        var bsb2kr = parseInt($('#bsb2kr').val());
        var bsb2kn = parseInt($('#bsb2kn').val());
        var berat_sumbu2 = parseInt($('#bsumbu2').val());
        var prosentase_total_sumbu2 = 0;
        var selisih_sumbu2 = 0;
        var prosentase_selisih_sumbu2 = 0;
        prosentase_total_sumbu2 = Math.ceil((((bsb2kr + bsb2kn) / berat_sumbu2) * 100));
        selisih_sumbu2 = (bsb2kr - bsb2kn);
        if (selisih_sumbu2 < 0) {
            selisih_sumbu2 = selisih_sumbu2 * (-1);
        }
        prosentase_selisih_sumbu2 = Math.ceil(((selisih_sumbu2 / berat_sumbu2) * 100));
        if (berat_sumbu2 == 0) {
            prosentase_total_sumbu2 = 0;
            prosentase_selisih_sumbu2 = 0;
        }
        //---------------------------------------------------
        var bsb3kr = parseInt($('#bsb3kr').val());
        var bsb3kn = parseInt($('#bsb3kn').val());
        var berat_sumbu3 = parseInt($('#bsumbu3').val());
        var prosentase_total_sumbu3 = 0;
        var selisih_sumbu3 = 0;
        var prosentase_selisih_sumbu3 = 0;
        prosentase_total_sumbu3 = Math.ceil((((bsb3kr + bsb3kn) / berat_sumbu3) * 100));
        selisih_sumbu3 = (bsb3kr - bsb3kn);
        if (selisih_sumbu3 < 0) {
            selisih_sumbu3 = selisih_sumbu3 * (-1);
        }
        prosentase_selisih_sumbu3 = Math.ceil(((selisih_sumbu3 / berat_sumbu3) * 100));
        if (berat_sumbu3 == 0) {
            prosentase_total_sumbu3 = 0;
            prosentase_selisih_sumbu3 = 0;
        }
        //---------------------------------------------------
        var bsb4kr = parseInt($('#bsb4kr').val());
        var bsb4kn = parseInt($('#bsb4kn').val());
        var berat_sumbu4 = parseInt($('#bsumbu4').val());
        var prosentase_total_sumbu4 = 0;
        var selisih_sumbu4 = 0;
        var prosentase_selisih_sumbu4 = 0;
        prosentase_total_sumbu4 = Math.ceil((((bsb4kr + bsb4kn) / berat_sumbu4) * 100));
        selisih_sumbu4 = (bsb4kr - bsb4kn);
        if (selisih_sumbu4 < 0) {
            selisih_sumbu4 = selisih_sumbu4 * (-1);
        }
        prosentase_selisih_sumbu4 = Math.ceil(((selisih_sumbu4 / berat_sumbu4) * 100));
        if (berat_sumbu4 == 0) {
            prosentase_total_sumbu4 = 0;
            prosentase_selisih_sumbu4 = 0;
        }
        //---------------------------------------------------

        $('#bsb1').val(prosentase_total_sumbu1.toFixed(0));
        $('#bsb2').val(prosentase_total_sumbu2.toFixed(0));
        $('#bsb3').val(prosentase_total_sumbu3.toFixed(0));
        $('#bsb4').val(prosentase_total_sumbu4.toFixed(0));
        $('#bsel1').val(prosentase_selisih_sumbu1.toFixed(0));
        $('#bsel2').val(prosentase_selisih_sumbu2.toFixed(0));
        $('#bsel3').val(prosentase_selisih_sumbu3.toFixed(0));
        $('#bsel4').val(prosentase_selisih_sumbu4.toFixed(0));
    }
</script>