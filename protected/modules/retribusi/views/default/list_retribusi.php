<!--<div class="row" style="padding: 0px 15px 0px 0px">-->
<?php // echo CHtml::hiddenField('tgl_search', date('d-M-y'), array('readonly' => 'readonly', 'class' => 'form-control')); 
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
    <div class="col-lg-8 col-md-8">
        <div class="col-lg-3 col-md-3">
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
        <div class="col-lg-3 col-md-3">
            <button type="button" class="btn btn-info" onclick="prosesSearch()">
                <span class="glyphicon glyphicon-refresh"></span> Refresh
            </button>
            <!--            <div class="btn-group" role="group" aria-label="...">
                            <button type="button" class="btn btn-info" onclick="prosesSearch()">
                                <span class="glyphicon glyphicon-refresh"></span> Refresh
                            </button>
                            <button type="button" class="btn btn-success" onclick="buttonPrintChecked('<?php // echo $this->createUrl('Default/CetakCheckedRetribusi');   
                                                                                                        ?>')">
                                <span class="glyphicon glyphicon-print"></span> Print Selected
                            </button>
                        </div>-->
        </div>
    </div>
</div>
<!--<div class="col-lg-12 col-md-12" style="padding: 10px;">
    <span style="color: red;" class="pull-left">*Retribusi Kendaraan untuk hari ini <?php // echo date('d F Y');      
                                                                                    ?></span>
</div>-->
<div class="col-lg-12 col-md-12" style="margin-top: 20px;">
    <table id="validasiListGrid"></table>
</div>
<div id="dlg" class="easyui-dialog" title="Edit Retribusi" style="width: 500px; height: 400px; padding: 10px;display: none" data-options="
     iconCls: 'icon-save',
     autoOpen: false,
     buttons: [{
     text:'Ok',
     iconCls:'icon-ok',
     handler:function(){
     saveEditRetribusi();
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
        <input type="hidden" id="dlg_idret_tglmati" name="dlg_idret_tglmati">
        <div class="form-group">
            <select id="pilih_kategori" class="form-control" name="pilih_kategori" onchange="pilihKategori('<?php echo $this->createUrl('Default/GetListSelect'); ?>')">
                <option value="0">-Pilih-</option>
                <option value="tgluji">Tanggal Uji</option>
                <option value="jenis_uji">Jenis Uji</option>
                <option value="buku">Kartu Uji</option>
                <option value="denda">Denda</option>
                <option value="jbb">JBB</option>
                <option value="numerator">Numerator</option>
                <option value="platuji">Sertifikat Uji</option>
                <option value="wilayah_asal">Wilayah Asal</option>
            </select>
        </div>
        <div class="form-group">
            <div class="input-group" id="div_ganti_tgl_uji" style="display: none">
                <div class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                </div>
                <input type="text" id="ganti_tgl_uji" name="ganti_tgl_uji" class="form-control" readonly="readonly" value="<?php echo date('d-M-y'); ?>">
            </div>
            <div class="input-group" id="div_ganti_tgl_mati" style="display: none">
                <div class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                </div>
                <input type="text" id="ganti_tgl_mati" name="ganti_tgl_mati" class="form-control" readonly="readonly" value="<?php echo date('d-M-y'); ?>">
            </div>
            <select class="form-control" id="kategori" name="kategori" style="display: none; margin-bottom:20px" onchange="selectJenisUjiDialog()"></select>
            <input type=" text" id="jbb" name="jbb" class="form-control" style="display: none;">
            <input type="text" id="edit_numerator" name="edit_numerator" class="form-control" style="display: none;">
            <div id="div_wilayah_asal_dialog" style="display: none">
                <?php
                $criteria_wilayah = new CDbCriteria();
                $criteria_wilayah->addNotInCondition('idx', array(12, 30, 145, 148, 149, 151));
                $criteria_wilayah->order = 'namawilayah asc';
                $tbl_wilayah = Kodewilayah::model()->findAll($criteria_wilayah);
                $type_wilayah = CHtml::listData($tbl_wilayah, 'kodewilayah', 'namawilayah');
                echo CHtml::dropDownList('wilayah_asal', '', $type_wilayah, array('class' => 'form-control selectpicker show-tick', 'data-live-search' => 'true', 'data-size' => '5', 'empty' => ''));
                ?>
            </div>
        </div>
    </form>
</div>
<div id="dlg_penguji" class="easyui-dialog" title="Cetak Stiker" style="width: 400px; height: auto; padding: 10px;display: none" data-options="
     iconCls: 'icon-print',
     autoOpen: false,
     buttons: [{
     text:'Print',
     iconCls:'icon-print',
     handler:function(){
     printCetakStiker();
     }
     }]
     ">
    <div class="col-lg-12 col-md-12 col-sm-12 no-padding">
        <div class="col-lg-12 col-md-12 col-sm-12 no-padding" style="margin-bottom: 10px;">
            <?php
            echo CHtml::hiddenField('dialog_url', '');
            echo CHtml::hiddenField('dialog_id', '');
            ?>
            <select id="dialog_penguji" class="form-control">
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
    </div>
</div>
<script>
    $('#validasiListGrid').datagrid({
        url: '<?php echo $this->createUrl('Default/ValidasiListGridPetugas'); ?>',
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
        pageSize: 10,
        pageList: [10, 20, 50],
        columns: [
            [
                //                {field: 'checkbox', align: 'center', checkbox: true},
                {
                    field: 'id',
                    hidden: true
                },
                {
                    field: 'ACTIONS',
                    title: 'Kuitansi',
                    width: 60,
                    halign: 'center',
                    align: 'center',
                    formatter: actionPrint
                },
                <?php if (Yii::app()->session['username'] == 'admin' || Yii::app()->session['username'] == 'qodrat') { ?> {
                        field: 'delete',
                        title: 'Delete',
                        width: 50,
                        halign: 'center',
                        align: 'center',
                        formatter: formatDelete
                    },
                <?php } ?> {
                    field: 'idret_tglmati',
                    title: 'Edit',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: formatAction
                },
                {
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
                    field: 'no_kendaraan',
                    width: 120,
                    title: 'No Kendaraan',
                    sortable: false
                },
                {
                    field: 'nama_pemilik',
                    width: 170,
                    title: 'Nama Pemilik',
                    sortable: false
                },
                {
                    field: 'uji',
                    width: 90,
                    title: 'Uji',
                    sortable: false
                },
                //                {field: 'jns', width: 90, title: 'Jns Kend', sortable: false},
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
            params.textCategory = $('#text_category').val();
            params.selectCategory = $('#select_category :selected').val();
            params.selectDate = $('#tgl_search').val();
        },
        onLoadError: function() {
            return false;
        },
        onLoadSuccess: function() {}
    });

    function formatDelete(value) {
        var button = '<button type="button" class="btn btn-danger delete-retribusi" onclick="buttonDeleteTerdaftar(\'' + value + '\')"><span class="glyphicon glyphicon-trash"></span></button>';
        return button;
    }

    function formatAction(value) {
        var button = '<button type="button" class="btn btn-info edit-retribusi" onclick="buttonEditTerdaftar(\'' + value + '\')"><span class="glyphicon glyphicon-pencil"></span></button>';
        return button;
    }

    function actionPrint(value) {
        var button = '<button type="button" class="btn btn-success edit-retribusi" onclick="cetakRetribusi(\'' + value + '\')"><span class="glyphicon glyphicon-print"></span></button>';
        return button;
    }

    function cetakRetribusi(id) {
        var url = '<?php echo $this->createUrl('Default/CetakRetribusi'); ?>';
        var win = window.open(url + "?id=" + id, '_blank');
        win.focus();
    }

    function buttonEditTerdaftar(value) {
        $('#dlg_idret_tglmati').val(value);
        $('#dlg').dialog('open');
        $('#dlg').dialog('center');
    }

    function buttonPrintChecked(urlAct) {
        var rows = $('#validasiListGrid').datagrid('getChecked');
        var ids = [];
        for (var i = 0; i < rows.length; i++) {
            ids.push(rows[i].id);
        }
        if (rows.length > 0) {
            var win = window.open(urlAct + "?idArray=" + ids, '_blank');
            win.focus();
        } else {
            $.messager.alert('Warning', 'You must select at least one item!', 'error');
            return false;
        }
    }

    function closeDialog() {
        $('#dlg').dialog('close');
        $('#dlg_penguji').dialog('close');
    }

    function prosesSearch() {
        $('#validasiListGrid').datagrid('reload');
    }

    function saveEditRetribusi() {
        var data = $("#form_edit").serialize();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('Default/UpdateRetribusi'); ?>',
            data: data,
            beforeSend: function() {
                showlargeloader();
            },
            success: function(data) {
                hidelargeloader();
                closeDialog();
                prosesSearch();
            },
            error: function() {
                hidelargeloader();
                return false;
            }
        });
    }

    $(document).on("keypress", '#text_category', function(e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            prosesSearch();
            return false;
        }
    });

    $(document).ready(function() {
        closeDialog();
        $('#ganti_tgl_uji').datepicker({
            startDate: "today",
            format: 'dd-M-yy',
            daysOfWeekDisabled: [0, 7],
            autoclose: true,
        });
        $('#ganti_tgl_mati').datepicker({
            format: 'dd-M-yy',
            daysOfWeekDisabled: [0, 7],
            autoclose: true,
        });
        $('#tgl_search').datepicker({
            format: 'dd-M-yyyy',
            daysOfWeekDisabled: [0, 7],
            autoclose: true,
        }).on('changeDate', prosesSearch);
    });

    function buttonDialogPenguji(id) {
        var urlAct = '<?php echo $this->createUrl('Default/CetakStiker'); ?>';
        $('#dialog_id').val(id);
        $('#dialog_url').val(urlAct);
        $('#dlg_penguji').dialog('open');
        $('#dlg_penguji').dialog('center');

    }

    function printCetakStiker() {
        var id = $('#dialog_id').val();
        var url = $('#dialog_url').val();
        var penguji = $('#dialog_penguji :selected').val();
        closeDialog();
        var win = window.open(url + "?id=" + id + "&penguji=" + penguji, '_blank');
        win.focus();
    }

    function buttonDeleteTerdaftar(value) {
        $.messager.confirm('Delete Retribusi', 'Apakah anda yakin ingin delete?', function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('Default/DeleteRetribusi'); ?>',
                    data: {
                        id: value
                    },
                    success: function(data) {
                        $('#validasiListGrid').datagrid('reload');
                    },
                    error: function() {
                        return false;
                    }
                });
            }
        });
    }
</script>