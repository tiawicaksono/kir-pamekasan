<?php

/**
 * This is the model class for table "tbl_rekom1".
 *
 * The followings are the available columns in table 'tbl_rekom1':
 * @property string $id_kendaraan
 * @property string $tgl_rekom
 * @property string $pemilik_baru
 * @property string $alamat_baru
 * @property string $nik_baru
 * @property string $id_riwayat
 * @property string $id_retribusi
 * @property boolean $mutke
 * @property boolean $numke
 * @property boolean $ubhbentuk
 * @property boolean $ubhsifat
 * @property string $id_rekom
 * @property string $id_provinsi_mutke
 * @property string $id_kota_mutke
 * @property string $id_provinsi_numke
 * @property string $id_kota_numke
 * @property integer $no_surat_mutke
 * @property integer $no_surat_numke
 */
class TblRekom1 extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_rekom1';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no_surat_mutke, no_surat_numke', 'numerical', 'integerOnly'=>true),
			array('pemilik_baru', 'length', 'max'=>30),
			array('alamat_baru', 'length', 'max'=>100),
			array('nik_baru', 'length', 'max'=>20),
			array('id_provinsi_mutke, id_provinsi_numke', 'length', 'max'=>2),
			array('id_kota_mutke, id_kota_numke', 'length', 'max'=>4),
			array('id_kendaraan, tgl_rekom, id_riwayat, id_retribusi, mutke, numke, ubhbentuk, ubhsifat', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_kendaraan, tgl_rekom, pemilik_baru, alamat_baru, nik_baru, id_riwayat, id_retribusi, mutke, numke, ubhbentuk, ubhsifat, id_rekom, id_provinsi_mutke, id_kota_mutke, id_provinsi_numke, id_kota_numke, no_surat_mutke, no_surat_numke', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_kendaraan' => 'Id Kendaraan',
			'tgl_rekom' => 'Tgl Rekom',
			'pemilik_baru' => 'Pemilik Baru',
			'alamat_baru' => 'Alamat Baru',
			'nik_baru' => 'Nik Baru',
			'id_riwayat' => 'Id Riwayat',
			'id_retribusi' => 'Id Retribusi',
			'mutke' => 'Mutke',
			'numke' => 'Numke',
			'ubhbentuk' => 'Ubhbentuk',
			'ubhsifat' => 'Ubhsifat',
			'id_rekom' => 'Id Rekom',
			'id_provinsi_mutke' => 'Id Provinsi Mutke',
			'id_kota_mutke' => 'Id Kota Mutke',
			'id_provinsi_numke' => 'Id Provinsi Numke',
			'id_kota_numke' => 'Id Kota Numke',
			'no_surat_mutke' => 'No Surat Mutke',
			'no_surat_numke' => 'No Surat Numke',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_kendaraan',$this->id_kendaraan,true);
		$criteria->compare('tgl_rekom',$this->tgl_rekom,true);
		$criteria->compare('pemilik_baru',$this->pemilik_baru,true);
		$criteria->compare('alamat_baru',$this->alamat_baru,true);
		$criteria->compare('nik_baru',$this->nik_baru,true);
		$criteria->compare('id_riwayat',$this->id_riwayat,true);
		$criteria->compare('id_retribusi',$this->id_retribusi,true);
		$criteria->compare('mutke',$this->mutke);
		$criteria->compare('numke',$this->numke);
		$criteria->compare('ubhbentuk',$this->ubhbentuk);
		$criteria->compare('ubhsifat',$this->ubhsifat);
		$criteria->compare('id_rekom',$this->id_rekom,true);
		$criteria->compare('id_provinsi_mutke',$this->id_provinsi_mutke,true);
		$criteria->compare('id_kota_mutke',$this->id_kota_mutke,true);
		$criteria->compare('id_provinsi_numke',$this->id_provinsi_numke,true);
		$criteria->compare('id_kota_numke',$this->id_kota_numke,true);
		$criteria->compare('no_surat_mutke',$this->no_surat_mutke);
		$criteria->compare('no_surat_numke',$this->no_surat_numke);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblRekom1 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
