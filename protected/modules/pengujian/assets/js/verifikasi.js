/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on("keypress", '#text_category', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        prosesSearch();
        return false;
    }
});

$(document).ready(function () {
    closeDialog();
    $('#tgl_search').datepicker({
        endDate: "today",
        format: 'dd-M-yyyy',
        daysOfWeekDisabled: [0, 7],
        autoclose: true,
    }).on('changeDate', prosesSearch);
});

function closeDialog() {
    $('#dlg').dialog('close');
    $('#dlg_no_surat').dialog('close');
    $('#dlg_cetak_hasil').dialog('close');
    $('#dlgBlokir').dialog('close');
}

function prosesSearch() {
    $('#pemeriksaanTglListGrid').datagrid('reload');
}

function buttonEditVerifikasi(value, url) {
//    $('#dlg_id_hasil_uji').val(value);
//    $('#dlg').dialog('open');
//    $('#dlg').dialog('center');
    var win = window.open(url + "?id=" + value, '_blank');
    win.focus();
}

function buttonDialogBlokir(value) {
    $('#dlg_id_kendaraan').val(value);
    $('#dlgBlokir').dialog('open');
    $('#dlgBlokir').dialog('center');
}

/*
 * PROSES BANDING
 */
//function buttonBanding(value, urlAct) {
//    $.messager.confirm('Confirm', 'Apakah anda yakin ingin banding?', function (r) {
//        if (r) {
//            $.ajax({
//                type: 'POST',
//                url: urlAct,
//                data: {id_hasil_uji: value},
//                beforeSend: function () {
//                    showlargeloader();
//                },
//                success: function (data) {
//                    $('#pemeriksaanTglListGrid').datagrid('reload');
//                    hidelargeloader();
//                },
//                error: function () {
//                    $('#pemeriksaanTglListGrid').datagrid('reload');
//                    hidelargeloader();
//                    return false;
//                }
//            });
//        }
//    });
//}

function buttonBanding(value, kategori) {
    $.messager.confirm('Confirm', 'Apakah anda yakin ingin banding ke ' + kategori + '?', function (r) {
        if (r) {
            var urlAct;
            if (kategori == 'prauji') {
                urlAct = 'Verifikasi/ProsesBandingPrauji';
            } else if (kategori == 'emisi') {
                urlAct = 'Verifikasi/ProsesBandingEmisi';
            } else if (kategori == 'pitlift') {
                urlAct = 'Verifikasi/ProsesBandingPitlift';
            } else if (kategori == 'lampu') {
                urlAct = 'Verifikasi/ProsesBandingLampu';
            } else if (kategori == 'rem') {
                urlAct = 'Verifikasi/ProsesBandingRem';
            }
            $.ajax({
                type: 'POST',
                url: urlAct,
                data: {id_hasil_uji: value},
                beforeSend: function () {
                    showlargeloader();
                },
                success: function (data) {
                    $('#pemeriksaanTglListGrid').datagrid('reload');
                    hidelargeloader();
                },
                error: function () {
                    $('#pemeriksaanTglListGrid').datagrid('reload');
                    hidelargeloader();
                    return false;
                }
            });
        }
    });
}