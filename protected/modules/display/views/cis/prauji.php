<script type="text/javascript">
    $(document).ready(function () {
        window.setInterval(function () {
            getKelulusanPrauji();
            getKelulusanEmisi();
        }, 1000);

        function getKelulusanPrauji() {
            var cis = $('#choose_proses').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('Prosesuji/GetKelulusanPrauji'); ?>',
                data: {cis: cis},
                dataType: "json",
                beforeSend: function () {
                },
                success: function (data) {
                    $('#no_uji').html(data.no_uji);
                    $('#no_kendaraan').html(data.no_kendaraan);
                    $('#kelulusan').html(data.kelulusan);
                    $('#list_kelulusan').html(data.list_kelulusan);
//                    $("#img_depan").attr('src','data:image/jpeg;base64,'+data.img_depan);
//                    $("#img_belakang").attr('src','data:image/jpeg;base64,'+data.img_belakang);
//                    $("#img_kanan").attr('src','data:image/jpeg;base64,'+data.img_kanan);
//                    $("#img_kiri").attr('src','data:image/jpeg;base64,'+data.img_kiri);
//                    if(data.nilai_kelulusan == 1){
//                        $('#keterangan_tl').hide();
//                    }else{
//                        $('#keterangan_tl').show();
//                        $('#list_kelulusan').html(data.list_kelulusan);
//                    }
                },
                error: function () {
                    return false;
                }
            });
        }

        function getKelulusanEmisi() {
            var cis = $('#choose_proses').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('Prosesuji/GetKelulusanEmisi'); ?>',
                data: {cis: cis},
                dataType: "json",
                beforeSend: function () {
                },
                success: function (data) {
                    $('#no_uji_emisi').html(data.no_uji);
                    $('#no_kendaraan_emisi').html(data.no_kendaraan);
                    $('#kelulusan_emisi').html(data.kelulusan);
                    $('#diesel').html(data.diesel);
                    $('#mesin_co').html(data.mesin_co);
                    $('#mesin_hc').html(data.mesin_hc);
                },
                error: function () {
                    return false;
                }
            });
        }
    });
</script>
<style>
    .bold{
        font-weight: bold;
    }
    .center{
        text-align: center;
        vertical-align: middle;
    }
</style>
<input type="hidden" id="choose_proses" value="Iyasaka">
<div class="row">
    <div class="col-lg-12" style="width: 100%">
        <div class="box box-info" style="padding: 0px; margin: 0px;">
            <div class="box-header with-border center bg-aqua">
                <div class="col-lg-6 center">
                    <span class="box-title bold" style="font-size: 36pt; color: #000;">DISPLAY HASIL EMISI</span>
                </div>
                <div class="col-lg-6 center">
                    <span class="box-title bold" style="font-size: 36pt; color: #000;">DISPLAY HASIL PRAUJI</span>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body bg-black" style="width: 100%">
                <!--EMISI-->
                <div class="col-lg-6 center">
                    <span id="no_uji_emisi" class="bold" style="font-size: 52pt;">SB XXXXXX K</span>
                    <br />
                    <span id="no_kendaraan_emisi" class="bold" style="font-size: 72pt;">L XXXX XX</span>
                    <br/>
                    <center><span id="kelulusan_emisi" class="bold" style="font-size: 82pt;">TIDAK LULUS</span></center>
                    
                    <div class="col-lg-12 center" style="padding:0px; margin:0px;">
                        <div class="col-lg-6">
                            <div class="col-lg-4" style="text-align:right">
                                <span class="bold" style="font-size: 24pt;">Diesel</span>
                            </div>
                            <div class="col-lg-4 center">
                                <span id="diesel" class="bold" style="font-size: 24pt; color: #eef442"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-lg-6">
                                <span class="bold" style="font-size: 24pt;">Mesin CO</span>
                                <br/>
                                <span class="bold" style="font-size: 24pt;">Mesin HC</span>
                            </div>
                            <div class="col-lg-6 center">
                                <span id="mesin_co" class="bold" style="font-size: 24pt; color: #eef442"></span>
                                <br/>
                                <span id="mesin_hc" class="bold" style="font-size: 24pt; color: #eef442"></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--PRAUJI-->
                <div class="col-lg-6 center">
                    <span id="no_uji" class="bold" style="font-size: 52pt;">SB XXXXXX K</span>
                    <br />
                    <span id="no_kendaraan" class="bold" style="font-size: 72pt;">L XXXX XX</span>
                    <br/>
                    <center><span id="kelulusan" class="bold" style="font-size: 82pt;">TIDAK LULUS</span></center>
                </div>
            </div>
        </div>
        <div id="keterangan_tl" class="box box-danger">
            <div class="box-header with-border center bg-red-active">
                <span class="box-title bold" style="font-size: 36pt">KETERANGAN TIDAK LULUS</span>
            </div><!-- /.box-header -->
            <div style="width: 100%; height: 100%;">
                <div class="col-lg-12" style="background-color: #FFF; height: 250px;">
                    <span id="list_kelulusan" style="font-size: 42pt; color:#000;">...</span>
                </div>
            </div>
        </div>
    </div>
</div>