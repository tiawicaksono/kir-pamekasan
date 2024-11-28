<?php

/**
 * This is the model class for table "tbl_ikm".
 *
 * The followings are the available columns in table 'tbl_ikm':
 * @property string $id_ikm
 * @property string $tgl_ikm
 * @property string $no_kendaraan
 * @property string $jawaban
 */
class TblIkm extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_ikm';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tgl_ikm', 'safe'),
			array('sangat_puas, puas, tidak_puas', 'numerical', 'integerOnly' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_ikm, tgl_ikm, sangat_puas, puas, tidak_puas', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_ikm' => 'Id Ikm',
			'tgl_ikm' => 'Tgl Ikm',
			'sangat puas' => 'Sangat Puas',
			'puas' => 'Puas',
			'tidak puas' => 'Tidak Puas',
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

		$criteria = new CDbCriteria;

		$criteria->compare('id_ikm', $this->id_ikm, true);
		$criteria->compare('tgl_ikm', $this->tgl_ikm, true);
		$criteria->compare('sangat_puas', $this->sangat_puas, true);
		$criteria->compare('puas', $this->puas, true);
		$criteria->compare('tidak_puas', $this->tidak_puas, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblIkm the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
