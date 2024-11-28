<?php

/**
 * This is the model class for table "tbl_nama_penguji".
 *
 * The followings are the available columns in table 'tbl_nama_penguji':
 * @property string $kode_penguji
 * @property string $nama_penguji
 * @property string $id_nama_penguji
 * @property string $jabatan
 * @property string $nrp
 * @property boolean $stt_genap
 * @property boolean $stt_tl
 * @property boolean $stt_tdgenap
 * @property boolean $stt_up
 * @property boolean $stt_gasal
 * @property boolean $stt_tdgasal
 * @property boolean $stt_tdup
 * @property boolean $stt_tdtl
 * @property boolean $status_penguji
 */
class TblNamaPenguji extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function primaryKey() {
        return 'id_nama_penguji';
    }
    
    public function tableName() {
        return 'tbl_nama_penguji';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kode_penguji, jabatan, nrp', 'length', 'max' => 30),
            array('nama_penguji', 'length', 'max' => 120),
            array('stt_genap, stt_tl, stt_tdgenap, stt_up, stt_gasal, stt_tdgasal, stt_tdup, stt_tdtl, status_penguji', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('kode_penguji, nama_penguji, id_nama_penguji, jabatan, nrp, stt_genap, stt_tl, stt_tdgenap, stt_up, stt_gasal, stt_tdgasal, stt_tdup, stt_tdtl, status_penguji', 'safe', 'on' => 'search'),
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
            'kode_penguji' => 'Kode Penguji',
            'nama_penguji' => 'Nama Penguji',
            'id_nama_penguji' => 'Id Nama Penguji',
            'jabatan' => 'Jabatan',
            'nrp' => 'Nrp',
            'stt_genap' => 'Stt Genap',
            'stt_tl' => 'Stt Tl',
            'stt_tdgenap' => 'Stt Tdgenap',
            'stt_up' => 'Stt Up',
            'stt_gasal' => 'Stt Gasal',
            'stt_tdgasal' => 'Stt Tdgasal',
            'stt_tdup' => 'Stt Tdup',
            'stt_tdtl' => 'Stt Tdtl',
            'status_penguji' => 'Status Penguji',
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

        $criteria->compare('kode_penguji', $this->kode_penguji, true);
        $criteria->compare('nama_penguji', $this->nama_penguji, true);
        $criteria->compare('id_nama_penguji', $this->id_nama_penguji, true);
        $criteria->compare('jabatan', $this->jabatan, true);
        $criteria->compare('nrp', $this->nrp, true);
        $criteria->compare('stt_genap', $this->stt_genap);
        $criteria->compare('stt_tl', $this->stt_tl);
        $criteria->compare('stt_tdgenap', $this->stt_tdgenap);
        $criteria->compare('stt_up', $this->stt_up);
        $criteria->compare('stt_gasal', $this->stt_gasal);
        $criteria->compare('stt_tdgasal', $this->stt_tdgasal);
        $criteria->compare('stt_tdup', $this->stt_tdup);
        $criteria->compare('stt_tdtl', $this->stt_tdtl);
        $criteria->compare('status_penguji', $this->status_penguji);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TblNamaPenguji the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
