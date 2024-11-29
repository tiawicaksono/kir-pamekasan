<?php
$path = $this->module->assetsUrl;
$baseJs = Yii::app()->appComponent->urlJs();
$baseCss = Yii::app()->appComponent->urlCss();
$cs = Yii::app()->clientScript;
$cs->registerCssFile($baseCss . '/bootstrap-select.css');
$cs->registerScriptFile($path . '/js/verifikasi.js', CClientScript::POS_END);
$cs->registerScriptFile($baseJs . '/bootstrap-select.js', CClientScript::POS_END);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Verifikasi</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        - Report -
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="javascript:void(0)" onclick="cetakReport('<?php echo $this->createUrl('verifikasi/ReportKelulusanExcel'); ?>')"><i class="fa fa-file-excel-o" style="color: green;"></i> Excel</a></li>
                        <li><a href="javascript:void(0)" onclick="cetakReport('<?php echo $this->createUrl('verifikasi/ReportKelulusanPdf'); ?>')"><i class="fa fa-file-pdf-o" style="color: red;"></i> PDF</a></li>
                    </ul>
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
                        <div class="col-lg-3 col-md-3">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <select class="btn" id="select_category">
                                        <option value="nomor_antrian">No Antrian</option>
                                        <option value="no_kend_uji" selected="selected">No. Uji / Kend</option>
                                    </select>
                                </span>
                                <?php echo CHtml::textField('text_category', '', array('class' => 'form-control text-besar')); ?>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <select id="choose_proses" class="form-control" onchange="prosesSearch()">
                                <option value="all" selected="true">- Semua -</option>
                                <option value="true">Lulus</option>
                                <option value="false">Tidak Lulus</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <button type="button" class="btn btn-info" onclick="prosesSearch()">
                                <span class="glyphicon glyphicon-refresh"></span>
                                Refresh
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12" style="margin-top: 20px">
                    <table id="pemeriksaanTglListGrid"></table>
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
    </div>
</div>
<div id="dlg" class="easyui-dialog" title="Edit Kelulusan" style="width: 700px; height: 400px; padding: 10px;display: none" data-options="
     iconCls: 'icon-save',
     autoOpen: false,
     buttons: [{
     text:'Ok',
     iconCls:'icon-ok',
     handler:function(){
     updateVerifikasi();
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
        <input type="hidden" id="dlg_id_hasil_uji" name="id_hasil_uji">
        <label class="checkbox-inline">
            <input type="checkbox" name="check_prauji" id="inlineCheckbox1" value="prauji" style="width: 30px;">
            <font style="font-size: 14px;">&nbsp;&nbsp;Prauji</font>
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="check_emisi" id="inlineCheckbox2" value="emisi" style="width: 30px;">
            <font style="font-size: 14px;">&nbsp;&nbsp;Emisi</font>
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="check_pitlift" id="inlineCheckbox3" value="pitlift" style="width: 30px;">
            <font style="font-size: 14px;">&nbsp;&nbsp;Pitlift</font>
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="check_lampu" id="inlineCheckbox2" value="lampu" style="width: 30px;">
            <font style="font-size: 14px;">&nbsp;&nbsp;Lampu</font>
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="check_rem" id="inlineCheckbox3" value="rem" style="width: 30px;">
            <font style="font-size: 14px;">&nbsp;&nbsp;Rem</font>
        </label>
        <div class="form-group" style="margin-top: 15px;">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="glyphicon glyphicon-ok"></i>
                </div>
                <select id="kelulusan" name="kelulusan" class="form-control">
                    <option value="true" selected="true">Lulus</option>
                    <option value="false">Tidak Lulus</option>
                </select>
            </div>
        </div>
        <div class="col-md-10" style="padding:0px;">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="glyphicon glyphicon-ok"></i>
                    </div>
                    <?php
                    $data_list_kelulusan = TblKelulusan::model()->findAll();
                    $list_kelulusan = CHtml::listData($data_list_kelulusan, 'kd_lulus', 'kelulusan');
                    echo CHtml::dropDownList('list_kelulusan', '', $list_kelulusan, array('class' => 'form-control selectpicker', 'data-width' => '520px', 'data-live-search' => 'true', 'data-size' => '5', 'multiple' => 'multiple'));
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-info" onclick="deselecAll()">
                <span class="glyphicon glyphicon-refresh"></span> Clear All
            </button>
        </div>
    </form>
</div>

<div id="dlgBlokir" class="easyui-dialog" title="Dialog Keterangan Blokir" style="width: 400px; height: auto; padding: 10px;display: none" data-options="
     iconCls: 'icon-save',
     autoOpen: false,
     buttons: [{
     text:'Ok',
     iconCls:'icon-ok',
     handler:function(){
     prosesBlokir();
     }
     },{
     text:'Cancel',
     iconCls:'icon-cancel',
     handler:function(){
     closeDialog();
     }
     }]
     ">
    <form id="form_blokir">
        <input type="hidden" id="dlg_id_kendaraan" name="id_kendaraan">
        <div class="form-group">
            <textarea id="keterangan_blokir" name="keterangan_blokir" class="form-control"></textarea>
        </div>
    </form>
</div>
<div id="dlg_no_surat" class="easyui-dialog" title="No Surat" style="width: 400px; height: auto; padding: 10px;display: none" data-options="
     iconCls: 'icon-print',
     autoOpen: false,
     buttons: [{
     text:'Print',
     iconCls:'icon-print',
     handler:function(){
     cetakTidakLulus();
     }
     }]
     ">
    <div class="col-lg-12 col-md-12 col-sm-12 no-padding">
        <div class="col-lg-12 col-md-12 col-sm-12 no-padding" style="margin-bottom: 10px;">
            <select id="choose_penguji" class="form-control">
                <?php
                $penguji = TblNamaPenguji::model()->findAllByAttributes(array('status_penguji' => true));
                foreach ($penguji as $dataPenguji) :
                ?>
                    <option value="<?php echo $dataPenguji->nrp; ?>"><?php echo $dataPenguji->nama_penguji; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 no-padding">
            <?php
            echo CHtml::hiddenField('dialog_url', '');
            echo CHtml::hiddenField('dialog_id', '');
            //            echo CHtml::textField('dialog_no_surat', '', array('class' => 'form-control text-besar'));
            ?>
        </div>
    </div>
</div>
<div id="dlg_cetak_hasil" class="easyui-dialog" title="Cetak Hasil Uji" style="width: 400px; height: auto; padding: 10px;display: none" data-options="
     iconCls: 'icon-print',
     autoOpen: false,
     buttons: [{
     text:'Print',
     iconCls:'icon-print',
     handler:function(){
     cetakLulus();
     }
     }]
     ">
    <div class="col-lg-12 col-md-12 col-sm-12 no-padding">
        <div class="col-lg-12 col-md-12 col-sm-12 no-padding" style="margin-bottom: 10px;">
            <select id="choose_lulus_penguji" class="form-control">
                <?php
                $penguji = TblNamaPenguji::model()->findAllByAttributes(array('status_penguji' => true));
                foreach ($penguji as $dataPenguji) :
                ?>
                    <option value="<?php echo $dataPenguji->nrp; ?>">
                        <?php echo $dataPenguji->nama_penguji; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 no-padding">
            <?php
            echo CHtml::hiddenField('dialog_lulus_url', '');
            echo CHtml::hiddenField('dialog_lulus_id', '');
            ?>
            <select id="choose_posisi" class="form-control">
                <option value="kiri">Kiri</option>
                <option value="kanan">Kanan</option>
            </select>
        </div>
    </div>
</div>
<script>
    $('#pemeriksaanTglListGrid').datagrid({
        url: '<?php echo $this->createUrl('Verifikasi/VerifikasiListGrid'); ?>',
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
        pageSize: 20,
        pageList: [20, 30, 50],
        pagePosition: "top bottom",
        columns: [
            [
                // {
                //     field: 'cetak',
                //     width: 50,
                //     title: 'Cetak',
                //     sortable: false,
                //     halign: 'center',
                //     align: 'center',
                //     formatter: buttonCetak
                // },
                {
                    field: 'foto',
                    title: 'Foto',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: buttonImage
                },
                {
                    field: 'id_kendaraan',
                    title: 'Blokir',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: blokirButton
                },
                <?php if (Yii::app()->user->isRole('Admin')) { ?> {
                        field: 'kendaraan_id',
                        title: 'Un-Blok',
                        width: 50,
                        halign: 'center',
                        align: 'center',
                        formatter: unblokirButton
                    },
                <?php } ?> {
                    field: 'blokir',
                    width: 100,
                    title: 'Blokir',
                    sortable: false
                },
                {
                    field: 'no_kendaraan',
                    width: 105,
                    title: 'No Kendaraan',
                    sortable: false
                },
                {
                    field: 'no_uji',
                    title: 'No Uji',
                    width: 100,
                    sortable: false
                },
                {
                    field: 'prauji',
                    width: 80,
                    title: 'Pra Uji',
                    sortable: false,
                    halign: 'center',
                    align: 'center'
                },
                {
                    field: 'emisi',
                    width: 80,
                    title: 'Emisi',
                    sortable: false,
                    halign: 'center',
                    align: 'center'
                },
                {
                    field: 'lampu',
                    width: 80,
                    title: 'Lampu',
                    sortable: false,
                    halign: 'center',
                    align: 'center'
                },
                {
                    field: 'rem',
                    width: 80,
                    title: 'Brake',
                    sortable: false,
                    halign: 'center',
                    align: 'center'
                },
                {
                    field: 'pitlift',
                    width: 80,
                    title: 'Pit Lift',
                    sortable: false,
                    halign: 'center',
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
                {
                    field: 'catatan',
                    width: 450,
                    title: 'Catatan TL',
                    sortable: false
                },
            ]
        ],
        //        toolbar: "#search",
        onBeforeLoad: function(params) {
            params.tanggal = $('#tgl_search').val();
            params.chooseProses = $('#choose_proses :selected').val();
            params.textCategory = $('#text_category').val();
            params.selectCategory = $('#select_category :selected').val();
        },
        onLoadError: function() {
            return false;
        },
        onLoadSuccess: function() {}
    });

    function formatAction(value) {
        var button;
        var urlact = '<?php echo $this->createUrl('Verifikasi/formEditKelulusan'); ?>';
        button = '<button type="button" data-toggle="tooltip" title="Edit Kelulusan" class="btn btn-success" onclick="buttonEditVerifikasi(' + value + ', \'' + urlact + '\')"><span class="glyphicon glyphicon-pencil"></span></button>';
        return button;
    }

    function bandingPraujiButton(value) {
        var button;
        var urlact = '<?php echo $this->createUrl('Verifikasi/ProsesBandingPrauji'); ?>';
        button = '<button type="button" data-toggle="tooltip" title="Banding" class="btn btn-danger" onclick="buttonBanding(' + value + ', \'' + urlact + '\')"><span class="glyphicon glyphicon-random"></span></button>';
        return button;
    }

    function bandingPengukuranButton(value) {
        var button;
        var urlact = '<?php echo $this->createUrl('Verifikasi/ProsesBandingPengukuran'); ?>';
        button = '<button type="button" data-toggle="tooltip" title="Banding" class="btn btn-danger" onclick="buttonBanding(' + value + ', \'' + urlact + '\')"><span class="glyphicon glyphicon-random"></span></button>';
        return button;
    }

    function blokirButton(value) {
        var button;
        button = '<button type="button" class="btn btn-warning" onclick="buttonDialogBlokir(' + value + ')"><span class="glyphicon glyphicon-floppy-remove"></span></button>';
        return button;
    }

    function unblokirButton(value) {
        var button;
        var urlact = '<?php echo $this->createUrl('Verifikasi/ProsesUnBlokir'); ?>';
        button = '<button type="button" class="btn btn-info" onclick="prosesUnBlokirButton(' + value + ', \'' + urlact + '\')"><span class="glyphicon glyphicon-floppy-saved"></span></button>';
        return button;
    }

    function deselecAll() {
        $('#list_kelulusan').selectpicker('deselectAll');
    }

    function updateVerifikasi() {
        var data = $("#form_edit").serialize();
        $.ajax({
            url: '<?php echo $this->createUrl('Verifikasi/UpdateVerifikasi'); ?>',
            type: 'POST',
            data: data,
            beforeSend: function() {
                showlargeloader();
            },
            success: function(data) {
                closeDialog();
                prosesSearch();
                hidelargeloader();
            },
            error: function(data) {
                closeDialog();
                hidelargeloader();
                return false;
            }
        });
    }

    function prosesBlokir() {
        var data = $("#form_blokir").serialize();
        $.messager.confirm('Confirm', 'Apakah anda yakin ingin blokir?', function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('Verifikasi/ProsesBlokir'); ?>',
                    data: data,
                    beforeSend: function() {
                        showlargeloader();
                    },
                    success: function(data) {
                        closeDialog();
                        prosesSearch();
                        hidelargeloader();
                    },
                    error: function() {
                        closeDialog();
                        prosesSearch();
                        hidelargeloader();
                        return false;
                    }
                });
            }
        });
    }

    function prosesUnBlokirButton(value, urlAct) {
        $.messager.confirm('Confirm', 'Apakah anda yakin ingin un-blokir?', function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: urlAct,
                    data: {
                        id_kendaraan: value
                    },
                    beforeSend: function() {
                        showlargeloader();
                    },
                    success: function(data) {
                        $('#pemeriksaanTglListGrid').datagrid('reload');
                        hidelargeloader();
                    },
                    error: function() {
                        $('#pemeriksaanTglListGrid').datagrid('reload');
                        hidelargeloader();
                        return false;
                    }
                });
            }
        });
    }

    function cetakReport(urlAct) {
        var tgl = $('#tgl_search').val();
        window.location.href = urlAct + "?tgl=" + tgl;
        return false;
    }

    function buttonCetak(value) {
        var button;
        var explode = value.split('|');
        var ltl = explode[0];
        var id = explode[1];
        var noSurat = explode[2];
        var penguji = explode[3];
        var url = '';
        if (ltl == 'l') {
            url = '<?php echo $this->createUrl('verifikasi/cetakl'); ?>';
            button = '<button class="btn btn-success" type="button" onclick="buttonDialogPosisi(\'' + url + '\', \'' + id + '\', \'' + penguji + '\')"><span class="glyphicon glyphicon-duplicate"></span></button>';
        } else if (ltl == 'tl') {
            url = '<?php echo $this->createUrl('verifikasi/cetaktl'); ?>';
            button = '<button class="btn btn-danger" type="button" onclick="buttonDialogNoSurat(\'' + url + '\', \'' + id + '\', \'' + noSurat + '\', \'' + penguji + '\')"><span class="glyphicon glyphicon-duplicate"></span></button>';
        }
        return button;
    }

    function cetakLulus() {
        var posisi = $("#choose_posisi option:selected").val();
        var penguji = $("#choose_lulus_penguji option:selected").val();
        var id = $('#dialog_lulus_id').val();
        var url = $('#dialog_lulus_url').val();
        $.ajax({
            url: '<?php echo $this->createUrl('verifikasi/SaveCetakl'); ?>',
            type: 'POST',
            data: {
                posisi: posisi,
                penguji: penguji,
                id: id
            },
            success: function(data) {
                $('#dlg_cetak_hasil').dialog('close');
                prosesSearch();
                prosesCetakLulus(url, id, posisi, penguji);
            },
            error: function(data) {
                $('#dlg_cetak_hasil').dialog('close');
                prosesSearch();
                return false;
            }
        });
    }

    function prosesCetakLulus(url, id, posisi, penguji) {
        var win = window.open(url + "?id=" + id + "&posisi=" + posisi + "&nrp=" + penguji, '_blank');
        win.focus();
    }

    function cetakTidakLulus() {
        //        var no_surat = $('#dialog_no_surat').val();
        var no_surat = '';
        var penguji = $("#choose_penguji option:selected").val();
        var id = $('#dialog_id').val();
        var url = $('#dialog_url').val();
        $('#dlg_no_surat').dialog('close');
        prosesSearch();
        var win = window.open(url + "?id=" + id + "&nosurat=" + no_surat + "&nrp=" + penguji, '_blank');
        win.focus();
    }

    function buttonDialogNoSurat(urlAct, id, noSurat) {
        $('#dialog_id').val(id);
        $('#dialog_url').val(urlAct);
        //        $('#dialog_no_surat').val(noSurat);
        $('#dlg_no_surat').dialog('open');
    }

    function buttonDialogPosisi(urlAct, id) {
        $('#dialog_lulus_id').val(id);
        $('#dialog_lulus_url').val(urlAct);
        $('#dlg_cetak_hasil').dialog({
            open: function() {
                $(document).on("keypress", '#button_print_lulus', function(e) {
                    var code = e.keyCode || e.which;
                    if (code == 13) {
                        cetakLulus();
                        return false;
                    }
                });
            }
        });
    }

    function buttonImage(value) {
        var urlAct = '<?php echo $this->createUrl('Verifikasi/ViewImage'); ?>';
        var button = '<button type="button" class="btn btn-primary" onclick="viewImage(' + value + ', \'' + urlAct + '\')"><span class="glyphicon glyphicon-picture"></span></button>';
        return button;
    }

    function viewImage(idHasilUji, urlAct) {
        $.ajax({
            url: urlAct,
            type: 'POST',
            data: {
                idHasilUji: idHasilUji
            },
            dataType: 'JSON',
            beforeSend: function() {
                showlargeloader();
            },
            success: function(data) {
                hidelargeloader();
                $("#img_depan").attr('src', 'data:image/jpeg;base64,' + data.img_depan);
                $("#img_belakang").attr('src', 'data:image/jpeg;base64,' + data.img_belakang);
                $("#img_kanan").attr('src', 'data:image/jpeg;base64,' + data.img_kanan);
                $("#img_kiri").attr('src', 'data:image/jpeg;base64,' + data.img_kiri);
                var bottom = $(document).height() - $(window).height();
                $('html, body').stop().animate({
                    scrollTop: $("#img_depan").offset().top
                }, 1500, 'swing');
            },
            error: function(data) {
                hidelargeloader();
                return false;
            }
        });
    }

    function deleteKeteranganTl(id_list_lulus) {
        $.ajax({
            url: '<?php echo $this->createUrl('verifikasi/DeleteKeteranganTl'); ?>',
            type: 'POST',
            data: {
                idListLulus: id_list_lulus
            },
            dataType: 'JSON',
            beforeSend: function() {
                showlargeloader();
            },
            success: function(data) {
                prosesSearch();
            },
            error: function(data) {
                hidelargeloader();
                prosesSearch();
                return false;
            }
        });
    }
</script>