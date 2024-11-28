<?php

/**
 * This is the model class for table "tbl_kendaraan".
 *
 * The followings are the available columns in table 'tbl_kendaraan':
 * @property string $no_uji
 * @property string $merk
 * @property string $tipe
 * @property string $tahun
 * @property string $jenis
 * @property string $awal_pakai
 * @property string $no_chasis
 * @property string $no_mesin
 * @property string $nama_pemilik
 * @property string $identitas
 * @property string $no_identitas
 * @property string $alamat
 * @property string $no_kendaraan
 * @property string $created
 * @property string $createdby
 * @property string $id_kendaraan
 * @property string $id_jns_kend
 * @property boolean $umum
 * @property string $kd_pemilik
 * @property string $tgl_mati_uji
 * @property boolean $cetak
 * @property string $tmp_lahir
 * @property string $tgl_lahir
 * @property string $kelamin
 * @property string $rt
 * @property string $rw
 * @property string $kelurahan
 * @property string $kecamatan
 * @property string $kota
 * @property string $propinsi
 * @property string $pengimport
 * @property string $no_telp
 * @property string $stts_kirim
 * @property boolean $kirim_1
 * @property boolean $kirim_2
 */
class TblKendaraan extends CActiveRecord {
    
    public $tgl_uji;
    public $mati_uji;
    public $nama_penguji;
    public $catatan;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_kendaraan';
    }
    
    public function primaryKey() {
        return array('no_uji');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('no_uji', 'required'),
            array('no_uji, merk, tipe, tahun, jenis, no_chasis, no_mesin, identitas, createdby, kd_pemilik, kelamin, rt, rw, stts_kirim', 'length', 'max' => 30),
            array('nama_pemilik, tmp_lahir, kelurahan, kecamatan, kota, propinsi, pengimport', 'length', 'max' => 100),
            array('no_identitas', 'length', 'max' => 60),
            array('alamat', 'length', 'max' => 200),
            array('no_kendaraan', 'length', 'max' => 12),
            array('created', 'length', 'max' => 20),
            array('awal_pakai, id_jns_kend, umum, tgl_mati_uji, cetak, tgl_lahir, no_telp, kirim_1, kirim_2', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('no_uji, merk, tipe, tahun, jenis, awal_pakai, no_chasis, no_mesin, nama_pemilik, identitas, no_identitas, alamat, no_kendaraan, created, createdby, id_kendaraan, id_jns_kend, umum, kd_pemilik, tgl_mati_uji, cetak, tmp_lahir, tgl_lahir, kelamin, rt, rw, kelurahan, kecamatan, kota, propinsi, pengimport, no_telp, stts_kirim, kirim_1, kirim_2', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'no_uji' => 'No Uji',
            'merk' => 'Merk',
            'tipe' => 'Tipe',
            'tahun' => 'Tahun',
            'jenis' => 'Jenis',
            'awal_pakai' => 'Awal Pakai',
            'no_chasis' => 'No Chasis',
            'no_mesin' => 'No Mesin',
            'nama_pemilik' => 'Nama Pemilik',
            'identitas' => 'Identitas',
            'no_identitas' => 'No Identitas',
            'alamat' => 'Alamat',
            'no_kendaraan' => 'No Kendaraan',
            'created' => 'Created',
            'createdby' => 'Createdby',
            'id_kendaraan' => 'Id Kendaraan',
            'id_jns_kend' => 'Id Jns Kend',
            'umum' => 'Umum',
            'kd_pemilik' => 'Kd Pemilik',
            'tgl_mati_uji' => 'Tgl Mati Uji',
            'cetak' => 'Cetak',
            'tmp_lahir' => 'Tmp Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'kelamin' => 'Kelamin',
            'rt' => 'Rt',
            'rw' => 'Rw',
            'kelurahan' => 'Kelurahan',
            'kecamatan' => 'Kecamatan',
            'kota' => 'Kota',
            'propinsi' => 'Propinsi',
            'pengimport' => 'Pengimport',
            'no_telp' => 'No Telp',
            'stts_kirim' => 'Stts Kirim',
            'kirim_1' => 'Kirim 1',
            'kirim_2' => 'Kirim 2',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('no_uji', $this->no_uji, true);
        $criteria->compare('merk', $this->merk, true);
        $criteria->compare('tipe', $this->tipe, true);
        $criteria->compare('tahun', $this->tahun, true);
        $criteria->compare('jenis', $this->jenis, true);
        $criteria->compare('awal_pakai', $this->awal_pakai, true);
        $criteria->compare('no_chasis', $this->no_chasis, true);
        $criteria->compare('no_mesin', $this->no_mesin, true);
        $criteria->compare('nama_pemilik', $this->nama_pemilik, true);
        $criteria->compare('identitas', $this->identitas, true);
        $criteria->compare('no_identitas', $this->no_identitas, true);
        $criteria->compare('alamat', $this->alamat, true);
        $criteria->compare('no_kendaraan', $this->no_kendaraan, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('createdby', $this->createdby, true);
        $criteria->compare('id_kendaraan', $this->id_kendaraan, true);
        $criteria->compare('id_jns_kend', $this->id_jns_kend, true);
        $criteria->compare('umum', $this->umum);
        $criteria->compare('kd_pemilik', $this->kd_pemilik, true);
        $criteria->compare('tgl_mati_uji', $this->tgl_mati_uji, true);
        $criteria->compare('cetak', $this->cetak);
        $criteria->compare('tmp_lahir', $this->tmp_lahir, true);
        $criteria->compare('tgl_lahir', $this->tgl_lahir, true);
        $criteria->compare('kelamin', $this->kelamin, true);
        $criteria->compare('rt', $this->rt, true);
        $criteria->compare('rw', $this->rw, true);
        $criteria->compare('kelurahan', $this->kelurahan, true);
        $criteria->compare('kecamatan', $this->kecamatan, true);
        $criteria->compare('kota', $this->kota, true);
        $criteria->compare('propinsi', $this->propinsi, true);
        $criteria->compare('pengimport', $this->pengimport, true);
        $criteria->compare('no_telp', $this->no_telp, true);
        $criteria->compare('stts_kirim', $this->stts_kirim, true);
        $criteria->compare('kirim_1', $this->kirim_1);
        $criteria->compare('kirim_2', $this->kirim_2);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TblKendaraan the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getRiwayatKendaraan($noUjiKendaraan) {
        $noUjiKendaraan = strtolower($noUjiKendaraan);
        $criteria = new CDbCriteria;
        $criteria->join = 'JOIN tbl_riwayat rwt USING(id_kendaraan)';
        $criteria->select = 'no_kendaraan,no_uji, to_char(rwt.tgl_uji, \'DD Month YYYY\') as tgl_uji, to_char(rwt.tgl_uji + INTERVAL \'6\' MONTH, \'DD Month YYYY\') as mati_uji, rwt.nama_penguji, rwt.catatan, no_chasis, no_mesin';
        $criteria->addCondition('LOWER(no_kendaraan) LIKE \'%'.$noUjiKendaraan.'%\' OR LOWER(no_uji) LIKE \'%'.$noUjiKendaraan.'%\'');
        return $criteria;
    }
    
    public function getDataKendaraan($noUjiKendaraan) {
        $noUjiKendaraan = strtolower($noUjiKendaraan);
        $criteria = new CDbCriteria;
//        $criteria->addCondition('LOWER(no_kendaraan) LIKE LOWER(\''.$noUjiKendaraan.'\') OR LOWER(no_uji) LIKE LOWER(\''.$noUjiKendaraan.'\')');
        $criteria->addCondition("(replace(LOWER(no_uji),' ','') like replace(LOWER('%".$noUjiKendaraan."%'),' ','') OR replace(LOWER(no_kendaraan),' ','') like replace(LOWER('".$noUjiKendaraan."'),' ',''))");
        $data = $this->find($criteria);
        return $data;
    }
}
