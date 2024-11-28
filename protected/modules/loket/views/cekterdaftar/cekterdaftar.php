<?php
$assetsUrl = $this->module->assetsUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($assetsUrl . '/js/cekterdaftar.js', CClientScript::POS_END);
?>
<style>    
    .datagrid-row{
        height: 40px !important; 
        font-weight: bold;
    }
    .datagrid-cell{                
        text-align: center;	
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">CEK TERDAFTAR</h3>                
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12">                        
                        <div class="col-lg-4 col-md-8">
                            <input type="text" id="text_category" class="text-besar form-control" placeholder="NO UJI/NO KENDARAAN">
                        </div>
                   <!--     <div class="col-lg-4 col-md-4">
                            <button type="button" class="btn btn-info pull-left" onclick="prosesSearch()">
                                <span class="glyphicon glyphicon-refresh"></span> 
                                Refresh
                            </button>
                        </div> -->
                    </div>
                </div>
                <div class="col-lg-12 col-md-12" style="margin-top: 20px">
                    <table id="terdaftarListGrid"></table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#terdaftarListGrid').datagrid({
        url: '<?php echo $this->createUrl('CekTerdaftar/GetListDataTerdaftar'); ?>',
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
        pageSize: 5,
        pageList: [5, 10, 15],
        columns: [[                
                {field: 'no_uji', title: 'No Uji', width: 90, sortable: true},
                {field: 'no_kendaraan', width: 100, title: 'No Kendaraan', sortable: true},
                {field: 'nama_pemilik', width: 250, title: 'Nama Pemilik', sortable: false},                
                {field: 'nm_uji', width: 150, title: 'Jenis Uji', sortable: false},
                {field: 'tgl_retribusi', width: 200, title: 'Tgl Retribusi', sortable: false},
                {field: 'tgl_uji', width: 100, title: 'Tgl Uji', sortable: false},
                {field: 'status', width: 150, title: 'Datang', sortable: false},
                {field: 'lulus', width: 150, title: 'Lulus', sortable: false},
            ]],
//        toolbar: "#search",
//        onBeforeLoad: function (params) {
//        params.textCategory = $('#text_category').val();
//        params.selectCategory = $('#select_category :selected').val();
//            params.selectDate = $('#tgl_search').val();
//        },
        onLoadError: function () {
            return false;
        },
        onLoadSuccess: function () {
        }
    });    
</script>