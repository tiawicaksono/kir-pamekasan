<?php

/**
 * This is the model class for table "v_daftar".
 *
 * The followings are the available columns in table 'v_daftar':
 * @property string $stts_daftar
 * @property string $no_berkas
 * @property string $tgl_uji
 * @property string $no_uji
 * @property string $no_chasis
 * @property string $no_mesin
 * @property string $no_kendaraan
 * @property string $nama_pemilik
 * @property string $id_kendaraan
 * @property string $id_daftar
 * @property string $id_uji
 * @property string $jenis
 * @property string $nm_komersil
 * @property string $karoseri_jenis
 * @property string $karoseri_bahan
 * @property string $karoseri_duduk
 * @property string $nampeng
 * @property string $idnoktp
 * @property string $nm_pengurus
 * @property string $nm_prus_jasa
 * @property string $id_retribusi
 */
class VDaftar extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'v_daftar';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('stts_daftar, no_uji, no_chasis, no_mesin, jenis, karoseri_jenis, karoseri_bahan, karoseri_duduk', 'length', 'max' => 30),
            array('no_kendaraan', 'length', 'max' => 12),
            array('nama_pemilik, nm_komersil, nampeng, nm_prus_jasa', 'length', 'max' => 100),
            array('nm_pengurus', 'length', 'max' => 50),
            array('no_berkas, tgl_uji, id_kendaraan, id_daftar, id_uji, idnoktp, id_retribusi', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('stts_daftar, no_berkas, tgl_uji, no_uji, no_chasis, no_mesin, no_kendaraan, nama_pemilik, id_kendaraan, id_daftar, id_uji, id_retribusi, jenis, nm_komersil, karoseri_jenis, karoseri_bahan, karoseri_duduk, nampeng, idnoktp, nm_pengurus, nm_prus_jasa', 'safe', 'on' => 'search'),
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
            'stts_daftar' => 'Stts Daftar',
            'no_berkas' => 'No Berkas',
            'tgl_uji' => 'Tgl Uji',
            'no_uji' => 'No Uji',
            'no_chasis' => 'No Chasis',
            'no_mesin' => 'No Mesin',
            'no_kendaraan' => 'No Kendaraan',
            'nama_pemilik' => 'Nama Pemilik',
            'id_kendaraan' => 'Id Kendaraan',
            'id_daftar' => 'Id Daftar',
            'id_uji' => 'Id Uji',
            'jenis' => 'Jenis',
            'nm_komersil' => 'Nm Komersil',
            'karoseri_jenis' => 'Karoseri Jenis',
            'karoseri_bahan' => 'Karoseri Bahan',
            'karoseri_duduk' => 'Karoseri Duduk',
            'nampeng' => 'Nampeng',
            'idnoktp' => 'Idnoktp',
            'nm_pengurus' => 'Nm Pengurus',
            'nm_prus_jasa' => 'Nm Prus Jasa',
            'id_retribusi' => 'Id Retribusi',
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

        $criteria->compare('stts_daftar', $this->stts_daftar, true);
        $criteria->compare('no_berkas', $this->no_berkas, true);
        $criteria->compare('tgl_uji', $this->tgl_uji, true);
        $criteria->compare('no_uji', $this->no_uji, true);
        $criteria->compare('no_chasis', $this->no_chasis, true);
        $criteria->compare('no_mesin', $this->no_mesin, true);
        $criteria->compare('no_kendaraan', $this->no_kendaraan, true);
        $criteria->compare('nama_pemilik', $this->nama_pemilik, true);
        $criteria->compare('id_kendaraan', $this->id_kendaraan, true);
        $criteria->compare('id_daftar', $this->id_daftar, true);
        $criteria->compare('id_uji', $this->id_uji, true);
        $criteria->compare('jenis', $this->jenis, true);
        $criteria->compare('nm_komersil', $this->nm_komersil, true);
        $criteria->compare('karoseri_jenis', $this->karoseri_jenis, true);
        $criteria->compare('karoseri_bahan', $this->karoseri_bahan, true);
        $criteria->compare('karoseri_duduk', $this->karoseri_duduk, true);
        $criteria->compare('nampeng', $this->nampeng, true);
        $criteria->compare('idnoktp', $this->idnoktp, true);
        $criteria->compare('nm_pengurus', $this->nm_pengurus, true);
        $criteria->compare('nm_prus_jasa', $this->nm_prus_jasa, true);
        $criteria->compare('id_retribusi', $this->id_retribusi, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return VDaftar the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
