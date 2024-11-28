<?php
$path = $this->module->assetsUrl;
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->clientScript;
$cs->registerScriptFile($path . '/js/master.js', CClientScript::POS_END);
//$cs->registerScriptFile($baseUrl . '/js/jQuery.print.js', CClientScript::POS_END);
?>
<div class="row">
    <section class="col-lg-6 col-md-12 no-padding">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">.:: Master Kepala Dinas</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php echo CHtml::beginForm('', 'post', array('class' => 'form-horizontal', 'id' => 'forminputkepaladinas')); ?>
                        <div class="col-lg-4 col-md-12">
                            <div class="col-lg-12 no-padding" style="margin-bottom: 10px;">
                                <?php
                                echo CHtml::hiddenField('id_kepaladinas', '');
                                echo CHtml::textField('nip', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: NIP'));
                                echo CHtml::textArea('kepaladinas', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: NAMA KEPALA DINAS'));
                                echo CHtml::textField('pangkat', '', array('class' => 'form-control', 'placeholder' => '.:: PANGKAT'));
                                ?>
                            </div>
                            <div class="col-lg-12 no-padding">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary" onclick="save('kepaladinas', '<?php echo $this->createUrl('Default/SaveKepalaDinas'); ?>', 'new')">SAVE</button>
                                </div>
                            </div>
                        </div>
                        <?php echo CHtml::endForm(); ?>
                        <div class="col-lg-8 col-md-12">
                            <?php echo CHtml::textField('kepala_dinas_search', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: SEARCH PENGUJI')); ?>
                            <table id="kepaladinasListGrid"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">.:: Master Penguji</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php echo CHtml::beginForm('', 'post', array('class' => 'form-horizontal', 'id' => 'forminputpenguji')); ?>
                        <div class="col-lg-4 col-md-12">
                            <div class="col-lg-12 no-padding" style="margin-bottom: 10px;">
                                <?php
                                echo CHtml::hiddenField('id_penguji', '');
                                echo CHtml::textField('nrp', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: NRP'));
                                echo CHtml::textArea('penguji', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: NAMA PENGUJI'));
                                echo CHtml::textField('jabatan', '', array('class' => 'form-control', 'placeholder' => '.:: JABATAN'));
                                ?>
                                <label>
                                    <input id="ttd" name="ttd" type="checkbox" class="flat-red"> Tandatangan?
                                </label>
                            </div>
                            <div class="col-lg-12 no-padding">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary" onclick="save('penguji', '<?php echo $this->createUrl('Default/SavePenguji'); ?>', 'update')">SAVE</button>
                                </div>
                            </div>
                        </div>
                        <?php echo CHtml::endForm(); ?>
                        <div class="col-lg-8 col-md-12">
                            <?php echo CHtml::textField('penguji_search', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: SEARCH PENGUJI')); ?>
                            <table id="pengujiListGrid"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">.:: Master User</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php echo CHtml::beginForm('', 'post', array('class' => 'form-horizontal', 'id' => 'forminputuser')); ?>
                        <div class="col-lg-4 col-md-12">
                            <div class="col-lg-12 no-padding" style="margin-bottom: 10px;">
                                <?php
                                echo CHtml::textField('username', '', array('class' => 'form-control', 'placeholder' => '.:: USERNAME'));
                                echo CHtml::passwordField('password', '', array('class' => 'form-control', 'placeholder' => '.:: PASSWORD'));
                                echo CHtml::dropDownList('hak_akses', '', array(
                                    'Admin' => 'Admin',
                                    'Loket' => 'Loket',
                                    'Penguji' => 'Penguji',
                                ), array('class' => 'form-control'));
                                ?>
                            </div>
                            <div class="col-lg-12 no-padding">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary" onclick="saveUser('<?php echo $this->createUrl('Default/SaveUser'); ?>')">SAVE</button>
                                </div>
                            </div>
                        </div>
                        <?php echo CHtml::endForm(); ?>
                        <div class="col-lg-8 col-md-12">
                            <?php echo CHtml::textField('user_search', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: SEARCH USER')); ?>
                            <table id="userListGrid"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">.:: Master Jenis Karoseri</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php echo CHtml::beginForm('', 'post', array('class' => 'form-horizontal', 'id' => 'forminputkaroseri')); ?>
                        <div class="col-lg-6 col-md-12">
                            <div class="col-lg-12 no-padding" style="margin-bottom: 10px;">
                                <?php
                                echo CHtml::hiddenField('id_karoseri', '');
                                echo CHtml::textArea('karoseri', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: INPUT JENIS KAROSERI'));
                                ?>
                            </div>
                            <div class="col-lg-12 no-padding">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary" onclick="save('karoseri', '<?php echo $this->createUrl('Default/SaveKaroseri'); ?>', 'update')">SAVE</button>
                                </div>
                            </div>
                        </div>
                        <?php echo CHtml::endForm(); ?>
                        <div class="col-lg-6 col-md-12">
                            <?php echo CHtml::textField('karoseri_search', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: SEARCH JENIS KAROSERI')); ?>
                            <table id="karoseriListGrid"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="col-lg-6 col-md-12 no-padding">
        <div class="col-lg-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">.:: Master Nama Komersil</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php echo CHtml::beginForm('', 'post', array('class' => 'form-horizontal', 'id' => 'forminputkomersil')); ?>
                        <div class="col-lg-6 col-md-12">
                            <div class="col-lg-12 no-padding" style="margin-bottom: 10px;">
                                <?php
                                echo CHtml::hiddenField('id_komersil', '');
                                echo CHtml::textArea('komersil', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: INPUT NAMA KOMERSIL'));
                                ?>
                            </div>
                            <div class="col-lg-12 no-padding">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary" onclick="save('komersil', '<?php echo $this->createUrl('Default/SaveKomersil'); ?>', 'update')">SAVE</button>
                                </div>
                            </div>
                        </div>
                        <?php echo CHtml::endForm(); ?>
                        <div class="col-lg-6 col-md-12">
                            <?php echo CHtml::textField('komersil_search', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: SEARCH NAMA KOMERSIL')); ?>
                            <table id="komersilListGrid"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">.:: Bahan Utama</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php echo CHtml::beginForm('', 'post', array('class' => 'form-horizontal', 'id' => 'forminputbahan')); ?>
                        <div class="col-lg-6 col-md-12">
                            <div class="col-lg-12 no-padding" style="margin-bottom: 10px;">
                                <?php
                                echo CHtml::hiddenField('id_bahan', '');
                                echo CHtml::textArea('bahan', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: INPUT BAHAN UTAMA'));
                                ?>
                            </div>
                            <div class="col-lg-12 no-padding">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary" onclick="save('bahan', '<?php echo $this->createUrl('Default/SaveBahan'); ?>', 'update')">SAVE</button>
                                </div>
                            </div>
                        </div>
                        <?php echo CHtml::endForm(); ?>
                        <div class="col-lg-6 col-md-12">
                            <?php echo CHtml::textField('bahan_search', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: SEARCH BAHAN UTAMA')); ?>
                            <table id="bahanListGrid"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">.:: Merk</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php echo CHtml::beginForm('', 'post', array('class' => 'form-horizontal', 'id' => 'forminputmerk')); ?>
                        <div class="col-lg-6 col-md-12">
                            <div class="col-lg-12 no-padding" style="margin-bottom: 10px;">
                                <?php
                                echo CHtml::hiddenField('id_merk', '');
                                echo CHtml::textField('merk', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: INPUT MERK'));
                                ?>
                            </div>
                            <div class="col-lg-12 no-padding">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary" onclick="save('merk', '<?php echo $this->createUrl('Default/SaveMerk'); ?>', 'update')">SAVE</button>
                                </div>
                            </div>
                        </div>
                        <?php echo CHtml::endForm(); ?>
                        <div class="col-lg-6 col-md-12">
                            <?php echo CHtml::textField('merk_search', '', array('class' => 'form-control text-besar', 'placeholder' => '.:: SEARCH MERK')); ?>
                            <table id="merkListGrid"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $('#userListGrid').datagrid({
        url: '<?php echo $this->createUrl('default/UserListGrid'); ?>',
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
        pageSize: 5,
        pageList: [5, 10, 20],
        columns: [
            [{
                    field: 'id_user',
                    title: '',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: formatButtonDelete
                },
                {
                    field: 'user_name',
                    title: 'Username',
                    width: 120,
                    halign: 'center',
                    align: 'left',
                    sortable: true
                },
                {
                    field: 'itemname',
                    title: 'Hak Akses',
                    width: 120,
                    halign: 'center'
                },
            ]
        ],
        onBeforeLoad: function(params) {
            params.user = $('#user_search').val();
        },
        onLoadError: function() {
            return false;
        },
        onLoadSuccess: function() {}
    });

    $('#kepaladinasListGrid').datagrid({
        url: '<?php echo $this->createUrl('default/KepaladinasListGrid'); ?>',
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
        pageSize: 5,
        pageList: [5, 10, 20],
        columns: [
            [{
                    field: 'delete',
                    title: '',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: formatButtonDeletKepalaDinas
                }, {
                    field: 'id_kepala_dinas',
                    title: '',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: formatButtonEdit
                },
                {
                    field: 'nip',
                    title: 'NIP',
                    width: 130,
                    halign: 'center',
                    align: 'left'
                },
                {
                    field: 'nama',
                    title: 'Nama',
                    width: 200,
                    halign: 'center',
                    sortable: true
                },
                {
                    field: 'pangkat',
                    title: 'Pangkat',
                    width: 300,
                    halign: 'center',
                    sortable: true
                },
            ]
        ],
        onBeforeLoad: function(params) {
            params.nama = $('#kepala_dinas_search').val();
        },
        onLoadError: function() {
            return false;
        },
        onLoadSuccess: function() {}
    });

    $('#pengujiListGrid').datagrid({
        url: '<?php echo $this->createUrl('default/PengujiListGrid'); ?>',
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
        pageSize: 5,
        pageList: [5, 10, 20],
        columns: [
            [{
                    field: 'id_nama_penguji',
                    title: '',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: formatButtonEdit
                },
                {
                    field: 'nrp',
                    title: 'NRP',
                    width: 130,
                    halign: 'center',
                    align: 'left'
                },
                {
                    field: 'nama_penguji',
                    title: 'Nama',
                    width: 200,
                    halign: 'center',
                    sortable: true
                },
                {
                    field: 'jabatan',
                    title: 'Jabatan',
                    width: 300,
                    halign: 'center',
                    sortable: true
                },
            ]
        ],
        onBeforeLoad: function(params) {
            params.penguji = $('#penguji_search').val();
        },
        onLoadError: function() {
            return false;
        },
        onLoadSuccess: function() {}
    });

    $('#komersilListGrid').datagrid({
        url: '<?php echo $this->createUrl('default/komersilListGrid'); ?>',
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
        pageSize: 5,
        pageList: [5, 10, 20],
        columns: [
            [{
                    field: 'id_komersil',
                    title: '',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: formatButtonEdit
                },
                {
                    field: 'komersil',
                    title: 'Nama Komersil',
                    width: 220,
                    sortable: false
                },
            ]
        ],
        onBeforeLoad: function(params) {
            params.komersil = $('#komersil_search').val();
        },
        onLoadError: function() {
            return false;
        },
        onLoadSuccess: function() {}
    });

    $('#karoseriListGrid').datagrid({
        url: '<?php echo $this->createUrl('default/karoseriListGrid'); ?>',
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
        pageSize: 5,
        pageList: [5, 10, 20],
        columns: [
            [{
                    field: 'id_karoseri',
                    title: '',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: formatButtonEdit
                },
                {
                    field: 'karoseri',
                    title: 'Jenis Karoseri',
                    width: 320,
                    sortable: false
                },
            ]
        ],
        onBeforeLoad: function(params) {
            params.karoseri = $('#karoseri_search').val();
        },
        onLoadError: function() {
            return false;
        },
        onLoadSuccess: function() {}
    });

    $('#bahanListGrid').datagrid({
        url: '<?php echo $this->createUrl('default/bahanListGrid'); ?>',
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
        pageSize: 5,
        pageList: [5, 10, 20],
        columns: [
            [{
                    field: 'id_bahan',
                    title: '',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: formatButtonEdit
                },
                {
                    field: 'bahan',
                    title: 'Bahan Utama',
                    width: 220,
                    sortable: false
                },
            ]
        ],
        onBeforeLoad: function(params) {
            params.bahan = $('#bahan_search').val();
        },
        onLoadError: function() {
            return false;
        },
        onLoadSuccess: function() {}
    });

    $('#merkListGrid').datagrid({
        url: '<?php echo $this->createUrl('default/merkListGrid'); ?>',
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
        pageSize: 5,
        pageList: [5, 10, 20],
        columns: [
            [{
                    field: 'id_merk',
                    title: '',
                    width: 50,
                    halign: 'center',
                    align: 'center',
                    formatter: formatButtonEdit
                },
                {
                    field: 'merk',
                    title: 'Merk',
                    width: 220,
                    sortable: false
                },
            ]
        ],
        onBeforeLoad: function(params) {
            params.merk = $('#merk_search').val();
        },
        onLoadError: function() {
            return false;
        },
        onLoadSuccess: function() {}
    });

    function formatButtonDelete(value) {
        var explode = value.split('|');
        var id = explode[0];
        var itemname = explode[1];
        var urlAct = '<?php echo $this->createUrl('default/DeleteUser'); ?>';
        var button = '<button type="button" class="btn btn-danger" onclick="buttonDelete(\'' + id + '\', \'' + itemname + '\', \'' + urlAct + '\')"><span class="glyphicon glyphicon-trash"></span></button>';
        return button;
    }

    function formatButtonDeletKepalaDinas(value) {
        var urlAct = '<?php echo $this->createUrl('default/DeleteKepalaDinas'); ?>';
        var button = '<button type="button" class="btn btn-danger" onclick="buttonDeleteKepalaDinas(\'' + value + '\', \'' + urlAct + '\')"><span class="glyphicon glyphicon-trash"></span></button>';
        return button;
    }

    function formatButtonEdit(value) {
        var explode = value.split('|');
        var id = explode[0];
        var pilihan = explode[1];
        var urlAct;
        if (pilihan == 'kepaladinas') {
            urlAct = '<?php echo $this->createUrl('default/GetDetailEditKepalaDinas'); ?>'
        } else if (pilihan == 'penguji') {
            urlAct = '<?php echo $this->createUrl('default/GetDetailEditPenguji'); ?>'
        } else if (pilihan == 'komersil') {
            urlAct = '<?php echo $this->createUrl('default/GetDetailEditKomersil'); ?>'
        } else if (pilihan == 'karoseri') {
            urlAct = '<?php echo $this->createUrl('default/GetDetailEditKaroseri'); ?>'
        } else if (pilihan == 'bahan') {
            urlAct = '<?php echo $this->createUrl('default/GetDetailEditBahan'); ?>'
        } else if (pilihan == 'merk') {
            urlAct = '<?php echo $this->createUrl('default/GetDetailEditMerk'); ?>'
        }
        var button = '<button type="button" class="btn btn-info" onclick="buttonEdit(\'' + id + '\', \'' + pilihan + '\', \'' + urlAct + '\')"><span class="glyphicon glyphicon-pencil"></span></button>';
        return button;
    }
</script>