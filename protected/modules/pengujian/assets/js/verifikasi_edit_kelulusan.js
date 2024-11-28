$(document).ready(function () {

    $(".toggle-accordion").on("click", function () {
        var accordionId = $(this).attr("accordion-id"),
                numPanelOpen = $(accordionId + ' .collapse.in').length;

        $(this).toggleClass("active");

        if (numPanelOpen == 0) {
            openAllPanels(accordionId);
        } else {
            closeAllPanels(accordionId);
        }
    })

    openAllPanels = function (aId) {
        console.log("setAllPanelOpen");
        $(aId + ' .panel-collapse:not(".in")').collapse('show');
    }
    closeAllPanels = function (aId) {
        console.log("setAllPanelclose");
        $(aId + ' .panel-collapse.in').collapse('hide');
    }

});

function updateVerifikasi(urlAct) {
    var data = $("#formEditKelulusan").serialize();
    var id_hasil_uji = $("#id_hasil_uji").val();
    var lain_lain = $("#form_lain").val();
    var form_uji = $("#form_uji").val();
    var form_kelulusan = $("#form_kelulusan").val();
    $.ajax({
        url: urlAct,
        type: 'POST',
        data: {id_hasil_uji: id_hasil_uji,form_uji:form_uji,form_kelulusan:form_kelulusan,lain_lain:lain_lain},
        beforeSend: function () {
            showlargeloader();
        },
        success: function (data) {
            hidelargeloader();
            $("#form_lain").val('');
        },
        error: function (data) {
            hidelargeloader();
            return false;
        }
    });
}

function showHide() {
    var uji = $('#form_uji :selected').val();
    var kelulusan = $('#form_kelulusan :selected').val();
    if (uji == 'prauji' && kelulusan == 'false') {
        $('#form_prauji').show();
        $('#form_brake').hide();
        $('#buttonSave').hide();
    } else if (uji == 'break' && kelulusan == 'false') {
        $('#form_brake').show();
        $('#form_prauji').hide();
        $('#buttonSave').hide();
    } else {
        $('#form_prauji').hide();
        $('#form_brake').hide();
        $('#buttonSave').show();
    }
    if(kelulusan == 'false'){
        $('#lain_lain').show();
    }else{
        $('#lain_lain').hide();
    }
}

function prosesClickPrauji(urlAct) {
    var kode   = new Array();
    var kirim  = '';
    var inken  = new Array();
    var idHasil = $('#id_hasil_uji').val();
    var posisi = $('#posisi').val();
    // A. IDENTITAS KENDARAAN
    if ($('#a1a').is(':checked')) { kode[1] = 'A01A'; };
    if ($('#a1b').is(':checked')) { kode[2] = 'A01B'; };
    if ($('#a1c').is(':checked')) { kode[3] = 'A01C'; };
    if ($('#a2a').is(':checked')) { kode[4] = 'A02A'; };
    if ($('#a2b').is(':checked')) { kode[5] = 'A02B'; };
    if ($('#a2c').is(':checked')) { kode[6] = 'A02C'; };
    if ($('#a3a').is(':checked')) { kode[7] = 'A03A'; };
    if ($('#a3b').is(':checked')) { kode[8] = 'A03B'; };
    if ($('#a3c').is(':checked')) { kode[9] = 'A03C'; };
    if ($('#a4a').is(':checked')) { kode[10] = 'A04A'; };
    if ($('#a4b').is(':checked')) { kode[11] = 'A04B'; };
    if ($('#a4c').is(':checked')) { kode[12] = 'A04C'; };
    // B. SISTEM PENERANGAN
    if ($('#b1a').is(':checked')) { kode[13] = 'B01A'; };
    if ($('#b1b').is(':checked')) { kode[14] = 'B01B'; };
    if ($('#b1c').is(':checked')) { kode[15] = 'B01C'; };
    if ($('#b1d').is(':checked')) { kode[16] = 'B01D'; };
    if ($('#b2a').is(':checked')) { kode[17] = 'B02A'; };
    if ($('#b2b').is(':checked')) { kode[18] = 'B02B'; };
    if ($('#b2c').is(':checked')) { kode[19] = 'B02C'; };
    if ($('#b2d').is(':checked')) { kode[20] = 'B02D'; };
    if ($('#b3a').is(':checked')) { kode[21] = 'B03A'; };
    if ($('#b3b').is(':checked')) { kode[22] = 'B03B'; };
    if ($('#b3c').is(':checked')) { kode[23] = 'B03C'; };
    if ($('#b3d').is(':checked')) { kode[24] = 'B03D'; };
    if ($('#b4a').is(':checked')) { kode[25] = 'B04A'; };
    if ($('#b4b').is(':checked')) { kode[26] = 'B04B'; };
    if ($('#b5a').is(':checked')) { kode[27] = 'B05A'; };
    if ($('#b5b').is(':checked')) { kode[28] = 'B05B'; };
    if ($('#b6a').is(':checked')) { kode[29] = 'B06A'; };
    if ($('#b6b').is(':checked')) { kode[30] = 'B06B';};
    if ($('#b6c').is(':checked')) { kode[31] = 'B06C';};
    if ($('#b6d').is(':checked')) { kode[32] = 'B06D'; };
    if ($('#b7').is(':checked'))  { kode[33] = 'B07'; };
    if ($('#b8a').is(':checked')) { kode[34] = 'B08A'; };
    if ($('#b8b').is(':checked')) { kode[35] = 'B08B'; };
    // C. RUMAH DAN BODY
    if ($('#c1a').is(':checked')) { kode[36] = 'C01A'; };
    if ($('#c1b').is(':checked')) { kode[37] = 'C01B'; };
    if ($('#c2').is(':checked'))  { kode[38] = 'C02'; };
    if ($('#c3').is(':checked'))  { kode[39] = 'C03'; };
    if ($('#c4').is(':checked'))  { kode[40] = 'C04'; };
    if ($('#c5').is(':checked'))  { kode[41] = 'C05'; };
    if ($('#c6').is(':checked'))  { kode[42] = 'C06'; };
    if ($('#c7a').is(':checked')) { kode[43] = 'C07A'; };
    if ($('#c7b').is(':checked')) { kode[44] = 'C07B'; };
    if ($('#c8a').is(':checked')) { kode[45] = 'C08A'; };
    if ($('#c8b').is(':checked')) { kode[46] = 'C08B'; };
    if ($('#c9').is(':checked'))  { kode[47] = 'C09'; };
    if ($('#c10').is(':checked')) { kode[48] = 'C10'; };
    if ($('#c11a').is(':checked')) { kode[49] = 'C11A'; };
    if ($('#c11b').is(':checked')) { kode[50] = 'C11B'; };
    if ($('#c11c').is(':checked')) { kode[51] = 'C11C'; };
    if ($('#c11d').is(':checked')) { kode[52] = 'C11D'; };
    if ($('#c12').is(':checked')) { kode[53] = 'C12'; };
    if ($('#c13').is(':checked')) { kode[54] = 'C13'; };
    if ($('#c14').is(':checked')) { kode[55] = 'C14'; };
    if ($('#c15a').is(':checked')) { kode[56] = 'C15A'; };
    if ($('#c15b').is(':checked')) { kode[57] = 'C15B'; };
    if ($('#c16a1').is(':checked')) { kode[58] = 'C16A1'; };
    if ($('#c16a2').is(':checked')) { kode[59] = 'C16A2'; };
    if ($('#c16a3').is(':checked')) { kode[60] = 'C16A3'; };
    if ($('#c16a4').is(':checked')) { kode[61] = 'C16A4'; };
    if ($('#c16b1').is(':checked')) { kode[62] = 'C16B1'; };
    if ($('#c16b2').is(':checked')) { kode[63] = 'C16B2'; };
    if ($('#c16b3').is(':checked')) { kode[64] = 'C16B3'; };
    if ($('#c16b4').is(':checked')) { kode[65] = 'C16B4'; };
    if ($('#c16c1').is(':checked')) { kode[66] = 'C16C1'; };
    if ($('#c16c2').is(':checked')) { kode[67] = 'C16C2'; };
    if ($('#c16c3').is(':checked')) { kode[68] = 'C16C3'; };
    if ($('#c16c4').is(':checked')) { kode[69] = 'C16C4'; };
    // D. Roda - Roda
    if ($('#d1a').is(':checked')) { kode[70] = 'D01A'; };
    if ($('#d1b').is(':checked')) { kode[71] = 'D01B'; };
    if ($('#d1c').is(':checked')) { kode[72] = 'D01C'; };
    if ($('#d1d').is(':checked')) { kode[73] = 'D01D'; };
    if ($('#d1e').is(':checked')) { kode[74] = 'D01E'; };
    if ($('#d1f').is(':checked')) { kode[75] = 'D01F'; };
    if ($('#d1g').is(':checked')) { kode[76] = 'D01G'; };
    if ($('#d1h').is(':checked')) { kode[77] = 'D01H'; };
    if ($('#d2a').is(':checked')) { kode[78] = 'D02A'; };
    if ($('#d2b').is(':checked')) { kode[79] = 'D02B'; };
    if ($('#d2c').is(':checked')) { kode[80] = 'D02C'; };
    if ($('#d2d').is(':checked')) { kode[81] = 'D02D'; };
    if ($('#d2e').is(':checked')) { kode[82] = 'D02E'; };
    if ($('#d2f').is(':checked')) { kode[83] = 'D02F'; };
    if ($('#d2g').is(':checked')) { kode[84] = 'D02G'; };
    if ($('#d2h').is(':checked')) { kode[85] = 'D02H'; };
    if ($('#d3a').is(':checked')) { kode[86] = 'D03A'; };
    if ($('#d3b').is(':checked')) { kode[87] = 'D03B'; };
    if ($('#d3c').is(':checked')) { kode[88] = 'D03C'; };
    if ($('#d3d').is(':checked')) { kode[89] = 'D03D'; };
    if ($('#d3e').is(':checked')) { kode[90] = 'D03E'; };
    if ($('#d3f').is(':checked')) { kode[91] = 'D03F'; };
    if ($('#d3g').is(':checked')) { kode[92] = 'D03G'; };
    if ($('#d3h').is(':checked')) { kode[93] = 'D03H'; };
    if ($('#d4a').is(':checked')) { kode[94] = 'D04A'; };
    if ($('#d4b').is(':checked')) { kode[95] = 'D04B'; };
    if ($('#d4c').is(':checked')) { kode[96] = 'D04C'; };
    if ($('#d4d').is(':checked')) { kode[97] = 'D04D'; };
    if ($('#d4e').is(':checked')) { kode[98] = 'D04E'; };
    if ($('#d4f').is(':checked')) { kode[99] = 'D04F'; };
    if ($('#d4g').is(':checked')) { kode[100] = 'D04G'; };
    if ($('#d4h').is(':checked')) { kode[101] = 'D04H'; };
    if ($('#d5a').is(':checked')) { kode[102] = 'D05A'; };
    if ($('#d5b').is(':checked')) { kode[103] = 'D05B'; };
    if ($('#d5c').is(':checked')) { kode[104] = 'D05C'; };
    if ($('#d5d').is(':checked')) { kode[105] = 'D05D'; };
    if ($('#d5e').is(':checked')) { kode[106] = 'D05E'; };
    if ($('#d5f').is(':checked')) { kode[107] = 'D05F'; };
    if ($('#d5g').is(':checked')) { kode[108] = 'D05G'; };
    if ($('#d5h').is(':checked')) { kode[109] = 'D05H'; };
    if ($('#d6').is(':checked'))  { kode[110] = 'D06'; };
    // E. Dimensi Kendaraan
    if ($('#e1a').is(':checked')) { kode[111] = 'E01A'; };
    if ($('#e1b').is(':checked')) { kode[112] = 'E01B'; };
    if ($('#e1c').is(':checked')) { kode[113] = 'E01C'; };
    if ($('#e2a').is(':checked')) { kode[114] = 'E02A'; };
    if ($('#e2b').is(':checked')) { kode[115] = 'E02B'; };
    if ($('#e2c').is(':checked')) { kode[116] = 'E02C'; };
    if ($('#e3a').is(':checked')) { kode[117] = 'E03A'; };
    if ($('#e3b').is(':checked')) { kode[118] = 'E03B'; };
    if ($('#e3c').is(':checked')) { kode[119] = 'E03C'; };
    if ($('#e4a').is(':checked')) { kode[120] = 'E04A'; };
    if ($('#e4b').is(':checked')) { kode[121] = 'E04B'; };
    if ($('#e4c').is(':checked')) { kode[122] = 'E04C'; };
    if ($('#e5').is(':checked'))  { kode[123] = 'E05'; };
    if ($('#e6').is(':checked'))  { kode[124] = 'E06'; };
    if ($('#e7').is(':checked'))  { kode[125] = 'E07'; };
    if ($('#e8').is(':checked'))  { kode[126] = 'E08'; };
    if ($('#e9').is(':checked'))  { kode[127] = 'E09'; };
    // F. Peralatan
    if ($('#f1a').is(':checked'))  { kode[128] = 'F01A'; };
    if ($('#f1b').is(':checked'))  { kode[129] = 'F01B'; };
    if ($('#f1c').is(':checked'))  { kode[130] = 'F01C'; };
    if ($('#f1d').is(':checked'))  { kode[131] = 'F01D'; };
    if ($('#f2a').is(':checked'))  { kode[132] = 'F02A'; };
    if ($('#f2b').is(':checked'))  { kode[133] = 'F02B'; };
    if ($('#f2c').is(':checked'))  { kode[134] = 'F02C'; };
    if ($('#f2d').is(':checked'))  { kode[135] = 'F02D'; };
    if ($('#f3a').is(':checked'))  { kode[136] = 'F03A'; };
    if ($('#f3b').is(':checked'))  { kode[137] = 'F03B'; };
    if ($('#f3c').is(':checked'))  { kode[138] = 'F03C'; };
    if ($('#f3d').is(':checked'))  { kode[139] = 'F03D'; };
    if ($('#f4a').is(':checked'))  { kode[140] = 'F04A'; };
    if ($('#f4b').is(':checked'))  { kode[141] = 'F04B'; };
    if ($('#f5').is(':checked'))   { kode[142] = 'F05'; };
    if ($('#f6').is(':checked'))   { kode[143] = 'F06'; };
    if ($('#f7').is(':checked'))   { kode[144] = 'F07'; };
    if ($('#f8').is(':checked'))   { kode[145] = 'F08'; };
    if ($('#f9').is(':checked'))   { kode[146] = 'F09'; };
    if ($('#f10').is(':checked'))  { kode[147] = 'F10'; };
    if ($('#f11').is(':checked'))  { kode[148] = 'F11'; };
    if ($('#f12').is(':checked'))  { kode[149] = 'F12'; };
    if ($('#f13').is(':checked'))  { kode[150] = 'F13'; };
    if ($('#f14').is(':checked'))  { kode[151] = 'F14'; };
    if ($('#f15').is(':checked'))  { kode[152] = 'F15'; };
    if ($('#f16').is(':checked'))  { kode[153] = 'F16'; };
    if ($('#b9a').is(':checked')) { kode[154] = 'B09A'; };
    if ($('#b9b').is(':checked')) { kode[155] = 'B09B'; };
    if ($('#b10a').is(':checked')) { kode[156] = 'B10A'; };
    if ($('#b10b').is(':checked')) { kode[157] = 'B10B'; };
    if ($('#d7').is(':checked')) { kode[158] = 'UM44'; };
    //----------------------------------------------------
    inken[1] = 'C01A'+'~'+$('#c1ain').val();
    inken[2] = 'C03'+'~'+$('#c3in').val();
    inken[3] = 'C10'+'~'+$('#jnsbody').val();
    inken[4] = 'C13'+'~'+$('#jnsbahan').val();
    inken[5] = 'E01A'+'~'+$('#e1ain').val();
    inken[6] = 'E01B'+'~'+$('#e1bin').val();
    inken[7] = 'E01C'+'~'+$('#e1cin').val();
    inken[8] = 'E02A'+'~'+$('#e2ain').val();
    inken[9] = 'E02B'+'~'+$('#e2bin').val();
    inken[10] = 'E02C'+'~'+$('#e2cin').val();
    inken[11] = 'E03A'+'~'+$('#e3ain').val();
    inken[12] = 'E03B'+'~'+$('#e3bin').val();
    inken[13] = 'E03C'+'~'+$('#e3cin').val();
    inken[14] = 'E04A'+'~'+$('#e4ain').val();
    inken[15] = 'E04B'+'~'+$('#e4bin').val();
    inken[16] = 'E04C'+'~'+$('#e4cin').val();
    inken[17] = 'E05'+'~'+$('#e5in').val();
    inken[18] = 'E06'+'~'+$('#e6in').val();
    inken[19] = 'E07'+'~'+$('#e7in').val();
    inken[20] = 'E08'+'~'+$('#e8in').val();
    inken[21] = 'E09'+'~'+$('#e9in').val();
    var lain_lain = $('#form_lain').val();

    // String yang harus dikirim sebagai variabel inputan					    
    for ( i = 1; i < kode.length; i++) {
        if (kode[i] != null) {
              kirim = kirim+kode[i]+','; 
        }
    };  
    kirim = kirim+'#'+inken;
    $.ajax({
        url: urlAct,
        type: 'POST',
        data: {idhasil: idHasil,variabel:kirim,posisi:posisi,lain_lain:lain_lain},
        beforeSend: function () {
            showlargeloader();
        },
        success: function (data) {
            hidelargeloader();
            $('#form_lain').val('');
            // A. Default
            $("#a1a").removeAttr("checked"); $("#a1b").removeAttr("checked"); $("#a1c").removeAttr("checked");
            $("#a2a").removeAttr("checked"); $("#a2b").removeAttr("checked"); $("#a2c").removeAttr("checked");
            $("#a3a").removeAttr("checked"); $("#a3b").removeAttr("checked"); $("#a3c").removeAttr("checked");
            $("#a4a").removeAttr("checked"); $("#a4b").removeAttr("checked"); $("#a4c").removeAttr("checked");
            // B. Default
            $('#b1a').removeAttr("checked");  $('#b1b').removeAttr("checked");  $('#b1c').removeAttr("checked");
            $('#b1d').removeAttr("checked");  $('#b2a').removeAttr("checked");  $('#b2b').removeAttr("checked");
            $('#b2c').removeAttr("checked");  $('#b2d').removeAttr("checked");  $('#b3a').removeAttr("checked");
            $('#b3b').removeAttr("checked");  $('#b3c').removeAttr("checked");  $('#b3d').removeAttr("checked");
            $('#b4a').removeAttr("checked");  $('#b4b').removeAttr("checked");  $('#b5a').removeAttr("checked");
            $('#b5b').removeAttr("checked");  $('#b6a').removeAttr("checked");  $('#b6b').removeAttr("checked");
            $('#b6c').removeAttr("checked");  $('#b6d').removeAttr("checked");  $('#b7').removeAttr("checked");
            $('#b8a').removeAttr("checked");  $('#b8b').removeAttr("checked"); $('#b9a').removeAttr("checked");  
            $('#b9b').removeAttr("checked"); $('#b10a').removeAttr("checked");  $('#b10b').removeAttr("checked");
            // C. Default
            $('#c1a').removeAttr("checked");  $('#c1b').removeAttr("checked");  $('#c2').removeAttr("checked");
            $('#c3').removeAttr("checked");   $('#c4').removeAttr("checked");   $('#c5').removeAttr("checked");
            $('#c6').removeAttr("checked");   $('#c7a').removeAttr("checked");  $('#c7b').removeAttr("checked");
            $('#c8a').removeAttr("checked");  $('#c8b').removeAttr("checked");  $('#c9').removeAttr("checked");
            $('#c10').removeAttr("checked");  $('#c11a').removeAttr("checked"); $('#c11b').removeAttr("checked");
            $('#c11c').removeAttr("checked"); $('#c11d').removeAttr("checked"); $('#c12').removeAttr("checked");
            $('#c13').removeAttr("checked");  $('#c14').removeAttr("checked");  $('#c15a').removeAttr("checked");
            $('#c15b').removeAttr("checked");
            $('#c16a1').removeAttr("checked");$('#c16a2').removeAttr("checked");$('#c16a3').removeAttr("checked");
            $('#c16a4').removeAttr("checked");$('#c16b1').removeAttr("checked");$('#c16b2').removeAttr("checked");
            $('#c16b3').removeAttr("checked");$('#c16b4').removeAttr("checked");$('#c16c1').removeAttr("checked");
            $('#c16c2').removeAttr("checked");$('#c16c3').removeAttr("checked");$('#c16c4').removeAttr("checked");
            // D. Default
            $('#d1a').removeAttr("checked");  $('#d1b').removeAttr("checked");  $('#d1c').removeAttr("checked");
            $('#d1d').removeAttr("checked");  $('#d1e').removeAttr("checked");  $('#d1f').removeAttr("checked");
            $('#d1g').removeAttr("checked");  $('#d1h').removeAttr("checked");  $('#d2a').removeAttr("checked");
            $('#d2b').removeAttr("checked");  $('#d2c').removeAttr("checked");  $('#d2d').removeAttr("checked");
            $('#d2e').removeAttr("checked");  $('#d2f').removeAttr("checked");  $('#d2g').removeAttr("checked");
            $('#d2h').removeAttr("checked");  $('#d3a').removeAttr("checked");  $('#d3b').removeAttr("checked");
            $('#d3c').removeAttr("checked");  $('#d3d').removeAttr("checked");  $('#d3e').removeAttr("checked");
            $('#d3f').removeAttr("checked");  $('#d3g').removeAttr("checked");  $('#d3h').removeAttr("checked");
            $('#d4a').removeAttr("checked");  $('#d4b').removeAttr("checked");  $('#d4c').removeAttr("checked");
            $('#d4d').removeAttr("checked");  $('#d4e').removeAttr("checked");  $('#d4f').removeAttr("checked");
            $('#d4g').removeAttr("checked");  $('#d4h').removeAttr("checked");  $('#d5a').removeAttr("checked");
            $('#d5b').removeAttr("checked");  $('#d5c').removeAttr("checked");  $('#d5d').removeAttr("checked");
            $('#d5e').removeAttr("checked");  $('#d5f').removeAttr("checked");  $('#d5g').removeAttr("checked");
            $('#d5h').removeAttr("checked");  $('#d6').removeAttr("checked");
            // E. Default
            $('#e1a').removeAttr("checked");  $('#e1b').removeAttr("checked");  $('#e1c').removeAttr("checked");
            $('#e2a').removeAttr("checked");  $('#e2b').removeAttr("checked");  $('#e2c').removeAttr("checked");
            $('#e3a').removeAttr("checked");  $('#e3b').removeAttr("checked");  $('#e3c').removeAttr("checked");
            $('#e4a').removeAttr("checked");  $('#e4b').removeAttr("checked");  $('#e4c').removeAttr("checked");
            $('#e5').removeAttr("checked");   $('#e6').removeAttr("checked");   $('#e7').removeAttr("checked");
            $('#e8').removeAttr("checked");   $('#e9').removeAttr("checked");
            // F. Default
            $('#f1a').removeAttr("checked");  $('#f1b').removeAttr("checked");  $('#f1c').removeAttr("checked");
            $('#f1d').removeAttr("checked");  $('#f2a').removeAttr("checked");  $('#f2b').removeAttr("checked");
            $('#f2c').removeAttr("checked");  $('#f2d').removeAttr("checked");  $('#f3a').removeAttr("checked");
            $('#f3b').removeAttr("checked");  $('#f3c').removeAttr("checked");  $('#f3d').removeAttr("checked");
            $('#f4a').removeAttr("checked");  $('#f4b').removeAttr("checked");  $('#f5').removeAttr("checked");
            $('#f6').removeAttr("checked");   $('#f7').removeAttr("checked");   $('#f8').removeAttr("checked");
            $('#f9').removeAttr("checked");   $('#f10').removeAttr("checked");  $('#f11').removeAttr("checked");
            $('#f12').removeAttr("checked");  $('#f13').removeAttr("checked");  $('#f14').removeAttr("checked");
            $('#f15').removeAttr("checked");  $('#f16').removeAttr("checked");  $('#d7').removeAttr("checked");
            // Inputan NULL
            $('#c1ain').val('');   $('#c3in').val('');   $('#c10in').val('');  $('#e1ain').val('');
            $('#e1bin').val('');   $('#e1cin').val('');  $('#e2ain').val('');  $('#e2bin').val('');
            $('#e2cin').val('');   $('#e3ain').val('');  $('#e3bin').val('');  $('#e3cin').val('');
            $('#e4ain').val('');   $('#e4bin').val('');  $('#e4cin').val('');  $('#e5in').val('');
            $('#e6in').val('');    $('#e7in').val('');   $('#e8in').val('');   $('#e9in').val('');
        },
        error: function (data) {
            hidelargeloader();
        }
    });		     
}

function prosesClickBrake(urlAct){
    var kirim  = '';
    var kode   = new Array();
    var idHasil = $('#id_hasil_uji').val();
    var alt_uji = '';
    if ($('#um21').is(':checked'))  { kode[1] = 'UM21' } else { kode[1] = '' };
    if ($('#um22').is(':checked'))  { kode[2] = 'UM22' } else { kode[2] = '' };
    if ($('#um23').is(':checked'))  { kode[3] = 'UM23' } else { kode[3] = '' };
    if ($('#um24').is(':checked'))  { kode[4] = 'UM24' } else { kode[4] = '' };
    if ($('#um33').is(':checked'))  { kode[5] = 'UM33' } else { kode[5] = '' };
    //---------------------------------------------------
    //if ($("#edtCis").text() == 'MULLER') { posisi = 1; } else { posisi = 2; };
    kirim = $('#bsb1').val()+','+$('#bsb2').val()+','+$('#bsb3').val()+','+$('#bsb4').val()+','+
    $('#bsel1').val()+','+$('#bsel2').val()+','+$('#bsel3').val()+','+$('#bsel4').val()+','+$("#edtCis").text(); 
    kirim = kirim +','+kode+','+alt_uji;
    var lain_lain = $('#form_lain').val();
    //alert(kirim);
    $.ajax({
        url: urlAct,
        type: 'POST',
        data: {idhasil: idHasil,variabel:kirim,lain_lain:lain_lain},
        beforeSend: function () {
            showlargeloader();
        },
        success: function (data) {
            hidelargeloader();
            $('#bsb1').val('');  $('#bsb2').val('');  $('#bsb3').val('');  $('#bsb4').val('');
            $('#bsel1').val(''); $('#bsel2').val(''); $('#bsel3').val(''); $('#bsel4').val('');
            $("#um21").removeAttr("checked"); $("#um22").removeAttr("checked"); $("#um23").removeAttr("checked");
            $("#um24").removeAttr("checked"); $("#um33").removeAttr("checked");
        },
        error: function (data) {
            hidelargeloader();
        }
    });
    
}