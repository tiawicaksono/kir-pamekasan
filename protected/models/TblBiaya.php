<?php

/**
 * This is the model class for table "tbl_biaya".
 *
 * The followings are the available columns in table 'tbl_biaya':
 * @property integer $id_biaya
 * @property double $b_pertama
 * @property double $b_berkala
 * @property double $b_plat_uji
 * @property double $b_tnd_samping
 * @property double $b_buku
 * @property double $b_rekom
 * @property double $b_jbb_kurang
 * @property double $b_jbb_lebih
 */
class TblBiaya extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_biaya';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('b_pertama, b_berkala, b_plat_uji, b_tnd_samping, b_buku, b_rekom, b_jbb_kurang, b_jbb_lebih', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_biaya, b_pertama, b_berkala, b_plat_uji, b_tnd_samping, b_buku, b_rekom, b_jbb_kurang, b_jbb_lebih', 'safe', 'on'=>'search'),
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
			'id_biaya' => 'Id Biaya',
			'b_pertama' => 'B Pertama',
			'b_berkala' => 'B Berkala',
			'b_plat_uji' => 'B Plat Uji',
			'b_tnd_samping' => 'B Tnd Samping',
			'b_buku' => 'B Buku',
			'b_rekom' => 'B Rekom',
			'b_jbb_kurang' => 'B Jbb Kurang',
			'b_jbb_lebih' => 'B Jbb Lebih',
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

		$criteria->compare('id_biaya',$this->id_biaya);
		$criteria->compare('b_pertama',$this->b_pertama);
		$criteria->compare('b_berkala',$this->b_berkala);
		$criteria->compare('b_plat_uji',$this->b_plat_uji);
		$criteria->compare('b_tnd_samping',$this->b_tnd_samping);
		$criteria->compare('b_buku',$this->b_buku);
		$criteria->compare('b_rekom',$this->b_rekom);
		$criteria->compare('b_jbb_kurang',$this->b_jbb_kurang);
		$criteria->compare('b_jbb_lebih',$this->b_jbb_lebih);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblBiaya the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
