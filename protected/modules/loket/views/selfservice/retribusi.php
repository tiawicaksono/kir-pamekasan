<!DOCTYPE html>
<html>

<head>
    <?php
    $baseUrl = Yii::app()->baseUrl;
    $cs = Yii::app()->clientScript;
    $cs->registerScriptFile($baseUrl . '/js/jquery-3.2.1.min.js', CClientScript::POS_BEGIN);
    ?>
    <style>
        /* $background: #f5f6fa;
        $text: #9c9c9c;
        $input-bg-color: #fff;
        $input-text-color: #a3a3a3;
        $button-bg-color: #7f8ff4;
        $button-text-color: #fff;
 */
        body {
            background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/ikm_1920x1080.png');
            background-color: #cccccc;
        }

        a {
            color: inherit;
        }

        a:hover {
            color: #7f8ff4;
        }


        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 15%;
        }

        .uppercase {
            text-transform: uppercase;
        }


        .btn {
            display: inline-block;
            background: transparent;
            color: inherit;
            font: inherit;
            border: 0;
            outline: 0;
            padding: 0;
            transition: all 200ms ease-in;
            cursor: pointer;
        }

        .btn--primary {
            background: #7f8ff4;
            color: white;
            box-shadow: 0 0 10px 2px rgba(0, 0, 0, .1);
            border-radius: 2px;
            padding: 12px 36px;
        }

        .btn--primary:hover {
            background: darken(#7f8ff4, 4%);
        }

        .btn--primary:active {
            background: #7f8ff4;
            box-shadow: inset 0 0 10px 2px rgba(0, 0, 0, .2);
        }

        .btn--inside {
            margin-left: -96px;
        }

        .form__field {
            width: 760px;
            background: #fff;
            color: black;
            font: inherit;
            box-shadow: 0 6px 10px 0 rgba(0, 0, 0, .1);
            border: 0;
            outline: 0;
            padding: 22px 18px;
            font-size: 24px;
        }

        .box {
            float: left;
            width: 50%;
            text-align: center;
            /* border: 5px solid #fff; */
            /* three boxes (use 25% for four, and 50% for two, etc) */
        }

        .card {
            margin-top: 40px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            width: 50%;
            background-color: white;
            margin-bottom: 30px;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .font-card {
            font-size: 30px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .block {
            display: block;
            color: white;
            font-weight: bold;
            font-size: 30px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
            float: left;
            width: 50%;
            padding-top: 20px;
            padding-bottom: 20px;
            border: 4px solid white;
            border-radius: 10px;
        }

        .batal {
            background-color: red;
        }

        .daftar {
            background-color: #04AA6D;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
            max-width: 40%;
        }

        .img {
            width: 70%;
            padding-top: 50px;
            cursor: pointer;
        }

        .content {
            max-width: 80%;
            margin: auto;
            text-align: center;
            padding-top: 17%;
        }

        td {
            vertical-align: top;
            padding: 5px;
        }

        .noted {
            color: red;
            font-size: 25px;
            font-style: italic;
            font-weight: bold;
        }

        #tidak_ada {
            color: red;
            font-size: 25px;
            font-weight: bold;
            padding-top: 5px;
        }

        #overlay {
            background: #000000;
            opacity: 0.5;
            bottom: 0;
            left: 0;
            position: fixed;
            right: 0;
            top: 0;
            z-index: 9999;
        }

        #popup {
            background: url('<?php echo Yii::app()->baseUrl; ?>/images/loading-smooth.gif') no-repeat scroll center center #FFF;
            opacity: 0.3;
            width: 130px;
            height: 130px;
            position: fixed;
            text-align: center;
            top: 28%;
            left: 45%;
            -moz-border-radius: 45px;
            border-radius: 45px;
            z-index: 9999;
        }
    </style>
</head>

<body>
    <div class="content" id="pilihan_uji">
        <div class="box"><img class="img" src="<?php echo Yii::app()->baseUrl; ?>/images/icon_retribusi_berkala.png" onclick="jenisUji('ub')" /></div>
        <div class="box"><img class="img" src="<?php echo Yii::app()->baseUrl; ?>/images/icon_retribusi_up.png" onclick="jenisUji('up')" /></div>
        <div class="box"><img class="img" src="<?php echo Yii::app()->baseUrl; ?>/images/icon_retribusi_mutasi.png" onclick="jenisUji('mm')" /></div>
        <div class="box"><img class="img" src="<?php echo Yii::app()->baseUrl; ?>/images/icon_retribusi_nu_color.png" onclick="jenisUji('nu')" /></div>
    </div>
    <!--
        * ===================
        * BERKALA, UJI PERTAMA, MUTASI MASUK
        * ===================
    -->
    <div class="container" id="form_daftar" style="display: none;">
        <div class="container__item">
            <form class="form">
                <input type="text" class="form__field" placeholder="Masukkan No Uji Kendaraan" id="input_no_uji" />
                <button type="button" class="btn btn--primary btn--inside uppercase" onclick="cekKendaraan()">CEK DATA KENDARAAN</button>
            </form>
        </div>
        <?php

        ?>
        <div class="card">
            <div style="padding: 2px 16px;">
                <center id="tidak_ada">&nbsp;</center>
                <br />
                <span style="font-size: 40px; line-height:2"><b id="judul">&nbsp;</b></span>
                <table>
                    <tr>
                        <td class="font-card" width="300px"><b>NO UJI</b></td>
                        <td class="font-card" width="15px">:</td>
                        <td class="font-card" id="no_uji">-</td>
                    </tr>
                    <tr>
                        <td class="font-card"><b>NO KENDARAAN</b></td>
                        <td class="font-card">:</td>
                        <td class="font-card" id="no_kendaraan">-</td>
                    </tr>
                    <tr>
                        <td class="font-card"><b>NAMA PEMILIK</b></td>
                        <td class="font-card">:</td>
                        <td class="font-card" id="nama_pemilik">-</td>
                    </tr>
                    <tr>
                        <td class="font-card"><b>ALAMAT</b></td>
                        <td class="font-card">:</td>
                        <td class="font-card" id="alamat_pemilik">-</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="noted">* Jika nomor kendaraan / nama pemilik BERUBAH, silakan ke LOKET</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>
        <div style="width: 50%;">
            <input type="hidden" id="id_kendaraan" value="0">
            <input type="hidden" id="jenis_uji" value="0">
            <button class="block batal" onclick="batal()">BATAL</button>
            <button class="block daftar" onclick="saveRetribusi()">DAFTAR</button>
        </div>
    </div>
    <div style="display: none;" id="overlay"></div>
    <div style="display: none;" id="popup"></div>
</body>
<script src="https://cdn.jsdelivr.net/npm/recta/dist/recta.js"></script>
<script>
    function showlargeloader() {
        $("#overlay").css('display', 'block');
        $("#popup").css('display', 'block');
        $("#popup").fadeIn(500);
    }

    function hidelargeloader() {
        $("#overlay").fadeOut(500);
        $("#popup").fadeOut(500);
    }


    function jenisUji(pilihan) {
        setTimeout(function() {
            $('#pilihan_uji').fadeOut();
        }, 500);
        let placeholder = "Masukkan No Uji Kendaraan";
        if (pilihan == 'ub') {
            $("#jenis_uji").val(1);
            $("#judul").text("UJI BERKALA");
        } else if (pilihan == 'up') {
            $("#jenis_uji").val(8);
            $("#judul").text("UJI PERTAMA");
            placeholder = "Masukkan Kode";
        } else if (pilihan == 'mm') {
            $("#jenis_uji").val(4);
            $("#judul").text("MUTASI MASUK");
        } else if (pilihan == 'nu') {
            $("#jenis_uji").val(2);
            $("#judul").text("NUMPANG UJI MASUK");
        }
        $("#input_no_uji").attr("placeholder", placeholder);
        $("#input_no_uji").focus();
        setTimeout(function() {
            $('#form_daftar').fadeIn();
        }, 1000);
    }

    function batal() {
        $("#input_no_uji").val('');
        $("#id_kendaraan").val(0);
        $("#no_uji").text('-');
        $("#no_kendaraan").text('-');
        $("#nama_pemilik").text('-');
        $("#alamat_pemilik").text('-');
        setTimeout(function() {
            $('#form_daftar').fadeOut();
        }, 500);
        setTimeout(function() {
            $('#pilihan_uji').fadeIn();
        }, 1000);
    }


    $(document).on("keypress", "#input_no_uji", function(e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            cekKendaraan();
            return false;
        }
    });

    function cekKendaraan() {
        var no_uji = $('#input_no_uji').val()
        $.ajax({
            url: '<?php echo $this->createUrl('selfservice/cekDataKendaraan'); ?>',
            type: 'POST',
            data: {
                no_sb: no_uji
            },
            dataType: 'JSON',
            beforeSend: function() {
                showlargeloader();
            },
            success: function(data) {
                hidelargeloader();
                if (data != 0) {
                    $('#tidak_ada').text('');
                    $("#id_kendaraan").val(data.id_kendaraan);
                    $("#no_uji").text(data.no_uji);
                    $("#no_kendaraan").text(data.no_kendaraan);
                    $("#nama_pemilik").text(data.nama_pemilik);
                    $("#alamat_pemilik").text(data.alamat_pemilik);
                } else {
                    $('#tidak_ada').text('Data tidak ditemukan');
                    $("#id_kendaraan").val(0);
                    $("#no_uji").text('-');
                    $("#no_kendaraan").text('-');
                    $("#nama_pemilik").text('-');
                    $("#alamat_pemilik").text('-');
                }
            },
            error: function(data) {
                hidelargeloader();
                return false;
            }
        });
    }

    function saveRetribusi() {
        var id_kendaraan = $('#id_kendaraan').val()
        var jenis_uji = $('#jenis_uji').val()
        $.ajax({
            url: '<?php echo $this->createUrl('selfservice/saveRetribusi'); ?>',
            type: 'POST',
            data: {
                id_kendaraan: id_kendaraan,
                jenis_uji: jenis_uji,
            },
            dataType: 'JSON',
            beforeSend: function() {
                showlargeloader();
            },
            success: function(data) {
                hidelargeloader();
                if (data.ada == 'true') {
                    printNota(data)
                    batal()
                } else {
                    $('#tidak_ada').text(data.message)
                }
            },
            error: function(data) {
                hidelargeloader();
                return false;
            }
        });
    }

    function printNota(data) {
        // 15042017040491
        var judul = $("#judul").text()
        var nouji = data.nouji;
        var nokendaraan = data.nokendaraan;
        var namapemilik = data.namapemilik;
        var alamatpemilik = data.alamatpemilik;
        var nomor = data.nomor;
        var tglretribusi = data.tglretribusi;
        var printer = new Recta('6747608510', '1811')
        printer.open().then(() => {
            printer.align('left')
                .mode(font = 'A', emphasized = false, doubleHeight = true, doubleWidth = true, underline = false)
                .text("  " + judul)
            printer.align('left')
                .mode(font = 'A', emphasized = false, doubleHeight = false, doubleWidth = false, underline = false)
                .text("    " + tglretribusi)
            printer.align('left')
                .mode(font = 'A', emphasized = false, doubleHeight = true, doubleWidth = true, underline = false)
                .text(" ")
                .text("  " + nouji)
                .text("  " + nokendaraan)
                .text("  " + namapemilik)
                .text("  " + alamatpemilik)
            printer.align('center')
                .text("  ---------------------")
                .text("  " + nomor)
                .text(" ")
                .text(" ")
                .text(" ")
                .text(" ")
                .text(" ")
            printer.cut(partial = true, linefeed = 3)
                .print()
        })
    }
</script>

</html>