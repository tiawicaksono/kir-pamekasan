<script type="text/javascript">
    $(document).ready(function () {
//        window.setInterval(function () {
//            getKelulusan();
//        }, 100000);

        function getKelulusan() {
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
                <span class="box-title bold" style="font-size: 36pt">DISPLAY HASIL PRAUJI</span>
            </div><!-- /.box-header -->
            <div class="box-body bg-black" style="width: 100%">
                <div class="col-lg-6 center">
                    <span id="no_uji" class="bold" style="font-size: 62pt;">SB XXXXXX K</span>
                    <br />
                    <span id="no_kendaraan" class="bold" style="font-size: 82pt;">L XXXX XX</span>
                </div>
                <div class="col-lg-6 center">
                    <span id="kelulusan" class="bold" style="font-size: 92pt;">TIDAK LULUS</span>
                </div>
                
                <div class="col-md-12 tengah">
                    <b style="font-size:15pt;">FOTO 6 BULAN LALU</b>
                </div>
                <div class="col-md-12" style="margin-bottom:20px;">
                    <div class="col-md-3 tengah">
                        <img id="img_depan" width="100%" height="200"/>
                    </div>
                    <div class="col-md-3 tengah">
                        <img id="img_belakang" width="100%" height="200"/>
                    </div>
                    <div class="col-md-3 tengah">
                        <img id="img_kanan" width="100%" height="200"/>
                    </div>
                    <div class="col-md-3 tengah">
                        <img id="img_kiri" width="100%" height="200"/>
                    </div>
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