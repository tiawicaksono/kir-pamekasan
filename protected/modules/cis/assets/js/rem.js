$(document).ready(function () {
  $("#bsb1").numeric({ decimal: false, negative: false });
  $("#bsb2").numeric({ decimal: false, negative: false });
  $("#bsb3").numeric({ decimal: false, negative: false });
  $("#bsb4").numeric({ decimal: false, negative: false });
  $("#bsel1").numeric({ decimal: false, negative: false });
  $("#bsel2").numeric({ decimal: false, negative: false });
  $("#bsel3").numeric({ decimal: false, negative: false });
  $("#bsel4").numeric({ decimal: false, negative: false });
});

function prosesSearchRem() {
  //    $('#remListGrid').datagrid('reload');
  $("#remListGrid").datagrid({
    url: "Rem/ListGrid",
    onBeforeLoad: function (params) {
      params.textCategory = $("#text_category_rem").val();
    },
    onLoadError: function () {
      return false;
    },
    onLoadSuccess: function () {},
  });
}

function getInformationRem() {
  var row = $("#remListGrid").datagrid("getSelected");
  var no_kendaraan = row.no_kendaraan;
  var no_uji = row.no_uji;
  var id_hasil_uji = row.id_hasil_uji;
  var posisi = row.posisi;
  var no_antrian = row.no_antrian;
  var tipe = row.id_jns_kend;
  //==================================
  var sumbu1 = row.bsumbu1;
  var sumbu2 = row.bsumbu2;
  var sumbu3 = row.bsumbu3;
  var sumbu4 = row.bsumbu4;
  $("#bsumbu1").val(sumbu1);
  $("#bsumbu2").val(sumbu2);
  $("#bsumbu3").val(sumbu3);
  $("#bsumbu4").val(sumbu4);
  //==================================

  $("#no_kendaraan_rem").val(no_kendaraan);
  $("#posisi_cis_rem").val(posisi);
  $("#no_uji_rem").val(no_uji);
  $("#id_hasil_uji_rem").val(id_hasil_uji);
  $("#no_antrian_rem").val(no_antrian);

  $("#bsb1kr").prop("readonly", false);
  $("#bsb1kr").css("background-color", "#fff");
  $("#bsb1kn").prop("readonly", false);
  $("#bsb1kn").css("background-color", "#fff");

  $("#bsb2kr").prop("readonly", false);
  $("#bsb2kr").css("background-color", "#fff");
  $("#bsb2kn").prop("readonly", false);
  $("#bsb2kn").css("background-color", "#fff");

  $("#bsb3kr").prop("readonly", false);
  $("#bsb3kr").css("background-color", "#fff");
  $("#bsb3kn").prop("readonly", false);
  $("#bsb3kn").css("background-color", "#fff");

  $("#bsb4kr").prop("readonly", false);
  $("#bsb4kr").css("background-color", "#fff");
  $("#bsb4kn").prop("readonly", false);
  $("#bsb4kn").css("background-color", "#fff");

  if (tipe == 5) {
    $("#bsb1kr").val(0);
    $("#bsb1kn").val(0);
    $("#bsb1kr").prop("readonly", true);
    $("#bsb1kr").css("background-color", "#eaeae1");
    $("#bsb1kn").prop("readonly", true);
    $("#bsb1kn").css("background-color", "#eaeae1");

    if (sumbu2 == "0" || sumbu2 == "") {
      $("#bsb2").val(0);
      $("#bsel2").val(0);
      $("#bsb2kr").val(0);
      $("#bsb2kn").val(0);
      $("#bsb2kr").prop("readonly", true);
      $("#bsb2kr").css("background-color", "#eaeae1");
      $("#bsb2kn").prop("readonly", true);
      $("#bsb2kn").css("background-color", "#eaeae1");
    }
    if (sumbu3 == "0" || sumbu3 == "") {
      $("#bsb3").val(0);
      $("#bsel3").val(0);
      $("#bsb3kr").val(0);
      $("#bsb3kn").val(0);
      $("#bsb3kr").prop("readonly", true);
      $("#bsb3kr").css("background-color", "#eaeae1");
      $("#bsb3kn").prop("readonly", true);
      $("#bsb3kn").css("background-color", "#eaeae1");
    }
    if (sumbu4 == "0" || sumbu4 == "") {
      $("#bsb4").val(0);
      $("#bsel4").val(0);
      $("#bsb4kr").val(0);
      $("#bsb4kn").val(0);
      $("#bsb4kr").prop("readonly", true);
      $("#bsb4kr").css("background-color", "#eaeae1");
      $("#bsb4kn").prop("readonly", true);
      $("#bsb4kn").css("background-color", "#eaeae1");
    }
  } else {
    $("#bsb1kr").prop("readonly", false);
    $("#bsb1kr").css("background-color", "#fff");
    $("#bsb1kn").prop("readonly", false);
    $("#bsb1kn").css("background-color", "#fff");

    if (sumbu1 == "0" || sumbu1 == "") {
      $("#bsb1").val(0);
      $("#bsel1").val(0);
      $("#bsb1kr").val(0);
      $("#bsb1kn").val(0);
      $("#bsb1kr").prop("readonly", true);
      $("#bsb1kr").css("background-color", "#eaeae1");
      $("#bsb1kn").prop("readonly", true);
      $("#bsb1kn").css("background-color", "#eaeae1");
    }
    if (sumbu2 == "0" || sumbu2 == "") {
      $("#bsb2").val(0);
      $("#bsel2").val(0);
      $("#bsb2kr").val(0);
      $("#bsb2kn").val(0);
      $("#bsb2kr").prop("readonly", true);
      $("#bsb2kr").css("background-color", "#eaeae1");
      $("#bsb2kn").prop("readonly", true);
      $("#bsb2kn").css("background-color", "#eaeae1");
    }
    if (sumbu3 == "0" || sumbu3 == "") {
      $("#bsb3").val(0);
      $("#bsel3").val(0);
      $("#bsb3kr").val(0);
      $("#bsb3kn").val(0);
      $("#bsb3kr").prop("readonly", true);
      $("#bsb3kr").css("background-color", "#eaeae1");
      $("#bsb3kn").prop("readonly", true);
      $("#bsb3kn").css("background-color", "#eaeae1");
    }
    if (sumbu4 == "0" || sumbu4 == "") {
      $("#bsb4").val(0);
      $("#bsel4").val(0);
      $("#bsb4kr").val(0);
      $("#bsb4kn").val(0);
      $("#bsb4kr").prop("readonly", true);
      $("#bsb4kr").css("background-color", "#eaeae1");
      $("#bsb4kn").prop("readonly", true);
      $("#bsb4kn").css("background-color", "#eaeae1");
    }
  }
}

function reloadDataRem(urlAct) {
  var tahun_kendaraan = $("#tahun_rem").val();
  var row = $("#remListGrid").datagrid("getSelected");
  var tipe = row.id_jns_kend;
  var sumbu1 = row.bsumbu1;
  var sumbu2 = row.bsumbu2;
  var sumbu3 = row.bsumbu3;
  var sumbu4 = row.bsumbu4;
  $.ajax({
    type: "POST",
    url: urlAct,
    data: { tahun_kendaraan: tahun_kendaraan },
    dataType: "JSON",
    success: function (data) {
      var kiri1 = Math.round((data.kiri1 / 100) * sumbu1);
      var kiri2 = Math.round((data.kiri2 / 100) * sumbu2);
      var kiri3 = Math.round((data.kiri3 / 100) * sumbu3);
      var kiri4 = Math.round((data.kiri4 / 100) * sumbu4);
      var kanan1 = Math.round((data.kanan1 / 100) * sumbu1);
      var kanan2 = Math.round((data.kanan2 / 100) * sumbu2);
      var kanan3 = Math.round((data.kanan3 / 100) * sumbu3);
      var kanan4 = Math.round((data.kanan4 / 100) * sumbu4);
      var selisih_sumbu1 = Math.ceil(((kanan1 - kiri1) / sumbu1) * 100);
      var selisih_sumbu2 = Math.ceil(((kanan2 - kiri2) / sumbu2) * 100);
      var selisih_sumbu3 = Math.ceil(((kanan3 - kiri3) / sumbu3) * 100);
      var selisih_sumbu4 = Math.ceil(((kanan4 - kiri4) / sumbu4) * 100);
      if (tipe == 5) {
        if (sumbu2 == "0" || sumbu2 == "") {
          $("#bsb2").val(0);
          $("#bsel2").val(0);
        } else {
          $("#bsb2").val(data.bsb2);
          $("#bsel2").val(selisih_sumbu2);
          $("#bsb2kr").val(kiri2);
          $("#bsb2kn").val(kanan2);
        }
        if (sumbu3 == "0" || sumbu3 == "") {
          $("#bsb3").val(0);
          $("#bsel3").val(0);
        } else {
          $("#bsb3").val(data.bsb3);
          $("#bsel3").val(selisih_sumbu3);
          $("#bsb3kr").val(kiri3);
          $("#bsb3kn").val(kanan3);
        }
        if (sumbu4 == "0" || sumbu4 == "") {
          $("#bsb4").val(0);
          $("#bsel4").val(0);
        } else {
          $("#bsb4").val(data.bsb4);
          $("#bsel4").val(selisih_sumbu4);
          $("#bsb4kr").val(kiri4);
          $("#bsb4kn").val(kanan4);
        }
      } else {
        if (sumbu1 == "0" || sumbu1 == "") {
          $("#bsb1").val(0);
          $("#bsel1").val(0);
        } else {
          $("#bsb1").val(data.bsb1);
          $("#bsel1").val(selisih_sumbu1);
          $("#bsb1kr").val(kiri1);
          $("#bsb1kn").val(kanan1);
        }
        if (sumbu2 == "0" || sumbu2 == "") {
          $("#bsb2").val(0);
          $("#bsel2").val(0);
        } else {
          $("#bsb2").val(data.bsb2);
          $("#bsel2").val(selisih_sumbu2);
          $("#bsb2kr").val(kiri2);
          $("#bsb2kn").val(kanan2);
        }
        if (sumbu3 == "0" || sumbu3 == "") {
          $("#bsb3").val(0);
          $("#bsel3").val(0);
        } else {
          $("#bsb3").val(data.bsb3);
          $("#bsel3").val(selisih_sumbu3);
          $("#bsb3kr").val(kiri3);
          $("#bsb3kn").val(kanan3);
        }
        if (sumbu4 == "0" || sumbu4 == "") {
          $("#bsb4").val(0);
          $("#bsel4").val(0);
        } else {
          $("#bsb4").val(data.bsb4);
          $("#bsel4").val(selisih_sumbu4);
          $("#bsb4kr").val(kiri4);
          $("#bsb4kn").val(kanan4);
        }
      }
    },
  });
}

function prosesRem(urlAct) {
  var id_hasil_uji = $("#id_hasil_uji_rem").val();
  var posisi = $("#posisi_cis_rem").val();
  var username = $("#username_rem").val();
  var kategori_rem = $("#text_category_rem").val();

  if (id_hasil_uji != "") {
    var kirim = "";
    var kode = new Array();
    if ($("#um21").is(":checked")) {
      kode[1] = "UM21";
    } else {
      kode[1] = "";
    }
    if ($("#um22").is(":checked")) {
      kode[2] = "UM22";
    } else {
      kode[2] = "";
    }
    if ($("#um23").is(":checked")) {
      kode[3] = "UM23";
    } else {
      kode[3] = "";
    }
    if ($("#um24").is(":checked")) {
      kode[4] = "UM24";
    } else {
      kode[4] = "";
    }
    if ($("#g34").is(":checked")) {
      kode[5] = "G34";
    } else {
      kode[5] = "";
    }
    //---------------------------------------------------
    kirim =
      $("#bsb1").val() +
      "," +
      $("#bsb2").val() +
      "," +
      $("#bsb3").val() +
      "," +
      $("#bsb4").val() +
      "," +
      $("#bsel1").val() +
      "," +
      $("#bsel2").val() +
      "," +
      $("#bsel3").val() +
      "," +
      $("#bsel4").val();
    kirim = kirim + "," + kode;
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
              kategori_rem: kategori_rem,
            },
            success: function (data) {
              $("#muncul_tl").text("");
              $("#id_hasil_uji_rem").val("");
              $("#no_kendaraan_rem").val("");
              $("#no_uji_rem").val("");
              $("#tahun_rem").val("");
              $("#no_antrian_rem").val("");

              $("#bsb1kr").val("");
              $("#bsb2kr").val("");
              $("#bsb3kr").val("");
              $("#bsb4kr").val("");
              $("#bsb1kn").val("");
              $("#bsb2kn").val("");
              $("#bsb3kn").val("");
              $("#bsb4kn").val("");
              $("#bsb1kr").prop("readonly", false);
              $("#bsb1kr").css("background-color", "#fff");
              $("#bsb1kn").prop("readonly", false);
              $("#bsb1kn").css("background-color", "#fff");
              $("#bsb2kr").prop("readonly", false);
              $("#bsb2kr").css("background-color", "#fff");
              $("#bsb2kn").prop("readonly", false);
              $("#bsb2kn").css("background-color", "#fff");
              $("#bsb3kr").prop("readonly", false);
              $("#bsb3kr").css("background-color", "#fff");
              $("#bsb3kn").prop("readonly", false);
              $("#bsb3kn").css("background-color", "#fff");
              $("#bsb4kr").prop("readonly", false);
              $("#bsb4kr").css("background-color", "#fff");
              $("#bsb4kn").prop("readonly", false);
              $("#bsb4kn").css("background-color", "#fff");

              $("#bsb1").val("");
              $("#bsb2").val("");
              $("#bsb3").val("");
              $("#bsb4").val("");
              $("#bsel1").val("");
              $("#bsel2").val("");
              $("#bsel3").val("");
              $("#bsel4").val("");
              $("#bsb1").prop("readonly", false);
              $("#bsb1").css("background-color", "#fff");
              $("#bsel1").prop("readonly", false);
              $("#bsel1").css("background-color", "#fff");
              $("#bsb2").prop("readonly", false);
              $("#bsb2").css("background-color", "#fff");
              $("#bsel2").prop("readonly", false);
              $("#bsel2").css("background-color", "#fff");
              $("#bsb3").prop("readonly", false);
              $("#bsb3").css("background-color", "#fff");
              $("#bsel3").prop("readonly", false);
              $("#bsel3").css("background-color", "#fff");
              $("#bsb4").prop("readonly", false);
              $("#bsb4").css("background-color", "#fff");
              $("#bsel4").prop("readonly", false);
              $("#bsel4").css("background-color", "#fff");
              $("#um21").iCheck("uncheck");
              $("#um22").iCheck("uncheck");
              $("#um23").iCheck("uncheck");
              $("#um24").iCheck("uncheck");
              $("#um33").iCheck("uncheck");
              $("#g34").iCheck("uncheck");

              prosesSearchRem();
              prosesSearchLampu();
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
