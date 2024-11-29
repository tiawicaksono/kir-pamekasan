<style>
    .datagrid-row {
        min-height: 40px;
        height: 40px;
    }

    #button_save_lulus {
        background: #E53935;
        color: #fff;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Cetak Print Hasil</h3>
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
                            <select id="choose_kelulusan" class="form-control" onchange="prosesSearch()">
                                <option value="all" selected="true">- Semua L/TL-</option>
                                <option value="true">Lulus</option>
                                <option value="false">Tidak Lulus</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <select id="choose_cetak" class="form-control" onchange="prosesSearch()">
                                <option value="all">- Semua Cetak/Belum-</option>
                                <option value="false" selected="true">Belum Cetak</option>
                                <option value="true">Sudah Cetak</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <button type="button" class="btn btn-info" onclick="prosesSearch()">
                                <span class="glyphicon glyphicon-refresh"></span> Refresh
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12" style="margin-top: 20px">
                        <table id="statusProsesListGrid"></table>
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
                $penguji = Penguji::model()->findAll();
                foreach ($penguji as $dataPenguji) :
                ?>
                    <option value="<?php echo $dataPenguji->idx; ?>"><?php echo $dataPenguji->nama; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 no-padding">
            <?php
            echo CHtml::hiddenField('dialog_url', '');
            echo CHtml::hiddenField('dialog_id', '');
            ?>
        </div>
    </div>
</div>
<div id="dlg_cetak_hasil" class="easyui-dialog" title="Cetak Hasil Uji" style="width: 400px; height: auto; padding: 10px;display: none" data-options="
     iconCls: 'icon-print',
     autoOpen: false,
     buttons: [{
     id: 'button_save_lulus',
     text:'Kartu',
     iconCls:'icon-save',
     handler:function(){
     submitLulus();
     }},{
     text:'Print',
     iconCls:'icon-print',
     handler:function(){
     cetakLulus();
     }
     }]
     ">
    <div class="col-lg-12 col-md-12 col-sm-12 no-padding">
        <div class="col-lg-12 col-md-12 col-sm-12 no-padding" style="margin-bottom: 10px;">
            <input type="text" id="no_seri_kartu" class="form-control" placeholder="No Seri Kartu" style="text-transform: uppercase;" />
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 no-padding" style="margin-bottom: 10px;">
            <select id="choose_lulus_penguji" class="form-control">
                <?php
                $penguji = Penguji::model()->findAll();
                foreach ($penguji as $dataPenguji) :
                ?>
                    <option value="<?php echo $dataPenguji->idx; ?>">
                        <?php echo $dataPenguji->nama; ?>
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
     closeDialogBlokir();
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
<script>
    $('#statusProsesListGrid').datagrid({
        url: '<?php echo $this->createUrl('Printhasil/PrintHasilListGrid'); ?>',
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
        pageSize: 15,
        pageList: [15, 30, 50],
        columns: [
            [{
                    field: 'foto',
                    title: 'Foto',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: buttonImage
                },
                {
                    field: 'cetak',
                    width: 80,
                    title: 'CETAK',
                    sortable: false,
                    halign: 'center',
                    align: 'center',
                    formatter: buttonCetak
                },
                {
                    field: 'no_kendaraan',
                    width: 90,
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
                    field: 'nama_pemilik',
                    title: 'Nama Pemilik',
                    width: 200,
                    sortable: false
                },
                {
                    field: 'prauji',
                    width: 50,
                    title: 'Pra Uji',
                    sortable: false,
                    halign: 'center',
                    align: 'center'
                },
                {
                    field: 'emisi',
                    width: 50,
                    title: 'Emisi',
                    sortable: false,
                    halign: 'center',
                    align: 'center'
                },
                {
                    field: 'lampu',
                    width: 50,
                    title: 'Lampu',
                    sortable: false,
                    halign: 'center',
                    align: 'center'
                },
                {
                    field: 'rem',
                    width: 50,
                    title: 'Brake',
                    sortable: false,
                    halign: 'center',
                    align: 'center'
                },
                {
                    field: 'pitlift',
                    width: 50,
                    title: 'Pit Lift',
                    sortable: false,
                    halign: 'center',
                    align: 'center'
                },
                {
                    field: 'nm_penguji',
                    width: 300,
                    title: 'Penguji',
                    sortable: false,
                    halign: 'center'
                },
            ]
        ],
        onBeforeLoad: function(params) {
            params.tanggal = $('#tgl_search').val();
            params.chooseKelulusan = $('#choose_kelulusan :selected').val();
            params.chooseCetak = $('#choose_cetak :selected').val();
            params.textCategory = $('#text_category').val();
        },
        onLoadError: function() {
            return false;
        },
        onLoadSuccess: function() {}
    });

    function bandingPraujiButton(value) {
        var button;
        var urlact = '<?php echo $this->createUrl('/pengujian/Default/ProsesBandingPrauji'); ?>';
        button = '<button type="button" data-toggle="tooltip" title="Banding" class="btn btn-danger" onclick="buttonBanding(' + value + ', \'' + urlact + '\')"><span class="glyphicon glyphicon-random"></span></button>';
        return button;
    }

    function bandingPengukuranButton(value) {
        var button;
        var urlact = '<?php echo $this->createUrl('/pengujian/Default/ProsesBandingPengukuran'); ?>';
        button = '<button type="button" data-toggle="tooltip" title="Banding" class="btn btn-danger" onclick="buttonBanding(' + value + ', \'' + urlact + '\')"><span class="glyphicon glyphicon-random"></span></button>';
        return button;
    }

    function prosesSearch() {
        $('#statusProsesListGrid').datagrid('reload');
    }

    function closeDialogBlokir() {
        $('#dlgBlokir').dialog('close');
    }

    $(document).on("keypress", '#text_category', function(e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            prosesSearch();
            return false;
        }
    });

    $("#dlg_cetak_hasil").keydown(function(event) {
        if (event.keyCode == 13) {
            $(this).parent()
                .find("#button_print_lulus").trigger("click");
            return false;
        }
    });

    function buttonBanding(value, urlAct) {
        $.messager.confirm('Confirm', 'Apakah anda yakin ingin banding?', function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: urlAct,
                    data: {
                        id_hasil_uji: value
                    },
                    beforeSend: function() {
                        showlargeloader();
                    },
                    success: function(data) {
                        $('#statusProsesListGrid').datagrid('reload');
                        hidelargeloader();
                    },
                    error: function() {
                        $('#statusProsesListGrid').datagrid('reload');
                        hidelargeloader();
                        return false;
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        $('#dlg_no_surat').dialog('close');
        $('#dlg_cetak_hasil').dialog('close');
        $('#dlgBlokir').dialog('close');
        $('#tgl_search').datepicker({
            endDate: "today",
            format: 'dd-M-yyyy',
            daysOfWeekDisabled: [0, 7],
            autoclose: true,
        }).on('changeDate', prosesSearch);
    });

    function buttonCetak(value) {
        var button;
        var explode = value.split('|');
        var ltl = explode[0];
        var id = explode[1];
        var noSurat = explode[2];
        var noSeriKartu = explode[3];
        var url = '';
        if (ltl == 'l') {
            url = '<?php echo $this->createUrl('Printhasil/cetakl'); ?>';
            button = '<button class="btn btn-success" type="button" onclick="buttonDialogPosisi(\'' + url + '\', \'' + id + '\', \'' + noSeriKartu + '\')"><span class="glyphicon glyphicon-duplicate"></span></button>';
        } else if (ltl == 'tl') {
            url = '<?php echo $this->createUrl('Printhasil/cetaktl'); ?>';
            button = '<button class="btn btn-danger" type="button" onclick="buttonDialogNoSurat(\'' + url + '\', \'' + id + '\', \'' + noSurat + '\')"><span class="glyphicon glyphicon-duplicate"></span></button>';
        } else {
            button = "<button class='btn btn-default' type='button' disabled='disabled'><span class='glyphicon glyphicon-duplicate'></span></button>";
        }
        return button;
    }

    function submitLulus() {
        var no_seri_kartu = $("#no_seri_kartu").val();
        var posisi = $("#choose_posisi option:selected").val();
        var penguji = $("#choose_lulus_penguji option:selected").val();
        var id = $('#dialog_lulus_id').val();
        var url = $('#dialog_lulus_url').val();
        $.ajax({
            url: '<?php echo $this->createUrl('Printhasil/SaveCetakl'); ?>',
            type: 'POST',
            data: {
                posisi: posisi,
                penguji: penguji,
                id: id,
                no_seri_kartu: no_seri_kartu
            },
            success: function(data) {
                $('#dlg_cetak_hasil').dialog('close');
                prosesSearch();
            },
            error: function(data) {
                $('#dlg_cetak_hasil').dialog('close');
                prosesSearch();
                return false;
            }
        });
    }

    function cetakLulus() {
        var no_seri_kartu = $("#no_seri_kartu").val();
        var posisi = $("#choose_posisi option:selected").val();
        var penguji = $("#choose_lulus_penguji option:selected").val();
        var id = $('#dialog_lulus_id').val();
        var url = $('#dialog_lulus_url').val();
        $.ajax({
            url: '<?php echo $this->createUrl('Printhasil/SaveCetakl'); ?>',
            type: 'POST',
            data: {
                posisi: posisi,
                penguji: penguji,
                id: id,
                no_seri_kartu: no_seri_kartu
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
        $('#dlg_no_surat').dialog('open');
    }

    function buttonDialogPosisi(urlAct, id, noSeriKartu) {
        $('#dialog_lulus_id').val(id);
        $('#dialog_lulus_url').val(urlAct);
        $('#no_seri_kartu').val(noSeriKartu);
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

    function blokirButton(value) {
        var button;
        button = '<button type="button" class="btn btn-warning" onclick="buttonDialogBlokir(' + value + ')"><span class="glyphicon glyphicon glyphicon-floppy-remove"></span></button>';
        return button;
    }

    function unblokirButton(value) {
        var button;
        var urlact = '<?php echo $this->createUrl('Printhasil/ProsesUnBlokir'); ?>';
        button = '<button type="button" class="btn btn-info" onclick="prosesUnBlokirButton(' + value + ', \'' + urlact + '\')"><span class="glyphicon glyphicon-floppy-saved"></span></button>';
        return button;
    }

    function buttonDialogBlokir(value) {
        $('#dlg_id_kendaraan').val(value);
        $('#dlgBlokir').dialog('open');
        $('#dlgBlokir').dialog('center');
    }

    function prosesBlokir() {
        var data = $("#form_blokir").serialize();
        $.messager.confirm('Confirm', 'Apakah anda yakin ingin blokir?', function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('Printhasil/ProsesBlokir'); ?>',
                    data: data,
                    beforeSend: function() {
                        showlargeloader();
                    },
                    success: function(data) {
                        closeDialogBlokir();
                        prosesSearch();
                        hidelargeloader();
                    },
                    error: function() {
                        closeDialogBlokir();
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
                        prosesSearch();
                        hidelargeloader();
                    },
                    error: function() {
                        prosesSearch();
                        hidelargeloader();
                        return false;
                    }
                });
            }
        });
    }

    function buttonImage(value) {
        var urlAct = '<?php echo $this->createUrl('Printhasil/ViewImage'); ?>';
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
</script>