function prosesSearchPitlift() {
  //    $('#pitliftListGrid').datagrid('reload');
  $("#pitliftListGrid").datagrid({
    url: "Pitlift/ListGrid",
    onBeforeLoad: function (params) {},
    onLoadError: function () {
      return false;
    },
    onLoadSuccess: function () {},
  });
}

function getInformationPitlift() {
  var row = $("#pitliftListGrid").datagrid("getSelected");
  var no_kendaraan = row.no_kendaraan;
  var no_uji = row.no_uji;
  var id_hasil_uji = row.id_hasil_uji;
  var posisi = row.posisi;
  var no_antrian = row.no_antrian;
  var id_kendaraan = row.id_kendaraan;
  $("#no_kendaraan_pitlift").val(no_kendaraan);
  $("#posisi_cis_pitlift").val(posisi);
  $("#no_uji_pitlift").val(no_uji);
  $("#id_hasil_uji_pitlift").val(id_hasil_uji);
  $("#no_antrian_pitlift").val(no_antrian);

  $.ajax({
    type: "POST",
    url: "Default/LoadTl",
    data: { idkendaraan: id_kendaraan },
    dataType: "JSON",
    beforeSend: function () {
      showlargeloader();
    },
    success: function (data) {
      hidelargeloader();
      $("#muncul_tl").html(data.dataTl);
    },
    error: function () {
      hidelargeloader();
      return false;
    },
  });
}

function reloadDataPitlift(urlAct) {
  var tahun_kendaraan = $("#tahun_pitlift").val();
  $.ajax({
    type: "POST",
    url: urlAct,
    data: { tahun_kendaraan: tahun_kendaraan },
    dataType: "JSON",
    success: function (data) {
      $("#kuat_kanan").val(data.lampu_kanan);
      $("#kuat_kiri").val(data.lampu_kiri);
      $("#deviasi_kanan").val(data.dev_kanan);
      $("#deviasi_kiri").val(data.dev_kiri);
    },
  });
}

function prosesPitlift(urlAct) {
  var id_hasil_uji = $("#id_hasil_uji_pitlift").val();
  var posisi = $("#posisi_cis_pitlift").val();
  var username = $("#username_pitlift").val();

  if (id_hasil_uji != "") {
    var kode = new Array();
    var kirim = "";
    if ($("#g1").is(":checked")) {
      kode[1] = "G01";
    }
    if ($("#g2").is(":checked")) {
      kode[2] = "G02";
    }
    if ($("#g3").is(":checked")) {
      kode[3] = "G03";
    }
    if ($("#g4a").is(":checked")) {
      kode[4] = "G04A";
    }
    if ($("#g4b").is(":checked")) {
      kode[5] = "G04B";
    }
    if ($("#g6a").is(":checked")) {
      kode[6] = "G06A";
    }
    if ($("#g6b").is(":checked")) {
      kode[7] = "G06B";
    }
    if ($("#g7a1").is(":checked")) {
      kode[8] = "G7A1";
    }
    if ($("#g7a2").is(":checked")) {
      kode[9] = "G7A2";
    }
    if ($("#g7a3").is(":checked")) {
      kode[10] = "G7A3";
    }
    if ($("#g7a4").is(":checked")) {
      kode[11] = "G7A4";
    }
    if ($("#g7a5").is(":checked")) {
      kode[12] = "G7A5";
    }
    if ($("#g7a6").is(":checked")) {
      kode[13] = "G7A6";
    }
    if ($("#g7a7").is(":checked")) {
      kode[14] = "G7A7";
    }
    if ($("#g7a8").is(":checked")) {
      kode[15] = "G7A8";
    }
    if ($("#g7b1").is(":checked")) {
      kode[16] = "G7B1";
    }
    if ($("#g7b2").is(":checked")) {
      kode[17] = "G7B2";
    }
    if ($("#g7b3").is(":checked")) {
      kode[18] = "G7B3";
    }
    if ($("#g7b4").is(":checked")) {
      kode[19] = "G7B4";
    }
    if ($("#g7b5").is(":checked")) {
      kode[20] = "G7B5";
    }
    if ($("#g7b6").is(":checked")) {
      kode[21] = "G7B6";
    }
    if ($("#g7b7").is(":checked")) {
      kode[22] = "G7B7";
    }
    if ($("#g7b8").is(":checked")) {
      kode[23] = "G7B8";
    }
    if ($("#g8a1").is(":checked")) {
      kode[24] = "G8A1";
    }
    if ($("#g8a2").is(":checked")) {
      kode[25] = "G8A2";
    }
    if ($("#g8a3").is(":checked")) {
      kode[26] = "G8A3";
    }
    if ($("#g8a4").is(":checked")) {
      kode[27] = "G8A4";
    }
    if ($("#g8a5").is(":checked")) {
      kode[28] = "G8A5";
    }
    if ($("#g8a6").is(":checked")) {
      kode[29] = "G8A6";
    }
    if ($("#g8a7").is(":checked")) {
      kode[30] = "G8A7";
    }
    if ($("#g8a8").is(":checked")) {
      kode[31] = "G8A8";
    }
    if ($("#g8b1").is(":checked")) {
      kode[32] = "G8B1";
    }
    if ($("#g8b2").is(":checked")) {
      kode[33] = "G8B2";
    }
    if ($("#g8b3").is(":checked")) {
      kode[34] = "G8B3";
    }
    if ($("#g8b4").is(":checked")) {
      kode[35] = "G8B4";
    }
    if ($("#g8b5").is(":checked")) {
      kode[36] = "G8B5";
    }
    if ($("#g8b6").is(":checked")) {
      kode[37] = "G8B6";
    }
    if ($("#g8b7").is(":checked")) {
      kode[38] = "G8B7";
    }
    if ($("#g8b8").is(":checked")) {
      kode[39] = "G8B8";
    }
    if ($("#g8c1").is(":checked")) {
      kode[40] = "G8C1";
    }
    if ($("#g8c2").is(":checked")) {
      kode[41] = "G8C2";
    }
    if ($("#g8c3").is(":checked")) {
      kode[42] = "G8C3";
    }
    if ($("#g8c4").is(":checked")) {
      kode[43] = "G8C4";
    }
    if ($("#g8d1").is(":checked")) {
      kode[44] = "G8D1";
    }
    if ($("#g8d2").is(":checked")) {
      kode[45] = "G8D2";
    }
    if ($("#g8d3").is(":checked")) {
      kode[46] = "G8D3";
    }
    if ($("#g8d4").is(":checked")) {
      kode[47] = "G8D4";
    }
    if ($("#g8d5").is(":checked")) {
      kode[48] = "G8D5";
    }
    if ($("#g8d6").is(":checked")) {
      kode[49] = "G8D6";
    }
    if ($("#g8d7").is(":checked")) {
      kode[50] = "G8D7";
    }
    if ($("#g8d8").is(":checked")) {
      kode[51] = "G8D8";
    }
    if ($("#g9a").is(":checked")) {
      kode[52] = "G9A";
    }
    if ($("#g9b").is(":checked")) {
      kode[53] = "G9B";
    }
    if ($("#g9c").is(":checked")) {
      kode[54] = "G9C";
    }
    if ($("#g9d").is(":checked")) {
      kode[55] = "G9D";
    }
    if ($("#g9e").is(":checked")) {
      kode[56] = "G9E";
    }
    if ($("#g9f").is(":checked")) {
      kode[57] = "G9F";
    }
    if ($("#g9g").is(":checked")) {
      kode[58] = "G9G";
    }
    if ($("#g9h").is(":checked")) {
      kode[59] = "G9H";
    }
    if ($("#g10a").is(":checked")) {
      kode[60] = "G10A";
    }
    if ($("#g10b").is(":checked")) {
      kode[61] = "G10B";
    }
    if ($("#g10c").is(":checked")) {
      kode[62] = "G10C";
    }
    if ($("#g10d").is(":checked")) {
      kode[63] = "G10D";
    }
    if ($("#g10e").is(":checked")) {
      kode[64] = "G10E";
    }
    if ($("#g10f").is(":checked")) {
      kode[65] = "G10F";
    }
    if ($("#g10g").is(":checked")) {
      kode[66] = "G10G";
    }
    if ($("#g10h").is(":checked")) {
      kode[67] = "G10H";
    }
    if ($("#g11a").is(":checked")) {
      kode[68] = "G11A";
    }
    if ($("#g11b").is(":checked")) {
      kode[69] = "G11B";
    }
    if ($("#g11c").is(":checked")) {
      kode[70] = "G11C";
    }
    if ($("#g11d").is(":checked")) {
      kode[71] = "G11D";
    }
    if ($("#g11e").is(":checked")) {
      kode[72] = "G11E";
    }
    if ($("#g11f").is(":checked")) {
      kode[73] = "G11F";
    }
    if ($("#g11g").is(":checked")) {
      kode[74] = "G11G";
    }
    if ($("#g11h").is(":checked")) {
      kode[75] = "G11H";
    }
    if ($("#g11").is(":checked")) {
      kode[76] = "G11";
    }
    if ($("#g12").is(":checked")) {
      kode[77] = "G12";
    }
    if ($("#g13").is(":checked")) {
      kode[78] = "G13";
    }
    if ($("#g13a").is(":checked")) {
      kode[79] = "G13A";
    }
    if ($("#g13b").is(":checked")) {
      kode[80] = "G13B";
    }
    if ($("#g13c").is(":checked")) {
      kode[81] = "G13C";
    }
    if ($("#g13d").is(":checked")) {
      kode[82] = "G13D";
    }
    if ($("#g13e").is(":checked")) {
      kode[83] = "G13E";
    }
    if ($("#g13f").is(":checked")) {
      kode[84] = "G13F";
    }
    if ($("#g13g").is(":checked")) {
      kode[85] = "G13G";
    }
    if ($("#g13h").is(":checked")) {
      kode[86] = "G13H";
    }
    if ($("#g13i").is(":checked")) {
      kode[87] = "G13I";
    }
    if ($("#g13j").is(":checked")) {
      kode[88] = "G13J";
    }
    if ($("#g14").is(":checked")) {
      kode[89] = "G14";
    }
    if ($("#g15").is(":checked")) {
      kode[90] = "G15";
    }
    if ($("#g16").is(":checked")) {
      kode[91] = "G16";
    }
    if ($("#g17").is(":checked")) {
      kode[92] = "G17";
    }
    if ($("#g18").is(":checked")) {
      kode[93] = "G18";
    }
    if ($("#g19").is(":checked")) {
      kode[94] = "G19";
    }
    if ($("#g20").is(":checked")) {
      kode[95] = "G20";
    }
    if ($("#g20a").is(":checked")) {
      kode[96] = "G20A";
    }
    if ($("#g20b").is(":checked")) {
      kode[97] = "G20B";
    }
    if ($("#g21").is(":checked")) {
      kode[98] = "G21";
    }
    if ($("#g22").is(":checked")) {
      kode[99] = "G22";
    }
    if ($("#g23").is(":checked")) {
      kode[100] = "G23";
    }
    if ($("#g24").is(":checked")) {
      kode[101] = "G24";
    }
    if ($("#g25").is(":checked")) {
      kode[102] = "G25";
    }
    if ($("#g26").is(":checked")) {
      kode[103] = "G26";
    }
    if ($("#g27").is(":checked")) {
      kode[104] = "G27";
    }
    if ($("#g28").is(":checked")) {
      kode[105] = "G28";
    }
    if ($("#g29").is(":checked")) {
      kode[106] = "G29";
    }
    if ($("#g30").is(":checked")) {
      kode[107] = "G30";
    }
    if ($("#g31a").is(":checked")) {
      kode[108] = "G31A";
    }
    if ($("#g31b").is(":checked")) {
      kode[109] = "G31B";
    }
    if ($("#g31c").is(":checked")) {
      kode[110] = "G31C";
    }
    if ($("#g31d").is(":checked")) {
      kode[111] = "G31D";
    }
    if ($("#g32").is(":checked")) {
      kode[112] = "G32";
    }
    if ($("#g33").is(":checked")) {
      kode[113] = "G33";
    }
    if ($("#g34").is(":checked")) {
      kode[114] = "G34";
    }
    if ($("#g35").is(":checked")) {
      kode[115] = "G35";
    }
    if ($("#g36a").is(":checked")) {
      kode[116] = "G36A";
    }
    if ($("#g36b").is(":checked")) {
      kode[117] = "G36B";
    }
    if ($("#g36c").is(":checked")) {
      kode[118] = "G36C";
    }
    if ($("#g36d").is(":checked")) {
      kode[119] = "G36D";
    }
    if ($("#g36e").is(":checked")) {
      kode[120] = "G36E";
    }
    if ($("#g36f").is(":checked")) {
      kode[121] = "G36F";
    }
    if ($("#g36g").is(":checked")) {
      kode[122] = "G36G";
    }
    if ($("#g36h").is(":checked")) {
      kode[123] = "G36H";
    }
    //---------------------------------------------------------------------------
    if ($("#g5a").is(":checked")) {
      kode[124] = "G05A";
    }
    if ($("#g5b").is(":checked")) {
      kode[125] = "G05B";
    }
    if ($("#g6a1").is(":checked")) {
      kode[126] = "G06A1";
    }
    if ($("#g6a2").is(":checked")) {
      kode[127] = "G06A2";
    }
    if ($("#g6a3").is(":checked")) {
      kode[128] = "G06A3";
    }
    if ($("#g6a4").is(":checked")) {
      kode[129] = "G06A4";
    }
    if ($("#g6b1").is(":checked")) {
      kode[130] = "G06B1";
    }
    if ($("#g6b2").is(":checked")) {
      kode[131] = "G06B2";
    }
    if ($("#g6b3").is(":checked")) {
      kode[132] = "G06B3";
    }
    if ($("#g6b4").is(":checked")) {
      kode[133] = "G06B4";
    }

    if ($("#g8c5").is(":checked")) {
      kode[134] = "G8C5";
    }
    if ($("#g8c6").is(":checked")) {
      kode[135] = "G8C6";
    }
    if ($("#g8c7").is(":checked")) {
      kode[136] = "G8C7";
    }
    if ($("#g8c8").is(":checked")) {
      kode[137] = "G8C8";
    }
    if ($("#g37").is(":checked")) {
      kode[138] = "G37";
    }
    if ($("#g38").is(":checked")) {
      kode[139] = "G38";
    }
    if ($("#d40a").is(":checked")) {
      kode[140] = "D03A";
    }
    if ($("#d40b").is(":checked")) {
      kode[141] = "D03B";
    }
    if ($("#d40c").is(":checked")) {
      kode[142] = "D03C";
    }
    if ($("#d40d").is(":checked")) {
      kode[143] = "D03D";
    }
    if ($("#d40e").is(":checked")) {
      kode[144] = "D03E";
    }
    if ($("#d40f").is(":checked")) {
      kode[145] = "D03F";
    }
    if ($("#d40g").is(":checked")) {
      kode[146] = "D03G";
    }
    if ($("#d40h").is(":checked")) {
      kode[147] = "D03H";
    }
    //---------------------------------------------------------------------------
    //        var rows = $('#pitliftLainListGrid').datagrid('getChecked');
    //        var ids = [];
    //        for (var i = 0; i < rows.length; i++) {
    //            ids.push(rows[i].kd_lulus);
    //        }

    for (i = 1; i < kode.length; i++) {
      if (kode[i] != null) {
        kirim = kirim + kode[i] + ",";
      }
    }
    //        kirim = kirim + ids;
    $.messager.defaults.ok = "Ya";
    $.messager.defaults.cancel = "Tidak";
    $.messager.confirm(
      "Confirm",
      "Apakah anda yakin ingin memproses kendaraan berikut?",
      function (r) {
        if (r) {
          $.ajax({
            type: "POST",
            url: urlAct,
            data: {
              variabel: kirim,
              id_hasil_uji: id_hasil_uji,
              cis: posisi,
              username: username,
            },
            success: function (data) {
              $("#id_hasil_uji_pitlift").val("");
              $("#no_kendaraan_pitlift").val("");
              $("#no_uji_pitlift").val("");
              $("#no_antrian_pitlift").val("");

              $("#g1").iCheck("uncheck");
              $("#g2").iCheck("uncheck");
              $("#g3").iCheck("uncheck");
              $("#g4a").iCheck("uncheck");
              $("#g4b").iCheck("uncheck");
              $("#g6a").iCheck("uncheck");
              $("#g6b").iCheck("uncheck");
              $("#g7a1").iCheck("uncheck");
              $("#g7a2").iCheck("uncheck");
              $("#g7a3").iCheck("uncheck");
              $("#g7a4").iCheck("uncheck");
              $("#g7a5").iCheck("uncheck");
              $("#g7a6").iCheck("uncheck");
              $("#g7a7").iCheck("uncheck");
              $("#g7a8").iCheck("uncheck");
              $("#g7b1").iCheck("uncheck");
              $("#g7b2").iCheck("uncheck");
              $("#g7b3").iCheck("uncheck");
              $("#g7b4").iCheck("uncheck");
              $("#g7b5").iCheck("uncheck");
              $("#g7b6").iCheck("uncheck");
              $("#g7b7").iCheck("uncheck");
              $("#g7b8").iCheck("uncheck");
              $("#g8a1").iCheck("uncheck");
              $("#g8a2").iCheck("uncheck");
              $("#g8a3").iCheck("uncheck");
              $("#g8a4").iCheck("uncheck");
              $("#g8a5").iCheck("uncheck");
              $("#g8a6").iCheck("uncheck");
              $("#g8a7").iCheck("uncheck");
              $("#g8a8").iCheck("uncheck");
              $("#g8b1").iCheck("uncheck");
              $("#g8b2").iCheck("uncheck");
              $("#g8b3").iCheck("uncheck");
              $("#g8b4").iCheck("uncheck");
              $("#g8b5").iCheck("uncheck");
              $("#g8b6").iCheck("uncheck");
              $("#g8b7").iCheck("uncheck");
              $("#g8b8").iCheck("uncheck");
              $("#g8c1").iCheck("uncheck");
              $("#g8c2").iCheck("uncheck");
              $("#g8c3").iCheck("uncheck");
              $("#g8c4").iCheck("uncheck");
              $("#g8d1").iCheck("uncheck");
              $("#g8d2").iCheck("uncheck");
              $("#g8d3").iCheck("uncheck");
              $("#g8d4").iCheck("uncheck");
              $("#g8d5").iCheck("uncheck");
              $("#g8d6").iCheck("uncheck");
              $("#g8d7").iCheck("uncheck");
              $("#g8d8").iCheck("uncheck");
              $("#g9a").iCheck("uncheck");
              $("#g9b").iCheck("uncheck");
              $("#g9c").iCheck("uncheck");
              $("#g9d").iCheck("uncheck");
              $("#g9e").iCheck("uncheck");
              $("#g9f").iCheck("uncheck");
              $("#g9g").iCheck("uncheck");
              $("#g9h").iCheck("uncheck");
              $("#g10a").iCheck("uncheck");
              $("#g10b").iCheck("uncheck");
              $("#g10c").iCheck("uncheck");
              $("#g10d").iCheck("uncheck");
              $("#g10e").iCheck("uncheck");
              $("#g10f").iCheck("uncheck");
              $("#g10g").iCheck("uncheck");
              $("#g10h").iCheck("uncheck");
              $("#g11a").iCheck("uncheck");
              $("#g11b").iCheck("uncheck");
              $("#g11c").iCheck("uncheck");
              $("#g11d").iCheck("uncheck");
              $("#g11e").iCheck("uncheck");
              $("#g11f").iCheck("uncheck");
              $("#g11g").iCheck("uncheck");
              $("#g11h").iCheck("uncheck");
              $("#g11").iCheck("uncheck");
              $("#g12").iCheck("uncheck");
              $("#g13").iCheck("uncheck");
              $("#g13a").iCheck("uncheck");
              $("#g13b").iCheck("uncheck");
              $("#g13c").iCheck("uncheck");
              $("#g13d").iCheck("uncheck");
              $("#g13e").iCheck("uncheck");
              $("#g13f").iCheck("uncheck");
              $("#g13g").iCheck("uncheck");
              $("#g13h").iCheck("uncheck");
              $("#g13i").iCheck("uncheck");
              $("#g13j").iCheck("uncheck");
              $("#g14").iCheck("uncheck");
              $("#g15").iCheck("uncheck");
              $("#g16").iCheck("uncheck");
              $("#g17").iCheck("uncheck");
              $("#g18").iCheck("uncheck");
              $("#g19").iCheck("uncheck");
              $("#g20").iCheck("uncheck");
              $("#g20a").iCheck("uncheck");
              $("#g20b").iCheck("uncheck");
              $("#g21").iCheck("uncheck");
              $("#g22").iCheck("uncheck");
              $("#g23").iCheck("uncheck");
              $("#g24").iCheck("uncheck");
              $("#g25").iCheck("uncheck");
              $("#g26").iCheck("uncheck");
              $("#g27").iCheck("uncheck");
              $("#g28").iCheck("uncheck");
              $("#g29").iCheck("uncheck");
              $("#g30").iCheck("uncheck");
              $("#g31a").iCheck("uncheck");
              $("#g31b").iCheck("uncheck");
              $("#g31c").iCheck("uncheck");
              $("#g31d").iCheck("uncheck");
              $("#g32").iCheck("uncheck");
              $("#g33").iCheck("uncheck");
              $("#g34").iCheck("uncheck");
              $("#g35").iCheck("uncheck");
              $("#g36a").iCheck("uncheck");
              $("#g36b").iCheck("uncheck");
              $("#g36c").iCheck("uncheck");
              $("#g36d").iCheck("uncheck");
              $("#g36e").iCheck("uncheck");
              $("#g36f").iCheck("uncheck");
              $("#g36g").iCheck("uncheck");
              $("#g36h").iCheck("uncheck");
              $("#g38").iCheck("uncheck");
              //---------------------------------------------------------------------------
              $("#g5a").iCheck("uncheck");
              $("#g5b").iCheck("uncheck");
              $("#g6a1").iCheck("uncheck");
              $("#g6a2").iCheck("uncheck");
              $("#g6a3").iCheck("uncheck");
              $("#g6a4").iCheck("uncheck");
              $("#g6b1").iCheck("uncheck");
              $("#g6b2").iCheck("uncheck");
              $("#g6b3").iCheck("uncheck");
              $("#g6b4").iCheck("uncheck");
              $("#g7a1").iCheck("uncheck");
              $("#g7a2").iCheck("uncheck");
              $("#g7a3").iCheck("uncheck");
              $("#g7a4").iCheck("uncheck");
              $("#g7b1").iCheck("uncheck");
              $("#g7b2").iCheck("uncheck");
              $("#g7b3").iCheck("uncheck");
              $("#g7b4").iCheck("uncheck");
              $("#g8c5").iCheck("uncheck");
              $("#g8c6").iCheck("uncheck");
              $("#g8c7").iCheck("uncheck");
              $("#g8c8").iCheck("uncheck");
              $("#g37").iCheck("uncheck");
              $("#d40a").iCheck("uncheck");
              $("#d40b").iCheck("uncheck");
              $("#d40c").iCheck("uncheck");
              $("#d40d").iCheck("uncheck");
              $("#d40e").iCheck("uncheck");
              $("#d40f").iCheck("uncheck");
              $("#d40g").iCheck("uncheck");
              $("#d40h").iCheck("uncheck");
              $("#muncul_tl").text("");
              prosesSearchPitlift();
              $("#pitliftLainListGrid").datagrid("reload");
            },
            error: function () {
              return false;
            },
          });
        }
      }
    );
  } else {
    alert("Data Kendaraan Belum Dipilih !");
  }
}
