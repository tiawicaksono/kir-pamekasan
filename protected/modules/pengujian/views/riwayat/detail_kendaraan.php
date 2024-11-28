<div class="col-md-12 no-margin no-padding">
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">SERTIFIKASI</h3>
            </div>
            <div  class="box-body">
                <div class="col-md-12">
                    <label for="1">Nomor Sertifikat Registrasi Uji Tipe Kendaraan</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->no_regis; ?>">
                    <div class="col-md-7 no-margin no-padding">
                        <label for="2">Diterbitkan Oleh</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $data->oleh_regis; ?>">
                    </div>
                    <div class="col-md-1 no-margin no-padding"></div>
                    <div class="col-md-4 no-margin no-padding">
                        <label for="3">Tanggal Diterbitkan</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo date("d-M-Y", strtotime($data->tgl_regis)); ?>">
                    </div>
                    <label for="1">Nomor Sertifikat Uji Tipe Kendaraan</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->no_tipe; ?>">
                    <div class="col-md-7 no-margin no-padding">
                        <label for="2">Diterbitkan Oleh</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $data->dikeluarkan; ?>">
                    </div>
                    <div class="col-md-1 no-margin no-padding"></div>
                    <div class="col-md-4 no-margin no-padding">
                        <label for="3">Tanggal Diterbitkan</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo date("d-M-Y", strtotime($data->tgl_terbit)); ?>">
                    </div>
                    <label for="1">Nomor Sertifikat Rancang Bangun</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->no_rancang; ?>">
                    <div class="col-md-7 no-margin no-padding">
                        <label for="2">Diterbitkan Oleh</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $data->oleh_rancang; ?>">
                    </div>
                    <div class="col-md-1 no-margin no-padding"></div>
                    <div class="col-md-4 no-margin no-padding">
                        <label for="3">Tanggal Diterbitkan</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo date("d-M-Y", strtotime($data->tgl_rancang)); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 no-margin no-padding">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">DATA KENDARAAN</h3>
            </div>
            <div  class="box-body">
                <div class="col-md-4">
                    <label for="1">Nomor Uji</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->no_uji; ?>">
                    <label for="1">Nomor Kendaraan</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->no_kendaraan; ?>">
                    <div class="col-md-4 no-margin no-padding">
                        <label for="3">Identitas</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $data->identitas; ?>">
                    </div>
                    <div class="col-md-1 no-margin no-padding"></div>
                    <div class="col-md-7 no-margin no-padding">
                        <label for="2">Nomor</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $data->no_identitas; ?>">
                    </div>
                    <label for="1">Nama Pemilik</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->nama_pemilik; ?>">
                    <label for="1">Alamat Pemilik</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->alamat; ?>">
                    <label for="1">Tempat Lahir</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->tmp_lahir; ?>">
                </div>
                <div class="col-md-4">
                    <div class="col-md-7 no-margin no-padding">
                        <label for="2">Tanggal Lahir</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo date("d-M-Y", strtotime($data->tgl_lahir)); ?>">
                    </div>
                    <div class="col-md-1 no-margin no-padding"></div>
                    <div class="col-md-4 no-margin no-padding">
                        <label for="3">Kelamin</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $data->kelamin; ?>">
                    </div>
                    <div class="col-md-5 no-margin no-padding">
                        <label for="2">RT</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $data->rt; ?>">
                    </div>
                    <div class="col-md-1 no-margin no-padding"></div>
                    <div class="col-md-6 no-margin no-padding">
                        <label for="3">RW</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $data->rw; ?>">
                    </div>
                    <label for="3">Kelurahan</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->kelurahan; ?>">
                    <label for="3">Kecamatan</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->kecamatan; ?>">
                    <label for="3">Kota</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->kota; ?>">
                    <label for="3">Propinsi</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->propinsi; ?>">
                </div>
                <div class="col-md-4 no-padding">
                    <div class="col-md-7 no-margin no-padding">
                        <label for="2">Awal Pemakaian</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo date("d-M-Y", strtotime($data->awal_pakai)); ?>">
                    </div>
                    <div class="col-md-1 no-margin no-padding"></div>
                    <div class="col-md-4 no-margin no-padding">
                        <label for="3">Tahun</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $data->tahun; ?>">
                    </div>
                    <label for="3">Nomor Mesin</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->no_mesin; ?>">
                    <label for="3">Nomor Chasis</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->no_chasis; ?>">
                    <div class="col-md-5 no-margin no-padding">
                        <label for="2">Jenis</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $data->jenis; ?>">
                    </div>
                    <div class="col-md-1 no-margin no-padding"></div>
                    <div class="col-md-6 no-margin no-padding">
                        <label for="3">Status</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $data->umum; ?>">
                    </div>
                    <div class="col-md-5 no-margin no-padding">
                        <label for="2">Merk</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $data->merk; ?>">
                    </div>
                    <div class="col-md-1 no-margin no-padding"></div>
                    <div class="col-md-6 no-margin no-padding">
                        <label for="3">Tipe</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $data->tipe; ?>">
                    </div>
                    <label for="3">Pengimport / Pabrik</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $data->pengimport; ?>">
                </div>
            </div>
        </div>
    </div>
</div>